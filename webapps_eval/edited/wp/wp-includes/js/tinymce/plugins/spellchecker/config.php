<?php require_once('AspisMain.php'); ?><?php
arrayAssign($config[0],deAspis(registerTaint(array('general.engine',false))),addTaint(array('GoogleSpell',false)));
arrayAssign($config[0],deAspis(registerTaint(array('PSpell.mode',false))),addTaint(array(PSPELL_FAST,false)));
arrayAssign($config[0],deAspis(registerTaint(array('PSpell.spelling',false))),addTaint(array("",false)));
arrayAssign($config[0],deAspis(registerTaint(array('PSpell.jargon',false))),addTaint(array("",false)));
arrayAssign($config[0],deAspis(registerTaint(array('PSpell.encoding',false))),addTaint(array("",false)));
arrayAssign($config[0],deAspis(registerTaint(array('PSpellShell.mode',false))),addTaint(array(PSPELL_FAST,false)));
arrayAssign($config[0],deAspis(registerTaint(array('PSpellShell.aspell',false))),addTaint(array('/usr/bin/aspell',false)));
arrayAssign($config[0],deAspis(registerTaint(array('PSpellShell.tmp',false))),addTaint(array('/tmp',false)));
;
?>
<?php 