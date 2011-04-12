<?php require_once('AspisMain.php'); ?><?php
define(('MAX_RESULTS'),50);
define(('MAX_EXECUTION_TIME'),20);
define(('STATUS_INTERVAL'),3);
class Blogger_Import{function greet (  ) {
{$next_url = concat2(get_option(array('siteurl',false)),'/wp-admin/index.php?import=blogger&amp;noheader=true');
$auth_url = array("https://www.google.com/accounts/AuthSubRequest",false);
$title = __(array('Import Blogger',false));
$welcome = __(array('Howdy! This importer allows you to import posts and comments from your Blogger account into your WordPress blog.',false));
$prereqs = __(array('To use this importer, you must have a Google account and an upgraded (New, was Beta) blog hosted on blogspot.com or a custom domain (not FTP).',false));
$stepone = __(array('The first thing you need to do is tell Blogger to let WordPress access your account. You will be sent back here after providing authorization.',false));
$auth = esc_attr__(array('Authorize',false));
echo AspisCheckPrint(concat(concat1("
		<div class='wrap'>
		",screen_icon()),concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("
		<h2>",$title),"</h2>
		<p>"),$welcome),"</p><p>"),$prereqs),"</p><p>"),$stepone),"</p>
			<form action='"),$auth_url),"' method='get'>
				<p class='submit' style='text-align:left;'>
					<input type='submit' class='button' value='"),$auth),"' />
					<input type='hidden' name='scope' value='http://www.blogger.com/feeds/' />
					<input type='hidden' name='session' value='1' />
					<input type='hidden' name='secure' value='0' />
					<input type='hidden' name='next' value='"),$next_url),"' />
				</p>
			</form>
		</div>\n")));
} }
function uh_oh ( $title,$message,$info ) {
{echo AspisCheckPrint(array("<div class='wrap'>",false));
screen_icon();
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1("<h2>",$title),"</h2><p>"),$message),"</p><pre>"),$info),"</pre></div>"));
} }
function auth (  ) {
{$token = Aspis_preg_replace(array('/[^-_0-9a-zA-Z]/',false),array('',false),$_GET[0]['token']);
$headers = array(array(array("GET /accounts/AuthSubSessionToken HTTP/1.0",false),concat2(concat1("Authorization: AuthSub token=\"",$token),"\"")),false);
$request = concat2(Aspis_join(array("\r\n",false),$headers),"\r\n\r\n");
$sock = $this->_get_auth_sock();
if ( (denot_boolean($sock)))
 return array(false,false);
$response = $this->_txrx($sock,$request);
Aspis_preg_match(array('/token=([-_0-9a-z]+)/i',false),$response,$matches);
if ( ((empty($matches[0][(1)]) || Aspis_empty( $matches [0][(1)]))))
 {$this->uh_oh(__(array('Authorization failed',false)),__(array('Something went wrong. If the problem persists, send this info to support:',false)),Aspis_htmlspecialchars($response));
return array(false,false);
}$this->token = attachAspis($matches,(1));
wp_redirect(remove_query_arg(array(array(array('token',false),array('noheader',false)),false)));
} }
function get_token_info (  ) {
{$headers = array(array(array("GET /accounts/AuthSubTokenInfo  HTTP/1.0",false),concat2(concat1("Authorization: AuthSub token=\"",$this->token),"\"")),false);
$request = concat2(Aspis_join(array("\r\n",false),$headers),"\r\n\r\n");
$sock = $this->_get_auth_sock();
if ( (denot_boolean($sock)))
 return ;
$response = $this->_txrx($sock,$request);
return $this->parse_response($response);
} }
function token_is_valid (  ) {
{$info = $this->get_token_info();
if ( (deAspis($info[0]['code']) == (200)))
 return array(true,false);
return array(false,false);
} }
function show_blogs ( $iter = array(0,false) ) {
{if ( ((empty($this->blogs) || Aspis_empty( $this ->blogs ))))
 {$headers = array(array(array("GET /feeds/default/blogs HTTP/1.0",false),array("Host: www.blogger.com",false),concat2(concat1("Authorization: AuthSub token=\"",$this->token),"\"")),false);
$request = concat2(Aspis_join(array("\r\n",false),$headers),"\r\n\r\n");
$sock = $this->_get_blogger_sock();
if ( (denot_boolean($sock)))
 return ;
$response = $this->_txrx($sock,$request);
list($headers,$xml) = deAspisList(Aspis_explode(array("\r\n\r\n",false),$response),array());
$p = array(xml_parser_create(),false);
AspisInternalFunctionCall("xml_parse_into_struct",$p[0],$xml[0],AspisPushRefParam($vals),AspisPushRefParam($index),array(2,3));
xml_parser_free(deAspisRC($p));
$this->title = $vals[0][deAspis(attachAspis($index[0][('TITLE')],(0)))][0]['value'];
if ( ((empty($index[0][('ENTRY')]) || Aspis_empty( $index [0][('ENTRY')]))))
 {if ( ($iter[0] < (3)))
 {return $this->show_blogs(array($iter[0] + (1),false));
}else 
{{$this->uh_oh(__(array('Trouble signing in',false)),__(array('We were not able to gain access to your account. Try starting over.',false)),array('',false));
return array(false,false);
}}}foreach ( deAspis($index[0]['ENTRY']) as $i  )
{$blog = array(array(),false);
while ( (deAspis(($tag = attachAspis($vals,$i[0]))) && (!((deAspis($tag[0]['tag']) == ('ENTRY')) && (deAspis($tag[0]['type']) == ('close'))))) )
{if ( (deAspis($tag[0]['tag']) == ('TITLE')))
 {arrayAssign($blog[0],deAspis(registerTaint(array('title',false))),addTaint($tag[0]['value']));
}elseif ( (deAspis($tag[0]['tag']) == ('SUMMARY')))
 {deAspis($blog[0]['summary']) == deAspis($tag[0]['value']);
}elseif ( (deAspis($tag[0]['tag']) == ('LINK')))
 {if ( ((deAspis($tag[0][('attributes')][0]['REL']) == ('alternate')) && (deAspis($tag[0][('attributes')][0]['TYPE']) == ('text/html'))))
 {$parts = Aspis_parse_url($tag[0][('attributes')][0]['HREF']);
arrayAssign($blog[0],deAspis(registerTaint(array('host',false))),addTaint($parts[0]['host']));
}elseif ( (deAspis($tag[0][('attributes')][0]['REL']) == ('edit')))
 arrayAssign($blog[0],deAspis(registerTaint(array('gateway',false))),addTaint($tag[0][('attributes')][0]['HREF']));
}preincr($i);
}if ( (!((empty($blog) || Aspis_empty( $blog)))))
 {arrayAssign($blog[0],deAspis(registerTaint(array('total_posts',false))),addTaint($this->get_total_results(array('posts',false),$blog[0]['host'])));
arrayAssign($blog[0],deAspis(registerTaint(array('total_comments',false))),addTaint($this->get_total_results(array('comments',false),$blog[0]['host'])));
arrayAssign($blog[0],deAspis(registerTaint(array('mode',false))),addTaint(array('init',false)));
arrayAssignAdd($this->blogs[0][],addTaint($blog));
}}if ( ((empty($this->blogs) || Aspis_empty( $this ->blogs ))))
 {$this->uh_oh(__(array('No blogs found',false)),__(array('We were able to log in but there were no blogs. Try a different account next time.',false)),array('',false));
return array(false,false);
}}$start = esc_js(__(array('Import',false)));
$continue = esc_js(__(array('Continue',false)));
$stop = esc_js(__(array('Importing...',false)));
$authors = esc_js(__(array('Set Authors',false)));
$loadauth = esc_js(__(array('Preparing author mapping form...',false)));
$authhead = esc_js(__(array('Final Step: Author Mapping',false)));
$nothing = esc_js(__(array('Nothing was imported. Had you already imported this blog?',false)));
$stopping = array('',false);
$title = __(array('Blogger Blogs',false));
$name = __(array('Blog Name',false));
$url = __(array('Blog URL',false));
$action = __(array('The Magic Button',false));
$posts = __(array('Posts',false));
$comments = __(array('Comments',false));
$noscript = __(array('This feature requires Javascript but it seems to be disabled. Please enable Javascript and then reload this page. Don&#8217;t worry, you can turn it back off when you&#8217;re done.',false));
$interval = array(STATUS_INTERVAL * (1000),false);
foreach ( $this->blogs[0] as $i =>$blog )
{restoreTaint($i,$blog);
{if ( (deAspis($blog[0]['mode']) == ('init')))
 $value = $start;
elseif ( ((deAspis($blog[0]['mode']) == ('posts')) || (deAspis($blog[0]['mode']) == ('comments'))))
 $value = $continue;
else 
{$value = $authors;
}$value = esc_attr($value);
$blogtitle = esc_js($blog[0]['title']);
$pdone = ((isset($blog[0][('posts_done')]) && Aspis_isset( $blog [0][('posts_done')]))) ? int_cast($blog[0]['posts_done']) : array(0,false);
$cdone = ((isset($blog[0][('comments_done')]) && Aspis_isset( $blog [0][('comments_done')]))) ? int_cast($blog[0]['comments_done']) : array(0,false);
$init = concat($init,concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("blogs[",$i),"]=new blog("),$i),",'"),$blogtitle),"','"),$blog[0]['mode']),"',"),$this->get_js_status($i)),');'));
$pstat = concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<div class='ind' id='pind",$i),"'>&nbsp;</div><div id='pstat"),$i),"' class='stat'>"),$pdone),"/"),$blog[0]['total_posts']),"</div>");
$cstat = concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<div class='ind' id='cind",$i),"'>&nbsp;</div><div id='cstat"),$i),"' class='stat'>"),$cdone),"/"),$blog[0]['total_comments']),"</div>");
$rows = concat($rows,concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<tr id='blog",$i),"'><td class='blogtitle'>"),$blogtitle),"</td><td class='bloghost'>"),$blog[0]['host']),"</td><td class='bar'>"),$pstat),"</td><td class='bar'>"),$cstat),"</td><td class='submit'><input type='submit' class='button' id='submit"),$i),"' value='"),$value),"' /><input type='hidden' name='blog' value='"),$i),"' /></td></tr>\n"));
}}echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<div class='wrap'><h2>",$title),"</h2><noscript>"),$noscript),"</noscript><table cellpadding='5px'><thead><tr><td>"),$name),"</td><td>"),$url),"</td><td>"),$posts),"</td><td>"),$comments),"</td><td>"),$action),"</td></tr></thead>\n"),$rows),"</table></div>"));
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("
		<script type='text/javascript'>
		/* <![CDATA[ */
			var strings = {cont:'",$continue),"',stop:'"),$stop),"',stopping:'"),$stopping),"',authors:'"),$authors),"',nothing:'"),$nothing),"'};
			var blogs = {};
			function blog(i, title, mode, status){
				this.blog   = i;
				this.mode   = mode;
				this.title  = title;
				this.status = status;
				this.button = document.getElementById('submit'+this.blog);
			};
			blog.prototype = {
				start: function() {
					this.cont = true;
					this.kick();
					this.check();
				},
				kick: function() {
					++this.kicks;
					var i = this.blog;
					jQuery.post('admin.php?import=blogger&noheader=true',{blog:this.blog},function(text,result){blogs[i].kickd(text,result)});
				},
				check: function() {
					++this.checks;
					var i = this.blog;
					jQuery.post('admin.php?import=blogger&noheader=true&status=true',{blog:this.blog},function(text,result){blogs[i].checkd(text,result)});
				},
				kickd: function(text, result) {
					if ( result == 'error' ) {
						// TODO: exception handling
						if ( this.cont )
							setTimeout('blogs['+this.blog+'].kick()', 1000);
					} else {
						if ( text == 'done' ) {
							this.stop();
							this.done();
						} else if ( text == 'nothing' ) {
							this.stop();
							this.nothing();
						} else if ( text == 'continue' ) {
							this.kick();
						} else if ( this.mode = 'stopped' )
							jQuery(this.button).attr('value', strings.cont);
					}
					--this.kicks;
				},
				checkd: function(text, result) {
					if ( result == 'error' ) {
						// TODO: exception handling
					} else {
						eval('this.status='+text);
						jQuery('#pstat'+this.blog).empty().append(this.status.p1+'/'+this.status.p2);
						jQuery('#cstat'+this.blog).empty().append(this.status.c1+'/'+this.status.c2);
						this.update();
						if ( this.cont || this.kicks > 0 )
							setTimeout('blogs['+this.blog+'].check()', "),$interval),");
					}
					--this.checks;
				},
				update: function() {
					jQuery('#pind'+this.blog).width(((this.status.p1>0&&this.status.p2>0)?(this.status.p1/this.status.p2*jQuery('#pind'+this.blog).parent().width()):1)+'px');
					jQuery('#cind'+this.blog).width(((this.status.c1>0&&this.status.c2>0)?(this.status.c1/this.status.c2*jQuery('#cind'+this.blog).parent().width()):1)+'px');
				},
				stop: function() {
					this.cont = false;
				},
				done: function() {
					this.mode = 'authors';
					jQuery(this.button).attr('value', strings.authors);
				},
				nothing: function() {
					this.mode = 'nothing';
					jQuery(this.button).remove();
					alert(strings.nothing);
				},
				getauthors: function() {
					if ( jQuery('div.wrap').length > 1 )
						jQuery('div.wrap').gt(0).remove();
					jQuery('div.wrap').empty().append('<h2>"),$authhead),"</h2><h3>' + this.title + '</h3>');
					jQuery('div.wrap').append('<p id=\"auth\">"),$loadauth),"</p>');
					jQuery('p#auth').load('index.php?import=blogger&noheader=true&authors=1',{blog:this.blog});
				},
				init: function() {
					this.update();
					var i = this.blog;
					jQuery(this.button).bind('click', function(){return blogs[i].click();});
					this.kicks = 0;
					this.checks = 0;
				},
				click: function() {
					if ( this.mode == 'init' || this.mode == 'stopped' || this.mode == 'posts' || this.mode == 'comments' ) {
						this.mode = 'started';
						this.start();
						jQuery(this.button).attr('value', strings.stop);
					} else if ( this.mode == 'started' ) {
						return false; // let it run...
						this.mode = 'stopped';
						this.stop();
						if ( this.checks > 0 || this.kicks > 0 ) {
							this.mode = 'stopping';
							jQuery(this.button).attr('value', strings.stopping);
						} else {
							jQuery(this.button).attr('value', strings.cont);
						}
					} else if ( this.mode == 'authors' ) {
						document.location = 'index.php?import=blogger&authors=1&blog='+this.blog;
						//this.mode = 'authors2';
						//this.getauthors();
					}
					return false;
				}
			};
			"),$init),"
			jQuery.each(blogs, function(i, me){me.init();});
		/* ]]> */
		</script>\n"));
} }
function have_time (  ) {
{global $importer_started;
if ( ((time() - $importer_started[0]) > MAX_EXECUTION_TIME))
 Aspis_exit(array('continue',false));
return array(true,false);
} }
function get_total_results ( $type,$host ) {
{$headers = array(array(concat2(concat1("GET /feeds/",$type),"/default?max-results=1&start-index=2 HTTP/1.0"),concat1("Host: ",$host),concat2(concat1("Authorization: AuthSub token=\"",$this->token),"\"")),false);
$request = concat2(Aspis_join(array("\r\n",false),$headers),"\r\n\r\n");
$sock = $this->_get_blogger_sock($host);
if ( (denot_boolean($sock)))
 return ;
$response = $this->_txrx($sock,$request);
$response = $this->parse_response($response);
$parser = array(xml_parser_create(),false);
AspisInternalFunctionCall("xml_parse_into_struct",$parser[0],deAspis($response[0]['body']),AspisPushRefParam($struct),AspisPushRefParam($index),array(2,3));
xml_parser_free(deAspisRC($parser));
$total_results = $struct[0][deAspis(attachAspis($index[0][('OPENSEARCH:TOTALRESULTS')],(0)))][0]['value'];
return int_cast($total_results);
} }
function import_blog ( $blogID ) {
{global $importing_blog;
$importing_blog = $blogID;
if ( ((isset($_GET[0][('authors')]) && Aspis_isset( $_GET [0][('authors')]))))
 return print AspisCheckPrint(($this->get_author_form()));
header(('Content-Type: text/plain'));
if ( ((isset($_GET[0][('status')]) && Aspis_isset( $_GET [0][('status')]))))
 Aspis_exit($this->get_js_status());
if ( ((isset($_GET[0][('saveauthors')]) && Aspis_isset( $_GET [0][('saveauthors')]))))
 Aspis_exit($this->save_authors());
$blog = $this->blogs[0][$blogID[0]];
$total_results = $this->get_total_results(array('posts',false),$blog[0]['host']);
arrayAssign($this->blogs[0][$importing_blog[0]][0],deAspis(registerTaint(array('total_posts',false))),addTaint($total_results));
$start_index = array(($total_results[0] - MAX_RESULTS) + (1),false);
if ( ((isset($this->blogs[0][$importing_blog[0]][0][('posts_start_index')]) && Aspis_isset( $this ->blogs [0][$importing_blog[0]] [0][('posts_start_index')] ))))
 $start_index = int_cast($this->blogs[0][$importing_blog[0]][0][('posts_start_index')]);
elseif ( ($total_results[0] > MAX_RESULTS))
 $start_index = array(($total_results[0] - MAX_RESULTS) + (1),false);
else 
{$start_index = array(1,false);
}if ( ($start_index[0] > (0)))
 {arrayAssign($this->blogs[0][$importing_blog[0]][0],deAspis(registerTaint(array('mode',false))),addTaint(array('posts',false)));
$query = concat2(concat2(concat1("start-index=",$start_index),"&max-results="),MAX_RESULTS);
do {$index = $struct = $entries = array(array(),false);
$headers = array(array(concat2(concat1("GET /feeds/posts/default?",$query)," HTTP/1.0"),concat1("Host: ",$blog[0]['host']),concat2(concat1("Authorization: AuthSub token=\"",$this->token),"\"")),false);
$request = concat2(Aspis_join(array("\r\n",false),$headers),"\r\n\r\n");
$sock = $this->_get_blogger_sock($blog[0]['host']);
if ( (denot_boolean($sock)))
 return ;
$response = $this->_txrx($sock,$request);
$response = $this->parse_response($response);
Aspis_preg_match_all(array('/<entry[^>]*>.*?<\/entry>/s',false),$response[0]['body'],$matches);
if ( count(deAspis(attachAspis($matches,(0)))))
 {$entries = Aspis_array_reverse(attachAspis($matches,(0)));
foreach ( $entries[0] as $entry  )
{$entry = concat2(concat1("<feed>",$entry),"</feed>");
$AtomParser = array(new AtomParser(),false);
$AtomParser[0]->parse($entry);
$result = $this->import_post($AtomParser[0]->entry);
if ( deAspis(is_wp_error($result)))
 return $result;
unset($AtomParser);
}}else 
{break ;
}$query = array('',false);
$links = Aspis_preg_match_all(array('/<link([^>]*)>/',false),$response[0]['body'],$matches);
if ( count(deAspis(attachAspis($matches,(1)))))
 foreach ( deAspis(attachAspis($matches,(1))) as $match  )
if ( deAspis(Aspis_preg_match(array('/rel=.previous./',false),$match)))
 $query = @Aspis_html_entity_decode(Aspis_preg_replace(array('/^.*href=[\'"].*\?(.+)[\'"].*$/',false),array('$1',false),$match),array(ENT_COMPAT,false),get_option(array('blog_charset',false)));
if ( $query[0])
 {AspisInternalFunctionCall("parse_str",$query[0],AspisPushRefParam($q),array(1));
arrayAssign($this->blogs[0][$importing_blog[0]][0],deAspis(registerTaint(array('posts_start_index',false))),addTaint(int_cast($q[0]['start-index'])));
}else 
{arrayAssign($this->blogs[0][$importing_blog[0]][0],deAspis(registerTaint(array('posts_start_index',false))),addTaint(array(0,false)));
}$this->save_vars();
}while (((!((empty($query) || Aspis_empty( $query)))) && deAspis($this->have_time())) )
;
}$total_results = $this->get_total_results(array('comments',false),$blog[0]['host']);
arrayAssign($this->blogs[0][$importing_blog[0]][0],deAspis(registerTaint(array('total_comments',false))),addTaint($total_results));
if ( ((isset($this->blogs[0][$importing_blog[0]][0][('comments_start_index')]) && Aspis_isset( $this ->blogs [0][$importing_blog[0]] [0][('comments_start_index')] ))))
 $start_index = int_cast($this->blogs[0][$importing_blog[0]][0][('comments_start_index')]);
elseif ( ($total_results[0] > MAX_RESULTS))
 $start_index = array(($total_results[0] - MAX_RESULTS) + (1),false);
else 
{$start_index = array(1,false);
}if ( ($start_index[0] > (0)))
 {arrayAssign($this->blogs[0][$importing_blog[0]][0],deAspis(registerTaint(array('mode',false))),addTaint(array('comments',false)));
$query = concat2(concat2(concat1("start-index=",$start_index),"&max-results="),MAX_RESULTS);
do {$index = $struct = $entries = array(array(),false);
$headers = array(array(concat2(concat1("GET /feeds/comments/default?",$query)," HTTP/1.0"),concat1("Host: ",$blog[0]['host']),concat2(concat1("Authorization: AuthSub token=\"",$this->token),"\"")),false);
$request = concat2(Aspis_join(array("\r\n",false),$headers),"\r\n\r\n");
$sock = $this->_get_blogger_sock($blog[0]['host']);
if ( (denot_boolean($sock)))
 return ;
$response = $this->_txrx($sock,$request);
$response = $this->parse_response($response);
Aspis_preg_match_all(array('/<entry[^>]*>.*?<\/entry>/s',false),$response[0]['body'],$matches);
if ( count(deAspis(attachAspis($matches,(0)))))
 {$entries = Aspis_array_reverse(attachAspis($matches,(0)));
foreach ( $entries[0] as $entry  )
{$entry = concat2(concat1("<feed>",$entry),"</feed>");
$AtomParser = array(new AtomParser(),false);
$AtomParser[0]->parse($entry);
$this->import_comment($AtomParser[0]->entry);
unset($AtomParser);
}}$query = array('',false);
$links = Aspis_preg_match_all(array('/<link([^>]*)>/',false),$response[0]['body'],$matches);
if ( count(deAspis(attachAspis($matches,(1)))))
 foreach ( deAspis(attachAspis($matches,(1))) as $match  )
if ( deAspis(Aspis_preg_match(array('/rel=.previous./',false),$match)))
 $query = @Aspis_html_entity_decode(Aspis_preg_replace(array('/^.*href=[\'"].*\?(.+)[\'"].*$/',false),array('$1',false),$match),array(ENT_COMPAT,false),get_option(array('blog_charset',false)));
AspisInternalFunctionCall("parse_str",$query[0],AspisPushRefParam($q),array(1));
arrayAssign($this->blogs[0][$importing_blog[0]][0],deAspis(registerTaint(array('comments_start_index',false))),addTaint(int_cast($q[0]['start-index'])));
$this->save_vars();
}while (((!((empty($query) || Aspis_empty( $query)))) && deAspis($this->have_time())) )
;
}arrayAssign($this->blogs[0][$importing_blog[0]][0],deAspis(registerTaint(array('mode',false))),addTaint(array('authors',false)));
$this->save_vars();
if ( ((denot_boolean($this->blogs[0][$importing_blog[0]][0][('posts_done')])) && (denot_boolean($this->blogs[0][$importing_blog[0]][0][('comments_done')]))))
 Aspis_exit(array('nothing',false));
do_action(array('import_done',false),array('blogger',false));
Aspis_exit(array('done',false));
} }
function convert_date ( $date ) {
{Aspis_preg_match(array('#([0-9]{4})-([0-9]{2})-([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})(?:\.[0-9]+)?(Z|[\+|\-][0-9]{2,4}){0,1}#',false),$date,$date_bits);
$offset = iso8601_timezone_to_offset(attachAspis($date_bits,(7)));
$timestamp = attAspis(gmmktime(deAspis(attachAspis($date_bits,(4))),deAspis(attachAspis($date_bits,(5))),deAspis(attachAspis($date_bits,(6))),deAspis(attachAspis($date_bits,(2))),deAspis(attachAspis($date_bits,(3))),deAspis(attachAspis($date_bits,(1)))));
$timestamp = array($timestamp[0] - $offset[0],false);
$timestamp = array((deAspis(get_option(array('gmt_offset',false))) * (3600)) + $timestamp[0],false);
return attAspis(gmdate(('Y-m-d H:i:s'),$timestamp[0]));
} }
function no_apos ( $string ) {
{return Aspis_str_replace(array('&apos;',false),array("'",false),$string);
} }
function min_whitespace ( $string ) {
{return Aspis_preg_replace(array('|\s+|',false),array(' ',false),$string);
} }
function _normalize_tag ( $matches ) {
{return concat1('<',Aspis_strtolower(attachAspis($matches,(1))));
} }
function import_post ( $entry ) {
{global $importing_blog;
if ( ((isset($entry[0]->draft) && Aspis_isset( $entry[0] ->draft ))))
 $rel = array('self',false);
else 
{$rel = array('alternate',false);
}foreach ( $entry[0]->links[0] as $link  )
{if ( (deAspis($link[0]['rel']) == $rel[0]))
 {$parts = Aspis_parse_url($link[0]['href']);
$entry[0]->old_permalink = $parts[0]['path'];
break ;
}}$post_date = $this->convert_date($entry[0]->published);
$post_content = Aspis_trim(Aspis_addslashes($this->no_apos(@Aspis_html_entity_decode($entry[0]->content,array(ENT_COMPAT,false),get_option(array('blog_charset',false))))));
$post_title = Aspis_trim(Aspis_addslashes($this->no_apos($this->min_whitespace($entry[0]->title))));
$post_status = ((isset($entry[0]->draft) && Aspis_isset( $entry[0] ->draft ))) ? array('draft',false) : array('publish',false);
$post_content = Aspis_preg_replace_callback(array('|<(/?[A-Z]+)|',false),array(array(array($this,false),array('_normalize_tag',false)),false),$post_content);
$post_content = Aspis_str_replace(array('<br>',false),array('<br />',false),$post_content);
$post_content = Aspis_str_replace(array('<hr>',false),array('<hr />',false),$post_content);
if ( ((isset($this->blogs[0][$importing_blog[0]][0][('posts')][0][$entry[0]->old_permalink[0]]) && Aspis_isset( $this ->blogs [0][$importing_blog[0]] [0][('posts')] [0][$entry[0] ->old_permalink [0]] ))))
 {preincr($this->blogs[0][$importing_blog[0]][0][('posts_skipped')]);
}elseif ( deAspis($post_id = post_exists($post_title,$post_content,$post_date)))
 {arrayAssign($this->blogs[0][$importing_blog[0]][0][('posts')][0],deAspis(registerTaint($entry[0]->old_permalink)),addTaint($post_id));
preincr($this->blogs[0][$importing_blog[0]][0][('posts_skipped')]);
}else 
{{$post = array(compact('post_date','post_content','post_title','post_status'),false);
$post_id = wp_insert_post($post);
if ( deAspis(is_wp_error($post_id)))
 return $post_id;
wp_create_categories(attAspisRC(array_map(AspisInternalCallback(array('addslashes',false)),deAspisRC($entry[0]->categories))),$post_id);
$author = $this->no_apos(Aspis_strip_tags($entry[0]->author));
add_post_meta($post_id,array('blogger_blog',false),$this->blogs[0][$importing_blog[0]][0][('host')],array(true,false));
add_post_meta($post_id,array('blogger_author',false),$author,array(true,false));
add_post_meta($post_id,array('blogger_permalink',false),$entry[0]->old_permalink,array(true,false));
arrayAssign($this->blogs[0][$importing_blog[0]][0][('posts')][0],deAspis(registerTaint($entry[0]->old_permalink)),addTaint($post_id));
preincr($this->blogs[0][$importing_blog[0]][0][('posts_done')]);
}}$this->save_vars();
return ;
} }
function import_comment ( $entry ) {
{global $importing_blog;
foreach ( $entry[0]->links[0] as $link  )
{if ( (deAspis($link[0]['rel']) == ('alternate')))
 {$parts = Aspis_parse_url($link[0]['href']);
$entry[0]->old_permalink = $parts[0]['fragment'];
$entry[0]->old_post_permalink = $parts[0]['path'];
break ;
}}$comment_post_ID = int_cast($this->blogs[0][$importing_blog[0]][0][('posts')][0][$entry[0]->old_post_permalink[0]]);
Aspis_preg_match(array('#<name>(.+?)</name>.*(?:\<uri>(.+?)</uri>)?#',false),$entry[0]->author,$matches);
$comment_author = Aspis_addslashes($this->no_apos(Aspis_strip_tags(string_cast(attachAspis($matches,(1))))));
$comment_author_url = Aspis_addslashes($this->no_apos(Aspis_strip_tags(string_cast(attachAspis($matches,(2))))));
$comment_date = $this->convert_date($entry[0]->updated);
$comment_content = Aspis_addslashes($this->no_apos(@Aspis_html_entity_decode($entry[0]->content,array(ENT_COMPAT,false),get_option(array('blog_charset',false)))));
$comment_content = Aspis_preg_replace_callback(array('|<(/?[A-Z]+)|',false),array(array(array($this,false),array('_normalize_tag',false)),false),$comment_content);
$comment_content = Aspis_str_replace(array('<br>',false),array('<br />',false),$comment_content);
$comment_content = Aspis_str_replace(array('<hr>',false),array('<hr />',false),$comment_content);
if ( (((isset($this->blogs[0][$importing_blog[0]][0][('comments')][0][$entry[0]->old_permalink[0]]) && Aspis_isset( $this ->blogs [0][$importing_blog[0]] [0][('comments')] [0][$entry[0] ->old_permalink [0]] ))) || deAspis(comment_exists($comment_author,$comment_date))))
 {preincr($this->blogs[0][$importing_blog[0]][0][('comments_skipped')]);
}else 
{{$comment = array(compact('comment_post_ID','comment_author','comment_author_url','comment_date','comment_content'),false);
$comment = wp_filter_comment($comment);
$comment_id = wp_insert_comment($comment);
arrayAssign($this->blogs[0][$importing_blog[0]][0][('comments')][0],deAspis(registerTaint($entry[0]->old_permalink)),addTaint($comment_id));
preincr($this->blogs[0][$importing_blog[0]][0][('comments_done')]);
}}$this->save_vars();
} }
function get_js_status ( $blog = array(false,false) ) {
{global $importing_blog;
if ( ($blog[0] === false))
 $blog = $this->blogs[0][$importing_blog[0]];
else 
{$blog = $this->blogs[0][$blog[0]];
}$p1 = ((isset($blog[0][('posts_done')]) && Aspis_isset( $blog [0][('posts_done')]))) ? int_cast($blog[0]['posts_done']) : array(0,false);
$p2 = ((isset($blog[0][('total_posts')]) && Aspis_isset( $blog [0][('total_posts')]))) ? int_cast($blog[0]['total_posts']) : array(0,false);
$c1 = ((isset($blog[0][('comments_done')]) && Aspis_isset( $blog [0][('comments_done')]))) ? int_cast($blog[0]['comments_done']) : array(0,false);
$c2 = ((isset($blog[0][('total_comments')]) && Aspis_isset( $blog [0][('total_comments')]))) ? int_cast($blog[0]['total_comments']) : array(0,false);
return concat2(concat(concat2(concat(concat2(concat(concat2(concat1("{p1:",$p1),",p2:"),$p2),",c1:"),$c1),",c2:"),$c2),"}");
} }
function get_author_form ( $blog = array(false,false) ) {
{global $importing_blog,$wpdb,$current_user;
if ( ($blog[0] === false))
 $blog = &$this->blogs[0][$importing_blog[0]];
else 
{$blog = &$this->blogs[0][$blog[0]];
}if ( (!((isset($blog[0][('authors')]) && Aspis_isset( $blog [0][('authors')])))))
 {$post_ids = Aspis_array_values($blog[0]['posts']);
$authors = array_cast($wpdb[0]->get_col(concat2(concat(concat2(concat1("SELECT DISTINCT meta_value FROM ",$wpdb[0]->postmeta)," WHERE meta_key = 'blogger_author' AND post_id IN ("),Aspis_join(array(',',false),$post_ids)),")")));
arrayAssign($blog[0],deAspis(registerTaint(array('authors',false))),addTaint(attAspisRC(array_map(AspisInternalCallback(array(null,false)),deAspisRC($authors),deAspisRC(Aspis_array_fill(array(0,false),attAspis(count($authors[0])),$current_user[0]->ID))))));
$this->save_vars();
}$directions = __(array('All posts were imported with the current user as author. Use this form to move each Blogger user&#8217;s posts to a different WordPress user. You may <a href="users.php">add users</a> and then return to this page and complete the user mapping. This form may be used as many times as you like until you activate the &#8220;Restart&#8221; function below.',false));
$heading = __(array('Author mapping',false));
$blogtitle = concat2(concat(concat2($blog[0]['title']," ("),$blog[0]['host']),")");
$mapthis = __(array('Blogger username',false));
$tothis = __(array('WordPress login',false));
$submit = esc_js(__(array('Save Changes',false)));
foreach ( deAspis($blog[0]['authors']) as $i =>$author )
{restoreTaint($i,$author);
$rows = concat($rows,concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<tr><td><label for='authors[",$i),"]'>"),attachAspis($author,(0))),"</label></td><td><select name='authors["),$i),"]' id='authors["),$i),"]'>"),$this->get_user_options(attachAspis($author,(1)))),"</select></td></tr>"));
}return concat(concat(concat2(concat(concat2(concat(concat2(concat1("<div class='wrap'><h2>",$heading),"</h2><h3>"),$blogtitle),"</h3><p>"),$directions),"</p><form action='index.php?import=blogger&amp;noheader=true&saveauthors=1' method='post'><input type='hidden' name='blog' value='"),esc_attr($importing_blog)),concat2(concat(concat2(concat(concat2(concat(concat2(concat1("' /><table cellpadding='5'><thead><td>",$mapthis),"</td><td>"),$tothis),"</td></thead>"),$rows),"<tr><td></td><td class='submit'><input type='submit' class='button authorsubmit' value='"),$submit),"' /></td></tr></table></form></div>"));
} }
function get_user_options ( $current ) {
{global $importer_users;
if ( (!((isset($importer_users) && Aspis_isset( $importer_users)))))
 $importer_users = array_cast(get_users_of_blog());
foreach ( $importer_users[0] as $user  )
{$sel = ($user[0]->user_id[0] == $current[0]) ? array(" selected='selected'",false) : array('',false);
$options = concat($options,concat2(concat(concat2(concat(concat2(concat1("<option value='",$user[0]->user_id),"'"),$sel),">"),$user[0]->display_name),"</option>"));
}return $options;
} }
function save_authors (  ) {
{global $importing_blog,$wpdb;
$authors = array_cast($_POST[0]['authors']);
$host = $this->blogs[0][$importing_blog[0]][0][('host')];
$post_ids = array_cast($wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT post_id FROM ",$wpdb[0]->postmeta)," WHERE meta_key = 'blogger_blog' AND meta_value = %s"),$host)));
$post_ids = Aspis_join(array(',',false),$post_ids);
$results = array_cast($wpdb[0]->get_results(concat2(concat(concat2(concat1("SELECT post_id, meta_value FROM ",$wpdb[0]->postmeta)," WHERE meta_key = 'blogger_author' AND post_id IN ("),$post_ids),")")));
foreach ( $results[0] as $row  )
arrayAssign($authors_posts[0],deAspis(registerTaint($row[0]->post_id)),addTaint($row[0]->meta_value));
foreach ( $authors[0] as $author =>$user_id )
{restoreTaint($author,$user_id);
{$user_id = int_cast($user_id);
if ( ($user_id[0] == $this->blogs[0][$importing_blog[0]][0][('authors')][0][$author[0]][0][(1)][0]))
 continue ;
$post_ids = array_cast(attAspisRC(array_keys(deAspisRC($authors_posts),deAspisRC($this->blogs[0][$importing_blog[0]][0][('authors')][0][$author[0]][0][(0)]))));
$post_ids = Aspis_join(array(',',false),$post_ids);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET post_author = %d WHERE id IN ("),$post_ids),")"),$user_id));
arrayAssign($this->blogs[0][$importing_blog[0]][0][('authors')][0][$author[0]][0],deAspis(registerTaint(array(1,false))),addTaint($user_id));
}}$this->save_vars();
wp_redirect(array('edit.php',false));
} }
function _get_auth_sock (  ) {
{if ( (denot_boolean($sock = @AspisInternalFunctionCall("fsockopen",('ssl://www.google.com'),(443),AspisPushRefParam($errno),AspisPushRefParam($errstr),array(2,3)))))
 {$this->uh_oh(__(array('Could not connect to https://www.google.com',false)),__(array('There was a problem opening a secure connection to Google. This is what went wrong:',false)),concat2(concat(concat2($errstr," ("),$errno),")"));
return array(false,false);
}return $sock;
} }
function _get_blogger_sock ( $host = array('www2.blogger.com',false) ) {
{if ( (denot_boolean($sock = @AspisInternalFunctionCall("fsockopen",$host[0],(80),AspisPushRefParam($errno),AspisPushRefParam($errstr),array(2,3)))))
 {$this->uh_oh(Aspis_sprintf(__(array('Could not connect to %s',false)),$host),__(array('There was a problem opening a connection to Blogger. This is what went wrong:',false)),concat2(concat(concat2($errstr," ("),$errno),")"));
return array(false,false);
}return $sock;
} }
function _txrx ( $sock,$request ) {
{fwrite($sock[0],$request[0]);
while ( (!(feof($sock[0]))) )
$response = concat($response,@attAspis(fread($sock[0],(8192))));
fclose($sock[0]);
return $response;
} }
function revoke ( $token ) {
{$headers = array(array(array("GET /accounts/AuthSubRevokeToken HTTP/1.0",false),concat2(concat1("Authorization: AuthSub token=\"",$token),"\"")),false);
$request = concat2(Aspis_join(array("\r\n",false),$headers),"\r\n\r\n");
$sock = $this->_get_auth_sock();
if ( (denot_boolean($sock)))
 return array(false,false);
$this->_txrx($sock,$request);
} }
function restart (  ) {
{global $wpdb;
$options = get_option(array('blogger_importer',false));
if ( ((isset($options[0][('token')]) && Aspis_isset( $options [0][('token')]))))
 $this->revoke($options[0]['token']);
delete_option(array('blogger_importer',false));
$wpdb[0]->query(concat2(concat1("DELETE FROM ",$wpdb[0]->postmeta)," WHERE meta_key = 'blogger_author'"));
wp_redirect(array('?import=blogger',false));
} }
function parse_response ( $this_response ) {
{list($response_headers,$response_body) = deAspisList(Aspis_explode(array("\r\n\r\n",false),$this_response,array(2,false)),array());
$response_header_lines = Aspis_explode(array("\r\n",false),$response_headers);
$http_response_line = Aspis_array_shift($response_header_lines);
if ( deAspis(Aspis_preg_match(array('@^HTTP/[0-9]\.[0-9] ([0-9]{3})@',false),$http_response_line,$matches)))
 {$response_code = attachAspis($matches,(1));
}$response_header_array = array(array(),false);
foreach ( $response_header_lines[0] as $header_line  )
{list($header,$value) = deAspisList(Aspis_explode(array(': ',false),$header_line,array(2,false)),array());
arrayAssign($response_header_array[0],deAspis(registerTaint($header)),addTaint(concat(attachAspis($response_header_array,$header[0]),concat2($value,"\n"))));
}$cookie_array = array(array(),false);
$cookies = Aspis_explode(array("\n",false),$response_header_array[0]["Set-Cookie"]);
foreach ( $cookies[0] as $this_cookie  )
{Aspis_array_push($cookie_array,concat1("Cookie: ",$this_cookie));
}return array(array(deregisterTaint(array("code",false)) => addTaint($response_code),deregisterTaint(array("header",false)) => addTaint($response_header_array),deregisterTaint(array("cookies",false)) => addTaint($cookie_array),deregisterTaint(array("body",false)) => addTaint($response_body)),false);
} }
function congrats (  ) {
{$blog = int_cast($_GET[0]['blog']);
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1('<h1>',__(array('Congratulations!',false))),'</h1><p>'),__(array('Now that you have imported your Blogger blog into WordPress, what are you going to do? Here are some suggestions:',false))),'</p><ul><li>'),__(array('That was hard work! Take a break.',false))),'</li>'));
if ( (count($this->import[0][('blogs')][0]) > (1)))
 echo AspisCheckPrint(concat2(concat(concat1('<li>',__(array('In case you haven&#8217;t done it already, you can import the posts from your other blogs:',false))),$this->show_blogs()),'</li>'));
if ( deAspis($n = attAspis(count($this->import[0][('blogs')][0][$blog[0]][0][('newusers')][0]))))
 echo AspisCheckPrint(concat2(concat1('<li>',Aspis_sprintf(__(array('Go to <a href="%s" target="%s">Authors &amp; Users</a>, where you can modify the new user(s) or delete them. If you want to make all of the imported posts yours, you will be given that option when you delete the new authors.',false)),array('users.php',false),array('_parent',false))),'</li>'));
echo AspisCheckPrint(concat2(concat1('<li>',__(array('For security, click the link below to reset this importer.',false))),'</li>'));
echo AspisCheckPrint(array('</ul>',false));
} }
function start (  ) {
{if ( ((isset($_POST[0][('restart')]) && Aspis_isset( $_POST [0][('restart')]))))
 $this->restart();
$options = get_option(array('blogger_importer',false));
if ( is_array($options[0]))
 foreach ( $options[0] as $key =>$value )
{restoreTaint($key,$value);
$this->$key[0] = $value;
}if ( ((isset($_REQUEST[0][('blog')]) && Aspis_isset( $_REQUEST [0][('blog')]))))
 {$blog = is_array(deAspis($_REQUEST[0]['blog'])) ? Aspis_array_shift($keys = attAspisRC(array_keys(deAspisRC($_REQUEST[0]['blog'])))) : $_REQUEST[0]['blog'];
$blog = int_cast($blog);
$result = $this->import_blog($blog);
if ( deAspis(is_wp_error($result)))
 echo AspisCheckPrint($result[0]->get_error_message());
}elseif ( ((isset($_GET[0][('token')]) && Aspis_isset( $_GET [0][('token')]))))
 $this->auth();
elseif ( (((isset($this->token) && Aspis_isset( $this ->token ))) && deAspis($this->token_is_valid())))
 $this->show_blogs();
else 
{$this->greet();
}$saved = $this->save_vars();
if ( ($saved[0] && (!((isset($_GET[0][('noheader')]) && Aspis_isset( $_GET [0][('noheader')]))))))
 {$restart = __(array('Restart',false));
$message = __(array('We have saved some information about your Blogger account in your WordPress database. Clearing this information will allow you to start over. Restarting will not affect any posts you have already imported. If you attempt to re-import a blog, duplicate posts and comments will be skipped.',false));
$submit = esc_attr__(array('Clear account information',false));
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1("<div class='wrap'><h2>",$restart),"</h2><p>"),$message),"</p><form method='post' action='?import=blogger&amp;noheader=true'><p class='submit' style='text-align:left;'><input type='submit' class='button' value='"),$submit),"' name='restart' /></p></form></div>"));
}} }
function save_vars (  ) {
{$vars = attAspis(get_object_vars(deAspisRC(array($this,false))));
update_option(array('blogger_importer',false),$vars);
return not_boolean(array((empty($vars) || Aspis_empty( $vars)),false));
} }
function admin_head (  ) {
{;
?>
<style type="text/css">
td { text-align: center; line-height: 2em;}
thead td { font-weight: bold; }
.bar {
	width: 200px;
	text-align: left;
	line-height: 2em;
	padding: 0px;
}
.ind {
	position: absolute;
	background-color: #83B4D8;
	width: 1px;
	z-index: 9;
}
.stat {
	z-index: 10;
	position: relative;
	text-align: center;
}
</style>
<?php } }
function Blogger_Import (  ) {
{global $importer_started;
$importer_started = attAspis(time());
if ( (((isset($_GET[0][('import')]) && Aspis_isset( $_GET [0][('import')]))) && (deAspis($_GET[0]['import']) == ('blogger'))))
 {wp_enqueue_script(array('jquery',false));
add_action(array('admin_head',false),array(array(array($this,false),array('admin_head',false)),false));
}} }
}$blogger_import = array(new Blogger_Import(),false);
register_importer(array('blogger',false),__(array('Blogger',false)),__(array('Import posts, comments, and users from a Blogger blog.',false)),array(array($blogger_import,array('start',false)),false));
class AtomEntry{var $links = array(array(),false);
var $categories = array(array(),false);
}class AtomParser{var $ATOM_CONTENT_ELEMENTS = array(array(array('content',false),array('summary',false),array('title',false),array('subtitle',false),array('rights',false)),false);
var $ATOM_SIMPLE_ELEMENTS = array(array(array('id',false),array('updated',false),array('published',false),array('draft',false),array('author',false)),false);
var $depth = array(0,false);
var $indent = array(2,false);
var $in_content;
var $ns_contexts = array(array(),false);
var $ns_decls = array(array(),false);
var $is_xhtml = array(false,false);
var $skipped_div = array(false,false);
var $entry;
function AtomParser (  ) {
{$this->entry = array(new AtomEntry(),false);
} }
function _map_attrs_func ( $k,$v ) {
{return concat2(concat(concat2($k,"=\""),$v),"\"");
} }
function _map_xmlns_func ( $p,$n ) {
{$xd = array("xmlns",false);
if ( (strlen(deAspis(attachAspis($n,(0)))) > (0)))
 $xd = concat($xd,concat1(":",attachAspis($n,(0))));
return concat2(concat(concat2($xd,"=\""),attachAspis($n,(1))),"\"");
} }
function parse ( $xml ) {
{global $app_logging;
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
$contents = array("",false);
xml_parse($parser[0],$xml[0]);
xml_parser_free(deAspisRC($parser));
return array(true,false);
} }
function start_element ( $parser,$name,$attrs ) {
{$tag = Aspis_array_pop(Aspis_split(array(":",false),$name));
Aspis_array_unshift($this->ns_contexts,$this->ns_decls);
postincr($this->depth);
if ( (!((empty($this->in_content) || Aspis_empty( $this ->in_content )))))
 {$attrs_prefix = array(array(),false);
foreach ( $attrs[0] as $key =>$value )
{restoreTaint($key,$value);
{arrayAssign($attrs_prefix[0],deAspis(registerTaint($this->ns_to_prefix($key))),addTaint($this->xml_escape($value)));
}}$attrs_str = Aspis_join(array(' ',false),attAspisRC(array_map(AspisInternalCallback(array(array(array($this,false),array('_map_attrs_func',false)),false)),deAspisRC(attAspisRC(array_keys(deAspisRC($attrs_prefix)))),deAspisRC(Aspis_array_values($attrs_prefix)))));
if ( (strlen($attrs_str[0]) > (0)))
 {$attrs_str = concat1(" ",$attrs_str);
}$xmlns_str = Aspis_join(array(' ',false),attAspisRC(array_map(AspisInternalCallback(array(array(array($this,false),array('_map_xmlns_func',false)),false)),deAspisRC(attAspisRC(array_keys(deAspisRC($this->ns_contexts[0][(0)])))),deAspisRC(Aspis_array_values($this->ns_contexts[0][(0)])))));
if ( (strlen($xmlns_str[0]) > (0)))
 {$xmlns_str = concat1(" ",$xmlns_str);
}if ( (count($this->in_content[0]) == (2)))
 {Aspis_array_push($this->in_content,array(">",false));
}Aspis_array_push($this->in_content,concat(concat1("<",$this->ns_to_prefix($name)),$xmlns_str));
}else 
{if ( (deAspis(Aspis_in_array($tag,$this->ATOM_CONTENT_ELEMENTS)) || deAspis(Aspis_in_array($tag,$this->ATOM_SIMPLE_ELEMENTS))))
 {$this->in_content = array(array(),false);
$this->is_xhtml = array(deAspis($attrs[0]['type']) == ('xhtml'),false);
Aspis_array_push($this->in_content,array(array($tag,$this->depth),false));
}else 
{if ( ($tag[0] == ('link')))
 {Aspis_array_push($this->entry[0]->links,$attrs);
}else 
{if ( ($tag[0] == ('category')))
 {Aspis_array_push($this->entry[0]->categories,$attrs[0]['term']);
}}}}$this->ns_decls = array(array(),false);
} }
function end_element ( $parser,$name ) {
{$tag = Aspis_array_pop(Aspis_split(array(":",false),$name));
if ( (!((empty($this->in_content) || Aspis_empty( $this ->in_content )))))
 {if ( (($this->in_content[0][(0)][0][(0)][0] == $tag[0]) && ($this->in_content[0][(0)][0][(1)][0] == $this->depth[0])))
 {Aspis_array_shift($this->in_content);
if ( $this->is_xhtml[0])
 {$this->in_content = Aspis_array_slice($this->in_content,array(2,false),array(count($this->in_content[0]) - (3),false));
}$this->entry[0]->$tag[0] = Aspis_join(array('',false),$this->in_content);
$this->in_content = array(array(),false);
}else 
{{$endtag = $this->ns_to_prefix($name);
if ( (strpos($this->in_content[0][(count($this->in_content[0]) - (1))][0],(deconcat1('<',$endtag))) !== false))
 {Aspis_array_push($this->in_content,array("/>",false));
}else 
{{Aspis_array_push($this->in_content,concat2(concat1("</",$endtag),">"));
}}}}}Aspis_array_shift($this->ns_contexts);
postdecr($this->depth);
} }
function start_ns ( $parser,$prefix,$uri ) {
{Aspis_array_push($this->ns_decls,array(array($prefix,$uri),false));
} }
function end_ns ( $parser,$prefix ) {
{} }
function cdata ( $parser,$data ) {
{if ( (!((empty($this->in_content) || Aspis_empty( $this ->in_content )))))
 {if ( (strpos($this->in_content[0][(count($this->in_content[0]) - (1))][0],'<') !== false))
 {Aspis_array_push($this->in_content,array(">",false));
}Aspis_array_push($this->in_content,$this->xml_escape($data));
}} }
function _default ( $parser,$data ) {
{} }
function ns_to_prefix ( $qname ) {
{$components = Aspis_split(array(":",false),$qname);
$name = Aspis_array_pop($components);
if ( (!((empty($components) || Aspis_empty( $components)))))
 {$ns = Aspis_join(array(":",false),$components);
foreach ( $this->ns_contexts[0] as $context  )
{foreach ( $context[0] as $mapping  )
{if ( ((deAspis(attachAspis($mapping,(1))) == $ns[0]) && (strlen(deAspis(attachAspis($mapping,(0)))) > (0))))
 {return concat(concat2(attachAspis($mapping,(0)),":"),$name);
}}}}return $name;
} }
function xml_escape ( $string ) {
{return Aspis_str_replace(array(array(array('&',false),array('"',false),array("'",false),array('<',false),array('>',false)),false),array(array(array('&amp;',false),array('&quot;',false),array('&apos;',false),array('&lt;',false),array('&gt;',false)),false),$string);
} }
};
?>
<?php 