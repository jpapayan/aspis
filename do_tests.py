#!/usr/bin/python
# -*- coding: utf-8 -*-

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


def do_test(path, infile, taints, prototypes, categories):
        ##cleanup
        p=Popen("rm original.out", shell=True);
        p.wait()
        p=Popen("rm edited.out", shell=True);
        p.wait()

        ##Aspisize the input script
        in_filename=infile
        out_dir=os.path.join(path,"results");
        cmd="aspis -in "+in_filename+ " -out "+out_dir + " -categories "+categories;

        if (taints!=""):
            cmd+=" -taints "+taints;
        elif (infile.find("_partial_")>-1):
            filename=os.path.basename(infile);
            filename=filename[0:filename.find(".")];
            cmd+=" -taints "+ os.path.join(path,"taint_propagation/")+filename+".tainted";
            print cmd;
        if (prototypes!=""):
            cmd+=" -prototypes "+prototypes;
        elif (infile.find("_partial_")>-1):
            filename=os.path.basename(infile);
            filename=filename[0:filename.find(".")];
            cmd+=" -prototypes "+ os.path.join(path,"taint_propagation/")+filename+".prototypes";
            print cmd;
        p=Popen(cmd, shell=True);
        p.wait()

        ##run the input script
        p=Popen("php "+in_filename+" 'html&tag'"+" >original.out", shell=True);
        p.wait()

        ##run the edited script
        out_filename=out_dir+string_prune(infile,'/')
        p=Popen("php "+out_filename+" 'html&tag'"+" >edited.out", shell=True);
        p.wait()

        ##compare results
        original_file_list = open('original.out', 'r').readlines()
        edited_file_list = open('edited.out', 'r').readlines()
        passed=True
        if (len(original_file_list)==len(edited_file_list)) :
            i=0
            errors=0
            for line_or in  original_file_list :
                line_ed=edited_file_list[i]
                i+=1
                if line_ed!=line_or and ((not "PHP Notice" in line_ed) or (not "PHP Notice" in line_or)) :
                    passed=False
                    if errors < 3 :
                        errors+=1
                        print "ERROR: "+str(errors)
                        print "("+str(i-1)+") Original Line: "+line_or ,
                        print "("+str(i-1)+") Edited   Line: "+line_ed ,
                    else:
                        print "more errors ommited (..........) "
                        break
        else :
            print "ERROR: different #lines in the two files."
            passed=False
        if passed :
            print ">>>TEST PASSED<<<"
        else:
            print ">>>TEST FAILED<<<"
        return passed

def usage():
    print "Please invoke the program correcly."
    print "[-dir directory][-file file][-taints file][-prototypes file]"
    sys.exit(1)

if __name__ == '__main__':
    print "==================================================="
    print "|          PhpAspis test suite                    |"
    print "==================================================="

    if (not len(sys.argv))==3 or (not len(sys.argv))==5 or (not len(sys.argv))==7:
        print len(sys.argv)
        usage()
        exit()
    path=get_param(sys.argv,"dir")
    file=get_param(sys.argv,"file")
    categories=get_param(sys.argv,"categories")
    if path=="" and file=="":
        print "Please provide a -dir with the tests or a -file to test."
        usage()
        exit()
    taints=get_param(sys.argv,"taints")
    prototypes=get_param(sys.argv,"prototypes")
    
    ####let's make PhpAspis
    aspis_home=os.environ.get("ASPIS_HOME")
    p=Popen("make clean", shell=True, cwd=aspis_home)
    p.wait()
    p=Popen("make", shell=True,cwd=aspis_home)
    p.wait()
    print "\nPhpAspis compiled, please ENTER to continue with testing\n(or CTRL-C me if compilation wasn't fine)..."
    xxx=raw_input()

    results=dict()

    ###now let's run the tests
    test_no = 0
    if (file == ""):
        ending='*.inc'
        while ending!="done":
            for infile in glob.glob(os.path.join(path, ending)):
                if infile.find("test") > -1: 
                    print "======================================="
                    print "Test " + str( +  + test_no) + ": " + infile
                    results[string_prune(infile, '/')] = do_test(path, infile, "","", categories)
            if (ending=="*.inc"):
                ending="*.php"
            else:
                ending="done"
        succeed_count = 0
        print "========================="
        for key in results.keys():
            res = results[key]
            if res:
                succeed_count += 1
                continue
                print "|| ",
                print "passed :",
                print key

            else:
                print "|| ",
                print "FAILED :",
                print key
        print "========================="
        print "|| passed: " + str(succeed_count) + "/" + str(len(results.keys()))
        print "|| FAILED: " + str(len(results.keys())-succeed_count) + "/" + str(len(results.keys()))
        print "========================="
    else:
        do_test(path, file, taints, prototypes, categories)
        print "\nORIGINAL FILE's OUTPUT:"
        p=Popen("cat original.out", shell=True)
        p.wait()
        print "\nEDITED FILE's OUTPUT:"
        p=Popen("cat edited.out", shell=True)
        p.wait()
        print("\n")
    p=Popen("rm original.out", shell=True);
    p.wait()
    p=Popen("rm edited.out", shell=True);
    p.wait()

