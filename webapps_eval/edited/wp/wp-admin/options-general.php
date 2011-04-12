<?php require_once('AspisMain.php'); ?><?php
require_once ('./admin.php');
if ( (denot_boolean(current_user_can(array('manage_options',false)))))
 wp_die(__(array('You do not have sufficient permissions to manage options for this blog.',false)));
$title = __(array('General Settings',false));
$parent_file = array('options-general.php',false);
$timezone_format = _x(array('Y-m-d G:i:s',false),array('timezone date format',false));
function add_js (  ) {
;
?>
<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready(function($){
		$("input[name='date_format']").click(function(){
			if ( "date_format_custom_radio" != $(this).attr("id") )
				$("input[name='date_format_custom']").val( $(this).val() );
		});
		$("input[name='date_format_custom']").focus(function(){
			$("#date_format_custom_radio").attr("checked", "checked");
		});

		$("input[name='time_format']").click(function(){
			if ( "time_format_custom_radio" != $(this).attr("id") )
				$("input[name='time_format_custom']").val( $(this).val() );
		});
		$("input[name='time_format_custom']").focus(function(){
			$("#time_format_custom_radio").attr("checked", "checked");
		});
	});
//]]>
</script>
<?php  }
add_filter(array('admin_head',false),array('add_js',false));
include ('./admin-header.php');
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<form method="post" action="options.php">
<?php settings_fields(array('general',false));
;
?>

<table class="form-table">
<tr valign="top">
<th scope="row"><label for="blogname"><?php _e(array('Blog Title',false));
?></label></th>
<td><input name="blogname" type="text" id="blogname" value="<?php form_option(array('blogname',false));
;
?>" class="regular-text" /></td>
</tr>
<tr valign="top">
<th scope="row"><label for="blogdescription"><?php _e(array('Tagline',false));
?></label></th>
<td><input name="blogdescription" type="text" id="blogdescription"  value="<?php form_option(array('blogdescription',false));
;
?>" class="regular-text" />
<span class="description"><?php _e(array('In a few words, explain what this blog is about.',false));
?></span></td>
</tr>
<tr valign="top">
<th scope="row"><label for="siteurl"><?php _e(array('WordPress address (URL)',false));
?></label></th>
<td><input name="siteurl" type="text" id="siteurl" value="<?php form_option(array('siteurl',false));
;
?>" class="regular-text code<?php if ( defined(('WP_SITEURL')))
 {;
?> disabled" disabled="disabled"<?php }else 
{;
?>"<?php };
?> /></td>
</tr>
<tr valign="top">
<th scope="row"><label for="home"><?php _e(array('Blog address (URL)',false));
?></label></th>
<td><input name="home" type="text" id="home" value="<?php form_option(array('home',false));
;
?>" class="regular-text code<?php if ( defined(('WP_HOME')))
 {;
?> disabled" disabled="disabled"<?php }else 
{;
?>"<?php };
?> />
<span class="description"><?php _e(array('Enter the address here if you want your blog homepage <a href="http://codex.wordpress.org/Giving_WordPress_Its_Own_Directory">to be different from the directory</a> you installed WordPress.',false));
;
?></span></td>
</tr>
<tr valign="top">
<th scope="row"><label for="admin_email"><?php _e(array('E-mail address',false));
?> </label></th>
<td><input name="admin_email" type="text" id="admin_email" value="<?php form_option(array('admin_email',false));
;
?>" class="regular-text" />
<span class="description"><?php _e(array('This address is used for admin purposes, like new user notification.',false));
?></span></td>
</tr>
<tr valign="top">
<th scope="row"><?php _e(array('Membership',false));
?></th>
<td> <fieldset><legend class="screen-reader-text"><span><?php _e(array('Membership',false));
?></span></legend><label for="users_can_register">
<input name="users_can_register" type="checkbox" id="users_can_register" value="1" <?php checked(array('1',false),get_option(array('users_can_register',false)));
;
?> />
<?php _e(array('Anyone can register',false));
?></label>
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><label for="default_role"><?php _e(array('New User Default Role',false));
?></label></th>
<td>
<select name="default_role" id="default_role"><?php wp_dropdown_roles(get_option(array('default_role',false)));
;
?></select>
</td>
</tr>
<tr>
<?php if ( (denot_boolean(wp_timezone_supported())))
 {;
?>
<th scope="row"><label for="gmt_offset"><?php _e(array('Timezone',false));
?> </label></th>
<td>
<select name="gmt_offset" id="gmt_offset">
<?php $current_offset = get_option(array('gmt_offset',false));
$offset_range = array(array(negate(array(12,false)),negate(array(11.5,false)),negate(array(11,false)),negate(array(10.5,false)),negate(array(10,false)),negate(array(9.5,false)),negate(array(9,false)),negate(array(8.5,false)),negate(array(8,false)),negate(array(7.5,false)),negate(array(7,false)),negate(array(6.5,false)),negate(array(6,false)),negate(array(5.5,false)),negate(array(5,false)),negate(array(4.5,false)),negate(array(4,false)),negate(array(3.5,false)),negate(array(3,false)),negate(array(2.5,false)),negate(array(2,false)),negate(array(1.5,false)),negate(array(1,false)),negate(array(0.5,false)),array(0,false),array(0.5,false),array(1,false),array(1.5,false),array(2,false),array(2.5,false),array(3,false),array(3.5,false),array(4,false),array(4.5,false),array(5,false),array(5.5,false),array(5.75,false),array(6,false),array(6.5,false),array(7,false),array(7.5,false),array(8,false),array(8.5,false),array(8.75,false),array(9,false),array(9.5,false),array(10,false),array(10.5,false),array(11,false),array(11.5,false),array(12,false),array(12.75,false),array(13,false),array(13.75,false),array(14,false)),false);
foreach ( $offset_range[0] as $offset  )
{if ( ((0) < $offset[0]))
 $offset_name = concat1('+',$offset);
elseif ( ((0) == $offset[0]))
 $offset_name = array('',false);
else 
{$offset_name = string_cast($offset);
}$offset_name = Aspis_str_replace(array(array(array('.25',false),array('.5',false),array('.75',false)),false),array(array(array(':15',false),array(':30',false),array(':45',false)),false),$offset_name);
$selected = array('',false);
if ( ($current_offset[0] == $offset[0]))
 {$selected = array(" selected='selected'",false);
$current_offset_name = $offset_name;
}echo AspisCheckPrint(concat2(concat(concat(concat1("<option value=\"",esc_attr($offset)),concat2(concat1("\"",$selected),">")),Aspis_sprintf(__(array('UTC %s',false)),$offset_name)),'</option>'));
};
?>
</select>
<?php _e(array('hours',false));
;
?>
<span id="utc-time"><?php printf(deAspis(__(array('<abbr title="Coordinated Universal Time">UTC</abbr> time is <code>%s</code>',false))),deAspisRC(date_i18n($time_format,array(false,false),array('gmt',false))));
;
?></span>
<?php if ( $current_offset[0])
 {;
?>
	<span id="local-time"><?php printf(deAspis(__(array('UTC %1$s is <code>%2$s</code>',false))),deAspisRC($current_offset_name),deAspisRC(date_i18n($time_format)));
;
?></span>
<?php };
?>
<br />
<span class="description"><?php _e(array('Unfortunately, you have to manually update this for Daylight Savings Time. Lame, we know, but will be fixed in the future.',false));
;
?></span>
</td>
<?php }else 
{$current_offset = get_option(array('gmt_offset',false));
$tzstring = get_option(array('timezone_string',false));
$check_zone_info = array(true,false);
if ( (false !== strpos($tzstring[0],'Etc/GMT')))
 $tzstring = array('',false);
if ( ((empty($tzstring) || Aspis_empty( $tzstring))))
 {$check_zone_info = array(false,false);
if ( ((0) == $current_offset[0]))
 $tzstring = array('UTC+0',false);
elseif ( ($current_offset[0] < (0)))
 $tzstring = concat1('UTC',$current_offset);
else 
{$tzstring = concat1('UTC+',$current_offset);
}};
?>
<th scope="row"><label for="timezone_string"><?php _e(array('Timezone',false));
?></label></th>
<td>

<select id="timezone_string" name="timezone_string">
<?php echo AspisCheckPrint(wp_timezone_choice($tzstring));
;
?>
</select>

    <span id="utc-time"><?php printf(deAspis(__(array('<abbr title="Coordinated Universal Time">UTC</abbr> time is <code>%s</code>',false))),deAspisRC(date_i18n($timezone_format,array(false,false),array('gmt',false))));
;
?></span>
<?php if ( deAspis(get_option(array('timezone_string',false))))
 {;
?>
	<span id="local-time"><?php printf(deAspis(__(array('Local time is <code>%1$s</code>',false))),deAspisRC(date_i18n($timezone_format)));
;
?></span>
<?php };
?>
<br />
<span class="description"><?php _e(array('Choose a city in the same timezone as you.',false));
;
?></span>
<br />
<span>
<?php if ( ($check_zone_info[0] && $tzstring[0]))
 {;
?>
	<?php $now = attAspisRC(localtime(time(),true));
if ( deAspis($now[0]['tm_isdst']))
 _e(array('This timezone is currently in daylight savings time.',false));
else 
{_e(array('This timezone is currently in standard time.',false));
};
?>
	<br />
	<?php if ( function_exists(('timezone_transitions_get')))
 {$dateTimeZoneSelected = array(new DateTimeZone($tzstring),false);
foreach ( (timezone_transitions_get(deAspisRC($dateTimeZoneSelected))) as $tr  )
{if ( (deAspis($tr[0]['ts']) > time()))
 {$found = array(true,false);
break ;
}}if ( (((isset($found) && Aspis_isset( $found))) && ($found[0] === true)))
 {echo AspisCheckPrint(array(' ',false));
$message = deAspis($tr[0]['isdst']) ? __(array('Daylight savings time begins on: <code>%s</code>.',false)) : __(array('Standard time begins  on: <code>%s</code>.',false));
printf($message[0],deAspisRC(date_i18n(concat(concat2(get_option(array('date_format',false)),' '),get_option(array('time_format',false))),$tr[0]['ts'])));
}else 
{{_e(array('This timezone does not observe daylight savings time.',false));
}}};
?>
	</span>
<?php };
?>
</td>

<?php };
?>
</tr>
<tr>
<th scope="row"><?php _e(array('Date Format',false));
?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e(array('Date Format',false));
?></span></legend>
<?php $date_formats = apply_filters(array('date_formats',false),array(array(__(array('F j, Y',false)),array('Y/m/d',false),array('m/d/Y',false),array('d/m/Y',false),),false));
$custom = array(TRUE,false);
foreach ( $date_formats[0] as $format  )
{echo AspisCheckPrint(concat2(concat(concat2(concat1("\t<label title='",esc_attr($format)),"'><input type='radio' name='date_format' value='"),esc_attr($format)),"'"));
if ( (deAspis(get_option(array('date_format',false))) === $format[0]))
 {echo AspisCheckPrint(array(" checked='checked'",false));
$custom = array(FALSE,false);
}echo AspisCheckPrint(concat2(concat1(' /> ',date_i18n($format)),"</label><br />\n"));
}echo AspisCheckPrint(array('	<label><input type="radio" name="date_format" id="date_format_custom_radio" value="\c\u\s\t\o\m"',false));
checked($custom);
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1('/> ',__(array('Custom:',false))),' </label><input type="text" name="date_format_custom" value="'),esc_attr(get_option(array('date_format',false)))),'" class="small-text" /> '),date_i18n(get_option(array('date_format',false)))),"\n"));
echo AspisCheckPrint(concat2(concat1("\t<p>",__(array('<a href="http://codex.wordpress.org/Formatting_Date_and_Time">Documentation on date formatting</a>. Click &#8220;Save Changes&#8221; to update sample output.',false))),"</p>\n"));
;
?>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row"><?php _e(array('Time Format',false));
?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e(array('Time Format',false));
?></span></legend>
<?php $time_formats = apply_filters(array('time_formats',false),array(array(__(array('g:i a',false)),array('g:i A',false),array('H:i',false),),false));
$custom = array(TRUE,false);
foreach ( $time_formats[0] as $format  )
{echo AspisCheckPrint(concat2(concat(concat2(concat1("\t<label title='",esc_attr($format)),"'><input type='radio' name='time_format' value='"),esc_attr($format)),"'"));
if ( (deAspis(get_option(array('time_format',false))) === $format[0]))
 {echo AspisCheckPrint(array(" checked='checked'",false));
$custom = array(FALSE,false);
}echo AspisCheckPrint(concat2(concat1(' /> ',date_i18n($format)),"</label><br />\n"));
}echo AspisCheckPrint(array('	<label><input type="radio" name="time_format" id="time_format_custom_radio" value="\c\u\s\t\o\m"',false));
checked($custom);
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1('/> ',__(array('Custom:',false))),' </label><input type="text" name="time_format_custom" value="'),esc_attr(get_option(array('time_format',false)))),'" class="small-text" /> '),date_i18n(get_option(array('time_format',false)))),"\n"));
;
?>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row"><label for="start_of_week"><?php _e(array('Week Starts On',false));
?></label></th>
<td><select name="start_of_week" id="start_of_week">
<?php for ( $day_index = array(0,false) ; ($day_index[0] <= (6)) ; postincr($day_index) )
{$selected = (deAspis(get_option(array('start_of_week',false))) == $day_index[0]) ? array('selected="selected"',false) : array('',false);
echo AspisCheckPrint(concat2(concat(concat(concat1("\n\t<option value='",esc_attr($day_index)),concat2(concat1("' ",$selected),">")),$wp_locale[0]->get_weekday($day_index)),'</option>'));
};
?>
</select></td>
</tr>
<?php do_settings_fields(array('general',false),array('default',false));
;
?>
</table>

<?php do_settings_sections(array('general',false));
;
?>

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e(array('Save Changes',false));
?>" />
</p>
</form>

</div>

<?php include ('./admin-footer.php');
?>
<?php 