#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include "file_structures.h"
#include "ast.h"
#include "my_main.h"

/**
 * Reads all bult-in functions of php in an array. The file is sorted in the first place
 */
void function_file_read( char * file, char *** flist, int *fcount) {
    FILE * fp = fopen(file, "r");
    if (fp==NULL) die("Could not open file.");
    if (fp == NULL) die("Failed to read PHP built in functions list\n");
    *fcount=0;
    while (!feof(fp)) {
        if (fgetc(fp) == '\n') (*fcount)++;
    }
    if (*fcount == 0) die("PHP built in functions list is empty?!\n");
    *flist = (char **) malloc((*fcount) * sizeof (char *));
    if (*flist == NULL) die("Malloc failed to hold all PHP functions\n");
    char line[500]="";
    rewind(fp);
    int i = 0;
    for (i = 0; i<*fcount; i++) {
        fscanf(fp, "%s", (char*) line);
        (*flist)[i] = (char *) malloc((strlen(line) + 1) * sizeof (char));
        if ((*flist)[i]==0) die("Malloc failed to store name.");
        strcpy((*flist)[i], line);
    }
    if (fclose(fp)!=0) die("Could not close file?");
}
/**
 * Reads all taints from the taint file in two arrays. The file is sorted
 * (per catrgory) in the first place
 */
void taint_file_read(char * file, char *** flist, int *fcount,char *** clist, int *ccount) {
    FILE * fp = fopen(file, "r");
    if (fp == NULL) die("Failed to read taints list\n");
    int cf=0;
    int cc=0;
    int * cp=&cf;
    while (!feof(fp)) {
        char ch=fgetc(fp);
        if (ch==EOF) break;
        if (cf==0 && cc==0 && ch=='>') continue;
        if (ch=='>') {
            cp=&cc;
            continue;
        }
        if (ch == '\n') (*cp)++;
    }
    cf--; cc--; //one extra line break from the category name

    if (cf == 0 && cc==0) die("Taint functions list is empty?!\n");
    *flist = (char **) malloc((cf) * sizeof (char *));
    if (*flist == NULL) die("Malloc failed to hold all function taints\n");
    *clist = (char **) malloc((cc) * sizeof (char *));
    if (*clist == NULL) die("Malloc failed to hold all class taints\n");
    *fcount=cf;
    *ccount=cc;

    char line[200];
    rewind(fp);
    int inclasses=0;
    int i = 0;
    while (!feof(fp)) {
        int eof=fscanf(fp, "%s", (char*) line);
        if (eof==EOF) break;
        if (i++==0) continue; //ignore first line
        if (strcmp(line,">classes")==0) {
            inclasses=1;
            i=1;
            continue;
        }
        if (!inclasses) {
            (*flist)[i-2] = (char *) malloc((strlen(line) + 1) * sizeof (char));
            strcpy((*flist)[i-2], line);
            //printf("Added1(%d): %s\n",i-2,line);
        } else {
            if (i-2==cc) break;
            (*clist)[i-2] = (char *) malloc((strlen(line) + 1) * sizeof (char));
            strcpy((*clist)[i-2], line);
            //printf("Added2(%d): %s\n",i-2,line);
        }
    }
    fclose(fp);
}
/**
 * Binary search of a single function name in the list
 */
int list_search(char** flist, int fbase, int fcount, int fmax, const char * str) {
    if (fmax==0) return -1;
    if (fmax==1) {
        if (strcmp(flist[0], str)==0) return 0;
        else return -1;
    }
    int my_count = (fcount - fbase) / 2 + fbase; //the middle element in the range
    int res = strcmp(flist[my_count], str);
    if (res == 0) return my_count;
    else if (fcount - fbase <= 1) {
        int i = strcmp(flist[fbase], str);
        if (i == 0) return fbase;
        if (fcount==fmax) return -1;
        i = strcmp(flist[fcount], str);
        if (i == 0) return fcount;
        else return -1;
    } else if (res < 0) return list_search(flist, my_count, fcount, fmax, str);
    else if (res > 0) return list_search(flist, fbase, my_count, fmax, str);
}
int list_print(char** flist, int fcount) {
    int i=0;

    for (i=0;i<fcount;i++) {
        printf("FUNCTION: %s\n",flist[i]);
        fflush(stdout);
    }
}


/*
 * Assumes a cetrainf format form the input files:
 * f_name
 * \tparam_type
 * \tparamtype
 * ...
 * \t\treturntype
 */
void prototypes_file_read(char * file, prototype ** plist, int *pcount) {
    FILE * fp = fopen(file, "r");
    if (fp == NULL) die("Failed to read PHP function proptypes\n");
    char line[200];
    int i = 0;
    *plist=NULL;
    prototype * list=*plist;
    *pcount=0;
    for (i = 0; fgets(line,sizeof line,fp)!=NULL; i++) {
        if (line==NULL || strlen(line)<2) break;
        if (line[0]!='\t') {
            (*pcount)++;
            list=(prototype *)realloc(list, (*pcount) * sizeof(prototype));
            if (list == NULL) die("realloc failed\n");
            (list[*pcount-1]).name=strcpy_malloc(line);
            int t=strlen((list[*pcount-1]).name);
            for (t=t;t>=0;t--) {
                if ((list[*pcount-1]).name[t]=='\n') {
                    (list[*pcount-1]).name[t]='\0';
                    break;
                }
            }
            //printf("%s\n",list[*pcount-1]);
            list[*pcount-1].parameters.total_parameters=0;
            list[*pcount-1].parameters.types=NULL;
            list[*pcount-1].return_type=NULL;
        }
        else if (line[0]=='\t' && line[1]!='\t') {
            int total=++(list[*pcount-1].parameters.total_parameters);
            list[*pcount-1].parameters.types=(char **)realloc(list[*pcount-1].parameters.types, total*sizeof(char **) );
            if (list[*pcount-1].parameters.types == NULL) die("realloc failed\n");
            list[*pcount-1].parameters.types[total-1] = strcpy_malloc(&(line[1]));
            //kill the trailing \n;
            list[*pcount-1].parameters.types[total-1][strlen(list[*pcount-1].parameters.types[total-1])-1]='\0';
        }
        else if (line[0]=='\t' && line[1]=='\t') {
            list[*pcount-1].return_type=strcpy_malloc(&(line[2]));
            //kill the trailing \n;
            list[*pcount-1].return_type[strlen(list[*pcount-1].return_type)-1]='\0';
        }
    }
    *plist=list;
    fclose(fp);
}
void uprototypes_read_functions(char * file, prototype ** plist, int *pcount) {
    FILE * fp = fopen(file, "r");
    if (fp == NULL) die("Failed to read PHP user function proptypes\n");
    char line[200];
    int i = 0;
    *plist=NULL;
    prototype * list=*plist;
    *pcount=0;
    for (i = 0; fgets(line,sizeof line,fp)!=NULL; i++) {
        if (line==NULL || strlen(line)<2) break;
        if (strcmp(line,">functions\n")==0) continue;
        else if (strcmp(line,">methods\n")==0) break;
        if (line[0]!='\t') {
            (*pcount)++;
            list=(prototype *)realloc(list, (*pcount) * sizeof(prototype));
            if (list == NULL) die("realloc failed\n");
            (list[*pcount-1]).name=strcpy_malloc(line);
            int t=strlen((list[*pcount-1]).name);
            for (t=t;t>=0;t--) {
                if ((list[*pcount-1]).name[t]=='\n') {
                    (list[*pcount-1]).name[t]='\0';
                    break;
                }
            }
            //printf("%s\n",list[*pcount-1]);
            list[*pcount-1].parameters.total_parameters=0;
            list[*pcount-1].parameters.types=NULL;
            list[*pcount-1].return_type=NULL;
        }
        else if (line[0]=='\t' && line[1]!='\t') {
            int total=++(list[*pcount-1].parameters.total_parameters);
            list[*pcount-1].parameters.types=(char **)realloc(list[*pcount-1].parameters.types, total*sizeof(char **) );
            if (list[*pcount-1].parameters.types == NULL) die("realloc failed\n");
            list[*pcount-1].parameters.types[total-1] = strcpy_malloc(&(line[1]));
            //kill the trailing \n;
            list[*pcount-1].parameters.types[total-1][strlen(list[*pcount-1].parameters.types[total-1])-1]='\0';
        }
        else if (line[0]=='\t' && line[1]=='\t') {
            list[*pcount-1].return_type=strcpy_malloc(&(line[2]));
            //kill the trailing \n;
            list[*pcount-1].return_type[strlen(list[*pcount-1].return_type)-1]='\0';
        }
    }
    *plist=list;
    fclose(fp);
}
void uprototypes_read_methods(char * file, prototype ** plist, int *pcount) {
    FILE * fp = fopen(file, "r");
    if (fp == NULL) die("Failed to read PHP user method proptypes\n");
    char line[200];
    int i = 0;
    *plist=NULL;
    prototype * list=*plist;
    *pcount=0;
    int methods_started=0;
    for (i = 0; fgets(line,sizeof line,fp)!=NULL; i++) {
        //skip the first part of the file
        if (!methods_started) {
            if (strcmp(line,">methods\n")==0) methods_started=1;
            continue;
        }
        if (line==NULL || strlen(line)<2) break;
        if (line[0]!='\t') {
            (*pcount)++;
            list=(prototype *)realloc(list, (*pcount) * sizeof(prototype));
            if (list == NULL) die("realloc failed\n");
            (list[*pcount-1]).name=strcpy_malloc(line);
            int t=strlen((list[*pcount-1]).name);
            for (t=t;t>=0;t--) {
                if ((list[*pcount-1]).name[t]=='\n') {
                    (list[*pcount-1]).name[t]='\0';
                    break;
                }
            }
            //printf("%s\n",list[*pcount-1]);
            list[*pcount-1].parameters.total_parameters=0;
            list[*pcount-1].parameters.types=NULL;
            list[*pcount-1].return_type=NULL;
        }
        else if (line[0]=='\t' && line[1]!='\t') {
            int total=++(list[*pcount-1].parameters.total_parameters);
            list[*pcount-1].parameters.types=(char **)realloc(list[*pcount-1].parameters.types, total*sizeof(char **) );
            if (list[*pcount-1].parameters.types == NULL) die("realloc failed\n");
            list[*pcount-1].parameters.types[total-1] = strcpy_malloc(&(line[1]));
            //kill the trailing \n;
            list[*pcount-1].parameters.types[total-1][strlen(list[*pcount-1].parameters.types[total-1])-1]='\0';
        }
        else if (line[0]=='\t' && line[1]=='\t') {
            list[*pcount-1].return_type=strcpy_malloc(&(line[2]));
            //kill the trailing \n;
            list[*pcount-1].return_type[strlen(list[*pcount-1].return_type)-1]='\0';
        }
    }
    *plist=list;
    fclose(fp);
}

void prototypes_print(prototype * plist, int pcount) {
    int i=0;
    for (i=0;i<pcount;i++) {
        printf("Prototype: %s\n",plist[i].name);
        printf("      ret: %s\n",plist[i].return_type);
        int j=0;
        for (j=0;j<plist[i].parameters.total_parameters;j++) {
            printf("       p%d: %s\n",j,plist[i].parameters.types[j]);
        }
    }
}
int prototypes_find(prototype * plist, int pcount, char* function) {
    int i=0;
    int res=-1;
    for (i=0;i<pcount;i++) {
        int cmp=strcmp(plist[i].name,function);
        if (cmp==0) {
            res=i;
            break;
        }
        else if (cmp>0) break;
    }
    return res;
}
int prototype_total_parameters(prototype * plist, int pcount, char* function) {
    int index=prototypes_find(plist,pcount,function);
    if (index>-1) return plist[index].parameters.total_parameters;
    else return -1;
}
char * prototype_parameter_type(prototype *plist, int pcount, char* function, int pnum, int ptotal) {
    int index=prototypes_find(plist,pcount,function);
    int total_parameters;
    if (index>-1) {
        total_parameters=plist[index].parameters.total_parameters;
        char* rp_type=NULL;
        int i=0;
        for (i=0;i<total_parameters;i++) {
            if (strstr(plist[index].parameters.types[i],"rp")!=NULL) rp_type=plist[index].parameters.types[i];
            if (rp_type==NULL) {
                if (i==pnum) {
                   return strcpy_malloc(plist[index].parameters.types[pnum]);
                }
            }
            else  {
                if (pnum==ptotal-1) {
                    //printf("READ1:%s %d-%d\n",plist[index].parameters.types[pnum],pnum,ptotal);
                    return strcpy_malloc(plist[index].parameters.types[total_parameters-1]);
                }
                else {
                    //printf("READ2:%s\n",rp_type);
                    return strcpy_malloc(rp_type);
                }
            }
        }
    }
    return strcpy_malloc("");
}
int prototype_has_ref_param(prototype *plist, int pcount, char* function) {
    int res=0;
    int index=prototypes_find(plist,pcount,function);
    if (index>-1) {
        int i=0;
        for (i=0;i<plist[index].parameters.total_parameters;i++) {
            if (strchr(plist[index].parameters.types[i],'&')!=NULL) {
                res=1;
                break;
            }
        }
    }
    return res;
}
char * prototype_return_type(prototype * plist, int pcount, char* function) {
    int index=prototypes_find(plist,pcount,function);
    if (index>-1) return strcpy_malloc(plist[index].return_type);
    else return strcpy_malloc("");
}

int is_scalar(char * type) {
  return strstr(type,"int")!=NULL || strstr(type,"bool")!=NULL || strstr(type,"string")!=NULL
            || strstr(type,"resource")!=NULL || strstr(type,"float")!=NULL;
}
int is_void(char * type) {
  return strstr(type,"void")!=NULL;
}
int is_ref(char * type) {
   return strchr(type,'&')!=NULL ;
}
int is_callback(char * type) {
  return strstr(type,"callback")!=NULL;
}
int is_object(char * type) {
  return strstr(type,"object")!=NULL;
}

//taint category functions
taint_category_list * category_file_read(char * file) {
    taint_category_list *ret=(taint_category_list *)malloc(sizeof(taint_category_list));
    ret->count=0;
    ret->categories=NULL;
    FILE * fp = fopen(file, "r");
    if (fp == NULL) die("Failed to read the taint category file provided\n");
    char line[200];
    while (fscanf(fp, "%s\n", (char*) line)>0) { //category loop
        if (strcmp(line,"begin")==0) {
            taint_category *tc=(taint_category *)malloc(sizeof(taint_category));
            tc->glist=NULL;
            tc->gcount=0;
            tc->flist=NULL;
            tc->fcount=0;
            int reading_sanitisation=0;
            int reading_guards=0;
            while (1) { 
                if (fscanf(fp,"%s\n",(char *)line)==0) break;
                if (strcmp(line,"end")==0) break;
                else if (strcmp(line,">sanitisation")==0) {
                    reading_sanitisation=1; 
                    continue;
                }
                else if (strcmp(line,">guards")==0) {
                    reading_sanitisation=0;
                    reading_guards=1;
                    continue;
                }
                
                if (reading_sanitisation) { 
                    tc->fcount++;
                    tc->flist=(char **)realloc(tc->flist, tc->fcount * (sizeof(char *)) );
                    if (tc->flist == NULL) die("realloc failed\n");
                    tc->flist[tc->fcount-1]=strcpy_malloc(line);
                }
                else if (reading_guards) { 
                    char *tok1=strtok((char *)line,"->");
                    char *tok2=strtok((char *)NULL,"->");
                    if (tok1!=NULL && tok2!=NULL) {
                        guard * g=(guard *)malloc(sizeof(guard));
                        g->name = strcpy_malloc(tok1);
                        g->sink = strcpy_malloc(tok2);
                        tc->gcount++;
                        tc->glist=(guard **)realloc(tc->glist, tc->gcount * (sizeof(guard *)) );
                        if (tc->glist == NULL) die("realloc failed\n");
                        tc->glist[tc->gcount-1]=g;
                    }
                    else die("Invalid guard in the category file");
                }
            }
            //add to the category list
            ret->count++;
            ret->categories=(taint_category **)realloc(ret->categories, ret->count*sizeof(taint_category *));
            ret->categories[ret->count-1]=tc;
        }
    }
    
    fclose(fp);
    return ret;
}
/* 
 * Given a function name, returns the index of the taint category.
 * Returns -1 if the function is not a sanitisation function for any category.
 */
int category_find_index(taint_category_list *tc_list, char * function) {
    //linear search, I expect taint categories to be very sort.
    for (int i=0; i<tc_list->count; i++) {
        taint_category * tc = tc_list->categories[i];
        for ( int j=0; j<tc->fcount; j++ ) {
            if (strcmp(function,tc->flist[j])==0) return i;
        }
    }
    return -1;
}

char * category_find_guard(taint_category_list *tc_list, char * function) {
    //linear search, I expect taint categories to be very sort.
    for (int i=0; i<tc_list->count; i++) {
        taint_category * tc = tc_list->categories[i];
        for ( int j=0; j<tc->gcount; j++ ) {
            if (strcmp(function,tc->glist[j]->name)==0) 
                return strcpy_malloc(tc->glist[j]->sink);
        }
    }
    return NULL;
}

