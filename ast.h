#ifndef _AST_H
#define	_AST_H

#include <stdio.h>
int is_online;
typedef struct astnode * astp;

typedef struct astnode {
   int type;
   char *text;
   short rewritten;
   short not_array;
   int total_parameters;
   astp parameters[400];
   //astp *parameters;
   int total_children;
   astp children[1000];
   //astp *children;
} astnode;

//Some string manipulation to ease the cruelty of C...
char * strcat_malloc(const char *,const char *);
char * strcpy_malloc(const char * );
char * path_join( char * , char * );

//The ast related onces
astp ast_new(int , const char * );
astp ast_new_wparams(int ,const char *, astp, astp );
astp ast_new_w3params(int ,const char *, astp, astp, astp );
astp ast_new_wparam(int , const char *, astp );
void ast_add_child(astp ,astp );
void ast_add_parameter(astp ,astp );
void ast_add_last_parameter(astp, astp);
void ast_add_symbol(astp,int, char *);
astp getLastChild(astp );
void ast_remove_parameter(astp t,int i);
void ast_remove_child(astp t,int i);
void ast_clear_parameters(astp t);
void ast_clear_children(astp t);
astp ast_copy(astp );

#endif	/* _AST_H */