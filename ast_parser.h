#include "ast.h"
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

void ast_print_bfs(FILE *,astp);
void process_tree(char *, char*,  char *, char*, char*, astp );
void print_node_generic(FILE *,astp,char *);
