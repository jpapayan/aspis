<?php
/*
	Plugin Name: FeedList
	Plugin URI: http://rawlinson.us/blog/articles/feedlist-plugin/
	Description: Displays any ATOM or RSS feed in your blog.
	Author: Bill Rawlinson
	Author URI: http://blog.rawlinson.us/
	Version: 2.61.01
*/

// setup error level
 error_reporting(0);


// use Magpie? or SimplePie?
$useMagPie = true;



 	// include files
			$relroot = ABSPATH . '/';
			require_once('feedListExtensions.php');
			



			if($useMagPie){
			// get the magpie libary
				if (file_exists($relroot . 'wp-includes/rss.php')) {
					require_once($relroot . 'wp-includes/rss.php');
				} else if(file_exists($relroot . 'wp-includes/rss-functions.php')){
					require_once($relroot . 'wp-includes/rss-functions.php');
				} else {
					function FeedListInitError(){
					?>
						<div id="message" style="margin-top: 15px; padding: 10px;" class="updated fade">There was a problem initializing the feedlist plugin.  Make sure the file feedlist.php is in the feedList directory under your <strong>wp-content/plugins</strong> directory.</div>
					<?php
					}
				}
			} else{
				require_once('simplepie.php');
			}
		// end
	// end

	
	
	class FeedList {
			var $dateFormat = "F j, Y, g:i a";
			var $id;
			var $items;
			var $rs;
			var $args;
			var $feed;
			var $output;

			function FeedList($args){
				$this->args = $args;

				$this->id = md5(uniqid(rand(), true));
			}

			function GetID(){
				$this->Debug($this->id);
			}

		/* core methods */
			// called automagically if you use an inline filter (inside a post/page).
			function FeedListFilter(){

				return $this->BuildFeedOutput();
			}


			// call this if you want to process one feed
			function FeedListFeed(){
				echo $this->BuildFeedOutput();
			}

			// call this if you want to process a feed file
			function FeedListFile(){

				$this->args = $this->GetArgumentArray();
				$this->output = '';
				// Seed the random number generator:
				srand((double)microtime()*1000000);

				$feed = Array();

				$feedInfo = $this->LoadFile($this->args['file']);
				if(count($feedInfo)){ // we have some feeds
					// Randomize the array:
					shuffle($feedInfo);
					// Make sure we are set to show something:
					($this->args['feedsToShow'] < 1) ? 1 : $this->args['feedsToShow'];
					($this->args['feedsToShow'] > sizeof($feedInfo)) ? sizeof($feedInfo) : $this->args['feedsToShow'];


					// we will fetch each feed, then coallate items
					for($i=0;$i<$this->args['feedsToShow'];$i++){

						$thisFeed = $feedInfo[$i];

						$urlAndTitle =  preg_split("/~/", $thisFeed);
						$feedUrl = trim($urlAndTitle[0]);
						$feedTitle = trim($urlAndTitle[1]);
						
						$this->rs = $this->GetFeed($feedUrl);

						if($this->items){
							if($this->args['random']){
								shuffle($this->items);
							}
							// Slice off the number of items that we want:
							if ($this->args['num_items'] > 0 && is_array($this->items))
							{
								$this->items = array_slice($this->items, 0, $this->args['num_items']);
							}

							if(!$this->args['mergeFeeds']){
								$this->output.= '<div class="feedTitle">'.$feedTitle.'</div>';
								if($this->args['show_date']){
									$this->output .= '<div class="feedDate">updated: '.
									$this->NormalizeDate($this->rs) . '</div>';	
			//						fl_tz_convert($this->rs->last_modified,0,Date('I')).'</div>';
								}

								$this->output.=$this->Draw($this->items,$this->args);
							} else {
								$feed = array_merge($feed,$this->items);
							}

						}

					}
				$this->output .= '<ul class="randomFeed">';

				if($this->args['mergeFeeds']){
					$this->output.=$this->Draw($feed,$this->args);
				} 
			
				$this->output .= '</ul>';


				} else {
					$this->output = $this->args['before'] . 'No Items Were Found In the Provided Feeds. Perhaps there is a communication problem.' . $this->args['after'];
				}

				// coallate feed items
				return $this->output;

			}
		/* end core methods */



		/* basic settings - you can edit these */
			function GetSettings(){
							/*
					CONFIGURATION SETTINGS
					----------------------

					cacheTimeout		how long should your cache file live in seconds?  By default it is 21600 or 6 hours.
								most sites prefer you use caching so please make sure you do!

					connectionTimeout	how long should I try to connect the feed provider before I give up, default is 15 seconds


					showRssLinkListJS	TRUE by default and will include a small block of JS in your header.  If it is false the JS will not be
								included. If you want the $new_window = 'true' option to use the JS then this must also be true.
								Otherwise both true and simple will hardcode the target="_blank" into the new window links
				*/

				// DEFINE THE SETTINGS -- EDIT AS YOU NEED:
				$feedListDebug = false; // To debug this script during programming (true/false).

				$cacheTimeout = 21600;		// 21600 sec is 6 hours.
				$connectionTimeout = 15;	// 15 seconds is default
				$showRSSLinkListJS = true;
				
				$Language = 'en_US'; // Choose your language (from the available languages below,in the translations):
				
				
				$Translations = array(); // Please send in your suggestions/translations:

					// English:
					$Translations['en_US'] = array();
					$Translations['en_US']['ReadMore']		= 'Read more...';

					// Dutch:
					$Translations['nl_NL'] = array();
					$Translations['nl_NL']['ReadMore']		= '[lees verder]';

					// French:
					$Translations['fr_FR'] = array();
					$Translations['fr_FR']['ReadMore'] = 'Lisez davantage';
				
				$feedListFile = ABSPATH .  'wp-content\plugins\feeds.txt'; // IF you are going to use the random feedlist generator make sure this holds the correct name for your feed file:

				// Build an array out of the settings and send them back:
				$settings = array (	'feedListDebug' => $feedListDebug,
							'cacheTimeout' => $cacheTimeout,
							'connectionTimeout' => $connectionTimeout,
							'showRSSLinkListJS' => $showRSSLinkListJS,
							'language' => $Language,
							'translations' => $Translations,
							'feedListFile' => $feedListFile
				);

				return $settings;

			}

			function GetDefaults(){
				$settings = $this->GetSettings();
				return array(	'rss_feed_url' => 'http://del.icio.us/rss',
							'num_items' => 15,
							'show_description' => true,
							'random' => false,
							'before' => '<li>',
							'after' => '</li>',
							'description_separator' => ' - ',
							'encoding' => false,
							'sort' => 'none',
							'new_window' => false,
							'ignore_cache' => false,
							'suppress_link' => false,
							'show_date' => false,
							'additional_fields' => '',
							'max_characters' => 0,
							'max_char_wordbreak' => true,
							'file'=>$settings['feedListFile'],
							'feedsToShow'=>0,
							'itemsPerFeed'=>1,
							'mergeFeeds'=>false,
							'show_date_per_item' => false,
							'show_description_only' => false,
							'no_follow_on' => false,
							'language'=> $settings['language']
						);
			
			}
		/* end basic settings */
			function BuildFeedOutput(){
				$this->args = $this->GetArgumentArray();


				$this->rs = $this->GetFeed($this->args['rss_feed_url']);


				$this->output = '';
				if($this->items){
					if($this->args['random']){
						shuffle($this->items);
					}
					// Slice off the number of items that we want:
					if ($this->args['num_items'] > 0 && is_array($this->items))
					{
						$this->items = array_slice($this->items, 0, $this->args['num_items']);
					}


					$this->output = $this->Draw();
				}


				return $this->output;
			}


			function Draw(){

				$settings = $this->GetSettings();
				$this->items = $this->NormalizeDates($this->items);
				$this->items = $this->SortItems($this->items,$this->args['sort']);

				// Explicitly set this because $new_window could be "simple":
				$target = '';
				if($this->args["new_window"] == true && $settings["showRSSLinkListJS"])
				{
					$target=' rel="external" ';
				}
				elseif ($this->args["new_window"] == true || $settings["new_window"] == 'simple')
				{
					$target=' target="_blank" ';
				}


				$noFollowFlag = $this->args["no_follow_on"] ? 'rel="nofollow" ' : '';

				$this->output ='';

				foreach($this->items as $item){
					$thisLink = '';
					$linkTitle = '';
					$thisDescription = '';
					$thisTitle = $item['title'];
					$thisItemDate = '';

					if($this->args['show_description_only']){
						$this->args['show_description'] = true;
					}

					if ($this->args['encoding']){ // very poor and limited internationalization effort
						$thisTitle = htmlentities(utf8_decode($thisTitle));
					}

					if (isset($item['content']['encoded']) || isset($item['description'])){
						if (isset($item['description'])){
							$thisDescription = $item['description'];
						}
						else{
							$thisDescription = $item['content']['encoded'];
						}
						
						// Handle max_characters and max_char_wordbreak before the htmlentities makes it more complicated:
						if (!empty($this->args['max_characters']) && is_numeric($this->args['max_characters']))
						{
							$thisDescription = substr($thisDescription, 0, $this->args['max_characters']);

							// If true, we cut on the last space:
							if (!empty($this->args['max_char_wordbreak']))
							{
								$max_char_pos = strrpos($thisDescription, ' ');
								if ($max_char_pos > 0)
								{
									$thisDescription = substr($thisDescription, 0, $max_char_pos);
								}
							} 

						} else if ($encoding) { 
							//further really weak attempt at internationalization
							$thisDescription = html_entity_decode($thisDescription, ENT_QUOTES, "UTF-8");
						}

						$linkTitle = $thisDescription;
						$linkTitle = strip_tags($linkTitle);
						$linkTitle = str_replace(array("\n", "\t", '"'), array('', '', "'"), $linkTitle);
						$linkTitle = substr($linkTitle, 0, 300);
	
						// if we are only showing the description we don't need the separator..
						if (strlen(trim($thisDescription)) && !$this->args['show_description_only'])
						{
							$thisDescription = $this->args['description_separator'].$thisDescription;
						}
					}

					// Only build the hyperlink if a link is provided..and we are not told to suppress the link:
					if (!$this->args['suppress_link'] && strlen(trim($item['link'])) && strlen(trim($thisTitle)) && !$this->args['show_description_only']){
						$thisLink = '<span class="rssLinkListItemTitle"><a ' . $noFollowFlag . 'href="'.htmlentities(utf8_decode(transfromLinkURL($item['link']))).'"' . $target .' title="'.$linkTitle.'">'.$thisTitle.'</a></span>';
					}
					elseif (strlen(trim($item['link'])) && $this->args['show_description'] && !$this->args['suppress_link'])
					{
						// If we don't have a title but we do have a description we want to show.. link the description
						$thisLink = '<span class="rssLinkListItemTitle"><a ' . $noFollowFlag . 'href="'.htmlentities(utf8_decode(transfromLinkURL($item['link']))).'"' . $target .'><span class="rssLinkListItemDesc">'.$thisDescription.'</span></a></span>';
						$thisDescription = '';
					}
					elseif(!$this->args['show_description_only'])
					{
						$thisLink = '<span class="rssLinkListItemTitle">' . $thisTitle . '</span>';
					} else {
						$thisLink = '<span class="rssLinkListItemDesc">' . $thisDescription . '</span>';
					}


					if($this->args['show_date_per_item']){
						$thisItemDate =  '<div class="feedItemDate">' . $item['feeddate'] . '</div>';
					}

					// Determine if any extra data should be shown:
					$extraData = '';
					if (strlen($this->args['additional_fields'])){
						// Magpie converts all key names to lowercase so we do too:
						$this->args['additional_fields'] = strtolower($this->args['additional_fields']);

						// Get each additional field:
						$addFields = explode('~', $this->args['additional_fields']);

						foreach ($addFields as $addField)
						{
							// Determine if the field was a nested field:
							$fieldDef = explode('.', $addField);
							$thisNode = $item;
							foreach($fieldDef as $fieldName)
							{
								// Check to see if the fieldName has a COLON in it, if so then we are referencing an array:
								$thisField = explode(':', $fieldName);
								$fieldName = $thisField[0];

								$thisNode = $thisNode[$fieldName];
								if (count($thisField) == 2)
								{
									$fieldName = $thisField[1];
									$thisNode = $thisNode[$fieldName];
								}
							}
							if (is_string($thisNode) && isset($thisNode))
							{
								$extraData .= '<div class="feedExtra'.str_replace(".","",$addField).'">' . $thisNode . '</div>';
							}
						}
					}

					if($this->args['show_description_only']){
						$this->output .= $this->args['before'].$thisLink.$thisItemDate.$extraData;

					} else if ($this->args['show_description']){
						$this->output .= $this->args['before'].$thisLink.$thisItemDate.$thisDescription.$extraData;
					}else{
						$this->output .= $this->args['before'].$thisLink.$thisItemDate.$extraData;
					}
					if (is_numeric($this->args['max_characters']) && $this->args['max_characters'] > 0) {
						$this->output .= '<div class="ReadMoreLink"><a ' . $target .' href="'.htmlentities(utf8_decode(transfromLinkURL($item['link']))).' ">'.$settings["translations"][$this->args["language"]]['ReadMore'].'</a> &nbsp; </div>';
					}

					$this->output .= $this->args['after'];
				}

				return $this->output;
			}

			function ArrayPush(&$arr) {
			   $args = func_get_args();
			   foreach ($args as $arg) {
				   if (is_array($arg)) {
					   foreach ($arg as $key => $value) {
						   $arr[$key] = $value;
						   $ret++;
					   }
				   }else{
					   $arr[$arg] = "";
				   }
			   }
			   return $ret;
			}
		/* utility functions */

			function NormalizeDates(){
				$newItems = array();

				foreach($this->items as $item){
					$this->ArrayPush($item,array("feeddate"=>$this->NormalizeDate($item)));
					array_push($newItems,$item);
				}
				return $newItems;
			} 

			function NormalizeDate($item){
				$d="";
				if(array_key_exists('pubdate',$item)) {
						$d = date($this->dateFormat,strtotime($item['pubdate']));
				} else if (array_key_exists('published',$item)) {
						$d = date($this->dateFormat,strtotime($item['published']));
				} else if (array_key_exists('dc',$item) && array_key_exists('date',$item['dc'])) {
						$d = date($this->dateFormat,strtotime($item['dc']['date']));
				} else if (array_key_exists('last_modified',$item)) {
						$d = $this->TimezoneConvert($item['last_modified'],0,Date('I'));
				} else {
						$d = date($this->dateFormat);
				}
				return $d;
			}

			function TimezoneConvert($datetime,$tz_from,$tz_to,$format='d M Y h:ia T'){
			   return date($format,strtotime($datetime)+(3600*($tz_to - $tz_from)));
			} 

			function MakeNumericOnly($val){
				return ereg_replace( '[^0-9]+', '', $val);
			}


			function GetMonthNum($month){
				$months = array('jan'=>'01','feb'=>'02','mar'=>'03','apr'=>'04','may'=>'05','jun'=>'06','jul'=>'07','aug'=>'08','sep'=>'09','oct'=>'10','nov'=>'11','dec'=>'12');
				$month = strtolower($month);
				return $months[$month];
			}

			function SortItems(){
				$sort = strtolower($this->args['sort']);
				$sort = explode(" ",$sort);

				if((count($sort) ==1 || $sort[0] == 'asc') && $sort[0] != 'none'){
					$sort[1] = SORT_ASC;
				} elseif ($sort[1] == 'desc') {
					$sort[1] = SORT_DESC;
				} else {
					$sort[1] = '';
				}

				if($sort[0] == 'feeddate'){
					$sort[2] = SORT_NUMERIC;
				} else {
					$sort[2] = SORT_STRING;
				}
				if (($sort[1]!='') && count($this->items))
				{
					// Order  by sortCol:
					foreach($this->items as $item)
					{
						$sortBy[] = $item[$sort[0]];
					}

					// Make titles lowercase (otherwise capitals will come before lowercase):
					$sortByLower = array_map('strtolower', $sortBy);

					array_multisort($sortByLower, $sort[1], $sort[2], $this->items);
				}
				
				return $this->items;
			}

			function LoadFile($file){
				/*	
					load the $feedListFile  contents into an array, using the --NEXT-- text as
					a delimeter between feeds and a tilde (~) between URL and TITLE
				*/
				$x = file($file);
				return preg_split("/--NEXT--/", join('', $x));
			}

			function GetArgumentArray(){
				$this->args = $this->AssignDefaults();
				$a = array();
				foreach($this->args as $d=>$v){
					if($this->args[$d] === 'true') { 
						$a[$d] = 1;
					}else if($this->args[$d] === 'false'){
						$a[$d] = 0;
					}else{
						$a[$d] = $v;
					}

					$a[$d] =  html_entity_decode($a[$d]);

				}

				return $a;
			}


			function AssignDefaults(){
				$defaults = $this->GetDefaults();
				$a = array();
				$i=0;

				foreach ($defaults as $d => $v)
				{
					$a[$d] = isset($this->args[$d]) ? $this->args[$d] : $v;
					$a[$d] = isset($this->args[$i]) ? $this->args[$i] : $a[$d];
					$i++;
				}

				return $a;
			}

			function GetFeed($feedUrl){
				$this->feed = false;
				if(function_exists('fetch_rss')){
					$this->feed =  fetch_rss($feedUrl);
					if($this->feed){
						$this->items = $this->feed->items;
					}
				}elseif(function_exists('simplepie_fetch_rss')) {
					$this->feed = simplepie_fetch_rss($feedUrl,!$this->args['ignore_cache'],$settings["cacheTimeout"]);
					if($this->feed){
						$this->items = $this->feed["items"];
					}
				}else {
					print ('rss functionality not available');
				}
				return $this->feed;
				
			}

			function InitializeReader($ignore_cache){
				$settings = $this->GetSettings();

				if ($ignore_cache)
				{
					if (is_numeric($ignore_cache))
					{
						define('MAGPIE_CACHE_AGE', $ignore_cache);
					}
					else
					{
						define('MAGPIE_CACHE_ON', false);
					}
				}
				else
				{
					define('MAGPIE_CACHE_AGE', $settings["cacheTimeout"]);
				}
				define('MAGPIE_DEBUG', false);
				define('MAGPIE_FETCH_TIME_OUT', $settings["connectionTimeout"]);
			}

			function Debug($val,$name=''){
				if(strlen($name)){
					print('<h1>'.$name.'</h1>');
				}
				print('<pre>');
				print_r($val);
				print('</pre>');
			}

		/* end utility functions */

	}

		function rssLinkListFilter($text)
		{
			return preg_replace_callback("/<!--rss:(.*)-->/", "feedListFilter", $text);
		}
		function rssLinkListFileFilter($text)
		{
			return preg_replace_callback("/<!--rssFile:(.*)-->/", "feedListFileFilter", $text);
		}


	/* Templates can call any of these functions */
		function rssLinkList($args){
			if(!is_array($args)){
				$args = func_get_args();
			}
			return feedList($args);
		}
		function feedList($args){
			if(!is_array($args)){
				$args = func_get_args();
			}

			$feed = new FeedList($args);

			return $feed->FeedListFeed();
		}

		function randomFeedList($args){
				echo processRandomFeedList($args);
		}

		function processRandomFeedList($args){
			if(!is_array($args)){
				$args = parse_str($args,$a);
				$args = $a;
			}
			$feed = new FeedList($args);
			$feed->Debug("called");
			return $feed->FeedListFile();
		}
		
		function feedListFilter($args){
			$args = explode(",",$args[1]);


			if(count($args) == 1 && !strpos($args[0],":=")){
				$a = array();
				$a["rss_feed_url"] = $args[0];
				$args = $a;
			} else {
				$a = array();
				foreach($args as $arg){
					$arg = explode(":=",$arg);
					$a[$arg[0]] = $arg[1];
				}
				$args = $a;

			}

			$feed = new FeedList($args);
			return $feed->FeedListFilter();
		}

		function feedListFileFilter($args){
			$args = explode(",",$args[1]);


			if(count($args) == 1 && !strpos($args[0],":=")){
				$a = array();
				$a["file"] = $args[0];
				$args = $a;
			} else {
				$a = array();
				foreach($args as $arg){
					$arg = explode(":=",$arg);
					$a[$arg[0]] = $arg[1];
				}
				$args = $a;

			}

			return processRandomFeedList($args);

		}

	/* end template functions */

		if (function_exists('add_filter'))
		{
			add_filter('the_content', 'rssLinkListFilter');
			add_filter('the_content', 'rssLinkListFileFilter');
		}

		if(function_exists('FeedListInitError')){
			add_action('admin_head','FeedListInitError');
		}


		
		if(function_exists('register_deactivation_hook'))
		{
			register_deactivation_hook(__FILE__, 'cleanupFeedlistCache'); 
		}

		function cleanupFeedListCache(){
			global $wpdb;
			$sql = "delete from wp_options WHERE option_name like 'rss_%'";
			$wpdb->query( $sql );
		}


if(function_exists('add_action')) { 
	      function rssLinkList_JS(){ 
	 
	            $jsstring = '<script type="text/javascript"><!-- 
	 
	            function addEvent(elm, evType, fn, useCapture) 
	            // addEvent and removeEvent 
	            // cross-browser event handling for IE5+,  NS6 and Mozilla 
	            // By Scott Andrew 
	            { 
	              if (elm.addEventListener){ 
	                  elm.addEventListener(evType, fn, useCapture); 
	                  return true; 
	              } else if (elm.attachEvent){ 
	                  var r = elm.attachEvent("on"+evType, fn); 
	                  return r; 
	              } else { 
	                  // alert("Handler could not be removed"); 
	              } 
	            }  
	            function externalLinks() { 
	             if (!document.getElementsByTagName) return; 
	             var anchors = document.getElementsByTagName("a"); 
				 var newwindows =0;
	             for (var i=0; i<anchors.length; i++) { 
	               var anchor = anchors[i]; 
	               if (anchor.getAttribute("href") && anchor.getAttribute("rel") == "external") {
	                        anchor.setAttribute("target","_blank"); 
							newwindows++;
					}
	             } 
	            } 
	 
	            addEvent(window, "load", externalLinks); 

	            //--> 
	            </script> 
	            '; 
	 
	 
	            echo $jsstring; 
	      }


	$jsFeed = new FeedList('');
	$settings = $jsFeed->GetSettings();
	 
	if($settings["showRSSLinkListJS"]){ 
		  add_action('wp_head', 'rssLinkList_JS'); 
	} 
}
	 
	 
?>
