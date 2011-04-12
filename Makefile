GCCPARAMS =
YACC = bison
LEX  = flex
RE2C = re2c
RE2C_FLAGS= -i

.PHONY : default

default: php_parser

php_parser: php_parser.tab.c php_scanner.lex.c
	gcc $(GCCPARAMS) -o php_parser php_scanner.lex.c php_parser.tab.c my_main.c ast.c ast_transformer.c ast_improver.c ast_parser.c file_structures.c -lfl

php_scanner.lex.c: php_scanner.l 
	flex -t php_scanner.l > php_scanner.lex.c

php_parser.tab.c php_parser.tab.h: php_parser.y
	bison -dv php_parser.y

clean:
	rm php_parser.tab.c php_parser.tab.h php_scanner.lex.c php_parser.output php_parser
