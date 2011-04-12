<?php require_once('AspisMain.php'); ?><?php
arrayAssign($_GET[0],deAspis(registerTaint(array('inline',false))),addTaint(array('true',false)));
require_once ('admin.php');
require_once ('media-upload.php');
;
