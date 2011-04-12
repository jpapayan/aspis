#include <stdio.h>

typedef struct astnode * astp;

typedef struct astnode {
   int type;
   char *text;
   int total_parameters;
   astp *parameters;
   int total_children;
   astp *children;
} astnode;

char * strcat_malloc(const char *,const char *);
astp ast_new(int , const char * );
astp ast_new_wparams(int ,const char *, astp, astp );
astp ast_new_w3params(int ,const char *, astp, astp, astp );
astp ast_new_wparam(int , const char *, astp );
void ast_add_child(astp ,astp );
void ast_add_parameter(astp ,astp );
void ast_add_symbol(astp,int, char *);