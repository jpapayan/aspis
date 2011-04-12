#include "php_parser.tab.h"
#include "ast_improver.h"
#include "ast_transformer.h"
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

const int IMPROVE_AST=1;

void improve_node_generic(FILE * , astp * , char * );
void improve_node_generic_concat(FILE * , astp * , char * );
void improve_node_generic_attachAspis(FILE * , astp * , char * );

astp nextp(astp t) {
    astp next = t;
    astp afternext = NULL;
    //locate the parenthesis of deAspis() (next) and the item right after it (array,or sth different)
    while (1) {
        if (next->total_parameters == 0) break;
        astp temp = next->parameters[0]; //parenthesis
        if (temp->type != T_ARTIFICIAL || strcmp(temp->text, "(") != 0
                || temp->total_parameters == 0) break;
        next = next->parameters[0]; //first element
        afternext = next->parameters[0]; //second element
        if (afternext->type != T_ARTIFICIAL || strcmp(afternext->text, "(") != 0
                || afternext->total_parameters == 0) break;
    }
    return next;
}
astp afternextp(astp t) {
    astp next = t;
    astp afternext = NULL;
    //locate the parenthesis of deAspis() (next) and the item right after it (array,or sth different)
    while (1) {
        if (next->total_parameters == 0) break;
        astp temp = next->parameters[0]; //parenthesis
        if (temp->type != T_ARTIFICIAL || strcmp(temp->text, "(") != 0
                || temp->total_parameters == 0) break;
        next = next->parameters[0]; //first element
        afternext = next->parameters[0]; //second element
        if (afternext->type != T_ARTIFICIAL || strcmp(afternext->text, "(") != 0
                || afternext->total_parameters == 0) break;
    }
    return afternext;
}

void improve_current(astp *tree) {
    astp t=*tree;
    if (!is_online) printf("**%s**\n",t->text);
    //Lets kill deAspis() when called on a newly created Aspis
    if (strcmp(t->text,"deAspis")==0 ) {
        astp next=nextp(t);
        astp afternext=afternextp(t);
        if (afternext!=NULL && (afternext->type==T_ARRAY_ASPIS ) ) {
            astp toadd=afternext->parameters[0]->parameters[0];
            if (toadd->total_children==0 && toadd->total_parameters==0  && toadd->type==T_STRING) {
                *tree=ast_new_wparam(T_NULL,NULL,toadd);
            }
            else *tree=ast_new_wparam(T_ARTIFICIAL,"(",toadd);
        }
        else if (afternext!=NULL && afternext->type==T_ARTIFICIAL && strcmp(afternext->text,"?")==0) {
            *tree=ast_new_wparam(T_ARTIFICIAL,"(",afternext);
            if (afternext->parameters[1]->type!=T_NULL) dereference_aspis(&(afternext->parameters[1]));
            dereference_aspis(&(afternext->parameters[2]));
        }
        else if (afternext!=NULL && afternext->type==T_ARTIFICIAL && strcmp(afternext->text,"@")==0 &&
                afternext->parameters[0]->type==T_ARRAY_ASPIS) {
            astp item=afternext->parameters[0]->parameters[0]->parameters[0];
            astp duck=ast_new_wparam(T_ARTIFICIAL,"@",item);
            *tree=ast_new_wparam(T_ARTIFICIAL,"(",duck);
        }
        else if (afternext!=NULL && afternext->type==T_STRING_FUNCTION && strcmp(afternext->text,"attAspis")==0) {
            *tree=afternext->parameters[0]->parameters[0];
        }
        else if (afternext!=NULL && afternext->type==T_STRING_FUNCTION &&
                (strcmp(afternext->text,"concat")==0 || strcmp(afternext->text,"concat1")==0 ||
                strcmp(afternext->text,"concat2")==0 || strcmp(afternext->text,"concat12")==0 ||
                strcmp(afternext->text,"not_boolean")==0 ) ) {
            afternext->text=strcat_malloc("de",afternext->text);
            astp toadd=afternext;
            *tree=ast_new_wparam(T_ARTIFICIAL,"(",toadd);
        }
        return;
    }
    //recursive versions can be killed if the operand is a SIMPLE ASPIS!
    if (strcmp(t->text,"deAspisRC")==0 || strcmp(t->text,"deAspisR")==0 || strcmp(t->text,"deAspisWarningRC")==0) {
        astp next=nextp(t);
        astp afternext=afternextp(t);
        //printf("improver afternext: (%d) %s\n",afternext->type,afternext->text);
        if (afternext!=NULL && afternext->type==T_ARRAY_ASPIS)  {
            astp toadd=afternext->parameters[0]->parameters[0];
            //printf("improver toadd: (%d) %s\n",toadd->type,toadd->text);
            if (toadd->total_children==0 && toadd->total_parameters==0  && 
                    (toadd->type==T_CONSTANT_ENCAPSED_STRING
                     ||toadd->type==T_DNUMBER
                     ||toadd->type==T_LNUMBER
                     ||toadd->type==T_STRING)) {
                *tree=ast_new_wparam(T_NULL,NULL,toadd);
            }
        }
        return;
    }
    //recursive versions can be killed if the operand is a recursive aspis as well
    if (strcmp(t->text,"deAspisRC")==0 || strcmp(t->text,"deAspisR")==0 || strcmp(t->text,"deAspisWarningRC")==0) {
        astp next=nextp(t);
        astp afternext=afternextp(t);
        //printf("improver afternext: (%d) %s\n",afternext->type,afternext->text);
        if (afternext!=NULL && afternext->type==T_STRING_FUNCTION &&
                (strcmp(afternext->text,"attAspisRCO")==0 || strcmp(afternext->text,"attAspisRO")==0 )) {
            astp toadd=afternext->parameters[0]->parameters[0];
            //printf("improver toadd: (%d) %s\n",toadd->type,toadd->text);
            if (toadd->total_children==0 && toadd->total_parameters==0  &&
                    (toadd->type==T_CONSTANT_ENCAPSED_STRING
                     ||toadd->type==T_DNUMBER
                     ||toadd->type==T_LNUMBER
                     ||toadd->type==T_STRING)) {
                *tree=ast_new_wparam(T_NULL,NULL,toadd);
            }
        }
        return;
    }
    if (strcmp(t->text,"AspisCheckPrint")==0) {
        astp next=nextp(t);
        astp afternext=afternextp(t);
        if (afternext!=NULL && afternext->type==T_ARRAY) {
            astp toadd=afternext->parameters[0]->parameters[0];
            if (toadd->total_children==0 && toadd->total_parameters==0  && toadd->type==T_STRING) {
                *tree=ast_new_wparam(T_NULL,NULL,toadd);
            }
            else *tree=ast_new_wparam(T_ARTIFICIAL,"(",toadd);
        }
        return;
    }
    if (strcmp(t->text,"concat")==0 || strcmp(t->text,"deconcat")==0) {
        printf("1\n");
        fflush(stdout);
        char * function_prefix=t->text;
        int removed_array=0;
        astp paren=t->parameters[0];
        astp left_op=paren->parameters[0];
        astp right_op=paren->parameters[1]->parameters[0];

        int left_aspis=left_op->type==T_ARRAY_ASPIS;
        int right_aspis=right_op->type==T_ARRAY_ASPIS;
        if (left_aspis && right_aspis) {
            removed_array=3;
            paren->parameters[0]=left_op->parameters[0]->parameters[0];
            paren->parameters[1]->parameters[0]=right_op->parameters[0]->parameters[0];
        }
        else if (left_aspis) {
            removed_array=1;
            paren->parameters[0]=left_op->parameters[0]->parameters[0];
        }
        else if (right_aspis) {
            removed_array=2;
            paren->parameters[1]->parameters[0]=right_op->parameters[0]->parameters[0];
        }
        printf("3\n");
        fflush(stdout);

        if (paren->total_parameters<2 || paren->parameters[1]->total_parameters==0) return;
        left_op=paren->parameters[0];
        while (left_op->type==TA_IGNORE) left_op=left_op->parameters[0];
        right_op=paren->parameters[1]->parameters[0];
        while (right_op->type==TA_IGNORE) right_op=right_op->parameters[0];

        printf("4\n");
        fflush(stdout);


        printf("removed_array=%d \n",removed_array);
        if (removed_array==3) {
            t->text=strcpy_malloc(strcat_malloc(function_prefix,"12"));
        }
        else if (removed_array==1) {
            t->text=strcpy_malloc(strcat_malloc(function_prefix,"1"));
        }
        else if (removed_array==2) {
            t->text=strcpy_malloc(strcat_malloc(function_prefix,"2"));
        }
        return;
    }

    if (strcmp(t->text,"denot_boolean")==0 ) {
        astp next=nextp(t);
        astp afternext=afternextp(t);
        if (afternext!=NULL && (
                afternext->type==T_ARRAY_ASPIS
                || (afternext->type==T_STRING_FUNCTION && strcmp(afternext->text,"attAspis")==0)
                ) ) {
            astp toadd=afternext->parameters[0]->parameters[0];
            astp a=ast_new_wparam(T_ARTIFICIAL,"(",toadd);
            *tree=ast_new_wparam(T_ARTIFICIAL,"!",a);
        }
        return;
    }
    
}

/*
- * kill aspides generated but ignored
 */
void improve_return_value(astp *tree) {
    astp t=*tree;
    if (t->type==T_STMT_EXPR && t->total_parameters>0) {
        astp next=t->parameters[0];
        printf("improver next: (%d) %s\n",next->type,next->text);
        if (next->type==T_ARRAY_ASPIS ||
                (next->type==T_STRING_FUNCTION &&
                (strcmp(next->text,"attAspis")==0 || strcmp(next->text,"attAspisRC")==0
                || strcmp(next->text,"attAspisRCO")==0 || strcmp(next->text,"attAspisRO")==0
                || strcmp(next->text,"deAspisWarningRC")==0  ) ) ) {
            (*tree)->parameters[0]=next->parameters[0]->parameters[0];
        }

    }
}
/*
 * There are helper functions that can avoid creating an Aspis that is then removed.
 */
void improve_concat(astp * tree) {
    astp tt=*tree;
    //if (tt->type==T_NULL) tt=tt->parameters[0];
    if (strcmp(tt->text,"deAspis")==0 || strcmp(tt->text,"deAspisRC")==0 || strcmp(tt->text,"deAspisR")==0 ) {
        astp next=nextp(tt);
        astp afternext=afternextp(tt);
        if (afternext->type==T_NULL && afternext->total_parameters>0) afternext=afternext->parameters[0];
        if (afternext->type==TA_IGNORE && afternext->total_parameters>0) afternext=afternext->parameters[0];
        printf("add deconcat? %s, %d\n",next->text,afternext->type);
        fflush(stdout);
        if (afternext!=NULL && afternext->type==T_STRING_FUNCTION &&
                (strcmp(afternext->text,"concat")==0 || strcmp(afternext->text,"concat1")==0 ||
                strcmp(afternext->text,"concat2")==0 || strcmp(afternext->text,"concat12")==0 ) ) {
            afternext->text=strcat_malloc("de",afternext->text);
            astp toadd=afternext;
            *tree=ast_new_wparam(T_ARTIFICIAL,"(",toadd);
        }
    }
}
/*
 * If the access is using a string key, then no need to check for a string
 */
void improve_attachAspis(astp * tree) {
    astp tt=*tree;
    //if (tt->type==T_NULL) tt=tt->parameters[0];
    if (strcmp(tt->text,"attachAspis")==0) {
        astp next=nextp(tt);
        astp afternext=next->parameters[0]->parameters[1]->parameters[0];
        if (afternext->type==T_ARTIFICIAL && strcmp(afternext->text,"(")==0) afternext=afternext->parameters[0];
        printf("remove attachAspis? %s, %d\n",afternext->text,afternext->type);
        fflush(stdout);
        if (afternext!=NULL && afternext->type==T_CONSTANT_ENCAPSED_STRING) {
            astp res=ast_new_wparam(T_NULL,NULL,next->parameters[0]->parameters[0]);
            dereference_aspis_nofunction(&res); //put the [] back in
            astp p=ast_new_wparam(T_ARTIFICIAL,"[",afternext);
            ast_add_parameter(res,p);
            *tree=res;
        }
    }
}


void ast_improve_bfs(FILE *out, astp* tree) {
    int i = 0;
    if (*tree != NULL) {
        //printf("[%d] %s\n", (*tree)->type, (*tree)->text);
        switch ((*tree)->type) {
            case T_STRING_FUNCTION:
                improve_current(tree);
                improve_node_generic(out, tree, NULL);
                break;
            case T_STMT_EXPR:
                improve_return_value(tree);
                improve_node_generic(out, tree, NULL);
                break;
            default:
                improve_node_generic(out, tree, NULL);
        }
        for (i = 0; i < (*tree)->total_children; i++) {
            ast_improve_bfs(out, &((*tree)->children[i]));
        }
    }
}
void ast_improve_bfs_concat(FILE *out, astp* tree) {
    int i = 0;
    if (*tree != NULL) {
        //printf("[%d] %s\n", (*tree)->type, (*tree)->text);
        switch ((*tree)->type) {
            case T_STRING_FUNCTION:
                improve_concat(tree);
             default:
                improve_node_generic_concat(out, tree, NULL);
        }
        for (i = 0; i < (*tree)->total_children; i++) {
            ast_improve_bfs_concat(out, &((*tree)->children[i]));
        }
    }
}
void ast_improve_bfs_attachAspis(FILE *out, astp* tree) {
    int i = 0;
    if (*tree != NULL) {
        //printf("[%d] %s\n", (*tree)->type, (*tree)->text);
        switch ((*tree)->type) {
            case T_STRING_FUNCTION:
                improve_attachAspis(tree);
             default:
                improve_node_generic_attachAspis(out, tree, NULL);
        }
        for (i = 0; i < (*tree)->total_children; i++) {
            ast_improve_bfs_attachAspis(out, &((*tree)->children[i]));
        }
    }
}

void improve_node_generic(FILE * out, astp * tree, char * name) {
    if (*tree != NULL) {
        int i = 0;
        for (i = 0; i < (*tree)->total_parameters; i++) {
            ast_improve_bfs(out, &((*tree)->parameters[i]));
        }
    }
}
void improve_node_generic_concat(FILE * out, astp * tree, char * name) {
    if (*tree != NULL) {
        int i = 0;
        for (i = 0; i < (*tree)->total_parameters; i++) {
            ast_improve_bfs_concat(out, &((*tree)->parameters[i]));
        }
    }
}
void improve_node_generic_attachAspis(FILE * out, astp * tree, char * name) {
    if (*tree != NULL) {
        int i = 0;
        for (i = 0; i < (*tree)->total_parameters; i++) {
            ast_improve_bfs_attachAspis(out, &((*tree)->parameters[i]));
        }
    }
}


void ast_improve(FILE * out, astp * tree) {
    if (IMPROVE_AST) {
        ast_improve_bfs(out,tree);
        ast_improve_bfs_concat(out,tree);
        ast_improve_bfs_attachAspis(out,tree);
        if (!is_online) fprintf(out,"Improved!\n");
    }
    else if (!is_online) fprintf(out,"Improoving turned off.\n");
    
}
