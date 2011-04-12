<?php require_once('AspisMain.php'); ?><?php
class AtomFeed{var $links = array(array(),false);
var $categories = array(array(),false);
var $entries = array(array(),false);
}class AtomEntry{var $links = array(array(),false);
var $categories = array(array(),false);
}class AtomParser{var $NS = array('http://www.w3.org/2005/Atom',false);
var $ATOM_CONTENT_ELEMENTS = array(array(array('content',false),array('summary',false),array('title',false),array('subtitle',false),array('rights',false)),false);
var $ATOM_SIMPLE_ELEMENTS = array(array(array('id',false),array('updated',false),array('published',false),array('draft',false)),false);
var $debug = array(false,false);
var $depth = array(0,false);
var $indent = array(2,false);
var $in_content;
var $ns_contexts = array(array(),false);
var $ns_decls = array(array(),false);
var $content_ns_decls = array(array(),false);
var $content_ns_contexts = array(array(),false);
var $is_xhtml = array(false,false);
var $is_html = array(false,false);
var $is_text = array(true,false);
var $skipped_div = array(false,false);
var $FILE = array("php://input",false);
var $feed;
var $current;
function AtomParser (  ) {
{$this->feed = array(new AtomFeed(),false);
$this->current = array(null,false);
$this->map_attrs_func = Aspis_create_function(array('$k,$v',false),array('return "$k=\"$v\"";',false));
$this->map_xmlns_func = Aspis_create_function(array('$p,$n',false),array('$xd = "xmlns"; if(strlen($n[0])>0) $xd .= ":{$n[0]}"; return "{$xd}=\"{$n[1]}\"";',false));
} }
function _p ( $msg ) {
{if ( $this->debug[0])
 {print AspisCheckPrint(concat2(concat(Aspis_str_repeat(array(" ",false),array($this->depth[0] * $this->indent[0],false)),$msg),"\n"));
}} }
function error_handler ( $log_level,$log_text,$error_file,$error_line ) {
{$this->error = $log_text;
} }
function parse (  ) {
{set_error_handler(deAspisRC(array(array(array($this,false),array('error_handler',false)),false)));
Aspis_array_unshift($this->ns_contexts,array(array(),false));
$parser = array(xml_parser_create_ns(),false);
Aspis_xml_set_object($parser,array($this,false));
Aspis_xml_set_element_handler($parser,array("start_element",false),array("end_element",false));
xml_parser_set_option($parser[0],XML_OPTION_CASE_FOLDING,0);
xml_parser_set_option($parser[0],XML_OPTION_SKIP_WHITE,0);
Aspis_xml_set_character_data_handler($parser,array("cdata",false));
Aspis_xml_set_default_handler($parser,array("_default",false));
Aspis_xml_set_start_namespace_decl_handler($parser,array("start_ns",false));
Aspis_xml_set_end_namespace_decl_handler($parser,array("end_ns",false));
$this->content = array('',false);
$ret = array(true,false);
$fp = attAspis(fopen($this->FILE[0],("r")));
while ( deAspis($data = attAspis(fread($fp[0],(4096)))) )
{if ( $this->debug[0])
 $this->content = concat($this->content ,$data);
if ( (!(xml_parse($parser[0],$data[0],feof($fp[0])))))
 {trigger_error(deAspisRC(Aspis_sprintf(concat2(__(array('XML error: %s at line %d',false)),"\n"),array(xml_error_string(deAspisRC(array(xml_get_error_code(deAspisRC($xml_parser)),false))),false),array(xml_get_current_line_number(deAspisRC($xml_parser)),false))));
$ret = array(false,false);
break ;
}}fclose($fp[0]);
xml_parser_free(deAspisRC($parser));
restore_error_handler();
return $ret;
} }
function start_element ( $parser,$name,$attrs ) {
{$tag = Aspis_array_pop(Aspis_split(array(":",false),$name));
switch ( $name[0] ) {
case (deconcat2($this->NS,':feed')):$this->current = $this->feed;
break ;
case (deconcat2($this->NS,':entry')):$this->current = array(new AtomEntry(),false);
break ;
 }
;
$this->_p(concat2(concat1("start_element('",$name),"')"));
Aspis_array_unshift($this->ns_contexts,$this->ns_decls);
postincr($this->depth);
if ( (!((empty($this->in_content) || Aspis_empty( $this ->in_content )))))
 {$this->content_ns_decls = array(array(),false);
if ( ($this->is_html[0] || $this->is_text[0]))
 trigger_error("Invalid content in element found. Content must not be of type text or html if it contains markup.");
$attrs_prefix = array(array(),false);
foreach ( $attrs[0] as $key =>$value )
{restoreTaint($key,$value);
{$with_prefix = $this->ns_to_prefix($key,array(true,false));
arrayAssign($attrs_prefix[0],deAspis(registerTaint(attachAspis($with_prefix,(1)))),addTaint($this->xml_escape($value)));
}}$attrs_str = Aspis_join(array(' ',false),attAspisRC(array_map(AspisInternalCallback($this->map_attrs_func),deAspisRC(attAspisRC(array_keys(deAspisRC($attrs_prefix)))),deAspisRC(Aspis_array_values($attrs_prefix)))));
if ( (strlen($attrs_str[0]) > (0)))
 {$attrs_str = concat1(" ",$attrs_str);
}$with_prefix = $this->ns_to_prefix($name);
if ( (denot_boolean($this->is_declared_content_ns(attachAspis($with_prefix,(0))))))
 {Aspis_array_push($this->content_ns_decls,attachAspis($with_prefix,(0)));
}$xmlns_str = array('',false);
if ( (count($this->content_ns_decls[0]) > (0)))
 {Aspis_array_unshift($this->content_ns_contexts,$this->content_ns_decls);
$xmlns_str = concat($xmlns_str,Aspis_join(array(' ',false),attAspisRC(array_map(AspisInternalCallback($this->map_xmlns_func),deAspisRC(attAspisRC(array_keys(deAspisRC($this->content_ns_contexts[0][(0)])))),deAspisRC(Aspis_array_values($this->content_ns_contexts[0][(0)]))))));
if ( (strlen($xmlns_str[0]) > (0)))
 {$xmlns_str = concat1(" ",$xmlns_str);
}}Aspis_array_push($this->in_content,array(array($tag,$this->depth,concat2(concat(concat1("<",attachAspis($with_prefix,(1))),$xmlns_str),">")),false));
}else 
{if ( (deAspis(Aspis_in_array($tag,$this->ATOM_CONTENT_ELEMENTS)) || deAspis(Aspis_in_array($tag,$this->ATOM_SIMPLE_ELEMENTS))))
 {$this->in_content = array(array(),false);
$this->is_xhtml = array(deAspis($attrs[0]['type']) == ('xhtml'),false);
$this->is_html = array((deAspis($attrs[0]['type']) == ('html')) || (deAspis($attrs[0]['type']) == ('text/html')),false);
$this->is_text = array((denot_boolean(Aspis_in_array(array('type',false),attAspisRC(array_keys(deAspisRC($attrs)))))) || (deAspis($attrs[0]['type']) == ('text')),false);
$type = $this->is_xhtml[0] ? array('XHTML',false) : ($this->is_html[0] ? array('HTML',false) : ($this->is_text[0] ? array('TEXT',false) : $attrs[0]['type']));
if ( deAspis(Aspis_in_array(array('src',false),attAspisRC(array_keys(deAspisRC($attrs))))))
 {$this->current[0]->$tag[0] = $attrs;
}else 
{{Aspis_array_push($this->in_content,array(array($tag,$this->depth,$type),false));
}}}else 
{if ( ($tag[0] == ('link')))
 {Aspis_array_push($this->current[0]->links,$attrs);
}else 
{if ( ($tag[0] == ('category')))
 {Aspis_array_push($this->current[0]->categories,$attrs);
}}}}$this->ns_decls = array(array(),false);
} }
function end_element ( $parser,$name ) {
{$tag = Aspis_array_pop(Aspis_split(array(":",false),$name));
$ccount = attAspis(count($this->in_content[0]));
if ( (!((empty($this->in_content) || Aspis_empty( $this ->in_content )))))
 {if ( (($this->in_content[0][(0)][0][(0)][0] == $tag[0]) && ($this->in_content[0][(0)][0][(1)][0] == $this->depth[0])))
 {$origtype = $this->in_content[0][(0)][0][(2)];
Aspis_array_shift($this->in_content);
$newcontent = array(array(),false);
foreach ( $this->in_content[0] as $c  )
{if ( (count($c[0]) == (3)))
 {Aspis_array_push($newcontent,attachAspis($c,(2)));
}else 
{{if ( ($this->is_xhtml[0] || $this->is_text[0]))
 {Aspis_array_push($newcontent,$this->xml_escape($c));
}else 
{{Aspis_array_push($newcontent,$c);
}}}}}if ( deAspis(Aspis_in_array($tag,$this->ATOM_CONTENT_ELEMENTS)))
 {$this->current[0]->$tag[0] = array(array($origtype,Aspis_join(array('',false),$newcontent)),false);
}else 
{{$this->current[0]->$tag[0] = Aspis_join(array('',false),$newcontent);
}}$this->in_content = array(array(),false);
}else 
{if ( (($this->in_content[0][($ccount[0] - (1))][0][(0)][0] == $tag[0]) && ($this->in_content[0][($ccount[0] - (1))][0][(1)][0] == $this->depth[0])))
 {arrayAssign($this->in_content[0][($ccount[0] - (1))][0],deAspis(registerTaint(array(2,false))),addTaint(concat2(Aspis_substr($this->in_content[0][($ccount[0] - (1))][0][(2)],array(0,false),negate(array(1,false))),"/>")));
}else 
{{$endtag = $this->ns_to_prefix($name);
Aspis_array_push($this->in_content,array(array($tag,$this->depth,concat2(concat1("</",attachAspis($endtag,(1))),">")),false));
}}}}Aspis_array_shift($this->ns_contexts);
postdecr($this->depth);
if ( ($name[0] == (deconcat2($this->NS,':entry'))))
 {Aspis_array_push($this->feed[0]->entries,$this->current);
$this->current = array(null,false);
}$this->_p(concat2(concat1("end_element('",$name),"')"));
} }
function start_ns ( $parser,$prefix,$uri ) {
{$this->_p(concat(concat2(concat1("starting: ",$prefix),":"),$uri));
Aspis_array_push($this->ns_decls,array(array($prefix,$uri),false));
} }
function end_ns ( $parser,$prefix ) {
{$this->_p(concat2(concat1("ending: #",$prefix),"#"));
} }
function cdata ( $parser,$data ) {
{$this->_p(concat2(concat1("data: #",Aspis_str_replace(array(array(array("\n",false)),false),array(array(array("\\n",false)),false),Aspis_trim($data))),"#"));
if ( (!((empty($this->in_content) || Aspis_empty( $this ->in_content )))))
 {Aspis_array_push($this->in_content,$data);
}} }
function _default ( $parser,$data ) {
{} }
function ns_to_prefix ( $qname,$attr = array(false,false) ) {
{$components = Aspis_split(array(":",false),$qname);
$name = Aspis_array_pop($components);
if ( (!((empty($components) || Aspis_empty( $components)))))
 {$ns = Aspis_join(array(":",false),$components);
foreach ( $this->ns_contexts[0] as $context  )
{foreach ( $context[0] as $mapping  )
{if ( ((deAspis(attachAspis($mapping,(1))) == $ns[0]) && (strlen(deAspis(attachAspis($mapping,(0)))) > (0))))
 {return array(array($mapping,concat(concat2(attachAspis($mapping,(0)),":"),$name)),false);
}}}}if ( $attr[0])
 {return array(array(array(null,false),$name),false);
}else 
{{foreach ( $this->ns_contexts[0] as $context  )
{foreach ( $context[0] as $mapping  )
{if ( (strlen(deAspis(attachAspis($mapping,(0)))) == (0)))
 {return array(array($mapping,$name),false);
}}}}}} }
function is_declared_content_ns ( $new_mapping ) {
{foreach ( $this->content_ns_contexts[0] as $context  )
{foreach ( $context[0] as $mapping  )
{if ( ($new_mapping[0] == $mapping[0]))
 {return array(true,false);
}}}return array(false,false);
} }
function xml_escape ( $string ) {
{return Aspis_str_replace(array(array(array('&',false),array('"',false),array("'",false),array('<',false),array('>',false)),false),array(array(array('&amp;',false),array('&quot;',false),array('&apos;',false),array('&lt;',false),array('&gt;',false)),false),$string);
} }
};
?>
<?php 