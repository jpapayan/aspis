%{
/*
   +----------------------------------------------------------------------+
   | Zend Engine                                                          |
   +----------------------------------------------------------------------+
   | Copyright (c) 1998-2009 Zend Technologies Ltd. (http://www.zend.com) |
   +----------------------------------------------------------------------+
   | This source file is subject to version 2.00 of the Zend license,     |
   | that is bundled with this package in the file LICENSE, and is        |
   | available throught he world-wide-web at the following url:           |
   | http://www.zend.com/license/2_00.txt.                                |
   | If you did not receive a copy of the Zend license and are unable to  |
   | obtain it through the world-wide-web, please send a note to          |
   | license@zend.com so we can mail you a copy immediately.              |
   +----------------------------------------------------------------------+
   | Authors: Andi Gutmans <andi@zend.com>                                |
   |          Zeev Suraski <zeev@zend.com>                                |
   +----------------------------------------------------------------------+
*/

/* $Id: zend_language_parser.y 277815 2009-03-26 12:37:54Z dmitry $ */

/*
 * LALR shift/reduce conflicts and how they are resolved:
 *
 * - 2 shift/reduce conflicts due to the dangling elseif/else ambiguity. Solved by shift.
 *
 */
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <errno.h>
#include <sys/types.h>
#include <sys/stat.h>
#include "my_main.h"

#define YYERROR_VERBOSE 0 
void yyerror(const char msg[]);
extern int yylineno;
int yylex(void); //to avoid a gcc warning
char * aspis_home=NULL;
char * outputfilepath=NULL;
char * taintsfilepath=NULL;
char * prototypesfilepath=NULL;
char * categoriesfilepath=NULL;
char * filename=NULL;
%}

//%pure_parser
%expect 2
%code requires {   
   //#include "ast.h"
   #include "ast_parser.h"
   struct lvalstruct {
      char *or;
      char *ed;
   };
   typedef struct lvalstruct * lvalpointer;
}
%union{
   lvalpointer text;
   astp tree;
   int integer;
}
%left T_INCLUDE T_INCLUDE_ONCE T_EVAL T_REQUIRE T_REQUIRE_ONCE
%left ','
%left T_LOGICAL_OR
%left T_LOGICAL_XOR
%left T_LOGICAL_AND
%right T_PRINT
%left '=' T_PLUS_EQUAL T_MINUS_EQUAL T_MUL_EQUAL T_DIV_EQUAL T_CONCAT_EQUAL T_MOD_EQUAL T_AND_EQUAL T_OR_EQUAL T_XOR_EQUAL T_SL_EQUAL T_SR_EQUAL
%left '?' ':'
%left T_BOOLEAN_OR
%left T_BOOLEAN_AND
%left '|'
%left '^'
%left '&'
%nonassoc T_IS_EQUAL T_IS_NOT_EQUAL T_IS_IDENTICAL T_IS_NOT_IDENTICAL
%nonassoc '<' T_IS_SMALLER_OR_EQUAL '>' T_IS_GREATER_OR_EQUAL
%left T_SL T_SR
%left '+' '-' '.'
%left '*' '/' '%'
%right '!'
%nonassoc T_INSTANCEOF
%right '~' T_INC T_DEC T_INT_CAST T_DOUBLE_CAST T_STRING_CAST T_ARRAY_CAST T_OBJECT_CAST T_BOOL_CAST T_UNSET_CAST '@'
%right '['
%nonassoc T_NEW T_CLONE
%token T_EXIT
%token T_IF
%left T_ELSEIF
%left T_ELSE
%left T_ENDIF
%token <text>T_LNUMBER
%token <text>T_DNUMBER
%token <text>T_STRING
%token <text>T_STRING_VARNAME
%token <text>T_VARIABLE
%token <text>T_NUM_STRING
%token <text>T_INLINE_HTML
%token <text>T_CHARACTER
%token <text>T_BAD_CHARACTER
%token <text>T_ENCAPSED_AND_WHITESPACE
%token <text>T_CONSTANT_ENCAPSED_STRING
%token T_ECHO
%token T_DO
%token T_WHILE
%token T_ENDWHILE
%token T_FOR
%token T_ENDFOR
%token T_FOREACH
%token T_ENDFOREACH
%token T_DECLARE
%token T_ENDDECLARE
%token T_AS
%token T_SWITCH
%token T_ENDSWITCH
%token T_CASE
%token T_DEFAULT
%token T_BREAK
%token T_CONTINUE
%token T_GOTO
%token T_FUNCTION
%token T_CONST
%token T_RETURN
%token T_TRY
%token T_CATCH
%token T_THROW
%token T_USE
%token T_GLOBAL
%right T_STATIC T_ABSTRACT T_FINAL T_PRIVATE T_PROTECTED T_PUBLIC
%token T_VAR
%token T_UNSET
%token T_ISSET
%token T_EMPTY
%token T_HALT_COMPILER
%token T_CLASS
%token T_INTERFACE
%token T_EXTENDS
%token T_IMPLEMENTS
%token T_OBJECT_OPERATOR
%token T_DOUBLE_ARROW
%token T_LIST
%token T_ARRAY
%token T_CLASS_C
%token T_METHOD_C
%token T_FUNC_C
%token T_LINE
%token T_FILE
%token T_COMMENT
%token T_DOC_COMMENT
%token T_OPEN_TAG
%token T_OPEN_TAG_WITH_ECHO
%token T_CLOSE_TAG
%token T_WHITESPACE
%token <text> T_START_HEREDOC
%token <text> T_END_HEREDOC
%token T_DOLLAR_OPEN_CURLY_BRACES
%token T_CURLY_OPEN
%token T_PAAMAYIM_NEKUDOTAYIM
%token T_NAMESPACE
%token T_NS_C
%token T_DIR
%token T_NS_SEPARATOR
//My tokens
%token T_LABEL
%token T_ARTIFICIAL
%token T_NULL
%token T_CC
%token T_MINUS_UNARY
%token T_PLUS_UNARY
%token T_REF
%token T_FIRST_BRACKET
//used to sign that a rewritten object access is not an array.
%token T_NOT_ARRAY
//used for '(' to sign a variable function call
%token T_FUNCTION_VARIABLE
%token T_FUNCTION_ANONYMOUS
//these are used as "do nothing" alternatives to T_STRING, as T_STRING are now protected in Aspis
%token T_STRING_FUNCTION
%token T_STRING_FUNCTION_DEF
%token T_STRING_FUNCTION_PAAMAYIM
%token T_STRING_GOTO
%token T_STRING_EXCEPTION
%token T_STRING_CLASSNAME
%token T_STRING_INTERFACE
%token T_STRING_OBJECTPAR
%token T_STRING_METHOD
%token T_STRING_CONSTNAME
//these mark the definition of a new class 
%token T_METHOD_START
//this is used for static array declarations
%token T_DOUBLE_ARROW_STATIC
//this is used to mark arrays() created as aspides (used in impoover.c)
%token T_ARRAY_ASPIS
//dummy token echoed in the final file. I use this when I want to echo sth on the output
%token T_STATEMENT_OPAQUE
//used to sign the start of a new class declaration (T_CLASS was not enough)
%token T_CLASS_DECLARATION
//This represents <?= php blocks
%token <text> T_INLINE_HTML_EQUALS
//PHPAspis Tokens
%token TA_IGNORE
%token T_STMT_EXPR

%type <tree> variable
%type <tree> base_variable_with_function_calls
%type <tree> compound_variable
%type <tree> base_variable
%type <tree> reference_variable
%type <tree> top_statement_list
%type <tree> top_statement
%type <tree> namespace_name
%type <tree> statement
%type <tree> use_declarations
%type <tree> use_declaration
%type <tree> constant_declaration
%type <tree> static_scalar
%type <tree> class_declaration_statement
%type <tree> function_declaration_statement
%type <tree> unticked_statement
%type <tree> inner_statement_list
%type <tree> else_single
%type <tree> elseif_list
%type <tree> expr
%type <tree> inner_statement
%type <tree> while_statement
%type <tree> for_expr
%type <tree> for_statement
%type <tree> non_empty_for_expr
%type <tree> switch_case_list
%type <tree> case_list
%type <tree> expr_without_variable
%type <tree> global_var_list
%type <tree> global_var
%type <tree> r_variable
%type <tree> simple_indirect_reference
%type <tree> echo_expr_list
%type <tree> function_call
%type <tree> object_property
%type <tree> object_dim_list
%type <tree> variable_without_objects
%type <tree> variable_name
%type <tree> method_or_not
%type <tree> function_call_parameter_list
%type <tree> non_empty_function_call_parameter_list
%type <tree> variable_property
%type <tree> unset_variables
%type <tree> unset_variable
%type <tree> foreach_variable
%type <tree> foreach_statement
%type <tree> foreach_optional_arg
%type <tree> declare_list
%type <tree> declare_statement
%type <tree> additional_catches
%type <tree> non_empty_additional_catches
%type <tree> additional_catch
%type <tree> function
%type <tree> is_reference
%type <tree> unticked_function_declaration_statement
%type <tree> parameter_list
%type <tree> non_empty_parameter_list
%type <tree> optional_class_type
%type <tree> class_entry_type
%type <tree> extends_from
%type <tree> interface_entry
%type <tree> interface_extends_list
%type <tree> implements_list
%type <tree> interface_list
%type <tree> class_statement_list
%type <tree> member_modifier
%type <tree> non_empty_member_modifiers
%type <tree> method_modifiers
%type <tree> variable_modifiers
%type <tree> class_variable_declaration
%type <tree> class_constant_declaration
%type <tree> class_statement
%type <tree> method_body
%type <tree> static_var_list
%type <tree> fully_qualified_class_name
%type <tree> class_name_reference
%type <tree> dynamic_class_name_reference
%type <tree> dynamic_class_name_variable_property
%type <tree> dynamic_class_name_variable_properties
%type <tree> lexical_vars
%type <tree> lexical_var_list
%type <tree> class_name
%type <tree> exit_expr
%type <tree> backticks_expr
%type <tree> ctor_arguments
%type <tree> common_scalar
%type <tree> static_class_constant
%type <tree> scalar
%type <tree> static_array_pair_list
%type <tree> possible_comma
%type <tree> non_empty_static_array_pair_list
%type <tree> static_member
%type <tree> variable_class_name
%type <tree> dim_offset
%type <tree> assignment_list_element
%type <tree> assignment_list
%type <tree> array_pair_list
%type <tree> non_empty_array_pair_list
%type <tree> encaps_list
%type <tree> encaps_var
%type <tree> encaps_var_offset
%type <tree> internal_functions_in_yacc
%type <tree> isset_variables
%type <tree> class_constant
%type <tree> unticked_class_declaration_statement
%type <tree> new_elseif_list
%type <tree> new_else_single
%type <tree> w_variable
%type <tree> rw_variable
%type <tree> variable_properties
%type <tree> case_separator


%% /* Rules */
start:
	top_statement_list	
   {
      if (!is_online) printf("\nPHP Parsing done.\n"); 
      process_tree(aspis_home, outputfilepath, taintsfilepath, prototypesfilepath, categoriesfilepath, filename, $1);
   }
;

//DONE
top_statement_list:
   top_statement_list  top_statement 
   {
      if ($$->type==T_NULL) {
	  $$=$2;
      }
      else {
	  astp p=getLastChild($1);
	  ast_add_child(p,$2);
	  $$=$1;
      }	
   }
   |	/* empty */ {$$=ast_new(T_NULL,NULL);}
;

//DONE
namespace_name:
   T_STRING 
   {
      $$=ast_new(T_STRING,$1->or);
   }
   |	namespace_name T_NS_SEPARATOR T_STRING 
   {
      astp t=ast_new(T_STRING,$3->or);
      ast_add_child($1,t);
      $$=$1;
   }
;

//DONE
top_statement:
		statement {$$=$1;}
	|	function_declaration_statement	{$$=$1;}
	|	class_declaration_statement {$$=$1;}
	|	T_HALT_COMPILER '(' ')' ';' 
   {
      astp t=ast_new(T_HALT_COMPILER,"__halt_compiler");
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }	
	|	T_NAMESPACE namespace_name ';'	
   {
      astp t=ast_new(T_NAMESPACE,NULL);
      ast_add_parameter(t,$2);
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }
	|	T_NAMESPACE namespace_name '{'	
		top_statement_list '}'		    
   {
      astp t=ast_new(T_NAMESPACE,NULL);
      ast_add_child(t,$2);
      ast_add_child(t,$4);
      $$=t;
   }
	|	T_NAMESPACE '{'					
		top_statement_list '}'
   {
      astp t=ast_new(T_NAMESPACE,NULL);
      ast_add_child(t,ast_new(T_STRING,"")); //anonymous namespace
      ast_add_child(t,$3);
      $$=t;
   }
	|	T_USE use_declarations ';'
   { 
      astp t=ast_new(T_USE,"use");
      ast_add_parameter(t,$2);
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }      
	|	constant_declaration ';'  {ast_add_symbol($1,T_ARTIFICIAL,";"); $$=$1;}
;

//DONE
use_declarations:
		use_declarations ',' use_declaration
   {
      ast_add_child($1,$3);
      $$=$1;
   }
	|	use_declaration {$$=$1;}
;

//DONE
use_declaration:
		namespace_name {$$=$1;}
	|	namespace_name T_AS T_STRING
   {
      ast_add_child($1,ast_new(T_AS,$3->or));
      $$=$1;
   }
	|	T_NS_SEPARATOR namespace_name {$$=$2;}
	|	T_NS_SEPARATOR namespace_name T_AS T_STRING
   {
      ast_add_child($2,ast_new(T_AS,$4->or));
      $$=$2;
   }
;

//DONE
constant_declaration:
		constant_declaration ',' T_STRING '=' static_scalar
   {
      astp s=ast_new(T_STRING_CONSTNAME,$3->or);
      astp e=ast_new_wparams(T_ARTIFICIAL,"=",s,$5);
      astp c=ast_new_wparam(T_ARTIFICIAL,",",e);
      ast_add_parameter($1,c);      
      $$=$1;
   }
	|	T_CONST T_STRING '=' static_scalar
   {
      astp s=ast_new(T_STRING_CONSTNAME,$2->or);
      astp c=ast_new_wparam(T_CONST,"const",s);
      $$=ast_new_wparams(T_ARTIFICIAL,"=",c,$4);
   }

;

//DONE
inner_statement_list:
		inner_statement_list  inner_statement 
   {
      if ($1->type==T_NULL) {/*free($1);*/ $$=$2;}
      else {
         astp p=getLastChild($1);
         ast_add_child(p,$2);
         $$=$1;
      }
   }
	|	/* empty */ {$$=ast_new(T_NULL,NULL);}
;

//DONE
inner_statement:
		statement {$$=$1;}
	|	function_declaration_statement {$$=$1}
	|	class_declaration_statement {$$=$1}
	|	T_HALT_COMPILER '(' ')' ';' 
   {
      astp t=ast_new(T_HALT_COMPILER,NULL);
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }  
;

//DONE
statement:
		unticked_statement  {$$=$1;}
	|	T_STRING ':'  {$$=ast_new(T_LABEL,$1->or); } 
;

//DONE
unticked_statement:
		'{' inner_statement_list '}' {$$=ast_new_wparam(T_ARTIFICIAL,"{",$2);}
	|	T_IF '(' expr ')'  statement  elseif_list else_single
   {
      astp t=ast_new(T_IF,NULL);
      ast_add_parameter(t,$3);
      ast_add_parameter(t,$5);
      ast_add_parameter(t,$6);
      ast_add_parameter(t,$7);
      $$=t;
   }
	|	T_IF '(' expr ')' ':' inner_statement_list 
                new_elseif_list new_else_single T_ENDIF ';' 
   {
      fflush(stdout);
      astp t=ast_new(T_IF,":");
      ast_add_parameter(t,$3);
      astp c=ast_new_wparam(T_ARTIFICIAL,"{",$6);
      ast_add_parameter(t,c);
      ast_add_parameter(t,$7);
      ast_add_parameter(t,$8);
      $$=t;
   }
	|	T_WHILE '('  expr  ')'  while_statement 
   {
      astp t=ast_new(T_WHILE,NULL);
      ast_add_parameter(t,$3);
      ast_add_parameter(t,$5);
      $$=t;
   }
	|	T_DO  statement T_WHILE '('  expr ')' ';' 
   {
      astp t=ast_new(T_DO,NULL);
      ast_add_parameter(t,$2);
      ast_add_parameter(t,$5);
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }
	|	T_FOR '(' for_expr ';' for_expr	';' for_expr ')' for_statement 
   {
      astp t=ast_new(T_FOR,NULL);
      ast_add_parameter(t,$3);
      ast_add_parameter(t,$5);
      ast_add_parameter(t,$7);
      ast_add_parameter(t,$9);
      $$=t;
   }
	|	T_SWITCH '(' expr ')'	 switch_case_list 
   {
      astp t=ast_new(T_SWITCH,NULL);
      ast_add_parameter(t,$3);
      ast_add_parameter(t,$5);
      $$=t;
   }
	|	T_BREAK ';' 
   {
      astp t=ast_new(T_BREAK,"break");
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t
   }
	|	T_BREAK expr ';' 
   {
      astp t=ast_new(T_BREAK,"break");
      ast_add_parameter(t,$2);
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }
	|	T_CONTINUE ';' 
   {
      astp t=ast_new(T_CONTINUE,"continue");
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }
	|	T_CONTINUE expr ';'		
   {
      astp t=ast_new(T_CONTINUE,"continue");
      ast_add_parameter(t,$2);
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }
	|	T_RETURN ';' 
   {
      astp t=ast_new(T_RETURN,"return");
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }
	|	T_RETURN expr_without_variable ';'
   {
      astp t=ast_new(T_RETURN,"return");
      ast_add_parameter(t,$2);
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }
	|	T_RETURN variable ';'
   {
      astp t=ast_new(T_RETURN,"return");
      ast_add_parameter(t,$2);
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }
	|	T_GLOBAL global_var_list ';'
   {
      astp t=ast_new(T_GLOBAL,"global");
      ast_add_parameter(t,$2);
      $$=t;
      ast_add_symbol(t,T_ARTIFICIAL,";");
   }
	|	T_STATIC static_var_list ';'
   {
      astp t=ast_new(T_STATIC,"static");
      ast_add_parameter(t,$2);
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }
	|	T_ECHO echo_expr_list ';'
   {
      astp t=ast_new(T_ECHO,"echo");
      ast_add_parameter(t,$2);
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }
	|	T_INLINE_HTML
   {
      astp t=ast_new(T_INLINE_HTML,$1->or);
      $$=t;
   }		
	|	T_INLINE_HTML_EQUALS
   {
      astp t=ast_new(T_INLINE_HTML_EQUALS,$1->or);
      $$=t;
   }	
	|	expr ';' 
   {
      astp c=ast_new(T_ARTIFICIAL,";");
      $$=ast_new_wparams(T_STMT_EXPR,NULL,$1,c);
      //ast_add_parameter($1,c);
      //$$=$1;
   }
	|	T_UNSET '(' unset_variables ')' ';'
   {
      astp p=ast_new_wparam(T_ARTIFICIAL,"(",$3);
      astp t=ast_new_wparam(T_UNSET,"unset",p);
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }
	|	T_FOREACH '(' variable T_AS		
		foreach_variable foreach_optional_arg ')' 
		foreach_statement 
   {
      astp t=ast_new(T_FOREACH,NULL);
      ast_add_parameter(t,$3);
      ast_add_parameter(t,$5);
      ast_add_parameter(t,$6);
      ast_add_parameter(t,$8);
      $$=t;
   }
	|	T_FOREACH '(' expr_without_variable T_AS		
		variable foreach_optional_arg ')' 
		foreach_statement 
   {
      astp t=ast_new(T_FOREACH,NULL);
      ast_add_parameter(t,$3);
      ast_add_parameter(t,$5);
      ast_add_parameter(t,$6);
      ast_add_parameter(t,$8);
      $$=t;
   }
	|	T_DECLARE  '(' declare_list ')' declare_statement 
   {
      astp t=ast_new(T_DECLARE,NULL);
      ast_add_parameter(t,$3);
      ast_add_parameter(t,$5);
      $$=t;
   }
	|	';'		/* empty statement */ {$$=ast_new(T_ARTIFICIAL,";")}
	|	T_TRY  '{' inner_statement_list '}'
		T_CATCH '(' 
		fully_qualified_class_name 
		T_VARIABLE ')' 
		'{' inner_statement_list '}' 
		additional_catches 
   {
      astp t=ast_new_wparam(T_TRY,NULL,$3);
      $7->type=T_STRING_EXCEPTION;
      astp c=ast_new_wparam(T_CATCH,NULL,$7);
      astp var=ast_new(T_VARIABLE,$8->or);
      ast_add_parameter(c,var);
      astp p=ast_new_wparam(T_ARTIFICIAL,"{",$11);
      ast_add_parameter(c,p);
      ast_add_parameter(t,c);
      ast_add_parameter(t,$13);
      $$=t;
   }
	|	T_THROW expr ';' 
   {
      astp t=ast_new(T_THROW,"throw");
      ast_add_parameter(t,$2);
      ast_add_symbol(t,T_ARTIFICIAL,";");
      $$=t;
   }
	|	T_GOTO T_STRING ';' 
   {
      astp g=ast_new(T_GOTO,"goto");
      astp s=ast_new(T_STRING_GOTO,$2->or);
      ast_add_parameter(g,s);
      ast_add_symbol(g,T_ARTIFICIAL,";");
      $$=g;
   }
;

//DONE
additional_catches:
		non_empty_additional_catches {$$=$1}
	|	/* empty */ {$$=ast_new(T_NULL,NULL)}
;

//DONE
non_empty_additional_catches:
		additional_catch {$$=$1}
	|	non_empty_additional_catches additional_catch 
   {
      ast_add_parameter($1,$2);
      $$=$1;
   }
;

//DONE
additional_catch:
	T_CATCH '(' fully_qualified_class_name  T_VARIABLE ')'  '{'
inner_statement_list '}' 
   {
        astp c=ast_new(T_CATCH,NULL);
        ast_add_parameter(c,$3);
        $3->type=T_STRING_EXCEPTION;
        astp var=ast_new(T_VARIABLE,$4->or);
        ast_add_parameter(c,var);
        astp p=ast_new_wparam(T_ARTIFICIAL,"{",$7);
        ast_add_parameter(c,p);
        $$=c;
   }
;

//DONE
unset_variables:
		unset_variable {$$=$1;}
	|	unset_variables ',' unset_variable
   {
      astp t=ast_new(T_ARTIFICIAL,",");
      ast_add_parameter(t,$3);
      ast_add_child($1,t);
      $$=$1;
   }
; 

//DONE
unset_variable:
		variable {$$=$1;}
;

//DONE
function_declaration_statement:
		unticked_function_declaration_statement	{$$=$1}
;

//DONE
class_declaration_statement:
		unticked_class_declaration_statement	{$$=$1}
;

//DONE
is_reference:
		/* empty */	{$$=ast_new(T_NULL,NULL)}
	|	'&'		{$$=ast_new(T_REF,"&")}
;

//DONE
unticked_function_declaration_statement:
		function is_reference T_STRING 
			'(' parameter_list ')' '{' inner_statement_list '}' 
   {
      ast_add_parameter($1,$2);
      astp s=ast_new(T_STRING_FUNCTION_DEF,$3->or);
      ast_add_parameter($1,s);
      ast_add_parameter($1,$5);
      ast_add_parameter($1,$8);
      $$=$1;
   }

;

//DONE
unticked_class_declaration_statement:
		class_entry_type T_STRING extends_from
			implements_list
			'{'
				class_statement_list
			'}' 
   {
      astp s=ast_new(T_STRING_CLASSNAME,$2->or);
      ast_add_parameter($1,s);
      ast_add_parameter($1,$3);
      ast_add_parameter($1,$4);
      astp p=ast_new_wparam(T_ARTIFICIAL,"{",$6);
      ast_add_parameter($1,p);
      $$=ast_new_wparam(T_CLASS_DECLARATION,"",$1);
   }
	|	interface_entry T_STRING
			interface_extends_list
			'{'
				class_statement_list
			'}' 
   {
      astp s=ast_new(T_STRING_INTERFACE,$2->or);
      ast_add_parameter($1,s);
      ast_add_parameter($1,$3);
      astp p=ast_new_wparam(T_ARTIFICIAL,"{",$5);
      ast_add_parameter($1,p);
      $$=$1;
   }
;

//DONE
class_entry_type:
		T_CLASS	{$$=ast_new(T_CLASS,"class")}
	|	T_ABSTRACT T_CLASS 
   {
      astp t=ast_new(T_CLASS,"class");
      astp a=ast_new(T_ABSTRACT,"abstract");
      ast_add_parameter(a,t);
      $$=a;
   }
	|	T_FINAL T_CLASS 
   {
      astp t=ast_new(T_CLASS,"class");
      astp a=ast_new(T_FINAL,"final");
      ast_add_parameter(a,t);
      $$=a;
   }
;

//DONE
extends_from:
		/* empty */	{$$=ast_new(T_NULL,NULL)}
	|	T_EXTENDS fully_qualified_class_name 
   {
      astp p=ast_new(T_EXTENDS,"extends");
      ast_add_parameter(p,$2);
      $$=p;
   }
;

//DONE
interface_entry:
	T_INTERFACE		{$$=ast_new(T_INTERFACE,"interface")}
;

//DONE
interface_extends_list:
		/* empty */ {$$=ast_new(T_NULL,NULL)}
	|	T_EXTENDS interface_list
   {
      astp p=ast_new(T_EXTENDS,"extends");
      ast_add_parameter(p,$2);
      $$=p;
   }
;

//DONE
implements_list:
		/* empty */ {$$=ast_new(T_NULL,NULL)}
	|	T_IMPLEMENTS interface_list
   {
      astp p=ast_new(T_IMPLEMENTS,"implements");
      ast_add_parameter(p,$2);
      $$=p;
   }
;

//DONE
interface_list:
		fully_qualified_class_name {$$=$1}
	|	interface_list ',' fully_qualified_class_name
   {
      astp t=ast_new(T_ARTIFICIAL,",");
      ast_add_parameter(t,$3);
      ast_add_child($1,t);
      $$=$1;
   }
;

//DONE
foreach_optional_arg:
		/* empty */	{$$=ast_new(T_NULL,NULL);}				
	|	T_DOUBLE_ARROW foreach_variable	
   {
      astp t=ast_new(T_DOUBLE_ARROW,"=>");
      ast_add_parameter(t,$2);
      $$=t;
   }
;

//DONE
foreach_variable:
		variable	{$$=$1}		
	|	'&' variable	 {$$=ast_new_wparam(T_REF,"&",$2);}	
;

//DONE
for_statement:
		statement {$$=$1;}
	|	':' inner_statement_list T_ENDFOR ';' 
   {  
      $$=ast_new_wparam(T_ARTIFICIAL,"{",$2);
   }
;

//DONE
foreach_statement:
		statement {$$=$1;}
	|	':' inner_statement_list T_ENDFOREACH ';' 
   {  
      $$=ast_new_wparam(T_ARTIFICIAL,"{",$2);
   }

;

//DONE
declare_statement:
		statement {$$=$1}
	|	':' inner_statement_list T_ENDDECLARE ';' {      ast_add_symbol($2,T_ARTIFICIAL,";");$$=$2}
;

//DONE
declare_list:
		T_STRING '=' static_scalar 
   {
      astp t=ast_new(T_ARTIFICIAL,"=");
      astp s=ast_new(T_STRING,$1->or);
      ast_add_parameter(t,s);
      ast_add_parameter(t,$3);
      $$=t;
   }
	|	declare_list ',' T_STRING '=' static_scalar	
   {
      astp t=ast_new(T_ARTIFICIAL,"=");
      astp s=ast_new(T_STRING,$3->or);
      ast_add_parameter(t,s);
      ast_add_parameter(t,$5);
      astp q=ast_new(T_ARTIFICIAL,",");
      ast_add_parameter(q,t);
      ast_add_parameter($1,q);
      $$=$1;
   }
;

//DONE
switch_case_list:
//Destoying original format again, who cares?
		'{' case_list '}' {$$=$2;}
	|	'{' ';' case_list '}' {$$=$3;}
	|	':' case_list T_ENDSWITCH ';' {ast_add_symbol($2,T_ARTIFICIAL,";");$$=$2;}
	|	':' ';' case_list T_ENDSWITCH ';' {ast_add_symbol($3,T_ARTIFICIAL,";");$$=$3;}
;

//DONE
case_list:
		/* empty */	{$$=NULL;}
	|	case_list T_CASE expr case_separator  inner_statement_list 
   {
      astp t=ast_new(T_CASE,"case");
      ast_add_parameter(t,$3);
      ast_add_parameter(t,$4);
      ast_add_parameter(t,$5);
      if ($1==NULL) $$=t;
      else {
         ast_add_child($1,t);
         $$=$1;
      }
   }
	|	case_list T_DEFAULT case_separator  inner_statement_list 
   {
      astp t=ast_new(T_DEFAULT,"default");
      ast_add_parameter(t,$3);
      ast_add_parameter(t,$4);
      if ($1==NULL) $$=t;
      else {
         ast_add_child($1,t);
         $$=$1;
      }
   }
;

//DONE
case_separator:
		':' {$$=ast_new(T_ARTIFICIAL,":")}
	|	';' {$$=ast_new(T_ARTIFICIAL,":")}
;

//DONE
while_statement:
		statement {$$=$1;}
	|	':' inner_statement_list T_ENDWHILE ';' 
   {
      $$=ast_new_wparam(T_ARTIFICIAL,"{",$2);
   }
;


//DONE
elseif_list:
		/* empty */ {$$=ast_new(T_NULL,NULL);}
	|	elseif_list T_ELSEIF '(' expr ')'  statement 
   {
      astp t=ast_new(T_ELSEIF,NULL);
      ast_add_parameter(t,$4);
      ast_add_parameter(t,$6);
      if ($1->type==T_NULL) $$=t;
      else {
         ast_add_parameter($1,t);
         $$=$1;
      }
   }
;

//DONE
new_elseif_list:
		/* empty */ {$$=ast_new(T_NULL,NULL)}
	|	new_elseif_list T_ELSEIF '(' expr ')' ':'  inner_statement_list
   {
      astp t=ast_new(T_ELSEIF,":");
      ast_add_parameter(t,$4);
      astp c=ast_new_wparam(T_ARTIFICIAL,"{",$7);
      ast_add_parameter(t,c);
      if ($1->type==T_NULL) $$=t;
      else {
         ast_add_child($1,t);
         $$=$1;
      }
   }
;

//DONE
else_single:
		/* empty */ {$$=ast_new(T_NULL,NULL)}
	|	T_ELSE statement  
    {
        astp c=ast_new_wparam(T_ARTIFICIAL,"{",$2);
        $$=ast_new_wparam(T_ELSE,NULL,c);
    }
;

//DONE
new_else_single:
		/* empty */ {$$=ast_new(T_NULL,NULL)}
	|	T_ELSE ':' inner_statement_list 
   {
      astp t=ast_new_wparam(T_ARTIFICIAL,"{",$3);
      $$=ast_new_wparam(T_ELSE,NULL,t);
   }
;

//DONE
parameter_list:
		non_empty_parameter_list {$$=$1}
	|	/* empty */ {$$=ast_new(T_NULL,NULL)}
;

//DONE
non_empty_parameter_list:
		optional_class_type T_VARIABLE 
   {
      astp t=ast_new(T_VARIABLE,$2->or);
      if ($1->type!=T_NULL) {
         ast_add_parameter($1,t);
         $$=$1;
      }
      else $$=t;
   }
	|	optional_class_type '&' T_VARIABLE
   {
      astp v=ast_new(T_VARIABLE,$3->or);
      astp a=ast_new(T_REF,"&");
      ast_add_parameter(a,v);
      if ($1->type!=T_NULL) {
         ast_add_parameter($1,a);
         $$=$1;
      }
      else $$=a;
   }
	|	optional_class_type '&' T_VARIABLE '=' static_scalar
   {
      astp e=ast_new(T_ARTIFICIAL,"=");
      astp v=ast_new(T_VARIABLE,$3->or);
      astp a=ast_new_wparam(T_REF,"&",v);
      if ($1->type!=T_NULL) {
         ast_add_parameter($1,a);
         ast_add_parameter(e,$1);
      }
      else {
         ast_add_parameter(e,a);
      }
      ast_add_parameter(e,$5); 
      $$=e;
   }
	|	optional_class_type T_VARIABLE '=' static_scalar
   {
      astp e=ast_new(T_ARTIFICIAL,"=");
      astp v=ast_new(T_VARIABLE,$2->or);
      if ($1->type!=T_NULL) {
         ast_add_parameter($1,v);
         ast_add_parameter(e,$1);
      }
      else {
         ast_add_parameter(e,v);
      }
      ast_add_parameter(e,$4); 
      $$=e;
   }
	|	non_empty_parameter_list ',' optional_class_type T_VARIABLE
   {
      astp t=ast_new(T_VARIABLE,$4->or);
      astp tmp;
      if ($3->type!=T_NULL) {
         ast_add_parameter($3,t);
         tmp=$3;
      }
      else tmp=t;
      astp c=ast_new(T_ARTIFICIAL,",");
      ast_add_parameter(c,tmp);
      ast_add_parameter($1,c);
      $$=$1;   
   }
	|	non_empty_parameter_list ',' optional_class_type '&' T_VARIABLE	
   {
      astp c=ast_new(T_ARTIFICIAL,",");
      astp a=ast_new(T_REF,"&");
      astp v=ast_new(T_VARIABLE,$5->or);
      ast_add_parameter(a,v);
      astp tmp;
      if ($3->type!=T_NULL) {
         ast_add_parameter($3,a);
         tmp=$3;
      }
      else tmp=a;
      ast_add_parameter(c,tmp);
      ast_add_parameter($1,c);
      $$=$1;
   }
	|	non_empty_parameter_list ',' optional_class_type '&' T_VARIABLE
'=' static_scalar 
   {
      astp c=ast_new(T_ARTIFICIAL,",");
      astp e=ast_new(T_ARTIFICIAL,"=");
      astp v=ast_new(T_VARIABLE,$5->or);
      astp a=ast_new_wparam(T_REF,"&",v);
      if ($3->type!=T_NULL) {
         ast_add_parameter($3,a);
         ast_add_parameter(e,$3);
      }
      else {
         ast_add_parameter(e,a);
      }
      ast_add_parameter(e,$7); 
      ast_add_parameter(c,e);
      ast_add_parameter($1,c);
      $$=$1;
   }
	|	non_empty_parameter_list ',' optional_class_type T_VARIABLE '='
static_scalar 	
   {
      astp e=ast_new(T_ARTIFICIAL,"=");
      astp v=ast_new(T_VARIABLE,$4->or);
      if ($3->type!=T_NULL) {
         ast_add_parameter($3,v);
         ast_add_parameter(e,$3);
      }
      else {
         ast_add_parameter(e,v);
      }
      ast_add_parameter(e,$6); 
      astp c=ast_new_wparam(T_ARTIFICIAL,",",e);
      ast_add_parameter($1,c);
      $$=$1;
   }
;

//DONE
optional_class_type:
		/* empty */	{$$=ast_new(T_NULL,NULL)}
	|	fully_qualified_class_name {$$=$1}	
	|	T_ARRAY		{$$=ast_new(T_ARRAY,NULL)}
;

//DONE
function_call_parameter_list:
		non_empty_function_call_parameter_list	{$$=$1}
	|	/* empty */ {$$=ast_new(T_NULL,NULL);}				
;

//DONE
non_empty_function_call_parameter_list:
		expr_without_variable	
   {
      $$=ast_new_wparam(T_NULL,NULL,$1);
   }
	|	variable		
   {
      $$=ast_new_wparam(T_NULL,NULL,$1);
   }
	|	'&' w_variable 
   {
      astp p=ast_new_wparam(T_REF,"&",$2);
      $$=ast_new_wparam(T_NULL,NULL,p);
   }
	|	non_empty_function_call_parameter_list ',' expr_without_variable	
   {
      astp t=ast_new_wparam(T_ARTIFICIAL,",",$3);
      ast_add_parameter($1,t);
      $$=$1;
   }
	|	non_empty_function_call_parameter_list ',' variable
   {
      astp t=ast_new_wparam(T_ARTIFICIAL,",",$3);
      ast_add_parameter($1,t);
      $$=$1;
   }		
	|	non_empty_function_call_parameter_list ',' '&' w_variable	
   {
      astp t=ast_new(T_ARTIFICIAL,",");
      astp n=ast_new(T_REF,"&");
      ast_add_parameter(n,$4);
      ast_add_parameter(t,n);
      ast_add_parameter($1,t);
      $$=$1;
   }
	
;

//DONE
global_var_list:
		global_var_list ',' global_var
   {
      astp t=ast_new(T_ARTIFICIAL,",");
      ast_add_parameter(t,$3);
      ast_add_child($1,t);
      $$=$1;
   }
	|	global_var {$$=ast_new_wparam(T_NULL,NULL,$1);}
;

//DONE
global_var:
		T_VARIABLE	
   {
      $$=ast_new(T_VARIABLE,$1->or)
   }
	|	'$' r_variable  
   {
      $$=ast_new_wparam(T_ARTIFICIAL,"$",$2);
   }
	|	'$' '{' expr '}'
   {
      astp p=ast_new_wparam(T_ARTIFICIAL,"{",$3);
      $$=ast_new_wparam(T_ARTIFICIAL,"$",p);
   }
;

//DONE
static_var_list:
		static_var_list ',' T_VARIABLE 
   {
      astp c=ast_new(T_ARTIFICIAL,",");
      astp s=ast_new(T_VARIABLE,$3->or);
      ast_add_parameter(c,s);
      ast_add_parameter($1,c);
      $$=$1;
   }
	|	static_var_list ',' T_VARIABLE '=' static_scalar
   {
      astp c=ast_new(T_ARTIFICIAL,",");
      astp v=ast_new(T_VARIABLE,$3->or);
      astp e=ast_new(T_ARTIFICIAL,"="); 
      ast_add_parameter(c,e);
      ast_add_parameter(e,v);
      ast_add_parameter(e,$5);
      ast_add_parameter($1,c);
      $$=$1;
   }
	|	T_VARIABLE {$$=ast_new(T_VARIABLE,$1->or)}
	|	T_VARIABLE '=' static_scalar 
   {
      astp v=ast_new(T_VARIABLE,$1->or);
      $$=ast_new_wparams(T_ARTIFICIAL,"=",v,$3); 
   }


;

//DONE
class_statement_list:
		class_statement_list class_statement
   {
      if ($1->type==T_NULL) $$=$2;
      else {
         ast_add_child($1,$2);
         $$=$1;
      }
   }
	|	/* empty */ {$$=ast_new(T_NULL,NULL)}
;

//DONE
class_statement:
		variable_modifiers class_variable_declaration ';'
   {
       ast_add_parameter($1,$2);
       ast_add_symbol($1,T_ARTIFICIAL,";");
       $$=$1;
   }
	|	class_constant_declaration ';' {ast_add_symbol($1,T_ARTIFICIAL,";");$$=$1}
	|	method_modifiers function is_reference T_STRING  '('
			parameter_list ')' method_body 
   {
       ast_add_parameter($2,$3);
       astp s=ast_new(T_STRING_FUNCTION_DEF,$4->or);
       ast_add_parameter($2,s);
       ast_add_parameter($2,$6);
       ast_add_parameter($2,$8);
       ast_add_parameter($1,$2);
       $$=$1;
   }
;

//DONE
method_body:
		';' /* abstract method */	{$$=ast_new(T_ARTIFICIAL,";");}
	|	'{' inner_statement_list '}'	
   {
       astp s=ast_new(T_ARTIFICIAL,"{");
       ast_add_parameter(s,$2);
       $$=s;
   }

;

//DONE
variable_modifiers:
		non_empty_member_modifiers {$$=$1}
	|	T_VAR {$$=ast_new(T_VAR,"var")}
;

//DONE
method_modifiers:
		/* empty */ 
   {
      $$=ast_new(T_METHOD_START,""); 
   }
	|	non_empty_member_modifiers {$$=$1}
;

//DONE
non_empty_member_modifiers:
		member_modifier {$$=ast_new_wparam(T_METHOD_START,"",$1)}
	|	non_empty_member_modifiers member_modifier	
   {
      ast_add_parameter($1,$2);
      $$=$1;
   }
;

//DONE
member_modifier:
		T_PUBLIC {$$=ast_new(T_PUBLIC,"public")}
	|	T_PROTECTED {$$=ast_new(T_PROTECTED,"protected")}
	|	T_PRIVATE {$$=ast_new(T_PRIVATE,"private")}
	|	T_STATIC {$$=ast_new(T_STATIC,"static")}
	|	T_ABSTRACT {$$=ast_new(T_ABSTRACT,"abstract")}
	|	T_FINAL {$$=ast_new(T_FINAL,"final")}
;

//DONE
class_variable_declaration:
		class_variable_declaration ',' T_VARIABLE
   {
      astp v=ast_new(T_VARIABLE,$3->or);
      astp a=ast_new(T_ARTIFICIAL,",");
      ast_add_parameter(a,v);
      ast_add_parameter($1,a);
      $$=$1
   }
	|	class_variable_declaration ',' T_VARIABLE '=' static_scalar	
   {
      astp v=ast_new(T_VARIABLE,$3->or);
      astp c=ast_new_wparam(T_ARTIFICIAL,",",v);
      ast_add_parameter($1,c);
      astp e=ast_new_wparam(T_ARTIFICIAL,"=",$1);
      ast_add_parameter(e,$5);
      $$=e;
   }
	|	T_VARIABLE {$$=ast_new(T_VARIABLE,$1->or)}
	|	T_VARIABLE '=' static_scalar	
   {
      astp v=ast_new(T_VARIABLE,$1->or);
      $$=ast_new_wparams(T_ARTIFICIAL,"=",v,$3);
   }
;

//DONE
class_constant_declaration:
		class_constant_declaration ',' T_STRING '=' static_scalar	
   {
      astp v=ast_new(T_STRING_CONSTNAME,$3->or);
      astp c=ast_new_wparam(T_ARTIFICIAL,",",v);
      ast_add_parameter($1,c);
      astp e=ast_new_wparam(T_ARTIFICIAL,"=",$1);
      ast_add_parameter(e,$5);
      $$=e;
   }
	|	T_CONST T_STRING '=' static_scalar	
   {
      astp s=ast_new(T_STRING_CONSTNAME,$2->or);
      astp c=ast_new_wparam(T_CONST,"const",s);      
      $$=ast_new_wparams(T_ARTIFICIAL,"=",c,$4);       
   }
;

//DONE
echo_expr_list:
		echo_expr_list ',' expr 
   {
      astp t=ast_new(T_ARTIFICIAL,",");
      ast_add_parameter(t,$3);
      ast_add_parameter($1,t);
      $$=$1;
   }
	|	expr 
   {
      $$=ast_new_wparam(T_NULL,NULL,$1);
   }					
;

//DONE
for_expr:
		/* empty */	{$$=ast_new(T_NULL,NULL);}		
	|	non_empty_for_expr	{$$=$1;}
;

//DONE
non_empty_for_expr: //carefull, added last non_empty_for_expr myself
		non_empty_for_expr ','	non_empty_for_expr
   {
      astp t=ast_new_wparam(T_ARTIFICIAL,",",$3);
      ast_add_child($1,t);
      $$=$1;
   }
	|	expr	{$$=$1;}		
;
//DONE
expr_without_variable:
		T_LIST '('  assignment_list ')' '=' expr 
   {
      astp p=ast_new_wparam(T_ARTIFICIAL,"(",$3);
      astp l=ast_new_wparam(T_LIST,"list",p);
      $$=ast_new_wparams(T_ARTIFICIAL,"=",l,$6); 
   }
	|	variable '=' expr {$$=ast_new_wparams(T_ARTIFICIAL,"=",$1,$3)}
	|	variable '=' '&' variable 
   {
      astp t=ast_new(T_ARTIFICIAL,"=");
      ast_add_parameter(t,$1);
      astp a=ast_new(T_REF,"&");
      ast_add_parameter(a,$4);
      ast_add_parameter(t,a);
      $$=t;
   }	

	|	variable '=' '&' T_NEW class_name_reference  ctor_arguments 
   {
      astp t=ast_new(T_ARTIFICIAL,"=");
      ast_add_parameter(t,$1);
      astp a=ast_new(T_REF,"&");
      ast_add_parameter(t,a);
      astp newt=ast_new(T_NEW,"new");
      ast_add_parameter(newt,$5);
      ast_add_parameter(newt,$6);
      ast_add_parameter(a,newt);      
      $$=t;
   }	
	|	T_NEW class_name_reference  ctor_arguments 
   {
      astp newt=ast_new(T_NEW,"new");
      ast_add_parameter(newt,$2);
      ast_add_parameter(newt,$3);
      $$=newt;
   }	
	|	T_CLONE expr 
   {
      astp t=ast_new(T_CLONE,"clone");
      ast_add_parameter(t,$2);
      $$=t;
   }	
	|	variable T_PLUS_EQUAL expr {$$=ast_new_wparams(T_PLUS_EQUAL,"+=",$1,$3)}	
	|	variable T_MINUS_EQUAL expr {$$=ast_new_wparams(T_MINUS_EQUAL,"-=",$1,$3)}	
	|	variable T_MUL_EQUAL expr {$$=ast_new_wparams(T_MUL_EQUAL,"*=",$1,$3)}	
	|	variable T_DIV_EQUAL expr {$$=ast_new_wparams(T_DIV_EQUAL,"/=",$1,$3)}	
	|	variable T_CONCAT_EQUAL expr {$$=ast_new_wparams(T_CONCAT_EQUAL,".=",$1,$3)}	
	|	variable T_MOD_EQUAL expr {$$=ast_new_wparams(T_MOD_EQUAL,"%=",$1,$3)}	
	|	variable T_AND_EQUAL expr {$$=ast_new_wparams(T_AND_EQUAL,"&=",$1,$3)}	
	|	variable T_OR_EQUAL expr {$$=ast_new_wparams(T_OR_EQUAL,"|=",$1,$3)}	
	|	variable T_XOR_EQUAL expr {$$=ast_new_wparams(T_XOR_EQUAL,"^=",$1,$3)}	
	|	variable T_SL_EQUAL expr {$$=ast_new_wparams(T_SL_EQUAL,"<<=",$1,$3)}	
	|	variable T_SR_EQUAL expr {$$=ast_new_wparams(T_SR_EQUAL,">>=",$1,$3)}	
	|	rw_variable T_INC    {
      astp t=ast_new(T_INC,"A"); //B-efore or A-fter the variable
      ast_add_parameter(t,$1);
      $$=t;
   }
	|	T_INC rw_variable {$$=ast_new_wparam(T_INC,"B",$2)}
	|	rw_variable T_DEC 
   {
      astp t=ast_new(T_DEC,"A");
      ast_add_parameter(t,$1);
      $$=t;
   }
	|	T_DEC rw_variable {$$=ast_new_wparam(T_DEC,"B",$2)}
	|	expr T_BOOLEAN_OR  expr {$$=ast_new_wparams(T_BOOLEAN_OR,"||",$1,$3)}
	|	expr T_BOOLEAN_AND  expr {$$=ast_new_wparams(T_BOOLEAN_AND,"&&",$1,$3)}	
	|	expr T_LOGICAL_OR  expr {$$=ast_new_wparams(T_LOGICAL_OR,"or",$1,$3)}	
	|	expr T_LOGICAL_AND  expr {$$=ast_new_wparams(T_LOGICAL_AND,"and",$1,$3)}	
	|	expr T_LOGICAL_XOR expr {$$=ast_new_wparams(T_LOGICAL_XOR,"xor",$1,$3)}	
	|	expr '|' expr	{$$=ast_new_wparams(T_ARTIFICIAL,"|",$1,$3)}
	|	expr '&' expr	{$$=ast_new_wparams(T_ARTIFICIAL,"&",$1,$3)}
	|	expr '^' expr	{$$=ast_new_wparams(T_ARTIFICIAL,"^",$1,$3)}
	|	expr '.' expr 	{$$=ast_new_wparams(T_ARTIFICIAL,".",$1,$3)}
	|	expr '+' expr 	{$$=ast_new_wparams(T_ARTIFICIAL,"+",$1,$3)}
	|	expr '-' expr 	{$$=ast_new_wparams(T_ARTIFICIAL,"-",$1,$3)}
	|	expr '*' expr	{$$=ast_new_wparams(T_ARTIFICIAL,"*",$1,$3)}
	|	expr '/' expr	{$$=ast_new_wparams(T_ARTIFICIAL,"/",$1,$3)}
	|	expr '%' expr 	{$$=ast_new_wparams(T_ARTIFICIAL,"%",$1,$3)}
	| 	expr T_SL expr	{$$=ast_new_wparams(T_SL,"<<",$1,$3)}
	|	expr T_SR expr	{$$=ast_new_wparams(T_SR,">>",$1,$3)}
	|	'+' expr %prec T_INC  { $$=ast_new_wparam(T_PLUS_UNARY,"+",$2); }
	|	'-' expr %prec T_INC  { $$=ast_new_wparam(T_MINUS_UNARY,"-",$2); }
	|	'!' expr {$$=ast_new_wparam(T_ARTIFICIAL,"!",$2)}
	|	'~' expr {$$=ast_new_wparam(T_ARTIFICIAL,"~",$2)}
	|	expr T_IS_IDENTICAL expr {$$=ast_new_wparams(T_IS_IDENTICAL,"===",$1,$3)}
	|	expr T_IS_NOT_IDENTICAL expr 
                {$$=ast_new_wparams(T_IS_NOT_IDENTICAL,"!==",$1,$3)}
	|	expr T_IS_EQUAL expr {$$=ast_new_wparams(T_IS_EQUAL,"==",$1,$3)}
	|	expr T_IS_NOT_EQUAL expr {$$=ast_new_wparams(T_IS_NOT_EQUAL,"!=",$1,$3)}
	|	expr '<' expr {$$=ast_new_wparams(T_ARTIFICIAL,"<",$1,$3)}
	|	expr T_IS_SMALLER_OR_EQUAL expr
                {$$=ast_new_wparams(T_IS_SMALLER_OR_EQUAL,"<=",$1,$3)}
	|	expr '>' expr {$$=ast_new_wparams(T_ARTIFICIAL,">",$1,$3)}
	|	expr T_IS_GREATER_OR_EQUAL expr
                {$$=ast_new_wparams(T_IS_GREATER_OR_EQUAL,">=",$1,$3)}
	|	expr T_INSTANCEOF class_name_reference
                {$$=ast_new_wparams(T_INSTANCEOF,"instanceof",$1,$3)}
	|	'(' expr ')' 	{$$=ast_new_wparam(T_ARTIFICIAL,"(",$2)}
	|	expr '?' expr ':' expr {$$=ast_new_w3params(T_ARTIFICIAL,"?",$1,$3,$5)}	 
	|	expr '?' ':' expr 
   {
      astp n=ast_new(T_NULL,NULL);
      $$=ast_new_w3params(T_ARTIFICIAL,"?",$1,n,$4)
   }    
	|	internal_functions_in_yacc {$$=$1}
	|	T_INT_CAST expr {$$=ast_new_wparam(T_INT_CAST,NULL,$2)}
	|	T_DOUBLE_CAST expr {$$=ast_new_wparam(T_DOUBLE_CAST,NULL,$2)}
	|	T_STRING_CAST expr {$$=ast_new_wparam(T_STRING_CAST,NULL,$2)}
	|	T_ARRAY_CAST expr {$$=ast_new_wparam(T_ARRAY_CAST,NULL,$2)}
	|	T_OBJECT_CAST expr {$$=ast_new_wparam(T_OBJECT_CAST,NULL,$2)}
	|	T_BOOL_CAST expr {$$=ast_new_wparam(T_BOOL_CAST,NULL,$2)}
	|	T_UNSET_CAST expr {$$=ast_new_wparam(T_UNSET_CAST,NULL,$2)}
	|	T_EXIT exit_expr 
   {
      astp tnull ;
      if ($2->type==T_NULL) tnull=$2;
      else tnull=ast_new_wparam(T_NULL,NULL,$2);
      astp t=ast_new_wparam(T_ARTIFICIAL,"(",tnull);
      $$=ast_new_wparam(T_EXIT,"exit",t);
   }
	|	'@'  expr {$$=ast_new_wparam(T_ARTIFICIAL,"@",$2)}
	|	scalar {$$=$1}
	|	T_ARRAY '(' array_pair_list ')'  
   {
      astp t=ast_new_wparam(T_ARTIFICIAL,"(",$3);
      $$=ast_new_wparam(T_ARRAY,NULL,t)
   }
	|	'`' backticks_expr '`'  {$$=ast_new_wparam(T_ARTIFICIAL,"'",$2)}
	|	T_PRINT expr {$$=ast_new_wparam(T_PRINT,"print",$2)} 
	|	function is_reference '(' 
			parameter_list ')' lexical_vars '{' inner_statement_list '}' 
   {
      $1->type=T_FUNCTION_ANONYMOUS;
      ast_add_parameter($1,$2);
      ast_add_parameter($1,$4);
      ast_add_parameter($1,$6);
      ast_add_parameter($1,$8);
      $$=$1;
   }
;

//DONE
function:
	T_FUNCTION {$$=ast_new(T_FUNCTION,"function")}
;

//DONE
lexical_vars:
		/* empty */ {$$=ast_new(T_NULL,NULL)}
	|	T_USE '(' lexical_var_list ')' {$$=ast_new_wparam(T_USE,"use",$3)}
;

//DONE
lexical_var_list:
		lexical_var_list ',' T_VARIABLE
   {
      astp v=ast_new(T_VARIABLE,$3->or);
      astp c=ast_new(T_ARTIFICIAL,",");
      ast_add_parameter(c,v);
      ast_add_parameter($1,c);
      $$=$1;
   }
	|	lexical_var_list ',' '&' T_VARIABLE
   {
      astp a=ast_new(T_REF,"&");
      astp v=ast_new(T_VARIABLE,$4->or);
      astp c=ast_new(T_ARTIFICIAL,",");
      ast_add_parameter(a,v);
      ast_add_parameter(c,a);
      ast_add_parameter($1,c);
      $$=$1;
   }
	|	T_VARIABLE	{$$=ast_new(T_VARIABLE,$1->or)}
	|	'&' T_VARIABLE	
   {
      astp a=ast_new(T_REF,"&");
      astp v=ast_new(T_VARIABLE,$2->or);
      ast_add_parameter(a,v);
      $$=a;
   }
;

//DONE
function_call:
		namespace_name '(' function_call_parameter_list ')' 
   {
      astp p=ast_new_wparam(T_ARTIFICIAL,"(",$3);
      astp q=ast_new_wparam(T_STRING_FUNCTION,$1->text,p);
      $$=q;
      
   }
	|	T_NAMESPACE T_NS_SEPARATOR namespace_name '(' function_call_parameter_list ')'
   {
      astp p=ast_new_wparam(T_ARTIFICIAL,"(",$5);
      ast_add_parameter($3,p);
      astp nss=ast_new_wparam(T_NS_SEPARATOR,NULL,$3);
      $$=ast_new_wparam(T_NAMESPACE,NULL,nss);
   } 
	|	T_NS_SEPARATOR namespace_name '(' function_call_parameter_list ')'
   {
      astp p=ast_new_wparam(T_ARTIFICIAL,"(",$4);
      ast_add_parameter($2,p);
      $$=ast_new_wparam(T_NS_SEPARATOR,NULL,$2);
   } 
	|	class_name T_PAAMAYIM_NEKUDOTAYIM T_STRING '(' function_call_parameter_list ')'
   {
      astp p=ast_new_wparam(T_ARTIFICIAL,"(",$5);
      astp s=ast_new_wparam(T_STRING_FUNCTION_PAAMAYIM,$3->or,p);
      astp dots=ast_new_wparam(T_PAAMAYIM_NEKUDOTAYIM,"::",s);
      ast_add_parameter($1,dots);
      $$=$1;
   } 
	|	class_name T_PAAMAYIM_NEKUDOTAYIM variable_without_objects '(' 
			function_call_parameter_list
			')' 
   {
      astp p=ast_new_wparam(T_ARTIFICIAL,"(",$5);
      astp dots=ast_new_wparam(T_PAAMAYIM_NEKUDOTAYIM,"::",$3);
      ast_add_parameter($1,dots);
      $$=ast_new_wparams(T_FUNCTION_VARIABLE,"",$1,p);
   } 
	|	variable_class_name T_PAAMAYIM_NEKUDOTAYIM T_STRING '(' 
			function_call_parameter_list
			')' 
   {
      astp p=ast_new_wparam(T_ARTIFICIAL,"(",$5);
      astp s=ast_new_wparam(T_STRING_FUNCTION_PAAMAYIM,$3->or,p);
      astp dots=ast_new_wparam(T_PAAMAYIM_NEKUDOTAYIM,"::",s);
      ast_add_parameter($1,dots);
      $$=$1;
   } 
	|	variable_class_name T_PAAMAYIM_NEKUDOTAYIM
variable_without_objects '(' function_call_parameter_list ')' 
   {
      astp p=ast_new_wparam(T_ARTIFICIAL,"(",$5);
      astp dots=ast_new_wparam(T_PAAMAYIM_NEKUDOTAYIM,"::",$3);
      ast_add_parameter($1,dots);
      $$=ast_new_wparams(T_FUNCTION_VARIABLE,"",$1,p);
   } 
	|	variable_without_objects  '(' function_call_parameter_list ')'
   {
      astp p=ast_new_wparam(T_ARTIFICIAL,"(",$3);
      $$=ast_new_wparams(T_FUNCTION_VARIABLE,"",$1,p);
   }
;

//DONE
class_name:
		T_STATIC {$$=ast_new(T_STATIC,NULL)}
//My edit (see below, it's the same):
        |       fully_qualified_class_name {$$=$1}
//Original grammar
//	|	namespace_name {$$=$1}
//	|	T_NAMESPACE T_NS_SEPARATOR namespace_name 
//	|	T_NS_SEPARATOR namespace_name 
;

//DONE
fully_qualified_class_name:
		namespace_name 
   {
      $1->type=T_STRING_CLASSNAME;
      $$=$1
   }
	|	T_NAMESPACE T_NS_SEPARATOR namespace_name 
   {
      astp a=ast_new(T_NAMESPACE,NULL);
      astp b=ast_new(T_NS_SEPARATOR,NULL);
      ast_add_parameter(b,$3);
      ast_add_parameter(a,b);
      $3->type=T_STRING_CLASSNAME;
      $$=a;
   }
	|	T_NS_SEPARATOR namespace_name 
   {
      $2->type=T_STRING_CLASSNAME;
      astp a=ast_new(T_NS_SEPARATOR,NULL);
      ast_add_parameter(a,$2);
      $$=a;
   }
;


//DONE
class_name_reference:
		class_name	{$$=$1}		
	|	dynamic_class_name_reference	{$$=$1}
;

//DONE
dynamic_class_name_reference:
		base_variable T_OBJECT_OPERATOR 
			object_property  dynamic_class_name_variable_properties
   {
      astp t=ast_new_wparams(T_OBJECT_OPERATOR,"->",$3,$4);
      ast_add_parameter($1,t);
      $$=$1;
   }
	|	base_variable {$$=$1}
;

//DONE
dynamic_class_name_variable_properties:
		dynamic_class_name_variable_properties dynamic_class_name_variable_property
   {
      ast_add_parameter($1,$2);
      $$=$1;
   }
	|	/* empty */ {$$=ast_new(T_NULL,NULL)}
;

//DONE
dynamic_class_name_variable_property:
		T_OBJECT_OPERATOR object_property {$$=ast_new_wparam(T_OBJECT_OPERATOR,"->",$2)}
;

//DONE
exit_expr:
		/* empty */	{$$=ast_new(T_NULL,NULL)}
	|	'(' ')'		{$$=ast_new(T_NULL,NULL)}
	|	'(' expr ')'	{$$=$2}
;

//DONE
backticks_expr:
//ip108: deleted the first two, now captured in encaps_list
		/* empty */	{$$=ast_new(T_NULL,NULL);}
//	|	T_ENCAPSED_AND_WHITESPACE
//    {$$=ast_new(T_ENCAPSED_AND_WHITESPACE,$1->or);}
	|	encaps_list	{$$=$1}
;

//DONE
ctor_arguments:
		/* empty */	{$$=ast_new(T_NULL,NULL);}
	|	'(' function_call_parameter_list ')' {$$=ast_new_wparam(T_ARTIFICIAL,"(",$2);}
;

//DONE
common_scalar:
		T_LNUMBER {$$=ast_new(T_LNUMBER,$1->or);}
	|	T_DNUMBER {$$=ast_new(T_DNUMBER,$1->or);}
	|	T_CONSTANT_ENCAPSED_STRING {$$=ast_new(T_CONSTANT_ENCAPSED_STRING,$1->or);}
	|	T_LINE {$$=ast_new(T_LINE,"__LINE__");}
	|	T_FILE {$$=ast_new(T_FILE,"__FILE__");}
	|	T_DIR {$$=ast_new(T_DIR,NULL);}
	|	T_CLASS_C {$$=ast_new(T_CLASS_C,"__CLASS__");} 
	|	T_METHOD_C {$$=ast_new(T_METHOD_C,"__METHOD__");}
	|	T_FUNC_C {$$=ast_new(T_FUNC_C,"__FUNCTION__");}
	|	T_NS_C	{$$=ast_new(T_NS_C,NULL);}
//ip108: what is the point of this rule? Apart from causing s/r, r/r...
/*	|	T_START_HEREDOC T_ENCAPSED_AND_WHITESPACE T_END_HEREDOC 
   {
      astp e=ast_new(T_END_HEREDOC,$3->or);
      astp enc=ast_new_wparam(T_ENCAPSED_AND_WHITESPACE,$2->or,e);
      $$=ast_new_wparam(T_START_HEREDOC,"<<<",enc);
   } */
	|	T_START_HEREDOC encaps_list T_END_HEREDOC 
   {
      astp e=ast_new(T_END_HEREDOC,$3->or);
      ast_add_last_parameter($2,e);
      $$=ast_new_wparam(T_START_HEREDOC,$1->or,$2);
   }
;

//DONE
static_scalar: /* compile-time evaluated scalars */
		common_scalar {$$=$1}
	|	namespace_name {$$=$1}
	|	T_NAMESPACE T_NS_SEPARATOR namespace_name 
   {
      astp a=ast_new(T_NAMESPACE,NULL);
      astp b=ast_new(T_NS_SEPARATOR,NULL);
      ast_add_parameter(b,$3);
      ast_add_parameter(a,b);
      $$=a;
   }
	|	T_NS_SEPARATOR namespace_name {$$==ast_new_wparam(T_NS_SEPARATOR,NULL,$2);}
	|	'+' static_scalar {$$=$2}//$$=ast_new_wparam(T_PLUS_UNARY,"+",$2)}
	|	'-' static_scalar 
   {
      $2->text=strcat_malloc("-",$2->text);
      $$=$2;//ast_new_wparam(T_MINUS_UNARY,"-",$2)
   }
	|	T_ARRAY '(' static_array_pair_list ')' 
   {
      astp t=ast_new_wparam(T_ARTIFICIAL,"(",$3);
      $$=ast_new_wparam(T_ARRAY,"array",t);
   }
	|	static_class_constant {$$=$1}
;

//DONE
static_class_constant:
		class_name T_PAAMAYIM_NEKUDOTAYIM T_STRING 
   {
      astp s=ast_new(T_STRING_CONSTNAME,$3->or);
      astp dots=ast_new_wparam(T_PAAMAYIM_NEKUDOTAYIM,"::",s);
      ast_add_parameter($1,dots);
      $$=$1;
   } 
;

//DONE
scalar:
		T_STRING_VARNAME {$$=ast_new(T_STRING_VARNAME,$1->or)}		
	|	class_constant {$$=$1}
	|	namespace_name	{$$=$1}
	|	T_NAMESPACE T_NS_SEPARATOR namespace_name 
   {
      astp a=ast_new(T_NAMESPACE,NULL);
      astp b=ast_new(T_NS_SEPARATOR,NULL);
      ast_add_parameter(b,$3);
      ast_add_parameter(a,b);
      $$=a;
   }
	|	T_NS_SEPARATOR namespace_name {$$==ast_new_wparam(T_NS_SEPARATOR,NULL,$2);}
	|	common_scalar {$$=$1}
	|	'\"' encaps_list '\"'
{$$=ast_new_wparam(T_ARTIFICIAL,"\"",$2)}
//ip108: added to avoid s/r and r/r if encaps_list is empty
//	|	'"'  '"' 
//   { 
//      astp t=ast_new(T_ARTIFICIAL,"\"");
//      $$=ast_new_wparam(T_ARTIFICIAL,"\"",t);
//   }

;

//DONE
static_array_pair_list:
		/* empty */ {$$=ast_new(T_NULL,NULL)}
	|	non_empty_static_array_pair_list possible_comma	
   {
      ast_add_parameter($1,$2);
      $$=$1;
   }
;

//DONE
possible_comma:
		/* empty */ {$$=ast_new(T_NULL,NULL)}
	|	',' {$$=ast_new(T_ARTIFICIAL,",")}
;

//DONE
non_empty_static_array_pair_list:
		non_empty_static_array_pair_list ',' static_scalar
T_DOUBLE_ARROW static_scalar	
   {
      $3->rewritten=1;
      astp a=ast_new_wparams(T_DOUBLE_ARROW_STATIC,"=>",$3,$5);
      astp c=ast_new_wparam(T_ARTIFICIAL,",",a);
      ast_add_parameter($1,c);
      $$=$1;
   }
	|	non_empty_static_array_pair_list ',' static_scalar 
   {
      astp a=ast_new_wparam(T_ARTIFICIAL,",",$3);
      ast_add_parameter($1,a);
      $$=$1;
   }
	|	static_scalar T_DOUBLE_ARROW static_scalar 
   {
      $1->rewritten=1;
      astp t=ast_new_wparams(T_DOUBLE_ARROW_STATIC,"=>",$1,$3);
      $$=ast_new_wparam(T_NULL,NULL,t);
   }
	|	static_scalar {$$=ast_new_wparam(T_NULL,NULL,$1)}
;

//DONE
expr:
		r_variable {$$=$1}
	|	expr_without_variable {$$=$1}
;

//DONE
r_variable:
	variable {$$=$1}
;

//DONE
w_variable:
	variable {$$=$1}
;
//DONE
rw_variable:
	variable {$$=$1}
;

//DONE
variable:
		base_variable_with_function_calls T_OBJECT_OPERATOR 
			object_property  method_or_not variable_properties
   {
      ast_add_child($3,$4);
      if ($4->type!=T_NULL && $3->type!=T_ARTIFICIAL) $3->type=T_STRING_METHOD;
      astp t=ast_new_wparams(T_OBJECT_OPERATOR,"->",$3,$5);
      ast_add_parameter($1,t);
      if ($4->type!=T_NULL && ($3->type==T_VARIABLE || 
         ($3->type==T_STRING_METHOD && $3->text[0]=='$') )) {
            $3->type=T_VARIABLE;
            $$=ast_new_wparam(T_FUNCTION_VARIABLE,"",$1); 
      }
      else $$=$1; 
   }
	|	base_variable_with_function_calls {$$=$1}
;

//DONE
variable_properties:
		variable_properties variable_property 
   {
         ast_add_parameter($1,$2);
         $$=$1;
   }
	|	/* empty */ {$$=ast_new(T_NULL,NULL);}
;

//DONE
variable_property:
		T_OBJECT_OPERATOR object_property  method_or_not 
   {
      astp t=ast_new(T_OBJECT_OPERATOR,"->");
      ast_add_parameter(t,$2);
      ast_add_parameter($2,$3);
      if ($3->type!=T_NULL) $2->type=T_STRING_METHOD;
      $$=t;
   }
;

//DONE
method_or_not:
		'(' function_call_parameter_list ')'
   {
      astp t=ast_new(T_ARTIFICIAL,"(");
      ast_add_parameter(t,$2);
      $$=t;  
   }
	|	/* empty */  {$$=ast_new(T_NULL,NULL);}
;

//DONE
variable_without_objects:
		reference_variable {$$=$1;}
	|	simple_indirect_reference reference_variable 
   {
      ast_add_parameter($1,$2);
      $$=$1;
   }
;

//DONE
static_member:
		class_name T_PAAMAYIM_NEKUDOTAYIM variable_without_objects 
   {
      astp dots=ast_new_wparam(T_PAAMAYIM_NEKUDOTAYIM,"::",$3);
      ast_add_parameter($1,dots);
      $$=$1;
   }
	|	variable_class_name T_PAAMAYIM_NEKUDOTAYIM variable_without_objects 
   {
      astp dots=ast_new_wparam(T_PAAMAYIM_NEKUDOTAYIM,"::",$3);
      ast_add_parameter($1,dots);
      $$=$1;
   }
;

//DONE
variable_class_name:
		reference_variable {$$=$1}
;

//DONE
base_variable_with_function_calls:
		base_variable	{$$=$1}
	|	function_call {$$=$1}
;

//DONE
base_variable:
		reference_variable {$$=$1;}
	|	simple_indirect_reference reference_variable
   {
      ast_add_parameter($1,$2);
      $$=$1;
   }
	|	static_member {$$=$1;}
;

//DONE
reference_variable:
		reference_variable '[' dim_offset ']'	
   {
      astp t=ast_new(T_ARTIFICIAL,"[");
      ast_add_parameter(t,$3);
      ast_add_parameter($1,t);
      $$=$1
   }
	|	reference_variable '{' expr '}'	
   {
      astp t=ast_new(T_ARTIFICIAL,"[");
      ast_add_parameter(t,$3);
      ast_add_parameter($1,t);
      $$=$1
   }
	|	compound_variable {$$=$1}		
;

//DONE
compound_variable:
		T_VARIABLE {$$=ast_new(T_VARIABLE,$1->or);}
	|	'$' '{' expr '}' 
   {
      astp p=ast_new_wparam(T_ARTIFICIAL,"{",$3);
      $$=ast_new_wparam(T_ARTIFICIAL,"$",p);
   }
;

//DONE
dim_offset:
		/* empty */	{$$=ast_new(T_NULL,NULL)}
	|	expr {$$=$1;}
;

//DONE
object_property:
		object_dim_list {$$=$1;}
	|	variable_without_objects  {$$=$1;}
;

//DONE
object_dim_list:
		object_dim_list '[' dim_offset ']'	
   {
      astp t=ast_new(T_ARTIFICIAL,"[");
      ast_add_parameter(t,$3);
      ast_add_parameter($1,t);
      $$=$1;
   }
	|	object_dim_list '{' expr '}' 
   {
      astp t=ast_new(T_ARTIFICIAL,"[");
      ast_add_parameter(t,$3);
      ast_add_parameter($1,t);
      $$=$1;
   }	
	|	variable_name { $$=$1;}
;

//DONE
variable_name:
		T_STRING	{$$=ast_new(T_STRING_OBJECTPAR,$1->or);}
	|	'{' expr '}'	
   {
      astp t=ast_new(T_ARTIFICIAL,"{");
      ast_add_parameter(t,$2);
      $$=t;
   }
;

//DONE
simple_indirect_reference:
		'$' {$$=ast_new(T_ARTIFICIAL,"$");}
	|	simple_indirect_reference '$' 
   {
      ast_add_parameter($1,ast_new(T_ARTIFICIAL,"$"));
      $$=$1
   }
;

//DONE
assignment_list:
		assignment_list ',' assignment_list_element
   {
      astp element;
      if ($3->total_parameters>0) element=$3->parameters[0] ;
      else element=$3;
      astp c=ast_new_wparam(T_ARTIFICIAL,",",element);
      ast_add_parameter($1,c);
      $$=$1;
   }
	|	assignment_list_element {$$=$1}
;

//DONE
assignment_list_element:
		variable	{$$=ast_new_wparam(T_NULL,NULL,$1);}		
	|	T_LIST '('  assignment_list ')'
    {
	astp p=ast_new_wparam(T_ARTIFICIAL,"(",$3);
	astp p2=ast_new_wparam(T_LIST,"list",p);
        $$=ast_new_wparam(T_NULL,NULL,p2);
    }
	|	/* empty */ {$$=ast_new(T_NULL,NULL)}
;

//DONE
array_pair_list:
		/* empty */ {$$=ast_new(T_NULL,NULL)}
	|	non_empty_array_pair_list possible_comma {ast_add_parameter($1,$2); $$=$1;}
;

//DONE
non_empty_array_pair_list:
		non_empty_array_pair_list ',' expr T_DOUBLE_ARROW expr
   {
      astp a=ast_new_wparams(T_DOUBLE_ARROW,"=>",$3,$5);
      astp c=ast_new_wparam(T_ARTIFICIAL,",",a);
      ast_add_parameter($1,c);
      $$=$1;
   }
	|	non_empty_array_pair_list ',' expr
   {
      astp c=ast_new_wparam(T_ARTIFICIAL,",",$3);
      ast_add_parameter($1,c);
      $$=$1;
   }	
	|	expr T_DOUBLE_ARROW expr {$$=ast_new_wparams(T_DOUBLE_ARROW,"=>",$1,$3);}
	|	expr {$$=ast_new_wparam(T_NULL,NULL,$1);}
	|	non_empty_array_pair_list ',' expr T_DOUBLE_ARROW '&' w_variable 
   {
      astp u=ast_new_wparam(T_REF,"&",$6);
      astp a=ast_new_wparams(T_DOUBLE_ARROW,"=>",$3,u);
      astp c=ast_new_wparam(T_ARTIFICIAL,",",a);
      ast_add_parameter($1,c);
      $$=$1;
   }
	|	non_empty_array_pair_list ',' '&' w_variable 
   {
      astp u=ast_new_wparam(T_REF,"&",$4);
      astp a=ast_new_wparam(T_ARTIFICIAL,",",u);
      ast_add_parameter($1,a);
      $$=$1;
   }
	|	expr T_DOUBLE_ARROW '&' w_variable	
   {
      astp u=ast_new_wparam(T_REF,"&",$4);
      $$=ast_new_wparams(T_DOUBLE_ARROW,"=>",$1,u);
   }
	|	'&' w_variable 
   {
      astp t=ast_new_wparam(T_REF,"&",$2);
      $$=ast_new_wparam(T_NULL,NULL,t);
   }
;

//DONE
  encaps_list:
		encaps_var encaps_list {ast_add_parameter($1,$2); $$=$1;}
	|	T_STRING encaps_list {$$=ast_new_wparam(T_STRING,$1->or,$2);}
	|	T_NUM_STRING encaps_list  {$$=ast_new_wparam(T_NUM_STRING,$1->or,$2);}
	|	T_ENCAPSED_AND_WHITESPACE encaps_list
   {$$=ast_new_wparam(T_ENCAPSED_AND_WHITESPACE,$1->or,$2);}
	|	T_CHARACTER encaps_list {$$=ast_new_wparam(T_CHARACTER,$1->or,$2);}
	|	T_BAD_CHARACTER encaps_list  {$$=ast_new_wparam(T_BAD_CHARACTER,$1->or,$2);}
//let's end the list
	|	T_STRING {$$=ast_new(T_STRING,$1->or);}
	|	T_NUM_STRING {$$=ast_new(T_NUM_STRING,$1->or);} 
	|	T_ENCAPSED_AND_WHITESPACE {$$=ast_new(T_ENCAPSED_AND_WHITESPACE,$1->or)}
	|	T_CHARACTER {$$=ast_new(T_CHARACTER,$1->or);}
	|	T_BAD_CHARACTER {$$=ast_new(T_BAD_CHARACTER,$1->or);}
	|	encaps_var {$$=$1}
;

//DONE
encaps_var:
		T_VARIABLE {$$=ast_new(T_VARIABLE,$1->or)}
	|	T_VARIABLE '['  encaps_var_offset ']'	
   {
      astp t=ast_new_wparam(T_ARTIFICIAL,"[",$3);
      $$=ast_new_wparam(T_VARIABLE,$1->or,t)
   }
	|	T_VARIABLE T_OBJECT_OPERATOR T_STRING 
   {
      astp s=ast_new(T_STRING_OBJECTPAR,$3->or);
      astp o=ast_new_wparam(T_OBJECT_OPERATOR,"->",s);
      $$=ast_new_wparam(T_VARIABLE,$1->or,o)
   }
	| 	T_DOLLAR_OPEN_CURLY_BRACES expr '}'
                   {$$=ast_new_wparam(T_DOLLAR_OPEN_CURLY_BRACES,"${",$2)}
	|	T_DOLLAR_OPEN_CURLY_BRACES T_STRING_VARNAME '[' expr ']' '}' 
   {
      astp p=ast_new_wparam(T_ARTIFICIAL,"[",$4);
      astp o=ast_new_wparam(T_STRING_VARNAME,$2->or,p);
      $$=ast_new_wparam(T_DOLLAR_OPEN_CURLY_BRACES,"${",o)
   }
	|	T_CURLY_OPEN variable '}'
{$$=ast_new_wparam(T_CURLY_OPEN,"{",$2)}
;

//DONE
encaps_var_offset:
		T_STRING {$$=ast_new(T_STRING,$1->or)}
	|	T_NUM_STRING {$$=ast_new(T_NUM_STRING,$1->or)}
	|	T_VARIABLE {$$=ast_new(T_VARIABLE,$1->or)}
;


//DONE
internal_functions_in_yacc:
		T_ISSET '(' isset_variables ')' 
   {
      astp tnull=ast_new_wparam(T_NULL,NULL,$3);
      astp t=ast_new_wparam(T_ARTIFICIAL,"(",tnull);
      $$=ast_new_wparam(T_ISSET,"isset",t);
   }
	|	T_EMPTY '(' variable ')'	
   {
      astp tnull=ast_new_wparam(T_NULL,NULL,$3);
      astp t=ast_new_wparam(T_ARTIFICIAL,"(",tnull);
      $$=ast_new_wparam(T_EMPTY,"empty",t);
   }
	|	T_INCLUDE expr {$$=ast_new_wparam(T_INCLUDE,"include",$2)}
	|	T_INCLUDE_ONCE expr {$$=ast_new_wparam(T_INCLUDE_ONCE,"include_once",$2)}
	|	T_EVAL '(' expr ')' 
   {
      astp t=ast_new_wparam(T_ARTIFICIAL,"(",$3);
      $$=ast_new_wparam(T_EVAL,"eval",t);
   }
	|	T_REQUIRE expr {$$=ast_new_wparam(T_REQUIRE,"require",$2)}
	|	T_REQUIRE_ONCE expr {$$=ast_new_wparam(T_REQUIRE_ONCE,"require_once",$2)}
;

//DONE
isset_variables:
		variable {$$=$1}
	|	isset_variables ','  variable 
   {
      astp t=ast_new_wparam(T_ARTIFICIAL,",",$3);
      ast_add_parameter($1,t);
      $$=$1;
   }
;

//DONE
class_constant:
		class_name T_PAAMAYIM_NEKUDOTAYIM T_STRING 
   {
      astp t=ast_new(T_STRING_CONSTNAME,$3->or);
      astp w=ast_new_wparam(T_PAAMAYIM_NEKUDOTAYIM,"::",t);
      ast_add_parameter($1,w);
      $$=$1;
   }
	|	variable_class_name T_PAAMAYIM_NEKUDOTAYIM T_STRING 
   {
      astp t=ast_new(T_STRING_CONSTNAME,$3->or);
      astp w=ast_new_wparam(T_PAAMAYIM_NEKUDOTAYIM,"::",t);
      ast_add_parameter($1,w);
      $$=$1;
   }
;

%%

void yyerror (const char* msg)
{

	if (!is_online) printf("PARSER ERROR line %d:\n%s\n",yylineno, msg);
	exit(0); //no error recovery please
}

int main(int argc, char* argv[])
{
   my_main(argc,argv,&aspis_home,&outputfilepath,&taintsfilepath,&prototypesfilepath, &categoriesfilepath, &filename);
   int res=yyparse();
   if (!is_online)  printf("\n>>>yyparse() returned: %d\n",res);
   return 0;
}
