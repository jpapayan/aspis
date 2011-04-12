//#include "ast.h"
#define PRINT_TOKENS 0
#include "php_parser.tab.h"
#include "ast_transformer.h"
#include "ast_improver.h"
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int script_stage=0;
int T_NULL_print=0;


void print_node_generic(FILE *,astp,char *);
void print_node_whitespace(FILE *,astp,char *);
void print_node_data(FILE * ,astp ,char *);

void ast_print_bfs(FILE *out,astp tree) {
  int i=0;
  char *s=NULL;
  if (tree!=NULL) {
    switch (tree->type) {
      case T_INLINE_HTML:
      case T_INLINE_HTML_EQUALS:
	//printf("script_stage=%d\n",script_stage);
	if (script_stage==0) {
	   script_stage=1;
	   print_node_generic(out,tree,tree->text);
	   if (tree->type==T_INLINE_HTML) fprintf(out,"<?php\n");
           else fprintf(out,"<?= ");
	}
	else if (script_stage==1) {
           //printf("total_children=%d\n",tree->total_children);
	   fprintf(out,"?>");
	   print_node_generic(out,tree,tree->text);
	   //if (tree->total_children!=0) {
              if (tree->type==T_INLINE_HTML) fprintf(out,"<?php ");
              else fprintf(out,"<?= ");
	   //}
	}
	break;
      case T_ARTIFICIAL:
	if (strcmp(tree->text,"{")==0) {
	  print_node_generic(out,tree,tree->text);
	  fprintf(out,"}");
	  //if (tree->parameters[0]==NULL || tree->parameters[0]->type!=T_OBJECT_OPERATOR)
	    //fprintf(out,"\n");
	}
	else if (strcmp(tree->text,"\"")==0) {
	  print_node_generic(out,tree,tree->text); //Warning, adds spaces inside the " "
	  fprintf(out,"\""); 
	}
	else if (strcmp(tree->text,"(")==0) {
	  print_node_generic(out,tree,tree->text);
	  fprintf(out,")");
	}
	else if (strcmp(tree->text,"[")==0) {
	  print_node_generic(out,tree,tree->text);
	  fprintf(out,"]");
	}
	else if (strcmp(tree->text,"=")==0 || strcmp(tree->text,"+")==0
	      || strcmp(tree->text,"*")==0 || strcmp(tree->text,"/")==0
	      || strcmp(tree->text,".")==0 || strcmp(tree->text,"-")==0
	      || strcmp(tree->text,"<")==0 || strcmp(tree->text,">")==0
              || strcmp(tree->text,"&")==0 || strcmp(tree->text,"|")==0
              || strcmp(tree->text,"^")==0 || strcmp(tree->text,"%")==0 ) {
	  ast_print_bfs(out,tree->parameters[0]);
	  fprintf(out," %s ",tree->text);
	  for (i=1;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	}
        else if (strcmp(tree->text,"?")==0) {
            ast_print_bfs(out,tree->parameters[0]);
            fprintf(out," ? ");
            ast_print_bfs(out,tree->parameters[1]);
            fprintf(out," : ");
            ast_print_bfs(out,tree->parameters[2]);
            for (i=3;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);

        }
	else if (strcmp(tree->text,"&")==0) print_node_whitespace(out,tree,tree->text);
	else print_node_generic(out,tree,tree->text);
	break;
      case T_FUNCTION_VARIABLE:
        print_node_generic(out,tree,tree->text);
	//fprintf(out,")");
        break;
      case T_FIRST_BRACKET:
        print_node_generic(out,tree,tree->text);
	fprintf(out,"]");
        break;
      case T_NULL:
	if (T_NULL_print) fprintf(out,"T_NULL ");
        print_node_generic(out,tree,NULL);
	break;
      case T_INT_CAST:
	print_node_generic(out,tree,"(int)");
	break;
      case T_DOUBLE_CAST:
	print_node_generic(out,tree,"(double)");
	break;
      case T_STRING_CAST:
	print_node_generic(out,tree,"(string)");
	break;
      case T_ARRAY_CAST:
	print_node_generic(out,tree,"(array)");
	break;
      case T_OBJECT_CAST:
	print_node_generic(out,tree,"(object)");
	break;
      case T_BOOL_CAST:
        print_node_generic(out,tree,"(bool)");
	break;	
      case T_UNSET_CAST:
	print_node_generic(out,tree,"(unset)");
	break;
      case T_INC:
        if (strcmp(tree->text,"B")==0) {
            print_node_generic(out,tree,"++");
        } else {
            print_node_generic(out,tree->parameters[0],tree->parameters[0]->text);
            print_node_data(out,tree,"++");
        }
        break;
      case T_DEC:
        if (strcmp(tree->text,"B")==0) {
            print_node_generic(out,tree,"--");
        } else {
            print_node_generic(out,tree->parameters[0],tree->parameters[0]->text);
            print_node_data(out,tree,"--");
        }
        break;
      case T_DOUBLE_ARROW:
      case T_DOUBLE_ARROW_STATIC:
          if (tree->total_parameters>=2) {
             ast_print_bfs(out,tree->parameters[0]);
	     fprintf(out," %s ","=>");
	     for (i=1;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
          }
          else {
              print_node_generic(out,tree,tree->text);
          }
          break;
      case T_STRING:
      case T_STRING_FUNCTION:
      case T_STRING_FUNCTION_DEF:
      case T_STRING_METHOD:
      case T_STRING_GOTO:
      case T_STRING_CLASSNAME:
      case T_STRING_OBJECTPAR:
      case T_STRING_CONSTNAME:
      case T_VARIABLE:
      case T_NOT_ARRAY:
      case T_LNUMBER:
      case T_DNUMBER:
      case T_NUM_STRING:
      case T_STRING_VARNAME:
      case T_CONSTANT_ENCAPSED_STRING:
      case T_EVAL:
      case T_ISSET:
      case T_EMPTY:
      case T_EXIT:
      case T_ENCAPSED_AND_WHITESPACE:      
      case T_UNSET:
      case T_HALT_COMPILER:
      case T_INTERFACE:      
      case T_CLASS_C:
      case T_METHOD_C:
      case T_FUNC_C:
      case T_LIST:
      case T_LINE:
      case T_FILE:
      case T_START_HEREDOC:
      case T_PAAMAYIM_NEKUDOTAYIM:
      case T_CHARACTER:
      case T_CC:
      case T_PLUS_UNARY:
      case T_MINUS_UNARY:
      case T_REF:
      case T_STRING_FUNCTION_PAAMAYIM:
      case T_CLASS_DECLARATION:
	print_node_generic(out,tree,tree->text);	
	break;
      case T_END_HEREDOC:
        print_node_generic(out,tree,tree->text);
        fprintf(out,"\n");
	break;
      case T_VAR:
      case T_CLONE:
      case T_USE:
      case T_PRINT:
      case T_RETURN:      
      case T_THROW:
      case T_GOTO:
      case T_INCLUDE: 
      case T_INCLUDE_ONCE: 
      case T_REQUIRE: 
      case T_REQUIRE_ONCE:
      case T_ABSTRACT:
      case T_FINAL:
      case T_PRIVATE:
      case T_PROTECTED:
      case T_PUBLIC:
      case T_ECHO:
      case T_NEW:
      case T_GLOBAL:
      case T_STATIC:
      case T_CLASS:
      case T_CONST:
      case T_CASE:
      case T_DEFAULT:
      case T_BREAK:
      case T_CONTINUE:
	print_node_whitespace(out,tree,tree->text);
	break;
      case T_EXTENDS:
      case T_IMPLEMENTS:
        fprintf(out," ");
        print_node_whitespace(out,tree,tree->text);
	break;
      case T_IS_EQUAL:
      case T_IS_NOT_EQUAL:
      case T_IS_IDENTICAL: 
      case T_IS_NOT_IDENTICAL:
      case T_IS_SMALLER_OR_EQUAL:
      case T_IS_GREATER_OR_EQUAL:
      case T_LOGICAL_OR:
      case T_LOGICAL_XOR:
      case T_LOGICAL_AND:
      case T_BOOLEAN_OR:
      case T_BOOLEAN_AND:
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
      case T_SR_EQUAL:
      case T_SL:
      case T_SR:
      case T_INSTANCEOF:
	ast_print_bfs(out,tree->parameters[0]);
	fprintf(out," %s ",tree->text);
	ast_print_bfs(out,tree->parameters[1]);
	for (i=2;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	break;
      case T_FUNCTION:
	if (tree->total_parameters>=4) {
	  fprintf(out, "function ");
	  ast_print_bfs(out,tree->parameters[0]);
	  ast_print_bfs(out,tree->parameters[1]);
	  fprintf(out," ( ");
	  ast_print_bfs(out,tree->parameters[2]);
	  fprintf(out," ) {\n");
	  ast_print_bfs(out,tree->parameters[3]);
	  fprintf(out," }\n");
	  for (i=4;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	}
	else {
	  print_node_generic(out,tree,"ERROR function");
	}
	break;
      case T_FUNCTION_ANONYMOUS:
        if (tree->total_parameters==4) {
	  fprintf(out, "function ");
	  ast_print_bfs(out,tree->parameters[0]);
	  fprintf(out," ( ");
	  ast_print_bfs(out,tree->parameters[1]);
	  fprintf(out," ) ");
          ast_print_bfs(out,tree->parameters[2]);
          fprintf(out," {\n");
	  ast_print_bfs(out,tree->parameters[3]);
	  fprintf(out," }\n");
	  for (i=4;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	}
	else {
	  print_node_generic(out,tree,"ERROR function");
	}
        break;
      case T_OBJECT_OPERATOR:
	print_node_generic(out,tree,"->");
	break;
      case T_IF:
	fprintf(out,"if ( ");
	ast_print_bfs(out,tree->parameters[0]);
	fprintf(out,")\n ");
	for (i=1;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	break;
      case T_ELSEIF:
	fprintf(out,"elseif ( ");
	ast_print_bfs(out,tree->parameters[0]);
	fprintf(out,")\n ");
	for (i=1;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	break;
      case T_ELSE:
	print_node_generic(out,tree,"else \n");
	break;
      case T_ARRAY:
      case T_ARRAY_ASPIS:
	print_node_generic(out,tree,"array");
	break;
      case T_DO:
	fprintf(out,"do ");
	ast_print_bfs(out,tree->parameters[0]);
	fprintf(out,"while (");
	ast_print_bfs(out,tree->parameters[1]);
	fprintf(out," )\n");
	for (i=2;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	break;	
      case T_WHILE:
	fprintf(out,"while ( ");
	ast_print_bfs(out,tree->parameters[0]);
	fprintf(out," )\n");
	for (i=1;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	break;	
      case T_FOR:
	fprintf(out,"for ( ");
	ast_print_bfs(out,tree->parameters[0]);
	fprintf(out," ; ");
	ast_print_bfs(out,tree->parameters[1]);
	fprintf(out," ; ");
	ast_print_bfs(out,tree->parameters[2]);
	fprintf(out," )\n");
	for (i=3;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	break;
      case T_FOREACH:
	fprintf(out,"foreach ( ");
	ast_print_bfs(out,tree->parameters[0]);
	fprintf(out," as ");
	ast_print_bfs(out,tree->parameters[1]);
	fprintf(out," ");
	ast_print_bfs(out,tree->parameters[2]);
	fprintf(out," )\n");
	for (i=3;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	break;
      case T_SWITCH:
	fprintf(out,"switch ( ");
	ast_print_bfs(out,tree->parameters[0]);
	fprintf(out," ) {\n");
	for (i=1;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
        fprintf(out," }\n");
	break;
      case T_DECLARE:
	fprintf(out,"declare ( ");
	ast_print_bfs(out,tree->parameters[0]);
	fprintf(out," )");
	for (i=1;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	break;
      case T_TRY:
	fprintf(out,"try {\n");
	ast_print_bfs(out,tree->parameters[0]);
	fprintf(out,"}\n");
	for (i=1;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	break;
      case T_CATCH:
	fprintf(out,"catch (\n");
	ast_print_bfs(out,tree->parameters[0]);
	fprintf(out," ");
	ast_print_bfs(out,tree->parameters[1]);
	fprintf(out,")\n");
	for (i=2;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	break;
      case T_LABEL:
	print_node_generic(out,tree,tree->text);
	fprintf(out,":\n");
	break;
	
	//Related to heredocs and strings with vars.
      case T_DOLLAR_OPEN_CURLY_BRACES:
	fprintf(out,"$");
      case T_CURLY_OPEN:
	if (PRINT_TOKENS) fprintf(out,"[%d]",T_CURLY_OPEN);
	fprintf(out,"{");
	ast_print_bfs(out,tree->parameters[0]);
	fprintf(out,"}");
	for (i=1;i<tree->total_parameters;i++) ast_print_bfs(out,tree->parameters[i]);
	break;
      case TA_IGNORE:
      case T_STMT_EXPR:
        for (i = 0; i < tree->total_parameters; i++) {
           ast_print_bfs(out, tree->parameters[i]);
        }
        break;

      case T_METHOD_START:
	print_node_generic(out,tree,tree->text);
	break;
	//Symbols that are normally not propagated to the ast.
      case T_STATEMENT_OPAQUE:
        print_node_generic(out,tree,tree->text);
	break;
      case T_ENDDECLARE:
      case T_ENDSWITCH:
      case T_ENDFOR:
      case T_ENDFOREACH:      
      case T_BAD_CHARACTER:
      case T_ENDWHILE:
      case T_DIR:
      case T_COMMENT:
      case T_DOC_COMMENT:
      case T_OPEN_TAG:
      case T_OPEN_TAG_WITH_ECHO:
      case T_CLOSE_TAG:
      case T_WHITESPACE:
      case T_NAMESPACE: //The lexer doesnt support namespaces //TODO
      case T_NS_C:
      case T_NS_SEPARATOR:

	printf("\nWARNGING: Symbol %d should normally not be found.",tree->type);
	break;
      
      default:
	printf("DEFAULT "); fflush(out);
	print_node_generic(out,tree,NULL);
    }
    for (i=0; i<tree->total_children; i++){
      ast_print_bfs(out,tree->children[i]); 
    }
  }
}

void print_node_data(FILE * out,astp tree,char *name) {
  if (tree!=NULL) {
    if (name!=NULL) {
      if (PRINT_TOKENS) fprintf(out,"[%d]",tree->type);
      fprintf(out,"%s",name);
      if (strcmp(name,";")==0) fprintf(out,"\n");
    }
    else {
      if (PRINT_TOKENS) fprintf(out,"[%d]",tree->type);
      if (tree->text!=NULL) fprintf(out,"%s ",tree->text);
      //else fprintf(out,"");
    }
  }
}

void print_node_generic(FILE * out,astp tree,char * name) {
  if (tree!=NULL) {
    print_node_data(out,tree,name);
    int i=0;
    for (i=0; i<tree->total_parameters; i++){
      ast_print_bfs(out,tree->parameters[i]); 
    }
  }
}

void print_node_whitespace(FILE * out,astp tree,char * name) {
  if (tree!=NULL) {
    print_node_data(out,tree,name);
    fprintf(out," ");
    int i=0;
    for (i=0; i<tree->total_parameters; i++){
      ast_print_bfs(out,tree->parameters[i]); 
    }
  }
}

void process_tree(char *aspis_home, char* outpath, char * taintspath, char* prototypespath, char *filename, astp tree) {
    FILE * fout = NULL;
    if (outpath != NULL) {
        fout = fopen(outpath, "w");
        if (fout == NULL) {
            die("Cannot write to output");
        }
    } else fout = stdout;

    if (!is_online) {
        printf("\n\n==========================\n");
        printf("|       Parsing AST      |\n");
        printf("==========================\n\n");
    }
    if (tree->type != T_INLINE_HTML && tree->type != T_INLINE_HTML_EQUALS) {
        astp p = ast_new(T_INLINE_HTML, "");
        ast_add_child(p, tree);
        tree = p;
    }
    if (!is_online) ast_print_bfs(stdout, tree);

    if (!is_online) {
        printf("\n\n==========================\n");
        printf("|     Transforming AST     |\n");
        printf("==========================\n\n");
    }
    astp functions_used;
    ast_transform(stdout,aspis_home, taintspath, prototypespath, filename, &tree, &functions_used);

    if (!is_online) {
        printf("\n\n==========================\n");
        printf("|      Improving AST      |\n");
        printf("==========================\n\n");
    }
    ast_improve(stdout, &tree);

    if (!is_online) {
        printf("\n\n==========================\n");
        printf("|         Final AST         |\n");
        printf("==========================\n\n");
    }
    script_stage = 0;
    ast_print_bfs(fout, tree);

    if (!is_online) {
        printf("\n\n==========================\n");
        printf("| Built-in  Functions used |\n");
        printf("==========================\n\n");
    }
    script_stage = 0;
    FILE * fused=fopen("/data/Dropbox/php/svn_local/php/PhpParserC/fused.txt","a");
    ast_print_bfs(fused, functions_used);
    fclose(fused);


   //let's output the result
   if (fout!=stdout && !is_online ) {
       fflush(fout);
       close(fout);
       printf("File (%s) closed\n",outpath);
       char str[1000];
       sprintf(str,"cat %s",outpath);
       printf("--------->%s\n",str);
       if (system(str)==-1) die();
       printf("\n----------\n");
   }
   else printf("Did not print the result.\n");
   
}

