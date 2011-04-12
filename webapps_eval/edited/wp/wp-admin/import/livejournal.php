<?php require_once('AspisMain.php'); ?><?php
require_once (deconcat2(concat12(ABSPATH,WPINC),'/class-IXR.php'));
class LJ_API_Import{var $comments_url = array('http://www.livejournal.com/export_comments.bml',false);
var $ixr_url = array('http://www.livejournal.com/interface/xmlrpc',false);
var $ixr;
var $username;
var $password;
var $comment_meta;
var $comments;
var $usermap;
var $postmap;
var $commentmap;
var $pointers = array(array(),false);
var $moods = array(array('1' => array('aggravated',false),'10' => array('discontent',false),'100' => array('rushed',false),'101' => array('contemplative',false),'102' => array('nerdy',false),'103' => array('geeky',false),'104' => array('cynical',false),'105' => array('quixotic',false),'106' => array('crazy',false),'107' => array('creative',false),'108' => array('artistic',false),'109' => array('pleased',false),'11' => array('energetic',false),'110' => array('bitchy',false),'111' => array('guilty',false),'112' => array('irritated',false),'113' => array('blank',false),'114' => array('apathetic',false),'115' => array('dorky',false),'116' => array('impressed',false),'117' => array('naughty',false),'118' => array('predatory',false),'119' => array('dirty',false),'12' => array('enraged',false),'120' => array('giddy',false),'121' => array('surprised',false),'122' => array('shocked',false),'123' => array('rejected',false),'124' => array('numb',false),'125' => array('cheerful',false),'126' => array('good',false),'127' => array('distressed',false),'128' => array('intimidated',false),'129' => array('crushed',false),'13' => array('enthralled',false),'130' => array('devious',false),'131' => array('thankful',false),'132' => array('grateful',false),'133' => array('jealous',false),'134' => array('nervous',false),'14' => array('exhausted',false),'15' => array('happy',false),'16' => array('high',false),'17' => array('horny',false),'18' => array('hungry',false),'19' => array('infuriated',false),'2' => array('angry',false),'20' => array('irate',false),'21' => array('jubilant',false),'22' => array('lonely',false),'23' => array('moody',false),'24' => array('pissed off',false),'25' => array('sad',false),'26' => array('satisfied',false),'27' => array('sore',false),'28' => array('stressed',false),'29' => array('thirsty',false),'3' => array('annoyed',false),'30' => array('thoughtful',false),'31' => array('tired',false),'32' => array('touched',false),'33' => array('lazy',false),'34' => array('drunk',false),'35' => array('ditzy',false),'36' => array('mischievous',false),'37' => array('morose',false),'38' => array('gloomy',false),'39' => array('melancholy',false),'4' => array('anxious',false),'40' => array('drained',false),'41' => array('excited',false),'42' => array('relieved',false),'43' => array('hopeful',false),'44' => array('amused',false),'45' => array('determined',false),'46' => array('scared',false),'47' => array('frustrated',false),'48' => array('indescribable',false),'49' => array('sleepy',false),'5' => array('bored',false),'51' => array('groggy',false),'52' => array('hyper',false),'53' => array('relaxed',false),'54' => array('restless',false),'55' => array('disappointed',false),'56' => array('curious',false),'57' => array('mellow',false),'58' => array('peaceful',false),'59' => array('bouncy',false),'6' => array('confused',false),'60' => array('nostalgic',false),'61' => array('okay',false),'62' => array('rejuvenated',false),'63' => array('complacent',false),'64' => array('content',false),'65' => array('indifferent',false),'66' => array('silly',false),'67' => array('flirty',false),'68' => array('calm',false),'69' => array('refreshed',false),'7' => array('crappy',false),'70' => array('optimistic',false),'71' => array('pessimistic',false),'72' => array('giggly',false),'73' => array('pensive',false),'74' => array('uncomfortable',false),'75' => array('lethargic',false),'76' => array('listless',false),'77' => array('recumbent',false),'78' => array('exanimate',false),'79' => array('embarrassed',false),'8' => array('cranky',false),'80' => array('envious',false),'81' => array('sympathetic',false),'82' => array('sick',false),'83' => array('hot',false),'84' => array('cold',false),'85' => array('worried',false),'86' => array('loved',false),'87' => array('awake',false),'88' => array('working',false),'89' => array('productive',false),'9' => array('depressed',false),'90' => array('accomplished',false),'91' => array('busy',false),'92' => array('blah',false),'93' => array('full',false),'95' => array('grumpy',false),'96' => array('weird',false),'97' => array('nauseated',false),'98' => array('ecstatic',false),'99' => array('chipper',false)),false);
function header (  ) {
{echo AspisCheckPrint(array('<div class="wrap">',false));
screen_icon();
echo AspisCheckPrint(concat2(concat1('<h2>',__(array('Import LiveJournal',false))),'</h2>'));
} }
function footer (  ) {
{echo AspisCheckPrint(array('</div>',false));
} }
function greet (  ) {
{;
?>
		<div class="narrow">
		<form action="admin.php?import=livejournal" method="post">
		<?php wp_nonce_field(array('lj-api-import',false));
?>
		<?php if ( (deAspis(get_option(array('ljapi_username',false))) && deAspis(get_option(array('ljapi_password',false)))))
 {;
?>
			<input type="hidden" name="step" value="<?php echo AspisCheckPrint(esc_attr(get_option(array('ljapi_step',false))));
?>" />
			<p><?php _e(array('It looks like you attempted to import your LiveJournal posts previously and got interrupted.',false));
?></p>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php esc_attr_e(array('Continue previous import',false));
?>" />
			</p>
			<p class="submitbox"><a href="<?php echo AspisCheckPrint(esc_url(concat(concat2(concat(concat2($_SERVER[0]['PHP_SELF'],'?import=livejournal&amp;step=-1&amp;_wpnonce='),wp_create_nonce(array('lj-api-import',false))),'&amp;_wp_http_referer='),esc_attr($_SERVER[0]['REQUEST_URI']))));
?>" class="deletion submitdelete"><?php _e(array('Cancel &amp; start a new import',false));
?></a></p>
			<p>
		<?php }else 
{;
?>
			<input type="hidden" name="step" value="1" />
			<input type="hidden" name="login" value="true" />
			<p><?php _e(array('Howdy! This importer allows you to connect directly to LiveJournal and download all your entries and comments',false));
?></p>
			<p><?php _e(array('Enter your LiveJournal username and password below so we can connect to your account:',false));
?></p>

			<table class="form-table">

			<tr>
			<th scope="row"><label for="lj_username"><?php _e(array('LiveJournal Username',false));
?></label></th>
			<td><input type="text" name="lj_username" id="lj_username" class="regular-text" /></td>
			</tr>

			<tr>
			<th scope="row"><label for="lj_password"><?php _e(array('LiveJournal Password',false));
?></label></th>
			<td><input type="password" name="lj_password" id="lj_password" class="regular-text" /></td>
			</tr>

			</table>

			<p><?php _e(array('If you have any entries on LiveJournal which are marked as private, they will be password-protected when they are imported so that only people who know the password can see them.',false));
?></p>
			<p><?php _e(array('If you don&#8217;t enter a password, ALL ENTRIES from your LiveJournal will be imported as public posts in WordPress.',false));
?></p>
			<p><?php _e(array('Enter the password you would like to use for all protected entries here:',false));
?></p>
			<table class="form-table">

			<tr>
			<th scope="row"><label for="protected_password"><?php _e(array('Protected Post Password',false));
?></label></th>
			<td><input type="text" name="protected_password" id="protected_password" class="regular-text" /></td>
			</tr>

			</table>

			<p><?php _e(array("<strong>WARNING:</strong> This can take a really long time if you have a lot of entries in your LiveJournal, or a lot of comments. Ideally, you should only start this process if you can leave your computer alone while it finishes the import.",false));
?></p>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php esc_attr_e(array('Connect to LiveJournal and Import',false));
?>" />
			</p>

			<p><?php _e(array('<strong>NOTE:</strong> If the import process is interrupted for <em>any</em> reason, come back to this page and it will continue from where it stopped automatically.',false));
?></p>

			<noscript>
				<p><?php _e(array('<strong>NOTE:</strong> You appear to have JavaScript disabled, so you will need to manually click through each step of this importer. If you enable JavaScript, it will step through automatically.',false));
?></p>
			</noscript>
		<?php };
?>
		</form>
		</div>
		<?php } }
function download_post_meta (  ) {
{$total = int_cast(get_option(array('ljapi_total',false)));
$count = int_cast(get_option(array('ljapi_count',false)));
$lastsync = get_option(array('ljapi_lastsync',false));
if ( (denot_boolean($lastsync)))
 {update_option(array('ljapi_lastsync',false),array('1900-01-01 00:00:00',false));
}$sync_item_times = get_option(array('ljapi_sync_item_times',false));
if ( (!(is_array($sync_item_times[0]))))
 $sync_item_times = array(array(),false);
do {$lastsync = attAspis(date(('Y-m-d H:i:s'),strtotime(deAspis(get_option(array('ljapi_lastsync',false))))));
$synclist = $this->lj_ixr(array('syncitems',false),array(array('ver' => array(1,false,false),deregisterTaint(array('lastsync',false)) => addTaint($lastsync)),false));
if ( deAspis(is_wp_error($synclist)))
 return $synclist;
$total = $synclist[0]['total'];
$count = $synclist[0]['count'];
foreach ( deAspis($synclist[0]['syncitems']) as $event  )
{if ( (deAspis(Aspis_substr($event[0]['item'],array(0,false),array(2,false))) == ('L-')))
 {arrayAssign($sync_item_times[0],deAspis(registerTaint(Aspis_str_replace(array('L-',false),array('',false),$event[0]['item']))),addTaint($event[0]['time']));
if ( (deAspis($event[0]['time']) > $lastsync[0]))
 {$lastsync = $event[0]['time'];
update_option(array('ljapi_lastsync',false),$lastsync);
}}}}while (($total[0] > $count[0]) )
;
unset($synclist);
update_option(array('ljapi_sync_item_times',false),$sync_item_times);
update_option(array('ljapi_total',false),$total);
update_option(array('ljapi_count',false),$count);
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Post metadata has been downloaded, proceeding with posts...',false))),'</p>'));
} }
function download_post_bodies (  ) {
{$imported_count = int_cast(get_option(array('ljapi_imported_count',false)));
$sync_item_times = get_option(array('ljapi_sync_item_times',false));
$lastsync = get_option(array('ljapi_lastsync_posts',false));
if ( (denot_boolean($lastsync)))
 update_option(array('ljapi_lastsync_posts',false),attAspis(date(('Y-m-d H:i:s'),(0))));
$count = array(0,false);
echo AspisCheckPrint(array('<ol>',false));
do {$lastsync = attAspis(date(('Y-m-d H:i:s'),strtotime(deAspis(get_option(array('ljapi_lastsync_posts',false))))));
$itemlist = $this->lj_ixr(array('getevents',false),array(array('ver' => array(1,false,false),'selecttype' => array('syncitems',false,false),'lineendings' => array('pc',false,false),deregisterTaint(array('lastsync',false)) => addTaint($lastsync)),false));
if ( deAspis(is_wp_error($itemlist)))
 return $itemlist;
if ( deAspis($num = attAspis(count(deAspis($itemlist[0]['events'])))))
 {for ( $e = array(0,false) ; ($e[0] < count(deAspis($itemlist[0]['events']))) ; postincr($e) )
{$event = attachAspis($itemlist[0][('events')],$e[0]);
postincr($imported_count);
$inserted = $this->import_post($event);
if ( deAspis(is_wp_error($inserted)))
 return $inserted;
if ( (deAspis(attachAspis($sync_item_times,deAspis($event[0]['itemid']))) > $lastsync[0]))
 $lastsync = attachAspis($sync_item_times,deAspis($event[0]['itemid']));
wp_cache_flush();
}update_option(array('ljapi_lastsync_posts',false),$lastsync);
update_option(array('ljapi_imported_count',false),$imported_count);
update_option(array('ljapi_last_sync_count',false),$num);
}postincr($count);
}while ((($num[0] > (0)) && ($count[0] < (3))) )
;
update_option(array('ljapi_last_sync_count',false),$num);
update_option(array('ljapi_post_batch',false),(array(deAspis(int_cast(get_option(array('ljapi_post_batch',false)))) + (1),false)));
echo AspisCheckPrint(array('</ol>',false));
} }
function _normalize_tag ( $matches ) {
{return concat1('<',Aspis_strtolower(attachAspis($matches,(1))));
} }
function import_post ( $post ) {
{global $wpdb;
if ( deAspis($this->get_wp_post_ID($post[0]['itemid'])))
 return ;
$user = wp_get_current_user();
$post_author = $user[0]->ID;
arrayAssign($post[0],deAspis(registerTaint(array('security',false))),addTaint((!((empty($post[0][('security')]) || Aspis_empty( $post [0][('security')])))) ? $post[0]['security'] : array('',false)));
$post_status = (('private') == deAspis(Aspis_trim($post[0]['security']))) ? array('private',false) : array('publish',false);
$post_password = (('usemask') == deAspis(Aspis_trim($post[0]['security']))) ? $this->protected_password : array('',false);
$post_date = $post[0]['eventtime'];
if ( ((18) == strlen($post_date[0])))
 $post_date = concat(concat2(Aspis_substr($post_date,array(0,false),array(10,false)),' '),Aspis_substr($post_date,array(10,false)));
$post_title = ((isset($post[0][('subject')]) && Aspis_isset( $post [0][('subject')]))) ? Aspis_trim($post[0]['subject']) : array('',false);
$post_title = $this->translate_lj_user($post_title);
$post_title = Aspis_strip_tags($post_title);
$post_title = $wpdb[0]->escape($post_title);
$post_content = $post[0]['event'];
$post_content = Aspis_preg_replace_callback(array('|<(/?[A-Z]+)|',false),array(array(array($this,false),array('_normalize_tag',false)),false),$post_content);
$post_content = Aspis_str_replace(array('<br>',false),array('<br />',false),$post_content);
$post_content = Aspis_str_replace(array('<hr>',false),array('<hr />',false),$post_content);
$post_content = Aspis_preg_replace(array('|<lj-cut text="([^"]*)">|is',false),array('<!--more $1-->',false),$post_content);
$post_content = Aspis_str_replace(array(array(array('<lj-cut>',false),array('</lj-cut>',false)),false),array(array(array('<!--more-->',false),array('',false)),false),$post_content);
$first = attAspis(strpos($post_content[0],'<!--more'));
$post_content = concat(Aspis_substr($post_content,array(0,false),array($first[0] + (1),false)),Aspis_preg_replace(array('|<!--more(.*)?-->|sUi',false),array('',false),Aspis_substr($post_content,array($first[0] + (1),false))));
$post_content = $this->translate_lj_user($post_content);
$post_content = $wpdb[0]->escape($post_content);
$tags_input = (!((empty($post[0][('props')][0][('taglist')]) || Aspis_empty( $post [0][('props')] [0][('taglist')])))) ? $post[0][('props')][0]['taglist'] : array('',false);
$comment_status = (!((empty($post[0][('props')][0][('opt_nocomments')]) || Aspis_empty( $post [0][('props')] [0][('opt_nocomments')])))) ? array('closed',false) : array('open',false);
echo AspisCheckPrint(array('<li>',false));
if ( deAspis($post_id = post_exists($post_title,$post_content,$post_date)))
 {printf(deAspis(__(array('Post <strong>%s</strong> already exists.',false))),deAspisRC(Aspis_stripslashes($post_title)));
}else 
{{printf(deAspis(__(array('Imported post <strong>%s</strong>...',false))),deAspisRC(Aspis_stripslashes($post_title)));
$postdata = array(compact('post_author','post_date','post_content','post_title','post_status','post_password','tags_input','comment_status'),false);
$post_id = wp_insert_post($postdata,array(true,false));
if ( deAspis(is_wp_error($post_id)))
 {if ( (('empty_content') == deAspis($post_id[0]->get_error_code())))
 return ;
return $post_id;
}if ( (denot_boolean($post_id)))
 {_e(array('Couldn&#8217;t get post ID (creating post failed!)',false));
echo AspisCheckPrint(array('</li>',false));
return array(new WP_Error(array('insert_post_failed',false),__(array('Failed to create post.',false))),false);
}$this->insert_postmeta($post_id,$post);
}}echo AspisCheckPrint(array('</li>',false));
} }
function translate_lj_user ( $str ) {
{return Aspis_preg_replace(array('|<lj\s+user\s*=\s*["\']([\w-]+)["\']>|',false),array('<a href="http://$1.livejournal.com/" class="lj-user">$1</a>',false),$str);
} }
function insert_postmeta ( $post_id,$post ) {
{add_post_meta($post_id,array('lj_itemid',false),$post[0]['itemid']);
add_post_meta($post_id,array('lj_permalink',false),$post[0]['url']);
foreach ( (array(array('adult_content',false),array('current_coords',false),array('current_location',false),array('current_moodid',false),array('current_music',false),array('picture_keyword',false))) as $prop  )
{if ( (!((empty($post[0][('props')][0][$prop[0]]) || Aspis_empty( $post [0][('props')] [0][$prop[0]])))))
 {if ( (('current_moodid') == $prop[0]))
 {$prop = array('current_mood',false);
$val = $this->moods[0][deAspis($post[0][('props')][0]['current_moodid'])];
}else 
{{$val = attachAspis($post[0][('props')],$prop[0]);
}}add_post_meta($post_id,concat1('lj_',$prop),$val);
}}} }
function get_session (  ) {
{$cookie = $this->lj_ixr(array('sessiongenerate',false),array(array('ver' => array(1,false,false),'expiration' => array('short',false,false)),false));
if ( deAspis(is_wp_error($cookie)))
 return array(new WP_Error(array('cookie',false),__(array('Could not get a cookie from LiveJournal. Please try again soon.',false))),false);
return array(new WP_Http_Cookie(array(array('name' => array('ljsession',false,false),deregisterTaint(array('value',false)) => addTaint($cookie[0]['ljsession'])),false)),false);
} }
function download_comment_meta (  ) {
{$cookie = $this->get_session();
if ( deAspis(is_wp_error($cookie)))
 return $cookie;
$this->usermap = array_cast(get_option(array('ljapi_usermap',false)));
$maxid = deAspis(get_option(array('ljapi_maxid',false))) ? get_option(array('ljapi_maxid',false)) : array(1,false);
$highest_id = deAspis(get_option(array('ljapi_highest_id',false))) ? get_option(array('ljapi_highest_id',false)) : array(0,false);
while ( ($maxid[0] > $highest_id[0]) )
{$results = wp_remote_get(concat(concat2($this->comments_url,'?get=comment_meta&startid='),(array($highest_id[0] + (1),false))),array(array('cookies' => array(array($cookie),false,false),'timeout' => array(20,false,false)),false));
if ( deAspis(is_wp_error($results)))
 return array(new WP_Error(array('comment_meta',false),__(array('Failed to retrieve comment meta information from LiveJournal. Please try again soon.',false))),false);
$results = wp_remote_retrieve_body($results);
Aspis_preg_match(array('|<maxid>(\d+)</maxid>|',false),$results,$matches);
if ( ((0) == deAspis(attachAspis($matches,(1)))))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('You have no comments to import!',false))),'</p>'));
update_option(array('ljapi_highest_id',false),array(1,false));
update_option(array('ljapi_highest_comment_id',false),array(1,false));
return array(false,false);
}$maxid = (!((empty($matches[0][(1)]) || Aspis_empty( $matches [0][(1)])))) ? attachAspis($matches,(1)) : $maxid;
Aspis_preg_match_all(array('|<comment id=\'(\d+)\'|is',false),$results,$matches);
foreach ( deAspis(attachAspis($matches,(1))) as $id  )
{if ( ($id[0] > $highest_id[0]))
 $highest_id = $id;
}Aspis_preg_match_all(array('|<usermap id=\'(\d+)\' user=\'([^\']+)\' />|',false),$results,$matches);
foreach ( deAspis(attachAspis($matches,(1))) as $count =>$userid )
{restoreTaint($count,$userid);
arrayAssign($this->usermap[0],deAspis(registerTaint($userid)),addTaint(attachAspis($matches[0][(2)],$count[0])));
}wp_cache_flush();
}update_option(array('ljapi_usermap',false),$this->usermap);
update_option(array('ljapi_maxid',false),$maxid);
update_option(array('ljapi_highest_id',false),$highest_id);
echo AspisCheckPrint(concat2(concat1('<p>',__(array(' Comment metadata downloaded successfully, proceeding with comment bodies...',false))),'</p>'));
return array(true,false);
} }
function download_comment_bodies (  ) {
{global $wpdb;
$cookie = $this->get_session();
if ( deAspis(is_wp_error($cookie)))
 return $cookie;
$this->usermap = array_cast(get_option(array('ljapi_usermap',false)));
$maxid = deAspis(get_option(array('ljapi_maxid',false))) ? int_cast(get_option(array('ljapi_maxid',false))) : array(1,false);
$highest_id = int_cast(get_option(array('ljapi_highest_comment_id',false)));
$loop = array(0,false);
while ( (($maxid[0] > $highest_id[0]) && ($loop[0] < (5))) )
{postincr($loop);
$results = wp_remote_get(concat(concat2($this->comments_url,'?get=comment_body&startid='),(array($highest_id[0] + (1),false))),array(array('cookies' => array(array($cookie),false,false),'timeout' => array(20,false,false)),false));
if ( deAspis(is_wp_error($results)))
 return array(new WP_Error(array('comment_bodies',false),__(array('Failed to retrieve comment bodies from LiveJournal. Please try again soon.',false))),false);
$results = wp_remote_retrieve_body($results);
Aspis_preg_match_all(array('|<comment id=\'(\d+)\'.*</comment>|iUs',false),$results,$matches);
for ( $c = array(0,false) ; ($c[0] < count(deAspis(attachAspis($matches,(0))))) ; postincr($c) )
{if ( (deAspis(attachAspis($matches[0][(1)],$c[0])) > $highest_id[0]))
 {$highest_id = attachAspis($matches[0][(1)],$c[0]);
update_option(array('ljapi_highest_comment_id',false),$highest_id);
}$comment = attachAspis($matches[0][(0)],$c[0]);
$comment = Aspis_preg_replace(array('|<comment id=\'\d+\' jitemid=\'\d+\' posterid=\'\d+\' state=\'D\'[^/]*/>|is',false),array('',false),$comment);
$comment = $this->parse_comment($comment);
$comment = wp_filter_comment($comment);
$id = wp_insert_comment($comment);
clean_comment_cache($id);
}wp_cache_flush();
}update_option(array('ljapi_comment_batch',false),(array(deAspis(int_cast(get_option(array('ljapi_comment_batch',false)))) + (1),false)));
return array(true,false);
} }
function parse_comment ( $comment ) {
{global $wpdb;
Aspis_preg_match(array('|<comment([^>]+)>|i',false),$comment,$attribs);
Aspis_preg_match(array('| id=\'(\d+)\'|i',false),attachAspis($attribs,(1)),$matches);
$lj_comment_ID = attachAspis($matches,(1));
Aspis_preg_match(array('| jitemid=\'(\d+)\'|i',false),attachAspis($attribs,(1)),$matches);
$lj_comment_post_ID = attachAspis($matches,(1));
Aspis_preg_match(array('| posterid=\'(\d+)\'|i',false),attachAspis($attribs,(1)),$matches);
$comment_author_ID = ((isset($matches[0][(1)]) && Aspis_isset( $matches [0][(1)]))) ? attachAspis($matches,(1)) : array(0,false);
Aspis_preg_match(array('| parentid=\'(\d+)\'|i',false),attachAspis($attribs,(1)),$matches);
$lj_comment_parent = ((isset($matches[0][(1)]) && Aspis_isset( $matches [0][(1)]))) ? attachAspis($matches,(1)) : array(0,false);
Aspis_preg_match(array('| state=\'([SDFA])\'|i',false),attachAspis($attribs,(1)),$matches);
$lj_comment_state = ((isset($matches[0][(1)]) && Aspis_isset( $matches [0][(1)]))) ? attachAspis($matches,(1)) : array('A',false);
Aspis_preg_match(array('|<subject>(.*)</subject>|is',false),$comment,$matches);
if ( ((isset($matches[0][(1)]) && Aspis_isset( $matches [0][(1)]))))
 {$comment_subject = $wpdb[0]->escape(Aspis_trim(attachAspis($matches,(1))));
if ( (('Re:') == $comment_subject[0]))
 $comment_subject = array('',false);
}Aspis_preg_match(array('|<body>(.*)</body>|is',false),$comment,$matches);
$comment_content = (!((empty($comment_subject) || Aspis_empty( $comment_subject)))) ? concat(concat2($comment_subject,"\n\n"),attachAspis($matches,(1))) : attachAspis($matches,(1));
$comment_content = @Aspis_html_entity_decode($comment_content,array(ENT_COMPAT,false),get_option(array('blog_charset',false)));
$comment_content = Aspis_str_replace(array('&apos;',false),array("'",false),$comment_content);
$comment_content = wpautop($comment_content);
$comment_content = Aspis_str_replace(array('<br>',false),array('<br />',false),$comment_content);
$comment_content = Aspis_str_replace(array('<hr>',false),array('<hr />',false),$comment_content);
$comment_content = Aspis_preg_replace_callback(array('|<(/?[A-Z]+)|',false),array(array(array($this,false),array('_normalize_tag',false)),false),$comment_content);
$comment_content = $wpdb[0]->escape(Aspis_trim($comment_content));
Aspis_preg_match(array('|<date>(.*)</date>|i',false),$comment,$matches);
$comment_date = Aspis_trim(Aspis_str_replace(array(array(array('T',false),array('Z',false)),false),array(' ',false),attachAspis($matches,(1))));
Aspis_preg_match(array('|<property name=\'poster_ip\'>(.*)</property>|i',false),$comment,$matches);
$comment_author_IP = ((isset($matches[0][(1)]) && Aspis_isset( $matches [0][(1)]))) ? attachAspis($matches,(1)) : array('',false);
$author = ((((empty($comment_author_ID) || Aspis_empty( $comment_author_ID))) || ((empty($this->usermap[0][$comment_author_ID[0]]) || Aspis_empty( $this ->usermap [0][$comment_author_ID[0]] )))) || (deAspis(Aspis_substr($this->usermap[0][$comment_author_ID[0]],array(0,false),array(4,false))) == ('ext_'))) ? __(array('Anonymous',false)) : $this->usermap[0][$comment_author_ID[0]];
if ( (deAspis(get_option(array('ljapi_username',false))) == $author[0]))
 {$user = wp_get_current_user();
$user_id = $user[0]->ID;
$author = $user[0]->display_name;
$url = trailingslashit(get_option(array('home',false)));
}else 
{{$user_id = array(0,false);
$url = (deAspis(__(array('Anonymous',false))) == $author[0]) ? array('',false) : concat2(concat1('http://',$author),'.livejournal.com/');
}}return array(array(deregisterTaint(array('lj_comment_ID',false)) => addTaint($lj_comment_ID),deregisterTaint(array('lj_comment_post_ID',false)) => addTaint($lj_comment_post_ID),deregisterTaint(array('lj_comment_parent',false)) => addTaint(((!((empty($lj_comment_parent) || Aspis_empty( $lj_comment_parent)))) ? $lj_comment_parent : array(0,false))),deregisterTaint(array('lj_comment_state',false)) => addTaint($lj_comment_state),deregisterTaint(array('comment_post_ID',false)) => addTaint($this->get_wp_post_ID($lj_comment_post_ID)),deregisterTaint(array('comment_author',false)) => addTaint($author),deregisterTaint(array('comment_author_url',false)) => addTaint($url),'comment_author_email' => array('',false,false),deregisterTaint(array('comment_content',false)) => addTaint($comment_content),deregisterTaint(array('comment_date',false)) => addTaint($comment_date),deregisterTaint(array('comment_author_IP',false)) => addTaint(((!((empty($comment_author_IP) || Aspis_empty( $comment_author_IP)))) ? $comment_author_IP : array('',false))),deregisterTaint(array('comment_approved',false)) => addTaint((deAspis(Aspis_in_array($lj_comment_state,array(array(array('A',false),array('F',false)),false))) ? array(1,false) : array(0,false))),deregisterTaint(array('comment_karma',false)) => addTaint($lj_comment_ID),deregisterTaint(array('comment_agent',false)) => addTaint($lj_comment_parent),'comment_type' => array('livejournal',false,false),deregisterTaint(array('user_ID',false)) => addTaint($user_id)),false);
} }
function get_wp_post_ID ( $post ) {
{global $wpdb;
if ( ((empty($this->postmap[0][$post[0]]) || Aspis_empty( $this ->postmap [0][$post[0]] ))))
 arrayAssign($this->postmap[0],deAspis(registerTaint($post)),addTaint(int_cast($wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT post_id FROM ",$wpdb[0]->postmeta)," WHERE meta_key = 'lj_itemid' AND meta_value = %d"),$post)))));
return $this->postmap[0][$post[0]];
} }
function get_wp_comment_ID ( $comment ) {
{global $wpdb;
if ( ((empty($this->commentmap[0][$comment[0]]) || Aspis_empty( $this ->commentmap [0][$comment[0]] ))))
 arrayAssign($this->commentmap[0],deAspis(registerTaint($comment)),addTaint($wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT comment_ID FROM ",$wpdb[0]->comments)," WHERE comment_karma = %d"),$comment))));
return $this->commentmap[0][$comment[0]];
} }
function lj_ixr (  ) {
{if ( deAspis($challenge = $this->ixr[0]->query(array('LJ.XMLRPC.getchallenge',false))))
 {$challenge = $this->ixr[0]->getResponse();
}if ( ((isset($challenge[0][('challenge')]) && Aspis_isset( $challenge [0][('challenge')]))))
 {$params = array(array(deregisterTaint(array('username',false)) => addTaint($this->username),'auth_method' => array('challenge',false,false),deregisterTaint(array('auth_challenge',false)) => addTaint($challenge[0]['challenge']),deregisterTaint(array('auth_response',false)) => addTaint(attAspis(md5((deconcat($challenge[0]['challenge'],attAspis(md5($this->password[0])))))))),false);
}else 
{{return array(new WP_Error(array('IXR',false),__(array('LiveJournal is not responding to authentication requests. Please wait a while and then try again.',false))),false);
}}$args = array(func_get_args(),false);
$method = Aspis_array_shift($args);
if ( ((isset($args[0][(0)]) && Aspis_isset( $args [0][(0)]))))
 $params = Aspis_array_merge($params,attachAspis($args,(0)));
if ( deAspis($this->ixr[0]->query(concat1('LJ.XMLRPC.',$method),$params)))
 {return $this->ixr[0]->getResponse();
}else 
{{return array(new WP_Error(array('IXR',false),concat(concat2(concat(__(array('XML-RPC Request Failed -- ',false)),$this->ixr[0]->getErrorCode()),': '),$this->ixr[0]->getErrorMessage())),false);
}}} }
function dispatch (  ) {
{if ( ((empty($_REQUEST[0][('step')]) || Aspis_empty( $_REQUEST [0][('step')]))))
 $step = array(0,false);
else 
{$step = int_cast($_REQUEST[0]['step']);
}$this->header();
switch ( $step[0] ) {
case deAspis(negate(array(1,false))):$this->cleanup();
case (0):$this->greet();
break ;
case (1):case (2):case (3):check_admin_referer(array('lj-api-import',false));
$result = $this->{(deconcat1('step',$step))}();
if ( deAspis(is_wp_error($result)))
 {$this->throw_error($result,$step);
}break ;
 }
$this->footer();
} }
function setup (  ) {
{global $verified;
if ( ((!((empty($_POST[0][('lj_username')]) || Aspis_empty( $_POST [0][('lj_username')])))) && (!((empty($_POST[0][('lj_password')]) || Aspis_empty( $_POST [0][('lj_password')]))))))
 {$this->username = $_POST[0]['lj_username'];
$this->password = $_POST[0]['lj_password'];
update_option(array('ljapi_username',false),$this->username);
update_option(array('ljapi_password',false),$this->password);
}else 
{{$this->username = get_option(array('ljapi_username',false));
$this->password = get_option(array('ljapi_password',false));
}}if ( (!((empty($_POST[0][('protected_password')]) || Aspis_empty( $_POST [0][('protected_password')])))))
 {$this->protected_password = $_POST[0]['protected_password'];
update_option(array('ljapi_protected_password',false),$this->protected_password);
}else 
{{$this->protected_password = get_option(array('ljapi_protected_password',false));
}}if ( (((empty($this->username) || Aspis_empty( $this ->username ))) || ((empty($this->password) || Aspis_empty( $this ->password )))))
 {;
?>
			<p><?php _e(array('Please enter your LiveJournal username <em>and</em> password so we can download your posts and comments.',false));
?></p>
			<p><a href="<?php echo AspisCheckPrint(esc_url(concat(concat2(concat(concat2($_SERVER[0]['PHP_SELF'],'?import=livejournal&amp;step=-1&amp;_wpnonce='),wp_create_nonce(array('lj-api-import',false))),'&amp;_wp_http_referer='),esc_attr(Aspis_str_replace(array('&step=1',false),array('',false),$_SERVER[0]['REQUEST_URI'])))));
?>"><?php _e(array('Start again',false));
?></a></p>
			<?php return array(false,false);
}$verified = $this->lj_ixr(array('login',false));
if ( deAspis(is_wp_error($verified)))
 {if ( (((100) == deAspis($this->ixr[0]->getErrorCode())) || ((101) == deAspis($this->ixr[0]->getErrorCode()))))
 {delete_option(array('ljapi_username',false));
delete_option(array('ljapi_password',false));
delete_option(array('ljapi_protected_password',false));
;
?>
				<p><?php _e(array('Logging in to LiveJournal failed. Check your username and password and try again.',false));
?></p>
				<p><a href="<?php echo AspisCheckPrint(esc_url(concat(concat2(concat(concat2($_SERVER[0]['PHP_SELF'],'?import=livejournal&amp;step=-1&amp;_wpnonce='),wp_create_nonce(array('lj-api-import',false))),'&amp;_wp_http_referer='),esc_attr(Aspis_str_replace(array('&step=1',false),array('',false),$_SERVER[0]['REQUEST_URI'])))));
?>"><?php _e(array('Start again',false));
?></a></p>
				<?php return array(false,false);
}else 
{{return $verified;
}}}else 
{{update_option(array('ljapi_verified',false),array('yes',false));
}}add_option(array('ljapi_sync_item_times',false),array('',false),array('',false),array('no',false));
add_option(array('ljapi_usermap',false),array('',false),array('',false),array('no',false));
update_option(array('ljapi_comment_batch',false),array(0,false));
return array(true,false);
} }
function step1 (  ) {
{global $verified;
set_time_limit(0);
update_option(array('ljapi_step',false),array(1,false));
if ( (denot_boolean($this->ixr)))
 $this->ixr = array(new IXR_Client($this->ixr_url,array(false,false),array(80,false),array(30,false)),false);
if ( ((empty($_POST[0][('login')]) || Aspis_empty( $_POST [0][('login')]))))
 {$this->username = get_option(array('ljapi_username',false));
$this->password = get_option(array('ljapi_password',false));
$this->protected_password = get_option(array('ljapi_protected_password',false));
}else 
{{$setup = $this->setup();
if ( (denot_boolean($setup)))
 {return array(false,false);
}else 
{if ( deAspis(is_wp_error($setup)))
 {$this->throw_error($setup,array(1,false));
return array(false,false);
}}}}echo AspisCheckPrint(array('<div id="ljapi-status">',false));
echo AspisCheckPrint(concat2(concat1('<h3>',__(array('Importing Posts',false))),'</h3>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('We&#8217;re downloading and importing your LiveJournal posts...',false))),'</p>'));
if ( (deAspis(get_option(array('ljapi_post_batch',false))) && count(deAspis(get_option(array('ljapi_sync_item_times',false))))))
 {$batch = attAspis(count(deAspis(get_option(array('ljapi_sync_item_times',false)))));
$batch = ($count[0] > (300)) ? attAspis(ceil(($batch[0] / (300)))) : array(1,false);
echo AspisCheckPrint(concat2(concat1('<p><strong>',Aspis_sprintf(__(array('Imported post batch %d of <strong>approximately</strong> %d',false)),(array(deAspis(get_option(array('ljapi_post_batch',false))) + (1),false)),$batch)),'</strong></p>'));
}ob_flush();
flush();
if ( ((denot_boolean(get_option(array('ljapi_lastsync',false)))) || (('1900-01-01 00:00:00') == deAspis(get_option(array('ljapi_lastsync',false))))))
 {$result = $this->download_post_meta();
if ( deAspis(is_wp_error($result)))
 {$this->throw_error($result,array(1,false));
return array(false,false);
}}$result = $this->download_post_bodies();
if ( deAspis(is_wp_error($result)))
 {if ( ((406) == deAspis($this->ixr[0]->getErrorCode())))
 {;
?>
				<p><strong><?php _e(array('Uh oh &ndash; LiveJournal has disconnected us because we made too many requests to their servers too quickly.',false));
?></strong></p>
				<p><strong><?php _e(array('We&#8217;ve saved where you were up to though, so if you come back to this importer in about 30 minutes, you should be able to continue from where you were.',false));
?></strong></p>
				<?php echo AspisCheckPrint($this->next_step(array(1,false),__(array('Try Again',false))));
return array(false,false);
}else 
{{$this->throw_error($result,array(1,false));
return array(false,false);
}}}if ( (deAspis(get_option(array('ljapi_last_sync_count',false))) > (0)))
 {;
?>
			<form action="admin.php?import=livejournal" method="post" id="ljapi-auto-repost">
			<?php wp_nonce_field(array('lj-api-import',false));
?>
			<input type="hidden" name="step" id="step" value="1" />
			<p><input type="submit" class="button-primary" value="<?php esc_attr_e(array('Import the next batch',false));
?>" /> <span id="auto-message"></span></p>
			</form>
			<?php $this->auto_ajax(array('ljapi-auto-repost',false),array('auto-message',false),array(0,false));
;
?>
		<?php }else 
{{echo AspisCheckPrint(concat2(concat1('<p>',__(array('Your posts have all been imported, but wait &#8211; there&#8217;s more! Now we need to download &amp; import your comments.',false))),'</p>'));
echo AspisCheckPrint($this->next_step(array(2,false),__(array('Download my comments &raquo;',false))));
$this->auto_submit();
}}echo AspisCheckPrint(array('</div>',false));
} }
function step2 (  ) {
{set_time_limit(0);
update_option(array('ljapi_step',false),array(2,false));
$this->username = get_option(array('ljapi_username',false));
$this->password = get_option(array('ljapi_password',false));
$this->ixr = array(new IXR_Client($this->ixr_url,array(false,false),array(80,false),array(30,false)),false);
echo AspisCheckPrint(array('<div id="ljapi-status">',false));
echo AspisCheckPrint(concat2(concat1('<h3>',__(array('Downloading Comments',false))),'</h3>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Now we will download your comments so we can import them (this could take a <strong>long</strong> time if you have lots of comments)...',false))),'</p>'));
ob_flush();
flush();
if ( (denot_boolean(get_option(array('ljapi_usermap',false)))))
 {$result = $this->download_comment_meta();
if ( deAspis(is_wp_error($result)))
 {$this->throw_error($result,array(2,false));
return array(false,false);
}}$result = $this->download_comment_bodies();
if ( deAspis(is_wp_error($result)))
 {$this->throw_error($result,array(2,false));
return array(false,false);
}$maxid = deAspis(get_option(array('ljapi_maxid',false))) ? int_cast(get_option(array('ljapi_maxid',false))) : array(1,false);
$highest_id = int_cast(get_option(array('ljapi_highest_comment_id',false)));
if ( ($maxid[0] > $highest_id[0]))
 {$batch = ($maxid[0] > (5000)) ? attAspis(ceil(($maxid[0] / (5000)))) : array(1,false);
;
?>
			<form action="admin.php?import=livejournal" method="post" id="ljapi-auto-repost">
			<p><strong><?php printf(deAspis(__(array('Imported comment batch %d of <strong>approximately</strong> %d',false))),deAspisRC(get_option(array('ljapi_comment_batch',false))),deAspisRC($batch));
?></strong></p>
			<?php wp_nonce_field(array('lj-api-import',false));
?>
			<input type="hidden" name="step" id="step" value="2" />
			<p><input type="submit" class="button-primary" value="<?php esc_attr_e(array('Import the next batch',false));
?>" /> <span id="auto-message"></span></p>
			</form>
			<?php $this->auto_ajax(array('ljapi-auto-repost',false),array('auto-message',false),array(0,false));
;
?>
		<?php }else 
{{echo AspisCheckPrint(concat2(concat1('<p>',__(array('Your comments have all been imported now, but we still need to rebuild your conversation threads.',false))),'</p>'));
echo AspisCheckPrint($this->next_step(array(3,false),__(array('Rebuild my comment threads &raquo;',false))));
$this->auto_submit();
}}echo AspisCheckPrint(array('</div>',false));
} }
function step3 (  ) {
{global $wpdb;
set_time_limit(0);
update_option(array('ljapi_step',false),array(3,false));
echo AspisCheckPrint(array('<div id="ljapi-status">',false));
echo AspisCheckPrint(concat2(concat1('<h3>',__(array('Threading Comments',false))),'</h3>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('We are now re-building the threading of your comments (this can also take a while if you have lots of comments)...',false))),'</p>'));
ob_flush();
flush();
$imported_comments = $wpdb[0]->get_var(concat2(concat1("SELECT COUNT(*) FROM ",$wpdb[0]->comments)," WHERE comment_type = 'livejournal'"));
$added_indices = array(false,false);
if ( ((5000) < $imported_comments[0]))
 {include_once (deconcat12(ABSPATH,'wp-admin/includes/upgrade.php'));
$added_indices = array(true,false);
add_clean_index($wpdb[0]->comments,array('comment_type',false));
add_clean_index($wpdb[0]->comments,array('comment_karma',false));
add_clean_index($wpdb[0]->comments,array('comment_agent',false));
}while ( deAspis($comments = $wpdb[0]->get_results(concat2(concat1("SELECT comment_ID, comment_agent FROM ",$wpdb[0]->comments)," WHERE comment_type = 'livejournal' AND comment_agent != '0' LIMIT 5000"),array(OBJECT,false))) )
{foreach ( $comments[0] as $comment  )
{$wpdb[0]->update($wpdb[0]->comments,array(array(deregisterTaint(array('comment_parent',false)) => addTaint($this->get_wp_comment_ID($comment[0]->comment_agent)),'comment_type' => array('livejournal-done',false,false)),false),array(array(deregisterTaint(array('comment_ID',false)) => addTaint($comment[0]->comment_ID)),false));
}wp_cache_flush();
$wpdb[0]->flush();
}if ( $added_indices[0])
 {drop_index($wpdb[0]->comments,array('comment_type',false));
drop_index($wpdb[0]->comments,array('comment_karma',false));
drop_index($wpdb[0]->comments,array('comment_agent',false));
$wpdb[0]->query(concat1("OPTIMIZE TABLE ",$wpdb[0]->comments));
}$this->cleanup();
do_action(array('import_done',false),array('livejournal',false));
if ( ($imported_comments[0] > (1)))
 echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array("Successfully re-threaded %s comments.",false)),attAspis(number_format($imported_comments[0])))),'</p>'));
echo AspisCheckPrint(array('<h3>',false));
printf(deAspis(__(array('All done. <a href="%s">Have fun!</a>',false))),deAspisRC(get_option(array('home',false))));
echo AspisCheckPrint(array('</h3>',false));
echo AspisCheckPrint(array('</div>',false));
} }
function throw_error ( $error,$step ) {
{echo AspisCheckPrint(concat2(concat1('<p><strong>',$error[0]->get_error_message()),'</strong></p>'));
echo AspisCheckPrint($this->next_step($step,__(array('Try Again',false))));
} }
function next_step ( $next_step,$label,$id = array('ljapi-next-form',false) ) {
{$str = concat2(concat1('<form action="admin.php?import=livejournal" method="post" id="',$id),'">');
$str = concat($str,wp_nonce_field(array('lj-api-import',false),array('_wpnonce',false),array(true,false),array(false,false)));
$str = concat($str,wp_referer_field(array(false,false)));
$str = concat($str,concat2(concat1('<input type="hidden" name="step" id="step" value="',esc_attr($next_step)),'" />'));
$str = concat($str,concat2(concat1('<p><input type="submit" class="button-primary" value="',esc_attr($label)),'" /> <span id="auto-message"></span></p>'));
$str = concat2($str,'</form>');
return $str;
} }
function auto_submit ( $id = array('ljapi-next-form',false),$msg = array('auto-message',false),$seconds = array(10,false) ) {
{;
?><script type="text/javascript">
			next_counter = <?php echo AspisCheckPrint($seconds);
?>;
			jQuery(document).ready(function(){
				ljapi_msg();
			});

			function ljapi_msg() {
				str = '<?php _e(array("Continuing in %d",false));
?>';
				jQuery( '#<?php echo AspisCheckPrint($msg);
?>' ).text( str.replace( /%d/, next_counter ) );
				if ( next_counter <= 0 ) {
					if ( jQuery( '#<?php echo AspisCheckPrint($id);
?>' ).length ) {
						jQuery( "#<?php echo AspisCheckPrint($id);
?> input[type='submit']" ).hide();
						str = '<?php _e(array("Continuing",false));
?> <img src="images/wpspin_light.gif" alt="" id="processing" align="top" />';
						jQuery( '#<?php echo AspisCheckPrint($msg);
?>' ).html( str );
						jQuery( '#<?php echo AspisCheckPrint($id);
?>' ).submit();
						return;
					}
				}
				next_counter = next_counter - 1;
				setTimeout('ljapi_msg()', 1000);
			}
		</script><?php } }
function auto_ajax ( $id = array('ljapi-next-form',false),$msg = array('auto-message',false),$seconds = array(5,false) ) {
{;
?><script type="text/javascript">
			next_counter = <?php echo AspisCheckPrint($seconds);
?>;
			jQuery(document).ready(function(){
				ljapi_msg();
			});

			function ljapi_msg() {
				str = '<?php _e(array("Continuing in %d",false));
?>';
				jQuery( '#<?php echo AspisCheckPrint($msg);
?>' ).text( str.replace( /%d/, next_counter ) );
				if ( next_counter <= 0 ) {
					if ( jQuery( '#<?php echo AspisCheckPrint($id);
?>' ).length ) {
						jQuery( "#<?php echo AspisCheckPrint($id);
?> input[type='submit']" ).hide();
						jQuery.ajaxSetup({'timeout':3600000});
						str = '<?php _e(array("Processing next batch.",false));
?> <img src="images/wpspin_light.gif" alt="" id="processing" align="top" />';
						jQuery( '#<?php echo AspisCheckPrint($msg);
?>' ).html( str );
						jQuery('#ljapi-status').load(ajaxurl, {'action':'lj-importer',
																'step':jQuery('#step').val(),
																'_wpnonce':'<?php echo AspisCheckPrint(wp_create_nonce(array('lj-api-import',false)));
?>',
																'_wp_http_referer':'<?php echo AspisCheckPrint($_SERVER[0]['REQUEST_URI']);
?>'});
						return;
					}
				}
				next_counter = next_counter - 1;
				setTimeout('ljapi_msg()', 1000);
			}
		</script><?php } }
function cleanup (  ) {
{global $wpdb;
delete_option(array('ljapi_username',false));
delete_option(array('ljapi_password',false));
delete_option(array('ljapi_protected_password',false));
delete_option(array('ljapi_verified',false));
delete_option(array('ljapi_total',false));
delete_option(array('ljapi_count',false));
delete_option(array('ljapi_lastsync',false));
delete_option(array('ljapi_last_sync_count',false));
delete_option(array('ljapi_sync_item_times',false));
delete_option(array('ljapi_lastsync_posts',false));
delete_option(array('ljapi_post_batch',false));
delete_option(array('ljapi_imported_count',false));
delete_option(array('ljapi_maxid',false));
delete_option(array('ljapi_usermap',false));
delete_option(array('ljapi_highest_id',false));
delete_option(array('ljapi_highest_comment_id',false));
delete_option(array('ljapi_comment_batch',false));
delete_option(array('ljapi_step',false));
$wpdb[0]->update($wpdb[0]->comments,array(array('comment_karma' => array(0,false,false),'comment_agent' => array('WP LJ Importer',false,false),'comment_type' => array('',false,false)),false),array(array('comment_type' => array('livejournal-done',false,false)),false));
$wpdb[0]->update($wpdb[0]->comments,array(array('comment_karma' => array(0,false,false),'comment_agent' => array('WP LJ Importer',false,false),'comment_type' => array('',false,false)),false),array(array('comment_type' => array('livejournal',false,false)),false));
} }
function LJ_API_Import (  ) {
{$this->__construct();
} }
function __construct (  ) {
{} }
}$lj_api_import = array(new LJ_API_Import(),false);
register_importer(array('livejournal',false),__(array('LiveJournal',false)),__(array('Import posts from LiveJournal using their API.',false)),array(array($lj_api_import,array('dispatch',false)),false));
;
?>
<?php 