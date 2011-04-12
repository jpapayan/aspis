<?php
/*
	modified bbcode plugin for WP-Froum, just tagged ff_ and PP_ on stuff
	so as to not have any issues with the official plugin
*/
/*
Original Plugin URL: http://www.procata.com/software/wordpress-bbcode/
Author: Jeff Moore (modified by Fredrik Fahlstad)
Author URI: http://www.procata.com/blog/
*/

// Copyright (c) 2004 Jeff Moore
// Portions Copyright (c) 1997-2003 The PHP Group
// LICENSE: This source file is subject to version 2.02 of the PHP license.
// This code contains a modified version of PEAR::HTML_BBCodeParser, 
// (original author Stijn de Reede <sjr@gmx.co.uk>).
// http://pear.php.net/package/HTML_BBCodeParser/docs

if (!defined('PP_CUSTOM_TAGS')) {
    define('PP_CUSTOM_TAGS', TRUE);
}
        
$ff_allowedtags = array(
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'rel' => array()),
                'abbr' => array('title' => array()),
                'acronym' => array('title' => array()),
                'b' => array(),
                'blockquote' => array('cite' => array()),
                'code' => array(),
                'div' => array('align' => array()),
                'em' => array(),
                'font' => array(
                    'color' => array(),
                    'size' => array(),
                    'face' => array()),
                'i' => array(),
                'li' => array(),
                'ol' => array(),
                'strike' => array(),
                'strong' => array(),
                'sub' => array(),
                'sup' => array(),
                'ul' => array(),
                );


class PP_HTML_BBCodeParser
{

    /**
    * An array of tags parsed by the engine, should be overwritten by filters
    *
    * @access   private
    * @var      array
    */
    var $_definedTags  = array();

    /**
    * A string containing the input
    *
    * @access   private
    * @var      string
    */
    var $_text          = '';

    /**
    * A string containing the preparsed input
    *
    * @access   private
    * @var      string
    */
    var $_preparsed     = '';

    /**
    * An array tags and texts build from the input text
    *
    * @access   private
    * @var      array
    */
    var $_tagArray      = array();

    /**
    * A string containing the parsed version of the text
    *
    * @access   private
    * @var      string
    */
    var $_parsed        = '';

    /**
    * An array of options, filled by an ini file or through the contructor
    *
    * @access   private
    * @var      array
    */
    var $_options = array(  'quotestyle'    => 'single',
                            'quotewhat'     => 'all',
                            'open'          => '[',
                            'close'         => ']',
                            'xmlclose'      => true,
                            'filters'       => 'Basic'
                         );

    /**
    * An array of filters used for parsing
    *
    * @access   private
    * @var      array
    */
    var $_filters       = array();

    /**
    * Constructor, initialises the options and filters
    *
    * Sets the private variable _options with base options defined with
    * &PP_HTML_BBCodeParser::getStaticProperty(), overwriting them with (if present)
    * the argument to this method.
    * Then it sets the extra options to properly escape the tag
    * characters in preg_replace() etc. The set options are
    * then stored back with &PP_HTML_BBCodeParser::getStaticProperty(), so that the filter
    * classes can use them.
    * All the filters in the options are initialised and their defined tags
    * are copied into the private variable _definedTags.
    *
    * @param    array           options to use, can be left out
    * @return   none
    * @access   public
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function PP_HTML_BBCodeParser($options = array())
    {

        /* set the already set options */
        $baseoptions = &PP_HTML_BBCodeParser::getStaticProperty('PP_HTML_BBCodeParser', '_options');
        if (is_array($baseoptions)) {
            foreach ($baseoptions as  $k => $v)  {
                $this->_options[$k] = $v;
            }
        }
        
        /* set the options passed as an argument */
        foreach ($options as $k => $v )  {
           $this->_options[$k] = $v;
        }

        /* add escape open and close chars to the options for preg escaping */
        $preg_escape = '\^$.[]|()?*+{}';
        if (strstr($preg_escape, $this->_options['open'])) {
            $this->_options['open_esc'] = "\\".$this->_options['open'];
        } else {
            $this->_options['open_esc'] = $this->_options['open'];
        }
        if (strstr($preg_escape, $this->_options['close'])) {
            $this->_options['close_esc'] = "\\".$this->_options['close'];
        } else {
            $this->_options['close_esc'] = $this->_options['close'];
        }

        /* set the options back so that child classes can use them */
        $baseoptions = $this->_options;
        unset($baseoptions);
        
        /* return if this is a subclass */
        if (is_subclass_of($this, 'PP_HTML_BBCodeParser')) return;

        /* extract the definedTags from subclasses */
        $filters = explode(',', $this->_options['filters']);
        foreach ($filters as $filter) {
            $class = 'PP_HTML_BBCodeParser_Filter_'.$filter;
            $this->_filters[$filter] =& new $class;
            $this->_definedTags = array_merge($this->_definedTags, $this->_filters[$filter]->_definedTags);
        }
    }

    function &getStaticProperty($var)
    {
        static $properties;
        return $properties[$var];
    }

    /**
    * Executes statements before the actual array building starts
    *
    * This method should be overwritten in a filter if you want to do
    * something before the parsing process starts. This can be useful to
    * allow certain short alternative tags which then can be converted into
    * proper tags with preg_replace() calls.
    * The main class walks through all the filters and and calls this
    * method. The filters should modify their private $_preparsed
    * variable, with input from $_text.
    *
    * @return   none
    * @access   private
    * @see      $_text
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function _preparse()
    {
        /* default: assign _text to _preparsed, to be overwritten by filters */
        $this->_preparsed = $this->_text;

        /* return if this is a subclass */
        if (is_subclass_of($this, 'PP_HTML_BBCodeParser')) return;

        /* walk through the filters and execute _preparse */
        foreach ($this->_filters as $filter) {
            $filter->setText($this->_preparsed);
            $filter->_preparse();
            $this->_preparsed = $filter->getPreparsed();
        }
    }




    /**
    * Builds the tag array from the input string $_text
    *
    * An array consisting of tag and text elements is contructed from the
    * $_preparsed variable. The method uses _buildTag() to check if a tag is
    * valid and to build the actual tag to be added to the tag array.
    *
    * TODO: - rewrite whole method, as this one is old and probably slow
    *       - see if a recursive method would be better than an iterative one
    *
    * @return   none
    * @access   private
    * @see      _buildTag()
    * @see      $_text
    * @see      $_tagArray
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function _buildTagArray()
    {
        $this->_tagArray = array();
        $str = $this->_preparsed;
        $strPos = 0;
        $strLength = strlen($str);

        while ( ($strPos < $strLength) ) {
            $tag = array();
            $openPos = strpos($str, $this->_options['open'], $strPos);
            if ($openPos === false) {
                $openPos = $strLength;
                $nextOpenPos = $strLength;
            }
            if ($openPos + 1 > $strLength) {
                $nextOpenPos = $strLength;
            } else {
                $nextOpenPos = strpos($str, $this->_options['open'], $openPos + 1);
                if ($nextOpenPos === false) {
                    $nextOpenPos = $strLength;
                }
            }
            $closePos = strpos($str, $this->_options['close'], $strPos);
            if ($closePos === false) {
                $closePos = $strLength + 1;
            }

            if ( $openPos == $strPos ) {
                if ( ($nextOpenPos < $closePos) ) {
                    /* new open tag before closing tag: treat as text */
                    $newPos = $nextOpenPos;
                    $tag['text'] = substr($str, $strPos, $nextOpenPos - $strPos);
                    $tag['type'] = 0;
                } else {
                    /* possible valid tag */
                    $newPos = $closePos + 1;
                    $newTag = $this->_buildTag(substr($str, $strPos, $closePos - $strPos + 1));
                    if ( ($newTag !== false) ) {
                        $tag = $newTag;
                    } else {
                    /* no valid tag after all */
                        $tag['text'] = substr($str, $strPos, $closePos - $strPos + 1);
                        $tag['type'] = 0;
                    }
                }
            } else {
                /* just text */
                $newPos = $openPos;
                $tag['text'] = substr($str, $strPos, $openPos - $strPos);
                $tag['type'] = 0;
            }

            /* join 2 following text elements */
            if ($tag['type'] === 0 && isset($prev) && $prev['type'] === 0) {
                $tag['text'] = $prev['text'].$tag['text'];
                array_pop($this->_tagArray);
            }

            $this->_tagArray[] = $tag;
            $prev = $tag;
            $strPos = $newPos;
        }
    }




    /**
    * Builds a tag from the input string
    *
    * This method builds a tag array based on the string it got as an
    * argument. If the tag is invalid, <false> is returned. The tag
    * attributes are extracted from the string and stored in the tag
    * array as an associative array.
    *
    * @param    string          string to build tag from
    * @return   array           tag in array format
    * @access   private
    * @see      _buildTagArray()
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function _buildTag($str)
    {
        $tag = array('text' => $str, 'attributes' => array());

        if (substr($str, 1, 1) == '/') {        /* closing tag */

            $tag['tag'] = strtolower(substr($str, 2, strlen($str) - 3));
            if ( (in_array($tag['tag'], array_keys($this->_definedTags)) == false) ) {
                return false;                   /* nope, it's not valid */
            } else {
                $tag['type'] = 2;
                return $tag;
            }
        } else {                                /* opening tag */

            $tag['type'] = 1;
            if ( (strpos($str, ' ') == true) && (strpos($str, '=') == false) ) {
                return false;                   /* nope, it's not valid */
            }

            /* tnx to Onno for the regex
               split the tag with arguments and all */
            $oe = $this->_options['open_esc'];
            $ce = $this->_options['close_esc'];
            if (preg_match("!$oe([a-z]+)[^$ce]*$ce!i", $str, $tagArray) == 0) {
                return false;
            }
            $tag['tag'] = strtolower($tagArray[1]);
            if ( (in_array($tag['tag'], array_keys($this->_definedTags)) == false) ) {
                return false;                   /* nope, it's not valid */
            }

            /* tnx to Onno for the regex
               validate the arguments */
            preg_match_all("![\s$oe]([a-z]+)=([^\s$ce]+)(?=[\s$ce])!i", $str, $attributeArray, PREG_SET_ORDER);
            foreach ($attributeArray as $attribute) {
                $attribute[1] = strtolower($attribute[1]);
                if ( (in_array($attribute[1], array_keys($this->_definedTags[$tag['tag']]['attributes'])) == true) ) {
                    $tag['attributes'][$attribute[1]] = $attribute[2];
                }
            }
            return $tag;
        }
    }




    /**
    * Validates the tag array, regarding the allowed tags
    *
    * While looping through the tag array, two following text tags are
    * joined, and it is checked that the tag is allowed inside the
    * last opened tag.
    * By remembering what tags have been opened it is checked that
    * there is correct (xml compliant) nesting.
    * In the end all still opened tags are closed.
    *
    * @return   none
    * @access   private
    * @see      _isAllowed()
    * @see      $_tagArray
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function _validateTagArray()
    {
        $newTagArray = array();
        $openTags = array();
        foreach ($this->_tagArray as $tag) {
            $prevTag = end($newTagArray);
            switch ($tag['type']) {
            case 0:
                if ($prevTag['type'] === 0) {
                    $tag['text'] = $prevTag['text'].$tag['text'];
                    array_pop($newTagArray);
                }
                $newTagArray[] = $tag;
                break;

            case 1:
                if ($this->_isAllowed(end($openTags), $tag['tag']) == false) {
                    $tag['type'] = 0;
                    if ($prevTag['type'] === 0) {
                        $tag['text'] = $prevTag['text'].$tag['text'];
                        array_pop($newTagArray);
                    }
                } else {
                    $openTags[] = $tag['tag'];
                }
                $newTagArray[] = $tag;
                break;

            case 2:
                if ( ($this->_isAllowed(end($openTags), $tag['tag']) == true) || ($tag['tag'] == end($openTags)) ) {
                    if (in_array($tag['tag'], $openTags)) {
                        $tmpOpenTags = array();
                        while (end($openTags) != $tag['tag']) {
                            $newTagArray[] = $this->_buildTag('[/'.end($openTags).']');
                            $tmpOpenTags[] = end($openTags);
                            array_pop($openTags);
                        }
                        $newTagArray[] = $tag;
                        array_pop($openTags);
                        while (end($tmpOpenTags)) {
                            $tmpTag = $this->_buildTag('['.end($tmpOpenTags).']');
                            $newTagArray[] = $tmpTag;
                            $openTags[] = $tmpTag['tag'];
                            array_pop($tmpOpenTags);
                        }
                    }
                } else {
                    $tag['type'] = 0;
                    if ($prevTag['type'] === 0) {
                        $tag['text'] = $prevTag['text'].$tag['text'];
                        array_pop($newTagArray);
                    }
                    $newTagArray[] = $tag;
                }
                break;
            }
        }
        while (end($openTags)) {
            $newTagArray[] = $this->_buildTag('[/'.end($openTags).']');
            array_pop($openTags);
        }
        $this->_tagArray = $newTagArray;
    }




    /**
    * Checks to see if a tag is allowed inside another tag
    *
    * The allowed tags are extracted from the private _definedTags array.
    *
    * @param    array           tag that is on the outside
    * @param    array           tag that is on the inside
    * @return   boolean         return true if the tag is allowed, false
    *                           otherwise
    * @access   private
    * @see      _validateTagArray()
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function _isAllowed($out, $in)
    {
        if (!$out)                                          return true;
        if ($this->_definedTags[$out]['allowed'] == 'all')  return true;
        if ($this->_definedTags[$out]['allowed'] == 'none') return false;

        $ar = explode('^', $this->_definedTags[$out]['allowed']);
        $tags = explode(',', $ar[1]);
        if ($ar[0] == 'none' && in_array($in, $tags))       return true;
        if ($ar[0] == 'all'  && in_array($in, $tags))       return false;
        return false;
    }




    /**
    * Builds a parsed string based on the tag array
    *
    * The correct html and atribute values are extracted from the private
    * _definedTags array.
    *
    * @return   none
    * @access   private
    * @see      $_tagArray
    * @see      $_parsed
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function _buildParsedString()
    {
        $this->_parsed = '';
        foreach ($this->_tagArray as $tag) {
            switch ($tag['type']) {

            /* just text */
            case 0:
                $this->_parsed .= $tag['text'];
                break;

            /* opening tag */
            case 1:
                $this->_parsed .= '<'.$this->_definedTags[$tag['tag']]['htmlopen'];
                if ($this->_options['quotestyle'] == 'single') $q = "'";
                if ($this->_options['quotestyle'] == 'double') $q = '"';
                foreach ($tag['attributes'] as $a => $v) {
                    if (    ($this->_options['quotewhat'] == 'nothing') ||
                            ($this->_options['quotewhat'] == 'strings') && (is_numeric($v)) ) {
                        $this->_parsed .= ' '.sprintf($this->_definedTags[$tag['tag']]['attributes'][$a], $v, '');
                    } else {
                        $this->_parsed .= ' '.sprintf($this->_definedTags[$tag['tag']]['attributes'][$a], $v, $q);
                    }
                }
                if ($this->_definedTags[$tag['tag']]['htmlclose'] == '' && $this->_options['xmlclose']) {
                    $this->_parsed .= ' /';
                }
                $this->_parsed .= '>';
                break;

            /* closing tag */
            case 2:
                if ($this->_definedTags[$tag['tag']]['htmlclose'] != '') {
                    $this->_parsed .= '</'.$this->_definedTags[$tag['tag']]['htmlclose'].'>';
                }
                break;
            }
        }

    }




    /**
    * Sets text in the object to be parsed
    *
    * @param    string          the text to set in the object
    * @return   none
    * @access   public
    * @see      getText()
    * @see      $_text
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function setText($str)
    {
        $this->_text = $str;
    }




    /**
    * Gets the unparsed text from the object
    *
    * @return   string          the text set in the object
    * @access   public
    * @see      setText()
    * @see      $_text
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function getText()
    {
        return $this->_text;
    }




    /**
    * Gets the preparsed text from the object
    *
    * @return   string          the text set in the object
    * @access   public
    * @see      _preparse()
    * @see      $_preparsed
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function getPreparsed()
    {
        return $this->_preparsed;
    }




    /**
    * Gets the parsed text from the object
    *
    * @return   string          the parsed text set in the object
    * @access   public
    * @see      parse()
    * @see      $_parsed
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function getParsed()
    {
        return $this->_parsed;
    }




    /**
    * Parses the text set in the object
    *
    * @return   none
    * @access   public
    * @see      _preparse()
    * @see      _buildTagArray()
    * @see      _validateTagArray()
    * @see      _buildParsedString()
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function parse()
    {
        $this->_preparse();
        $this->_buildTagArray();
        $this->_validateTagArray();
        $this->_buildParsedString();
    }




    /**
    * Quick method to do setText(), parse() and getParsed at once
    *
    * @return   none
    * @access   public
    * @see      parse()
    * @see      $_text
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function qparse($str)
    {
        $this->_text = $str;
        $this->parse();
        return $this->_parsed;
    }




    /**
    * Quick static method to do setText(), parse() and getParsed at once
    *
    * @return   none
    * @access   public
    * @see      parse()
    * @see      $_text
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function staticQparse($str)
    {
        $p = new PP_HTML_BBCodeParser();
        $str = $p->qparse($str);
        unset($p);
        return $str;
    }


}

class PP_HTML_BBCodeParser_Filter_Links extends PP_HTML_BBCodeParser
{

    /**
    * An array of tags parsed by the engine
    *
    * @access   private
    * @var      array
    */
    var $_definedTags = array(  'url' => array( 'htmlopen'  => 'a',
                                                'htmlclose' => 'a',
                                                'allowed'   => 'none^img',
                                                'attributes'=> array(   'url'   => '',
                                                                        't'     => '')
                                               )
                              );


    /**
    * Executes statements before the actual array building starts
    *
    * This method should be overwritten in a filter if you want to do
    * something before the parsing process starts. This can be useful to
    * allow certain short alternative tags which then can be converted into
    * proper tags with preg_replace() calls.
    * The main class walks through all the filters and and calls this
    * method if it exists. The filters should modify their private $_text
    * variable.
    *
    * @return   none
    * @access   private
    * @see      $_text
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function _preparse()
    {
        $options = PP_HTML_BBCodeParser::getStaticProperty('PP_HTML_BBCodeParser','_options');
        $o = $options['open'];
        $c = $options['close'];
        $oe = $options['open_esc'];
        $ce = $options['close_esc'];
        $pattern = array(   "!(^|\s|\()((((http(s?)|ftp)://)|www)[-a-z0-9.]+\.[a-z]{2,4}[^\s()]*)!i",
                            "!".$oe."url(".$ce."|\s.*".$ce.")(.*)".$oe."/url".$ce."!iU");
        $replace = array(   "\\1".$o."url".$c."\\2".$o."/url".$c,
                            $o."url=\\2\\1\\2".$o."/url".$c);
        $this->_preparsed = preg_replace($pattern, $replace, $this->_text);
    }


}

class PP_HTML_BBCodeParser_Filter_Lists extends PP_HTML_BBCodeParser
{

    /**
    * An array of tags parsed by the engine
    *
    * @access   private
    * @var      array
    */
    var $_definedTags = array(  'list'  => array(   'htmlopen'  => 'ol',
                                                    'htmlclose' => 'ol',
                                                    'allowed'   => 'none^li',
                                                    'attributes'=> array(   'list'  => 'type=%2$s%1$s%2$s',
                                                                            's'     => 'start=%2$s%1$d%2$s')
                                                    ),
                                'ulist' => array(   'htmlopen'  => 'ul',
                                                    'htmlclose' => 'ul',
                                                    'allowed'   => 'none^li',
                                                    'attributes'=> array()
                                                    ),
                                'li'    => array(   'htmlopen'  => 'li',
                                                    'htmlclose' => 'li',
                                                    'allowed'   => 'all',
                                                    'attributes'=> array(   'li'    => 'value=%2$s%1$d%2$s')
                                                    )
                                );


    /**
    * Executes statements before the actual array building starts
    *
    * This method should be overwritten in a filter if you want to do
    * something before the parsing process starts. This can be useful to
    * allow certain short alternative tags which then can be converted into
    * proper tags with preg_replace() calls.
    * The main class walks through all the filters and and calls this
    * method if it exists. The filters should modify their private $_text
    * variable.
    *
    * @return   none
    * @access   private
    * @see      $_text
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function _preparse()
    {
        $options = PP_HTML_BBCodeParser::getStaticProperty('PP_HTML_BBCodeParser','_options');
        $o = $options['open'];
        $c = $options['close'];
        $oe = $options['open_esc'];
        $ce = $options['close_esc'];
        $pattern = array(   "!".$oe."\*".$ce."(.*)!i",
                            "!".$oe."list".$ce."(.+)".$oe."/list".$ce."!isU");
        $replace = array(   $o."li".$c."\\1".$o."/li".$c,
                            $o."ulist".$c."\\1".$o."/ulist".$c);
        $this->_preparsed = preg_replace($pattern, $replace, $this->_text);
    }


}

class PP_HTML_BBCodeParser_Filter_Images extends PP_HTML_BBCodeParser
{

    /**
    * An array of tags parsed by the engine
    *
    * @access   private
    * @var      array
    */
    var $_definedTags = array(  'img' => array( 'htmlopen'  => 'img',
                                                'htmlclose' => '',
                                                'allowed'   => 'none',
                                                'attributes'=> array(   'img'   => 'src=%2$s%1$s%2$s',
                                                                        'w'     => 'width=%2$s%1$d%2$s',
                                                                        'h'     => 'height=%2$s%1$d%2$s')
                                                )
                              );




    /**
    * Executes statements before the actual array building starts
    *
    * This method should be overwritten in a filter if you want to do
    * something before the parsing process starts. This can be useful to
    * allow certain short alternative tags which then can be converted into
    * proper tags with preg_replace() calls.
    * The main class walks through all the filters and and calls this
    * method if it exists. The filters should modify their private $_text
    * variable.
    *
    * @return   none
    * @access   private
    * @see      $_text
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function _preparse()
    {
        $options = PP_HTML_BBCodeParser::getStaticProperty('PP_HTML_BBCodeParser','_options');
        $o = $options['open'];
        $c = $options['close'];
        $oe = $options['open_esc'];
        $ce = $options['close_esc'];
        $this->_preparsed = preg_replace("!".$oe."img(".$ce."|\s.*".$ce.")(.*)".$oe."/img".$ce."!Ui", $o."img=\\2\\1".$o."/img".$c, $this->_text);
    }


}



class PP_HTML_BBCodeParser_Filter_Extended extends PP_HTML_BBCodeParser
{

    /**
    * An array of tags parsed by the engine
    *
    * @access   private
    * @var      array
    */
    var $_definedTags = array(
                                'color' => array( 'htmlopen'  => 'font',
                                                'htmlclose' => 'font',
                                                'allowed'   => 'all',
                                                'attributes'=> array('color' =>'color=%2$s%1$s%2$s')),
                                'size' => array( 'htmlopen'  => 'font',
                                                'htmlclose' => 'font',
                                                'allowed'   => 'all',
                                                'attributes'=> array('size' =>'size=%2$s%1$s%2$s')),
                                'font' => array( 'htmlopen'  => 'font',
                                                'htmlclose' => 'span',
                                                'allowed'   => 'all',
                                                'attributes'=> array('font' =>'face=%2$s%1$s%2$s')),
                                'align' => array( 'htmlopen'  => 'div',
                                                'htmlclose' => 'div',
                                                'allowed'   => 'all',
                                                'attributes'=> array('align' =>'style=%2$stext-align: %1$s%2$s')),
                                'quote' => array('htmlopen'  => 'blockquote',
                                                'htmlclose' => 'blockquote',
                                                'allowed'   => 'all',
                                                'attributes'=> array('quote' =>'cite=%2$s%1$s%2$s')),
                                'code' => array('htmlopen'  => 'pre class=\"code\"',
                                                'htmlclose' => 'pre',
                                                'allowed'   => 'all',
                                                'attributes'=> array())

    );


}

class PP_HTML_BBCodeParser_Filter_Email extends PP_HTML_BBCodeParser
{

    /**
    * An array of tags parsed by the engine
    *
    * @access   private
    * @var      array
    */
    var $_definedTags = array(  'email' => array(   'htmlopen'  => 'a',
                                                    'htmlclose' => 'a',
                                                    'allowed'   => 'none^img',
                                                    'attributes'=> array('email' =>'href=%2$smailto:%1$s%2$s')

                                               )
                              );


    /**
    * Executes statements before the actual array building starts
    *
    * This method should be overwritten in a filter if you want to do
    * something before the parsing process starts. This can be useful to
    * allow certain short alternative tags which then can be converted into
    * proper tags with preg_replace() calls.
    * The main class walks through all the filters and and calls this
    * method if it exists. The filters should modify their private $_text
    * variable.
    *
    * @return   none
    * @access   private
    * @see      $_text
    * @author   Stijn de Reede  <sjr@gmx.co.uk>
    */
    function _preparse()
    {
        $options = PP_HTML_BBCodeParser::getStaticProperty('PP_HTML_BBCodeParser','_options');
        $o = $options['open'];
        $c = $options['close'];
        $oe = $options['open_esc'];
        $ce = $options['close_esc'];
        $pattern = array(   "!(^|\s)([-a-z0-9_.]+@[-a-z0-9.]+\.[a-z]{2,4})!i",
                            "!".$oe."email(".$ce."|\s.*".$ce.")(.*)".$oe."/email".$ce."!Ui");
        $replace = array(   "\\1".$o."email=\\2".$c."\\2".$o."/email".$c,
                            $o."email=\\2\\1\\2".$o."/email".$c);
        $this->_preparsed = preg_replace($pattern, $replace, $this->_text);
    }


}

class PP_HTML_BBCodeParser_Filter_Basic extends PP_HTML_BBCodeParser
{

    /**
    * An array of tags parsed by the engine
    *
    * @access   private
    * @var      array
    */
    var $_definedTags = array(  'b' => array(   'htmlopen'  => 'strong',
                                                'htmlclose' => 'strong',
                                                'allowed'   => 'all',
                                                'attributes'=> array()),
                                'i' => array(   'htmlopen'  => 'em',
                                                'htmlclose' => 'em',
                                                'allowed'   => 'all',
                                                'attributes'=> array()),
                                'u' => array(   'htmlopen'  => 'u',
                                                'htmlclose' => 'u',
                                                'allowed'   => 'all',
                                                'attributes'=> array()),
                                's' => array(   'htmlopen'  => 'strike',
                                                'htmlclose' => 'strike',
                                                'allowed'   => 'all',
                                                'attributes'=> array()),
                                'sub' => array( 'htmlopen'  => 'sub',
                                                'htmlclose' => 'sub',
                                                'allowed'   => 'all',
                                                'attributes'=> array()),
                                'sup' => array( 'htmlopen'  => 'sup',
                                                'htmlclose' => 'sup',
                                                'allowed'   => 'all',
                                                'attributes'=> array())
                            );


}

$PP_PARSER_OBJECT = "";

function PP_BBCode($text) {
	global $PP_PARSER_OBJECT;

	if ($PP_PARSER_OBJECT==""){
		$PP_PARSER_OBJECT =& new PP_HTML_BBCodeParser(array(
			'quotestyle'    => 'single',
			'quotewhat'     => 'all',
			'open'          => '[',
			'close'         => ']',
			'xmlclose'      => true,
			'filters'       => 'Basic,Extended,Links,Images,Lists,Email'));
	}
	return $PP_PARSER_OBJECT->qparse($text);
}

?>