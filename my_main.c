#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <errno.h>
#include <sys/types.h>
#include <sys/stat.h>
#include "ast.h"
#include <unistd.h>

char * inpath=NULL;
char * outpath=NULL;
char * outfilepath=NULL;
char * taintspath=NULL;
char * infile=NULL;

void print_usage() {
   printf("Usage: /phpparser [-in infile.php]\t[-out \\path\\to\\out\\dir\\]\t[-mode online]\n");
   printf("       If -in or -out are not specified, stdin and stdout are used instead\n");
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
void add_runtime_variables(int collect_info){
    if (taintspath != NULL) {
        if (system("cp phplib/AspisMain.php phplib/AspisMainEdited.php") == -1)
            die("cant copy AspisMain.php");
        FILE * fp = fopen("phplib/AspisMainEdited.php", "a");
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
void copy_includes() {
   char * str=strcat_malloc("cp phplib/AspisObject.php ",outpath);
   if (system(str)==-1) die();
   str=strcat_malloc("cp phplib/AspisTaints.php ",outpath);
   if (system(str)==-1) die();
   str=strcat_malloc("cp phplib/AspisLibrary.php ",outpath);
   if (system(str)==-1) die();
   if (taintspath == NULL) {
        str = strcat_malloc("cp phplib/AspisMain.php ", outpath);
        if (system(str) == -1) die();
    }
   else {
       char * join;
       if (outpath[strlen(outpath)-1]=='/') join=strcat_malloc(outpath,"AspisMain.php");
       else join=strcat_malloc(outpath,"/AspisMain.php");
       str = strcat_malloc("mv phplib/AspisMainEdited.php ", join);
       if (system(str) == -1) die();
   }
   str=strcat_malloc("cp phplib/php_functions.txt ",outpath);
   if (system(str)==-1) die();
   else printf("All included files copied to (%s)\n",str);

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

int my_main(int argc, char* argv[],char** outfilepath_ex,char** taintsfilepath_ex, char** prototypesfilepath, char** filename)
{
   if (argc%2==1 && argc<12 && argc>4) {
      char * m=locate_param(argv,argc,"-mode");
      if (m!=NULL)  is_online=strcmp(m,"online")==0;
      else is_online=0;
      outpath=locate_param(argv,argc,"-out");
      inpath=locate_param(argv,argc,"-in");
      taintspath=locate_param(argv,argc,"-taints");
      *prototypesfilepath=locate_param(argv,argc,"-prototypes");
   }
   if (!is_online) {
        printf("----------------------------------\n");
        int i;
        printf(">>Parameters used:\n");
        for (i = 0; i < argc; i++) printf("%d. %s\n", i, argv[i]);
        if ((argc % 2) == 0 || argc > 11) {
            print_usage();
        }
   }
   if (inpath!=NULL) {
      if (!setin(inpath)) {
         die(">>Dying");
      }
   }

   infile=inpath;//get_filename_only(inpath);
   *filename=infile;

   if (outpath!=NULL && !is_online) {
        struct stat st;
        if (stat(outpath, &st) != 0) {
            if (mkdir(outpath, 0777)) die();
        }
        if (inpath == NULL) {
            outfilepath = (char*) malloc((strlen(outpath) + 200) * sizeof (char));
            strcat(outfilepath, outpath);
            if (outfilepath[strlen(outfilepath) - 1] != '/') strcat(outfilepath, "/");
            strcat(outfilepath, "out.php");
        } else {
            char * tok;
            char * inpathc = (char*) malloc((strlen(inpath) + 1) * sizeof (char));
            strcpy(inpathc, inpath);
            char * name = strtok(inpathc, "/");
            while ((tok = strtok(NULL, "/")) != NULL) {
                name = tok;
            }
            outfilepath = (char*) malloc((strlen(outpath) + strlen(name) + 200) * sizeof (char));
            strcat(outfilepath, outpath);
            if (outfilepath[strlen(outfilepath - 1)] != '/') strcat(outfilepath, "/");
            strcat(outfilepath, name);
        }
        add_runtime_variables(0);
        copy_includes(outpath);
   }
   else outfilepath=outpath;
   if (!is_online) {
       printf("Input File: %s\nOutput Dir:%s\nOutput File:%s\n",inpath,outpath,outfilepath);
       printf("Detected filename: %s\n",infile);
       printf("----------------------------------\n\n");
       fflush(stdout);
   }
   *outfilepath_ex=outfilepath;
   *taintsfilepath_ex=taintspath;
   return 0;
}
