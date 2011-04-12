<?php require_once('AspisMain.php'); ?><?php
function comment_exists ( $comment_author,$comment_date ) {
global $wpdb;
$comment_author = Aspis_stripslashes($comment_author);
$comment_date = Aspis_stripslashes($comment_date);
return $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT comment_post_ID FROM ",$wpdb[0]->comments),"
			WHERE comment_author = %s AND comment_date = %s"),$comment_author,$comment_date));
 }
function edit_comment (  ) {
$comment_post_ID = int_cast($_POST[0]['comment_post_ID']);
if ( (denot_boolean(current_user_can(array('edit_post',false),$comment_post_ID))))
 wp_die(__(array('You are not allowed to edit comments on this post, so you cannot edit this comment.',false)));
arrayAssign($_POST[0],deAspis(registerTaint(array('comment_author',false))),addTaint($_POST[0]['newcomment_author']));
arrayAssign($_POST[0],deAspis(registerTaint(array('comment_author_email',false))),addTaint($_POST[0]['newcomment_author_email']));
arrayAssign($_POST[0],deAspis(registerTaint(array('comment_author_url',false))),addTaint($_POST[0]['newcomment_author_url']));
arrayAssign($_POST[0],deAspis(registerTaint(array('comment_approved',false))),addTaint($_POST[0]['comment_status']));
arrayAssign($_POST[0],deAspis(registerTaint(array('comment_content',false))),addTaint($_POST[0]['content']));
arrayAssign($_POST[0],deAspis(registerTaint(array('comment_ID',false))),addTaint(int_cast($_POST[0]['comment_ID'])));
foreach ( (array(array('aa',false),array('mm',false),array('jj',false),array('hh',false),array('mn',false))) as $timeunit  )
{if ( ((!((empty($_POST[0][(deconcat1('hidden_',$timeunit))]) || Aspis_empty( $_POST [0][(deconcat1('hidden_',$timeunit))])))) && (deAspis(attachAspis($_POST,(deconcat1('hidden_',$timeunit)))) != deAspis(attachAspis($_POST,$timeunit[0])))))
 {arrayAssign($_POST[0],deAspis(registerTaint(array('edit_date',false))),addTaint(array('1',false)));
break ;
}}if ( (!((empty($_POST[0][('edit_date')]) || Aspis_empty( $_POST [0][('edit_date')])))))
 {$aa = $_POST[0]['aa'];
$mm = $_POST[0]['mm'];
$jj = $_POST[0]['jj'];
$hh = $_POST[0]['hh'];
$mn = $_POST[0]['mn'];
$ss = $_POST[0]['ss'];
$jj = ($jj[0] > (31)) ? array(31,false) : $jj;
$hh = ($hh[0] > (23)) ? array($hh[0] - (24),false) : $hh;
$mn = ($mn[0] > (59)) ? array($mn[0] - (60),false) : $mn;
$ss = ($ss[0] > (59)) ? array($ss[0] - (60),false) : $ss;
arrayAssign($_POST[0],deAspis(registerTaint(array('comment_date',false))),addTaint(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2($aa,"-"),$mm),"-"),$jj)," "),$hh),":"),$mn),":"),$ss)));
}wp_update_comment($_POST);
 }
function get_comment_to_edit ( $id ) {
if ( (denot_boolean($comment = get_comment($id))))
 return array(false,false);
$comment[0]->comment_ID = int_cast($comment[0]->comment_ID);
$comment[0]->comment_post_ID = int_cast($comment[0]->comment_post_ID);
$comment[0]->comment_content = format_to_edit($comment[0]->comment_content);
$comment[0]->comment_content = apply_filters(array('comment_edit_pre',false),$comment[0]->comment_content);
$comment[0]->comment_author = format_to_edit($comment[0]->comment_author);
$comment[0]->comment_author_email = format_to_edit($comment[0]->comment_author_email);
$comment[0]->comment_author_url = format_to_edit($comment[0]->comment_author_url);
$comment[0]->comment_author_url = esc_url($comment[0]->comment_author_url);
return $comment;
 }
function get_pending_comments_num ( $post_id ) {
global $wpdb;
$single = array(false,false);
if ( (!(is_array($post_id[0]))))
 {$post_id = array_cast($post_id);
$single = array(true,false);
}$post_id = attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC($post_id)));
$post_id = concat2(concat1("'",Aspis_implode(array("', '",false),$post_id)),"'");
$pending = $wpdb[0]->get_results(concat2(concat(concat2(concat1("SELECT comment_post_ID, COUNT(comment_ID) as num_comments FROM ",$wpdb[0]->comments)," WHERE comment_post_ID IN ( "),$post_id)," ) AND comment_approved = '0' GROUP BY comment_post_ID"),array(ARRAY_N,false));
if ( ((empty($pending) || Aspis_empty( $pending))))
 return array(0,false);
if ( $single[0])
 return attachAspis($pending[0][(0)],(1));
$pending_keyed = array(array(),false);
foreach ( $pending[0] as $pend  )
arrayAssign($pending_keyed[0],deAspis(registerTaint(attachAspis($pend,(0)))),addTaint(attachAspis($pend,(1))));
return $pending_keyed;
 }
function floated_admin_avatar ( $name ) {
global $comment;
$id = $avatar = array(false,false);
if ( $comment[0]->comment_author_email[0])
 $id = $comment[0]->comment_author_email;
if ( $comment[0]->user_id[0])
 $id = $comment[0]->user_id;
if ( $id[0])
 $avatar = get_avatar($id,array(32,false));
return concat(concat2($avatar," "),$name);
 }
function enqueue_comment_hotkeys_js (  ) {
if ( (('true') == deAspis(get_user_option(array('comment_shortcuts',false)))))
 wp_enqueue_script(array('jquery-table-hotkeys',false));
 }
if ( ((deAspis(is_admin()) && ((isset($pagenow) && Aspis_isset( $pagenow)))) && ((('edit-comments.php') == $pagenow[0]) || (('edit.php') == $pagenow[0]))))
 {if ( deAspis(get_option(array('show_avatars',false))))
 add_filter(array('comment_author',false),array('floated_admin_avatar',false));
};
?>
<?php 