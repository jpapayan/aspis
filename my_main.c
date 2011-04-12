#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <errno.h>
#include <sys/types.h>
#include <sys/stat.h>
#include "ast.h"
#include <unistd.h>

char * outpath=NULL;
char * outfile=NULL;
char * taintspath=NULL;
char * infile=NULL;

void print_usage() {
   printf("Usage: ./aspis \n"
           "-in infile.php\n\t*the file to transform\n"
           "[-out \\path\\to\\output\\DIR\\]\n\t*the dir where the ouput will be placed\n"
           "[-mode online]\n\t*set when PHP Aspis is invoked at runtime, useless otherwise\n"
           "[-taints file]\n\t*Partial tracking: what is tainted\n"
           "[-prototypes file]\n\t*Partial tracking: all function prototypes\n");
   exit(1);
}
//Locates an input parameter inside argv
char * locate_param(char *argv[],int argc,char * param) {
   char * ret=NULL;
   if (argc>=3) {
       int i;
       for (i=1;i<argc;i+=2) {
          if (strcmp(argv[i],param)==0) {
             ret=argv[i+1];
             break;
          }
       }
   }
   return ret;
}
char * get_taints_filename(char *fn) {
    char * cwd=(char*)malloc(200*sizeof(char));
    cwd = getcwd(cwd, 200);
    cwd = strcat_malloc("\"", cwd);
    cwd = strcat_malloc(cwd, "/");
    cwd = strcat_malloc(cwd, fn);
    cwd = strcat_malloc(cwd, "\"");
    return cwd;
}
void add_runtime_variables(char *aspis_home, int collect_info){
    if (taintspath != NULL) {
        char* p=strcat_malloc("cp ",aspis_home);
        p=path_join(p,"phplib/AspisMain.php AspisMainEdited.php");
        if (system(p) == -1)  die("cant copy AspisMain.php");
        FILE * fp = fopen("AspisMainEdited.php", "a");
/*
        if (collect_info) {
            fprintf(fp,"$ASPIS_INFO_COLLECT=true;\n");
        }
        else {
            fprintf(fp,"$ASPIS_INFO_COLLECT=false;\n");
        }
*/
        fprintf(fp,"$aspis_taint_details_path=%s\n?>\n",get_taints_filename(taintspath));
        fclose(fp);
    }
}
void copy_includes(char *aspis_home) {
   char* copy=strcat_malloc("cp ",aspis_home);
   
   char *p=path_join(copy,"phplib/AspisObject.php ");
   p=strcat_malloc(p,outpath);
   if (system(p)==-1) die();
   
   p=path_join(copy,"phplib/AspisTaints.php ");
   p=strcat_malloc(p,outpath);
   if (system(p)==-1) die();
   
   p=path_join(copy,"phplib/AspisLibrary.php ");
   p=strcat_malloc(p,outpath);
   if (system(p)==-1) die();
   
   p=path_join(copy,"phplib/php_functions.txt ");
   p=strcat_malloc(p,outpath);
   if (system(p)==-1) die();
   
   if (taintspath == NULL) {
        char *p=path_join(copy,"phplib/AspisMain.php ");
        p=strcat_malloc(p,outpath);
        if (system(p) == -1) die();
    }
   else {
       p=path_join(outpath,"AspisMain.php");
       p = strcat_malloc("mv AspisMainEdited.php ", p);
       if (system(p) == -1) die();
   }
   
   printf("All included files copied to (%s)\n",outpath);

}
char * get_filename_only(char * path) {
    char *res;
    int last_slash=0;
    int i;
    for (i=0 ; i<strlen(path) ; i++) {
        if (path[i]=='/') last_slash=i;
    }
    res=strcpy_malloc(path+last_slash+1);
    return res;
}

/*
 * Parsing of console arguments. Plus, copying of the php aspis lib to the output
 */
int my_main(int argc, char* argv[],char** aspis_home, char** outfilepath_ex, char** taintsfilepath_ex, char** prototypesfilepath, char** filename) {
    int i;
    printf(">>Parameters used:\n");
    for (i = 0; i < argc; i++) printf("\t%d. %s\n", i, argv[i]);
    
    //read the configuration parameters from the arguments
    char * m = locate_param(argv, argc, "-mode");
    if (m != NULL) is_online = strcmp(m, "online") == 0;
    else is_online = 0;
    outpath = locate_param(argv, argc, "-out");
    infile = locate_param(argv, argc, "-in");
    taintspath = locate_param(argv, argc, "-taints");
    *prototypesfilepath = locate_param(argv, argc, "-prototypes");
    *aspis_home=strcpy_malloc(getenv("ASPIS_HOME"));
    
    //stop if help was requested or if we had an invalid configuration    
    int asks_for_help = argc==2 && strcmp(argv[1],"help")==0;
    if (asks_for_help ||  infile==NULL ) {
            if (!is_online) print_usage();
            else exit(1);
    }
    if (*aspis_home==NULL) die("ASPIS_HOME environmental variable is not set.");
    
    //now set up the environment according to the arguments
    if (!setin(infile)) die(">>Cannot set the infile");

    *filename = infile;

    if (outpath != NULL && !is_online) {
        //construct the output file name. This will have the same name as the input
        //file, but placed inside the outpath directory.
        struct stat st;
        if (stat(outpath, &st) != 0) {
            if (mkdir(outpath, 0777)) die();
        }

        char * tok;
        char * inpathc = (char*) malloc((strlen(infile) + 1) * sizeof (char));
        strcpy(inpathc, infile);
        char * name = strtok(inpathc, "/");
        while ((tok = strtok(NULL, "/")) != NULL) {
            name = tok;
        }
        outfile = (char*) malloc((strlen(outpath) + strlen(name) + 200) * sizeof (char));
        strcat(outfile, outpath);
        if (outfile[strlen(outfile - 1)] != '/') strcat(outfile, "/");
        strcat(outfile, name);
        
        add_runtime_variables(*aspis_home,0);
        copy_includes(*aspis_home);
    } else outfile = outpath;
    if (!is_online) {
        printf("Input File: %s\nOutput Dir:%s\nOutput File:%s\n", infile, outpath, outfile);
        printf("Detected filename: %s\n", infile);
        printf("----------------------------------\n\n");
        fflush(stdout);
    }
    *outfilepath_ex = outfile;
    *taintsfilepath_ex = taintspath;
    return 0;
}