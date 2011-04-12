import os.path
#!/usr/bin/python
# -*- coding: utf-8 -*-

#This file automates compiling a generic PHP Project using Aspis.
#It iterates through all files found under the projects folder and its copies them
#to the output directory. If the file is .php, then Aspis is invoked.

import sys
import os
import glob
from time import *
import sys,random,threading,string,os,signal
from socket import *
from subprocess import *
from threading import Thread
from Queue import Queue
import time

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

def do_measurement(path,attempts):
    www_path="http://localhost" + path[(path.rfind("public_html")+11):]
    results=list()
    for i in range(attempts):
        execute("wget -nv -O /dev/null --quiet "+www_path)
    #total_time=0
    #for t in results:
    #    total_time+=t
    #print www_path+" (avg "+str(attempts)+") :" +str(total_time*1000/float(attempts)) +"msec"
    #print www_path+" (90% "+str(attempts)+") :" +str(1000*results[int(0.9*attempts)]) +"msec"
    execute("php misc/calc_percentile.php "+os.path.join(path, "stats.txt"));

def usage():
    print "Please invoke the program correcly."
    print "-dir directory -out directory [-taints taintsfile -prototypes prototypesfile] "
    print "Note: working directory must be Aspis' main dir."
    sys.exit(1)

if __name__ == '__main__':
    print "==================================================="
    print "|          PhpAspis Measurements for paper        |"
    print "==================================================="

    if len(sys.argv)!=3 and len(sys.argv)!=7:
        print len(sys.argv)
        usage()
        exit()
    rootdir=get_param(sys.argv,"dir")
    if rootdir=="":
        print "No path provided."
        usage()
        exit()
    taints=get_param(sys.argv,"taints")
    prototypes=get_param(sys.argv,"prototypes")
    print "-dir=\t"+rootdir;
    print "-tnts=\t"+taints;
    print "-prot=\t"+prototypes;
    print "==================================================="

    print "\nAll ready, please ENTER to continue with rewritting\n(or CTRL-C me)..."
    xxx=raw_input()

    ##lets fix all the paths and create the relevant dirs
    testsdir=rootdir
    editeddir=os.path.join(testsdir,"edited")
    originaldir=os.path.join(testsdir,"original")
    pgen_originaldir=os.path.join(originaldir,"pgen")
    pgen_editeddir=os.path.join(editeddir,"pgen")
    dbgen_originaldir=os.path.join(originaldir,"dbgen")
    dbgen_editeddir=os.path.join(editeddir,"dbgen")
    wp_originaldir=os.path.join(originaldir,"wp")
    wp_editeddir=os.path.join(editeddir,"wp")
    wp_partial_editeddir=os.path.join(editeddir,"wp_partial")
#    execute("rm -rf "+editeddir)
#    execute("mkdir "+editeddir)
#    execute("mkdir "+pgen_editeddir)
#    execute("mkdir "+dbgen_editeddir)
#    execute("mkdir "+wp_editeddir)
#    execute("mkdir "+wp_partial_editeddir)
    
    execute("rm -f all_results.txt")
    execute("rm -f "+os.path.join(pgen_originaldir,"stats.txt"))
    execute("rm -f "+os.path.join(dbgen_originaldir,"stats.txt"))
    execute("rm -f "+os.path.join(wp_originaldir,"stats.txt"))
    execute("rm -f "+os.path.join(pgen_editeddir,"stats.txt"))
    execute("rm -f "+os.path.join(dbgen_editeddir,"stats.txt"))
    execute("rm -f "+os.path.join(wp_editeddir,"stats.txt"))
    execute("rm -f "+os.path.join(wp_partial_editeddir,"stats.txt"))

#    ##now lets rewrite all projects that don't need
#    execute("python doRewriteProjectAll.py -dir "+pgen_originaldir+" -out "+pgen_editeddir)
#    print "\nPgen ready, please ENTER to continue with rewritting\n(or CTRL-C me)..."
#    xxx=raw_input()
#
#    execute("python doRewriteProjectAll.py -dir "+dbgen_originaldir+" -out "+dbgen_editeddir)
#    print "\nDBgen ready, please ENTER to continue with rewritting\n(or CTRL-C me)..."
#    xxx=raw_input()
#
#    execute("python doRewriteProjectAll.py -dir "+wp_originaldir+" -out "+wp_editeddir)
#    print "\nWP ready, please ENTER to continue with rewritting\n(or CTRL-C me)..."
#    xxx=raw_input()
##
#    execute("python doRewriteProjectAll.py -dir "+wp_originaldir+" -out "+wp_partial_editeddir +" -taints "+taints+" -prototypes "+prototypes)
#    print "\nWP_PARTIAL ready. Done transforming."
#
#    print "\nStarting MEASUREMENTS! (press enter)"
#    xxx=raw_input()
#
#    execute("chmod -R 777 "+editeddir)
#    execute("chmod -R 777 "+pgen_editeddir)
#    execute("chmod -R 777 "+dbgen_editeddir)
#    execute("chmod -R 777 "+wp_editeddir)
#    execute("chmod -R 777 "+wp_partial_editeddir)

    attempts=1000;
#    do_measurement(pgen_originaldir,attempts);
#    time.sleep(5);
#    do_measurement(pgen_editeddir,attempts);
#    time.sleep(5);
#    do_measurement(dbgen_originaldir,attempts);
#    time.sleep(5);
#    do_measurement(dbgen_editeddir,attempts);
#    time.sleep(5);
    do_measurement(wp_editeddir,attempts);
    time.sleep(10);
    do_measurement(wp_originaldir,attempts);
    time.sleep(10);
    do_measurement(wp_partial_editeddir,attempts);
    print "\nALL DONE!"

    ##
