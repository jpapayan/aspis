#ifndef _FILE_STRUCTURES_H
#define	_FILE_STRUCTURES_H

//The prototype functions

typedef struct {
    int total_parameters;
    char ** types;
} parameter_types;

typedef struct prototype_def {
    char * name;
    char * return_type;
    parameter_types parameters;
} prototype;

void function_file_read(char * , char *** , int *) ;
void taint_file_read(char * , char *** , int *,char *** , int *) ;
int list_search(char** , int , int , int , const char * );
int list_print(char** , int );
void prototypes_file_read(char *, prototype **, int *); //the php lib does not have methods
void uprototypes_read_functions(char *, prototype **, int *);
void uprototypes_read_methods(char *, prototype **, int *); //but user prototypes may contain methods

int prototype_total_parameters(prototype *, int, char*);
char * prototype_parameter_type(prototype *, int , char* , int,int );
int prototype_has_ref_param(prototype *, int , char* );
char * prototype_return_type(prototype * , int , char* );
void prototypes_print(prototype * , int );
int prototypes_find(prototype * , int , char* );

int is_scalar(char * );
int is_void(char * );
int is_ref(char *);
int is_callback(char * );
int is_object(char * );

//The taint category functions
typedef struct {
    char *name;
    char *sink;
} guard;

typedef struct {
    char** flist;
    int fcount;
    guard** glist;
    int gcount;
} taint_category;

typedef struct {
    taint_category ** categories;
    int count;
} taint_category_list;

taint_category_list *category_file_read(char *);
int category_find_index(taint_category_list *, char * );
char * category_find_guard(taint_category_list *, char *);

#endif	/* _FILE_STRUCTURES_H */

