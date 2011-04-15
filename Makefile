GCCPARAMS = -g -std=gnu99
YACC = bison
LEX  = flex
RE2C = re2c
RE2C_FLAGS= -i

.PHONY : default

default: aspis

aspis: php_parser.tab.c php_scanner.lex.c my_main.c ast.c ast_transformer.c ast_improver.c ast_parser.c file_structures.c
	gcc $(GCCPARAMS) -o aspis php_scanner.lex.c php_parser.tab.c my_main.c ast.c ast_transformer.c ast_improver.c ast_parser.c file_structures.c -lfl

php_scanner.lex.c: php_scanner.l 
	flex -t php_scanner.l > php_scanner.lex.c

php_parser.tab.c php_parser.tab.h: php_parser.y
	bison -dv php_parser.y

clean:
	rm php_parser.tab.c php_parser.tab.h php_scanner.lex.c php_parser.output aspis

install: aspis 
	echo "Installing PHPAspis in your home directory..."
	-rm -rI ~/aspis_home
	cp -r ${CURDIR} ~/aspis_home
	echo "export PATH=$$PATH:~/aspis_home" >> ~/.profile
	echo "export ASPIS_HOME=~/aspis_home" >> ~/.profile
	echo "Done!"
	
tests: aspis
	rm -rf tests/results
	do_tests.py -dir tests
	