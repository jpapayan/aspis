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
   char *tmp=(char *)malloc(
      sizeof(strlen(s1)+strlen(s2)+1)*sizeof(char)
   );
   tmp[0]='\0'; 
   char *s1d=strdup(s1);
   if (s1!=NULL && s1d!=NULL) tmp=strcat(tmp,s1d); 
   char *s2d=strdup(s2);
   if (s2!=NULL && s2d!=NULL) tmp=strcat(tmp,s2d);
   if (print) printf("done\n");
   return tmp;
}

astp ast_new(int type,const char * text) {
   if (print) { printf("ast_new...%s",text); fflush(stdout);}
   astp res =  (astp) malloc(sizeof(astnode));
   if (res==NULL) die("malloc");
   //printf("type=%d\n",type);
   res->type=type;
   if (text!=NULL) res->text=strdup(text);
   else res->text=NULL;
   res->total_parameters=0;
   res->parameters=NULL;
   res->total_children=0;
   res->children=NULL;
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
  print=1;
  if (tree->type==31075 || param->type==31075) {printf("BUG!\n");die("bug found");}
  if (print) { printf("ast_add_parameter...%d...",tree->total_parameters);
               fflush(stdout);}
   tree->total_parameters+=1;
   tree->parameters=realloc(tree->parameters,tree->total_parameters*sizeof(astp));
   tree->parameters[tree->total_parameters-1]=param;
   if (print) printf("done\n");
   print=0;
}

void ast_add_child(astp tree,astp nchild) {
  print=1;
  if (tree->type==31075 || nchild->type==31075) {printf("BUG!\n");die("bug found");}
   if (tree==NULL || nchild==NULL) die("NULL tree\n");
   if (tree->children==NULL && tree->total_children!=0) die("realloc");
   if (print) { printf("ast_add_child...%d...",tree->total_children); fflush(stdout);}
   tree->total_children+=1;
   astp * t=realloc(tree->children,(tree->total_children)*sizeof(astp));
   if  (t==NULL) die("realloc");
   tree->children=t;
   //astp * t=(astp *)malloc((tree->total_children)*sizeof(astp));
   //if (t==NULL) die("realloc");
   //int i;
   //for (i=0;i<tree->total_children-1;i++) {t[i]=tree->children[i];}
   //free(tree->children); //WTF?! WTF!!!
   //tree->children=t;   
    
   tree->children[tree->total_children-1]=nchild;
   if (print) printf("done\n");
   print=0;
}


void ast_add_symbol(astp t,int type,char * c) {
  astp n=ast_new(type,c);
  ast_add_parameter(t,n);
}



