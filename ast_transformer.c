#define _GNU_SOURCE
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include "php_parser.tab.h"
#include "ast_transformer.h"
#include "my_main.h"
#include "file_structures.h"

char *ALL_PRINTS="prints";
const int PROTECT_CHARS=1;
extern int COLLECT_INFO;

int is_global_scope_untainted=1;
int is_everything_untainted=0; //make all functions/classes untainted
int is_partial_enabled;

//TODO: the correct solution requires stacks, but I haven't run into any cases yet
int is_assignment=0;
int is_language_construct=0;
int is_reference=0;
int exists_superglobal=0;
int is_tainted;
int is_tainted_cl=0; //classes are untainted by default
int is_method_declaration=0;
int has_user_prototypes=0;

/*Files that contain lists of php functions*/
char** functions_list = NULL;
int functions_count = 0;
char** functions_overriden_list = NULL;
int functions_overriden_count = 0;
char** functions_overriden_partial_list = NULL;
int functions_overriden_partial_count = 0;
char** functions_tainted_list = NULL;
int functions_tainted_count = 0;
char** classes_tainted_list = NULL;
int classes_tainted_count = 0;
astp functions_found;
prototype * functions_prototypes=NULL;
int functions_prototypes_count=0;
prototype * user_functions_prototypes=NULL;
int user_functions_prototypes_count=0;
prototype * user_methods_prototypes=NULL;
int user_methods_prototypes_count=0;
taint_category_list *taint_categories;

// this holds the name of the file where defined functions are logged.
char *prototypes_log_filename=NULL;
// this holds the name of the file where taints are defined.
char *taints_filename;
//this stores a list of the globals imported in an function
astp imported_globals=NULL;
//this stores the index of the current imported global for current function
int imported_globals_index=0;
//this holds the actual varnames of imported globals, noone will import more than 20...
char* globals_aliases[20];
//does the current function return by ref?
int returns_by_ref=0;

/*some headers needed locally*/
void edit_node_generic(FILE *, astp*, char *);
void untainted_edit_node_generic(FILE *, astp*, char *);
void dereference_aspis_from_parameter(astp *,int );
void ast_untainted_edit_bfs(FILE *, astp* );
void ast_edit_bfs(FILE *, astp* );

/*
 * Must be used only when partial taints are on.
 */
int is_tainted_function(char * f) {
    if (functions_tainted_list==NULL) return 1;
    int r= list_search(functions_tainted_list,0,functions_tainted_count,functions_tainted_count,f)!=-1;
    return r;
}
/*
 * Must be used only when partial taints are on.
 */
int is_tainted_class(char * f) {
    if (classes_tainted_list==NULL) return 1;
    int r= list_search(classes_tainted_list,0,classes_tainted_count,classes_tainted_count,f)!=-1;
    return r;
}
/*
 * given a T_VARIABLE, it looks for the last potetial method call
 * Ie. $var[0]->method() must return true
 */
int is_method_call(astp t) {
    if (t->total_parameters>0) {
        astp o=t->parameters[t->total_parameters-1];
        if (o->type==T_OBJECT_OPERATOR && o->parameters[0]->type==T_STRING_METHOD) return 1;
    }
    return 0;
}
/*
 * given a T_VARIABLE, it looks for the last potetial property (is it accessed thorugha variable?
 * Ie. $var[0]->$variable must return true
 */
int is_object_variable_property(astp t) {
    if (t->total_parameters>0) {
        astp o=t->parameters[t->total_parameters-1];
        if (o->type==T_OBJECT_OPERATOR && o->parameters[0]->type==T_VARIABLE) return 1;
    }
    return 0;
}
/*
 * As before, but do not claim the the protected object is rewritten
 */
void attach_aspis_notwritten(astp * tree) {
    astp n = ast_new(T_STRING, "false");
    astp a = ast_new_wparam(T_ARTIFICIAL, ",", n);
    astp s = ast_new_wparams(T_ARTIFICIAL, "(", *tree,a);
    astp t = ast_new_wparam(T_ARRAY_ASPIS, "array", s);
    n->rewritten=1;
    a->rewritten=1;
    s->rewritten=1;
    t->rewritten=1;
    *tree = t;
}
/**
 * This creates an Aspis Object around the expression passed
 * I.e. "hello world" will become new PHPAspisObject("hello world")
 */
void attach_aspis(astp * tree) {
    (*tree)->rewritten = 1;
    attach_aspis_notwritten(tree);
}
void attach_aspis_wwarning(astp * tree) {
    astp t=*tree;
    if (t->type==T_VARIABLE || t->type==T_STRING_FUNCTION) {
        astp s = ast_new_wparam(T_ARTIFICIAL, "(", *tree);
        astp t = ast_new_wparam(T_STRING_FUNCTION, "attAspisRCO", s);
        s->rewritten = 1;
        t->rewritten = 1;
        *tree = t;
    }
    else attach_aspis(tree);
}
/*
 * All objects returned from internal functions must be protected with AspisObjects
 */
void attach_aspis_to_internal_object(astp * tree) {
    (*tree)->rewritten = 1;
    astp p=ast_new_wparam(T_ARTIFICIAL,"(",*tree);
    astp c=ast_new_wparam(T_STRING_CLASSNAME,"AspisObject",p);
    astp n=ast_new_wparam(T_NEW,"new",c);
    attach_aspis_notwritten(&n);
    *tree=n;
}
/*
 * This calls attAspisWarningRC; makes sure that objects are protected with proxies
 */
void attach_aspis_to_parameter_wwarning(astp *tree,int param) {
    astp t = *tree;
    if (!t->rewritten) {
        attach_aspis_wwarning(&(t->parameters[param]));
        t->rewritten = 1;
    }
}
int is_in_dummy_list(char * fname) {
    return (strcmp(fname, "mysql_fetch_field") == 0 || strcmp(fname, "mysql_fetch_object") == 0
                || strcmp(fname, "odbc_fetch_object") == 0
                || strcmp(fname, "imap_bodystruct") == 0
                || strcmp(fname, "imap_check") == 0
                || strcmp(fname, "imap_fetchstructure") == 0
                || strcmp(fname, "imap_headerinfo") == 0
                || strcmp(fname, "imap_mailboxmsginfo") == 0
                || strcmp(fname, "imap_headerinfo") == 0
                || strcmp(fname, "imap_rfc822_parse_headers") == 0
                || strcmp(fname, "imap_status") == 0
                || strcmp(fname, "mssql_fetch_field") == 0
                || strcmp(fname, "mssql_fetch_object") == 0
                || strcmp(fname, "imap_status") == 0);

}
/*
 * used in the return value of a function, when type information is known
 */
void attach_aspis_wtype(astp * tree,char * type,char* fname) {
    (*tree)->rewritten = 1;
    if (is_object(type) && !is_in_dummy_list(fname)) {
        attach_aspis_to_internal_object(tree);
    }
    else if (is_scalar(type)) {
        astp p = ast_new_wparam(T_ARTIFICIAL, "(", *tree);
        *tree = ast_new_wparam(T_STRING_FUNCTION, "attAspis", p);
        p->rewritten = 1;
        (*tree)->rewritten = 1;
    }
    else if (is_void(type)) {
        //ignore , no need to attach aspis
    }
    else {
        astp s;
        //these return objects that must have their fields protected
        if (is_in_dummy_list(fname)) {
            char *name = strcat_malloc("\"", fname);
            name = strcat_malloc(name, "\"");
            astp f = ast_new(T_STRING_VARNAME, name);
            astp c = ast_new_wparam(T_ARTIFICIAL, ",", f);
            s = ast_new_wparams(T_ARTIFICIAL, "(", *tree, c);
            c->rewritten = 1;
            f->rewritten = 1;
        }
        else if (strcmp(fname,"func_get_args")==0 || strcmp(fname,"compact")==0) {
            attach_aspis(tree);
            return;
        }
        else if (strcmp(fname,"func_get_arg")==0) {
            //the arg has already an Aspis/
            return;
        }
        else s = ast_new_wparam(T_ARTIFICIAL, "(", *tree);
        astp t = ast_new_wparam(T_STRING_FUNCTION, "attAspisRC", s);
        s->rewritten = 1;
        t->rewritten = 1;
        *tree = t;
    }
}
void attach_aspis_wwarning_wtype(astp * tree,char * type) {
    (*tree)->rewritten = 1;
    if (!is_ref(type)) {
        attach_aspis_wwarning(tree);
    }
    else  {
        astp p = ast_new_wparam(T_ARTIFICIAL, "(", *tree);
        *tree = ast_new_wparam(T_STRING_FUNCTION, "attAspisRO", p);
        p->rewritten = 1;
        (*tree)->rewritten = 1;
    }
}
/**
 * This creates a call to e() around the expression passed
 */
void attach_e(astp * tree) {
    (*tree)->rewritten = 1;
    astp s = ast_new_wparam(T_ARTIFICIAL, "(", *tree);
    astp t = ast_new_wparam(T_STRING, "e", s);
    *tree = t;
    s->rewritten=1;
    t->rewritten=1;
}
void dereference_aspis_nofunction(astp* tree) {
    astp p = ast_new(T_DNUMBER, "0");
    astp q = ast_new_wparam(T_ARTIFICIAL, "[", p);
    q->not_array = 1;
    ast_add_parameter(*tree, q);
    p->rewritten = 1;
    q->rewritten = 1;
}
/**
 * This adds code to the provided tree that accesses the protected from the Aspsis object
 * I.e. $x['a'] should become $x['a']->obj;
 * */
void dereference_aspis(astp* tree) {
    astp t=*tree;
    if (t->type==T_NULL && t->total_parameters==1) t=t->parameters[0];
    if ( (t->type == T_VARIABLE && !is_method_call(t) && !is_object_variable_property(t))
            || t->type == T_STRING_OBJECTPAR
            || t->type==T_DOLLAR_OPEN_CURLY_BRACES) {
        if (strcmp(t->text,"$this")==0 && t->total_parameters==0)
            return;//$this should not be dereferenced
        //just take the first element

        int param=t->total_parameters-1;
        if (!is_online) {
            if (param>=0) printf("DEREF (%s): %d-%s\n",t->text,t->parameters[param]->type,t->parameters[param]->text);
            else printf("DEREF (%s): no params\n",t->text);
        }
        if (COLLECT_INFO) {
            if (param >= 0 && t->parameters[param]->type == T_OBJECT_OPERATOR)
                dereference_aspis_nofunction(tree);
            else {

                astp s = ast_new_wparam(T_ARTIFICIAL, "(", *tree);
                astp t = ast_new_wparam(T_STRING_FUNCTION, "deAspis", s);
                s->rewritten = 1;
                t->rewritten = 1;
                *tree = t;
            }
        }
        else dereference_aspis_nofunction(tree);
    }
    else {
        //use deAspis() and always guarantee that position is the first element
        astp s = ast_new_wparam(T_ARTIFICIAL, "(", *tree);
        astp t = ast_new_wparam(T_STRING_FUNCTION, "deAspis", s);
        s->rewritten = 1;
        t->rewritten = 1;
        *tree = t;
    }
}
/*
 * This version is for typed (prototypes are used) builtin function parameters
 */
void dereference_aspis_wtype(astp* tree,char * type) {
    astp t=*tree;
    if (t->text!=NULL && strcmp(t->text,"$this")==0  && t->total_parameters==0)
            return;//$this should not be dereferenced
    if (is_scalar(type)) dereference_aspis(tree);
    else {
        //use deAspisRC()
        astp s = ast_new_wparam(T_ARTIFICIAL, "(", *tree);
        astp t = ast_new_wparam(T_STRING_FUNCTION, "deAspisRC", s);
        s->rewritten = 1;
        t->rewritten = 1;
        *tree = t;
    }
}
/*
 * This version is for untainted user functions, called from tainted contexts.
 */
void dereference_aspis_wwarning(astp* tree) {
    astp t = *tree;
    if (t->text != NULL && strcmp(t->text, "$this") == 0 && t->total_parameters == 0)
        return; //$this should not be dereferenced
    astp s = ast_new_wparam(T_ARTIFICIAL, "(", *tree);
    t = ast_new_wparam(T_STRING_FUNCTION, "deAspisWarningRC", s);
    s->rewritten = 1;
    t->rewritten = 1;
    *tree = t;
}
void dereference_aspis_wwarning_wtype(astp * tree,char * type) {
    (*tree)->rewritten = 1;
    if (!is_ref(type)) {
        dereference_aspis_wwarning(tree);
    }
    else  {
        astp p = ast_new_wparam(T_ARTIFICIAL, "(", *tree);
        *tree = ast_new_wparam(T_STRING_FUNCTION, "deAspisRO", p);
        p->rewritten = 1;
        (*tree)->rewritten = 1;
    }
}
/*
 * Force dereference_aspis to use deAspis().
 */
void dereference_aspis_wfunction(astp* tree){
    astp temp=ast_new_wparam(T_NULL,NULL,*tree);
    dereference_aspis(&temp);
    *tree=temp;
}
/*
 * If/while statements must remove the aspsis form the boolean expression
 * */
void dereference_aspis_from_parameter(astp *tree,int param) {
    astp t = *tree;
    if (!t->rewritten) {
        dereference_aspis(&(t->parameters[param]));
        t->rewritten = 1;
    }
}
void dereference_aspis_from_parameter_wwarning(astp *tree,int param) {
    astp t = *tree;
    if (!t->rewritten) {
        dereference_aspis_wwarning(&(t->parameters[param]));
        t->rewritten = 1;
    }
}
void dereference_aspis_from_parameter_nofunction(astp *tree,int param) {
    if (!COLLECT_INFO) {
        dereference_aspis_from_parameter(tree,param);
        return;
    }
    astp t = *tree;
    if (!t->rewritten) {
        dereference_aspis_nofunction(&(t->parameters[param]));
        t->rewritten = 1;
    }
}
/**
 * Attached an Aspis around numbers
 * */
void rewrite_number(astp * tree) {
    if (!(*tree)->rewritten) {
        attach_aspis(tree);
    }
}
/**
 * Rewrites the concatenation operator . to the concat method of PHPAspis Objects
 * Example: $hello.$dear will become concat($hello,$dear) (used to be $hello->concat($dear))
 */
void rewrite_concat(astp * tree) {
    //printf("Concat: [%s,%s]\n",(*tree)->parameters[0]->text,(*tree)->parameters[1]->text);
    astp left = (*tree)->parameters[0];
    astp right = (*tree)->parameters[1];
    if (left != NULL && right != NULL) {
        astp q = ast_new_wparam(T_ARTIFICIAL, ",", right);
        astp p = ast_new_wparams(T_ARTIFICIAL, "(", left,q);
        astp c = ast_new_wparam(T_STRING_FUNCTION, "concat", p);
        q->rewritten=1;
        p->rewritten=1;
        c->rewritten=1;
        int i = 0;
        for (i = 2; i < ((*tree)->total_parameters); i++) ast_add_parameter(c, (*tree)->parameters[i]);
        //free(*tree);
        //create a dummy node that only has a param the single next child.
        //This way bfs with go on with the next child and will not think that
        //the new child is already checked
        astp d = ast_new_wparam(TA_IGNORE, "", c);
        *tree = d;
    } else die("rewrite_concat met an operator without two arguments");
}
int is_nonexpanding(int t) {
    if (t == T_NUM_STRING || t == T_ENCAPSED_AND_WHITESPACE ||
            t == T_STRING || t == T_CHARACTER || t == T_BAD_CHARACTER)
        return 1;
    else return 0;
}
/*
 * In a string like "Hi: $a[$i]", eveything inside [] must be embedded in the
 * precessing variable. Without this, it was considered part of the next string
 * and was separated form the variable.
 * */
astp ingore_arrays(astp* cur, int lasttoken_wasstring ){
    astp t=*cur;
    astp prev=NULL;
    if (!lasttoken_wasstring && is_nonexpanding(t->type) && strcmp(t->text,"[")==0) {
        //while !found, where everything after ! is the stop condition "the ] is found"
        while (!(strcmp(t->text,"]")==0 &&
                (t->total_parameters==0 ||
                (t->total_parameters>0 &&
                (t->parameters[0]->type!=T_STRING ||
                strcmp(t->parameters[0]->text,"[")!=0))))) {
            if (t->type==T_STRING && strcmp(t->text,"[")==0) {
                t->type=T_ARTIFICIAL;
                t->text=strcpy_malloc("[");
            }
            else if (t->type==T_STRING && strcmp(t->text,"]")==0 && prev!=NULL) {
                if (t->total_parameters>0) prev->parameters[0]=t->parameters[0];
                else ast_remove_parameter(prev,0);
            }
            prev=t;
            t=t->parameters[0];
        }
        if (strcmp(t->text,"]")==0) {
            if (t->total_parameters>0) prev->parameters[0]=t->parameters[0];
            else ast_remove_parameter(prev,0);
            if (t->total_parameters>0) *cur=t->parameters[0];
            else *cur=NULL;
        }
        else die("ERROR in ingore_arrays: the string ended before the [] closed");
    }
    return prev;
}
/**
 * Takes a string with variables that should be expanded and creates a new version
 * with the variables removed from the string and concatenated with the constant parts
 * I.e. "Hello $dear" will become new PhpAspis("Hello ").concat($dear);
 */
void rewrite_expanding_string(astp * tree) { 
    astp result = NULL; //where the new tree starts
    astp result_last = NULL; //where the new subtree must be added
    astp cur = ((*tree)->parameters[0]); //first element after "
    astp prev = *tree;
    astp original_start = cur;

    char * tmp_str = NULL;
    astp tmp_lastp = NULL;
    astp temp_p;
    int thistoken_issstring;
    int lasttoken_wasstring = is_nonexpanding(cur->type);
    int token_change = 0;
    int lastrun = 0;
    int consecutive_vars=0;
    int run=0;

    while (cur != NULL || lastrun) {
        astp prev_original=prev;
        if ((temp_p=ingore_arrays(&cur, lasttoken_wasstring))!=NULL) {
            prev=temp_p;
        };
        if (cur==NULL) {
            lastrun=1; //due to an ingored array
            cur = ast_new(T_ARTIFICIAL, "\"");
        }
        thistoken_issstring = is_nonexpanding(cur->type);
        token_change =  (thistoken_issstring != lasttoken_wasstring);
        consecutive_vars= (run++ &&
                prev_original->type==T_VARIABLE && cur->type==T_VARIABLE
                && !lastrun);
        //printf("TOKEN: (%d) %s\nthis:%d---last:%d---cons:%d\n",cur->type,cur->text,thistoken_issstring,lasttoken_wasstring,consecutive_vars);
        if (thistoken_issstring) tmp_str = strcat_malloc(tmp_str, cur->text);
        if (token_change || consecutive_vars || lastrun) {
            if (lasttoken_wasstring) {
                original_start = cur; //now an expanding part starts
                tmp_str = strcat_malloc("\"", tmp_str);
                tmp_str = strcat_malloc(tmp_str, "\"");
                astp n = ast_new(T_CONSTANT_ENCAPSED_STRING, tmp_str);
                attach_aspis(&n);
                n->rewritten=1;
                if (result == NULL) {
                    result = n;
                    result_last = n; //maybe s
                } else {
                    astp q = ast_new_wparam(T_ARTIFICIAL, ",", n);
                    //ast_add_parameter(result_last,q); //CHANGED THIS
                    astp p = ast_new_wparams(T_ARTIFICIAL, "(", result_last,q);
                    astp c = ast_new_wparam(T_STRING_FUNCTION, "concat", p);
                    result_last=c;
                    result=c;
                    q->rewritten=1;
                    p->rewritten=1;
                    c->rewritten=1;
                }
                tmp_str = NULL;
            } else {
                ast_remove_parameter(prev, (prev->total_parameters) - 1); //from the existing tree
                if (original_start->type==T_CURLY_OPEN) {
                    //Complex syntax for variables is not acceptable outside the string
                    original_start=original_start->parameters[0];
                }
                else if (original_start->type==T_DOLLAR_OPEN_CURLY_BRACES) {
                    astp p = ast_new_wparam(T_ARTIFICIAL, "$", original_start->parameters[0]);
                    original_start=p;
                }
                if (result == NULL) {
                    result = ast_new_wparam(T_NULL,NULL,original_start);
                    result_last = result;
                } else {
                    astp q = ast_new_wparam(T_ARTIFICIAL, ",", original_start);
                    //ast_add_parameter(result_last,q); //CHANGED THIS
                    astp p = ast_new_wparams(T_ARTIFICIAL, "(", result_last,q);
                    astp c = ast_new_wparam(T_STRING_FUNCTION, "concat", p);
                    result_last=c;
                    result=c;
                    q->rewritten=1;
                    p->rewritten=1;
                    c->rewritten=1;
                }
                if (consecutive_vars) original_start = cur; //now another expanding part starts
            }
            token_change = 0;
            lasttoken_wasstring = thistoken_issstring;
        }
        prev = cur;
        if ((cur->total_parameters) > 0) cur = cur->parameters[cur->total_parameters - 1];
        else if (lastrun) {
            lastrun = 0;
            cur = NULL;
        } else {
            cur = ast_new(T_ARTIFICIAL, "\""); //fake one, contents should be ingored
            lastrun = 1; //allow an extra final run to take care of the last element
        }
    }
    //Now replace the original tree with the new but make sure that subsequent parameters
    //attached after the first " node are preserved (ie echo "hell $hi","hello")
    astp next=NULL;
    if ((*tree)->total_parameters>1) {
        int i;
        for (i=1 ; i<(*tree)->total_parameters ; i++) {
            ast_add_parameter(result,(*tree)->parameters[i]);
        }
    }
    *tree = result;
    //ast_print_bfs(stdout,*tree);
    //printf("\n");
}
/**
 * Parses and rewrites heredocs to propagate Aspis objects
 */
void rewrite_heredoc(astp * tree) {
    if (!is_online) printf("REWRITE HEREDOC %s",(*tree)->text);
    astp result = NULL; //where the new tree starts
    astp result_last = NULL; //where the new subtree must be added
    astp cur = ((*tree)->parameters[0]); //first element after START_HEREDOC
    astp prev = *tree;
    astp original_start = cur;

    char *heredoc_name = strcpy_malloc(&(((*tree)->text)[3])); //skip the initial <<<
    heredoc_name[strlen(heredoc_name) - 1] = '\0'; //kill the last \n
    int heredoc_offset = 0; //each subheredoc will be named after this index
    char * tmp_str = NULL;
    astp tmp_lastp = NULL;

    int thistoken_issstring;
    int lasttoken_wasstring = is_nonexpanding(cur->type);
    int token_change = 0;
    int consecutive_vars=0;
    int run=0;

    while (cur != NULL) {
        thistoken_issstring = is_nonexpanding(cur->type);
        token_change = (thistoken_issstring != lasttoken_wasstring);
        consecutive_vars= (run++ && prev->type==T_VARIABLE && cur->type==T_VARIABLE);
        if (thistoken_issstring) tmp_str = strcat_malloc(tmp_str, cur->text);
        if (token_change || cur->type == T_END_HEREDOC || consecutive_vars) {
            if (lasttoken_wasstring ) {
                original_start = cur; //now an expanding part starts
                original_start->rewritten = 1;

                //create the new tag
                char * heredoc_new_end = NULL;
                char * heredoc_new_start = NULL;

                if (cur->type != T_END_HEREDOC){
                    //in the average case, add a \n before the closing label
                    asprintf(&heredoc_new_end, "\n%s_PHPAspis_Part%d", heredoc_name, heredoc_offset);
                }
                else if (strcmp(tmp_str,"\n")!=0) {
                    //the last element doesn't need a \n, it's there in the first place
                    asprintf(&heredoc_new_end, "%s_PHPAspis_Part%d", heredoc_name, heredoc_offset);
                }
                else {
                    //But if there is just a \n caracter after the last variable,
                    //then the variable terminates the heredoc so we are done!
                    break;
                }
                asprintf(&heredoc_new_start, "<<<%s_PHPAspis_Part%d\n", heredoc_name, heredoc_offset);
                heredoc_offset++;

                //create the corresponding ast
                astp e = ast_new(T_END_HEREDOC, heredoc_new_end);
                e->rewritten=1;
                astp c = ast_new_wparam(T_STRING, tmp_str, e);
                c->rewritten=1;
                astp n = ast_new_wparam(T_START_HEREDOC, heredoc_new_start, c);
                n->rewritten = 1;

                attach_aspis(&n);
                if (result == NULL) {
                    result = n;
                    result_last = n; //maybe s
                } else {
                    astp q = ast_new_wparam(T_ARTIFICIAL, ",", n);
                    //ast_add_parameter(result_last,q);
                    astp p = ast_new_wparams(T_ARTIFICIAL, "(", result_last,q);
                    astp c = ast_new_wparam(T_STRING_FUNCTION, "concat", p);
                    result_last=c;
                    result=c;
                    q->rewritten=1;
                    p->rewritten=1;
                    c->rewritten=1;
                }
                tmp_str = NULL;
            } else {
                ast_remove_parameter(prev, (prev->total_parameters) - 1); //from the existing tree
                if (original_start->type==T_CURLY_OPEN) {
                    //Complex syntax for variables is not acceptable outside the string
                    original_start=original_start->parameters[0];
                    original_start->rewritten = 1;
                }
                else if (original_start->type==T_DOLLAR_OPEN_CURLY_BRACES) {
                    astp p = ast_new_wparam(T_ARTIFICIAL, "$", original_start->parameters[0]);
                    p->rewritten = 1;
                    original_start=p;
                }
                if (result == NULL) {
                    result = ast_new_wparam(T_NULL,NULL,original_start);
                    result_last = result;
                } else {
                    astp q = ast_new_wparam(T_ARTIFICIAL, ",", original_start);
                    //ast_add_parameter(result_last,q);
                    astp p = ast_new_wparams(T_ARTIFICIAL, "(", result_last,q);
                    astp c = ast_new_wparam(T_STRING_FUNCTION, "concat", p);
                    result_last=c;
                    result=c;
                    q->rewritten=1;
                    p->rewritten=1;
                    c->rewritten=1;
                }
                if (consecutive_vars) original_start = cur; //now another expanding part starts
            }
            token_change = 0;
            lasttoken_wasstring = thistoken_issstring;
        }
        prev = cur;
        cur = cur->parameters[cur->total_parameters - 1];
    }
    //Now replace the original tree with the new but make sure that subsequent parameters
    //attached after the first " node are preserved (ie echo "hell $hi","hello")
    astp next=NULL;
    if ((*tree)->total_parameters>1) {
        int i;
        result->rewritten=1;
        for (i=1 ; i<(*tree)->total_parameters ; i++) {
            ast_add_parameter(result,(*tree)->parameters[i]);
            (*tree)->parameters[i]->rewritten=1;
        }
    }
    *tree = result;
}
/**
 * Rewrites "$var1 X= $var2" expressions as "$var1=$var1 X $var2";
 * */
void rewrite_xequals(astp * tree, int newtype, const char * newname) {
    int i=0;

    astp nequals=ast_new(T_ARTIFICIAL,"=");
    ast_add_parameter(nequals,(*tree)->parameters[0]); //left side of equals

    //now let's copy the left operand to the right side. I need a new astp, copy of the old
    astp left_copy=ast_copy((*tree)->parameters[0]);
    astp nright;
    astp nrest=(*tree)->parameters[1];
    if (strcmp(newname,"+")==0 || strcmp(newname,"*")==0)
        //carefull, first evaluate the old right hand side and then attach the old left
        nright=ast_new_wparams(newtype,newname,nrest,left_copy);
        //this translates to the order of params above and not the opposite!
    else nright=ast_new_wparams(newtype,newname,left_copy,nrest);

    ast_add_parameter(nequals,nright);
    //but don't forget the parameters of the original X=
    for (i=2;i<(*tree)->total_parameters;i++) {
        ast_add_parameter(nequals,(*tree)->parameters[i]);
    }
    for (i=0;i<(*tree)->total_children;i++) {
        ast_add_child(nequals,(*tree)->children[i]);
    }

    //create a dummy node so that no backtracking is required while editing
    astp dummy=ast_new_wparam(TA_IGNORE,"",nequals);
    *tree=dummy;
    if (!is_online) {
        printf("after xequals:\n");
        ast_print_bfs(stdout, *tree);
        printf("\n");
    }

}
/*
 * Rewrites ++ and --.
 * I.e. $x++ should become $x->postinc() and ++$x should become $x->preincr()
 * These methods return either the existing(pre) or new Aspsis objects(post)
 * */
void rewrite_xcrement(astp* tree) {
    astp t=*tree;
    if (!t->rewritten) {
        *tree = t->parameters[0]; //just killed the operator
        astp p = ast_new_wparam(T_ARTIFICIAL, "(", *tree);
        astp c;
        if (strcmp(t->text, "B") == 0) {
            if (t->type == T_INC) c = ast_new_wparam(T_STRING_FUNCTION, "preincr", p);
            else c = ast_new_wparam(T_STRING_FUNCTION, "predecr", p);
        } else {
            if (t->type == T_INC) c = ast_new_wparam(T_STRING, "postincr", p);
            else c = ast_new_wparam(T_STRING, "postdecr", p);
        }
        c->rewritten = 1;
        *tree = c;
        int i = 0;
        for (i = 1; i < t->total_parameters; i++) {
            ast_add_parameter(c, t->parameters[i]);
        }
        for (i = 0; i < t->total_children; i++) {
            ast_add_child(c, t->children[i]);
        }
    }
}
/*
 * Rewrites a unary operator by calling a method on the operand
 * */
void rewrite_unary_operator(astp* tree,char* method) {
    astp t=*tree;
    if (!t->rewritten) {
        *tree = t->parameters[0]; //just killed the operator
        astp p = ast_new_wparam(T_ARTIFICIAL, "(",*tree);
        astp c = ast_new_wparam(T_STRING_FUNCTION, method, p);
        *tree=c;
        int i = 0;
        for (i = 1; i < t->total_parameters; i++) {
            ast_add_parameter(c, t->parameters[i]);
        }
        for (i = 0; i < t->total_children; i++) {
            ast_add_child(c, t->children[i]);
        }
    }
}
void rewrite_globalvar_write(astp tree) {
}
void rewrite_globalvar_read(astp tree) {

}
/**
 * The math operators +-/* and logical operators && ||
 *  first dereference their arguments and then produce a new Aspis that
 * protects their result
 * */
void rewrite_binary_operator(astp * tree) {
    if (!(*tree)->rewritten && (*tree)->total_parameters>=2 ) {
            dereference_aspis(&(*tree)->parameters[0]);
            dereference_aspis(&(*tree)->parameters[1]);
            attach_aspis(tree);
    }
}
/*
 * For the time being, it only attaches Aspis to true/false
 * */
void rewrite_string(astp * tree) {
    astp t=*tree;
    if (!t->rewritten) {
        //if (strcasecmp(t->text,"true")==0 || strcasecmp(t->text,"false")==0) {
            attach_aspis(tree);
            t->rewritten=1;
        //}
    }
}
/*
 * The ? operator must dereference the first boolean expression and then
 * attacha fake e() function to the result, so that it is a valid Aspis Object
 * I.e. $xb?$x1:$x2 must become e($xb->object?$x1:$x2)
 * */
void rewrite_qmark_operator(astp * tree) {
    astp t=*tree;
    if (!t->rewritten) {
        dereference_aspis(&t->parameters[0]);
        t->rewritten=1;
    }
}
/*
 *
 * */
void rewrite_casts(astp *tree) {
    astp t=*tree;
    astp p = ast_new_wparam(T_ARTIFICIAL, "(",t->parameters[0]);
    astp s=NULL;
    switch (t->type) {
        case T_STRING_CAST:
            s=ast_new_wparam(T_STRING_FUNCTION,"string_cast",p);
            break;
        case T_INT_CAST:
            s=ast_new_wparam(T_STRING_FUNCTION,"int_cast",p);
            break;
        case T_BOOL_CAST:
            s=ast_new_wparam(T_STRING_FUNCTION,"bool_cast",p);
            break;
        case T_DOUBLE_CAST:
            s=ast_new_wparam(T_STRING_FUNCTION,"float_cast",p);
            break;
        case T_ARRAY_CAST:
            s=ast_new_wparam(T_STRING_FUNCTION,"array_cast",p);
            break;
        case T_UNSET_CAST:
            s=ast_new_wparam(T_STRING_FUNCTION,"unset_cast",p);
            break;
        case T_OBJECT_CAST:
            s=ast_new_wparam(T_STRING_FUNCTION,"object_cast",p);
            break;
    }
    p->rewritten=1;
    s->rewritten=1;
    *tree=s;
    int i=0;
    for (i=1;i<t->total_parameters;t++) {
        ast_add_parameter(s,t->parameters[i]);
    }
    i=0;
    for (i=0;i<t->total_children;t++) {
        ast_add_child(s,t->children[i]);
    }
}
/*
 * Helper function for rewrite_assignement(). It stores in mark1 and mark2
 * the places under cur that have the last two '[' characters in the output string
 * mark2 is the last, mark1 is the second-to-last
 */
void find_array_last_paren(astp cur, astp *mark1) {
    astp mark1r=NULL;
    if (cur==NULL ) return;
    if ( (cur->type == T_ARTIFICIAL && strcmp(cur->text, "[") == 0) || cur->type == T_FIRST_BRACKET) {
        mark1r = cur;
    }
    int i=0;
    for (i=0;i<cur->total_parameters;i++) {
        astp mark1t=NULL;
        find_array_last_paren(cur->parameters[i],&mark1t);
        if (mark1t!=NULL) {
            mark1r=mark1t;
        }
    }
    *mark1=mark1r;
}
void find_array_prelast_paren(astp cur, astp *mark1) {
    astp mark1r=NULL;
    if (cur==NULL ) return;
    if ( (cur->type == T_ARTIFICIAL && strcmp(cur->text, "[") == 0) || cur->type == T_FIRST_BRACKET) {
        mark1r = cur;
    }
    int i=0;
    astp temp=mark1r;
    for (i=0;i<cur->total_parameters;i++) {
        astp mark1t=NULL;
        find_array_prelast_paren(cur->parameters[i],&mark1t);
        if (mark1t!=NULL && mark1r==NULL) {
            temp=mark1t;
        }
    }
    mark1r=temp;
    *mark1=mark1r;
}
/*
 * Checks if the operand is an element of an array. To do so, the last [] pair
 * must not be enclosed in anything.
 */
int is_array_operand(astp t){
    if (t==NULL) return 0;
    if (t->type==T_NOT_ARRAY || t->not_array) return 0;
    if ((t->type==T_ARTIFICIAL && strcmp(t->text,"[")==0) || t->type==T_FIRST_BRACKET)
        return 1;
    int res=0;
    int i=0;
    for (i=0;i<t->total_parameters;i++) {
        res=is_array_operand(t->parameters[i]);
    }
    return res;
}
void rewrite_break_continue(astp *tree) {
    astp t = *tree;
    if (!t->rewritten && t->total_parameters>=1 && 
            (t->parameters[0]->type!=T_ARTIFICIAL) || strcmp(t->parameters[0]->text,";")!=0) {
        dereference_aspis_from_parameter(tree,0);
    }
}
/*
 * In the throw block, a new call to unwrapException is introduced on the throwable
 * */
void rewrite_throw(astp* tree) {
    astp t = *tree;
    if (!t->rewritten && t->total_parameters>=2 ) {
        astp p=ast_new_wparam(T_ARTIFICIAL,"(",t->parameters[0]);
        astp f=ast_new_wparam(T_STRING,"unwrapException",p);
        t->parameters[0]=f;
        f->rewritten=1;
        t->rewritten=1;
    }
}
/*
 * In a catch block, a new statement is introduced that calls wrapException()
 * to add the previous/new Aspis to the exception
 * */
void rewrite_catch(astp*  tree){
    astp t = *tree;
    if (!t->rewritten && t->total_parameters>=3 ) {
        astp v1=ast_new(T_VARIABLE,t->parameters[1]->text);
        astp v2=ast_new(T_VARIABLE,t->parameters[1]->text);
        astp p=ast_new_wparam(T_ARTIFICIAL,"(",v2);
        astp f=ast_new_wparam(T_STRING,"wrapException",p);
        astp e=ast_new_wparams(T_ARTIFICIAL,"=",v1,f);
        ast_add_symbol(e,T_ARTIFICIAL,";");
        ast_add_child(e,t->parameters[2]->parameters[0]);
        t->parameters[2]->parameters[0]=e;
        e->rewritten=1;
        t->rewritten=1;
    }
}
/*
 * Arrays, when defined, must be protected with Aspides.
 * */
void rewrite_array(astp* tree) {
    astp t = *tree;
    if (!t->rewritten) {
        attach_aspis(tree);
        t->rewritten=1;
    }
}
/*
 * Also, each key used in the constuctor must be have its Aspis removed.
 * Plus, the taint of the $key is temporarily stored in the $value.
 * */
void rewrite_double_arrow(astp* tree) {
    astp t = *tree;
    if (!t->rewritten && t->total_parameters>=2) {
        //T_DOUBLE_ARROW is inside array() declaration
        if (t->parameters[0]->type == T_ARRAY_ASPIS && t->parameters[1]->type == T_ARRAY_ASPIS) {
            //no need to call register and reregister taint, just put a false taint placeholder
            t->parameters[0]=t->parameters[0]->parameters[0]->parameters[0];
            astp temp=ast_new(T_STRING,"false");
            temp->rewritten=1;
            temp=ast_new_wparam(T_ARTIFICIAL,",",temp);
            temp->rewritten=1;
            ast_add_parameter(t->parameters[1]->parameters[0],temp);

        } else {
            astp p = ast_new_wparam(T_ARTIFICIAL, "(", t->parameters[0]);
            astp q = ast_new_wparam(T_STRING_FUNCTION, "deregisterTaint", p);
            p->rewritten = 1;
            q->rewritten = 1;
            t->parameters[0] = q;

            astp r = ast_new_wparam(T_ARTIFICIAL, "(", t->parameters[1]);
            astp f = ast_new_wparam(T_STRING_FUNCTION, "addTaint", r);
            r->rewritten = 1;
            f->rewritten = 1;
            t->parameters[1] = f;
            t->rewritten = 1;
        }
    }
    else if (!t->rewritten && t->total_parameters==1) {
        //T_DOUBLE_ARROW is inside foreach()
        //no change there, rewrite_foreach takes care of it
    }
}
/*
 * Everytime that there is an access to an array (using $a[$e]), make sure that
 * the exprs are dereferenced: $a[0][$e[0]]
 * The rule is (1) dereference with [0] $a and (2) dereference normally $e.
 * */
void rewrite_array_access(astp* tree) {
    astp t = *tree;
    if (!is_online) {
        printf("rewritten: %d\n",t->rewritten);
        ast_print_bfs(stdout,t);
        printf("\n");
        printf("total params: %d\n",t->total_parameters);
    }
    if (!t->rewritten && t->total_parameters==1) {
        //In any case, dereference the operand
        if (t->parameters[0]->type!=T_NULL ||
                (t->parameters[0]->type==T_NULL && t->parameters[0]->total_parameters>0)) {
            dereference_aspis(&(t->parameters[0]));
        }
        astp n = ast_new(T_FIRST_BRACKET, "[");
        int i = 0;
        for (i = 0; i < t->total_parameters; i++) ast_add_parameter(n, t->parameters[i]);
        for (i = 0; i < t->total_children; i++) ast_add_child(n, t->children[i]);
        ast_clear_parameters(t);
        ast_clear_children(t);
        t->type = T_NULL;
        t->text = NULL;
        //manual dereference_aspis() here,mainly because the variable has already
        //passed in the input stream
        astp p = ast_new(T_DNUMBER, "0");
        astp q = ast_new_wparam(T_ARTIFICIAL, "[", p);
        ast_add_parameter(t, q);
        //ast_add_parameter(t, n);
        ast_add_parameter(t, n);
        t->rewritten=1;
        n->rewritten=1;
        if (!is_online) {
            printf("rewrite_array: %d\n", t->rewritten);
            ast_print_bfs(stdout, t);
            printf("\n");
        }
    }
}
/*
 * In a foreach statement, I must remove the Aspis from the first parameter
 * Then, I am adding a fisrt stmt--call to restoreTaint() that makes the key
 * an Aspis Object again+it restores its taint
 * */
void rewrite_foreach(astp* tree) {
    astp t=*tree;
    if (t->parameters[1]->type==T_REF ||
            (t->parameters[2]->type==T_DOUBLE_ARROW &&
            t->parameters[2]->parameters[0]->type==T_REF) )
        dereference_aspis_from_parameter_nofunction(tree,0);
    else dereference_aspis_from_parameter(tree,0);
    //lest create a call to the restoreTaints();
    if (t->parameters[2]->type==T_DOUBLE_ARROW) {
        astp left=ast_copy(t->parameters[1]);
        astp right=ast_copy(t->parameters[2]->parameters[0]);
        
        astp d1=ast_new(T_ARTIFICIAL,";");
        astp d2=ast_new_wparam(T_ARTIFICIAL,",",right);
        astp d3=ast_new_wparams(T_ARTIFICIAL,"(",left,d2);
        astp d4=ast_new_wparams(T_STRING_FUNCTION,"restoreTaint",d3,d1);
        astp d5=ast_new_wparams(T_ARTIFICIAL,"{",d4,t->parameters[3]);
        t->parameters[3]=d5;
    }
    
}
/*
 * Echo must have its parameters' Aspides removed. Additionally, potential
 * guard calls must be added.
 */
void rewrite_echo(astp* tree) {
    char *guard=category_find_guard(taint_categories,"echo");
    if (guard==NULL) guard=category_find_guard(taint_categories,ALL_PRINTS);
    astp tnull=(*tree)->parameters[0];
    if (!tnull->rewritten) {
        if (tnull->total_parameters>0) {
            if (guard != NULL) {
                astp p = ast_new_wparam(T_ARTIFICIAL, "(", tnull->parameters[0]);
                astp f = ast_new_wparam(T_STRING_FUNCTION, guard, p);
                tnull->parameters[0] = f;
                f->rewritten=1;
                p->rewritten=1;
            }
            dereference_aspis(&(tnull->parameters[0]));
        }
        int i=1;
        for (i=1;i<tnull->total_parameters;i++) {
            if (guard != NULL) {
                astp ip = tnull->parameters[i]->parameters[0];
                astp p = ast_new_wparam(T_ARTIFICIAL, "(", ip);
                astp f = ast_new_wparam(T_STRING_FUNCTION, guard, p);
                tnull->parameters[i]->parameters[0] = f;
                f->rewritten = 1;
                p->rewritten = 1;
            }
            dereference_aspis(&(tnull->parameters[i]->parameters[0]));
        }
        tnull->rewritten=1;
        (*tree)->rewritten=1;
    }
}
/*
 * As in rewrite_echo(), but now the arg can only be one expr
 */
void rewrite_print(astp* tree) {
    astp t=(*tree);
    char *guard=category_find_guard(taint_categories,"print");
    if (guard==NULL) guard=category_find_guard(taint_categories,ALL_PRINTS);
    if (!t->rewritten && t->total_parameters > 0) {
        if (guard != NULL) {
            astp p = ast_new_wparam(T_ARTIFICIAL, "(", t->parameters[0]);
            astp f = ast_new_wparam(T_STRING_FUNCTION, guard, p);
            t->parameters[0] = f;
            t->rewritten = 1;
        }
        dereference_aspis(&(t->parameters[0]));
    }
}
/*
 * I only know that this is variable function call when I receive '('.
 * But that's enough, just add a [0] right before it. And that is enough as
 * before it there will allways be a variable, dereferancable by [0]
 */
void rewrite_variable_function_call(astp* tree) {
    astp t=*tree;
    if (!t->rewritten) {
        astp function = t->parameters[0];
        if (function->total_parameters==0 ||
                function->parameters[function->total_parameters - 1]->type != T_OBJECT_OPERATOR) {
            astp paramslist = NULL;
            astp coma = NULL;
            astp q = ast_new(T_ARTIFICIAL, "(");
            if (t->parameters[1]->parameters[0]->total_parameters > 0) {
                paramslist = t->parameters[1]->parameters[0];
                coma = ast_new_wparam(T_ARTIFICIAL, ",", paramslist);
                ast_add_parameter(q,function);
                ast_add_parameter(q,coma);
            } else ast_add_parameter(q,function);
            astp r;
            if (!is_partial_enabled) r = ast_new_wparam(T_STRING_FUNCTION, "AspisDynamicCall", q);
            else if (is_tainted || is_tainted_cl) r = ast_new_wparam(T_STRING_FUNCTION, "AspisTaintedDynamicCall", q);
            else r = ast_new_wparam(T_STRING_FUNCTION, "AspisUntaintedDynamicCall", q);
            *tree = r;
            int i;
            for (i = 2; i < t->total_parameters; i++) {
                ast_add_parameter(r, t->parameters[i]);
            }
            for (i = 0; i < t->total_children; i++) {
                ast_add_parameter(r, t->children[i]);
            }

            q->rewritten = 1;
            r->rewritten = 1;
        }
        else {
            //this hanlded trees created from the rule on php_parser:1916
            //it only handles one level of -> : $v->$q->$d will fail //TODO
            //see
            ast_print_bfs(stdout,function);
            astp objop=function->parameters[function->total_parameters - 1];
            ast_remove_parameter(function,function->total_parameters-1);
            astp paramslist = NULL;
            astp coma = NULL;
            astp q = NULL;

            //create the function callback
            astp inv_params=objop->parameters[0]->children[0];
            ast_clear_children(objop->parameters[0]);
            coma =ast_new_wparam(T_ARTIFICIAL,",",objop->parameters[0]);
            ast_add_parameter(function,coma);
            astp array=ast_new_wparam(T_ARTIFICIAL,"(",function);
            array=ast_new_wparam(T_ARRAY,"array",array);
            if (!is_partial_enabled || (is_tainted || is_tainted_cl)) attach_aspis(&array);

            if (inv_params->type!=T_NULL && inv_params->parameters[0]->total_parameters>0) {
                paramslist = inv_params->parameters[0];
                coma = ast_new_wparam(T_ARTIFICIAL, ",", paramslist);
                q = ast_new_wparams(T_ARTIFICIAL, "(", array, coma);
            } else q = ast_new_wparam(T_ARTIFICIAL, "(", array);
            astp r;
            if (!is_partial_enabled) r = ast_new_wparam(T_STRING_FUNCTION, "AspisDynamicCall", q);
            else if (is_tainted || is_tainted_cl) r = ast_new_wparam(T_STRING_FUNCTION, "AspisTaintedDynamicCall", q);
            else r = ast_new_wparam(T_STRING_FUNCTION, "AspisUntaintedDynamicCall", q);
            *tree = r;
        }
    }
}
/*
 * Store all functions of the file for easier inspection in the end
 */
void save_function_name(char * f) {
    f=strcat_malloc(f,"()\n");
    if (strcmp(f,"array_multisort()\n")==0) {
        f=strcat_malloc("WARNING: ",f);
    }
    astp temp=functions_found;
    int params;
    if (temp==NULL)  functions_found=ast_new(T_STRING_FUNCTION,f);
    else {
        params=temp->total_parameters;
        while (params>0) {
            if (strcmp(temp->text,f)==0) return;
            temp=temp->parameters[0];
            params=temp->total_parameters;
        }
        if (strcmp(temp->text,f)==0) return;
        ast_add_symbol(temp,T_STRING_FUNCTION,f);
    }
}
/*
 * Attach the prefix Aspis to every function call in functions_overriden_list
 */
void rewrite_function_name(astp * tree,int total_parameters) {
    astp t=*tree;
    if (list_search(functions_list,0,functions_count,functions_count,t->text)!=-1) {
        save_function_name(t->text);
    }
    if (is_partial_enabled &&
            list_search(functions_overriden_partial_list,0,functions_overriden_partial_count,
            functions_overriden_partial_count,t->text)!=-1) {
           t->text = strcat_malloc("AspisTainted_", t->text);
    }
    else {
        if (list_search(functions_overriden_list, 0, functions_overriden_count,
                functions_overriden_count, t->text) != -1) {
            if (strcmp(t->text, "array_multisort") == 0) {
                t->text = strcat_malloc("Aspis_", t->text);
                char * asstr = (char *) malloc(5 * sizeof (char));
                sprintf(asstr, "%d", total_parameters);
                t->text = strcat_malloc(t->text, asstr);
            } else t->text = strcat_malloc("Aspis_", t->text);
        }
    }
}
/*
 * Function calls on built in functions must have their args dereferenced.
 * Additionally, for builtin functions with ref arguments, I use the AspisInternalFunnctionCall
 * wrapper. This makes sure that the ref arguments are altered after the call returns.
 */
void rewrite_function_call(astp * tree) {
    astp t=*tree;
    int ref_params[10]; //stores indexes of the call's ref parameters
    int ref_params_index=0;
    astp tnull;
    int i;
    int findex=-1;
    if (!t->rewritten) {
        int total_params=0;
        if (t!=NULL && t->total_parameters>0 && t->parameters[0]->total_parameters>0) {
            total_params=t->parameters[0]->parameters[0]->total_parameters;
        }
        rewrite_function_name(tree,total_params); //the rewritten name will never match the following
        int tainted_calls_untainted=is_partial_enabled && (is_tainted && !is_tainted_function(t->text) && !COLLECT_INFO);
        int library_call=list_search(functions_list,0,functions_count,functions_count,t->text)!=-1;
        if (strstr(t->text,"Aspis")!=NULL) {
            tainted_calls_untainted=0;
            library_call=0;
        }
        if (library_call || tainted_calls_untainted) {
            if (!is_language_construct) {
                //dereference aspides from each parameter
                tnull = t->parameters[0]->parameters[0];
                if (library_call) findex = prototypes_find(functions_prototypes, functions_prototypes_count, t->text);
                else findex = prototypes_find(user_functions_prototypes, user_functions_prototypes_count, t->text);
                //iterate through all parameters, act accordingly
                for (i = 0; i < tnull->total_parameters; i++) {
                    char * type;
                    if (library_call) type = prototype_parameter_type(functions_prototypes, functions_prototypes_count, t->text, i, tnull->total_parameters);
                    else type = prototype_parameter_type(user_functions_prototypes, user_functions_prototypes_count, t->text, i, tnull->total_parameters);
                    astp p = tnull->parameters[i];

                    //subsequent param
                    if (p->type == T_ARTIFICIAL && strcmp(p->text, ",") == 0) {
                        astp q = p->parameters[0];
                        if (findex != -1 && is_ref(type)) {
                            ref_params[ref_params_index++] = i; //write this down
                            astp t1 = ast_new_wparam(T_ARTIFICIAL, "(", q);
                            q = ast_new_wparam(T_STRING_FUNCTION, "AspisPushRefParam", t1);
                            q->rewritten = 1;
                        } else if (findex != -1 && is_callback(type)) {
                            astp t1 = ast_new_wparam(T_ARTIFICIAL, "(", q);
                            q = ast_new_wparam(T_STRING_FUNCTION, "AspisInternalCallback", t1);
                            q->rewritten = 1;
                        } else if (library_call) dereference_aspis_wtype(&q, type);
                        else dereference_aspis_wwarning(&q);
                        p->parameters[0] = q;
                    } else { //first param
                        if (findex != -1 && is_ref(type)) {
                            ref_params[ref_params_index++] = i; //write this down
                            astp t1 = ast_new_wparam(T_ARTIFICIAL, "(", p);
                            p = ast_new_wparam(T_STRING_FUNCTION, "AspisPushRefParam", t1);
                            p->rewritten = 1;
                        } else if (findex != -1 && is_callback(type)) {
                            astp t1 = ast_new_wparam(T_ARTIFICIAL, "(", p);
                            p = ast_new_wparam(T_STRING_FUNCTION, "AspisInternalCallback", t1);
                            p->rewritten = 1;
                        }
                        else if (strcmp(t->text,"extract")==0) {
                            /*
                             * extract() must get the first argument as it is. Otherwise, the
                             * extraced variables do not contain Aspides.
                             */
                            dereference_aspis(&p);
                            //add a stupid parenthesis to avoid a notice when the 1rst arg is a proxy
                            p=ast_new_wparam(T_ARTIFICIAL,"(",p);
                        }
                        else if (library_call)  dereference_aspis_wtype(&p, type);
                        else dereference_aspis_wwarning(&p);
                    }
                    tnull->parameters[i] = p;
                }
            }
            else if (strcmp(t->text,"empty")==0) {
                astp p=t->parameters[0];
                if (p->type==T_ARTIFICIAL && strcmp(p->text,"(")==0) dereference_aspis_from_parameter(&(p->parameters[0]),0);
                else dereference_aspis(&(p));
            }
            //attach an aspis to the result
            //lets move all children of the function call to the aspis, plus
            //a potential ; that ends the statement
            astp temp = ast_new(T_NULL, "");
            if (t->total_parameters > 0 && strcmp(t->parameters[t->total_parameters - 1]->text, ";") == 0) {
                ast_add_parameter(temp, t->parameters[t->total_parameters - 1]);
                ast_remove_parameter(t, t->total_parameters - 1);
            }
            i = 0;
            for (i = 0; i < t->total_children; i++) {
                ast_add_child(temp, t->children[0]);
                ast_remove_child(t, 0);
            }
            //how should I handle the return value?
            if (findex==-1) {
                if (!library_call) {
                    char * str=strcat_malloc("Function call rewritting failed to locate a function prototype that should be known: ",t->text);
                    printf("------Dying:-------\n");
                    printf("Library Call: %d\n",library_call);
                    findex = prototypes_find(functions_prototypes, functions_prototypes_count, t->text);
                    printf("Built in Functions Index: %d\n",findex);
                    findex = prototypes_find(user_functions_prototypes, user_functions_prototypes_count, t->text);
                    printf("Application Functions Index: %d\n",findex);
                    die(str);
                }
                attach_aspis(tree); //TODO: this should NEVER happen...
            }
            else if(ref_params_index!=0) {
                //there are ref params, I need a call to AspisInternalFunctionCall
                astp tp=ast_new(T_ARTIFICIAL,"(");
                int j=0;
                for (j=0;j<ref_params_index;j++) {
                    char* num=(char*)malloc(5*sizeof(char));
                    sprintf(num, "%d", ref_params[j]);
                    astp t=ast_new(T_DNUMBER,num);
                    if (j==0) {
                        ast_add_parameter(tp,t);
                    }
                    else {
                        astp tt=ast_new_wparam(T_ARTIFICIAL,",",t);
                        ast_add_parameter(tp,tt);
                    }
                }
                astp param3=ast_new_wparam(T_ARRAY,"array",tp);
                astp param2=tnull;
                astp p=ast_new(T_CONSTANT_ENCAPSED_STRING,strcpy_malloc(t->text));
                astp param1=ast_new_wparam(T_ARTIFICIAL,"\"",p);

                p=ast_new_wparam(T_ARTIFICIAL,"(",param1);
                astp c=ast_new_wparam(T_ARTIFICIAL,",",param2);
                ast_add_parameter(p,c);
                c=ast_new_wparam(T_ARTIFICIAL,",",param3);
                ast_add_parameter(p,c);
                astp newf;
                if (library_call) newf=ast_new_wparam(T_STRING_FUNCTION,"AspisInternalFunctionCall",p);
                else newf=ast_new_wparam(T_STRING_FUNCTION,"AspisUntaintedFunctionCall",p);
                *tree=newf;
            }
            else {
                if (library_call) {
                    char * rettype = prototype_return_type(functions_prototypes, functions_prototypes_count, t->text);
                    attach_aspis_wtype(tree, rettype, t->text);
                } else {
                    char * rettype = prototype_return_type(user_functions_prototypes, user_functions_prototypes_count, t->text);
                    attach_aspis_wwarning_wtype(tree, rettype);
                }
            }
            if (temp->total_parameters == 1) ast_add_parameter(*tree, temp->parameters[0]);
            for (i = 0; i < temp->total_children; i++) {
                ast_add_child(*tree, temp->children[i]);
            }
        }
        t->rewritten=1;
    }
}
/*
 * Calls to sanitisation functions should be enclosed in AspisKillTaint(f(),i);
 */
void rewrite_sanitiser_call(astp * tree) {
    astp t=*tree;
    if ( t->type!=T_STRING_FUNCTION ) return;
    char * fname=strcpy_malloc(t->text);
    char * initial=strtok(fname,"_");
    if (strcmp(initial,"Aspis")==0) fname=strtok(NULL,"");
    int i=category_find_index(taint_categories,fname);
    if (i==-1) return;
    
    char * i_str=(char *)malloc(5*sizeof(char));
    snprintf(i_str,4,"%d",i);
    astp p=ast_new(T_DNUMBER,i_str);
    astp c=ast_new_wparam(T_ARTIFICIAL,",",p);
    astp par=ast_new_wparams(T_ARTIFICIAL,"(",t,c);
    astp f=ast_new_wparam(T_STRING_FUNCTION,"AspisKillTaint",par);
    *tree=f;
    
    p->rewritten=1;
    c->rewritten=1;
    par->rewritten=1;
    f->rewritten=1;
}
/*
 * Calls to sinks should have their first argument passed to the guard.
 * E.g. sink($a) must become sink(guard($a))
 */
void rewrite_sink_call(astp * tree) {
    astp t=*tree;
    if ( t->type==T_ARRAY_ASPIS || strstr(t->text,"attAspis")!=NULL ) {
        t=t->parameters[0]->parameters[0];
    }
    //now t points the to the function call
    char * fname=strcpy_malloc(t->text);
    char * initial=strtok(fname,"_");
    if (strcmp(initial,"Aspis")==0) fname=strtok(NULL,"");
    
    char *guard=category_find_guard(taint_categories,fname);
/*
    if (t->type==T_EXIT && guard==NULL) {
        guard=category_find_guard(taint_categories,ALL_PRINTS);
    } 
*/
    if (guard==NULL) return;
    
    //now I have to attach a call to the guard before the first param
    //careful to put the call inside any potential deAspis() of the first param.
    astp paren=t->parameters[0];
    if (paren->total_parameters==0) return; //call with no arguments passed
    if (paren->parameters[0]->type!=T_NULL || paren->parameters[0]->total_parameters==0) return;
    astp tnull=paren->parameters[0];
    astp first_param=tnull->parameters[0];
    int has_deAspis=0;
    if (strstr(first_param->text,"deAspis")!=NULL) {
        has_deAspis=1;
        first_param=first_param->parameters[0]->parameters[0];
    }
    
    astp par=ast_new_wparam(T_ARTIFICIAL,"(",first_param);
    astp f=ast_new_wparam(T_STRING_FUNCTION,guard,par);
    
    if (has_deAspis) tnull->parameters[0]->parameters[0]->parameters[0]=f;
    else tnull->parameters[0]=f;
    
    par->rewritten=1;
    f->rewritten=1;
}
/*
 * All assingments to arrays must be checked for string/char assingments at runtime
 * I.e. $s="123"; $s[1]=$c; must become arrayAssign($s,1,$c);
 */
void rewrite_variable_array_assingment(astp *tree) {
    astp t=*tree;
    if (!PROTECT_CHARS) return;
    if (!t->rewritten && is_array_operand(t->parameters[0])) {
        //locate the new index that is stored in the array
        astp cur=t->parameters[0];
        astp mark1=NULL;
        astp mark2=NULL;
        find_array_prelast_paren(cur,&mark1);
        find_array_last_paren(cur,&mark2);
        if (mark1!=NULL && mark2!=NULL) {
            astp next=NULL;
            if (mark2->parameters[0]->type==T_STRING_FUNCTION &&
                    strcmp(mark2->parameters[0]->text,"deAspis")==0) {
                //mark2 points the last index, call registerTaint before current()
                next=mark2->parameters[0];

                ast_clear_children(mark2);
                ast_clear_parameters(mark2);
                mark2->type=T_NULL;
                mark2->text=NULL;
                
            }
            else if (mark2->parameters[0]->type==T_DNUMBER ) {
                //mark1 point the last index now.
                //TODO: this has not be tested, but it is rather impossible for control
                //to reach it. This is because the index was registerTaint()ed, thus
                //removal of Aspis is always with current() and not with [].
                next=mark1->parameters[0];
                ast_clear_children(mark1);
                ast_clear_parameters(mark1);
                mark1->type=T_NULL;
                mark1->text=NULL;
            }
            //in both cases, call addTaint on the right hand parameter
            astp a=ast_new_wparam(T_ARTIFICIAL,",",t->parameters[1]);
            astp q;
            if (next!=NULL) {
                astp b=ast_new_wparam(T_ARTIFICIAL,",",next);
                astp c=ast_new_w3params(T_NULL,NULL,t->parameters[0],b,a);
                astp p=ast_new_wparam(T_ARTIFICIAL,"(",c);
                q=ast_new_wparam(T_STRING_FUNCTION,"arrayAssign",p);
            }
            else {
                astp c=ast_new_wparams(T_NULL,NULL,t->parameters[0],a);
                astp p=ast_new_wparam(T_ARTIFICIAL,"(",c);
                q=ast_new_wparam(T_STRING_FUNCTION,"arrayAssignAdd",p);
            }
            int i=2;
            for (i=2;i<t->total_parameters;i++) {
                ast_add_parameter(q,t->parameters[i]);
            }
            for (i=0;i<t->total_children;i++) {
                ast_add_child(q,t->children[i]);
            }
            //and in the end, replace the assingment with arrayAssign();
            *tree=q;
        }
        t->rewritten=1;
        
    }

}
/*
 * This identifies in a list() stmts, the places where sublists are put:
 * i.e. list($a,list($b,$c)) gives array(1=>array())
 */
astp find_lists_recursively(astp t) {
/*
    printf("\nRECURSIVE LIST REMOVAL:\n");
    ast_print_bfs(stdout, t);
*/

    astp par=ast_new(T_ARTIFICIAL,"(");
    astp result=ast_new_wparam(T_ARRAY,"array",par);
    result->rewritten=1;

    int i=0;
    t=t->parameters[0]->parameters[0]; //the parenthesis-and then-T_NULL
    for (i=0;i<t->total_parameters;i++) {
/*
        printf("\nPARAM %d TYPE: %d\n",i,t->parameters[i]->type);
        ast_print_bfs(stdout,t->parameters[i]);
*/
        astp e=t->parameters[i];

        if (e->type==T_ARTIFICIAL && strcmp(e->text,",")==0) {
            if ( e->total_parameters>0 ) e=e->parameters[0];
            else continue;
        }
        if (e->type == T_LIST) {
            astp pp = ast_new(T_DOUBLE_ARROW, "=>");
            pp->rewritten=1;
            char * str = (char *) malloc(3 * sizeof (char));
            sprintf(str, "%d", i);
            pp = ast_new_wparam(T_DNUMBER, str, pp);
            pp->rewritten=1;
            ast_add_parameter(pp, find_lists_recursively(e));
            if (par->total_parameters!=0) pp = ast_new_wparam(T_ARTIFICIAL, ",", pp);
            ast_add_parameter(par, pp);
        }
    }
    return result;
}
/*
 * Since the left operand is a list() construct, i must remove the aspis form
 * the right hand operand. list($drink) = $info; -to- list($drink) = $info[0];
 */
void rewrite_list_assignment(astp * tree) {
    astp t=*tree;
    if (t->total_parameters>=2 && t->parameters[0]->type==T_LIST && t->parameters[0]->rewritten==0) {
        astp result=find_lists_recursively(t->parameters[0]);
        if (!is_online) {
            printf("\nLISTS TO REMOVE:\n");
            ast_print_bfs(stdout, result);
            printf("\n");
        }
        //dereference_aspis(&(t->parameters[1]));
        astp marks=ast_new_wparam(T_ARTIFICIAL,",",result);
        astp right=ast_new_wparams(T_ARTIFICIAL,"(",t->parameters[1],marks);
        astp call=ast_new_wparam(T_STRING_FUNCTION,"deAspisList",right);
        t->parameters[1]=call;
        t->parameters[0]->rewritten=1;
        call->rewritten=1;
        right->rewritten=1;
        marks->rewritten=1;
    }
}
/*
 * If the assignment involves an array as a lvalue, make sure that the taint of
 * the index is stored to the rvalue (piggybacked on the [2] index of its Aspis
 * */
void rewrite_assignement(astp *tree) {
   astp t = *tree;
   if (t->parameters[0]->type==T_LIST) {
       rewrite_list_assignment(tree);
       return;
    }
    if (!t->rewritten && is_array_operand(t->parameters[0])) {
        //locate the new index that is stored in the array
        astp cur = t->parameters[0];
        astp mark1 = NULL;
        astp mark2 = NULL;
        //find_array_start(cur, &mark1, &mark2);
        find_array_prelast_paren(cur,&mark1);
        find_array_last_paren(cur,&mark2);

        if (mark1 == NULL && mark2 == NULL) {
            //it's not actually an access, no need to do anything (normal variables)
            return;
        } else if (mark1 == NULL || mark2 == NULL) {
            //array access, but then there MUST be two '[' in the rewritten stream
            die("Assignment to array, but cannot locate at least two '['\n");
        } else {
            if (mark2->parameters[0]->type == T_STRING_FUNCTION &&
                    strcmp(mark2->parameters[0]->text, "deAspis") == 0) {
                //mark2 points the last index, call registerTaint before current()
                astp next = mark2->parameters[0]->parameters[0];
                astp a = ast_new_wparam(T_STRING_FUNCTION, "registerTaint", next);
                astp b = ast_new_wparam(T_ARTIFICIAL, "(", a);
                mark2->parameters[0]->parameters[0] = b;
            } else if (mark1->parameters[0]->type == T_STRING_FUNCTION &&
                    strcmp(mark1->parameters[0]->text, "deAspis") == 0) {
                //mark1 points the last index, call registerTaint before current()
                astp next = mark1->parameters[0]->parameters[0];
                astp a = ast_new_wparam(T_STRING_FUNCTION, "registerTaint", next);
                astp b = ast_new_wparam(T_ARTIFICIAL, "(", a);
                mark1->parameters[0]->parameters[0] = b;
            } else if (mark2->parameters[0]->type == T_DNUMBER) {
                //mark1 point the last index now.
                astp a = ast_new_wparam(T_ARTIFICIAL, "(", mark1->parameters[0]);
                astp b = ast_new_wparam(T_STRING_FUNCTION, "registerTaint", a);
                //where does registerTaint's parameter stop?
                astp var=mark1->parameters[0];
                ast_remove_parameter(var, var->total_parameters-1);
                //registerTaint is called but a new dereference_aspis is required
                //this is because registerTaint($var)[0] is not syntactically correct
                dereference_aspis(&b);
                mark1->parameters[0] = b;
            }
            //in both cases, call addTaint (or addTaintR!) on the right hand parameter
            astp p;
            astp q;
            astp r;
            int is_reference=t->parameters[1]->type==T_REF;
            if (is_reference) {
                p = ast_new_wparam(T_ARTIFICIAL, "(", t->parameters[1]->parameters[0]); //kill the &
                q = ast_new_wparam(T_STRING_FUNCTION, "addTaintR", p);
                q->rewritten=1;
                q=ast_new_wparam(T_REF,"&",q);
            } else {
                p = ast_new_wparam(T_ARTIFICIAL, "(", t->parameters[1]);
                q = ast_new_wparam(T_STRING_FUNCTION, "addTaint", p);
            }
            t->parameters[1] = q;
            p->rewritten = 1;
            q->rewritten = 1;
            //and in the end, replace the assingment with arrayAssign();
            if (!is_reference) {
                rewrite_variable_array_assingment(tree);
            }
        }
        t->rewritten = 1;
    }
}
/*
 * All accesses to arrays must be checked for possible character contents.
 * I.e. $s="12"; echo $s[1];  must be echo attachAspis($s[1]);
 */
void rewrite_variable_array_access(astp *tree) {
    astp t=*tree;
    if (!PROTECT_CHARS || is_language_construct || is_assignment || is_reference || t->total_parameters==0) return;
    astp lastp=t->parameters[t->total_parameters-1];
    astp afterlastp=NULL;
    if (lastp->total_parameters>0) afterlastp=lastp->parameters[lastp->total_parameters-1];
    if (afterlastp==NULL) return;
    //this catches reads that are on [], ie $a[] should be rewritten (but what does it mean?!)
    if (afterlastp->total_parameters==1 && afterlastp->parameters[0]->type==T_NULL &&
            afterlastp->parameters[0]->total_parameters==0) return;

    /*
 * //THIS PROTECTS ARRAY ACCESSES ON ARRAYS IN OBJECTS: $a->ar[];
    if (!is_online) {
            printf("Should I attach an Aspis?\n");
            ast_print_bfs(stdout,*tree);
            printf("\n");
            printf("lastp: %d -- afterlastp: %d\n",lastp->type,afterlastp->type);
    }
    if (PROTECT_CHARS && lastp->type==T_OBJECT_OPERATOR
            && lastp->total_parameters>0 && lastp->parameters[0]->total_parameters>0
            && lastp->parameters[0]->parameters[0]->total_parameters>0) {

        astp lastpt=lastp->parameters[0]->parameters[0];
        astp afterlastpt=lastpt->parameters[lastpt->total_parameters-1];
        if (afterlastpt->text!=NULL && strcmp(afterlastpt->text,"[")==0 && afterlastpt->not_array==0) {
            lastp=lastpt;
            afterlastp=afterlastpt;
        }
        if (!is_online) {
            printf("lastp\n");
            ast_print_bfs(stdout, lastp);
            printf("\nafterlastp\n");
            ast_print_bfs(stdout, afterlastp);
            printf("\n");
        }
    }
*/

    if (PROTECT_CHARS && lastp->type!=T_OBJECT_OPERATOR && strcmp(afterlastp->text,"[")==0 ) {
        if (!is_online) {
            printf("Just attached Aspis->\n");
            printf("before:\n");
            ast_print_bfs(stdout,*tree);
        }
        astp index=afterlastp->parameters[0];
        astp cindex=ast_new_wparam(T_ARTIFICIAL,",",index);
        ast_clear_parameters(afterlastp);

        afterlastp->type=T_NULL;
        afterlastp->text=NULL;
        lastp->type=T_NULL;
        lastp->text=NULL;


        if (!is_online) {
            printf("in between:\n");
            ast_print_bfs(stdout,lastp);
        }
        ast_clear_parameters(lastp);
        if (!is_online) {
            printf("in between:\n");
            ast_print_bfs(stdout,lastp);
        }

        astp n=ast_new_wparams(T_NULL,NULL,t,cindex);
        astp a=ast_new_wparam(T_ARTIFICIAL,"(",n);
        astp b=ast_new_wparam(T_STRING_FUNCTION,"attachAspis",a);
        if (!is_online) {
            printf("\nafter:\n");
            ast_print_bfs(stdout,b);
            printf("\n");
        }
        *tree=b;
    }
}
/*
 * Object operators must lead to the removals of their operand's apsides.
 * To do so, everything after a -> is collected to a list and then appended to *start
 * after its aspis has been removed.
 * ie $var->a->b->c will locate $var->a and will crete $var->a[0]->b[0]->c;
 * The aspis of $var is removed by rewrite_variable_object_accees.
 */
void rewrite_object_operator(astp *tree,astp* start) {
    astp t=*tree;
    astp lastp = t->parameters[t->total_parameters - 1];
    if (lastp->type != T_NULL) {
        return;
    }
    int i = 0;
    for (i = 0; i < lastp->total_parameters; i++) {
        if (lastp->parameters[i]->type != T_OBJECT_OPERATOR) {
            return;
        }
    }

    astp copy=ast_new(T_NULL,NULL);
    //lets create a list of everything with a -> operator
    ast_remove_parameter(t, t->total_parameters - 1);
    ast_add_parameter(copy,t);
    int paramsc=lastp->total_parameters;
    for (i = 0 ; i < paramsc  ; i++) {
        ast_add_parameter(copy,lastp->parameters[0]);
        ast_remove_parameter(lastp,0);
    }
    
    *tree=ast_new(T_NULL,NULL);
    for (i=0;i<copy->total_parameters;i++) {
        //this is not the last ->, thus the aspis must be removed
        if (i<copy->total_parameters-1) {
            if (copy->parameters[i]->parameters[0]->type == T_STRING_METHOD) {
                //deAspis() from the begining!
                ast_add_parameter(*start,copy->parameters[i]);
                dereference_aspis_wfunction(start);
            }
            else if (copy->parameters[i]->parameters[0]->type == T_VARIABLE) {
                //remove the aspis with a []
                dereference_aspis_nofunction(&(copy->parameters[i]->parameters[0]));
                ast_add_parameter(*start,copy->parameters[i]);
                //deAspis() from the begining!
                dereference_aspis_wfunction(start);
            }
            else {
               //remove the aspis with a []
               dereference_aspis_nofunction(&(copy->parameters[i]->parameters[0]));
               ast_add_parameter(*start,copy->parameters[i]);
            }
        }
        //the last -> doesn't have its aspis removed
        //UNLESS  it is a T_VARIABLE!
        else if (copy->parameters[i]->parameters[0]->type == T_VARIABLE) {
            dereference_aspis_nofunction(&(copy->parameters[i]->parameters[0]));
            ast_add_parameter(*start,copy->parameters[i]);
            (*start)->not_array=1;
        }
        //the last -> doesn't have its aspis removed
        else {
            ast_add_parameter(*start,copy->parameters[i]);
        }
    }
    t->rewritten = 0;
}
/*
 * if the variable is accessed as an object, then the variable must be deaspisised
 * eg $varr->hello() must become $varr[0]->hello()
 */
void rewrite_variable_object_access(astp *tree) {
    astp t=*tree;
    if (!is_online) printf("rewrite_variable_object_access on (%s)\n",t->text);
    if (t->total_parameters==0) {
        if (!is_online) printf("no parameters found at all \n");
        return;
    }
    
    astp lastp=t->parameters[t->total_parameters-1];
    //if (lastp->not_array && t->total_parameters>1) lastp=t->parameters[t->total_parameters-2];
    astp afterlastp=NULL;
/*
    if (lastp->type==T_ARTIFICIAL && strcmp(lastp->text,";")==0) {
        if (t->total_parameters>=2) {
            lastp=t->parameters[t->total_parameters-2];
        }
    }
*/
    if (lastp->total_parameters>0) afterlastp=lastp->parameters[lastp->total_parameters-1];
    else {
        if (!is_online)  printf("no parameters found after: (%s)\n",lastp->text);
        return;
    }

    if (lastp->type==T_OBJECT_OPERATOR && strcmp(t->text,"$this")!=0) {
        ast_remove_parameter(t,t->total_parameters-1);
        if ((*tree)->type==T_VARIABLE) dereference_aspis_nofunction(tree);
        else dereference_aspis(tree);
        ast_add_parameter(t,lastp);
    }
    else {
        if (!is_online) {
            printf("not an object operator?: (%d)(%s)\n", lastp->type, lastp->text);
            ast_print_bfs(stdout, t);
            printf("\n");
        }
    }
    if (afterlastp->type==T_NULL) rewrite_object_operator(&(t->parameters[t->total_parameters-1]),tree);

}
/*
 * All magic constants must be become... Aspides! :-p
 */
void rewrite_magic_constant(astp *tree) {
    astp t=*tree;
    if (!t->rewritten) {
        attach_aspis(tree);
        t->rewritten=1;
    }
}
/*
 * A reference to a new object is not required in PHP5 and doesnt work once
 * the objects is enclosed in an Aspis. Thus
 * $v=& new Object() is rewritten to $v=new Object();
 * The & was there as in PHP4, objects were copied by value...
 */
void rewrite_reference(astp *tree) {
    astp t=*tree;
    if (t->total_parameters==0) return;
    if ((*tree)->parameters[0]->type == T_NEW ||
            (t->parameters[0]->type==T_VARIABLE && strcmp(t->parameters[0]->text,"$this")==0
             && t->parameters[0]->total_parameters==0) ) {
        astp temp=(*tree)->parameters[0];
        //T_NULL is added so that T_NEW remains further down the tree and it
        //is rewritten in the seubsequent ast_edit_bfs()
        *tree = ast_new(T_NULL,NULL);
        ast_add_parameter(*tree,temp);
    }
}
/*
 * Any time that $this is used on its own (without a -> following), I must make
 * this reference appear as an Aspis. i.e. $this -> array($this,false)
 */
void rewrite_this(astp *tree) {
    astp t=*tree;
    if (t->rewritten!=1 && strcmp(t->text,"$this")==0
            && t->total_parameters==0) {
        attach_aspis(tree);
        t->rewritten=1;
    }
}
/*
 * When an object operator is followed with a {}, the expression inside {} must
 * be dereferenced.
 */
void rewrite_object_parenthesis (astp *tree) {
    astp t=*tree;
    if (t->rewritten!=1) {
        if (t->total_parameters>0 && t->parameters[0]->type==T_ARTIFICIAL
                && strcmp(t->parameters[0]->text,"{")==0) {
            dereference_aspis_from_parameter(&(t->parameters[0]),0);
        }
    }
}
/*
 * I must dereference the operand: ${$value} must become ${$value[0]}
 */
void rewrite_dollar_open(astp *tree) {
    astp t=*tree;
    if (strcmp((*tree)->text,"$")==0 && (*tree)->total_parameters>=1
            && (*tree)->parameters[0]->type==T_ARTIFICIAL
            && strcmp((*tree)->parameters[0]->text,"{")==0) {
        //tranform it to T_DOLLAR_OPEN_CURLY
        t->type=T_DOLLAR_OPEN_CURLY_BRACES;
        t->text=strcpy_malloc("&{");
        t->not_array=1;
        t->parameters[0]->type=T_NULL;
        t->parameters[0]->text=NULL;
        //astp temp=t->parameters[0];
        //ast_clear_parameters(t);
        //int i=0;
        //for (i=0;i<temp->total_parameters;i++) ast_add_parameter(t,temp->parameters[i]);
        //for (i=0;i<temp->total_children;i++) ast_add_child(t,temp->children[i]);
    }
    if (t->rewritten!=1 && t->total_parameters>0) {
        dereference_aspis(&(t->parameters[0]));
        t->rewritten=1;
    }

}
/*
 * Consequtive dollars mean that there is no ambiquity but the envlosed dollar
 * must be dereferenced. I.e. $$var must become $$var[0];
 * No ambiguity: var is not followed by any object or [] operators.
 */
void rewrite_dollar_dollar (astp *tree) {
   astp t=*tree;
   if (strcmp(t->text,"$")==0 && t->total_parameters>=1
            && t->parameters[0]->type==T_VARIABLE) {
       dereference_aspis_from_parameter(tree,0);
       printf("total params: %d\n",t->total_parameters);
       if (t->total_parameters==2) {
           astp n=ast_new_wparam(T_ARTIFICIAL,"{",t->parameters[0]);
           t->parameters[0]=n;
           astp temp=t->parameters[1];
           astp z=ast_new(T_DNUMBER,"0");
           astp p=ast_new_wparam(T_ARTIFICIAL,"[",z);
           p->not_array=1;
           t->parameters[1]=p;
           ast_add_parameter(t,temp);
       }
       else if (t->total_parameters==1) {
           astp n=ast_new_wparam(T_ARTIFICIAL,"{",t->parameters[0]);
           t->parameters[0]=n;
       }
   }
}
/*
 * Attach a reference to the result and dereference the operand, if it is a
 * function call!
 * When partial taint tracking is enabled, a proxy may be added to the call
 */
void rewrite_new(FILE * out,astp *tree) {
    astp t=*tree;
    if (!t->rewritten) {
        astp p=t->parameters[0];
        if (p->type!=T_STATIC && p->type!=T_STRING_CLASSNAME) {
            //DYNAMIC NEW
            if (!is_partial_enabled) {
                edit_node_generic(out, tree, NULL);
                dereference_aspis_from_parameter_nofunction(tree, 0);
                attach_aspis(tree);
                t->rewritten = 1;
            }
            else {
                int is_tainted_me = is_tainted || is_tainted_cl;
                astp b;
                if (is_tainted_me) {
                    edit_node_generic(out, tree, NULL);
                    dereference_aspis_from_parameter_nofunction(tree, 0);
                    b = ast_new(T_STRING_CONSTNAME, "true"); //wrong symbol name...
                }
                else {
                    untainted_edit_node_generic(out, tree, NULL);
                    b = ast_new(T_STRING_CONSTNAME, "false"); //wrong symbol name...
                }

                astp temp = ast_new(T_NULL, NULL);
                int i = 0;
                for (i = 0; i < t->total_children; i++) ast_add_child(temp, t->children[i]);
                ast_clear_children(t);
                astp new_name=ast_copy(t->parameters[0]);
                astp new_rest=ast_copy(t->parameters[1]);
                if (new_rest->type==T_NULL && new_rest->total_parameters==0 &&
                        new_rest->total_children==0) {
                    new_rest=ast_new(T_ARTIFICIAL,"(");
                }
                new_rest=ast_new_wparam(T_ARRAY,"array",new_rest);

                astp par = ast_new_wparams(T_ARTIFICIAL, "(",
                        new_name,
                        ast_new_wparam(T_ARTIFICIAL, ",", new_rest));
                ast_add_parameter(par,ast_new_wparam(T_ARTIFICIAL, ",", b));
                
                astp call = ast_new_wparam(T_STRING_FUNCTION, "AspisNewUnknownProxy", par);

                for (i = 0; i < t->total_children; i++) ast_add_child(call, temp->children[i]);
                *tree=call;
            }
        }
        else {
            //STATIC NEW, I know the name of the instantiated class
            t = *tree;
            if (!is_partial_enabled) {
                //just dereference all aspides from parameters, and protect the result
                edit_node_generic(out,tree,NULL);
                attach_aspis(tree);
                t->rewritten=1;
            }
            else  {
                int is_tainted_new=is_tainted_class(p->text);
                int is_tainted_me=is_tainted || is_tainted_cl;
                
                if (is_tainted_me && is_tainted_new) {
                    edit_node_generic(out, tree, NULL);
                    attach_aspis(tree);
                    t->rewritten = 1;
                }
                else if (!is_tainted_me && !is_tainted_new) {
                    untainted_edit_node_generic(out, tree, NULL);
                    t->rewritten = 1;
                }
                else { //both untainted->tainted and tainted->untainted are treated here
                    //attach aspides at parameters thay mey not have been rewritten
                    if (is_tainted_me) edit_node_generic(out, tree, NULL);
                    else untainted_edit_node_generic(out, tree, NULL);
                    //remove all aspides from each new parameter (cancel the last step)
                    //(easiest way out rather than figuring out where to remove aspides)
                    astp params = t->parameters[1];
                    if (params->type != T_NULL) {
                        astp params_list = params->parameters[0];
                        int param = 0;
                        for (param = 0; param < params_list->total_parameters; param++) {
                            if (is_tainted_me) {
                                if (params_list->parameters[param]->type == T_ARTIFICIAL && strcmp(params_list->parameters[param]->text, ",") == 0)
                                    dereference_aspis_from_parameter_wwarning(&(params_list->parameters[param]), 0);
                                else dereference_aspis_from_parameter_wwarning(&params_list, param);
                            } else {
                                if (params_list->parameters[param]->type == T_ARTIFICIAL && strcmp(params_list->parameters[param]->text, ",") == 0)
                                    attach_aspis_to_parameter_wwarning(&(params_list->parameters[param]), 0);
                                else attach_aspis_to_parameter_wwarning(&params_list, param);
                            }
                        }
                    }

                    //now create a proxy to this untainted object
                    astp temp = ast_new(T_NULL, NULL);
                    int i = 0;
                    for (i = 0; i < t->total_children; i++) ast_add_child(temp, t->children[i]);
                    ast_clear_children(t);
                    astp b;
                    if (is_tainted_me) b= ast_new(T_STRING_CONSTNAME, "true"); //wrong symbol name...
                    else b = ast_new(T_STRING_CONSTNAME, "false"); //wrong symbol name...
                    astp c = ast_new_wparam(T_ARTIFICIAL, ",", b);
                    astp par = ast_new_wparams(T_ARTIFICIAL, "(", ast_copy(t), c);
                    astp call = ast_new_wparam(T_STRING_FUNCTION, "AspisNewKnownProxy", par);
                    for (i = 0; i < t->total_children; i++) ast_add_child(call, temp->children[i]);

                    //and connect it to the general tree
                    *tree=call;
                    call->rewritten=1;
                    if (is_tainted_me) attach_aspis(tree); //the proxy still needs to be inside an Aspis
                    t->rewritten = 1;
                }
            }
        }
    }
}
/*
 * Clone needs to be applied to the operand's value and then, attach an Aspis to the result
 */
void rewrite_clone(astp *tree) {
    astp t=*tree;
    if (!t->rewritten) {
        if (t->parameters[0]->type==T_ARTIFICIAL && strcmp(t->parameters[0]->text,"(")==0) {
            dereference_aspis_from_parameter(&(t->parameters[0]),0);
        }
        else {
            dereference_aspis_from_parameter(tree,0);
        }
        attach_aspis(tree);
        t->rewritten=1;
    }
}
/*
 * empty() and isset() are overriden to check the Aspis and its content.
 * ie. empty($v) will become (empty($v) && Aspis_empty($v));
 * This is done to avoid errors at runtime caused in any other possible rewrite.
 */
void rewrite_construct(astp *tree) {
    astp t=*tree;
    if (!t->rewritten) {
        //keep in a temp value a possible trailing ; and all the node's children
        astp temp = ast_new(T_NULL, NULL);
        if (t->total_parameters > 0 && strcmp(t->parameters[t->total_parameters - 1]->text, ";") == 0) {
            ast_add_parameter(temp, t->parameters[t->total_parameters - 1]);
            ast_remove_parameter(t, t->total_parameters - 1);
        }
        int i = 0;
        for (i = 0; i < t->total_children; i++) {
            ast_add_child(temp, t->children[0]);
            ast_remove_child(t, 0);
        }

        //the actual job
        astp copy=ast_copy(t);
        rewrite_function_name(&copy,copy->total_parameters);
        //dereference_aspis_from_parameter(&(copy->parameters[0]),0);
        astp oper;
        if (strcmp(t->text,"isset")==0) oper=ast_new_wparams(T_BOOLEAN_AND,"&&",t,copy);
        else if (strcmp(t->text,"empty")==0) oper=ast_new_wparams(T_BOOLEAN_OR,"||",t,copy);
        else die("rewrite_construct only works with isset/empty");
        astp p=ast_new_wparam(T_ARTIFICIAL,"(",oper);
        attach_aspis(&p);
        *tree=p;

        //then copy back from temp to the new result
        if (temp->total_parameters == 1) ast_add_parameter(*tree, temp->parameters[0]);
        for (i = 0; i < temp->total_children; i++) {
            ast_add_child(*tree, temp->children[i]);
        }
    }
}
/*
 * Checks if the T_VARIABLE passed is a superglobal array. If so, it flips exists_superglobal
 */
void log_superglobal(astp *tree) {
    astp t=*tree;
    if (t->type==T_VARIABLE && 
            (strcmp(t->text,"$_SERVER")==0 ||
            strcmp(t->text,"$_GET")==0 ||
            strcmp(t->text,"$_POST")==0 ||
            strcmp(t->text,"$_FILES")==0 ||
            strcmp(t->text,"$_REQUEST")==0 ||
            strcmp(t->text,"$_COOKIE")==0 ||
            strcmp(t->text,"$_ENV")==0 )) exists_superglobal=1;
}
/*
 * This stores to the file function_prototypes, the prototype of the passed function
 */
void store_function_prototype(astp *tree) {
    astp t=*tree;
    if (prototypes_log_filename!=NULL && COLLECT_INFO) {
        FILE * fp=fopen(prototypes_log_filename,"a");
        if (is_method_declaration) fprintf(fp, "method ");
        fprintf(fp,"%s ( ",t->parameters[1]->text);
        
        astp p = t->parameters[2];
        if (p->type != T_NULL) {
            if (p->type==T_REF) fprintf(fp, "array &param");
            else fprintf(fp, "array param");
            int i=0;
            for (i=0;i<p->total_parameters;i++) {
                if (p->parameters[i]->type == T_ARTIFICIAL && strcmp(p->parameters[i]->text, ",") == 0) {
                    astp q = p->parameters[i]->parameters[0];
                    fprintf(fp, ", ");
                    if (q->type == T_REF || (q->type==T_ARTIFICIAL && strcmp(q->text,"=")==0 && q->parameters[0]->type==T_REF)) {
                        fprintf(fp, "array &param");
                    } else fprintf(fp, "array param");
                }
            }
        } 
        fprintf(fp," )\nAspis generated prototype (");
        if (t->parameters[0]->type==T_REF) fprintf(fp,"&array)\n");
        else fprintf(fp,"array)\n");
        fclose(fp);
    }

}
/*
 * This function stores a copy of the original version of the function, before editing
 */
astp original_function;
void store_tainted_function(astp *tree) {
    astp t=*tree;
    is_tainted=is_tainted_function(t->parameters[1]->text) || is_tainted_cl;

    astp tmp = ast_new(T_NULL, NULL);
    int i = 0;
    for (i = 0; i < t->total_children; i++) {
        ast_add_child(tmp, t->children[i]);
    }
    ast_clear_children(t);
    original_function=ast_copy(t); //just the function, no kids
    for (i=0;i<tmp->total_children;i++) {
            ast_add_child(t,tmp->children[i]);
    }
}
/*
 * This is is reposnible for logging info about taints. It adds statements in the
 * begining of the function. it also switches to edited_bfs processing of trees,
 * in case that the function definition is untainted.
 */
void rewrite_function_definition(FILE * out,astp *tree) {
    astp t=*tree;
    store_function_prototype(tree);
    if ( ( is_partial_enabled && is_method_declaration && !is_tainted_cl) ||
            (is_partial_enabled && !is_tainted_function(t->parameters[1]->text) && !is_tainted_cl && !is_method_declaration)
            ) {
        //turn off taint tracking

        imported_globals=ast_new(T_NULL,NULL);
        imported_globals_index=0;
        ast_untainted_edit_bfs(out,&original_function);
        //untainted_rewrite_function_definition(&original_function);

        //store children to the new tree
        int i=0;
        for (i=0;i<t->total_children;i++) {
            ast_add_child(original_function,t->children[i]);
        }
        *tree=original_function;
        return;
    }
    char *stmt=NULL;
    if (COLLECT_INFO) {
        stmt="foreach (func_get_args() as $aspisParam) AspisLogParameter($aspisParam);\n";
    }
    if (COLLECT_INFO && exists_superglobal) {
        char * tmp="AspisLogIntroduce();\n";
        if (stmt==NULL) stmt=tmp;
        else stmt=strcat_malloc(stmt,tmp);
    }
    if (stmt!=NULL) {
        astp s=ast_new_wparam(T_STATEMENT_OPAQUE,stmt,t->parameters[3]);
        t->parameters[3]=s;
        s->rewritten=1;
    }
}
/*
 * This switches to edited_bfs processing of trees,
 * in case that the class is untainted.
 */
int rewrite_class_definition(FILE * out,astp *tree) {
    astp t=*tree;
    astp original_class;
    int paramsnum=0;
    if (t->parameters[0]->parameters[0]->type==T_STRING_CLASSNAME) paramsnum=0;
    else paramsnum=1;
    is_tainted_cl=is_tainted_class(t->parameters[0]->parameters[paramsnum]->text);
    if (!is_partial_enabled || is_tainted_cl) {
        printf("CLASS IS GETTING REWRITTEN!\n");
        return 0;
    }
    printf("CLASS IS NOT GETTING REWRITTEN!\n");
    int is_tainted_tmp=is_tainted;
    is_tainted=0; //that's because the class' rewritting is independant of the current function's taint
    //limit the untainted rewriting to this class by removed all its kids
    astp tmp = ast_new(T_NULL, NULL);
    int i = 0;
    for (i = 0; i < t->total_children; i++) {
        ast_add_child(tmp, t->children[i]);
    }
    ast_clear_children(t);
    
    ast_untainted_edit_bfs(out, tree);

    //now put the kids back
    for (i=0;i<tmp->total_children;i++) {
            ast_add_child(t,tmp->children[i]);
    }
    is_tainted=is_tainted_tmp;
    return 1;
}
/*
 * This calls FixGlobal() to every global imported to an untainted scope.
 * It also assigns the return value to an internal $AspisVarX variable that with
 * then be used to restore the tainted version of the variable.
 * TODO: if the global var is defined with the use of function calls and calling the function
 * twice produces sideffects, this will not work.
 */
void both_rewrite_global(astp *tree,char * function) {
    astp t=*tree;
    //imported_globals can be null when global is in the global scope. No need to do anything
    if (t->rewritten || imported_globals==NULL) return;
    t->rewritten=1;
    astp vars = ast_copy(t->parameters[0]);
    //the first, always existing, element
    ast_clear_children(vars);
    astp var1=vars;
    ast_add_parameter(imported_globals,ast_copy(var1));
    char n[10];
    sprintf(n,"%d",imported_globals_index);
    char* str=strcat_malloc("$AspisVar",n);
    astp nvar=ast_new(T_VARIABLE,str);
    char * var_name=strcat_malloc("\"\\",var1->parameters[0]->text);
    var_name=strcat_malloc(var_name,"\"");
    globals_aliases[imported_globals_index]=strcpy_malloc(var_name);
    astp var2=ast_new_wparam(T_ARTIFICIAL,",",ast_new(T_CONSTANT_ENCAPSED_STRING,var_name));
    astp comma=ast_new_wparam(T_ARTIFICIAL,",",ast_new(T_VARIABLE,"$AspisChangesCache"));
    astp p = ast_new_w3params(T_ARTIFICIAL, "(", var1,var2,comma);
    astp e = ast_new(T_ARTIFICIAL, ";");
    astp c = ast_new_wparams(T_STRING_METHOD, function, p, e);
    c=ast_new_wparam(T_REF,"&",c);
    c=ast_new_wparams(T_ARTIFICIAL,"=",nvar,c);
    //ast_add_parameter(t,c);
    astp res = ast_new_wparams(T_ARTIFICIAL, "{", t, c);
    imported_globals_index++;
    //the rest possible elements
    vars = ast_copy(t->parameters[0]);
    int i = 0;
    for (i = 0; i < vars->total_children; i++) {
        astp var=ast_copy(vars->children[i]->parameters[0]); //after the comma
        ast_add_parameter(imported_globals,ast_copy(var));
        sprintf(n,"%d",imported_globals_index);
        str=strcat_malloc("$AspisVar",n);
        nvar=ast_new(T_VARIABLE,str);
        char * var_n=strcat_malloc("\"\\",var->text);
        var_n = strcat_malloc(var_n, "\"");
        globals_aliases[imported_globals_index]=strcpy_malloc(var_n);
        astp var_p = ast_new_wparam(T_ARTIFICIAL, ",", ast_new(T_CONSTANT_ENCAPSED_STRING, var_n));
        astp comma2=ast_new_wparam(T_ARTIFICIAL,",",ast_new(T_VARIABLE,"$AspisChangesCache"));
        p = ast_new_w3params(T_ARTIFICIAL, "(", var,var_p,comma2);
        e = ast_new(T_ARTIFICIAL, ";");
        c = ast_new_wparams(T_STRING_METHOD, function, p, e);
        c=ast_new_wparam(T_REF,"&",c);
        c=ast_new_wparams(T_ARTIFICIAL,"=",nvar,c);
        ast_add_parameter(res,c);
        imported_globals_index++;
    }
    //put the children of the old "globals" under {
    for (i = 0; i < t->total_children; i++) {
        ast_add_child(res, t->children[i]);
    }
    ast_clear_children(t);
    *tree = res;
}
/*
 * When logging is on, this rewrite global statements to call AspisLogGlobal
 * When partial is on, global variables need to be chechek/tainted as in the untainted case
 */
void rewrite_global(astp *tree) {
    astp t=*tree;
    if (COLLECT_INFO) {
        astp vars=ast_copy(t->parameters[0]);
        astp p=ast_new_wparam(T_ARTIFICIAL,"(",vars);
        astp e=ast_new(T_ARTIFICIAL,";");
        astp c=ast_new_wparams(T_STRING_METHOD,"AspisLogGlobals",p,e);
        //ast_add_parameter(t,c);
        astp r=ast_new_wparams(T_ARTIFICIAL,"{",t,c);
        int i=0;
        for (i=0;i<t->total_children;i++) {
            ast_add_child(r,t->children[i]);
        }
        ast_clear_children(t);
        *tree=r;
    }
    else if (is_partial_enabled) {
        if (is_global_scope_untainted) both_rewrite_global(tree,"AspisTaintUntaintedGlobalUntainted");
        else both_rewrite_global(tree,"AspisTaintUntaintedGlobal");
    }
    
}
/*
 * Replaces aspisdummy calls with AspisReferenceMethodCall
 * * NOTE: this function is also used for untainted rewritting!
 */
void rewrite_method_call(astp *tree) {
    astp t=*tree;
    astp temp=ast_new(T_NULL,NULL);
    int i;
    for (i=0;i<t->total_children;i++) ast_add_child(temp,t->children[i]);
    ast_clear_children(t);

    astp first_arrow=t->parameters[t->total_parameters-1];
    ast_remove_parameter(t,t->total_parameters-1);

    astp function=first_arrow->parameters[0];
    astp second_arrow=NULL;
    if (function->total_parameters>0) second_arrow=function->parameters[function->total_parameters-1];
    if (second_arrow==NULL || second_arrow->type!=T_OBJECT_OPERATOR) second_arrow=NULL;
    if (second_arrow!=NULL) ast_remove_parameter(function,function->total_parameters-1);
/*
    printf("t:");
    ast_print_bfs(stdout,t);
    printf("\n");
    printf("function %d:",function->total_children);
    ast_print_bfs(stdout,function);
    printf("\n");
    if (second_arrow!=NULL) {
        printf("second arrow:");
        ast_print_bfs(stdout,second_arrow);
        printf("\n");
    }
    fflush(stdout);
*/
    astp parameters;
    if (function->total_children!=0) {
        parameters=function->children[function->total_children-1];
        ast_clear_children(function);
    }
    else {
        parameters=function->parameters[function->total_parameters-1];
        ast_remove_parameter(function,function->total_parameters-1);
    }
    astp n;
    if (strcmp(t->text,"aspisdummy")!=0) n=ast_new_wparam(T_NULL,NULL,t);
    else n=ast_new_wparam(T_NULL,NULL,t->parameters[0]->parameters[0]);
    astp p=ast_new_wparam(T_ARTIFICIAL,"(",n);
    char *method=function->text;
    if (function->type==T_STRING_METHOD) {
        function->type=T_CONSTANT_ENCAPSED_STRING;
        function->text=strcat_malloc("\"",function->text);
        function->text=strcat_malloc(function->text,"\"");
    }
    astp c=ast_new_wparam(T_ARTIFICIAL,",",function);
    ast_add_parameter(p,c);
    //now fix the parameters
    printf("parameters: {");
    ast_print_bfs(stdout,parameters);
    printf("}\n");
    fflush(stdout);
    astp tnull = parameters->parameters[0];
    int findex = prototypes_find(user_methods_prototypes, user_methods_prototypes_count, method);
    //iterate through all parameters, act accordingly
    int ref_params[10]; //stores indexes of the call's ref parameters
    int ref_params_index=0;
    for (i = 0; i < tnull->total_parameters; i++) {
        char * type;
        type = prototype_parameter_type(user_methods_prototypes, user_methods_prototypes_count, method, i, tnull->total_parameters);
        astp pa = tnull->parameters[i];

        //subsequent param
        if (pa->type == T_ARTIFICIAL && strcmp(pa->text, ",") == 0) {
            astp q = pa->parameters[0];
            if (findex != -1 && is_ref(type)) {
                ref_params[ref_params_index++] = i; //write this down
                astp t1 = ast_new_wparam(T_ARTIFICIAL, "(", q);
                q = ast_new_wparam(T_STRING_FUNCTION, "AspisPushRefParam", t1);
                q->rewritten = 1;
            }
            pa->parameters[0] = q;
        } else { //first param
            if (findex != -1 && is_ref(type)) {
                ref_params[ref_params_index++] = i; //write this down
                astp t1 = ast_new_wparam(T_ARTIFICIAL, "(", pa);
                pa = ast_new_wparam(T_STRING_FUNCTION, "AspisPushRefParam", t1);
                pa->rewritten = 1;
            }
        }
        tnull->parameters[i] = pa;
    }
    //add the parameters to the result
    astp a=ast_new_wparam(T_ARRAY,"array",parameters);
    c=ast_new_wparam(T_ARTIFICIAL,",",a);
    ast_add_parameter(p,c);

    //now add the taint indexes to the result
    astp tp = ast_new(T_ARTIFICIAL, "(");
    int j = 0;
    for (j = 0; j < ref_params_index; j++) {
        char* num = (char*) malloc(5 * sizeof (char));
        sprintf(num, "%d", ref_params[j]);
        astp t = ast_new(T_DNUMBER, num);
        if (j == 0) {
            ast_add_parameter(tp, t);
        } else {
            astp tt = ast_new_wparam(T_ARTIFICIAL, ",", t);
            ast_add_parameter(tp, tt);
        }
    }
    astp param_taints = ast_new_wparam(T_ARRAY, "array", tp);
    c=ast_new_wparam(T_ARTIFICIAL,",",param_taints);
    ast_add_parameter(p,c);

    astp result=ast_new_wparam(T_STRING_FUNCTION,"AspisReferenceMethodCall",p);
    *tree=result;
}
/*
 * if partial taint tracking is on, all method calls with ref parameters must be
 * rewritten. That s because the proxy objexts cannot propagate references.
 * Rewritting uses the AspisReferenceMethodCall helper function at runtime.
 * NOTE: this function is also used for untainted rewritting!
 */
void rewrite_variable_method_call(astp *tree) {
    astp t=*tree;
    if (!is_online) printf("rewrite_variable_method_call on (%s)\n",t->text);
    if (strcmp(t->text,"deAspis")==0) {
        //this means that we have a chained call -rewrite the subcall
        rewrite_variable_method_call(&(t->parameters[0]->parameters[0]->parameters[0]));
        //but continue with the current call
    }
    else if (strcmp(t->text,"aspisdummy")==0) {
        printf("variable_method call:");
        ast_print_bfs(stdout,t);
        printf("\n");                             //paren         t_null         next function
        rewrite_variable_method_call(&(t->parameters[0]->parameters[0]->parameters[0]));
    }
    if (t->total_parameters==0) {
        if (!is_online) printf("no parameters found at all \n");
        return ;
    }
    astp lastp=t->parameters[t->total_parameters-1];
    astp afterlastp=NULL;
    if (lastp->total_parameters>0) afterlastp=lastp->parameters[lastp->total_parameters-1];
    else {
        if (!is_online)  printf("no parameters found after: (%s)\n",lastp->text);
        return ;
    }
    if (lastp->type==T_OBJECT_OPERATOR && strcmp(t->text,"$this")!=0 && lastp->parameters[0]->type==T_STRING_METHOD) {
        int i;
        int exists_ref=prototype_has_ref_param(user_methods_prototypes,user_methods_prototypes_count,lastp->parameters[0]->text) 
             || is_ref(prototype_return_type(user_methods_prototypes,user_methods_prototypes_count,lastp->parameters[0]->text));
        if (exists_ref) rewrite_method_call(tree);
        
        if (!is_online) {
            printf("Its a method call! : (%d)(%s)\n", lastp->total_parameters, lastp->text);
            ast_print_bfs(stdout, t);
            printf("\n");
        }
    }
    else {
        if (!is_online) {
            printf("not an object operator?: (%d)(%s)\n", lastp->type, lastp->text);
            ast_print_bfs(stdout, t);
            printf("\n");
        }
    }
}
/*
 * When the tag <?= ?> is used, it means that I have to remove the Aspis
 * from the NEXT statement (unfortunately, the parsers handles the tag
 * as a statement) and check the taint of the expression.
 */
void rewrite_equals_tag(astp *tree) {
    astp t=*tree;
    if (t->total_children>0 && t->children[0]->total_children>0) {
        astp next=t->children[0];
        int pcount=next->total_parameters;
        //remove the trailing ; as the statement will be placed in CheckPrint()
        //and CheckPrint($a;) is not acceptable
        if (pcount>0 && next->parameters[pcount-1]->type==T_ARTIFICIAL &&
                strcmp(next->parameters[pcount-1]->text,";")==0) {
            ast_remove_parameter(next,pcount-1);
        }
        
        astp after_next=t->children[0]->children[0];
        ast_clear_children(next);
        astp p = ast_new_wparam(T_ARTIFICIAL, "(", t->children[0]);
        astp f = ast_new_wparam(T_STRING_FUNCTION, "AspisCheckPrint", p);
        t->children[0]=f;
        
        ast_add_child(t->children[0],after_next);
    }
}

//**********Rewriting of the untainted version of functions*****************/
long int current_param_index=0;
void both_returns_by_ref(astp * tree) {
    astp t = *tree;
    if (t->total_parameters>0) {
        astp ref = t->parameters[0];
        if (ref->type == T_REF) returns_by_ref = 1;
        else returns_by_ref = 0;
    } else returns_by_ref = 0;
}
/*
 * Attach the prefix AspisUntainted to every function call in functions_overriden_partial_list
 */
void untainted_rewrite_function_name(astp * tree,int total_parameters) {
    astp t=*tree;
    if (list_search(functions_list,0,functions_count,functions_count,t->text)!=-1) {
        save_function_name(t->text);
    }
    if ( list_search(functions_overriden_partial_list, 0, functions_overriden_partial_count,
                    functions_overriden_partial_count, t->text) != -1) {
        t->text = strcat_malloc("AspisUntainted_", t->text);
    }
}
/*
 * All function calls in untainted context have to fix their imported variables
 * from global scope. This means global $x; f($p); will become
 * AspisReflect(2, $param=&$p; restore($x), f($param) ,$clean($x) )
 * where 2 marks the position of the actual function call.
 * Dummy variables are used because $x will become unusable after restore($x)
 */
void untainted_fix_function_wglobals(astp *tree) {
    die("DIED: \"untainted_fix_function_wglobals\" not used any more\n");
    astp t=*tree;
    int library_call=list_search(functions_list,0,functions_count,functions_count,t->text)!=-1;
    int push_call=strcmp(t->text,"AspisPushRefParam")==0;
    if (!t->rewritten && imported_globals_index>0 && !library_call && !push_call) {
        astp fparams=t->parameters[0]->parameters[0];
        int total_parameters=fparams->total_parameters;
        
        //add a call to AspisDummy
        astp n=ast_new(T_NULL,NULL);
        astp p=ast_new_wparam(T_ARTIFICIAL,"(",n);
        astp f=ast_new_wparam(T_STRING_FUNCTION,"AspisReflect",p);
        int i=0;
        for (i=0;i<t->total_children;i++) {
            ast_add_child(f,t->children[i]);
        }
        ast_clear_children(t);
        //let AspisDummy now the position of the actual parameter
        char *findex=(char*)malloc(4*sizeof(char));
        sprintf(findex,"%d",imported_globals_index+total_parameters+1);
        astp number=ast_new(T_DNUMBER,findex);
        ast_add_parameter(n,number);

        //first the copies of the function's parameters (before taints are added)
        for (i=0;i<fparams->total_parameters;i++) {
            astp * fparam_pp=&(fparams->parameters[i]);
            astp fparam=*fparam_pp;
            if (fparam->type==T_ARTIFICIAL && strcmp(fparam->text,",")==0) {
                fparam_pp=&(fparam->parameters[0]);
                fparam=fparam->parameters[0];
            }
            //left op
            char *index=(char*)malloc(4*sizeof(char));
            sprintf(index,"%ld",current_param_index++);
            char *var=strcat_malloc("$AspisParam",index);
            astp left=ast_new(T_VARIABLE,strcpy_malloc(var));
            //right op
            astp fp;
            if (fparam->type==T_VARIABLE && !is_method_call(fparam)) {
                fp=ast_new_wparam(T_REF,"&",ast_copy(fparam));
            }
            else fp = ast_copy(fparam);
            astp attach=ast_new_wparams(T_ARTIFICIAL,"=",left,fp);
            attach=ast_new_wparam(T_ARTIFICIAL,",",attach);
            ast_add_parameter(n,attach);
            //but don't forget to repace the original expression with the new variable
            *fparam_pp=ast_new(T_VARIABLE,strcpy_malloc(var));
            fp->rewritten=1;
        }
        //then calls to RestoreTaintGlobal
        for (i=0;i<imported_globals_index;i++) {
            //left op
            char *index=(char*)malloc(4*sizeof(char));
            sprintf(index,"%d",i);
            char *var=strcat_malloc("$AspisVar",index);
            astp left=ast_new(T_VARIABLE,strcpy_malloc(var));

            //right op
            astp rp=ast_new(T_VARIABLE,strcpy_malloc(var));
            astp pp=ast_new_wparam(T_ARTIFICIAL,"(",rp);
            astp fp=ast_new_wparam(T_STRING_FUNCTION,"AspisRestoreTaintedGlobal",pp);
            astp attach=fp;//ast_new_wparams(T_ARTIFICIAL,"=",left,fp);

            attach=ast_new_wparam(T_ARTIFICIAL,",",attach);
            ast_add_parameter(n,attach);

            fp->rewritten=1;
        }
        //then the actual function call 
        astp ppp=ast_new_wparam(T_ARTIFICIAL,",",t);
        ast_add_parameter(n,ppp);

        //then calls to CleanTaintedGlobal
        for (i=0;i<imported_globals_index;i++) {
            //left op
            char *index=(char*)malloc(4*sizeof(char));
            sprintf(index,"%d",i);
            char *var=strcat_malloc("$AspisVar",index);
            astp left=ast_new(T_VARIABLE,strcpy_malloc(var));
            //right op
            astp rp=ast_new(T_VARIABLE,strcpy_malloc(var));
            astp pp=ast_new_wparam(T_ARTIFICIAL,"(",rp);
            astp fp=ast_new_wparam(T_STRING_FUNCTION,"AspisCleanTaintedGlobal",pp);
            astp attach=fp;//ast_new_wparams(T_ARTIFICIAL,"=",left,fp);
            attach=ast_new_wparam(T_ARTIFICIAL,",",attach);
            ast_add_parameter(n,attach);
            fp->rewritten=1;
        }
        f->rewritten=1;
        t->rewritten=1;
        *tree=f;
    }
}
/*
 * Similar to untainted_fix_funxtion_wglobals, but applied to require/include
 * (they have different trees)
 */
void untainted_rewrite_require(astp *tree) {
    astp t=*tree;
    if (!t->rewritten && imported_globals_index>0 && !is_global_scope_untainted) {
        astp fparam=t->parameters[0];

        //add a call to AspisDummy
        astp n=ast_new(T_NULL,NULL);
        astp p=ast_new_wparam(T_ARTIFICIAL,"(",n);
        astp f=ast_new_wparam(T_STRING_FUNCTION,"AspisReflect",p);
        int i=0;
        for (i=0;i<t->total_children;i++) {
            ast_add_child(f,t->children[i]);
        }
        ast_clear_children(t);

        //let AspisDummy now the position of the actual parameter
        char *findex=(char*)malloc(4*sizeof(char));
        sprintf(findex,"%d",imported_globals_index+1+1);
        astp number=ast_new(T_DNUMBER,findex);
        ast_add_parameter(n,number);

        //first the copies of the function's parameter (before taints are added)
        //left op
        char *index = (char*) malloc(4 * sizeof (char));
        sprintf(index, "%ld", current_param_index++);
        char *var = strcat_malloc("$AspisParam", index);
        astp left = ast_new(T_VARIABLE, strcpy_malloc(var));
        //right op
        astp fp = ast_copy(fparam);
        astp attach = ast_new_wparams(T_ARTIFICIAL, "=", left, fp);
        attach = ast_new_wparam(T_ARTIFICIAL, ",", attach);
        ast_add_parameter(n, attach);
        //but don't forget to repace the original expression with the new variable
        t->parameters[0] = ast_new(T_VARIABLE, strcpy_malloc(var));
        fp->rewritten = 1;
            
        //then calls to RestoreTaintGlobal
        for (i=0;i<imported_globals_index;i++) {
            //left op
            char *index=(char*)malloc(4*sizeof(char));
            sprintf(index,"%d",i);
            char *var=strcat_malloc("$AspisVar",index);
            astp left=ast_new(T_VARIABLE,strcpy_malloc(var));

            //right op
            astp rp=ast_new(T_VARIABLE,strcpy_malloc(var));
            astp varname=ast_new(T_CONSTANT_ENCAPSED_STRING,globals_aliases[i]);
            varname->rewritten=1;
            astp comma1=ast_new_wparam(T_ARTIFICIAL,",",varname);
            astp comma2=ast_new_wparam(T_ARTIFICIAL,",",ast_new(T_VARIABLE,"$AspisChangesCache"));
            
            astp pp=ast_new_w3params(T_ARTIFICIAL,"(",rp,comma1,comma2);
            astp fp=ast_new_wparam(T_STRING_FUNCTION,"AspisRestoreTaintedGlobal",pp);
            astp attach=fp;//ast_new_wparams(T_ARTIFICIAL,"=",left,fp);

            attach=ast_new_wparam(T_ARTIFICIAL,",",attach);
            ast_add_parameter(n,attach);

            fp->rewritten=1;
        }
        //then the actual function call
        astp ppp=ast_new_wparam(T_ARTIFICIAL,",",t);
        ast_add_parameter(n,ppp);

        //then calls to CleanTaintedGlobal
        for (i=0;i<imported_globals_index;i++) {
            //left op
            char *index=(char*)malloc(4*sizeof(char));
            sprintf(index,"%d",i);
            char *var=strcat_malloc("$AspisVar",index);
            astp left=ast_new(T_VARIABLE,strcpy_malloc(var));
            //right op
            astp rp=ast_new(T_VARIABLE,strcpy_malloc(var));
            astp varname=ast_new(T_CONSTANT_ENCAPSED_STRING,globals_aliases[i]);
            varname->rewritten=1;
            astp comma1=ast_new_wparam(T_ARTIFICIAL,",",varname);
            astp comma2=ast_new_wparam(T_ARTIFICIAL,",",ast_new(T_VARIABLE,"$AspisChangesCache"));
            astp pp=ast_new_w3params(T_ARTIFICIAL,"(",rp,comma1,comma2);
            astp fp=ast_new_wparam(T_STRING_FUNCTION,"AspisCleanTaintedGlobal",pp);
            astp attach=fp;//ast_new_wparams(T_ARTIFICIAL,"=",left,fp);
            attach=ast_new_wparam(T_ARTIFICIAL,",",attach);
            ast_add_parameter(n,attach);
            fp->rewritten=1;
        }
        f->rewritten=1;
        t->rewritten=1;
        *tree=f;
    }
}
/*
 * Add a parenthesis around the first argument. This fixes a bug notice from the
 * zend engine when the first argument comes from a proxy (aka overloaded method)
 */
void untainted_rewrite_extract(astp *tree) {
    astp t=*tree;
    astp null=t->parameters[0]->parameters[0];
    null->parameters[0]=ast_new_wparam(T_ARTIFICIAL,"(",null->parameters[0]);
}

void remove_references_reqursively(astp *tree) {
    astp t=*tree;
    if (t->type==T_REF) {
        *tree=t->parameters[0];
        ast_remove_parameter(t,0);
        int i;
        for (i=0;i<t->total_parameters;i++) ast_add_parameter(*tree,t->parameters[i]);
        for (i=0;i<t->total_children;i++) ast_add_child(*tree,t->children[i]);
    }
    t=*tree;
    int i=0;
    for (i=0;i<t->total_parameters;i++) remove_references_reqursively(&(t->parameters[i]));
    for (i=0;i<t->total_children;i++) remove_references_reqursively(&(t->children[i]));
}
/*
 * If a function expects non-ref parameters (according to it) prototype, kill
 * all call time references created at the function call.
 * ie function f($a), when called as f(&$o) will be rewritten as $f($o)
 * I am doing this as this normally happens due to PHP4's object handling
 */
void untainted_remove_ref_objects(astp *tree) {
    astp t=*tree;
    astp tnull;
    int i;
    int findex=-1;
    if (!t->rewritten) {
        int total_params=0;
        if (t!=NULL && t->total_parameters>0 && t->parameters[0]->total_parameters>0) {
            total_params=t->parameters[0]->parameters[0]->total_parameters;
        }
        int untainted_calls_untainted=(!is_tainted_function(t->text) && !COLLECT_INFO);
        if (untainted_calls_untainted) {
            if (!is_language_construct) {
                //dereference aspides from each parameter
                tnull = t->parameters[0]->parameters[0];
                findex = prototypes_find(user_functions_prototypes, user_functions_prototypes_count, t->text);
                //iterate through all parameters, act accordingly
                for (i = 0; i < tnull->total_parameters; i++) {
                    char * type;
                    type = prototype_parameter_type(user_functions_prototypes, user_functions_prototypes_count, t->text, i, tnull->total_parameters);
                    astp p = tnull->parameters[i];

                    //subsequent param
                    if (p->type == T_ARTIFICIAL && strcmp(p->text, ",") == 0) {
                        astp q = p->parameters[0];
                        if (findex != -1 && !is_ref(type)) {
                            remove_references_reqursively(&q);
                            q->rewritten = 1;
                        }
                        p->parameters[0] = q;
                    } else { //first param
                        if (findex != -1 && !is_ref(type)) {
                            remove_references_reqursively(&p);
                            p->rewritten = 1;
                        }
                    }
                    tnull->parameters[i] = p;
                }
            }
        }
    }
}
/*
 * The opposite of the old rewrite_function_call: adds taints to parameters and
 * kills its from the return value.
 */
void untainted_rewrite_function_call(astp * tree) {
    int fixed_globals=0;
    astp t=*tree;
    int ref_params[10]; //stores indexes of the call's ref parameters
    int ref_params_index=0;
    astp tnull;
    int i;
    int findex=-1;
    if (!t->rewritten) {
        int total_params=0;
        if (t!=NULL && t->total_parameters>0 && t->parameters[0]->total_parameters>0) {
            total_params=t->parameters[0]->parameters[0]->total_parameters;
        }
        untainted_rewrite_function_name(tree,total_params); //the rewritten name will never match the following
        int untainted_calls_tainted=(is_tainted_function(t->text) && !COLLECT_INFO);
        int untainted_calls_untainted=(!is_tainted_function(t->text) && !COLLECT_INFO);
        if (untainted_calls_tainted) {
            if (!is_language_construct) {
                //dereference aspides from each parameter
                tnull = t->parameters[0]->parameters[0];
                findex = prototypes_find(user_functions_prototypes, user_functions_prototypes_count, t->text);
                //iterate through all parameters, act accordingly
                for (i = 0; i < tnull->total_parameters; i++) {
                    char * type;
                    type = prototype_parameter_type(user_functions_prototypes, user_functions_prototypes_count, t->text, i, tnull->total_parameters);
                    astp p = tnull->parameters[i];

                    //subsequent param
                    if (p->type == T_ARTIFICIAL && strcmp(p->text, ",") == 0) {
                        astp q = p->parameters[0];
                        if (findex != -1 && is_ref(type)) {
                            ref_params[ref_params_index++] = i; //write this down
                            astp t1 = ast_new_wparam(T_ARTIFICIAL, "(", q);
                            q = ast_new_wparam(T_STRING_FUNCTION, "AspisPushRefParam", t1);
                            q->rewritten = 1;
                        }  else {
                            attach_aspis_wwarning_wtype(&q, type);
                        }
                        p->parameters[0] = q;
                    } else { //first param
                        if (findex != -1 && is_ref(type)) {
                            ref_params[ref_params_index++] = i; //write this down
                            astp t1 = ast_new_wparam(T_ARTIFICIAL, "(", p);
                            p = ast_new_wparam(T_STRING_FUNCTION, "AspisPushRefParam", t1);
                            p->rewritten = 1;
                        } 
                        else attach_aspis_wwarning_wtype(&p, type);
                    }
                    tnull->parameters[i] = p;
                }
            }
            
            //attach an aspis to the result
            //lets move all children of the function call to the aspis, plus
            //a potential ; that ends the statement
            astp temp = ast_new(T_NULL, "");
            if (t->total_parameters > 0 && strcmp(t->parameters[t->total_parameters - 1]->text, ";") == 0) {
                ast_add_parameter(temp, t->parameters[t->total_parameters - 1]);
                ast_remove_parameter(t, t->total_parameters - 1);
            }
            i = 0;
            for (i = 0; i < t->total_children; i++) {
                ast_add_child(temp, t->children[0]);
                ast_remove_child(t, 0);
            }
            //how should I handle the return value?
            if (findex==-1) {
/*
                untainted_fix_function_wglobals(tree);
*/
                fixed_globals=1;
                attach_aspis(tree); //TODO: this should NEVER happen...
            }
            else if(ref_params_index!=0) {
                //there are ref params, I need a call to AspisInternalFunctionCall
                astp tp=ast_new(T_ARTIFICIAL,"(");
                int j=0;
                for (j=0;j<ref_params_index;j++) {
                    char* num=(char*)malloc(5*sizeof(char));
                    sprintf(num, "%d", ref_params[j]);
                    astp t=ast_new(T_DNUMBER,num);
                    if (j==0) {
                        ast_add_parameter(tp,t);
                    }
                    else {
                        astp tt=ast_new_wparam(T_ARTIFICIAL,",",t);
                        ast_add_parameter(tp,tt);
                    }
                }
                astp param3=ast_new_wparam(T_ARRAY,"array",tp);
                astp param2=tnull;
                astp p=ast_new(T_CONSTANT_ENCAPSED_STRING,strcpy_malloc(t->text));
                astp param1=ast_new_wparam(T_ARTIFICIAL,"\"",p);
                astp null=ast_new_wparam(T_NULL,NULL,param1);
                p=ast_new_wparam(T_ARTIFICIAL,"(",null);
                astp c=ast_new_wparam(T_ARTIFICIAL,",",param2);
                ast_add_parameter(null,c);
                c=ast_new_wparam(T_ARTIFICIAL,",",param3);
                ast_add_parameter(null,c);
                astp newf;
                newf=ast_new_wparam(T_STRING_FUNCTION,"AspisTaintedFunctionCall",p);
                *tree=newf;
            }
            else {
                fixed_globals=1;
                char * rettype=prototype_return_type(user_functions_prototypes, user_functions_prototypes_count, t->text);
                dereference_aspis_wwarning_wtype(tree,rettype);
            }
            if (temp->total_parameters == 1) ast_add_parameter(*tree, temp->parameters[0]);
            for (i = 0; i < temp->total_children; i++) {
                ast_add_child(*tree, temp->children[i]);
            }
        }
        else if (strcmp(t->text,"extract")==0) {
            untainted_rewrite_extract(tree);
        }
        else if (untainted_calls_untainted) {
            untainted_remove_ref_objects(tree);
        }
        t->rewritten=1;
    }
}
/*
 * Assignments by ref that are followed my calls to AspisReflect are merged.
 */
void untainted_rewrite_assignment_byref(astp *tree) {
    astp t=*tree;
    if (t->total_parameters>=2 && t->parameters[1]->type==T_REF &&
            t->parameters[1]->parameters[0]->type==T_STRING_FUNCTION &&
            strcmp(t->parameters[1]->parameters[0]->text,"AspisReflect")==0) {
        astp f=t->parameters[1]->parameters[0];

        //store teh echildren
        astp tmp=ast_new(T_NULL,NULL);
        int i=0;
        for (i=0;i<t->total_children;i++) ast_add_child(tmp,t->children[i]);
        ast_clear_children(t);

        //i need to locate the parameter that containts the actuall function call
        astp num=f->parameters[0]->parameters[0]->parameters[0];
        if (num->type!=T_DNUMBER) die("The first arg of Reflect should have been a number.");
        sscanf(num->text,"%d",&i);
        astp nv=ast_copy(t->parameters[0]);
        astp nr=ast_new_wparam(T_REF,"&",f->parameters[0]->parameters[0]->parameters[i]->parameters[0]);
        astp ne=ast_new_wparams(T_ARTIFICIAL,"=",nv, nr);
        f->parameters[0]->parameters[0]->parameters[i]->parameters[0]=ne;

        //restore children;
        for (i=0;i<t->total_children;i++) ast_add_child(f,tmp->children[i]);

        *tree=f;
    }
}
/*
 * This calls FixGlobal() to every global imported to an untainted scope.
 * It also assigns the return value to an internal $AspisVarX variable that with
 * then be used to restore the tainted version of the variable.
 * TODO: if the global var is defined with the use of function calls and calling the function
 * twice produces sideffects, this will not work.
 */
void untainted_rewrite_global(astp *tree) {
    if (!is_global_scope_untainted) both_rewrite_global(tree,"AspisCleanTaintedGlobal");
    else both_rewrite_global(tree,"AspisCleanTaintedGlobalUntainted");
}
/*
 * 1. Stores to $AspisRetTemp the result
 * 2. Calls RestoreTaintedGlobal for every global imported (using $AspisVarX nicknames)
 * 3. Calls return with $AspisRetTemp
 */
void both_rewrite_return(astp *tree,char * function) {
    astp t=*tree;
    if (!is_partial_enabled && imported_globals_index==0 || t->rewritten || t->total_parameters==0) return;
    int returns_value=1;
    if (t->parameters[0]->type==T_ARTIFICIAL && strcmp(t->parameters[0]->text,";")==0) {
        returns_value=0;
    }
    
    astp res = ast_new(T_ARTIFICIAL, "{");
    //step1: assign to a temp value
    if (returns_value) {
        astp p1 = ast_new(T_VARIABLE, "$AspisRetTemp");
        astp p2;
        int by_ref = 0;
        if (returns_by_ref && t->parameters[0]->type == T_VARIABLE && !is_method_call(t->parameters[0])) {
            p2 = ast_new_wparam(T_REF, "&", t->parameters[0]);
            by_ref = 1;
        } else {
            p2 = t->parameters[0];
            by_ref = 0;
        }
        astp stmt1 = ast_new_w3params(T_ARTIFICIAL, "=", p1, p2, ast_new(T_ARTIFICIAL, ";"));
        ast_add_parameter(res, stmt1);
    }
    //step 2: restore taints
    int i=0;
    for (i=0;i<imported_globals_index;i++) {
        char n[10];
        sprintf(n,"%d",i);
        char * str=strcat_malloc("$AspisVar",n);
        astp nvar=ast_new(T_VARIABLE,str);
        astp varname=ast_new(T_CONSTANT_ENCAPSED_STRING,globals_aliases[i]);
        varname->rewritten=1;
        astp comma1=ast_new_wparam(T_ARTIFICIAL,",",varname);
        astp comma2=ast_new_wparam(T_ARTIFICIAL,",",ast_new(T_VARIABLE,"$AspisChangesCache"));
        astp p = ast_new_w3params(T_ARTIFICIAL, "(", nvar,comma1,comma2);
        astp e = ast_new(T_ARTIFICIAL, ";");
        astp c = ast_new_wparams(T_STRING_METHOD, function, p, e);
        ast_add_parameter(res,c);
    }

    //step 3: return the temp var instead
    if (returns_value) t->parameters[0]=ast_new(T_VARIABLE,"$AspisRetTemp");
    ast_add_parameter(res,t);

    //put the children of the old "return" under {
    for (i = 0; i < t->total_children; i++) {
        ast_add_child(res, t->children[i]);
    }
    ast_clear_children(t);
    t->rewritten=1;
    *tree = res;
}
/*
 * If the function did some global declarations, then make sure that the last
 * statement behaves like there was a "return" in the end
 */
void both_rewrite_function_definition(astp *tree,char * function) {
    //this may be redundand if the function already "returns", but in this case,
    //it is just dead code after return.
    //TODO: eliminate the redudancy
    astp t = *tree;
    if (is_partial_enabled && t->rewritten == 0) {
        astp stmts = t->parameters[3];
        astp dummy = ast_new(T_NULL, NULL);
        int i = 0;
        for (i = 0; i < imported_globals_index; i++) {
            char n[10];
            sprintf(n, "%d", i);
            char * str = strcat_malloc("$AspisVar", n);
            astp nvar = ast_new(T_VARIABLE, str);
            astp varname=ast_new(T_CONSTANT_ENCAPSED_STRING,globals_aliases[i]);
            varname->rewritten=1;
            astp comma1=ast_new_wparam(T_ARTIFICIAL,",",varname);
            astp comma2=ast_new_wparam(T_ARTIFICIAL,",",ast_new(T_VARIABLE,"$AspisChangesCache"));
            astp p = ast_new_w3params(T_ARTIFICIAL, "(", nvar,comma1,comma2);
            astp e = ast_new(T_ARTIFICIAL, ";");
            astp c = ast_new_wparams(T_STRING_METHOD, function, p, e);
            ast_add_parameter(dummy, c);
        }
        ast_add_child(stmts, dummy);
        t->rewritten = 1;
    }
}
/*
 * add a call to function aspisdummy that will be killed afterwards
 * usefull to seperate chained calls in groups
 */
void add_dummy_function(astp *tree) {
    astp temp=ast_new_wparam(T_NULL,NULL,*tree);
    astp s = ast_new_wparam(T_ARTIFICIAL, "(", temp);
    astp t = ast_new_wparam(T_STRING_FUNCTION, "aspisdummy", s);
    s->rewritten = 1;
    t->rewritten = 1;
    *tree = t;
}
/*
 * Operates as tainted_rewrite_object_operator, but only for stupid reasons.
 * It breaks chaines of $o->a->b->c like the original but
 * 1) it doesn't dereference a or b with []
 * 2) the function used in braking the chain is aspisdummy() instead of deAspis()
 */
void untainted_rewrite_object_operator(astp *tree,astp* start) {
    astp t=*tree;
    astp lastp = t->parameters[t->total_parameters - 1];
    if (lastp->type != T_NULL) {
        return;
    }
    int i = 0;
    for (i = 0; i < lastp->total_parameters; i++) {
        if (lastp->parameters[i]->type != T_OBJECT_OPERATOR) {
            return;
        }
    }
    astp copy=ast_new(T_NULL,NULL);
    //lets create a list of everything with a -> operator
    ast_remove_parameter(t, t->total_parameters - 1);
    ast_add_parameter(copy,t);
    int paramsc=lastp->total_parameters;
    for (i = 0 ; i < paramsc  ; i++) {
        ast_add_parameter(copy,lastp->parameters[0]);
        ast_remove_parameter(lastp,0);
    }
    *tree=ast_new(T_NULL,NULL);
    for (i=0;i<copy->total_parameters;i++) {
        //this is not the last ->, thus the aspis must be removed
        if (i<copy->total_parameters-1) {
            if (copy->parameters[i]->parameters[0]->type == T_STRING_METHOD) {
                //deAspis() from the begining!
                ast_add_parameter(*start,copy->parameters[i]);
                add_dummy_function(start);
            }
            else if (copy->parameters[i]->parameters[0]->type == T_VARIABLE) {
                ast_add_parameter(*start,copy->parameters[i]);
                //deAspis() from the begining!
                add_dummy_function(start);
            }
            else {
               //remove the aspis with a []
               ast_add_parameter(*start,copy->parameters[i]);
            }
        }
        //the last -> doesn't have its aspis removed
        else {
            ast_add_parameter(*start,copy->parameters[i]);
        }
    }
    t->rewritten = 0;
}
/*
 * This is used to call untainted_rewrite_object_operator only iff this variable
 * is accessed is accessed with the object operator, ie $o->m;
 */
void untainted_rewrite_variable_object_access(astp *tree) {
    astp t=*tree;
    if (!is_online) printf("untainted_rewrite_variable_object_access on (%s)\n",t->text);
    if (t->total_parameters==0) {
        if (!is_online) printf("no parameters found at all \n");
        return;
    }
    astp lastp=t->parameters[t->total_parameters-1];
    astp afterlastp=NULL;
    if (lastp->total_parameters>0) afterlastp=lastp->parameters[lastp->total_parameters-1];
    else {
        if (!is_online)  printf("no parameters found after: (%s)\n",lastp->text);
        return;
    }
    if (afterlastp->type==T_NULL) untainted_rewrite_object_operator(&(t->parameters[t->total_parameters-1]),tree);
}
/*
 * untainted_rewrite_variable_object_access() adds calls to aspisdummy(), only to
 * facilitate rewriting. If aspisdummy() is still in the code, well, kill it
 */
void untainted_delete_dummies(astp *tree) {
    astp t=*tree;
    int i=0;
    for (i=0;i<t->total_parameters;i++) {
        untainted_delete_dummies(&(t->parameters[i]));
    }
    for (i=0;i<t->total_children;i++) {
        untainted_delete_dummies(&(t->children[i]));
    }
    
    if (t->type==T_STRING_FUNCTION && strcmp(t->text,"aspisdummy")==0 ) {
        astp tmp=ast_new(T_NULL,NULL);
        for (i=1;i<t->total_parameters;i++) ast_add_parameter(tmp,t->parameters[i]);
        for (i=0;i<t->total_children;i++) ast_add_child(tmp,t->children[i]);

        *tree=t->parameters[0]->parameters[0]->parameters[0];
        t=*tree;
        
        for (i=0;i<tmp->total_parameters;i++) ast_add_parameter(t,tmp->parameters[i]);
        for (i=0;i<tmp->total_children;i++) ast_add_child(t,tmp->children[i]);
    }
}
int is_superglobal(astp t) {
    if (t->type==T_VARIABLE &&
            (strcmp(t->text,"$_SERVER")==0 ||
            strcmp(t->text,"$_GET")==0 ||
            strcmp(t->text,"$_POST")==0 ||
            strcmp(t->text,"$_FILES")==0 ||
            strcmp(t->text,"$_REQUEST")==0 ||
            strcmp(t->text,"$_COOKIE")==0 ||
            strcmp(t->text,"$_ENV")==0 )) return 1;
    else return 0;
}
int is_globals(astp t) {
    if (t->type==T_VARIABLE && (strcmp(t->text,"$GLOBALS")==0)) return 1;
    else return 0;
}
/*
 * Every read to a superglobal fron untainted context is rewritten
 * $POST["me"] becomes deAspisRCO($POST[0]["me"])
 * This does not happen for reads on $GLOBALS iff is_global_scope_untainted==true
 */
void untainted_rewrite_superglobal_read(astp *tree) {
    astp t=*tree;
    if (is_superglobal(t)) {
        int i = 0;
        for (i = 0; i < t->total_parameters; i++) {
            astp p = t->parameters[i];
            if (p->type == T_ARTIFICIAL && strcmp(p->text, "[") == 0) {
                astp zero = ast_new(T_DNUMBER, "0");
                astp rest = ast_new_wparam(T_ARTIFICIAL, "[", zero);
                ast_add_child(rest, p);
                t->parameters[i] = rest;
            }
        }
        astp paren = ast_new_wparam(T_ARTIFICIAL, "(", t);
        *tree = ast_new_wparam(T_STRING_FUNCTION, "deAspisWarningRC", paren);
    } else if (is_globals(t)) {
        astp p = t->parameters[0];
        if (p->type == T_ARTIFICIAL && strcmp(p->text, "[") == 0) {
            astp zero = ast_new(T_DNUMBER, "0");
            astp rest = ast_new_wparam(T_ARTIFICIAL, "[", zero);
            ast_add_child(rest, p);
            t->parameters[0] = rest;
        }
    }
}
/*
 * Assingments to non $GLOBALS superglobals are rewritten. $POST["me"]=12 becomes
 * $POST[0]["me"]=attAspisRCO(12);
 * This does not happen for writes on $GLOBALS iff is_global_scope_untainted==true
 */
void untainted_rewrite_superglobal_assignement(astp *tree,astp original) {
    astp t=(*tree)->parameters[0];
    if (t->type==T_STRING_FUNCTION && strcmp(t->text,"deAspisWarningRC")==0 ) {
        astp global=t->parameters[0]->parameters[0];
        if (is_superglobal(global)) {
            (*tree)->parameters[0]=global;
            astp paren=ast_new_wparam(T_ARTIFICIAL,"(",(*tree)->parameters[1]);
            (*tree)->parameters[1]=ast_new_wparam(T_STRING_FUNCTION,"attAspisRCO",paren);
        }
    }
}
/*
 * empty() and isset() are overriden when called on tainted superglobals
 * This works much like the tainted counterpart but only for calls on superglobals
 */
void untainted_rewrite_construct(astp *tree) {
    astp t=*tree;
    astp f=t->parameters[0]->parameters[0];
    if (f->type==T_NULL) f=f->parameters[0];
    if (f->total_parameters==0 || f->parameters[0]->total_parameters==0) return;
    astp n=f->parameters[0]->parameters[0];
    
    if (f->type==T_STRING_FUNCTION && strcmp(f->text,"deAspisWarningRC")==0 && is_superglobal(n)) {
        //keep in a temp value a possible trailing ; and all the node's children
        astp temp = ast_new(T_NULL, NULL);
        if (t->total_parameters > 0 && strcmp(t->parameters[t->total_parameters - 1]->text, ";") == 0) {
            ast_add_parameter(temp, t->parameters[t->total_parameters - 1]);
            ast_remove_parameter(t, t->total_parameters - 1);
        }
        int i = 0;
        for (i = 0; i < t->total_children; i++) {
            ast_add_child(temp, t->children[0]);
            ast_remove_child(t, 0);
        }

        //delete the deAspisWarningRC
        t->parameters[0]->parameters[0]=f->parameters[0]->parameters[0];

        //the actual job
        astp copy=ast_copy(t);
        rewrite_function_name(&copy,copy->total_parameters);
        //dereference_aspis_from_parameter(&(copy->parameters[0]),0);
        astp oper;
        if (strcmp(t->text,"isset")==0) oper=ast_new_wparams(T_BOOLEAN_AND,"&&",t,copy);
        else if (strcmp(t->text,"empty")==0) oper=ast_new_wparams(T_BOOLEAN_OR,"||",t,copy);
        else die("rewrite_construct only works with isset/empty");
        astp p=ast_new_wparam(T_ARTIFICIAL,"(",oper);
        *tree=p;

        //then copy back from temp to the new result
        if (temp->total_parameters == 1) ast_add_parameter(*tree, temp->parameters[0]);
        for (i = 0; i < temp->total_children; i++) {
            ast_add_child(*tree, temp->children[i]);
        }
    }
}
/*
 * if called on superglobal, just remove the deAspisWarningRC();
 */
void untainted_rewrite_unset(astp *tree) {
    astp t=*tree;
    astp f=t->parameters[0]->parameters[0];
    if (f->type==T_STRING_FUNCTION && strcmp(f->text,"deAspisWarningRC")==0) {
        t->parameters[0]->parameters[0]=f->parameters[0]->parameters[0];
    }
}
/*
 * This switches to tainted_bfs processing of trees,
 * in case that the function definition is tainted.
 */
void untainted_rewrite_function_definition(FILE * out,astp *tree) {
    astp t=*tree;
    if ( ( is_partial_enabled && is_method_declaration && is_tainted_cl) ||
            (is_partial_enabled && is_tainted_function(t->parameters[1]->text) && !is_tainted_cl && !is_method_declaration)
            ) {
        //turn on taint tracking
        imported_globals=ast_new(T_NULL,NULL);
        imported_globals_index=0;
        ast_edit_bfs(out,&original_function);

        //store children to the new tree
        int i=0;
        for (i=0;i<t->total_children;i++) {
            ast_add_child(original_function,t->children[i]);
        }
        *tree=original_function;
        return;
    }
}
/*
 * This switches to original_bfs processing of trees,
 * in case that the class is tainted.
 */
int untainted_rewrite_class_definition(FILE * out,astp *tree) {
    astp t=*tree;
    astp original_class;
    int paramsnum=0;
    if (t->parameters[0]->parameters[0]->type==T_STRING_CLASSNAME) paramsnum=0;
    else paramsnum=1;
    int is_tainted_cl_tmp=is_tainted_cl;
    is_tainted_cl=is_tainted_class(t->parameters[0]->parameters[paramsnum]->text);
    if (!is_partial_enabled || !is_tainted_cl) {
        return 0;
    }
    int is_tainted_tmp=is_tainted;
    is_tainted=1;
    //limit the untainted rewriting to this class by removed all its kids
    astp tmp = ast_new(T_NULL, NULL);
    int i = 0;
    for (i = 0; i < t->total_children; i++) {
        ast_add_child(tmp, t->children[i]);
    }
    ast_clear_children(t);
    
    ast_edit_bfs(out, tree);

    //now put the kids back
    for (i=0;i<tmp->total_children;i++) {
            ast_add_child(t,tmp->children[i]);
    }
    is_tainted=is_tainted_tmp;
    is_tainted_cl=is_tainted_cl_tmp;
    return 1;
}

/**********Recursive control functions***********************************/
void ast_untainted_edit_bfs(FILE *out, astp* tree) {
    int i = 0;
    astp assign_to;
    int is_tainted_temp;
    if (*tree != NULL) {
        if (!is_online) printf("[%d] %s\n", (*tree)->type, (*tree)->text);
        switch ((*tree)->type) {
            case T_REQUIRE:
            case T_REQUIRE_ONCE:
            case T_INCLUDE_ONCE:
            case T_INCLUDE:
                untainted_edit_node_generic(out, tree, NULL);
                untainted_rewrite_require(tree);
                break;
            case T_STRING_FUNCTION:
                untainted_edit_node_generic(out, tree, NULL);
                untainted_rewrite_function_call(tree);
                break;
            case T_GLOBAL:
                untainted_rewrite_global(tree);
                untainted_edit_node_generic(out, tree, NULL);
                break;
            case T_RETURN:
                if (!is_global_scope_untainted) both_rewrite_return(tree,"AspisRestoreTaintedGlobal");
                else both_rewrite_return(tree,"AspisRestoreTaintedGlobalUntainted");
                untainted_edit_node_generic(out, tree, NULL);
                break;
            case T_FUNCTION:
                imported_globals = ast_new(T_NULL, NULL);
                imported_globals_index = 0;
                both_returns_by_ref(tree);

                is_tainted_temp=is_tainted;
                store_tainted_function(tree);

                untainted_edit_node_generic(out, tree, NULL);
                untainted_rewrite_function_definition(out,tree);
                if (!is_global_scope_untainted) both_rewrite_function_definition(tree,"AspisRestoreTaintedGlobal");
                else both_rewrite_function_definition(tree,"AspisRestoreTaintedGlobalUntainted");

                is_tainted=is_tainted_temp;
                imported_globals = NULL;
                imported_globals_index = 0;
                break;
            case T_CLASS_DECLARATION:
                if (untainted_rewrite_class_definition(out,tree)) break; //parameters are alread rewritten
                //if the prev fails, continue with old school rewriting
                is_tainted_cl=0;
                untainted_edit_node_generic(out, tree, NULL);
                break;
            case T_NEW:
                rewrite_new(out,tree);
                break;
            case T_VARIABLE:
                untainted_edit_node_generic(out, tree, NULL);
                untainted_rewrite_variable_object_access(tree); //break chains w aspisdummy()
                rewrite_variable_method_call(tree); //this may replace aspisdummys for methods with references
                untainted_delete_dummies(tree); //but if not, aspisdummy() is irrelevant
                untainted_rewrite_superglobal_read(tree); //it may also be a superglobal
                break;
            case T_ISSET:
            case T_EMPTY:
                untainted_edit_node_generic(out, tree, NULL);
                untainted_rewrite_construct(tree);
                break;
            case T_FUNCTION_VARIABLE:
                rewrite_variable_function_call(tree);
                untainted_edit_node_generic(out, tree, NULL);
                break;
            case T_UNSET:
                untainted_edit_node_generic(out, tree, NULL);
                untainted_rewrite_unset(tree);
                break;
            case T_PLUS_EQUAL:
            case T_MINUS_EQUAL:
            case T_MUL_EQUAL:
            case T_DIV_EQUAL:
            case T_CONCAT_EQUAL:
            case T_MOD_EQUAL:
            case T_AND_EQUAL:
            case T_OR_EQUAL:
            case T_XOR_EQUAL:
            case T_SL_EQUAL:
                assign_to=ast_copy((*tree)->parameters[0]);
                untainted_edit_node_generic(out, tree, NULL);
                untainted_rewrite_superglobal_assignement(tree,assign_to);
                untainted_rewrite_assignment_byref(tree);
                break;
            case T_ARTIFICIAL:
                if (strcmp((*tree)->text, "=") == 0 ) {
                    assign_to=ast_copy((*tree)->parameters[0]);
                    untainted_edit_node_generic(out, tree, NULL);
                    untainted_rewrite_superglobal_assignement(tree,assign_to);
                    untainted_rewrite_assignment_byref(tree);
                }
                else {
                    untainted_edit_node_generic(out, tree, NULL);
                }
                break;
            default:
                untainted_edit_node_generic(out, tree, NULL);
                break;
        }
        for (i = 0; i < (*tree)->total_children; i++) {
            ast_untainted_edit_bfs(out, &((*tree)->children[i]));
        }
    }
}
void ast_edit_bfs(FILE *out, astp* tree) {
    int i = 0;
    int exists_superglobal_temp;
    int is_tainted_temp;
    if (*tree != NULL) {
        if (!is_online) printf("[%d] %s\n", (*tree)->type, (*tree)->text);
        switch ((*tree)->type) {
            case T_CONSTANT_ENCAPSED_STRING:
                if (!(*tree)->rewritten) attach_aspis(tree);
                edit_node_generic(out, tree, NULL);
                break;
            case T_START_HEREDOC:
                if (!(*tree)->rewritten) {
                    rewrite_heredoc(tree);
                }
                edit_node_generic(out, tree, NULL);
                break;
            case T_ARTIFICIAL:
                if (strcmp((*tree)->text, ".") == 0) {
                    edit_node_generic(out, tree, NULL);
                    rewrite_concat(tree);
                } else if (strcmp((*tree)->text, "\"") == 0) {
                    rewrite_expanding_string(tree);
                    edit_node_generic(out, tree, NULL);
                } else if (strcmp((*tree)->text, "+") == 0 ||
                        strcmp((*tree)->text, "-") == 0 ||
                        strcmp((*tree)->text, "*") == 0 ||
                        strcmp((*tree)->text, "/") == 0 ||
                        strcmp((*tree)->text, "%") == 0 ||
                        strcmp((*tree)->text, ">") == 0 ||
                        strcmp((*tree)->text, "<") == 0 ||
                        strcmp((*tree)->text, "|") == 0 ||
                        strcmp((*tree)->text, "&") == 0 ||
                        strcmp((*tree)->text, "^") == 0 
                        ) {
                    //reverse order so that the subexpressions will first become objects
                    edit_node_generic(out, tree, NULL);
                    //and then they will be dereferenced
                    rewrite_binary_operator(tree);
                } 
                else if (strcmp((*tree)->text, "!") == 0) {
                    edit_node_generic(out, tree, NULL);
                    rewrite_unary_operator(tree,"not_boolean");
                }
                else if (strcmp((*tree)->text, "~") == 0 ) {
                    edit_node_generic(out, tree, NULL);
                    rewrite_unary_operator(tree,"not_bitwise");
                }
                else if (strcmp((*tree)->text, "?") == 0 ) {
                    edit_node_generic(out, tree, NULL);
                    rewrite_qmark_operator(tree);
                }
                else if (strcmp((*tree)->text, "=") == 0 ) {
                    is_assignment=1;
                    ast_edit_bfs(out,&((*tree)->parameters[0]));
                    is_assignment=0;
                    int i=0;
                    for (i = 1; i < (*tree)->total_parameters; i++) {
                        ast_edit_bfs(out,&((*tree)->parameters[i]));
                    }
                    rewrite_assignement(tree);
                }
                else if (strcmp((*tree)->text, "[") == 0 ) {
                    int is_assingment_t=is_assignment;
                    int is_language_construct_t=is_language_construct;
                    is_assignment=0; //no matter where I am, I need to do proper
                    is_language_construct=0; //rewritting here.
                    edit_node_generic(out, tree, NULL);
                    is_assignment=is_assingment_t;
                    is_language_construct=is_language_construct_t;
                    rewrite_array_access(tree);
                }
                else if (strcmp((*tree)->text, "$") == 0 ) {
                    if ((*tree)->total_parameters>=1 && (*tree)->parameters[0]->type==T_ARTIFICIAL
                            && strcmp((*tree)->parameters[0]->text,"{")==0) {
                        edit_node_generic(out, tree, NULL);
                        rewrite_dollar_open(tree);
                    }
                    else if ((*tree)->total_parameters>=1 &&
                            (*tree)->parameters[0]->type==T_VARIABLE) {
                        edit_node_generic(out, tree, NULL);
                        rewrite_dollar_dollar(tree);
                    }
                    else {
                        edit_node_generic(out, tree, NULL);
                        rewrite_variable_array_access(tree);
                        rewrite_variable_object_access(tree);
                    }
                }
                else {
                    edit_node_generic(out, tree, NULL);
                }
                break;
            case T_VARIABLE:
                rewrite_this(tree);
                edit_node_generic(out, tree, NULL);
                log_superglobal(tree);
                rewrite_variable_object_access(tree);
                rewrite_variable_array_access(tree);
                rewrite_variable_method_call(tree);
                break;
            case T_OBJECT_OPERATOR:
                edit_node_generic(out, tree, NULL);
                rewrite_object_parenthesis(tree);
                break;
            case T_FUNCTION_VARIABLE:
                rewrite_variable_function_call(tree);
                edit_node_generic(out, tree, NULL);
                break;
            case T_LNUMBER:
            case T_DNUMBER:
            case T_NUM_STRING:
                rewrite_number(tree);
                edit_node_generic(out, tree, NULL);
                break;
            case T_STRING:
                rewrite_string(tree);
                edit_node_generic(out, tree, NULL);
                break;
            case T_STRING_FUNCTION:
            case T_EXIT:
                edit_node_generic(out, tree, NULL);
                rewrite_function_call(tree);
                rewrite_sanitiser_call(tree);
                rewrite_sink_call(tree);
                break;
                /*
                NOTE: this rewritting fails when empty is directly called on
                a string's character, $s="str"; empty($s[1]); Unlike isset,
                here rewrite_function_call must dereference empty's operand
                and this results in empty() trying to check a char's[0]. I cannot
                treat this as isset, as isset on an Aspis is always true. I hope
                that noone does empty() on a string's character...
                */
            case T_ISSET:
            case T_EMPTY:
                //edit_node_generic(out, tree, NULL);
                is_language_construct=1;
                edit_node_generic(out, tree, NULL);
                is_language_construct=0;
                //(*tree)->parameters[0]=(*tree)->parameters[0]->parameters[0]->parameters[0];
                rewrite_construct(tree);
                break;
            case T_STRING_GOTO:
            case T_STRING_CLASSNAME:
                edit_node_generic(out, tree, NULL);
                break;
            case T_FIRST_BRACKET:
                edit_node_generic(out, tree, NULL);
                rewrite_array_access(tree);
                break;
            case T_IS_EQUAL:
            case T_IS_NOT_EQUAL:
            case T_IS_IDENTICAL:
            case T_IS_NOT_IDENTICAL:
            case T_IS_SMALLER_OR_EQUAL:
            case T_IS_GREATER_OR_EQUAL:
            case T_INSTANCEOF:
            case T_LOGICAL_OR:
            case T_LOGICAL_XOR:
            case T_LOGICAL_AND:
            case T_BOOLEAN_OR:
            case T_BOOLEAN_AND:
            case T_SL:
            case T_SR:
                //reverse proccessing order so that the subexpressions will first become AspisObjects
               edit_node_generic(out, tree, NULL);
               //and then they will be dereferenced
               rewrite_binary_operator(tree);
               break;
            case T_PLUS_EQUAL:
                rewrite_xequals(tree,T_ARTIFICIAL,"+");
                edit_node_generic(out, tree, NULL);
                break;
            case T_MINUS_EQUAL:
                rewrite_xequals(tree,T_ARTIFICIAL,"-");
                edit_node_generic(out, tree, NULL);
                break;
            case T_MUL_EQUAL:
                rewrite_xequals(tree,T_ARTIFICIAL,"*");
                edit_node_generic(out, tree, NULL);
                break;
            case T_DIV_EQUAL:
                rewrite_xequals(tree,T_ARTIFICIAL,"/");
                edit_node_generic(out, tree, NULL);
                break;
            case T_CONCAT_EQUAL:
                rewrite_xequals(tree,T_ARTIFICIAL,".");
                edit_node_generic(out, tree, NULL);
                break;
            case T_MOD_EQUAL:
                rewrite_xequals(tree,T_ARTIFICIAL,"%");
                edit_node_generic(out, tree, NULL);
                break;
            case T_AND_EQUAL:
                rewrite_xequals(tree,T_ARTIFICIAL,"&");
                edit_node_generic(out, tree, NULL);
                break;
            case T_OR_EQUAL:
                rewrite_xequals(tree,T_ARTIFICIAL,"|");
                edit_node_generic(out, tree, NULL);
                break;
            case T_XOR_EQUAL:
                rewrite_xequals(tree,T_ARTIFICIAL,"^");
                edit_node_generic(out, tree, NULL);
                break;
            case T_SL_EQUAL:
                rewrite_xequals(tree,T_ARTIFICIAL,"<<");
                edit_node_generic(out, tree, NULL);
                break;
            case T_SR_EQUAL:
                rewrite_xequals(tree,T_ARTIFICIAL,">>");
                edit_node_generic(out, tree, NULL);
                break;
            case T_INC:
            case T_DEC:
                rewrite_xcrement(tree);
                edit_node_generic(out, tree, NULL);
                break;
            case T_PLUS_UNARY:
                //do nothing, effectively ignore unary +'ses
                edit_node_generic(out, tree, NULL);
                break;
            case T_MINUS_UNARY:
                //reverse processing again to make the subexpressions objects first
                edit_node_generic(out, tree, NULL);
                rewrite_unary_operator(tree,"negate");
                break;
            case T_INT_CAST:
            case T_DOUBLE_CAST:
            case T_STRING_CAST:
            case T_ARRAY_CAST:
            case T_OBJECT_CAST:
            case T_BOOL_CAST:
            case T_UNSET_CAST:
                edit_node_generic(out, tree, NULL);
                rewrite_casts(tree);
                break;
            case T_IF:
            case T_ELSEIF:
            case T_WHILE:
            case T_SWITCH:
            case T_CASE:
                edit_node_generic(out, tree, NULL);
                dereference_aspis_from_parameter(tree,0);
                break;
            case T_BREAK:
            case T_CONTINUE:
                edit_node_generic(out, tree, NULL);
                rewrite_break_continue(tree);
                break;
            case T_DO:
            case T_FOR:
                edit_node_generic(out, tree, NULL);
                dereference_aspis_from_parameter(tree,1);
                break;
            case T_CATCH:
                edit_node_generic(out, tree, NULL);
                rewrite_catch(tree);
                break;
            case T_THROW:
                edit_node_generic(out, tree, NULL);
                rewrite_throw(tree);
                break;
            case T_ARRAY: //array construction
                edit_node_generic(out, tree, NULL);
                rewrite_array(tree);
                break;
            case T_DOUBLE_ARROW: //array construction, hashmap style
                edit_node_generic(out, tree, NULL);
                rewrite_double_arrow(tree);
                break;
            case T_FOREACH:
                edit_node_generic(out, tree, NULL);
                rewrite_foreach(tree);
                break;
            case T_ECHO:
                edit_node_generic(out, tree, NULL);
                rewrite_echo(tree);
                break;
            case T_PRINT:
                edit_node_generic(out, tree, NULL);
                rewrite_print(tree);
                break;
            case T_FUNCTION_ANONYMOUS:
                edit_node_generic(out, tree, NULL);
                attach_aspis(tree);
                break;
            case T_NEW:
                rewrite_new(out,tree);
                break;
            case T_LINE:
            case T_FILE:
            case T_DIR:
            case T_CLASS_C:
            case T_METHOD_C:
            case T_FUNC_C:
                rewrite_magic_constant(tree);
                edit_node_generic(out, tree, NULL);
                break;
            case T_INCLUDE:
            case T_INCLUDE_ONCE:
            case T_REQUIRE:
            case T_REQUIRE_ONCE:
                dereference_aspis_from_parameter(tree,0);
                edit_node_generic(out, tree, NULL);
                break;
            case T_REF:
                rewrite_reference(tree);
                is_reference=1;
                edit_node_generic(out, tree, NULL);
                is_reference=0;
                break;
            case T_UNSET:
                is_assignment=1;
                edit_node_generic(out, tree, NULL);
                is_assignment=0;
                break;
            case T_DOLLAR_OPEN_CURLY_BRACES:
                rewrite_dollar_open(tree);
                edit_node_generic(out, tree, NULL);
                break;
            case T_CLONE:
                edit_node_generic(out, tree, NULL);
                rewrite_clone(tree);
                break;
            case T_FUNCTION:
                imported_globals = ast_new(T_NULL, NULL);
                imported_globals_index = 0;
                both_returns_by_ref(tree);
                
                exists_superglobal_temp=exists_superglobal;
                is_tainted_temp=is_tainted;
                
                store_tainted_function(tree);
                edit_node_generic(out, tree, NULL);
                rewrite_function_definition(out,tree);
                if (!is_global_scope_untainted) both_rewrite_function_definition(tree,"AspisRestoreUntaintedGlobal");
                else both_rewrite_function_definition(tree,"AspisRestoreUntaintedGlobalUntainted");

                is_tainted=is_tainted_temp;
                exists_superglobal=exists_superglobal_temp;
                imported_globals = NULL;
                imported_globals_index = 0;
                break;
            case T_GLOBAL:
                edit_node_generic(out, tree, NULL);
                rewrite_global(tree);
                break;
            case T_METHOD_START:
                is_method_declaration=1;
                edit_node_generic(out, tree, NULL);
                is_method_declaration=0;
                break;
            case T_CLASS_DECLARATION:
                if (rewrite_class_definition(out,tree)) break; //parameters are alread rewritten
                //if the prev fails, continue with old school rewriting
                is_tainted_cl=1;
                edit_node_generic(out, tree, NULL);
                is_tainted_cl=0;
                break;
            case T_RETURN:
                if (!is_global_scope_untainted) both_rewrite_return(tree,"AspisRestoreUntaintedGlobal");
                else both_rewrite_return(tree,"AspisRestoreUntaintedGlobalUntainted");
                edit_node_generic(out, tree, NULL);
                break;
            case T_INLINE_HTML_EQUALS:
                edit_node_generic(out, tree, NULL);
                rewrite_equals_tag(tree);
                break;
            case T_INLINE_HTML:
            case T_DOUBLE_ARROW_STATIC:
            case T_ABSTRACT:
            case T_FINAL:
            case T_PRIVATE:
            case T_PROTECTED:
            case T_PUBLIC:
            case T_NULL:
            case T_STRING_VARNAME:
            case T_STRING_CONSTNAME:
            case T_EVAL:
            case T_ENCAPSED_AND_WHITESPACE:
            case T_VAR:
            case T_HALT_COMPILER:
            case T_INTERFACE:
            case T_LIST:
            case T_END_HEREDOC:
            case T_PAAMAYIM_NEKUDOTAYIM:
            case T_CHARACTER:
            case T_CC:
            case T_NOT_ARRAY:
            case T_USE:
            case T_STATIC:
            case T_CLASS:
            case T_EXTENDS:
            case T_IMPLEMENTS:
            case T_CONST:
            case T_STRING_FUNCTION_DEF:
            case T_ELSE:
            case T_DECLARE:
            case T_CURLY_OPEN:
            case T_ENDDECLARE:
            case T_ENDSWITCH:
            case T_ENDFOR:
            case T_ENDIF:
            case T_ENDFOREACH:
            case T_BAD_CHARACTER:
            case T_ENDWHILE:
            case T_COMMENT:
            case T_DOC_COMMENT:
            case T_OPEN_TAG:
            case T_OPEN_TAG_WITH_ECHO:
            case T_CLOSE_TAG:
            case T_WHITESPACE:
            case T_NAMESPACE: //The lexer doesnt support namespaces //TODO
            case T_NS_C:
            case T_NS_SEPARATOR:
            //Checked
            case T_GOTO:
            case T_LABEL:
            case T_DEFAULT:
            case T_TRY:
            default:
                edit_node_generic(out, tree, NULL);
        }
        for (i = 0; i < (*tree)->total_children; i++) {
            ast_edit_bfs(out, &((*tree)->children[i]));
        }
    }
}

void untainted_edit_node_generic(FILE * out, astp * tree, char * name) {
    if (*tree != NULL) {
        int i = 0;
        for (i = 0; i < (*tree)->total_parameters; i++) {
            ast_untainted_edit_bfs(out, &((*tree)->parameters[i]));
        }
    }
}
void edit_node_generic(FILE * out, astp * tree, char * name) {
    if (*tree != NULL) {
        int i = 0;
        for (i = 0; i < (*tree)->total_parameters; i++) {
            ast_edit_bfs(out, &((*tree)->parameters[i]));
        }
    }
}

void ast_transform(FILE * out,
        char * aspis_home, 
        char * taints, 
        char * prototypes, 
        char * categories,
        char * filename, 
        astp * tree, 
        astp * functions ) {
    //read the various lists of php functions
    function_file_read( path_join(aspis_home, "phplib/php_functions.txt"), &functions_list, &functions_count);
    function_file_read( path_join(aspis_home, "phplib/php_functions_overriden.txt"), &functions_overriden_list, &functions_overriden_count);
    function_file_read( path_join(aspis_home, "phplib/php_functions_overriden_partial.txt"), &functions_overriden_partial_list, &functions_overriden_partial_count);
    prototypes_file_read( path_join(aspis_home, "phplib/php_functions_reference_sorted_easy.txt"), &functions_prototypes,&functions_prototypes_count);

    if (taints!=NULL && !COLLECT_INFO) {
        is_partial_enabled=1;
        taints_filename=strcpy_malloc(taints);
        taint_file_read(taints, &functions_tainted_list, &functions_tainted_count, &classes_tainted_list, &classes_tainted_count);
        is_global_scope_untainted = !is_tainted_function(filename);
    }
    if (prototypes!=NULL && !COLLECT_INFO) {
        uprototypes_read_functions(prototypes, &user_functions_prototypes, &user_functions_prototypes_count);
        uprototypes_read_methods(prototypes, &user_methods_prototypes, &user_methods_prototypes_count);
        has_user_prototypes=1;
    }
    if (categories!=NULL) {
        taint_categories=category_file_read(categories);
    }
    
    if (COLLECT_INFO) {
        if (prototypes != NULL) prototypes_log_filename = prototypes;
        else prototypes_log_filename = "current.prototypes";
    }

    if (!is_online) {
        printf("Just read %d PHP lib function prototypes..!\n",functions_prototypes_count);
        if (is_partial_enabled) {
            printf("Just read %d user function prototypes..!\n",user_functions_prototypes_count);
            printf("Just read %d user method prototypes..!\n",user_methods_prototypes_count);
            printf("Just read a list of %d tainted function names..!\n",functions_tainted_count);
            printf("Just read a list of %d tainted class names..!\n",classes_tainted_count);
        }
    }
    
    //let's start the rewriting!
    is_tainted=!is_global_scope_untainted;
    if (is_partial_enabled && is_global_scope_untainted) ast_untainted_edit_bfs(out,tree);
    else ast_edit_bfs(out, tree);
    if (!is_online) {
        astp s = ast_new(T_CC, "<?php require_once('AspisMain.php'); ?>");
        ast_add_child(s, *tree);
        *tree = s;
    }
    *functions=functions_found;
}