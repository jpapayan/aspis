import os.path
#!/usr/bin/python
# -*- coding: utf-8 -*-

#This file automates transforming a generic PHP Project using Aspis.
#It iterates through all files found under the project folder and its copies them
#to the output directory. If the file is .php/.inc, then Aspis is invoked.

import sys
import os
import glob
from time import *
import sys,random,threading,string,os,signal
from socket import *
from subprocess import *
from threading import Thread
from Queue import Queue
from time import *

def file_category(infile):
    infile_no_nums=""
    for c in infile:
       if c>='0' and c<='9':
          continue;
       else:
	  infile_no_nums+=c
    return infile_no_nums
    
def my_sort_asc(inlist):
    res=list()
    for item in inlist:
      res.append(int(item))
    res.sort()
    return res
    
def string_prune(prune,delim):
    index=0
    last_index=0
    for c in prune:
      if c==delim:
         last_index=index
      index=index+1;
    return prune[last_index:]

def get_param(argv,param):
    found=False
    for arg in argv:
        if found :
            return arg
        if arg == "-"+param:
            found=True
    return ""

def get_filename(path):
    return path[(path.rfind("/")+1):]
def get_file_extension(path):
    return path[(path.rfind(".")+1):]
def get_dir(path):
    if path[-1]=='/':
        path=path[:-1]
    return path[:(path.rfind("/"))]
def execute(str):
    p=Popen(str, shell=True)
    p.wait()

def do_rewrite(in_filename,out_dir,taints,prototypes):
        print ".",
        sys.stdout.flush();
        cmd="./aspis -in "+in_filename+ " -out "+out_dir+"/";
        if (taints!=""):
           cmd+=" -taints "+taints;
        if (prototypes!=""):
           cmd+=" -prototypes "+prototypes;
        #Keep all output in a log file for debugging.
        cmd+=" >do_rewrite_project.log";
        execute(cmd);
        out_file=os.path.join(out_dir, get_filename(in_filename));
        ret=os.path.isfile(out_file);
        if (not ret):
            print "FAILED: "+cmd;
            sys.exit();
        return ret;

def usage():
    print "Please invoke the script correctly."
    print "-dir directory -out directory [-fused on]"
    print "[-taints taintsfile -prototypes prototypesfile]"
    print "Type \"$aspis help\" for info."
    sys.exit(1)

if __name__ == '__main__':
    print "==================================================="
    print "|          PhpAspis Rewrite FULL PROJECT           |"
    print "==================================================="

    rootdir=get_param(sys.argv,"dir")
    if len(sys.argv)%2!=1 or rootdir=="":
        print len(sys.argv)
        usage()
        exit()

    out=get_param(sys.argv,"out")
    taints=get_param(sys.argv,"taints")
    prototypes=get_param(sys.argv,"prototypes")
    fused=get_param(sys.argv,"fused")
    print "-dir=\t"+rootdir;
    print "-out=\t"+out;
    print "-fused=\t"+fused+" [optional]"; 
    print "-tnts=\t"+taints+" [optional]";
    print "-prot=\t"+prototypes+" [optional]";
    print "==================================================="
    
    ####let's make PhpAspis
    execute("rm fused.txt");
    execute("rm do_rewrite_project.log");
    p=Popen("make clean", shell=True)
    p.wait()
    p=Popen("make", shell=True)
    p.wait()
    print "\nPhpAspis compiled, please ENTER to continue with rewritting\n(or CTRL-C me if compilation wasn't fine)..."
    xxx=raw_input()
    results=dict()
    succeed_count = 0
    ###now let's rewrite everything
    p=Popen("rm -rf "+out, shell=True)
    p.wait()
    counter=0
    counter_success=0;
    counter_edits=0;
    failed=[];
    for root, subFolders, files in os.walk(rootdir):
        nroot=root.replace(rootdir,out,1);
        p=Popen("mkdir "+nroot, shell=True)
        p.wait()
        for infile in files:
            counter+=1
            ext = get_file_extension(infile);
            if (ext == "php" or ext == "PHP" or ext == "inc" or ext == "INC" ):
                counter_edits+=1;
                if (do_rewrite(os.path.join(root,infile), nroot, taints, prototypes)):
                    counter_success+=1
                else:
                    failed.append(os.path.join(root,infile));
            else:
                execute("cp "+os.path.join(root,infile)+" "+os.path.join(nroot,infile));
        #break
    res_counter=0
    for root, subFolders, files in os.walk(out):
        for infile in files:
            res_counter+=1

    root_dir=get_dir(out);
    print "========================="
    print "|| generated  files: " + str(counter_success) +"/"+str(counter_edits)
    for file in failed:
        print "||               failed:   "+file
    print "|| total      files: " + str(counter)
    print "|| resulting  files: " + str(res_counter)
    print "|| folder: " + rootdir
    print "========================="
