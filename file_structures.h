#ifndef _FILE_STRUCTURES_H
#define	_FILE_STRUCTURES_H

typedef struct {
    int total_parameters;
    char ** types;
} parameter_types;

typedef struct prototype_def {
    char * name;
    char * return_type;
    parameter_types parameters;
} prototype;

void read_php_functions(char * , char *** , int *) ;
void read_php_taints(char * , char *** , int *,char *** , int *) ;
int file_containts_name(char** , int , int , int , const char * );
int file_printall(char** , int );
void function_prototypes_read(char *, prototype **, int *);
void user_function_prototypes_read_functions(char *, prototype **, int *);
void user_function_prototypes_read_methods(char *, prototype **, int *);
int function_prototypes_total_parameters(prototype *, int, char*);
char * function_prototypes_parameter_type(prototype *, int , char* , int,int );
int function_prototypes_has_ref_param(prototype *, int , char* );
char * function_prototypes_return_type(prototype * , int , char* );
void function_prototypes_printall(prototype * , int );
int is_scalar(char * );
int is_void(char * );
int is_ref(char *);
int is_callback(char * );
int is_object(char * );
#endif	/* _FILE_STRUCTURES_H */

