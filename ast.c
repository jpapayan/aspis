#include "ast.h"
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int print=0;
void die(const char *name)
{
	perror(name);
	exit(-1);
}
//takes 2 strings and concats them to a new string.
char * strcat_malloc(const char * s1,const char * s2) {
   if (print) { printf("strcat_malloc..."); fflush(stdout);}
    char *tmp;
   if (s1 != NULL && s2!=NULL) {
        tmp = (char *) malloc((strlen(s1) + strlen(s2) + 1) * sizeof (char));
   }
   else if (s1 == NULL && s2!=NULL) {
       tmp = (char *) malloc((strlen(s2) + 1) * sizeof (char));
   }
   else if (s1 != NULL && s2==NULL) {
       tmp = (char *) malloc((strlen(s1) + 1) * sizeof (char));
   }
   else if (s1 == NULL && s2==NULL) {
       tmp = (char *) malloc(sizeof (char));
   }
   if (tmp==NULL) die("malloc failed");
   tmp[0]='\0';
   if (s1 != NULL) {
        char *s1d = strdup(s1);
        if (s1d != NULL) tmp = strcat(tmp, s1d);
   }
   if (s2 != NULL) {
        char *s2d = strdup(s2);
        if (s2 != NULL && s2d != NULL) tmp = strcat(tmp, s2d);
   }
   if (print) printf("done\n");
   return tmp;
}
char * strcpy_malloc(const char * s) {
    //printf("start"); fflush(stdout);
    char * tmp=NULL;
    if (s!=NULL) {
        tmp=(char *)malloc(sizeof(char)*(strlen(s)+1));
        if (tmp==NULL) die("malloc failed");
        strcpy(tmp,s);
    }
    else {
        tmp=(char*)malloc(sizeof(char));
        if (tmp==NULL) die("malloc failed");
        tmp[0]='\0';
    }
   // printf("stop"); fflush(stdout);
    return tmp;
}
char *path_join(char * p1,char * p2) {
    char * ret=NULL;
    int p1_len;
    if (p1==NULL || (p1_len=strlen(p1))==0) return p2;
    if (p2==NULL || strlen(p2)==0) return p1;
    if (p1[p1_len-1]=='/') {
        int i=(p2[0]=='/') ? 1 : 0;
        p1=strcat_malloc(p1,p2+i);
        ret=p1;
    }
    else {
        if (p2[0]!='/') p1=strcat_malloc(p1,"/");
        ret=strcat_malloc(ret,p2);
    }
    return ret;
}


astp ast_new(int type,const char * text) {
   if (print) { printf("ast_new...%s",text); fflush(stdout);}
   astp res =  (astp) malloc(sizeof(astnode));
   if (res==NULL) die("malloc failed");
   //printf("type=%d\n",type);
   res->type=type;
   res->rewritten=0;
   res->not_array=0;
   if (text!=NULL) res->text=strdup(text);
   else res->text=NULL;
   res->total_parameters=0;
   //res->parameters=NULL;
   res->total_children=0;
   //res->children=NULL;
   if (res->type==31075) {printf("BUG!\n");die("bug found");}
   if (print) printf("done\n"); 
   return res; 
}

astp ast_new_wparam(int type,const char * text, astp p1){
  if (print) { printf("ast_new_wparam...%s->%s",text,p1->text); fflush(stdout);}
  astp r=ast_new(type,text);
  ast_add_parameter(r,p1);
  if (print) printf("done\n");
  return r;
}

astp ast_new_wparams(int type,const char * text, astp p1, astp p2){
  if (print) { printf("ast_new_wparams...%s",text); fflush(stdout);}
  astp r=ast_new(type,text);
  ast_add_parameter(r,p1);
  ast_add_parameter(r,p2);
  if (print) printf("done\n");
  return r;
}

astp ast_new_w3params(int type,const char * text, astp p1, astp p2, astp p3){
  if (print) { printf("ast_new_w3params...%s",text); fflush(stdout);}
  astp r=ast_new(type,text);
  ast_add_parameter(r,p1);
  ast_add_parameter(r,p2);
  ast_add_parameter(r,p3);
  if (print) printf("done\n");
  return r;
}

void ast_add_parameter(astp tree,astp param) {
  //print=1;
  if (tree->type==31075 || param->type==31075) {printf("BUG!\n");die("bug found");}
  if (print) { printf("ast_add_parameter...%d...",tree->total_parameters);
               fflush(stdout);}
   tree->total_parameters+=1;
  
   //tree->parameters=realloc(tree->parameters,tree->total_parameters*sizeof(astp));
   
   //astp * t=(astp *)calloc((tree->total_parameters),sizeof(astp));
   //if (t==NULL) die("calloc");
   //int i;
   //for (i=0;i<tree->total_parameters;i++) {t[i]=NULL;}
   //for (i=0;i<tree->total_parameters-1;i++) {t[i]=tree->parameters[i];}
   //free(tree->parameters); //WTF?! WTF!!!
   //tree->parameters=t;   
   
   
   tree->parameters[tree->total_parameters-1]=param;
   if (print) printf("done\n");
   //print=0;
}

void ast_add_last_parameter(astp tree,astp param) {
  if (print) { printf("ast_add_parameter...%d...",tree->total_parameters);
               fflush(stdout);}
   astp prev;
   while (tree!=NULL) {
       prev=tree;
       if (tree->total_parameters>0) tree=tree->parameters[tree->total_parameters-1];
       else tree=NULL;
   }
   prev->parameters[prev->total_parameters]=param;
   prev->total_parameters+=1;
   if (print) printf("done\n");
   //print=0;
}

void ast_add_child(astp tree,astp nchild) {
  //print=1;
  if (tree->type==31075 || nchild->type==31075) {printf("BUG!\n");die("bug found");}
   if (tree==NULL || nchild==NULL) die("NULL tree\n");
   if (tree->children==NULL && tree->total_children!=0) die("realloc");
   if (print) { printf("ast_add_child...%d...",tree->total_children); fflush(stdout);}
   tree->total_children+=1;

   //astp * t=realloc(tree->children,(tree->total_children)*sizeof(astp));
   //if  (t==NULL) die("realloc");
   //tree->children=t;
   
   //astp * t=(astp *)calloc((tree->total_children),sizeof(astp));
   //if (t==NULL) die("calloc");
   //int i;
   //for (i=0;i<tree->total_children;i++) {t[i]=NULL;}
   //for (i=0;i<tree->total_children-1;i++) {t[i]=tree->children[i];}
   //free(tree->children); //WTF?! WTF!!!
   //tree->children=t;   
    
   tree->children[tree->total_children-1]=nchild;
   if (print) printf("done\n");
   //print=0;
}

void ast_add_symbol(astp t,int type,char * c) {
  astp n=ast_new(type,c);
  ast_add_parameter(t,n);
}

astp getLastChild(astp f) {
  if (f==NULL) { 
    printf("getLastChild called with NULL!");
    exit(-1);
  }
  while (f->total_children!=0) { //vertical list
    f=f->children[0];
  }
  return f;
}

void ast_remove_parameter(astp t,int i) {
    if ( i > (t->total_parameters-1) || i<0 ) {return;}
    else if ( i == (t->total_parameters-1) ) {
        t->total_parameters--;
        t->parameters[t->total_parameters]=NULL;
    }
    else {
        for ( ; i<(t->total_parameters-1); i++) {
            t->parameters[i]=t->parameters[i+1];
        }
        t->parameters[i]=NULL;
        t->total_parameters--;
    }
}
void ast_remove_child(astp t,int i) {
    if ( i > (t->total_children-1 || i<0) ) {printf("BUG!\n");die("bug found");}
    else if ( i == (t->total_children-1) ) {
        t->total_children--;
        t->children[t->total_children]=NULL;
    }
    else {
        for ( ; i<(t->total_children-1); i++) {
            t->children[i]=t->children[i+1];
        }
        t->children[i]=NULL;
        t->total_children--;
    }
}

void ast_clear_parameters(astp t) {
    int i=0;
    for (i=0;i<t->total_parameters;i++) t->parameters[i]=NULL;
    t->total_parameters=0;

}

void ast_clear_children(astp t) {
    int i=0;
    for (i=0;i<t->total_children;i++) t->children[i]=NULL;
    t->total_children=0;

}

astp ast_copy(astp tree) {
    if (tree==NULL) return NULL;
    astp result=ast_new(tree->type, strcpy_malloc(tree->text));
    int i=0;
    for (i=0;i<tree->total_parameters;i++) {
        ast_add_parameter(result,ast_copy(tree->parameters[i]));
    }
    for (i=0;i<tree->total_children;i++) {
        ast_add_child(result,ast_copy(tree->children[i]));
    }
    return result;
}