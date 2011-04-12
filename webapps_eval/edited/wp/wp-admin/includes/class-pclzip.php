<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('PCLZIP_READ_BLOCK_SIZE')))))
 {define(('PCLZIP_READ_BLOCK_SIZE'),2048);
}if ( (!(defined(('PCLZIP_SEPARATOR')))))
 {define(('PCLZIP_SEPARATOR'),',');
}if ( (!(defined(('PCLZIP_ERROR_EXTERNAL')))))
 {define(('PCLZIP_ERROR_EXTERNAL'),0);
}if ( (!(defined(('PCLZIP_TEMPORARY_DIR')))))
 {define(('PCLZIP_TEMPORARY_DIR'),'');
}if ( (!(defined(('PCLZIP_TEMPORARY_FILE_RATIO')))))
 {define(('PCLZIP_TEMPORARY_FILE_RATIO'),0.47);
}$g_pclzip_version = array("2.8.2",false);
define(('PCLZIP_ERR_USER_ABORTED'),2);
define(('PCLZIP_ERR_NO_ERROR'),0);
define(('PCLZIP_ERR_WRITE_OPEN_FAIL'),deAspisRC(negate(array(1,false))));
define(('PCLZIP_ERR_READ_OPEN_FAIL'),deAspisRC(negate(array(2,false))));
define(('PCLZIP_ERR_INVALID_PARAMETER'),deAspisRC(negate(array(3,false))));
define(('PCLZIP_ERR_MISSING_FILE'),deAspisRC(negate(array(4,false))));
define(('PCLZIP_ERR_FILENAME_TOO_LONG'),deAspisRC(negate(array(5,false))));
define(('PCLZIP_ERR_INVALID_ZIP'),deAspisRC(negate(array(6,false))));
define(('PCLZIP_ERR_BAD_EXTRACTED_FILE'),deAspisRC(negate(array(7,false))));
define(('PCLZIP_ERR_DIR_CREATE_FAIL'),deAspisRC(negate(array(8,false))));
define(('PCLZIP_ERR_BAD_EXTENSION'),deAspisRC(negate(array(9,false))));
define(('PCLZIP_ERR_BAD_FORMAT'),deAspisRC(negate(array(10,false))));
define(('PCLZIP_ERR_DELETE_FILE_FAIL'),deAspisRC(negate(array(11,false))));
define(('PCLZIP_ERR_RENAME_FILE_FAIL'),deAspisRC(negate(array(12,false))));
define(('PCLZIP_ERR_BAD_CHECKSUM'),deAspisRC(negate(array(13,false))));
define(('PCLZIP_ERR_INVALID_ARCHIVE_ZIP'),deAspisRC(negate(array(14,false))));
define(('PCLZIP_ERR_MISSING_OPTION_VALUE'),deAspisRC(negate(array(15,false))));
define(('PCLZIP_ERR_INVALID_OPTION_VALUE'),deAspisRC(negate(array(16,false))));
define(('PCLZIP_ERR_ALREADY_A_DIRECTORY'),deAspisRC(negate(array(17,false))));
define(('PCLZIP_ERR_UNSUPPORTED_COMPRESSION'),deAspisRC(negate(array(18,false))));
define(('PCLZIP_ERR_UNSUPPORTED_ENCRYPTION'),deAspisRC(negate(array(19,false))));
define(('PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE'),deAspisRC(negate(array(20,false))));
define(('PCLZIP_ERR_DIRECTORY_RESTRICTION'),deAspisRC(negate(array(21,false))));
define(('PCLZIP_OPT_PATH'),77001);
define(('PCLZIP_OPT_ADD_PATH'),77002);
define(('PCLZIP_OPT_REMOVE_PATH'),77003);
define(('PCLZIP_OPT_REMOVE_ALL_PATH'),77004);
define(('PCLZIP_OPT_SET_CHMOD'),77005);
define(('PCLZIP_OPT_EXTRACT_AS_STRING'),77006);
define(('PCLZIP_OPT_NO_COMPRESSION'),77007);
define(('PCLZIP_OPT_BY_NAME'),77008);
define(('PCLZIP_OPT_BY_INDEX'),77009);
define(('PCLZIP_OPT_BY_EREG'),77010);
define(('PCLZIP_OPT_BY_PREG'),77011);
define(('PCLZIP_OPT_COMMENT'),77012);
define(('PCLZIP_OPT_ADD_COMMENT'),77013);
define(('PCLZIP_OPT_PREPEND_COMMENT'),77014);
define(('PCLZIP_OPT_EXTRACT_IN_OUTPUT'),77015);
define(('PCLZIP_OPT_REPLACE_NEWER'),77016);
define(('PCLZIP_OPT_STOP_ON_ERROR'),77017);
define(('PCLZIP_OPT_EXTRACT_DIR_RESTRICTION'),77019);
define(('PCLZIP_OPT_TEMP_FILE_THRESHOLD'),77020);
define(('PCLZIP_OPT_ADD_TEMP_FILE_THRESHOLD'),77020);
define(('PCLZIP_OPT_TEMP_FILE_ON'),77021);
define(('PCLZIP_OPT_ADD_TEMP_FILE_ON'),77021);
define(('PCLZIP_OPT_TEMP_FILE_OFF'),77022);
define(('PCLZIP_OPT_ADD_TEMP_FILE_OFF'),77022);
define(('PCLZIP_ATT_FILE_NAME'),79001);
define(('PCLZIP_ATT_FILE_NEW_SHORT_NAME'),79002);
define(('PCLZIP_ATT_FILE_NEW_FULL_NAME'),79003);
define(('PCLZIP_ATT_FILE_MTIME'),79004);
define(('PCLZIP_ATT_FILE_CONTENT'),79005);
define(('PCLZIP_ATT_FILE_COMMENT'),79006);
define(('PCLZIP_CB_PRE_EXTRACT'),78001);
define(('PCLZIP_CB_POST_EXTRACT'),78002);
define(('PCLZIP_CB_PRE_ADD'),78003);
define(('PCLZIP_CB_POST_ADD'),78004);
class PclZip{var $zipname = array('',false);
var $zip_fd = array(0,false);
var $error_code = array(1,false);
var $error_string = array('',false);
var $magic_quotes_status;
function PclZip ( $p_zipname ) {
{if ( (!(function_exists(('gzopen')))))
 {Aspis_exit(concat2(concat1('Abort ',Aspis_basename(array(__FILE__,false))),' : Missing zlib extensions'));
}$this->zipname = $p_zipname;
$this->zip_fd = array(0,false);
$this->magic_quotes_status = negate(array(1,false));
return ;
} }
function create ( $p_filelist ) {
{$v_result = array(1,false);
$this->privErrorReset();
$v_options = array(array(),false);
arrayAssign($v_options[0],deAspis(registerTaint(array(PCLZIP_OPT_NO_COMPRESSION,false))),addTaint(array(FALSE,false)));
$v_size = attAspis(func_num_args());
if ( ($v_size[0] > (1)))
 {$v_arg_list = array(func_get_args(),false);
Aspis_array_shift($v_arg_list);
postdecr($v_size);
if ( ((is_integer(deAspisRC(attachAspis($v_arg_list,(0))))) && (deAspis(attachAspis($v_arg_list,(0))) > (77000))))
 {$v_result = $this->privParseOptions($v_arg_list,$v_size,$v_options,array(array(PCLZIP_OPT_REMOVE_PATH => array('optional',false,false),PCLZIP_OPT_REMOVE_ALL_PATH => array('optional',false,false),PCLZIP_OPT_ADD_PATH => array('optional',false,false),PCLZIP_CB_PRE_ADD => array('optional',false,false),PCLZIP_CB_POST_ADD => array('optional',false,false),PCLZIP_OPT_NO_COMPRESSION => array('optional',false,false),PCLZIP_OPT_COMMENT => array('optional',false,false),PCLZIP_OPT_TEMP_FILE_THRESHOLD => array('optional',false,false),PCLZIP_OPT_TEMP_FILE_ON => array('optional',false,false),PCLZIP_OPT_TEMP_FILE_OFF => array('optional',false,false)),false));
if ( ($v_result[0] != (1)))
 {return array(0,false);
}}else 
{{arrayAssign($v_options[0],deAspis(registerTaint(array(PCLZIP_OPT_ADD_PATH,false))),addTaint(attachAspis($v_arg_list,(0))));
if ( ($v_size[0] == (2)))
 {arrayAssign($v_options[0],deAspis(registerTaint(array(PCLZIP_OPT_REMOVE_PATH,false))),addTaint(attachAspis($v_arg_list,(1))));
}else 
{if ( ($v_size[0] > (2)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),array("Invalid number / type of arguments",false));
return array(0,false);
}}}}}$this->privOptionDefaultThreshold($v_options);
$v_string_list = array(array(),false);
$v_att_list = array(array(),false);
$v_filedescr_list = array(array(),false);
$p_result_list = array(array(),false);
if ( is_array($p_filelist[0]))
 {if ( (((isset($p_filelist[0][(0)]) && Aspis_isset( $p_filelist [0][(0)]))) && is_array(deAspis(attachAspis($p_filelist,(0))))))
 {$v_att_list = $p_filelist;
}else 
{{$v_string_list = $p_filelist;
}}}else 
{if ( is_string(deAspisRC($p_filelist)))
 {$v_string_list = Aspis_explode(array(PCLZIP_SEPARATOR,false),$p_filelist);
}else 
{{PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),array("Invalid variable type p_filelist",false));
return array(0,false);
}}}if ( ((sizeof(deAspisRC($v_string_list))) != (0)))
 {foreach ( $v_string_list[0] as $v_string  )
{if ( ($v_string[0] != ('')))
 {arrayAssign($v_att_list[0][][0],deAspis(registerTaint(array(PCLZIP_ATT_FILE_NAME,false))),addTaint($v_string));
}else 
{{}}}}$v_supported_attributes = array(array(PCLZIP_ATT_FILE_NAME => array('mandatory',false,false),PCLZIP_ATT_FILE_NEW_SHORT_NAME => array('optional',false,false),PCLZIP_ATT_FILE_NEW_FULL_NAME => array('optional',false,false),PCLZIP_ATT_FILE_MTIME => array('optional',false,false),PCLZIP_ATT_FILE_CONTENT => array('optional',false,false),PCLZIP_ATT_FILE_COMMENT => array('optional',false,false)),false);
foreach ( $v_att_list[0] as $v_entry  )
{$v_result = $this->privFileDescrParseAtt($v_entry,$v_filedescr_list[0][],$v_options,$v_supported_attributes);
if ( ($v_result[0] != (1)))
 {return array(0,false);
}}$v_result = $this->privFileDescrExpand($v_filedescr_list,$v_options);
if ( ($v_result[0] != (1)))
 {return array(0,false);
}$v_result = $this->privCreate($v_filedescr_list,$p_result_list,$v_options);
if ( ($v_result[0] != (1)))
 {return array(0,false);
}return $p_result_list;
} }
function add ( $p_filelist ) {
{$v_result = array(1,false);
$this->privErrorReset();
$v_options = array(array(),false);
arrayAssign($v_options[0],deAspis(registerTaint(array(PCLZIP_OPT_NO_COMPRESSION,false))),addTaint(array(FALSE,false)));
$v_size = attAspis(func_num_args());
if ( ($v_size[0] > (1)))
 {$v_arg_list = array(func_get_args(),false);
Aspis_array_shift($v_arg_list);
postdecr($v_size);
if ( ((is_integer(deAspisRC(attachAspis($v_arg_list,(0))))) && (deAspis(attachAspis($v_arg_list,(0))) > (77000))))
 {$v_result = $this->privParseOptions($v_arg_list,$v_size,$v_options,array(array(PCLZIP_OPT_REMOVE_PATH => array('optional',false,false),PCLZIP_OPT_REMOVE_ALL_PATH => array('optional',false,false),PCLZIP_OPT_ADD_PATH => array('optional',false,false),PCLZIP_CB_PRE_ADD => array('optional',false,false),PCLZIP_CB_POST_ADD => array('optional',false,false),PCLZIP_OPT_NO_COMPRESSION => array('optional',false,false),PCLZIP_OPT_COMMENT => array('optional',false,false),PCLZIP_OPT_ADD_COMMENT => array('optional',false,false),PCLZIP_OPT_PREPEND_COMMENT => array('optional',false,false),PCLZIP_OPT_TEMP_FILE_THRESHOLD => array('optional',false,false),PCLZIP_OPT_TEMP_FILE_ON => array('optional',false,false),PCLZIP_OPT_TEMP_FILE_OFF => array('optional',false,false)),false));
if ( ($v_result[0] != (1)))
 {return array(0,false);
}}else 
{{arrayAssign($v_options[0],deAspis(registerTaint(array(PCLZIP_OPT_ADD_PATH,false))),addTaint($v_add_path = attachAspis($v_arg_list,(0))));
if ( ($v_size[0] == (2)))
 {arrayAssign($v_options[0],deAspis(registerTaint(array(PCLZIP_OPT_REMOVE_PATH,false))),addTaint(attachAspis($v_arg_list,(1))));
}else 
{if ( ($v_size[0] > (2)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),array("Invalid number / type of arguments",false));
return array(0,false);
}}}}}$this->privOptionDefaultThreshold($v_options);
$v_string_list = array(array(),false);
$v_att_list = array(array(),false);
$v_filedescr_list = array(array(),false);
$p_result_list = array(array(),false);
if ( is_array($p_filelist[0]))
 {if ( (((isset($p_filelist[0][(0)]) && Aspis_isset( $p_filelist [0][(0)]))) && is_array(deAspis(attachAspis($p_filelist,(0))))))
 {$v_att_list = $p_filelist;
}else 
{{$v_string_list = $p_filelist;
}}}else 
{if ( is_string(deAspisRC($p_filelist)))
 {$v_string_list = Aspis_explode(array(PCLZIP_SEPARATOR,false),$p_filelist);
}else 
{{PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),concat2(concat1("Invalid variable type '",attAspis(gettype(deAspisRC($p_filelist)))),"' for p_filelist"));
return array(0,false);
}}}if ( ((sizeof(deAspisRC($v_string_list))) != (0)))
 {foreach ( $v_string_list[0] as $v_string  )
{arrayAssign($v_att_list[0][][0],deAspis(registerTaint(array(PCLZIP_ATT_FILE_NAME,false))),addTaint($v_string));
}}$v_supported_attributes = array(array(PCLZIP_ATT_FILE_NAME => array('mandatory',false,false),PCLZIP_ATT_FILE_NEW_SHORT_NAME => array('optional',false,false),PCLZIP_ATT_FILE_NEW_FULL_NAME => array('optional',false,false),PCLZIP_ATT_FILE_MTIME => array('optional',false,false),PCLZIP_ATT_FILE_CONTENT => array('optional',false,false),PCLZIP_ATT_FILE_COMMENT => array('optional',false,false)),false);
foreach ( $v_att_list[0] as $v_entry  )
{$v_result = $this->privFileDescrParseAtt($v_entry,$v_filedescr_list[0][],$v_options,$v_supported_attributes);
if ( ($v_result[0] != (1)))
 {return array(0,false);
}}$v_result = $this->privFileDescrExpand($v_filedescr_list,$v_options);
if ( ($v_result[0] != (1)))
 {return array(0,false);
}$v_result = $this->privAdd($v_filedescr_list,$p_result_list,$v_options);
if ( ($v_result[0] != (1)))
 {return array(0,false);
}return $p_result_list;
} }
function listContent (  ) {
{$v_result = array(1,false);
$this->privErrorReset();
if ( (denot_boolean($this->privCheckFormat())))
 {return (array(0,false));
}$p_list = array(array(),false);
if ( (deAspis(($v_result = $this->privList($p_list))) != (1)))
 {unset($p_list);
return (array(0,false));
}return $p_list;
} }
function extract (  ) {
{$v_result = array(1,false);
$this->privErrorReset();
if ( (denot_boolean($this->privCheckFormat())))
 {return (array(0,false));
}$v_options = array(array(),false);
$v_path = array('',false);
$v_remove_path = array("",false);
$v_remove_all_path = array(false,false);
$v_size = attAspis(func_num_args());
arrayAssign($v_options[0],deAspis(registerTaint(array(PCLZIP_OPT_EXTRACT_AS_STRING,false))),addTaint(array(FALSE,false)));
if ( ($v_size[0] > (0)))
 {$v_arg_list = array(func_get_args(),false);
if ( ((is_integer(deAspisRC(attachAspis($v_arg_list,(0))))) && (deAspis(attachAspis($v_arg_list,(0))) > (77000))))
 {$v_result = $this->privParseOptions($v_arg_list,$v_size,$v_options,array(array(PCLZIP_OPT_PATH => array('optional',false,false),PCLZIP_OPT_REMOVE_PATH => array('optional',false,false),PCLZIP_OPT_REMOVE_ALL_PATH => array('optional',false,false),PCLZIP_OPT_ADD_PATH => array('optional',false,false),PCLZIP_CB_PRE_EXTRACT => array('optional',false,false),PCLZIP_CB_POST_EXTRACT => array('optional',false,false),PCLZIP_OPT_SET_CHMOD => array('optional',false,false),PCLZIP_OPT_BY_NAME => array('optional',false,false),PCLZIP_OPT_BY_EREG => array('optional',false,false),PCLZIP_OPT_BY_PREG => array('optional',false,false),PCLZIP_OPT_BY_INDEX => array('optional',false,false),PCLZIP_OPT_EXTRACT_AS_STRING => array('optional',false,false),PCLZIP_OPT_EXTRACT_IN_OUTPUT => array('optional',false,false),PCLZIP_OPT_REPLACE_NEWER => array('optional',false,false),PCLZIP_OPT_STOP_ON_ERROR => array('optional',false,false),PCLZIP_OPT_EXTRACT_DIR_RESTRICTION => array('optional',false,false),PCLZIP_OPT_TEMP_FILE_THRESHOLD => array('optional',false,false),PCLZIP_OPT_TEMP_FILE_ON => array('optional',false,false),PCLZIP_OPT_TEMP_FILE_OFF => array('optional',false,false)),false));
if ( ($v_result[0] != (1)))
 {return array(0,false);
}if ( ((isset($v_options[0][PCLZIP_OPT_PATH]) && Aspis_isset( $v_options [0][PCLZIP_OPT_PATH]))))
 {$v_path = attachAspis($v_options,PCLZIP_OPT_PATH);
}if ( ((isset($v_options[0][PCLZIP_OPT_REMOVE_PATH]) && Aspis_isset( $v_options [0][PCLZIP_OPT_REMOVE_PATH]))))
 {$v_remove_path = attachAspis($v_options,PCLZIP_OPT_REMOVE_PATH);
}if ( ((isset($v_options[0][PCLZIP_OPT_REMOVE_ALL_PATH]) && Aspis_isset( $v_options [0][PCLZIP_OPT_REMOVE_ALL_PATH]))))
 {$v_remove_all_path = attachAspis($v_options,PCLZIP_OPT_REMOVE_ALL_PATH);
}if ( ((isset($v_options[0][PCLZIP_OPT_ADD_PATH]) && Aspis_isset( $v_options [0][PCLZIP_OPT_ADD_PATH]))))
 {if ( ((strlen($v_path[0]) > (0)) && (deAspis(Aspis_substr($v_path,negate(array(1,false)))) != ('/'))))
 {$v_path = concat2($v_path,'/');
}$v_path = concat($v_path,attachAspis($v_options,PCLZIP_OPT_ADD_PATH));
}}else 
{{$v_path = attachAspis($v_arg_list,(0));
if ( ($v_size[0] == (2)))
 {$v_remove_path = attachAspis($v_arg_list,(1));
}else 
{if ( ($v_size[0] > (2)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),array("Invalid number / type of arguments",false));
return array(0,false);
}}}}}$this->privOptionDefaultThreshold($v_options);
$p_list = array(array(),false);
$v_result = $this->privExtractByRule($p_list,$v_path,$v_remove_path,$v_remove_all_path,$v_options);
if ( ($v_result[0] < (1)))
 {unset($p_list);
return (array(0,false));
}return $p_list;
} }
function extractByIndex ( $p_index ) {
{$v_result = array(1,false);
$this->privErrorReset();
if ( (denot_boolean($this->privCheckFormat())))
 {return (array(0,false));
}$v_options = array(array(),false);
$v_path = array('',false);
$v_remove_path = array("",false);
$v_remove_all_path = array(false,false);
$v_size = attAspis(func_num_args());
arrayAssign($v_options[0],deAspis(registerTaint(array(PCLZIP_OPT_EXTRACT_AS_STRING,false))),addTaint(array(FALSE,false)));
if ( ($v_size[0] > (1)))
 {$v_arg_list = array(func_get_args(),false);
Aspis_array_shift($v_arg_list);
postdecr($v_size);
if ( ((is_integer(deAspisRC(attachAspis($v_arg_list,(0))))) && (deAspis(attachAspis($v_arg_list,(0))) > (77000))))
 {$v_result = $this->privParseOptions($v_arg_list,$v_size,$v_options,array(array(PCLZIP_OPT_PATH => array('optional',false,false),PCLZIP_OPT_REMOVE_PATH => array('optional',false,false),PCLZIP_OPT_REMOVE_ALL_PATH => array('optional',false,false),PCLZIP_OPT_EXTRACT_AS_STRING => array('optional',false,false),PCLZIP_OPT_ADD_PATH => array('optional',false,false),PCLZIP_CB_PRE_EXTRACT => array('optional',false,false),PCLZIP_CB_POST_EXTRACT => array('optional',false,false),PCLZIP_OPT_SET_CHMOD => array('optional',false,false),PCLZIP_OPT_REPLACE_NEWER => array('optional',false,false),PCLZIP_OPT_STOP_ON_ERROR => array('optional',false,false),PCLZIP_OPT_EXTRACT_DIR_RESTRICTION => array('optional',false,false),PCLZIP_OPT_TEMP_FILE_THRESHOLD => array('optional',false,false),PCLZIP_OPT_TEMP_FILE_ON => array('optional',false,false),PCLZIP_OPT_TEMP_FILE_OFF => array('optional',false,false)),false));
if ( ($v_result[0] != (1)))
 {return array(0,false);
}if ( ((isset($v_options[0][PCLZIP_OPT_PATH]) && Aspis_isset( $v_options [0][PCLZIP_OPT_PATH]))))
 {$v_path = attachAspis($v_options,PCLZIP_OPT_PATH);
}if ( ((isset($v_options[0][PCLZIP_OPT_REMOVE_PATH]) && Aspis_isset( $v_options [0][PCLZIP_OPT_REMOVE_PATH]))))
 {$v_remove_path = attachAspis($v_options,PCLZIP_OPT_REMOVE_PATH);
}if ( ((isset($v_options[0][PCLZIP_OPT_REMOVE_ALL_PATH]) && Aspis_isset( $v_options [0][PCLZIP_OPT_REMOVE_ALL_PATH]))))
 {$v_remove_all_path = attachAspis($v_options,PCLZIP_OPT_REMOVE_ALL_PATH);
}if ( ((isset($v_options[0][PCLZIP_OPT_ADD_PATH]) && Aspis_isset( $v_options [0][PCLZIP_OPT_ADD_PATH]))))
 {if ( ((strlen($v_path[0]) > (0)) && (deAspis(Aspis_substr($v_path,negate(array(1,false)))) != ('/'))))
 {$v_path = concat2($v_path,'/');
}$v_path = concat($v_path,attachAspis($v_options,PCLZIP_OPT_ADD_PATH));
}if ( (!((isset($v_options[0][PCLZIP_OPT_EXTRACT_AS_STRING]) && Aspis_isset( $v_options [0][PCLZIP_OPT_EXTRACT_AS_STRING])))))
 {arrayAssign($v_options[0],deAspis(registerTaint(array(PCLZIP_OPT_EXTRACT_AS_STRING,false))),addTaint(array(FALSE,false)));
}else 
{{}}}else 
{{$v_path = attachAspis($v_arg_list,(0));
if ( ($v_size[0] == (2)))
 {$v_remove_path = attachAspis($v_arg_list,(1));
}else 
{if ( ($v_size[0] > (2)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),array("Invalid number / type of arguments",false));
return array(0,false);
}}}}}$v_arg_trick = array(array(array(PCLZIP_OPT_BY_INDEX,false),$p_index),false);
$v_options_trick = array(array(),false);
$v_result = $this->privParseOptions($v_arg_trick,array(sizeof(deAspisRC($v_arg_trick)),false),$v_options_trick,array(array(PCLZIP_OPT_BY_INDEX => array('optional',false,false)),false));
if ( ($v_result[0] != (1)))
 {return array(0,false);
}arrayAssign($v_options[0],deAspis(registerTaint(array(PCLZIP_OPT_BY_INDEX,false))),addTaint(attachAspis($v_options_trick,PCLZIP_OPT_BY_INDEX)));
$this->privOptionDefaultThreshold($v_options);
if ( (deAspis(($v_result = $this->privExtractByRule($p_list,$v_path,$v_remove_path,$v_remove_all_path,$v_options))) < (1)))
 {return (array(0,false));
}return $p_list;
} }
function delete (  ) {
{$v_result = array(1,false);
$this->privErrorReset();
if ( (denot_boolean($this->privCheckFormat())))
 {return (array(0,false));
}$v_options = array(array(),false);
$v_size = attAspis(func_num_args());
if ( ($v_size[0] > (0)))
 {$v_arg_list = array(func_get_args(),false);
$v_result = $this->privParseOptions($v_arg_list,$v_size,$v_options,array(array(PCLZIP_OPT_BY_NAME => array('optional',false,false),PCLZIP_OPT_BY_EREG => array('optional',false,false),PCLZIP_OPT_BY_PREG => array('optional',false,false),PCLZIP_OPT_BY_INDEX => array('optional',false,false)),false));
if ( ($v_result[0] != (1)))
 {return array(0,false);
}}$this->privDisableMagicQuotes();
$v_list = array(array(),false);
if ( (deAspis(($v_result = $this->privDeleteByRule($v_list,$v_options))) != (1)))
 {$this->privSwapBackMagicQuotes();
unset($v_list);
return (array(0,false));
}$this->privSwapBackMagicQuotes();
return $v_list;
} }
function deleteByIndex ( $p_index ) {
{$p_list = $this->delete(array(PCLZIP_OPT_BY_INDEX,false),$p_index);
return $p_list;
} }
function properties (  ) {
{$this->privErrorReset();
$this->privDisableMagicQuotes();
if ( (denot_boolean($this->privCheckFormat())))
 {$this->privSwapBackMagicQuotes();
return (array(0,false));
}$v_prop = array(array(),false);
arrayAssign($v_prop[0],deAspis(registerTaint(array('comment',false))),addTaint(array('',false)));
arrayAssign($v_prop[0],deAspis(registerTaint(array('nb',false))),addTaint(array(0,false)));
arrayAssign($v_prop[0],deAspis(registerTaint(array('status',false))),addTaint(array('not_exist',false)));
if ( deAspis(@attAspis(is_file($this->zipname[0]))))
 {if ( (deAspis(($this->zip_fd = @attAspis(fopen($this->zipname[0],('rb'))))) == (0)))
 {$this->privSwapBackMagicQuotes();
PclZip::privErrorLog(array(PCLZIP_ERR_READ_OPEN_FAIL,false),concat2(concat1('Unable to open archive \'',$this->zipname),'\' in binary read mode'));
return array(0,false);
}$v_central_dir = array(array(),false);
if ( (deAspis(($v_result = $this->privReadEndCentralDir($v_central_dir))) != (1)))
 {$this->privSwapBackMagicQuotes();
return array(0,false);
}$this->privCloseFd();
arrayAssign($v_prop[0],deAspis(registerTaint(array('comment',false))),addTaint($v_central_dir[0]['comment']));
arrayAssign($v_prop[0],deAspis(registerTaint(array('nb',false))),addTaint($v_central_dir[0]['entries']));
arrayAssign($v_prop[0],deAspis(registerTaint(array('status',false))),addTaint(array('ok',false)));
}$this->privSwapBackMagicQuotes();
return $v_prop;
} }
function duplicate ( $p_archive ) {
{$v_result = array(1,false);
$this->privErrorReset();
if ( (is_object($p_archive[0]) && (get_class(deAspisRC($p_archive)) == ('pclzip'))))
 {$v_result = $this->privDuplicate($p_archive[0]->zipname);
}else 
{if ( is_string(deAspisRC($p_archive)))
 {if ( (!(is_file($p_archive[0]))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_MISSING_FILE,false),concat2(concat1("No file with filename '",$p_archive),"'"));
$v_result = array(PCLZIP_ERR_MISSING_FILE,false);
}else 
{{$v_result = $this->privDuplicate($p_archive);
}}}else 
{{PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),array("Invalid variable type p_archive_to_add",false));
$v_result = array(PCLZIP_ERR_INVALID_PARAMETER,false);
}}}return $v_result;
} }
function merge ( $p_archive_to_add ) {
{$v_result = array(1,false);
$this->privErrorReset();
if ( (denot_boolean($this->privCheckFormat())))
 {return (array(0,false));
}if ( (is_object($p_archive_to_add[0]) && (get_class(deAspisRC($p_archive_to_add)) == ('pclzip'))))
 {$v_result = $this->privMerge($p_archive_to_add);
}else 
{if ( is_string(deAspisRC($p_archive_to_add)))
 {$v_object_archive = array(new PclZip($p_archive_to_add),false);
$v_result = $this->privMerge($v_object_archive);
}else 
{{PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),array("Invalid variable type p_archive_to_add",false));
$v_result = array(PCLZIP_ERR_INVALID_PARAMETER,false);
}}}return $v_result;
} }
function errorCode (  ) {
{if ( (PCLZIP_ERROR_EXTERNAL == (1)))
 {return (PclErrorCode());
}else 
{{return ($this->error_code);
}}} }
function errorName ( $p_with_code = array(false,false) ) {
{$v_name = array(array(PCLZIP_ERR_NO_ERROR => array('PCLZIP_ERR_NO_ERROR',false,false),PCLZIP_ERR_WRITE_OPEN_FAIL => array('PCLZIP_ERR_WRITE_OPEN_FAIL',false,false),PCLZIP_ERR_READ_OPEN_FAIL => array('PCLZIP_ERR_READ_OPEN_FAIL',false,false),PCLZIP_ERR_INVALID_PARAMETER => array('PCLZIP_ERR_INVALID_PARAMETER',false,false),PCLZIP_ERR_MISSING_FILE => array('PCLZIP_ERR_MISSING_FILE',false,false),PCLZIP_ERR_FILENAME_TOO_LONG => array('PCLZIP_ERR_FILENAME_TOO_LONG',false,false),PCLZIP_ERR_INVALID_ZIP => array('PCLZIP_ERR_INVALID_ZIP',false,false),PCLZIP_ERR_BAD_EXTRACTED_FILE => array('PCLZIP_ERR_BAD_EXTRACTED_FILE',false,false),PCLZIP_ERR_DIR_CREATE_FAIL => array('PCLZIP_ERR_DIR_CREATE_FAIL',false,false),PCLZIP_ERR_BAD_EXTENSION => array('PCLZIP_ERR_BAD_EXTENSION',false,false),PCLZIP_ERR_BAD_FORMAT => array('PCLZIP_ERR_BAD_FORMAT',false,false),PCLZIP_ERR_DELETE_FILE_FAIL => array('PCLZIP_ERR_DELETE_FILE_FAIL',false,false),PCLZIP_ERR_RENAME_FILE_FAIL => array('PCLZIP_ERR_RENAME_FILE_FAIL',false,false),PCLZIP_ERR_BAD_CHECKSUM => array('PCLZIP_ERR_BAD_CHECKSUM',false,false),PCLZIP_ERR_INVALID_ARCHIVE_ZIP => array('PCLZIP_ERR_INVALID_ARCHIVE_ZIP',false,false),PCLZIP_ERR_MISSING_OPTION_VALUE => array('PCLZIP_ERR_MISSING_OPTION_VALUE',false,false),PCLZIP_ERR_INVALID_OPTION_VALUE => array('PCLZIP_ERR_INVALID_OPTION_VALUE',false,false),PCLZIP_ERR_UNSUPPORTED_COMPRESSION => array('PCLZIP_ERR_UNSUPPORTED_COMPRESSION',false,false),PCLZIP_ERR_UNSUPPORTED_ENCRYPTION => array('PCLZIP_ERR_UNSUPPORTED_ENCRYPTION',false,false),PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE => array('PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE',false,false),PCLZIP_ERR_DIRECTORY_RESTRICTION => array('PCLZIP_ERR_DIRECTORY_RESTRICTION',false,false)),false);
if ( ((isset($v_name[0][$this->error_code[0]]) && Aspis_isset( $v_name [0][$this ->error_code [0]]))))
 {$v_value = attachAspis($v_name,$this->error_code[0]);
}else 
{{$v_value = array('NoName',false);
}}if ( $p_with_code[0])
 {return (concat2(concat(concat2($v_value,' ('),$this->error_code),')'));
}else 
{{return ($v_value);
}}} }
function errorInfo ( $p_full = array(false,false) ) {
{if ( (PCLZIP_ERROR_EXTERNAL == (1)))
 {return (PclErrorString());
}else 
{{if ( $p_full[0])
 {return (concat(concat2($this->errorName(array(true,false))," : "),$this->error_string));
}else 
{{return (concat2(concat(concat2($this->error_string," [code "),$this->error_code),"]"));
}}}}} }
function privCheckFormat ( $p_level = array(0,false) ) {
{$v_result = array(true,false);
clearstatcache();
$this->privErrorReset();
if ( (!(is_file($this->zipname[0]))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_MISSING_FILE,false),concat2(concat1("Missing archive file '",$this->zipname),"'"));
return (array(false,false));
}if ( (!(is_readable($this->zipname[0]))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_READ_OPEN_FAIL,false),concat2(concat1("Unable to read archive '",$this->zipname),"'"));
return (array(false,false));
}return $v_result;
} }
function privParseOptions ( &$p_options_list,$p_size,&$v_result_list,$v_requested_options = array(false,false) ) {
{$v_result = array(1,false);
$i = array(0,false);
while ( ($i[0] < $p_size[0]) )
{if ( (!((isset($v_requested_options[0][deAspis(attachAspis($p_options_list,$i[0]))]) && Aspis_isset( $v_requested_options [0][deAspis(attachAspis( $p_options_list ,$i[0]))])))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),concat2(concat1("Invalid optional parameter '",attachAspis($p_options_list,$i[0])),"' for this method"));
return PclZip::errorCode();
}switch ( deAspis(attachAspis($p_options_list,$i[0])) ) {
case PCLZIP_OPT_PATH:case PCLZIP_OPT_REMOVE_PATH:case PCLZIP_OPT_ADD_PATH:if ( (($i[0] + (1)) >= $p_size[0]))
 {PclZip::privErrorLog(array(PCLZIP_ERR_MISSING_OPTION_VALUE,false),concat2(concat1("Missing parameter value for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}arrayAssign($v_result_list[0],deAspis(registerTaint(attachAspis($p_options_list,$i[0]))),addTaint(PclZipUtilTranslateWinPath(attachAspis($p_options_list,($i[0] + (1))),array(FALSE,false))));
postincr($i);
break ;
case PCLZIP_OPT_TEMP_FILE_THRESHOLD:if ( (($i[0] + (1)) >= $p_size[0]))
 {PclZip::privErrorLog(array(PCLZIP_ERR_MISSING_OPTION_VALUE,false),concat2(concat1("Missing parameter value for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}if ( ((isset($v_result_list[0][PCLZIP_OPT_TEMP_FILE_OFF]) && Aspis_isset( $v_result_list [0][PCLZIP_OPT_TEMP_FILE_OFF]))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),concat2(concat1("Option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"' can not be used with option 'PCLZIP_OPT_TEMP_FILE_OFF'"));
return PclZip::errorCode();
}$v_value = attachAspis($p_options_list,($i[0] + (1)));
if ( ((!(is_integer(deAspisRC($v_value)))) || ($v_value[0] < (0))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_OPTION_VALUE,false),concat2(concat1("Integer expected for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}arrayAssign($v_result_list[0],deAspis(registerTaint(attachAspis($p_options_list,$i[0]))),addTaint(array($v_value[0] * (1048576),false)));
postincr($i);
break ;
case PCLZIP_OPT_TEMP_FILE_ON:if ( ((isset($v_result_list[0][PCLZIP_OPT_TEMP_FILE_OFF]) && Aspis_isset( $v_result_list [0][PCLZIP_OPT_TEMP_FILE_OFF]))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),concat2(concat1("Option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"' can not be used with option 'PCLZIP_OPT_TEMP_FILE_OFF'"));
return PclZip::errorCode();
}arrayAssign($v_result_list[0],deAspis(registerTaint(attachAspis($p_options_list,$i[0]))),addTaint(array(true,false)));
break ;
case PCLZIP_OPT_TEMP_FILE_OFF:if ( ((isset($v_result_list[0][PCLZIP_OPT_TEMP_FILE_ON]) && Aspis_isset( $v_result_list [0][PCLZIP_OPT_TEMP_FILE_ON]))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),concat2(concat1("Option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"' can not be used with option 'PCLZIP_OPT_TEMP_FILE_ON'"));
return PclZip::errorCode();
}if ( ((isset($v_result_list[0][PCLZIP_OPT_TEMP_FILE_THRESHOLD]) && Aspis_isset( $v_result_list [0][PCLZIP_OPT_TEMP_FILE_THRESHOLD]))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),concat2(concat1("Option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"' can not be used with option 'PCLZIP_OPT_TEMP_FILE_THRESHOLD'"));
return PclZip::errorCode();
}arrayAssign($v_result_list[0],deAspis(registerTaint(attachAspis($p_options_list,$i[0]))),addTaint(array(true,false)));
break ;
case PCLZIP_OPT_EXTRACT_DIR_RESTRICTION:if ( (($i[0] + (1)) >= $p_size[0]))
 {PclZip::privErrorLog(array(PCLZIP_ERR_MISSING_OPTION_VALUE,false),concat2(concat1("Missing parameter value for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}if ( (is_string(deAspisRC(attachAspis($p_options_list,($i[0] + (1))))) && (deAspis(attachAspis($p_options_list,($i[0] + (1)))) != (''))))
 {arrayAssign($v_result_list[0],deAspis(registerTaint(attachAspis($p_options_list,$i[0]))),addTaint(PclZipUtilTranslateWinPath(attachAspis($p_options_list,($i[0] + (1))),array(FALSE,false))));
postincr($i);
}else 
{{}}break ;
case PCLZIP_OPT_BY_NAME:if ( (($i[0] + (1)) >= $p_size[0]))
 {PclZip::privErrorLog(array(PCLZIP_ERR_MISSING_OPTION_VALUE,false),concat2(concat1("Missing parameter value for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}if ( is_string(deAspisRC(attachAspis($p_options_list,($i[0] + (1))))))
 {arrayAssign($v_result_list[0][deAspis(attachAspis($p_options_list,$i[0]))][0],deAspis(registerTaint(array(0,false))),addTaint(attachAspis($p_options_list,($i[0] + (1)))));
}else 
{if ( is_array(deAspis(attachAspis($p_options_list,($i[0] + (1))))))
 {arrayAssign($v_result_list[0],deAspis(registerTaint(attachAspis($p_options_list,$i[0]))),addTaint(attachAspis($p_options_list,($i[0] + (1)))));
}else 
{{PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_OPTION_VALUE,false),concat2(concat1("Wrong parameter value for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}}}postincr($i);
break ;
case PCLZIP_OPT_BY_EREG:arrayAssign($p_options_list[0],deAspis(registerTaint($i)),addTaint(array(PCLZIP_OPT_BY_PREG,false)));
case PCLZIP_OPT_BY_PREG:if ( (($i[0] + (1)) >= $p_size[0]))
 {PclZip::privErrorLog(array(PCLZIP_ERR_MISSING_OPTION_VALUE,false),concat2(concat1("Missing parameter value for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}if ( is_string(deAspisRC(attachAspis($p_options_list,($i[0] + (1))))))
 {arrayAssign($v_result_list[0],deAspis(registerTaint(attachAspis($p_options_list,$i[0]))),addTaint(attachAspis($p_options_list,($i[0] + (1)))));
}else 
{{PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_OPTION_VALUE,false),concat2(concat1("Wrong parameter value for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}}postincr($i);
break ;
case PCLZIP_OPT_COMMENT:case PCLZIP_OPT_ADD_COMMENT:case PCLZIP_OPT_PREPEND_COMMENT:if ( (($i[0] + (1)) >= $p_size[0]))
 {PclZip::privErrorLog(array(PCLZIP_ERR_MISSING_OPTION_VALUE,false),concat2(concat1("Missing parameter value for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}if ( is_string(deAspisRC(attachAspis($p_options_list,($i[0] + (1))))))
 {arrayAssign($v_result_list[0],deAspis(registerTaint(attachAspis($p_options_list,$i[0]))),addTaint(attachAspis($p_options_list,($i[0] + (1)))));
}else 
{{PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_OPTION_VALUE,false),concat2(concat1("Wrong parameter value for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}}postincr($i);
break ;
case PCLZIP_OPT_BY_INDEX:if ( (($i[0] + (1)) >= $p_size[0]))
 {PclZip::privErrorLog(array(PCLZIP_ERR_MISSING_OPTION_VALUE,false),concat2(concat1("Missing parameter value for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}$v_work_list = array(array(),false);
if ( is_string(deAspisRC(attachAspis($p_options_list,($i[0] + (1))))))
 {arrayAssign($p_options_list[0],deAspis(registerTaint(array($i[0] + (1),false))),addTaint(Aspis_strtr(attachAspis($p_options_list,($i[0] + (1))),array(' ',false),array('',false))));
$v_work_list = Aspis_explode(array(",",false),attachAspis($p_options_list,($i[0] + (1))));
}else 
{if ( (is_integer(deAspisRC(attachAspis($p_options_list,($i[0] + (1)))))))
 {arrayAssign($v_work_list[0],deAspis(registerTaint(array(0,false))),addTaint(concat(concat2(attachAspis($p_options_list,($i[0] + (1))),'-'),attachAspis($p_options_list,($i[0] + (1))))));
}else 
{if ( is_array(deAspis(attachAspis($p_options_list,($i[0] + (1))))))
 {$v_work_list = attachAspis($p_options_list,($i[0] + (1)));
}else 
{{PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_OPTION_VALUE,false),concat2(concat1("Value must be integer, string or array for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}}}}$v_sort_flag = array(false,false);
$v_sort_value = array(0,false);
for ( $j = array(0,false) ; ($j[0] < (sizeof(deAspisRC($v_work_list)))) ; postincr($j) )
{$v_item_list = Aspis_explode(array("-",false),attachAspis($v_work_list,$j[0]));
$v_size_item_list = array(sizeof(deAspisRC($v_item_list)),false);
if ( ($v_size_item_list[0] == (1)))
 {arrayAssign($v_result_list[0][deAspis(attachAspis($p_options_list,$i[0]))][0][$j[0]][0],deAspis(registerTaint(array('start',false))),addTaint(attachAspis($v_item_list,(0))));
arrayAssign($v_result_list[0][deAspis(attachAspis($p_options_list,$i[0]))][0][$j[0]][0],deAspis(registerTaint(array('end',false))),addTaint(attachAspis($v_item_list,(0))));
}elseif ( ($v_size_item_list[0] == (2)))
 {arrayAssign($v_result_list[0][deAspis(attachAspis($p_options_list,$i[0]))][0][$j[0]][0],deAspis(registerTaint(array('start',false))),addTaint(attachAspis($v_item_list,(0))));
arrayAssign($v_result_list[0][deAspis(attachAspis($p_options_list,$i[0]))][0][$j[0]][0],deAspis(registerTaint(array('end',false))),addTaint(attachAspis($v_item_list,(1))));
}else 
{{PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_OPTION_VALUE,false),concat2(concat1("Too many values in index range for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}}if ( (deAspis($v_result_list[0][deAspis(attachAspis($p_options_list,$i[0]))][0][$j[0]][0]['start']) < $v_sort_value[0]))
 {$v_sort_flag = array(true,false);
PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_OPTION_VALUE,false),concat2(concat1("Invalid order of index range for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}$v_sort_value = $v_result_list[0][deAspis(attachAspis($p_options_list,$i[0]))][0][$j[0]][0]['start'];
}if ( $v_sort_flag[0])
 {}postincr($i);
break ;
case PCLZIP_OPT_REMOVE_ALL_PATH:case PCLZIP_OPT_EXTRACT_AS_STRING:case PCLZIP_OPT_NO_COMPRESSION:case PCLZIP_OPT_EXTRACT_IN_OUTPUT:case PCLZIP_OPT_REPLACE_NEWER:case PCLZIP_OPT_STOP_ON_ERROR:arrayAssign($v_result_list[0],deAspis(registerTaint(attachAspis($p_options_list,$i[0]))),addTaint(array(true,false)));
break ;
case PCLZIP_OPT_SET_CHMOD:if ( (($i[0] + (1)) >= $p_size[0]))
 {PclZip::privErrorLog(array(PCLZIP_ERR_MISSING_OPTION_VALUE,false),concat2(concat1("Missing parameter value for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}arrayAssign($v_result_list[0],deAspis(registerTaint(attachAspis($p_options_list,$i[0]))),addTaint(attachAspis($p_options_list,($i[0] + (1)))));
postincr($i);
break ;
case PCLZIP_CB_PRE_EXTRACT:case PCLZIP_CB_POST_EXTRACT:case PCLZIP_CB_PRE_ADD:case PCLZIP_CB_POST_ADD:if ( (($i[0] + (1)) >= $p_size[0]))
 {PclZip::privErrorLog(array(PCLZIP_ERR_MISSING_OPTION_VALUE,false),concat2(concat1("Missing parameter value for option '",PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}$v_function_name = attachAspis($p_options_list,($i[0] + (1)));
if ( (!(function_exists($v_function_name[0]))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_OPTION_VALUE,false),concat2(concat(concat2(concat1("Function '",$v_function_name),"()' is not an existing function for option '"),PclZipUtilOptionText(attachAspis($p_options_list,$i[0]))),"'"));
return PclZip::errorCode();
}arrayAssign($v_result_list[0],deAspis(registerTaint(attachAspis($p_options_list,$i[0]))),addTaint($v_function_name));
postincr($i);
break ;
default :PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),concat2(concat1("Unknown parameter '",attachAspis($p_options_list,$i[0])),"'"));
return PclZip::errorCode();
 }
postincr($i);
}if ( ($v_requested_options[0] !== false))
 {for ( $key = Aspis_reset($v_requested_options) ; deAspis($key = Aspis_key($v_requested_options)) ; $key = Aspis_next($v_requested_options) )
{if ( (deAspis(attachAspis($v_requested_options,$key[0])) == ('mandatory')))
 {if ( (!((isset($v_result_list[0][$key[0]]) && Aspis_isset( $v_result_list [0][$key[0]])))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),concat2(concat(concat2(concat1("Missing mandatory parameter ",PclZipUtilOptionText($key)),"("),$key),")"));
return PclZip::errorCode();
}}}}if ( (!((isset($v_result_list[0][PCLZIP_OPT_TEMP_FILE_THRESHOLD]) && Aspis_isset( $v_result_list [0][PCLZIP_OPT_TEMP_FILE_THRESHOLD])))))
 {}return $v_result;
} }
function privOptionDefaultThreshold ( &$p_options ) {
{$v_result = array(1,false);
if ( (((isset($p_options[0][PCLZIP_OPT_TEMP_FILE_THRESHOLD]) && Aspis_isset( $p_options [0][PCLZIP_OPT_TEMP_FILE_THRESHOLD]))) || ((isset($p_options[0][PCLZIP_OPT_TEMP_FILE_OFF]) && Aspis_isset( $p_options [0][PCLZIP_OPT_TEMP_FILE_OFF])))))
 {return $v_result;
}$v_memory_limit = array(ini_get('memory_limit'),false);
$v_memory_limit = Aspis_trim($v_memory_limit);
$last = Aspis_strtolower(Aspis_substr($v_memory_limit,negate(array(1,false))));
if ( ($last[0] == ('g')))
 $v_memory_limit = array($v_memory_limit[0] * (1073741824),false);
if ( ($last[0] == ('m')))
 $v_memory_limit = array($v_memory_limit[0] * (1048576),false);
if ( ($last[0] == ('k')))
 $v_memory_limit = array($v_memory_limit[0] * (1024),false);
arrayAssign($p_options[0],deAspis(registerTaint(array(PCLZIP_OPT_TEMP_FILE_THRESHOLD,false))),addTaint(attAspis(floor(($v_memory_limit[0] * PCLZIP_TEMPORARY_FILE_RATIO)))));
if ( (deAspis(attachAspis($p_options,PCLZIP_OPT_TEMP_FILE_THRESHOLD)) < (1048576)))
 {unset($p_options[0][PCLZIP_OPT_TEMP_FILE_THRESHOLD]);
}return $v_result;
} }
function privFileDescrParseAtt ( &$p_file_list,&$p_filedescr,$v_options,$v_requested_options = array(false,false) ) {
{$v_result = array(1,false);
foreach ( $p_file_list[0] as $v_key =>$v_value )
{restoreTaint($v_key,$v_value);
{if ( (!((isset($v_requested_options[0][$v_key[0]]) && Aspis_isset( $v_requested_options [0][$v_key[0]])))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),concat2(concat1("Invalid file attribute '",$v_key),"' for this file"));
return PclZip::errorCode();
}switch ( $v_key[0] ) {
case PCLZIP_ATT_FILE_NAME:if ( (!(is_string(deAspisRC($v_value)))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE,false),concat2(concat(concat2(concat1("Invalid type ",attAspis(gettype(deAspisRC($v_value)))),". String expected for attribute '"),PclZipUtilOptionText($v_key)),"'"));
return PclZip::errorCode();
}arrayAssign($p_filedescr[0],deAspis(registerTaint(array('filename',false))),addTaint(PclZipUtilPathReduction($v_value)));
if ( (deAspis($p_filedescr[0]['filename']) == ('')))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE,false),concat2(concat1("Invalid empty filename for attribute '",PclZipUtilOptionText($v_key)),"'"));
return PclZip::errorCode();
}break ;
case PCLZIP_ATT_FILE_NEW_SHORT_NAME:if ( (!(is_string(deAspisRC($v_value)))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE,false),concat2(concat(concat2(concat1("Invalid type ",attAspis(gettype(deAspisRC($v_value)))),". String expected for attribute '"),PclZipUtilOptionText($v_key)),"'"));
return PclZip::errorCode();
}arrayAssign($p_filedescr[0],deAspis(registerTaint(array('new_short_name',false))),addTaint(PclZipUtilPathReduction($v_value)));
if ( (deAspis($p_filedescr[0]['new_short_name']) == ('')))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE,false),concat2(concat1("Invalid empty short filename for attribute '",PclZipUtilOptionText($v_key)),"'"));
return PclZip::errorCode();
}break ;
case PCLZIP_ATT_FILE_NEW_FULL_NAME:if ( (!(is_string(deAspisRC($v_value)))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE,false),concat2(concat(concat2(concat1("Invalid type ",attAspis(gettype(deAspisRC($v_value)))),". String expected for attribute '"),PclZipUtilOptionText($v_key)),"'"));
return PclZip::errorCode();
}arrayAssign($p_filedescr[0],deAspis(registerTaint(array('new_full_name',false))),addTaint(PclZipUtilPathReduction($v_value)));
if ( (deAspis($p_filedescr[0]['new_full_name']) == ('')))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE,false),concat2(concat1("Invalid empty full filename for attribute '",PclZipUtilOptionText($v_key)),"'"));
return PclZip::errorCode();
}break ;
case PCLZIP_ATT_FILE_COMMENT:if ( (!(is_string(deAspisRC($v_value)))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE,false),concat2(concat(concat2(concat1("Invalid type ",attAspis(gettype(deAspisRC($v_value)))),". String expected for attribute '"),PclZipUtilOptionText($v_key)),"'"));
return PclZip::errorCode();
}arrayAssign($p_filedescr[0],deAspis(registerTaint(array('comment',false))),addTaint($v_value));
break ;
case PCLZIP_ATT_FILE_MTIME:if ( (!(is_integer(deAspisRC($v_value)))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE,false),concat2(concat(concat2(concat1("Invalid type ",attAspis(gettype(deAspisRC($v_value)))),". Integer expected for attribute '"),PclZipUtilOptionText($v_key)),"'"));
return PclZip::errorCode();
}arrayAssign($p_filedescr[0],deAspis(registerTaint(array('mtime',false))),addTaint($v_value));
break ;
case PCLZIP_ATT_FILE_CONTENT:arrayAssign($p_filedescr[0],deAspis(registerTaint(array('content',false))),addTaint($v_value));
break ;
default :PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),concat2(concat1("Unknown parameter '",$v_key),"'"));
return PclZip::errorCode();
 }
if ( ($v_requested_options[0] !== false))
 {for ( $key = Aspis_reset($v_requested_options) ; deAspis($key = Aspis_key($v_requested_options)) ; $key = Aspis_next($v_requested_options) )
{if ( (deAspis(attachAspis($v_requested_options,$key[0])) == ('mandatory')))
 {if ( (!((isset($p_file_list[0][$key[0]]) && Aspis_isset( $p_file_list [0][$key[0]])))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),concat2(concat(concat2(concat1("Missing mandatory parameter ",PclZipUtilOptionText($key)),"("),$key),")"));
return PclZip::errorCode();
}}}}}}return $v_result;
} }
function privFileDescrExpand ( &$p_filedescr_list,&$p_options ) {
{$v_result = array(1,false);
$v_result_list = array(array(),false);
for ( $i = array(0,false) ; ($i[0] < (sizeof(deAspisRC($p_filedescr_list)))) ; postincr($i) )
{$v_descr = attachAspis($p_filedescr_list,$i[0]);
arrayAssign($v_descr[0],deAspis(registerTaint(array('filename',false))),addTaint(PclZipUtilTranslateWinPath($v_descr[0]['filename'],array(false,false))));
arrayAssign($v_descr[0],deAspis(registerTaint(array('filename',false))),addTaint(PclZipUtilPathReduction($v_descr[0]['filename'])));
if ( file_exists(deAspis($v_descr[0]['filename'])))
 {if ( deAspis(@attAspis(is_file(deAspis($v_descr[0]['filename'])))))
 {arrayAssign($v_descr[0],deAspis(registerTaint(array('type',false))),addTaint(array('file',false)));
}else 
{if ( deAspis(@attAspis(is_dir(deAspis($v_descr[0]['filename'])))))
 {arrayAssign($v_descr[0],deAspis(registerTaint(array('type',false))),addTaint(array('folder',false)));
}else 
{if ( deAspis(@attAspis(is_link(deAspis($v_descr[0]['filename'])))))
 {continue ;
}else 
{{continue ;
}}}}}else 
{if ( ((isset($v_descr[0][('content')]) && Aspis_isset( $v_descr [0][('content')]))))
 {arrayAssign($v_descr[0],deAspis(registerTaint(array('type',false))),addTaint(array('virtual_file',false)));
}else 
{{PclZip::privErrorLog(array(PCLZIP_ERR_MISSING_FILE,false),concat2(concat1("File '",$v_descr[0]['filename']),"' does not exist"));
return PclZip::errorCode();
}}}$this->privCalculateStoredFilename($v_descr,$p_options);
arrayAssign($v_result_list[0],deAspis(registerTaint(array(sizeof(deAspisRC($v_result_list)),false))),addTaint($v_descr));
if ( (deAspis($v_descr[0]['type']) == ('folder')))
 {$v_dirlist_descr = array(array(),false);
$v_dirlist_nb = array(0,false);
if ( deAspis($v_folder_handler = @attAspis(opendir(deAspis($v_descr[0]['filename'])))))
 {while ( (deAspis(($v_item_handler = @attAspis(readdir($v_folder_handler[0])))) !== false) )
{if ( (($v_item_handler[0] == ('.')) || ($v_item_handler[0] == ('..'))))
 {continue ;
}arrayAssign($v_dirlist_descr[0][$v_dirlist_nb[0]][0],deAspis(registerTaint(array('filename',false))),addTaint(concat(concat2($v_descr[0]['filename'],'/'),$v_item_handler)));
if ( ((deAspis($v_descr[0]['stored_filename']) != deAspis($v_descr[0]['filename'])) && (!((isset($p_options[0][PCLZIP_OPT_REMOVE_ALL_PATH]) && Aspis_isset( $p_options [0][PCLZIP_OPT_REMOVE_ALL_PATH]))))))
 {if ( (deAspis($v_descr[0]['stored_filename']) != ('')))
 {arrayAssign($v_dirlist_descr[0][$v_dirlist_nb[0]][0],deAspis(registerTaint(array('new_full_name',false))),addTaint(concat(concat2($v_descr[0]['stored_filename'],'/'),$v_item_handler)));
}else 
{{arrayAssign($v_dirlist_descr[0][$v_dirlist_nb[0]][0],deAspis(registerTaint(array('new_full_name',false))),addTaint($v_item_handler));
}}}postincr($v_dirlist_nb);
}@closedir($v_folder_handler[0]);
}else 
{{}}if ( ($v_dirlist_nb[0] != (0)))
 {if ( (deAspis(($v_result = $this->privFileDescrExpand($v_dirlist_descr,$p_options))) != (1)))
 {return $v_result;
}$v_result_list = Aspis_array_merge($v_result_list,$v_dirlist_descr);
}else 
{{}}unset($v_dirlist_descr);
}}$p_filedescr_list = $v_result_list;
return $v_result;
} }
function privCreate ( $p_filedescr_list,&$p_result_list,&$p_options ) {
{$v_result = array(1,false);
$v_list_detail = array(array(),false);
$this->privDisableMagicQuotes();
if ( (deAspis(($v_result = $this->privOpenFd(array('wb',false)))) != (1)))
 {return $v_result;
}$v_result = $this->privAddList($p_filedescr_list,$p_result_list,$p_options);
$this->privCloseFd();
$this->privSwapBackMagicQuotes();
return $v_result;
} }
function privAdd ( $p_filedescr_list,&$p_result_list,&$p_options ) {
{$v_result = array(1,false);
$v_list_detail = array(array(),false);
if ( ((!(is_file($this->zipname[0]))) || (filesize($this->zipname[0]) == (0))))
 {$v_result = $this->privCreate($p_filedescr_list,$p_result_list,$p_options);
return $v_result;
}$this->privDisableMagicQuotes();
if ( (deAspis(($v_result = $this->privOpenFd(array('rb',false)))) != (1)))
 {$this->privSwapBackMagicQuotes();
return $v_result;
}$v_central_dir = array(array(),false);
if ( (deAspis(($v_result = $this->privReadEndCentralDir($v_central_dir))) != (1)))
 {$this->privCloseFd();
$this->privSwapBackMagicQuotes();
return $v_result;
}@attAspis(rewind($this->zip_fd[0]));
$v_zip_temp_name = concat2(concat1(PCLZIP_TEMPORARY_DIR,attAspis(uniqid('pclzip-'))),'.tmp');
if ( (deAspis(($v_zip_temp_fd = @attAspis(fopen($v_zip_temp_name[0],('wb'))))) == (0)))
 {$this->privCloseFd();
$this->privSwapBackMagicQuotes();
PclZip::privErrorLog(array(PCLZIP_ERR_READ_OPEN_FAIL,false),concat2(concat1('Unable to open temporary file \'',$v_zip_temp_name),'\' in binary write mode'));
return PclZip::errorCode();
}$v_size = $v_central_dir[0]['offset'];
while ( ($v_size[0] != (0)) )
{$v_read_size = (($v_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $v_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = attAspis(fread($this->zip_fd[0],$v_read_size[0]));
@attAspis(fwrite($v_zip_temp_fd[0],$v_buffer[0],$v_read_size[0]));
$v_size = array($v_size[0] - $v_read_size[0],false);
}$v_swap = $this->zip_fd;
$this->zip_fd = $v_zip_temp_fd;
$v_zip_temp_fd = $v_swap;
$v_header_list = array(array(),false);
if ( (deAspis(($v_result = $this->privAddFileList($p_filedescr_list,$v_header_list,$p_options))) != (1)))
 {fclose($v_zip_temp_fd[0]);
$this->privCloseFd();
@attAspis(unlink($v_zip_temp_name[0]));
$this->privSwapBackMagicQuotes();
return $v_result;
}$v_offset = @attAspis(ftell($this->zip_fd[0]));
$v_size = $v_central_dir[0]['size'];
while ( ($v_size[0] != (0)) )
{$v_read_size = (($v_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $v_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = @attAspis(fread($v_zip_temp_fd[0],$v_read_size[0]));
@attAspis(fwrite($this->zip_fd[0],$v_buffer[0],$v_read_size[0]));
$v_size = array($v_size[0] - $v_read_size[0],false);
}for ( $i = array(0,false),$v_count = array(0,false) ; ($i[0] < (sizeof(deAspisRC($v_header_list)))) ; postincr($i) )
{if ( (deAspis($v_header_list[0][$i[0]][0]['status']) == ('ok')))
 {if ( (deAspis(($v_result = $this->privWriteCentralFileHeader(attachAspis($v_header_list,$i[0])))) != (1)))
 {fclose($v_zip_temp_fd[0]);
$this->privCloseFd();
@attAspis(unlink($v_zip_temp_name[0]));
$this->privSwapBackMagicQuotes();
return $v_result;
}postincr($v_count);
}$this->privConvertHeader2FileInfo(attachAspis($v_header_list,$i[0]),attachAspis($p_result_list,$i[0]));
}$v_comment = $v_central_dir[0]['comment'];
if ( ((isset($p_options[0][PCLZIP_OPT_COMMENT]) && Aspis_isset( $p_options [0][PCLZIP_OPT_COMMENT]))))
 {$v_comment = attachAspis($p_options,PCLZIP_OPT_COMMENT);
}if ( ((isset($p_options[0][PCLZIP_OPT_ADD_COMMENT]) && Aspis_isset( $p_options [0][PCLZIP_OPT_ADD_COMMENT]))))
 {$v_comment = concat($v_comment,attachAspis($p_options,PCLZIP_OPT_ADD_COMMENT));
}if ( ((isset($p_options[0][PCLZIP_OPT_PREPEND_COMMENT]) && Aspis_isset( $p_options [0][PCLZIP_OPT_PREPEND_COMMENT]))))
 {$v_comment = concat(attachAspis($p_options,PCLZIP_OPT_PREPEND_COMMENT),$v_comment);
}$v_size = array(deAspis(@attAspis(ftell($this->zip_fd[0]))) - $v_offset[0],false);
if ( (deAspis(($v_result = $this->privWriteCentralHeader(array($v_count[0] + deAspis($v_central_dir[0]['entries']),false),$v_size,$v_offset,$v_comment))) != (1)))
 {unset($v_header_list);
$this->privSwapBackMagicQuotes();
return $v_result;
}$v_swap = $this->zip_fd;
$this->zip_fd = $v_zip_temp_fd;
$v_zip_temp_fd = $v_swap;
$this->privCloseFd();
@attAspis(fclose($v_zip_temp_fd[0]));
$this->privSwapBackMagicQuotes();
@attAspis(unlink($this->zipname[0]));
PclZipUtilRename($v_zip_temp_name,$this->zipname);
return $v_result;
} }
function privOpenFd ( $p_mode ) {
{$v_result = array(1,false);
if ( ($this->zip_fd[0] != (0)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_READ_OPEN_FAIL,false),concat2(concat1('Zip file \'',$this->zipname),'\' already open'));
return PclZip::errorCode();
}if ( (deAspis(($this->zip_fd = @attAspis(fopen($this->zipname[0],$p_mode[0])))) == (0)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_READ_OPEN_FAIL,false),concat2(concat(concat2(concat1('Unable to open archive \'',$this->zipname),'\' in '),$p_mode),' mode'));
return PclZip::errorCode();
}return $v_result;
} }
function privCloseFd (  ) {
{$v_result = array(1,false);
if ( ($this->zip_fd[0] != (0)))
 @attAspis(fclose($this->zip_fd[0]));
$this->zip_fd = array(0,false);
return $v_result;
} }
function privAddList ( $p_filedescr_list,&$p_result_list,&$p_options ) {
{$v_result = array(1,false);
$v_header_list = array(array(),false);
if ( (deAspis(($v_result = $this->privAddFileList($p_filedescr_list,$v_header_list,$p_options))) != (1)))
 {return $v_result;
}$v_offset = @attAspis(ftell($this->zip_fd[0]));
for ( $i = array(0,false),$v_count = array(0,false) ; ($i[0] < (sizeof(deAspisRC($v_header_list)))) ; postincr($i) )
{if ( (deAspis($v_header_list[0][$i[0]][0]['status']) == ('ok')))
 {if ( (deAspis(($v_result = $this->privWriteCentralFileHeader(attachAspis($v_header_list,$i[0])))) != (1)))
 {return $v_result;
}postincr($v_count);
}$this->privConvertHeader2FileInfo(attachAspis($v_header_list,$i[0]),attachAspis($p_result_list,$i[0]));
}$v_comment = array('',false);
if ( ((isset($p_options[0][PCLZIP_OPT_COMMENT]) && Aspis_isset( $p_options [0][PCLZIP_OPT_COMMENT]))))
 {$v_comment = attachAspis($p_options,PCLZIP_OPT_COMMENT);
}$v_size = array(deAspis(@attAspis(ftell($this->zip_fd[0]))) - $v_offset[0],false);
if ( (deAspis(($v_result = $this->privWriteCentralHeader($v_count,$v_size,$v_offset,$v_comment))) != (1)))
 {unset($v_header_list);
return $v_result;
}return $v_result;
} }
function privAddFileList ( $p_filedescr_list,&$p_result_list,&$p_options ) {
{$v_result = array(1,false);
$v_header = array(array(),false);
$v_nb = array(sizeof(deAspisRC($p_result_list)),false);
for ( $j = array(0,false) ; (($j[0] < (sizeof(deAspisRC($p_filedescr_list)))) && ($v_result[0] == (1))) ; postincr($j) )
{arrayAssign($p_filedescr_list[0][$j[0]][0],deAspis(registerTaint(array('filename',false))),addTaint(PclZipUtilTranslateWinPath($p_filedescr_list[0][$j[0]][0]['filename'],array(false,false))));
if ( (deAspis($p_filedescr_list[0][$j[0]][0]['filename']) == ("")))
 {continue ;
}if ( ((deAspis($p_filedescr_list[0][$j[0]][0]['type']) != ('virtual_file')) && (!(file_exists(deAspis($p_filedescr_list[0][$j[0]][0]['filename']))))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_MISSING_FILE,false),concat2(concat1("File '",$p_filedescr_list[0][$j[0]][0]['filename']),"' does not exist"));
return PclZip::errorCode();
}if ( (((deAspis($p_filedescr_list[0][$j[0]][0]['type']) == ('file')) || (deAspis($p_filedescr_list[0][$j[0]][0]['type']) == ('virtual_file'))) || ((deAspis($p_filedescr_list[0][$j[0]][0]['type']) == ('folder')) && ((!((isset($p_options[0][PCLZIP_OPT_REMOVE_ALL_PATH]) && Aspis_isset( $p_options [0][PCLZIP_OPT_REMOVE_ALL_PATH])))) || (denot_boolean(attachAspis($p_options,PCLZIP_OPT_REMOVE_ALL_PATH)))))))
 {$v_result = $this->privAddFile(attachAspis($p_filedescr_list,$j[0]),$v_header,$p_options);
if ( ($v_result[0] != (1)))
 {return $v_result;
}arrayAssign($p_result_list[0],deAspis(registerTaint(postincr($v_nb))),addTaint($v_header));
}}return $v_result;
} }
function privAddFile ( $p_filedescr,&$p_header,&$p_options ) {
{$v_result = array(1,false);
$p_filename = $p_filedescr[0]['filename'];
if ( ($p_filename[0] == ("")))
 {PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_PARAMETER,false),array("Invalid file list parameter (invalid or empty list)",false));
return PclZip::errorCode();
}clearstatcache();
arrayAssign($p_header[0],deAspis(registerTaint(array('version',false))),addTaint(array(20,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('version_extracted',false))),addTaint(array(10,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('flag',false))),addTaint(array(0,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('compression',false))),addTaint(array(0,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('crc',false))),addTaint(array(0,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('compressed_size',false))),addTaint(array(0,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('filename_len',false))),addTaint(attAspis(strlen($p_filename[0]))));
arrayAssign($p_header[0],deAspis(registerTaint(array('extra_len',false))),addTaint(array(0,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('disk',false))),addTaint(array(0,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('internal',false))),addTaint(array(0,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('offset',false))),addTaint(array(0,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('filename',false))),addTaint($p_filename));
arrayAssign($p_header[0],deAspis(registerTaint(array('stored_filename',false))),addTaint($p_filedescr[0]['stored_filename']));
arrayAssign($p_header[0],deAspis(registerTaint(array('extra',false))),addTaint(array('',false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('status',false))),addTaint(array('ok',false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('index',false))),addTaint(negate(array(1,false))));
if ( (deAspis($p_filedescr[0]['type']) == ('file')))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('external',false))),addTaint(array(0x00000000,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('size',false))),addTaint(attAspis(filesize($p_filename[0]))));
}else 
{if ( (deAspis($p_filedescr[0]['type']) == ('folder')))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('external',false))),addTaint(array(0x00000010,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('mtime',false))),addTaint(attAspis(filemtime($p_filename[0]))));
arrayAssign($p_header[0],deAspis(registerTaint(array('size',false))),addTaint(attAspis(filesize($p_filename[0]))));
}else 
{if ( (deAspis($p_filedescr[0]['type']) == ('virtual_file')))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('external',false))),addTaint(array(0x00000000,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('size',false))),addTaint(attAspis(strlen(deAspis($p_filedescr[0]['content'])))));
}}}if ( ((isset($p_filedescr[0][('mtime')]) && Aspis_isset( $p_filedescr [0][('mtime')]))))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('mtime',false))),addTaint($p_filedescr[0]['mtime']));
}else 
{if ( (deAspis($p_filedescr[0]['type']) == ('virtual_file')))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('mtime',false))),addTaint(attAspis(time())));
}else 
{{arrayAssign($p_header[0],deAspis(registerTaint(array('mtime',false))),addTaint(attAspis(filemtime($p_filename[0]))));
}}}if ( ((isset($p_filedescr[0][('comment')]) && Aspis_isset( $p_filedescr [0][('comment')]))))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('comment_len',false))),addTaint(attAspis(strlen(deAspis($p_filedescr[0]['comment'])))));
arrayAssign($p_header[0],deAspis(registerTaint(array('comment',false))),addTaint($p_filedescr[0]['comment']));
}else 
{{arrayAssign($p_header[0],deAspis(registerTaint(array('comment_len',false))),addTaint(array(0,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('comment',false))),addTaint(array('',false)));
}}if ( ((isset($p_options[0][PCLZIP_CB_PRE_ADD]) && Aspis_isset( $p_options [0][PCLZIP_CB_PRE_ADD]))))
 {$v_local_header = array(array(),false);
$this->privConvertHeader2FileInfo($p_header,$v_local_header);
$v_result = AspisDynamicCall(attachAspis($p_options,PCLZIP_CB_PRE_ADD),array(PCLZIP_CB_PRE_ADD,false),$v_local_header);
if ( ($v_result[0] == (0)))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('status',false))),addTaint(array("skipped",false)));
$v_result = array(1,false);
}if ( (deAspis($p_header[0]['stored_filename']) != deAspis($v_local_header[0]['stored_filename'])))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('stored_filename',false))),addTaint(PclZipUtilPathReduction($v_local_header[0]['stored_filename'])));
}}if ( (deAspis($p_header[0]['stored_filename']) == ("")))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('status',false))),addTaint(array("filtered",false)));
}if ( (strlen(deAspis($p_header[0]['stored_filename'])) > (0xFF)))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('status',false))),addTaint(array('filename_too_long',false)));
}if ( (deAspis($p_header[0]['status']) == ('ok')))
 {if ( (deAspis($p_filedescr[0]['type']) == ('file')))
 {if ( ((!((isset($p_options[0][PCLZIP_OPT_TEMP_FILE_OFF]) && Aspis_isset( $p_options [0][PCLZIP_OPT_TEMP_FILE_OFF])))) && (((isset($p_options[0][PCLZIP_OPT_TEMP_FILE_ON]) && Aspis_isset( $p_options [0][PCLZIP_OPT_TEMP_FILE_ON]))) || (((isset($p_options[0][PCLZIP_OPT_TEMP_FILE_THRESHOLD]) && Aspis_isset( $p_options [0][PCLZIP_OPT_TEMP_FILE_THRESHOLD]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_TEMP_FILE_THRESHOLD)) <= deAspis($p_header[0]['size']))))))
 {$v_result = $this->privAddFileUsingTempFile($p_filedescr,$p_header,$p_options);
if ( ($v_result[0] < PCLZIP_ERR_NO_ERROR))
 {return $v_result;
}}else 
{{if ( (deAspis(($v_file = @attAspis(fopen($p_filename[0],("rb"))))) == (0)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_READ_OPEN_FAIL,false),concat2(concat1("Unable to open file '",$p_filename),"' in binary read mode"));
return PclZip::errorCode();
}$v_content = @attAspis(fread($v_file[0],deAspis($p_header[0]['size'])));
@attAspis(fclose($v_file[0]));
arrayAssign($p_header[0],deAspis(registerTaint(array('crc',false))),addTaint(@attAspis(crc32($v_content[0]))));
if ( deAspis(attachAspis($p_options,PCLZIP_OPT_NO_COMPRESSION)))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('compressed_size',false))),addTaint($p_header[0]['size']));
arrayAssign($p_header[0],deAspis(registerTaint(array('compression',false))),addTaint(array(0,false)));
}else 
{{$v_content = @array(gzdeflate(deAspisRC($v_content)),false);
arrayAssign($p_header[0],deAspis(registerTaint(array('compressed_size',false))),addTaint(attAspis(strlen($v_content[0]))));
arrayAssign($p_header[0],deAspis(registerTaint(array('compression',false))),addTaint(array(8,false)));
}}if ( (deAspis(($v_result = $this->privWriteFileHeader($p_header))) != (1)))
 {@attAspis(fclose($v_file[0]));
return $v_result;
}@attAspis(fwrite($this->zip_fd[0],$v_content[0],deAspis($p_header[0]['compressed_size'])));
}}}else 
{if ( (deAspis($p_filedescr[0]['type']) == ('virtual_file')))
 {$v_content = $p_filedescr[0]['content'];
arrayAssign($p_header[0],deAspis(registerTaint(array('crc',false))),addTaint(@attAspis(crc32($v_content[0]))));
if ( deAspis(attachAspis($p_options,PCLZIP_OPT_NO_COMPRESSION)))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('compressed_size',false))),addTaint($p_header[0]['size']));
arrayAssign($p_header[0],deAspis(registerTaint(array('compression',false))),addTaint(array(0,false)));
}else 
{{$v_content = @array(gzdeflate(deAspisRC($v_content)),false);
arrayAssign($p_header[0],deAspis(registerTaint(array('compressed_size',false))),addTaint(attAspis(strlen($v_content[0]))));
arrayAssign($p_header[0],deAspis(registerTaint(array('compression',false))),addTaint(array(8,false)));
}}if ( (deAspis(($v_result = $this->privWriteFileHeader($p_header))) != (1)))
 {@attAspis(fclose($v_file[0]));
return $v_result;
}@attAspis(fwrite($this->zip_fd[0],$v_content[0],deAspis($p_header[0]['compressed_size'])));
}else 
{if ( (deAspis($p_filedescr[0]['type']) == ('folder')))
 {if ( (deAspis(@Aspis_substr($p_header[0]['stored_filename'],negate(array(1,false)))) != ('/')))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('stored_filename',false))),addTaint(concat2($p_header[0]['stored_filename'],'/')));
}arrayAssign($p_header[0],deAspis(registerTaint(array('size',false))),addTaint(array(0,false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('external',false))),addTaint(array(0x00000010,false)));
if ( (deAspis(($v_result = $this->privWriteFileHeader($p_header))) != (1)))
 {return $v_result;
}}}}}if ( ((isset($p_options[0][PCLZIP_CB_POST_ADD]) && Aspis_isset( $p_options [0][PCLZIP_CB_POST_ADD]))))
 {$v_local_header = array(array(),false);
$this->privConvertHeader2FileInfo($p_header,$v_local_header);
$v_result = AspisDynamicCall(attachAspis($p_options,PCLZIP_CB_POST_ADD),array(PCLZIP_CB_POST_ADD,false),$v_local_header);
if ( ($v_result[0] == (0)))
 {$v_result = array(1,false);
}}return $v_result;
} }
function privAddFileUsingTempFile ( $p_filedescr,&$p_header,&$p_options ) {
{$v_result = array(PCLZIP_ERR_NO_ERROR,false);
$p_filename = $p_filedescr[0]['filename'];
if ( (deAspis(($v_file = @attAspis(fopen($p_filename[0],("rb"))))) == (0)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_READ_OPEN_FAIL,false),concat2(concat1("Unable to open file '",$p_filename),"' in binary read mode"));
return PclZip::errorCode();
}$v_gzip_temp_name = concat2(concat1(PCLZIP_TEMPORARY_DIR,attAspis(uniqid('pclzip-'))),'.gz');
if ( (deAspis(($v_file_compressed = @array(gzopen(deAspisRC($v_gzip_temp_name),"wb"),false))) == (0)))
 {fclose($v_file[0]);
PclZip::privErrorLog(array(PCLZIP_ERR_WRITE_OPEN_FAIL,false),concat2(concat1('Unable to open temporary file \'',$v_gzip_temp_name),'\' in binary write mode'));
return PclZip::errorCode();
}$v_size = attAspis(filesize($p_filename[0]));
while ( ($v_size[0] != (0)) )
{$v_read_size = (($v_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $v_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = @attAspis(fread($v_file[0],$v_read_size[0]));
@array(gzputs(deAspisRC($v_file_compressed),deAspisRC($v_buffer),deAspisRC($v_read_size)),false);
$v_size = array($v_size[0] - $v_read_size[0],false);
}@attAspis(fclose($v_file[0]));
@array(gzclose(deAspisRC($v_file_compressed)),false);
if ( (filesize($v_gzip_temp_name[0]) < (18)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_BAD_FORMAT,false),concat2(concat1('gzip temporary file \'',$v_gzip_temp_name),'\' has invalid filesize - should be minimum 18 bytes'));
return PclZip::errorCode();
}if ( (deAspis(($v_file_compressed = @attAspis(fopen($v_gzip_temp_name[0],("rb"))))) == (0)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_READ_OPEN_FAIL,false),concat2(concat1('Unable to open temporary file \'',$v_gzip_temp_name),'\' in binary read mode'));
return PclZip::errorCode();
}$v_binary_data = @attAspis(fread($v_file_compressed[0],(10)));
$v_data_header = attAspisRC(unpack(('a1id1/a1id2/a1cm/a1flag/Vmtime/a1xfl/a1os'),$v_binary_data[0]));
arrayAssign($v_data_header[0],deAspis(registerTaint(array('os',false))),addTaint(Aspis_bin2hex($v_data_header[0]['os'])));
@attAspis(fseek($v_file_compressed[0],(filesize($v_gzip_temp_name[0]) - (8))));
$v_binary_data = @attAspis(fread($v_file_compressed[0],(8)));
$v_data_footer = attAspisRC(unpack(('Vcrc/Vcompressed_size'),$v_binary_data[0]));
arrayAssign($p_header[0],deAspis(registerTaint(array('compression',false))),addTaint(attAspis(ord(deAspis($v_data_header[0]['cm'])))));
arrayAssign($p_header[0],deAspis(registerTaint(array('crc',false))),addTaint($v_data_footer[0]['crc']));
arrayAssign($p_header[0],deAspis(registerTaint(array('compressed_size',false))),addTaint(array(filesize($v_gzip_temp_name[0]) - (18),false)));
@attAspis(fclose($v_file_compressed[0]));
if ( (deAspis(($v_result = $this->privWriteFileHeader($p_header))) != (1)))
 {return $v_result;
}if ( (deAspis(($v_file_compressed = @attAspis(fopen($v_gzip_temp_name[0],("rb"))))) == (0)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_READ_OPEN_FAIL,false),concat2(concat1('Unable to open temporary file \'',$v_gzip_temp_name),'\' in binary read mode'));
return PclZip::errorCode();
}fseek($v_file_compressed[0],(10));
$v_size = $p_header[0]['compressed_size'];
while ( ($v_size[0] != (0)) )
{$v_read_size = (($v_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $v_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = @attAspis(fread($v_file_compressed[0],$v_read_size[0]));
@attAspis(fwrite($this->zip_fd[0],$v_buffer[0],$v_read_size[0]));
$v_size = array($v_size[0] - $v_read_size[0],false);
}@attAspis(fclose($v_file_compressed[0]));
@attAspis(unlink($v_gzip_temp_name[0]));
return $v_result;
} }
function privCalculateStoredFilename ( &$p_filedescr,&$p_options ) {
{$v_result = array(1,false);
$p_filename = $p_filedescr[0]['filename'];
if ( ((isset($p_options[0][PCLZIP_OPT_ADD_PATH]) && Aspis_isset( $p_options [0][PCLZIP_OPT_ADD_PATH]))))
 {$p_add_dir = attachAspis($p_options,PCLZIP_OPT_ADD_PATH);
}else 
{{$p_add_dir = array('',false);
}}if ( ((isset($p_options[0][PCLZIP_OPT_REMOVE_PATH]) && Aspis_isset( $p_options [0][PCLZIP_OPT_REMOVE_PATH]))))
 {$p_remove_dir = attachAspis($p_options,PCLZIP_OPT_REMOVE_PATH);
}else 
{{$p_remove_dir = array('',false);
}}if ( ((isset($p_options[0][PCLZIP_OPT_REMOVE_ALL_PATH]) && Aspis_isset( $p_options [0][PCLZIP_OPT_REMOVE_ALL_PATH]))))
 {$p_remove_all_dir = attachAspis($p_options,PCLZIP_OPT_REMOVE_ALL_PATH);
}else 
{{$p_remove_all_dir = array(0,false);
}}if ( ((isset($p_filedescr[0][('new_full_name')]) && Aspis_isset( $p_filedescr [0][('new_full_name')]))))
 {$v_stored_filename = PclZipUtilTranslateWinPath($p_filedescr[0]['new_full_name']);
}else 
{{if ( ((isset($p_filedescr[0][('new_short_name')]) && Aspis_isset( $p_filedescr [0][('new_short_name')]))))
 {$v_path_info = Aspis_pathinfo($p_filename);
$v_dir = array('',false);
if ( (deAspis($v_path_info[0]['dirname']) != ('')))
 {$v_dir = concat2($v_path_info[0]['dirname'],'/');
}$v_stored_filename = concat($v_dir,$p_filedescr[0]['new_short_name']);
}else 
{{$v_stored_filename = $p_filename;
}}if ( $p_remove_all_dir[0])
 {$v_stored_filename = Aspis_basename($p_filename);
}else 
{if ( ($p_remove_dir[0] != ("")))
 {if ( (deAspis(Aspis_substr($p_remove_dir,negate(array(1,false)))) != ('/')))
 $p_remove_dir = concat2($p_remove_dir,"/");
if ( ((deAspis(Aspis_substr($p_filename,array(0,false),array(2,false))) == ("./")) || (deAspis(Aspis_substr($p_remove_dir,array(0,false),array(2,false))) == ("./"))))
 {if ( ((deAspis(Aspis_substr($p_filename,array(0,false),array(2,false))) == ("./")) && (deAspis(Aspis_substr($p_remove_dir,array(0,false),array(2,false))) != ("./"))))
 {$p_remove_dir = concat1("./",$p_remove_dir);
}if ( ((deAspis(Aspis_substr($p_filename,array(0,false),array(2,false))) != ("./")) && (deAspis(Aspis_substr($p_remove_dir,array(0,false),array(2,false))) == ("./"))))
 {$p_remove_dir = Aspis_substr($p_remove_dir,array(2,false));
}}$v_compare = PclZipUtilPathInclusion($p_remove_dir,$v_stored_filename);
if ( ($v_compare[0] > (0)))
 {if ( ($v_compare[0] == (2)))
 {$v_stored_filename = array("",false);
}else 
{{$v_stored_filename = Aspis_substr($v_stored_filename,attAspis(strlen($p_remove_dir[0])));
}}}}}$v_stored_filename = PclZipUtilTranslateWinPath($v_stored_filename);
if ( ($p_add_dir[0] != ("")))
 {if ( (deAspis(Aspis_substr($p_add_dir,negate(array(1,false)))) == ("/")))
 $v_stored_filename = concat($p_add_dir,$v_stored_filename);
else 
{$v_stored_filename = concat(concat2($p_add_dir,"/"),$v_stored_filename);
}}}}$v_stored_filename = PclZipUtilPathReduction($v_stored_filename);
arrayAssign($p_filedescr[0],deAspis(registerTaint(array('stored_filename',false))),addTaint($v_stored_filename));
return $v_result;
} }
function privWriteFileHeader ( &$p_header ) {
{$v_result = array(1,false);
arrayAssign($p_header[0],deAspis(registerTaint(array('offset',false))),addTaint(attAspis(ftell($this->zip_fd[0]))));
$v_date = attAspisRC(getdate(deAspis($p_header[0]['mtime'])));
$v_mtime = array(((deAspis($v_date[0]['hours']) << (11)) + (deAspis($v_date[0]['minutes']) << (5))) + (deAspis($v_date[0]['seconds']) / (2)),false);
$v_mdate = array((((deAspis($v_date[0]['year']) - (1980)) << (9)) + (deAspis($v_date[0]['mon']) << (5))) + deAspis($v_date[0]['mday']),false);
$v_binary_data = attAspis(pack(("VvvvvvVVVvv"),0x04034b50,deAspisRC($p_header[0]['version_extracted']),deAspisRC($p_header[0]['flag']),deAspisRC($p_header[0]['compression']),deAspisRC($v_mtime),deAspisRC($v_mdate),deAspisRC($p_header[0]['crc']),deAspisRC($p_header[0]['compressed_size']),deAspisRC($p_header[0]['size']),deAspisRC(attAspis(strlen(deAspis($p_header[0]['stored_filename'])))),deAspisRC($p_header[0]['extra_len'])));
fputs($this->zip_fd[0],$v_binary_data[0],(30));
if ( (strlen(deAspis($p_header[0]['stored_filename'])) != (0)))
 {fputs($this->zip_fd[0],deAspis($p_header[0]['stored_filename']),strlen(deAspis($p_header[0]['stored_filename'])));
}if ( (deAspis($p_header[0]['extra_len']) != (0)))
 {fputs($this->zip_fd[0],deAspis($p_header[0]['extra']),deAspis($p_header[0]['extra_len']));
}return $v_result;
} }
function privWriteCentralFileHeader ( &$p_header ) {
{$v_result = array(1,false);
$v_date = attAspisRC(getdate(deAspis($p_header[0]['mtime'])));
$v_mtime = array(((deAspis($v_date[0]['hours']) << (11)) + (deAspis($v_date[0]['minutes']) << (5))) + (deAspis($v_date[0]['seconds']) / (2)),false);
$v_mdate = array((((deAspis($v_date[0]['year']) - (1980)) << (9)) + (deAspis($v_date[0]['mon']) << (5))) + deAspis($v_date[0]['mday']),false);
$v_binary_data = attAspis(pack(("VvvvvvvVVVvvvvvVV"),0x02014b50,deAspisRC($p_header[0]['version']),deAspisRC($p_header[0]['version_extracted']),deAspisRC($p_header[0]['flag']),deAspisRC($p_header[0]['compression']),deAspisRC($v_mtime),deAspisRC($v_mdate),deAspisRC($p_header[0]['crc']),deAspisRC($p_header[0]['compressed_size']),deAspisRC($p_header[0]['size']),deAspisRC(attAspis(strlen(deAspis($p_header[0]['stored_filename'])))),deAspisRC($p_header[0]['extra_len']),deAspisRC($p_header[0]['comment_len']),deAspisRC($p_header[0]['disk']),deAspisRC($p_header[0]['internal']),deAspisRC($p_header[0]['external']),deAspisRC($p_header[0]['offset'])));
fputs($this->zip_fd[0],$v_binary_data[0],(46));
if ( (strlen(deAspis($p_header[0]['stored_filename'])) != (0)))
 {fputs($this->zip_fd[0],deAspis($p_header[0]['stored_filename']),strlen(deAspis($p_header[0]['stored_filename'])));
}if ( (deAspis($p_header[0]['extra_len']) != (0)))
 {fputs($this->zip_fd[0],deAspis($p_header[0]['extra']),deAspis($p_header[0]['extra_len']));
}if ( (deAspis($p_header[0]['comment_len']) != (0)))
 {fputs($this->zip_fd[0],deAspis($p_header[0]['comment']),deAspis($p_header[0]['comment_len']));
}return $v_result;
} }
function privWriteCentralHeader ( $p_nb_entries,$p_size,$p_offset,$p_comment ) {
{$v_result = array(1,false);
$v_binary_data = attAspis(pack(("VvvvvVVv"),0x06054b50,0,0,deAspisRC($p_nb_entries),deAspisRC($p_nb_entries),deAspisRC($p_size),deAspisRC($p_offset),deAspisRC(attAspis(strlen($p_comment[0])))));
fputs($this->zip_fd[0],$v_binary_data[0],(22));
if ( (strlen($p_comment[0]) != (0)))
 {fputs($this->zip_fd[0],$p_comment[0],strlen($p_comment[0]));
}return $v_result;
} }
function privList ( &$p_list ) {
{$v_result = array(1,false);
$this->privDisableMagicQuotes();
if ( (deAspis(($this->zip_fd = @attAspis(fopen($this->zipname[0],('rb'))))) == (0)))
 {$this->privSwapBackMagicQuotes();
PclZip::privErrorLog(array(PCLZIP_ERR_READ_OPEN_FAIL,false),concat2(concat1('Unable to open archive \'',$this->zipname),'\' in binary read mode'));
return PclZip::errorCode();
}$v_central_dir = array(array(),false);
if ( (deAspis(($v_result = $this->privReadEndCentralDir($v_central_dir))) != (1)))
 {$this->privSwapBackMagicQuotes();
return $v_result;
}@attAspis(rewind($this->zip_fd[0]));
if ( deAspis(@attAspis(fseek($this->zip_fd[0],deAspis($v_central_dir[0]['offset'])))))
 {$this->privSwapBackMagicQuotes();
PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_ARCHIVE_ZIP,false),array('Invalid archive size',false));
return PclZip::errorCode();
}for ( $i = array(0,false) ; ($i[0] < deAspis($v_central_dir[0]['entries'])) ; postincr($i) )
{if ( (deAspis(($v_result = $this->privReadCentralFileHeader($v_header))) != (1)))
 {$this->privSwapBackMagicQuotes();
return $v_result;
}arrayAssign($v_header[0],deAspis(registerTaint(array('index',false))),addTaint($i));
$this->privConvertHeader2FileInfo($v_header,attachAspis($p_list,$i[0]));
unset($v_header);
}$this->privCloseFd();
$this->privSwapBackMagicQuotes();
return $v_result;
} }
function privConvertHeader2FileInfo ( $p_header,&$p_info ) {
{$v_result = array(1,false);
$v_temp_path = PclZipUtilPathReduction($p_header[0]['filename']);
arrayAssign($p_info[0],deAspis(registerTaint(array('filename',false))),addTaint($v_temp_path));
$v_temp_path = PclZipUtilPathReduction($p_header[0]['stored_filename']);
arrayAssign($p_info[0],deAspis(registerTaint(array('stored_filename',false))),addTaint($v_temp_path));
arrayAssign($p_info[0],deAspis(registerTaint(array('size',false))),addTaint($p_header[0]['size']));
arrayAssign($p_info[0],deAspis(registerTaint(array('compressed_size',false))),addTaint($p_header[0]['compressed_size']));
arrayAssign($p_info[0],deAspis(registerTaint(array('mtime',false))),addTaint($p_header[0]['mtime']));
arrayAssign($p_info[0],deAspis(registerTaint(array('comment',false))),addTaint($p_header[0]['comment']));
arrayAssign($p_info[0],deAspis(registerTaint(array('folder',false))),addTaint((array((deAspis($p_header[0]['external']) & (0x00000010)) == (0x00000010),false))));
arrayAssign($p_info[0],deAspis(registerTaint(array('index',false))),addTaint($p_header[0]['index']));
arrayAssign($p_info[0],deAspis(registerTaint(array('status',false))),addTaint($p_header[0]['status']));
arrayAssign($p_info[0],deAspis(registerTaint(array('crc',false))),addTaint($p_header[0]['crc']));
return $v_result;
} }
function privExtractByRule ( &$p_file_list,$p_path,$p_remove_path,$p_remove_all_path,&$p_options ) {
{$v_result = array(1,false);
$this->privDisableMagicQuotes();
if ( (($p_path[0] == ("")) || (((deAspis(Aspis_substr($p_path,array(0,false),array(1,false))) != ("/")) && (deAspis(Aspis_substr($p_path,array(0,false),array(3,false))) != ("../"))) && (deAspis(Aspis_substr($p_path,array(1,false),array(2,false))) != (":/")))))
 $p_path = concat1("./",$p_path);
if ( (($p_path[0] != ("./")) && ($p_path[0] != ("/"))))
 {while ( (deAspis(Aspis_substr($p_path,negate(array(1,false)))) == ("/")) )
{$p_path = Aspis_substr($p_path,array(0,false),array(strlen($p_path[0]) - (1),false));
}}if ( (($p_remove_path[0] != ("")) && (deAspis(Aspis_substr($p_remove_path,negate(array(1,false)))) != ('/'))))
 {$p_remove_path = concat2($p_remove_path,'/');
}$p_remove_path_size = attAspis(strlen($p_remove_path[0]));
if ( (deAspis(($v_result = $this->privOpenFd(array('rb',false)))) != (1)))
 {$this->privSwapBackMagicQuotes();
return $v_result;
}$v_central_dir = array(array(),false);
if ( (deAspis(($v_result = $this->privReadEndCentralDir($v_central_dir))) != (1)))
 {$this->privCloseFd();
$this->privSwapBackMagicQuotes();
return $v_result;
}$v_pos_entry = $v_central_dir[0]['offset'];
$j_start = array(0,false);
for ( $i = array(0,false),$v_nb_extracted = array(0,false) ; ($i[0] < deAspis($v_central_dir[0]['entries'])) ; postincr($i) )
{@attAspis(rewind($this->zip_fd[0]));
if ( deAspis(@attAspis(fseek($this->zip_fd[0],$v_pos_entry[0]))))
 {$this->privCloseFd();
$this->privSwapBackMagicQuotes();
PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_ARCHIVE_ZIP,false),array('Invalid archive size',false));
return PclZip::errorCode();
}$v_header = array(array(),false);
if ( (deAspis(($v_result = $this->privReadCentralFileHeader($v_header))) != (1)))
 {$this->privCloseFd();
$this->privSwapBackMagicQuotes();
return $v_result;
}arrayAssign($v_header[0],deAspis(registerTaint(array('index',false))),addTaint($i));
$v_pos_entry = attAspis(ftell($this->zip_fd[0]));
$v_extract = array(false,false);
if ( (((isset($p_options[0][PCLZIP_OPT_BY_NAME]) && Aspis_isset( $p_options [0][PCLZIP_OPT_BY_NAME]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_BY_NAME)) != (0))))
 {for ( $j = array(0,false) ; (($j[0] < (sizeof(deAspisRC(attachAspis($p_options,PCLZIP_OPT_BY_NAME))))) && (denot_boolean($v_extract))) ; postincr($j) )
{if ( (deAspis(Aspis_substr(attachAspis($p_options[0][PCLZIP_OPT_BY_NAME],$j[0]),negate(array(1,false)))) == ("/")))
 {if ( ((strlen(deAspis($v_header[0]['stored_filename'])) > strlen(deAspis(attachAspis($p_options[0][PCLZIP_OPT_BY_NAME],$j[0])))) && (deAspis(Aspis_substr($v_header[0]['stored_filename'],array(0,false),attAspis(strlen(deAspis(attachAspis($p_options[0][PCLZIP_OPT_BY_NAME],$j[0])))))) == deAspis(attachAspis($p_options[0][PCLZIP_OPT_BY_NAME],$j[0])))))
 {$v_extract = array(true,false);
}}elseif ( (deAspis($v_header[0]['stored_filename']) == deAspis(attachAspis($p_options[0][PCLZIP_OPT_BY_NAME],$j[0]))))
 {$v_extract = array(true,false);
}}}else 
{if ( (((isset($p_options[0][PCLZIP_OPT_BY_PREG]) && Aspis_isset( $p_options [0][PCLZIP_OPT_BY_PREG]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_BY_PREG)) != (""))))
 {if ( deAspis(Aspis_preg_match(attachAspis($p_options,PCLZIP_OPT_BY_PREG),$v_header[0]['stored_filename'])))
 {$v_extract = array(true,false);
}}else 
{if ( (((isset($p_options[0][PCLZIP_OPT_BY_INDEX]) && Aspis_isset( $p_options [0][PCLZIP_OPT_BY_INDEX]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_BY_INDEX)) != (0))))
 {for ( $j = $j_start ; (($j[0] < (sizeof(deAspisRC(attachAspis($p_options,PCLZIP_OPT_BY_INDEX))))) && (denot_boolean($v_extract))) ; postincr($j) )
{if ( (($i[0] >= deAspis($p_options[0][PCLZIP_OPT_BY_INDEX][0][$j[0]][0]['start'])) && ($i[0] <= deAspis($p_options[0][PCLZIP_OPT_BY_INDEX][0][$j[0]][0]['end']))))
 {$v_extract = array(true,false);
}if ( ($i[0] >= deAspis($p_options[0][PCLZIP_OPT_BY_INDEX][0][$j[0]][0]['end'])))
 {$j_start = array($j[0] + (1),false);
}if ( (deAspis($p_options[0][PCLZIP_OPT_BY_INDEX][0][$j[0]][0]['start']) > $i[0]))
 {break ;
}}}else 
{{$v_extract = array(true,false);
}}}}if ( (deAspis(($v_extract)) && ((deAspis($v_header[0]['compression']) != (8)) && (deAspis($v_header[0]['compression']) != (0)))))
 {arrayAssign($v_header[0],deAspis(registerTaint(array('status',false))),addTaint(array('unsupported_compression',false)));
if ( (((isset($p_options[0][PCLZIP_OPT_STOP_ON_ERROR]) && Aspis_isset( $p_options [0][PCLZIP_OPT_STOP_ON_ERROR]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_STOP_ON_ERROR)) === true)))
 {$this->privSwapBackMagicQuotes();
PclZip::privErrorLog(array(PCLZIP_ERR_UNSUPPORTED_COMPRESSION,false),concat2(concat(concat2(concat2(concat2(concat1("Filename '",$v_header[0]['stored_filename']),"' is "),"compressed by an unsupported compression "),"method ("),$v_header[0]['compression']),") "));
return PclZip::errorCode();
}}if ( (deAspis(($v_extract)) && ((deAspis($v_header[0]['flag']) & (1)) == (1))))
 {arrayAssign($v_header[0],deAspis(registerTaint(array('status',false))),addTaint(array('unsupported_encryption',false)));
if ( (((isset($p_options[0][PCLZIP_OPT_STOP_ON_ERROR]) && Aspis_isset( $p_options [0][PCLZIP_OPT_STOP_ON_ERROR]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_STOP_ON_ERROR)) === true)))
 {$this->privSwapBackMagicQuotes();
PclZip::privErrorLog(array(PCLZIP_ERR_UNSUPPORTED_ENCRYPTION,false),concat2(concat(concat12("Unsupported encryption for "," filename '"),$v_header[0]['stored_filename']),"'"));
return PclZip::errorCode();
}}if ( (deAspis(($v_extract)) && (deAspis($v_header[0]['status']) != ('ok'))))
 {$v_result = $this->privConvertHeader2FileInfo($v_header,attachAspis($p_file_list,deAspis(postincr($v_nb_extracted))));
if ( ($v_result[0] != (1)))
 {$this->privCloseFd();
$this->privSwapBackMagicQuotes();
return $v_result;
}$v_extract = array(false,false);
}if ( $v_extract[0])
 {@attAspis(rewind($this->zip_fd[0]));
if ( deAspis(@attAspis(fseek($this->zip_fd[0],deAspis($v_header[0]['offset'])))))
 {$this->privCloseFd();
$this->privSwapBackMagicQuotes();
PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_ARCHIVE_ZIP,false),array('Invalid archive size',false));
return PclZip::errorCode();
}if ( deAspis(attachAspis($p_options,PCLZIP_OPT_EXTRACT_AS_STRING)))
 {$v_string = array('',false);
$v_result1 = $this->privExtractFileAsString($v_header,$v_string,$p_options);
if ( ($v_result1[0] < (1)))
 {$this->privCloseFd();
$this->privSwapBackMagicQuotes();
return $v_result1;
}if ( (deAspis(($v_result = $this->privConvertHeader2FileInfo($v_header,attachAspis($p_file_list,$v_nb_extracted[0])))) != (1)))
 {$this->privCloseFd();
$this->privSwapBackMagicQuotes();
return $v_result;
}arrayAssign($p_file_list[0][$v_nb_extracted[0]][0],deAspis(registerTaint(array('content',false))),addTaint($v_string));
postincr($v_nb_extracted);
if ( ($v_result1[0] == (2)))
 {break ;
}}elseif ( (((isset($p_options[0][PCLZIP_OPT_EXTRACT_IN_OUTPUT]) && Aspis_isset( $p_options [0][PCLZIP_OPT_EXTRACT_IN_OUTPUT]))) && deAspis((attachAspis($p_options,PCLZIP_OPT_EXTRACT_IN_OUTPUT)))))
 {$v_result1 = $this->privExtractFileInOutput($v_header,$p_options);
if ( ($v_result1[0] < (1)))
 {$this->privCloseFd();
$this->privSwapBackMagicQuotes();
return $v_result1;
}if ( (deAspis(($v_result = $this->privConvertHeader2FileInfo($v_header,attachAspis($p_file_list,deAspis(postincr($v_nb_extracted)))))) != (1)))
 {$this->privCloseFd();
$this->privSwapBackMagicQuotes();
return $v_result;
}if ( ($v_result1[0] == (2)))
 {break ;
}}else 
{{$v_result1 = $this->privExtractFile($v_header,$p_path,$p_remove_path,$p_remove_all_path,$p_options);
if ( ($v_result1[0] < (1)))
 {$this->privCloseFd();
$this->privSwapBackMagicQuotes();
return $v_result1;
}if ( (deAspis(($v_result = $this->privConvertHeader2FileInfo($v_header,attachAspis($p_file_list,deAspis(postincr($v_nb_extracted)))))) != (1)))
 {$this->privCloseFd();
$this->privSwapBackMagicQuotes();
return $v_result;
}if ( ($v_result1[0] == (2)))
 {break ;
}}}}}$this->privCloseFd();
$this->privSwapBackMagicQuotes();
return $v_result;
} }
function privExtractFile ( &$p_entry,$p_path,$p_remove_path,$p_remove_all_path,&$p_options ) {
{$v_result = array(1,false);
if ( (deAspis(($v_result = $this->privReadFileHeader($v_header))) != (1)))
 {return $v_result;
}if ( (deAspis($this->privCheckFileHeaders($v_header,$p_entry)) != (1)))
 {}if ( ($p_remove_all_path[0] == true))
 {if ( ((deAspis($p_entry[0]['external']) & (0x00000010)) == (0x00000010)))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("filtered",false)));
return $v_result;
}arrayAssign($p_entry[0],deAspis(registerTaint(array('filename',false))),addTaint(Aspis_basename($p_entry[0]['filename'])));
}else 
{if ( ($p_remove_path[0] != ("")))
 {if ( (deAspis(PclZipUtilPathInclusion($p_remove_path,$p_entry[0]['filename'])) == (2)))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("filtered",false)));
return $v_result;
}$p_remove_path_size = attAspis(strlen($p_remove_path[0]));
if ( (deAspis(Aspis_substr($p_entry[0]['filename'],array(0,false),$p_remove_path_size)) == $p_remove_path[0]))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('filename',false))),addTaint(Aspis_substr($p_entry[0]['filename'],$p_remove_path_size)));
}}}if ( ($p_path[0] != ('')))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('filename',false))),addTaint(concat(concat2($p_path,"/"),$p_entry[0]['filename'])));
}if ( ((isset($p_options[0][PCLZIP_OPT_EXTRACT_DIR_RESTRICTION]) && Aspis_isset( $p_options [0][PCLZIP_OPT_EXTRACT_DIR_RESTRICTION]))))
 {$v_inclusion = PclZipUtilPathInclusion(attachAspis($p_options,PCLZIP_OPT_EXTRACT_DIR_RESTRICTION),$p_entry[0]['filename']);
if ( ($v_inclusion[0] == (0)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_DIRECTORY_RESTRICTION,false),concat2(concat2(concat1("Filename '",$p_entry[0]['filename']),"' is "),"outside PCLZIP_OPT_EXTRACT_DIR_RESTRICTION"));
return PclZip::errorCode();
}}if ( ((isset($p_options[0][PCLZIP_CB_PRE_EXTRACT]) && Aspis_isset( $p_options [0][PCLZIP_CB_PRE_EXTRACT]))))
 {$v_local_header = array(array(),false);
$this->privConvertHeader2FileInfo($p_entry,$v_local_header);
$v_result = AspisDynamicCall(attachAspis($p_options,PCLZIP_CB_PRE_EXTRACT),array(PCLZIP_CB_PRE_EXTRACT,false),$v_local_header);
if ( ($v_result[0] == (0)))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("skipped",false)));
$v_result = array(1,false);
}if ( ($v_result[0] == (2)))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("aborted",false)));
$v_result = array(PCLZIP_ERR_USER_ABORTED,false);
}arrayAssign($p_entry[0],deAspis(registerTaint(array('filename',false))),addTaint($v_local_header[0]['filename']));
}if ( (deAspis($p_entry[0]['status']) == ('ok')))
 {if ( file_exists(deAspis($p_entry[0]['filename'])))
 {if ( is_dir(deAspis($p_entry[0]['filename'])))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("already_a_directory",false)));
if ( (((isset($p_options[0][PCLZIP_OPT_STOP_ON_ERROR]) && Aspis_isset( $p_options [0][PCLZIP_OPT_STOP_ON_ERROR]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_STOP_ON_ERROR)) === true)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_ALREADY_A_DIRECTORY,false),concat2(concat2(concat1("Filename '",$p_entry[0]['filename']),"' is "),"already used by an existing directory"));
return PclZip::errorCode();
}}else 
{if ( (!(is_writeable(deAspisRC($p_entry[0]['filename'])))))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("write_protected",false)));
if ( (((isset($p_options[0][PCLZIP_OPT_STOP_ON_ERROR]) && Aspis_isset( $p_options [0][PCLZIP_OPT_STOP_ON_ERROR]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_STOP_ON_ERROR)) === true)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_WRITE_OPEN_FAIL,false),concat2(concat2(concat1("Filename '",$p_entry[0]['filename']),"' exists "),"and is write protected"));
return PclZip::errorCode();
}}else 
{if ( (filemtime(deAspis($p_entry[0]['filename'])) > deAspis($p_entry[0]['mtime'])))
 {if ( (((isset($p_options[0][PCLZIP_OPT_REPLACE_NEWER]) && Aspis_isset( $p_options [0][PCLZIP_OPT_REPLACE_NEWER]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_REPLACE_NEWER)) === true)))
 {}else 
{{arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("newer_exist",false)));
if ( (((isset($p_options[0][PCLZIP_OPT_STOP_ON_ERROR]) && Aspis_isset( $p_options [0][PCLZIP_OPT_STOP_ON_ERROR]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_STOP_ON_ERROR)) === true)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_WRITE_OPEN_FAIL,false),concat2(concat2(concat1("Newer version of '",$p_entry[0]['filename']),"' exists "),"and option PCLZIP_OPT_REPLACE_NEWER is not selected"));
return PclZip::errorCode();
}}}}else 
{{}}}}}else 
{{if ( (((deAspis($p_entry[0]['external']) & (0x00000010)) == (0x00000010)) || (deAspis(Aspis_substr($p_entry[0]['filename'],negate(array(1,false)))) == ('/'))))
 $v_dir_to_check = $p_entry[0]['filename'];
else 
{if ( (denot_boolean(Aspis_strstr($p_entry[0]['filename'],array("/",false)))))
 $v_dir_to_check = array("",false);
else 
{$v_dir_to_check = Aspis_dirname($p_entry[0]['filename']);
}}if ( (deAspis(($v_result = $this->privDirCheck($v_dir_to_check,(array((deAspis($p_entry[0]['external']) & (0x00000010)) == (0x00000010),false))))) != (1)))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("path_creation_fail",false)));
$v_result = array(1,false);
}}}}if ( (deAspis($p_entry[0]['status']) == ('ok')))
 {if ( (!((deAspis($p_entry[0]['external']) & (0x00000010)) == (0x00000010))))
 {if ( (deAspis($p_entry[0]['compression']) == (0)))
 {if ( (deAspis(($v_dest_file = @attAspis(fopen(deAspis($p_entry[0]['filename']),('wb'))))) == (0)))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("write_error",false)));
return $v_result;
}$v_size = $p_entry[0]['compressed_size'];
while ( ($v_size[0] != (0)) )
{$v_read_size = (($v_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $v_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = @attAspis(fread($this->zip_fd[0],$v_read_size[0]));
@attAspis(fwrite($v_dest_file[0],$v_buffer[0],$v_read_size[0]));
$v_size = array($v_size[0] - $v_read_size[0],false);
}fclose($v_dest_file[0]);
touch(deAspis($p_entry[0]['filename']),deAspis($p_entry[0]['mtime']));
}else 
{{if ( ((deAspis($p_entry[0]['flag']) & (1)) == (1)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_UNSUPPORTED_ENCRYPTION,false),concat2(concat1('File \'',$p_entry[0]['filename']),'\' is encrypted. Encrypted files are not supported.'));
return PclZip::errorCode();
}if ( ((!((isset($p_options[0][PCLZIP_OPT_TEMP_FILE_OFF]) && Aspis_isset( $p_options [0][PCLZIP_OPT_TEMP_FILE_OFF])))) && (((isset($p_options[0][PCLZIP_OPT_TEMP_FILE_ON]) && Aspis_isset( $p_options [0][PCLZIP_OPT_TEMP_FILE_ON]))) || (((isset($p_options[0][PCLZIP_OPT_TEMP_FILE_THRESHOLD]) && Aspis_isset( $p_options [0][PCLZIP_OPT_TEMP_FILE_THRESHOLD]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_TEMP_FILE_THRESHOLD)) <= deAspis($p_entry[0]['size']))))))
 {$v_result = $this->privExtractFileUsingTempFile($p_entry,$p_options);
if ( ($v_result[0] < PCLZIP_ERR_NO_ERROR))
 {return $v_result;
}}else 
{{$v_buffer = @attAspis(fread($this->zip_fd[0],deAspis($p_entry[0]['compressed_size'])));
$v_file_content = @array(gzinflate(deAspisRC($v_buffer)),false);
unset($v_buffer);
if ( ($v_file_content[0] === FALSE))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("error",false)));
return $v_result;
}if ( (deAspis(($v_dest_file = @attAspis(fopen(deAspis($p_entry[0]['filename']),('wb'))))) == (0)))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("write_error",false)));
return $v_result;
}@attAspis(fwrite($v_dest_file[0],$v_file_content[0],deAspis($p_entry[0]['size'])));
unset($v_file_content);
@attAspis(fclose($v_dest_file[0]));
}}@attAspis(touch(deAspis($p_entry[0]['filename']),deAspis($p_entry[0]['mtime'])));
}}if ( ((isset($p_options[0][PCLZIP_OPT_SET_CHMOD]) && Aspis_isset( $p_options [0][PCLZIP_OPT_SET_CHMOD]))))
 {@attAspis(chmod(deAspis($p_entry[0]['filename']),deAspis(attachAspis($p_options,PCLZIP_OPT_SET_CHMOD))));
}}}if ( (deAspis($p_entry[0]['status']) == ("aborted")))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("skipped",false)));
}elseif ( ((isset($p_options[0][PCLZIP_CB_POST_EXTRACT]) && Aspis_isset( $p_options [0][PCLZIP_CB_POST_EXTRACT]))))
 {$v_local_header = array(array(),false);
$this->privConvertHeader2FileInfo($p_entry,$v_local_header);
$v_result = AspisDynamicCall(attachAspis($p_options,PCLZIP_CB_POST_EXTRACT),array(PCLZIP_CB_POST_EXTRACT,false),$v_local_header);
if ( ($v_result[0] == (2)))
 {$v_result = array(PCLZIP_ERR_USER_ABORTED,false);
}}return $v_result;
} }
function privExtractFileUsingTempFile ( &$p_entry,&$p_options ) {
{$v_result = array(1,false);
$v_gzip_temp_name = concat2(concat1(PCLZIP_TEMPORARY_DIR,attAspis(uniqid('pclzip-'))),'.gz');
if ( (deAspis(($v_dest_file = @attAspis(fopen($v_gzip_temp_name[0],("wb"))))) == (0)))
 {fclose($v_file[0]);
PclZip::privErrorLog(array(PCLZIP_ERR_WRITE_OPEN_FAIL,false),concat2(concat1('Unable to open temporary file \'',$v_gzip_temp_name),'\' in binary write mode'));
return PclZip::errorCode();
}$v_binary_data = attAspis(pack(('va1a1Va1a1'),0x8b1f,deAspisRC(Chr($p_entry[0]['compression'])),deAspisRC(Chr(array(0x00,false))),deAspisRC(attAspis(time())),deAspisRC(Chr(array(0x00,false))),deAspisRC(Chr(array(3,false)))));
@attAspis(fwrite($v_dest_file[0],$v_binary_data[0],(10)));
$v_size = $p_entry[0]['compressed_size'];
while ( ($v_size[0] != (0)) )
{$v_read_size = (($v_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $v_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = @attAspis(fread($this->zip_fd[0],$v_read_size[0]));
@attAspis(fwrite($v_dest_file[0],$v_buffer[0],$v_read_size[0]));
$v_size = array($v_size[0] - $v_read_size[0],false);
}$v_binary_data = attAspis(pack(('VV'),deAspisRC($p_entry[0]['crc']),deAspisRC($p_entry[0]['size'])));
@attAspis(fwrite($v_dest_file[0],$v_binary_data[0],(8)));
@attAspis(fclose($v_dest_file[0]));
if ( (deAspis(($v_dest_file = @attAspis(fopen(deAspis($p_entry[0]['filename']),('wb'))))) == (0)))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("write_error",false)));
return $v_result;
}if ( (deAspis(($v_src_file = @array(gzopen(deAspisRC($v_gzip_temp_name),'rb'),false))) == (0)))
 {@attAspis(fclose($v_dest_file[0]));
arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("read_error",false)));
PclZip::privErrorLog(array(PCLZIP_ERR_READ_OPEN_FAIL,false),concat2(concat1('Unable to open temporary file \'',$v_gzip_temp_name),'\' in binary read mode'));
return PclZip::errorCode();
}$v_size = $p_entry[0]['size'];
while ( ($v_size[0] != (0)) )
{$v_read_size = (($v_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $v_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = @array(gzread(deAspisRC($v_src_file),deAspisRC($v_read_size)),false);
@attAspis(fwrite($v_dest_file[0],$v_buffer[0],$v_read_size[0]));
$v_size = array($v_size[0] - $v_read_size[0],false);
}@attAspis(fclose($v_dest_file[0]));
@array(gzclose(deAspisRC($v_src_file)),false);
@attAspis(unlink($v_gzip_temp_name[0]));
return $v_result;
} }
function privExtractFileInOutput ( &$p_entry,&$p_options ) {
{$v_result = array(1,false);
if ( (deAspis(($v_result = $this->privReadFileHeader($v_header))) != (1)))
 {return $v_result;
}if ( (deAspis($this->privCheckFileHeaders($v_header,$p_entry)) != (1)))
 {}if ( ((isset($p_options[0][PCLZIP_CB_PRE_EXTRACT]) && Aspis_isset( $p_options [0][PCLZIP_CB_PRE_EXTRACT]))))
 {$v_local_header = array(array(),false);
$this->privConvertHeader2FileInfo($p_entry,$v_local_header);
$v_result = AspisDynamicCall(attachAspis($p_options,PCLZIP_CB_PRE_EXTRACT),array(PCLZIP_CB_PRE_EXTRACT,false),$v_local_header);
if ( ($v_result[0] == (0)))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("skipped",false)));
$v_result = array(1,false);
}if ( ($v_result[0] == (2)))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("aborted",false)));
$v_result = array(PCLZIP_ERR_USER_ABORTED,false);
}arrayAssign($p_entry[0],deAspis(registerTaint(array('filename',false))),addTaint($v_local_header[0]['filename']));
}if ( (deAspis($p_entry[0]['status']) == ('ok')))
 {if ( (!((deAspis($p_entry[0]['external']) & (0x00000010)) == (0x00000010))))
 {if ( (deAspis($p_entry[0]['compressed_size']) == deAspis($p_entry[0]['size'])))
 {$v_buffer = @attAspis(fread($this->zip_fd[0],deAspis($p_entry[0]['compressed_size'])));
echo AspisCheckPrint($v_buffer);
unset($v_buffer);
}else 
{{$v_buffer = @attAspis(fread($this->zip_fd[0],deAspis($p_entry[0]['compressed_size'])));
$v_file_content = array(gzinflate(deAspisRC($v_buffer)),false);
unset($v_buffer);
echo AspisCheckPrint($v_file_content);
unset($v_file_content);
}}}}if ( (deAspis($p_entry[0]['status']) == ("aborted")))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("skipped",false)));
}elseif ( ((isset($p_options[0][PCLZIP_CB_POST_EXTRACT]) && Aspis_isset( $p_options [0][PCLZIP_CB_POST_EXTRACT]))))
 {$v_local_header = array(array(),false);
$this->privConvertHeader2FileInfo($p_entry,$v_local_header);
$v_result = AspisDynamicCall(attachAspis($p_options,PCLZIP_CB_POST_EXTRACT),array(PCLZIP_CB_POST_EXTRACT,false),$v_local_header);
if ( ($v_result[0] == (2)))
 {$v_result = array(PCLZIP_ERR_USER_ABORTED,false);
}}return $v_result;
} }
function privExtractFileAsString ( &$p_entry,&$p_string,&$p_options ) {
{$v_result = array(1,false);
$v_header = array(array(),false);
if ( (deAspis(($v_result = $this->privReadFileHeader($v_header))) != (1)))
 {return $v_result;
}if ( (deAspis($this->privCheckFileHeaders($v_header,$p_entry)) != (1)))
 {}if ( ((isset($p_options[0][PCLZIP_CB_PRE_EXTRACT]) && Aspis_isset( $p_options [0][PCLZIP_CB_PRE_EXTRACT]))))
 {$v_local_header = array(array(),false);
$this->privConvertHeader2FileInfo($p_entry,$v_local_header);
$v_result = AspisDynamicCall(attachAspis($p_options,PCLZIP_CB_PRE_EXTRACT),array(PCLZIP_CB_PRE_EXTRACT,false),$v_local_header);
if ( ($v_result[0] == (0)))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("skipped",false)));
$v_result = array(1,false);
}if ( ($v_result[0] == (2)))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("aborted",false)));
$v_result = array(PCLZIP_ERR_USER_ABORTED,false);
}arrayAssign($p_entry[0],deAspis(registerTaint(array('filename',false))),addTaint($v_local_header[0]['filename']));
}if ( (deAspis($p_entry[0]['status']) == ('ok')))
 {if ( (!((deAspis($p_entry[0]['external']) & (0x00000010)) == (0x00000010))))
 {if ( (deAspis($p_entry[0]['compression']) == (0)))
 {$p_string = @attAspis(fread($this->zip_fd[0],deAspis($p_entry[0]['compressed_size'])));
}else 
{{$v_data = @attAspis(fread($this->zip_fd[0],deAspis($p_entry[0]['compressed_size'])));
if ( (deAspis(($p_string = @array(gzinflate(deAspisRC($v_data)),false))) === FALSE))
 {}}}}else 
{{}}}if ( (deAspis($p_entry[0]['status']) == ("aborted")))
 {arrayAssign($p_entry[0],deAspis(registerTaint(array('status',false))),addTaint(array("skipped",false)));
}elseif ( ((isset($p_options[0][PCLZIP_CB_POST_EXTRACT]) && Aspis_isset( $p_options [0][PCLZIP_CB_POST_EXTRACT]))))
 {$v_local_header = array(array(),false);
$this->privConvertHeader2FileInfo($p_entry,$v_local_header);
arrayAssign($v_local_header[0],deAspis(registerTaint(array('content',false))),addTaint($p_string));
$p_string = array('',false);
$v_result = AspisDynamicCall(attachAspis($p_options,PCLZIP_CB_POST_EXTRACT),array(PCLZIP_CB_POST_EXTRACT,false),$v_local_header);
$p_string = $v_local_header[0]['content'];
unset($v_local_header[0][('content')]);
if ( ($v_result[0] == (2)))
 {$v_result = array(PCLZIP_ERR_USER_ABORTED,false);
}}return $v_result;
} }
function privReadFileHeader ( &$p_header ) {
{$v_result = array(1,false);
$v_binary_data = @attAspis(fread($this->zip_fd[0],(4)));
$v_data = attAspisRC(unpack(('Vid'),$v_binary_data[0]));
if ( (deAspis($v_data[0]['id']) != (0x04034b50)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_BAD_FORMAT,false),array('Invalid archive structure',false));
return PclZip::errorCode();
}$v_binary_data = attAspis(fread($this->zip_fd[0],(26)));
if ( (strlen($v_binary_data[0]) != (26)))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('filename',false))),addTaint(array("",false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('status',false))),addTaint(array("invalid_header",false)));
PclZip::privErrorLog(array(PCLZIP_ERR_BAD_FORMAT,false),concat1("Invalid block size : ",attAspis(strlen($v_binary_data[0]))));
return PclZip::errorCode();
}$v_data = attAspisRC(unpack(('vversion/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len'),$v_binary_data[0]));
arrayAssign($p_header[0],deAspis(registerTaint(array('filename',false))),addTaint(attAspis(fread($this->zip_fd[0],deAspis($v_data[0]['filename_len'])))));
if ( (deAspis($v_data[0]['extra_len']) != (0)))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('extra',false))),addTaint(attAspis(fread($this->zip_fd[0],deAspis($v_data[0]['extra_len'])))));
}else 
{{arrayAssign($p_header[0],deAspis(registerTaint(array('extra',false))),addTaint(array('',false)));
}}arrayAssign($p_header[0],deAspis(registerTaint(array('version_extracted',false))),addTaint($v_data[0]['version']));
arrayAssign($p_header[0],deAspis(registerTaint(array('compression',false))),addTaint($v_data[0]['compression']));
arrayAssign($p_header[0],deAspis(registerTaint(array('size',false))),addTaint($v_data[0]['size']));
arrayAssign($p_header[0],deAspis(registerTaint(array('compressed_size',false))),addTaint($v_data[0]['compressed_size']));
arrayAssign($p_header[0],deAspis(registerTaint(array('crc',false))),addTaint($v_data[0]['crc']));
arrayAssign($p_header[0],deAspis(registerTaint(array('flag',false))),addTaint($v_data[0]['flag']));
arrayAssign($p_header[0],deAspis(registerTaint(array('filename_len',false))),addTaint($v_data[0]['filename_len']));
arrayAssign($p_header[0],deAspis(registerTaint(array('mdate',false))),addTaint($v_data[0]['mdate']));
arrayAssign($p_header[0],deAspis(registerTaint(array('mtime',false))),addTaint($v_data[0]['mtime']));
if ( (deAspis($p_header[0]['mdate']) && deAspis($p_header[0]['mtime'])))
 {$v_hour = array((deAspis($p_header[0]['mtime']) & (0xF800)) >> (11),false);
$v_minute = array((deAspis($p_header[0]['mtime']) & (0x07E0)) >> (5),false);
$v_seconde = array((deAspis($p_header[0]['mtime']) & (0x001F)) * (2),false);
$v_year = array(((deAspis($p_header[0]['mdate']) & (0xFE00)) >> (9)) + (1980),false);
$v_month = array((deAspis($p_header[0]['mdate']) & (0x01E0)) >> (5),false);
$v_day = array(deAspis($p_header[0]['mdate']) & (0x001F),false);
arrayAssign($p_header[0],deAspis(registerTaint(array('mtime',false))),addTaint(@attAspis(mktime($v_hour[0],$v_minute[0],$v_seconde[0],$v_month[0],$v_day[0],$v_year[0]))));
}else 
{{arrayAssign($p_header[0],deAspis(registerTaint(array('mtime',false))),addTaint(attAspis(time())));
}}arrayAssign($p_header[0],deAspis(registerTaint(array('stored_filename',false))),addTaint($p_header[0]['filename']));
arrayAssign($p_header[0],deAspis(registerTaint(array('status',false))),addTaint(array("ok",false)));
return $v_result;
} }
function privReadCentralFileHeader ( &$p_header ) {
{$v_result = array(1,false);
$v_binary_data = @attAspis(fread($this->zip_fd[0],(4)));
$v_data = attAspisRC(unpack(('Vid'),$v_binary_data[0]));
if ( (deAspis($v_data[0]['id']) != (0x02014b50)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_BAD_FORMAT,false),array('Invalid archive structure',false));
return PclZip::errorCode();
}$v_binary_data = attAspis(fread($this->zip_fd[0],(42)));
if ( (strlen($v_binary_data[0]) != (42)))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('filename',false))),addTaint(array("",false)));
arrayAssign($p_header[0],deAspis(registerTaint(array('status',false))),addTaint(array("invalid_header",false)));
PclZip::privErrorLog(array(PCLZIP_ERR_BAD_FORMAT,false),concat1("Invalid block size : ",attAspis(strlen($v_binary_data[0]))));
return PclZip::errorCode();
}$p_header = attAspisRC(unpack(('vversion/vversion_extracted/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len/vcomment_len/vdisk/vinternal/Vexternal/Voffset'),$v_binary_data[0]));
if ( (deAspis($p_header[0]['filename_len']) != (0)))
 arrayAssign($p_header[0],deAspis(registerTaint(array('filename',false))),addTaint(attAspis(fread($this->zip_fd[0],deAspis($p_header[0]['filename_len'])))));
else 
{arrayAssign($p_header[0],deAspis(registerTaint(array('filename',false))),addTaint(array('',false)));
}if ( (deAspis($p_header[0]['extra_len']) != (0)))
 arrayAssign($p_header[0],deAspis(registerTaint(array('extra',false))),addTaint(attAspis(fread($this->zip_fd[0],deAspis($p_header[0]['extra_len'])))));
else 
{arrayAssign($p_header[0],deAspis(registerTaint(array('extra',false))),addTaint(array('',false)));
}if ( (deAspis($p_header[0]['comment_len']) != (0)))
 arrayAssign($p_header[0],deAspis(registerTaint(array('comment',false))),addTaint(attAspis(fread($this->zip_fd[0],deAspis($p_header[0]['comment_len'])))));
else 
{arrayAssign($p_header[0],deAspis(registerTaint(array('comment',false))),addTaint(array('',false)));
}if ( (1))
 {$v_hour = array((deAspis($p_header[0]['mtime']) & (0xF800)) >> (11),false);
$v_minute = array((deAspis($p_header[0]['mtime']) & (0x07E0)) >> (5),false);
$v_seconde = array((deAspis($p_header[0]['mtime']) & (0x001F)) * (2),false);
$v_year = array(((deAspis($p_header[0]['mdate']) & (0xFE00)) >> (9)) + (1980),false);
$v_month = array((deAspis($p_header[0]['mdate']) & (0x01E0)) >> (5),false);
$v_day = array(deAspis($p_header[0]['mdate']) & (0x001F),false);
arrayAssign($p_header[0],deAspis(registerTaint(array('mtime',false))),addTaint(@attAspis(mktime($v_hour[0],$v_minute[0],$v_seconde[0],$v_month[0],$v_day[0],$v_year[0]))));
}else 
{{arrayAssign($p_header[0],deAspis(registerTaint(array('mtime',false))),addTaint(attAspis(time())));
}}arrayAssign($p_header[0],deAspis(registerTaint(array('stored_filename',false))),addTaint($p_header[0]['filename']));
arrayAssign($p_header[0],deAspis(registerTaint(array('status',false))),addTaint(array('ok',false)));
if ( (deAspis(Aspis_substr($p_header[0]['filename'],negate(array(1,false)))) == ('/')))
 {arrayAssign($p_header[0],deAspis(registerTaint(array('external',false))),addTaint(array(0x00000010,false)));
}return $v_result;
} }
function privCheckFileHeaders ( &$p_local_header,&$p_central_header ) {
{$v_result = array(1,false);
if ( (deAspis($p_local_header[0]['filename']) != deAspis($p_central_header[0]['filename'])))
 {}if ( (deAspis($p_local_header[0]['version_extracted']) != deAspis($p_central_header[0]['version_extracted'])))
 {}if ( (deAspis($p_local_header[0]['flag']) != deAspis($p_central_header[0]['flag'])))
 {}if ( (deAspis($p_local_header[0]['compression']) != deAspis($p_central_header[0]['compression'])))
 {}if ( (deAspis($p_local_header[0]['mtime']) != deAspis($p_central_header[0]['mtime'])))
 {}if ( (deAspis($p_local_header[0]['filename_len']) != deAspis($p_central_header[0]['filename_len'])))
 {}if ( ((deAspis($p_local_header[0]['flag']) & (8)) == (8)))
 {arrayAssign($p_local_header[0],deAspis(registerTaint(array('size',false))),addTaint($p_central_header[0]['size']));
arrayAssign($p_local_header[0],deAspis(registerTaint(array('compressed_size',false))),addTaint($p_central_header[0]['compressed_size']));
arrayAssign($p_local_header[0],deAspis(registerTaint(array('crc',false))),addTaint($p_central_header[0]['crc']));
}return $v_result;
} }
function privReadEndCentralDir ( &$p_central_dir ) {
{$v_result = array(1,false);
$v_size = attAspis(filesize($this->zipname[0]));
@attAspis(fseek($this->zip_fd[0],$v_size[0]));
if ( (deAspis(@attAspis(ftell($this->zip_fd[0]))) != $v_size[0]))
 {PclZip::privErrorLog(array(PCLZIP_ERR_BAD_FORMAT,false),concat2(concat1('Unable to go to the end of the archive \'',$this->zipname),'\''));
return PclZip::errorCode();
}$v_found = array(0,false);
if ( ($v_size[0] > (26)))
 {@attAspis(fseek($this->zip_fd[0],($v_size[0] - (22))));
if ( (deAspis(($v_pos = @attAspis(ftell($this->zip_fd[0])))) != ($v_size[0] - (22))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_BAD_FORMAT,false),concat2(concat1('Unable to seek back to the middle of the archive \'',$this->zipname),'\''));
return PclZip::errorCode();
}$v_binary_data = @attAspis(fread($this->zip_fd[0],(4)));
$v_data = @attAspisRC(unpack(('Vid'),$v_binary_data[0]));
if ( (deAspis($v_data[0]['id']) == (0x06054b50)))
 {$v_found = array(1,false);
}$v_pos = attAspis(ftell($this->zip_fd[0]));
}if ( (denot_boolean($v_found)))
 {$v_maximum_size = array(65557,false);
if ( ($v_maximum_size[0] > $v_size[0]))
 $v_maximum_size = $v_size;
@attAspis(fseek($this->zip_fd[0],($v_size[0] - $v_maximum_size[0])));
if ( (deAspis(@attAspis(ftell($this->zip_fd[0]))) != ($v_size[0] - $v_maximum_size[0])))
 {PclZip::privErrorLog(array(PCLZIP_ERR_BAD_FORMAT,false),concat2(concat1('Unable to seek back to the middle of the archive \'',$this->zipname),'\''));
return PclZip::errorCode();
}$v_pos = attAspis(ftell($this->zip_fd[0]));
$v_bytes = array(0x00000000,false);
while ( ($v_pos[0] < $v_size[0]) )
{$v_byte = @attAspis(fread($this->zip_fd[0],(1)));
$v_bytes = array((($v_bytes[0] & (0xFFFFFF)) << (8)) | deAspis(Ord($v_byte)),false);
if ( ($v_bytes[0] == (0x504b0506)))
 {postincr($v_pos);
break ;
}postincr($v_pos);
}if ( ($v_pos[0] == $v_size[0]))
 {PclZip::privErrorLog(array(PCLZIP_ERR_BAD_FORMAT,false),array("Unable to find End of Central Dir Record signature",false));
return PclZip::errorCode();
}}$v_binary_data = attAspis(fread($this->zip_fd[0],(18)));
if ( (strlen($v_binary_data[0]) != (18)))
 {PclZip::privErrorLog(array(PCLZIP_ERR_BAD_FORMAT,false),concat1("Invalid End of Central Dir Record size : ",attAspis(strlen($v_binary_data[0]))));
return PclZip::errorCode();
}$v_data = attAspisRC(unpack(('vdisk/vdisk_start/vdisk_entries/ventries/Vsize/Voffset/vcomment_size'),$v_binary_data[0]));
if ( ((($v_pos[0] + deAspis($v_data[0]['comment_size'])) + (18)) != $v_size[0]))
 {if ( (0))
 {PclZip::privErrorLog(array(PCLZIP_ERR_BAD_FORMAT,false),concat12('The central dir is not at the end of the archive.',' Some trailing bytes exists after the archive.'));
return PclZip::errorCode();
}}if ( (deAspis($v_data[0]['comment_size']) != (0)))
 {arrayAssign($p_central_dir[0],deAspis(registerTaint(array('comment',false))),addTaint(attAspis(fread($this->zip_fd[0],deAspis($v_data[0]['comment_size'])))));
}else 
{arrayAssign($p_central_dir[0],deAspis(registerTaint(array('comment',false))),addTaint(array('',false)));
}arrayAssign($p_central_dir[0],deAspis(registerTaint(array('entries',false))),addTaint($v_data[0]['entries']));
arrayAssign($p_central_dir[0],deAspis(registerTaint(array('disk_entries',false))),addTaint($v_data[0]['disk_entries']));
arrayAssign($p_central_dir[0],deAspis(registerTaint(array('offset',false))),addTaint($v_data[0]['offset']));
arrayAssign($p_central_dir[0],deAspis(registerTaint(array('size',false))),addTaint($v_data[0]['size']));
arrayAssign($p_central_dir[0],deAspis(registerTaint(array('disk',false))),addTaint($v_data[0]['disk']));
arrayAssign($p_central_dir[0],deAspis(registerTaint(array('disk_start',false))),addTaint($v_data[0]['disk_start']));
return $v_result;
} }
function privDeleteByRule ( &$p_result_list,&$p_options ) {
{$v_result = array(1,false);
$v_list_detail = array(array(),false);
if ( (deAspis(($v_result = $this->privOpenFd(array('rb',false)))) != (1)))
 {return $v_result;
}$v_central_dir = array(array(),false);
if ( (deAspis(($v_result = $this->privReadEndCentralDir($v_central_dir))) != (1)))
 {$this->privCloseFd();
return $v_result;
}@attAspis(rewind($this->zip_fd[0]));
$v_pos_entry = $v_central_dir[0]['offset'];
@attAspis(rewind($this->zip_fd[0]));
if ( deAspis(@attAspis(fseek($this->zip_fd[0],$v_pos_entry[0]))))
 {$this->privCloseFd();
PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_ARCHIVE_ZIP,false),array('Invalid archive size',false));
return PclZip::errorCode();
}$v_header_list = array(array(),false);
$j_start = array(0,false);
for ( $i = array(0,false),$v_nb_extracted = array(0,false) ; ($i[0] < deAspis($v_central_dir[0]['entries'])) ; postincr($i) )
{arrayAssign($v_header_list[0],deAspis(registerTaint($v_nb_extracted)),addTaint(array(array(),false)));
if ( (deAspis(($v_result = $this->privReadCentralFileHeader(attachAspis($v_header_list,$v_nb_extracted[0])))) != (1)))
 {$this->privCloseFd();
return $v_result;
}arrayAssign($v_header_list[0][$v_nb_extracted[0]][0],deAspis(registerTaint(array('index',false))),addTaint($i));
$v_found = array(false,false);
if ( (((isset($p_options[0][PCLZIP_OPT_BY_NAME]) && Aspis_isset( $p_options [0][PCLZIP_OPT_BY_NAME]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_BY_NAME)) != (0))))
 {for ( $j = array(0,false) ; (($j[0] < (sizeof(deAspisRC(attachAspis($p_options,PCLZIP_OPT_BY_NAME))))) && (denot_boolean($v_found))) ; postincr($j) )
{if ( (deAspis(Aspis_substr(attachAspis($p_options[0][PCLZIP_OPT_BY_NAME],$j[0]),negate(array(1,false)))) == ("/")))
 {if ( ((strlen(deAspis($v_header_list[0][$v_nb_extracted[0]][0]['stored_filename'])) > strlen(deAspis(attachAspis($p_options[0][PCLZIP_OPT_BY_NAME],$j[0])))) && (deAspis(Aspis_substr($v_header_list[0][$v_nb_extracted[0]][0]['stored_filename'],array(0,false),attAspis(strlen(deAspis(attachAspis($p_options[0][PCLZIP_OPT_BY_NAME],$j[0])))))) == deAspis(attachAspis($p_options[0][PCLZIP_OPT_BY_NAME],$j[0])))))
 {$v_found = array(true,false);
}elseif ( (((deAspis($v_header_list[0][$v_nb_extracted[0]][0]['external']) & (0x00000010)) == (0x00000010)) && ((deconcat2($v_header_list[0][$v_nb_extracted[0]][0]['stored_filename'],'/')) == deAspis(attachAspis($p_options[0][PCLZIP_OPT_BY_NAME],$j[0])))))
 {$v_found = array(true,false);
}}elseif ( (deAspis($v_header_list[0][$v_nb_extracted[0]][0]['stored_filename']) == deAspis(attachAspis($p_options[0][PCLZIP_OPT_BY_NAME],$j[0]))))
 {$v_found = array(true,false);
}}}else 
{if ( (((isset($p_options[0][PCLZIP_OPT_BY_PREG]) && Aspis_isset( $p_options [0][PCLZIP_OPT_BY_PREG]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_BY_PREG)) != (""))))
 {if ( deAspis(Aspis_preg_match(attachAspis($p_options,PCLZIP_OPT_BY_PREG),$v_header_list[0][$v_nb_extracted[0]][0]['stored_filename'])))
 {$v_found = array(true,false);
}}else 
{if ( (((isset($p_options[0][PCLZIP_OPT_BY_INDEX]) && Aspis_isset( $p_options [0][PCLZIP_OPT_BY_INDEX]))) && (deAspis(attachAspis($p_options,PCLZIP_OPT_BY_INDEX)) != (0))))
 {for ( $j = $j_start ; (($j[0] < (sizeof(deAspisRC(attachAspis($p_options,PCLZIP_OPT_BY_INDEX))))) && (denot_boolean($v_found))) ; postincr($j) )
{if ( (($i[0] >= deAspis($p_options[0][PCLZIP_OPT_BY_INDEX][0][$j[0]][0]['start'])) && ($i[0] <= deAspis($p_options[0][PCLZIP_OPT_BY_INDEX][0][$j[0]][0]['end']))))
 {$v_found = array(true,false);
}if ( ($i[0] >= deAspis($p_options[0][PCLZIP_OPT_BY_INDEX][0][$j[0]][0]['end'])))
 {$j_start = array($j[0] + (1),false);
}if ( (deAspis($p_options[0][PCLZIP_OPT_BY_INDEX][0][$j[0]][0]['start']) > $i[0]))
 {break ;
}}}else 
{{$v_found = array(true,false);
}}}}if ( $v_found[0])
 {unset($v_header_list[0][$v_nb_extracted[0]]);
}else 
{{postincr($v_nb_extracted);
}}}if ( ($v_nb_extracted[0] > (0)))
 {$v_zip_temp_name = concat2(concat1(PCLZIP_TEMPORARY_DIR,attAspis(uniqid('pclzip-'))),'.tmp');
$v_temp_zip = array(new PclZip($v_zip_temp_name),false);
if ( (deAspis(($v_result = $v_temp_zip[0]->privOpenFd(array('wb',false)))) != (1)))
 {$this->privCloseFd();
return $v_result;
}for ( $i = array(0,false) ; ($i[0] < (sizeof(deAspisRC($v_header_list)))) ; postincr($i) )
{@attAspis(rewind($this->zip_fd[0]));
if ( deAspis(@attAspis(fseek($this->zip_fd[0],deAspis($v_header_list[0][$i[0]][0]['offset'])))))
 {$this->privCloseFd();
$v_temp_zip[0]->privCloseFd();
@attAspis(unlink($v_zip_temp_name[0]));
PclZip::privErrorLog(array(PCLZIP_ERR_INVALID_ARCHIVE_ZIP,false),array('Invalid archive size',false));
return PclZip::errorCode();
}$v_local_header = array(array(),false);
if ( (deAspis(($v_result = $this->privReadFileHeader($v_local_header))) != (1)))
 {$this->privCloseFd();
$v_temp_zip[0]->privCloseFd();
@attAspis(unlink($v_zip_temp_name[0]));
return $v_result;
}if ( (deAspis($this->privCheckFileHeaders($v_local_header,attachAspis($v_header_list,$i[0]))) != (1)))
 {}unset($v_local_header);
if ( (deAspis(($v_result = $v_temp_zip[0]->privWriteFileHeader(attachAspis($v_header_list,$i[0])))) != (1)))
 {$this->privCloseFd();
$v_temp_zip[0]->privCloseFd();
@attAspis(unlink($v_zip_temp_name[0]));
return $v_result;
}if ( (deAspis(($v_result = PclZipUtilCopyBlock($this->zip_fd,$v_temp_zip[0]->zip_fd,$v_header_list[0][$i[0]][0]['compressed_size']))) != (1)))
 {$this->privCloseFd();
$v_temp_zip[0]->privCloseFd();
@attAspis(unlink($v_zip_temp_name[0]));
return $v_result;
}}$v_offset = @attAspis(ftell($v_temp_zip[0]->zip_fd[0]));
for ( $i = array(0,false) ; ($i[0] < (sizeof(deAspisRC($v_header_list)))) ; postincr($i) )
{if ( (deAspis(($v_result = $v_temp_zip[0]->privWriteCentralFileHeader(attachAspis($v_header_list,$i[0])))) != (1)))
 {$v_temp_zip[0]->privCloseFd();
$this->privCloseFd();
@attAspis(unlink($v_zip_temp_name[0]));
return $v_result;
}$v_temp_zip[0]->privConvertHeader2FileInfo(attachAspis($v_header_list,$i[0]),attachAspis($p_result_list,$i[0]));
}$v_comment = array('',false);
if ( ((isset($p_options[0][PCLZIP_OPT_COMMENT]) && Aspis_isset( $p_options [0][PCLZIP_OPT_COMMENT]))))
 {$v_comment = attachAspis($p_options,PCLZIP_OPT_COMMENT);
}$v_size = array(deAspis(@attAspis(ftell($v_temp_zip[0]->zip_fd[0]))) - $v_offset[0],false);
if ( (deAspis(($v_result = $v_temp_zip[0]->privWriteCentralHeader(array(sizeof(deAspisRC($v_header_list)),false),$v_size,$v_offset,$v_comment))) != (1)))
 {unset($v_header_list);
$v_temp_zip[0]->privCloseFd();
$this->privCloseFd();
@attAspis(unlink($v_zip_temp_name[0]));
return $v_result;
}$v_temp_zip[0]->privCloseFd();
$this->privCloseFd();
@attAspis(unlink($this->zipname[0]));
PclZipUtilRename($v_zip_temp_name,$this->zipname);
unset($v_temp_zip);
}else 
{if ( (deAspis($v_central_dir[0]['entries']) != (0)))
 {$this->privCloseFd();
if ( (deAspis(($v_result = $this->privOpenFd(array('wb',false)))) != (1)))
 {return $v_result;
}if ( (deAspis(($v_result = $this->privWriteCentralHeader(array(0,false),array(0,false),array(0,false),array('',false)))) != (1)))
 {return $v_result;
}$this->privCloseFd();
}}return $v_result;
} }
function privDirCheck ( $p_dir,$p_is_dir = array(false,false) ) {
{$v_result = array(1,false);
if ( (deAspis(($p_is_dir)) && (deAspis(Aspis_substr($p_dir,negate(array(1,false)))) == ('/'))))
 {$p_dir = Aspis_substr($p_dir,array(0,false),array(strlen($p_dir[0]) - (1),false));
}if ( (is_dir($p_dir[0]) || ($p_dir[0] == (""))))
 {return array(1,false);
}$p_parent_dir = Aspis_dirname($p_dir);
if ( ($p_parent_dir[0] != $p_dir[0]))
 {if ( ($p_parent_dir[0] != ("")))
 {if ( (deAspis(($v_result = $this->privDirCheck($p_parent_dir))) != (1)))
 {return $v_result;
}}}if ( (denot_boolean(@attAspis(mkdir($p_dir[0],(0777))))))
 {PclZip::privErrorLog(array(PCLZIP_ERR_DIR_CREATE_FAIL,false),concat2(concat1("Unable to create directory '",$p_dir),"'"));
return PclZip::errorCode();
}return $v_result;
} }
function privMerge ( &$p_archive_to_add ) {
{$v_result = array(1,false);
if ( (!(is_file($p_archive_to_add[0]->zipname[0]))))
 {$v_result = array(1,false);
return $v_result;
}if ( (!(is_file($this->zipname[0]))))
 {$v_result = $this->privDuplicate($p_archive_to_add[0]->zipname);
return $v_result;
}if ( (deAspis(($v_result = $this->privOpenFd(array('rb',false)))) != (1)))
 {return $v_result;
}$v_central_dir = array(array(),false);
if ( (deAspis(($v_result = $this->privReadEndCentralDir($v_central_dir))) != (1)))
 {$this->privCloseFd();
return $v_result;
}@attAspis(rewind($this->zip_fd[0]));
if ( (deAspis(($v_result = $p_archive_to_add[0]->privOpenFd(array('rb',false)))) != (1)))
 {$this->privCloseFd();
return $v_result;
}$v_central_dir_to_add = array(array(),false);
if ( (deAspis(($v_result = $p_archive_to_add[0]->privReadEndCentralDir($v_central_dir_to_add))) != (1)))
 {$this->privCloseFd();
$p_archive_to_add[0]->privCloseFd();
return $v_result;
}@attAspis(rewind($p_archive_to_add[0]->zip_fd[0]));
$v_zip_temp_name = concat2(concat1(PCLZIP_TEMPORARY_DIR,attAspis(uniqid('pclzip-'))),'.tmp');
if ( (deAspis(($v_zip_temp_fd = @attAspis(fopen($v_zip_temp_name[0],('wb'))))) == (0)))
 {$this->privCloseFd();
$p_archive_to_add[0]->privCloseFd();
PclZip::privErrorLog(array(PCLZIP_ERR_READ_OPEN_FAIL,false),concat2(concat1('Unable to open temporary file \'',$v_zip_temp_name),'\' in binary write mode'));
return PclZip::errorCode();
}$v_size = $v_central_dir[0]['offset'];
while ( ($v_size[0] != (0)) )
{$v_read_size = (($v_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $v_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = attAspis(fread($this->zip_fd[0],$v_read_size[0]));
@attAspis(fwrite($v_zip_temp_fd[0],$v_buffer[0],$v_read_size[0]));
$v_size = array($v_size[0] - $v_read_size[0],false);
}$v_size = $v_central_dir_to_add[0]['offset'];
while ( ($v_size[0] != (0)) )
{$v_read_size = (($v_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $v_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = attAspis(fread($p_archive_to_add[0]->zip_fd[0],$v_read_size[0]));
@attAspis(fwrite($v_zip_temp_fd[0],$v_buffer[0],$v_read_size[0]));
$v_size = array($v_size[0] - $v_read_size[0],false);
}$v_offset = @attAspis(ftell($v_zip_temp_fd[0]));
$v_size = $v_central_dir[0]['size'];
while ( ($v_size[0] != (0)) )
{$v_read_size = (($v_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $v_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = @attAspis(fread($this->zip_fd[0],$v_read_size[0]));
@attAspis(fwrite($v_zip_temp_fd[0],$v_buffer[0],$v_read_size[0]));
$v_size = array($v_size[0] - $v_read_size[0],false);
}$v_size = $v_central_dir_to_add[0]['size'];
while ( ($v_size[0] != (0)) )
{$v_read_size = (($v_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $v_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = @attAspis(fread($p_archive_to_add[0]->zip_fd[0],$v_read_size[0]));
@attAspis(fwrite($v_zip_temp_fd[0],$v_buffer[0],$v_read_size[0]));
$v_size = array($v_size[0] - $v_read_size[0],false);
}$v_comment = concat(concat2($v_central_dir[0]['comment'],' '),$v_central_dir_to_add[0]['comment']);
$v_size = array(deAspis(@attAspis(ftell($v_zip_temp_fd[0]))) - $v_offset[0],false);
$v_swap = $this->zip_fd;
$this->zip_fd = $v_zip_temp_fd;
$v_zip_temp_fd = $v_swap;
if ( (deAspis(($v_result = $this->privWriteCentralHeader(array(deAspis($v_central_dir[0]['entries']) + deAspis($v_central_dir_to_add[0]['entries']),false),$v_size,$v_offset,$v_comment))) != (1)))
 {$this->privCloseFd();
$p_archive_to_add[0]->privCloseFd();
@attAspis(fclose($v_zip_temp_fd[0]));
$this->zip_fd = array(null,false);
unset($v_header_list);
return $v_result;
}$v_swap = $this->zip_fd;
$this->zip_fd = $v_zip_temp_fd;
$v_zip_temp_fd = $v_swap;
$this->privCloseFd();
$p_archive_to_add[0]->privCloseFd();
@attAspis(fclose($v_zip_temp_fd[0]));
@attAspis(unlink($this->zipname[0]));
PclZipUtilRename($v_zip_temp_name,$this->zipname);
return $v_result;
} }
function privDuplicate ( $p_archive_filename ) {
{$v_result = array(1,false);
if ( (!(is_file($p_archive_filename[0]))))
 {$v_result = array(1,false);
return $v_result;
}if ( (deAspis(($v_result = $this->privOpenFd(array('wb',false)))) != (1)))
 {return $v_result;
}if ( (deAspis(($v_zip_temp_fd = @attAspis(fopen($p_archive_filename[0],('rb'))))) == (0)))
 {$this->privCloseFd();
PclZip::privErrorLog(array(PCLZIP_ERR_READ_OPEN_FAIL,false),concat2(concat1('Unable to open archive file \'',$p_archive_filename),'\' in binary write mode'));
return PclZip::errorCode();
}$v_size = attAspis(filesize($p_archive_filename[0]));
while ( ($v_size[0] != (0)) )
{$v_read_size = (($v_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $v_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = attAspis(fread($v_zip_temp_fd[0],$v_read_size[0]));
@attAspis(fwrite($this->zip_fd[0],$v_buffer[0],$v_read_size[0]));
$v_size = array($v_size[0] - $v_read_size[0],false);
}$this->privCloseFd();
@attAspis(fclose($v_zip_temp_fd[0]));
return $v_result;
} }
function privErrorLog ( $p_error_code = array(0,false),$p_error_string = array('',false) ) {
{if ( (PCLZIP_ERROR_EXTERNAL == (1)))
 {PclError($p_error_code,$p_error_string);
}else 
{{$this->error_code = $p_error_code;
$this->error_string = $p_error_string;
}}} }
function privErrorReset (  ) {
{if ( (PCLZIP_ERROR_EXTERNAL == (1)))
 {PclErrorReset();
}else 
{{$this->error_code = array(0,false);
$this->error_string = array('',false);
}}} }
function privDisableMagicQuotes (  ) {
{$v_result = array(1,false);
if ( ((!(function_exists(("get_magic_quotes_runtime")))) || (!(function_exists(("set_magic_quotes_runtime"))))))
 {return $v_result;
}if ( ($this->magic_quotes_status[0] != deAspis(negate(array(1,false)))))
 {return $v_result;
}$this->magic_quotes_status = @array(get_magic_quotes_runtime(),false);
if ( ($this->magic_quotes_status[0] == (1)))
 {@array(set_magic_quotes_runtime(0),false);
}return $v_result;
} }
function privSwapBackMagicQuotes (  ) {
{$v_result = array(1,false);
if ( ((!(function_exists(("get_magic_quotes_runtime")))) || (!(function_exists(("set_magic_quotes_runtime"))))))
 {return $v_result;
}if ( ($this->magic_quotes_status[0] != deAspis(negate(array(1,false)))))
 {return $v_result;
}if ( ($this->magic_quotes_status[0] == (1)))
 {@array(set_magic_quotes_runtime(deAspisRC($this->magic_quotes_status)),false);
}return $v_result;
} }
}function PclZipUtilPathReduction ( $p_dir ) {
$v_result = array("",false);
if ( ($p_dir[0] != ("")))
 {$v_list = Aspis_explode(array("/",false),$p_dir);
$v_skip = array(0,false);
for ( $i = array((sizeof(deAspisRC($v_list))) - (1),false) ; ($i[0] >= (0)) ; postdecr($i) )
{if ( (deAspis(attachAspis($v_list,$i[0])) == (".")))
 {}else 
{if ( (deAspis(attachAspis($v_list,$i[0])) == ("..")))
 {postincr($v_skip);
}else 
{if ( (deAspis(attachAspis($v_list,$i[0])) == ("")))
 {if ( ($i[0] == (0)))
 {$v_result = concat1("/",$v_result);
if ( ($v_skip[0] > (0)))
 {$v_result = $p_dir;
$v_skip = array(0,false);
}}else 
{if ( ($i[0] == ((sizeof(deAspisRC($v_list))) - (1))))
 {$v_result = attachAspis($v_list,$i[0]);
}else 
{{}}}}else 
{{if ( ($v_skip[0] > (0)))
 {postdecr($v_skip);
}else 
{{$v_result = concat(attachAspis($v_list,$i[0]),(($i[0] != ((sizeof(deAspisRC($v_list))) - (1))) ? concat1("/",$v_result) : array("",false)));
}}}}}}}if ( ($v_skip[0] > (0)))
 {while ( ($v_skip[0] > (0)) )
{$v_result = concat1('../',$v_result);
postdecr($v_skip);
}}}return $v_result;
 }
function PclZipUtilPathInclusion ( $p_dir,$p_path ) {
$v_result = array(1,false);
if ( (($p_dir[0] == ('.')) || ((strlen($p_dir[0]) >= (2)) && (deAspis(Aspis_substr($p_dir,array(0,false),array(2,false))) == ('./')))))
 {$p_dir = concat(concat2(PclZipUtilTranslateWinPath(attAspis(getcwd()),array(FALSE,false)),'/'),Aspis_substr($p_dir,array(1,false)));
}if ( (($p_path[0] == ('.')) || ((strlen($p_path[0]) >= (2)) && (deAspis(Aspis_substr($p_path,array(0,false),array(2,false))) == ('./')))))
 {$p_path = concat(concat2(PclZipUtilTranslateWinPath(attAspis(getcwd()),array(FALSE,false)),'/'),Aspis_substr($p_path,array(1,false)));
}$v_list_dir = Aspis_explode(array("/",false),$p_dir);
$v_list_dir_size = array(sizeof(deAspisRC($v_list_dir)),false);
$v_list_path = Aspis_explode(array("/",false),$p_path);
$v_list_path_size = array(sizeof(deAspisRC($v_list_path)),false);
$i = array(0,false);
$j = array(0,false);
while ( ((($i[0] < $v_list_dir_size[0]) && ($j[0] < $v_list_path_size[0])) && deAspis(($v_result))) )
{if ( (deAspis(attachAspis($v_list_dir,$i[0])) == ('')))
 {postincr($i);
continue ;
}if ( (deAspis(attachAspis($v_list_path,$j[0])) == ('')))
 {postincr($j);
continue ;
}if ( (((deAspis(attachAspis($v_list_dir,$i[0])) != deAspis(attachAspis($v_list_path,$j[0]))) && (deAspis(attachAspis($v_list_dir,$i[0])) != (''))) && (deAspis(attachAspis($v_list_path,$j[0])) != (''))))
 {$v_result = array(0,false);
}postincr($i);
postincr($j);
}if ( $v_result[0])
 {while ( (($j[0] < $v_list_path_size[0]) && (deAspis(attachAspis($v_list_path,$j[0])) == (''))) )
postincr($j);
while ( (($i[0] < $v_list_dir_size[0]) && (deAspis(attachAspis($v_list_dir,$i[0])) == (''))) )
postincr($i);
if ( (($i[0] >= $v_list_dir_size[0]) && ($j[0] >= $v_list_path_size[0])))
 {$v_result = array(2,false);
}else 
{if ( ($i[0] < $v_list_dir_size[0]))
 {$v_result = array(0,false);
}}}return $v_result;
 }
function PclZipUtilCopyBlock ( $p_src,$p_dest,$p_size,$p_mode = array(0,false) ) {
$v_result = array(1,false);
if ( ($p_mode[0] == (0)))
 {while ( ($p_size[0] != (0)) )
{$v_read_size = (($p_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $p_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = @attAspis(fread($p_src[0],$v_read_size[0]));
@attAspis(fwrite($p_dest[0],$v_buffer[0],$v_read_size[0]));
$p_size = array($p_size[0] - $v_read_size[0],false);
}}else 
{if ( ($p_mode[0] == (1)))
 {while ( ($p_size[0] != (0)) )
{$v_read_size = (($p_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $p_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = @array(gzread(deAspisRC($p_src),deAspisRC($v_read_size)),false);
@attAspis(fwrite($p_dest[0],$v_buffer[0],$v_read_size[0]));
$p_size = array($p_size[0] - $v_read_size[0],false);
}}else 
{if ( ($p_mode[0] == (2)))
 {while ( ($p_size[0] != (0)) )
{$v_read_size = (($p_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $p_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = @attAspis(fread($p_src[0],$v_read_size[0]));
@array(gzwrite(deAspisRC($p_dest),deAspisRC($v_buffer),deAspisRC($v_read_size)),false);
$p_size = array($p_size[0] - $v_read_size[0],false);
}}else 
{if ( ($p_mode[0] == (3)))
 {while ( ($p_size[0] != (0)) )
{$v_read_size = (($p_size[0] < PCLZIP_READ_BLOCK_SIZE) ? $p_size : array(PCLZIP_READ_BLOCK_SIZE,false));
$v_buffer = @array(gzread(deAspisRC($p_src),deAspisRC($v_read_size)),false);
@array(gzwrite(deAspisRC($p_dest),deAspisRC($v_buffer),deAspisRC($v_read_size)),false);
$p_size = array($p_size[0] - $v_read_size[0],false);
}}}}}return $v_result;
 }
function PclZipUtilRename ( $p_src,$p_dest ) {
$v_result = array(1,false);
if ( (denot_boolean(@attAspis(rename($p_src[0],$p_dest[0])))))
 {if ( (denot_boolean(@attAspis(copy($p_src[0],$p_dest[0])))))
 {$v_result = array(0,false);
}else 
{if ( (denot_boolean(@attAspis(unlink($p_src[0])))))
 {$v_result = array(0,false);
}}}return $v_result;
 }
function PclZipUtilOptionText ( $p_option ) {
$v_list = array(get_defined_constants(),false);
for ( Aspis_reset($v_list) ; deAspis($v_key = Aspis_key($v_list)) ; Aspis_next($v_list) )
{$v_prefix = Aspis_substr($v_key,array(0,false),array(10,false));
if ( (((($v_prefix[0] == ('PCLZIP_OPT')) || ($v_prefix[0] == ('PCLZIP_CB_'))) || ($v_prefix[0] == ('PCLZIP_ATT'))) && (deAspis(attachAspis($v_list,$v_key[0])) == $p_option[0])))
 {return $v_key;
}}$v_result = array('Unknown',false);
return $v_result;
 }
function PclZipUtilTranslateWinPath ( $p_path,$p_remove_disk_letter = array(true,false) ) {
if ( deAspis(Aspis_stristr(array(php_uname(),false),array('windows',false))))
 {if ( (deAspis(($p_remove_disk_letter)) && (deAspis(($v_position = attAspis(strpos($p_path[0],':')))) != false)))
 {$p_path = Aspis_substr($p_path,array($v_position[0] + (1),false));
}if ( ((strpos($p_path[0],'\\') > (0)) || (deAspis(Aspis_substr($p_path,array(0,false),array(1,false))) == ('\\'))))
 {$p_path = Aspis_strtr($p_path,array('\\',false),array('/',false));
}}return $p_path;
 }
;
?>
<?php 