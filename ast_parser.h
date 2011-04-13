#ifndef _AST_PARSER_H
#define	_AST_PARSER_H

#include "ast.h"
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

void ast_print_bfs(FILE *,astp);
void print_node_generic(FILE *,astp,char *);

#endif	/* _AST_PARSER_H */