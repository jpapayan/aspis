<?php require_once('AspisMain.php'); ?><?php
global $wp_db_version;
if ( ($wp_db_version[0] >= (7558)))
 {if ( (('embedded-video.php') == deAspis(Aspis_basename($_SERVER[0]['SCRIPT_FILENAME']))))
 Aspis_exit(array('Please do not access this file directly. Thanks!',false));
define(("EV_VERSION"),41);
function embeddedvideo_initialize (  ) {
add_option(array('embeddedvideo_prefix',false),array("Direkt",false));
add_option(array('embeddedvideo_space',false),array("false",false));
add_option(array('embeddedvideo_width',false),array(425,false));
add_option(array('embeddedvideo_small',false),array("false",false));
add_option(array('embeddedvideo_pluginlink',false),array("true",false));
add_option(array('embeddedvideo_version',false),array(EV_VERSION,false));
add_option(array('embeddedvideo_shownolink',false),array("false",false));
add_option(array('embeddedvideo_showinfeed',false),array("true",false));
update_option(array('embeddedvideo_version',false),array(EV_VERSION,false));
 }
if ( (('true') == deAspis(get_option(array('embeddedvideo_space',false)))))
 {$ev_space = array('&nbsp;',false);
}else 
{{$ev_space = array('',false);
}}define(("LINKTEXT"),(deconcat(get_option(array('embeddedvideo_prefix',false)),$ev_space)));
define(("GENERAL_WIDTH"),deAspisRC(get_option(array('embeddedvideo_width',false))));
define(("YOUTUBE_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (14)) / (17))))));
define(("GOOGLE_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (14)) / (17))))));
define(("MYVIDEO_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (367)) / (425))))));
define(("CLIPFISH_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (95)) / (116))))));
define(("SEVENLOAD_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (408)) / (500))))));
define(("REVVER_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (49)) / (60))))));
define(("METACAFE_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (69)) / (80))))));
define(("YAHOO_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (14)) / (17))))));
define(("IFILM_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (365)) / (448))))));
define(("MYSPACE_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (173)) / (215))))));
define(("BRIGHTCOVE_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (206)) / (243))))));
define(("QUICKTIME_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (3)) / (4))))));
define(("VIDEO_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (3)) / (4))))));
define(("ANIBOOM_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (93)) / (112))))));
define(("FLASHPLAYER_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (93)) / (112))))));
define(("VIMEO_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (3)) / (4))))));
define(("GUBA_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (72)) / (75))))));
define(("DAILYMOTION_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (334)) / (425))))));
define(("GARAGE_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (289)) / (430))))));
define(("GAMEVIDEO_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (3)) / (4))))));
define(("VSOCIAL_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (40)) / (41))))));
define(("VEOH_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (73)) / (90))))));
define(("GAMETRAILERS_HEIGHT"),deAspisRC(attAspis(floor(((GENERAL_WIDTH * (392)) / (480))))));
define(("YOUTUBE_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://www.youtube.com/v/###VID###\" width=\"",GENERAL_WIDTH),"\" height=\""),YOUTUBE_HEIGHT),"\"><param name=\"movie\" value=\"http://www.youtube.com/v/###VID###\" /><param name=\"autostart\" value=\"true\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("YOUTUBE_LINK"),"<a title=\"YouTube\" href=\"http://www.youtube.com/watch?v=###VID###\">YouTube ###TXT######THING###</a>");
define(("GOOGLE_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://video.google.com/googleplayer.swf?docId=###VID###\" width=\"",GENERAL_WIDTH),"\" height=\""),GOOGLE_HEIGHT),"\"><param name=\"movie\" value=\"http://video.google.com/googleplayer.swf?docId=###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("GOOGLE_LINK"),"<a title=\"Google Video\" href=\"http://video.google.com/videoplay?docid=###VID###\">Google ###TXT######THING###</a>");
define(("MYVIDEO_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://www.myvideo.de/movie/###VID###\" width=\"",GENERAL_WIDTH),"\" height=\""),MYVIDEO_HEIGHT),"\"><param name=\"movie\" value=\"http://www.myvideo.de/movie/###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("MYVIDEO_LINK"),"<a title=\"MyVideo\" href=\"http://www.myvideo.de/watch/###VID###\">MyVideo ###TXT######THING###</a>");
define(("CLIPFISH_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://www.clipfish.de/videoplayer.swf?as=0&amp;videoid=###VID###&amp;r=1\" width=\"",GENERAL_WIDTH),"\" height=\""),CLIPFISH_HEIGHT),"\"><param name=\"movie\" value=\"http://www.clipfish.de/videoplayer.swf?as=0&amp;videoid=###VID###&amp;r=1\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("CLIPFISH_LINK"),"<a title=\"Clipfish\" href=\"http://www.clipfish.de/player.php?videoid=###VID###\">Clipfish ###TXT######THING###</a>");
define(("SEVENLOAD_TARGET"),(deconcat2(concat2(concat2(concat12("<script type='text/javascript' src='http://sevenload.com/pl/###VID###/",GENERAL_WIDTH),"x"),SEVENLOAD_HEIGHT),"'></script><br />")));
define(("SEVENLOAD_LINK"),"<a title=\"Sevenload\" href=\"http://sevenload.com/videos/###VID###\">Sevenload ###TXT######THING###</a>");
define(("REVVER_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://flash.revver.com/player/1.0/player.swf?mediaId=###VID###\" width=\"",GENERAL_WIDTH),"\" height=\""),REVVER_HEIGHT),"\"><param name=\"movie\" value=\"http://flash.revver.com/player/1.0/player.swf?mediaId=###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("REVVER_LINK"),"<a title=\"Revver\" href=\"http://one.revver.com/watch/###VID###\">Revver ###TXT######THING###</a>");
define(("METACAFE_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://www.metacafe.com/fplayer/###VID###.swf\" width=\"",GENERAL_WIDTH),"\" height=\""),METACAFE_HEIGHT),"\"><param name=\"movie\" value=\"http://www.metacafe.com/fplayer/###VID###.swf\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("METACAFE_LINK"),"<a title=\"Metacaf&eacute;\" href=\"http://www.metacafe.com/watch/###VID###\">Metacaf&eacute; ###TXT######THING###</a>");
define(("YAHOO_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://us.i1.yimg.com/cosmos.bcst.yahoo.com/player/media/swf/FLVVideoSolo.swf?id=###VID###\" width=\"",GENERAL_WIDTH),"\" height=\""),YAHOO_HEIGHT),"\"><param name=\"movie\" value=\"http://us.i1.yimg.com/cosmos.bcst.yahoo.com/player/media/swf/FLVVideoSolo.swf?id=###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("YAHOO_LINK"),"<a title=\"Yahoo! Video\" href=\"http://video.yahoo.com/video/play?vid=###YAHOO###.###VID###\">Yahoo! ###TXT######THING###</a>");
define(("IFILM_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://www.ifilm.com/efp?flvbaseclip=###VID###\" width=\"",GENERAL_WIDTH),"\" height=\""),IFILM_HEIGHT),"\"><param name=\"movie\" value=\"http://www.ifilm.com/efp?flvbaseclip=###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("IFILM_LINK"),"<a title=\"ifilm\" href=\"http://www.ifilm.com/video/###VID###\">ifilm ###TXT######THING###</a>");
define(("MYSPACE_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://lads.myspace.com/videos/vplayer.swf?m=###VID###&amp;type=video\" width=\"",GENERAL_WIDTH),"\" height=\""),MYSPACE_HEIGHT),"\"><param name=\"movie\" value=\"http://lads.myspace.com/videos/vplayer.swf?m=###VID###&amp;type=video\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("MYSPACE_LINK"),"<a title=\"MySpace Video\" href=\"http://vids.myspace.com/index.cfm?fuseaction=vids.individual&amp;videoid=###VID###\">MySpace ###TXT######THING###</a>");
define(("BRIGHTCOVE_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://admin.brightcove.com/destination/player/player.swf?initVideoId=###VID###&amp;servicesURL=http://services.brightcove.com/services&amp;viewerSecureGatewayURL=https://services.brightcove.com/services/amfgateway&amp;cdnURL=http://admin.brightcove.com&amp;autoStart=false\" width=\"",GENERAL_WIDTH),"\" height=\""),BRIGHTCOVE_HEIGHT),"\"><param name=\"movie\" value=\"http://admin.brightcove.com/destination/player/player.swf?initVideoId=###VID###&amp;servicesURL=http://services.brightcove.com/services&amp;viewerSecureGatewayURL=https://services.brightcove.com/services/amfgateway&amp;cdnURL=http://admin.brightcove.com&amp;autoStart=false\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("BRIGHTCOVE_LINK"),"<a title=\"brightcove\" href=\"http://www.brightcove.com/title.jsp?title=###VID###\">brightcove ###TXT######THING###</a>");
define(("ANIBOOM_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://api.aniboom.com/embedded.swf?videoar=###VID###&amp;allowScriptAccess=sameDomain&amp;quality=high\" width=\"",GENERAL_WIDTH),"\" height=\""),ANIBOOM_HEIGHT),"\"><param name=\"movie\" value=\"http://api.aniboom.com/embedded.swf?videoar=###VID###&amp;allowScriptAccess=sameDomain&amp;quality=high\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("ANIBOOM_LINK"),"<a title=\"aniBOOM\" href=\"http://www.aniboom.com/Player.aspx?v=###VID###\">aniBOOM ###TXT######THING###</a>");
define(("VIMEO_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://www.vimeo.com/moogaloop.swf?clip_id=###VID###\" width=\"",GENERAL_WIDTH),"\" height=\""),VIMEO_HEIGHT),"\"><param name=\"movie\" value=\"http://www.vimeo.com/moogaloop.swf?clip_id=###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("VIMEO_LINK"),"<a title=\"vimeo\" href=\"http://www.vimeo.com/clip:###VID###\">vimeo ###TXT######THING###</a>");
define(("GUBA_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://www.guba.com/f/root.swf?video_url=http://free.guba.com/uploaditem/###VID###/flash.flv&amp;isEmbeddedPlayer=true\" width=\"",GENERAL_WIDTH),"\" height=\""),GUBA_HEIGHT),"\"><param name=\"movie\" value=\"http://www.guba.com/f/root.swf?video_url=http://free.guba.com/uploaditem/###VID###/flash.flv&amp;isEmbeddedPlayer=true\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("GUBA_LINK"),"<a title=\"GUBA\" href=\"http://www.guba.com/watch/###VID###\">GUBA ###TXT######THING###</a>");
define(("DAILYMOTION_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://www.dailymotion.com/swf/###VID###\" width=\"",GENERAL_WIDTH),"\" height=\""),DAILYMOTION_HEIGHT),"\"><param name=\"movie\" value=\"http://www.dailymotion.com/swf/###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("GARAGE_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://www.garagetv.be/v/###VID###/v.aspx\" width=\"",GENERAL_WIDTH),"\" height=\""),GARAGE_HEIGHT),"\"><param name=\"movie\" value=\"http://www.garagetv.be/v/###VID###/v.aspx\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("GAMEVIDEO_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://gamevideos.com:80/swf/gamevideos11.swf?embedded=1&amp;autoplay=0&amp;src=http://gamevideos.com:80/video/videoListXML%3Fid%3D###VID###%26adPlay%3Dfalse\" width=\"",GENERAL_WIDTH),"\" height=\""),GAMEVIDEO_HEIGHT),"\"><param name=\"movie\" value=\"http://gamevideos.com:80/swf/gamevideos11.swf?embedded=1&fullscreen=1&amp;autoplay=0&amp;src=http://gamevideos.com:80/video/videoListXML%3Fid%3D###VID###%26adPlay%3Dfalse\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("GAMEVIDEO_LINK"),"<a title=\"GameVideos\" href=\"http://gamevideos.com/video/id/###VID###\">GameVideos ###TXT######THING###</a>");
define(("VSOCIAL_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://static.vsocial.com/flash/ups.swf?d=###VID###&a=0\" width=\"",GENERAL_WIDTH),"\" height=\""),VSOCIAL_HEIGHT),"\"><param name=\"movie\" value=\"http://static.vsocial.com/flash/ups.swf?d=###VID###&a=0\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("VSOCIAL_LINK"),"<a title=\"vSocial\" href=\"http://www.vsocial.com/video/?d=###VID###\">vSocial ###TXT######THING###</a>");
define(("VEOH_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://www.veoh.com/videodetails2.swf?player=videodetailsembedded&type=v&permalinkId=###VID###&id=anonymous\" width=\"",GENERAL_WIDTH),"\" height=\""),VEOH_HEIGHT),"\"><param name=\"movie\" value=\"http://www.veoh.com/videodetails2.swf?player=videodetailsembedded&type=v&permalinkId=###VID###&id=anonymous\" /><param name=\"autostart\" value=\"true\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("VEOH_LINK"),"<a title=\"Veoh\" href=\"http://www.veoh.com/videos/###VID###\">Veoh ###TXT######THING###</a>");
define(("GAMETRAILERS_TARGET"),(deconcat2(concat2(concat2(concat12("<object type=\"application/x-shockwave-flash\" data=\"http://www.gametrailers.com/remote_wrap.php?mid=###VID###\" width=\"",GENERAL_WIDTH),"\" height=\""),GAMETRAILERS_HEIGHT),"\"><param name=\"movie\" value=\"http://www.gametrailers.com/remote_wrap.php?mid=###VID###\" /><param name=\"autostart\" value=\"true\" /><param name=\"wmode\" value=\"transparent\" /></object><br />")));
define(("GAMETRAILERS_LINK"),"<a title=\"Gametrailers\" href=\"http://www.gametrailers.com/player/###VID###.html\">Gametrailers ###TXT######THING###</a>");
define(("LOCAL_QUICKTIME_TARGET"),(deconcat2(concat2(concat2(concat2(concat2(concat(concat2(concat(concat2(concat2(concat2(concat12("<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"",GENERAL_WIDTH),"\" height=\""),QUICKTIME_HEIGHT),"\"><param name=\"src\" value=\""),get_option(array('siteurl',false))),"###VID###\" /><param name=\"autoplay\" value=\"false\" /><param name=\"pluginspage\" value=\"http://www.apple.com/quicktime/download/\" /><param name=\"controller\" value=\"true\" /><!--[if !IE]> <--><object data=\""),get_option(array('siteurl',false))),"###VID###\" width=\""),GENERAL_WIDTH),"\" height=\""),QUICKTIME_HEIGHT),"\" type=\"video/quicktime\"><param name=\"pluginurl\" value=\"http://www.apple.com/quicktime/download/\" /><param name=\"controller\" value=\"true\" /><param name=\"autoplay\" value=\"false\" /></object><!--> <![endif]--></object><br />")));
define(("LOCAL_FLASHPLAYER_TARGET"),(deconcat2(concat(concat2(concat2(concat2(concat2(concat2(concat(concat2(concat(concat2(concat(concat2(concat2(concat2(concat12("<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\"",GENERAL_WIDTH),"\" height=\""),FLASHPLAYER_HEIGHT),"\"><param value=\"#FFFFFF\" name=\"bgcolor\" /><param name=\"movie\" value=\""),get_option(array('siteurl',false))),"/wp-content/plugins/embedded-video-with-link/mediaplayer/player.swf\" /><param value=\"file="),get_option(array('siteurl',false))),"###VID###&amp;showdigits=true&amp;autostart=false&amp;overstretch=false&amp;showfsbutton=false\" name=\"flashvars\" /><param name=\"wmode\" value=\"transparent\" /><!--[if !IE]> <--><object data=\""),get_option(array('siteurl',false))),"/wp-content/plugins/embedded-video-with-link/mediaplayer/player.swf\" type=\"application/x-shockwave-flash\" height=\""),FLASHPLAYER_HEIGHT),"\" width=\""),GENERAL_WIDTH),"\"><param value=\"#FFFFFF\" name=\"bgcolor\"><param value=\"file="),get_option(array('siteurl',false))),"###VID###&amp;showdigits=true&amp;autostart=false&amp;overstretch=false&amp;showfsbutton=false\" name=\"flashvars\" /><param name=\"wmode\" value=\"transparent\" /></object><!--> <![endif]--></object><br />")));
define(("LOCAL_TARGET"),(deconcat2(concat2(concat2(concat2(concat2(concat(concat2(concat(concat2(concat2(concat2(concat12("<object classid=\"clsid:22D6f312-B0F6-11D0-94AB-0080C74C7E95\" codebase=\"http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112\" width=\"",GENERAL_WIDTH),"\" height=\""),VIDEO_HEIGHT),"\" type=\"application/x-oleobject\"><param name=\"filename\" value=\""),get_option(array('siteurl',false))),"###VID###\" /><param name=\"autostart\" value=\"false\" /><param name=\"showcontrols\" value=\"true\" /><!--[if !IE]> <--><object data=\""),get_option(array('siteurl',false))),"###VID###\" width=\""),GENERAL_WIDTH),"\" height=\""),VIDEO_HEIGHT),"\" type=\"application/x-mplayer2\"><param name=\"pluginurl\" value=\"http://www.microsoft.com/Windows/MediaPlayer/\" /><param name=\"ShowControls\" value=\"true\" /><param name=\"ShowStatusBar\" value=\"true\" /><param name=\"ShowDisplay\" value=\"true\" /><param name=\"Autostart\" value=\"0\" /></object><!--> <![endif]--></object><br />")));
define(("LOCAL_LINK"),(deconcat2(concat1("<a title=\"Video File\" href=\"",get_option(array('siteurl',false))),"###VID###\">Download Video</a>")));
define(("QUICKTIME_TARGET"),(deconcat2(concat2(concat2(concat2(concat2(concat2(concat2(concat12("<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"",GENERAL_WIDTH),"\" height=\""),QUICKTIME_HEIGHT),"\"><param name=\"src\" value=\"###VID###\" /><param name=\"autoplay\" value=\"false\" /><param name=\"pluginspage\" value=\"http://www.apple.com/quicktime/download/\" /><param name=\"controller\" value=\"true\" /><!--[if !IE]> <--><object data=\"###VID###\" width=\""),GENERAL_WIDTH),"\" height=\""),QUICKTIME_HEIGHT),"\" type=\"video/quicktime\"><param name=\"pluginurl\" value=\"http://www.apple.com/quicktime/download/\" /><param name=\"controller\" value=\"true\" /><param name=\"autoplay\" value=\"false\" /></object><!--> <![endif]--></object><br />")));
define(("FLASHPLAYER_TARGET"),(deconcat2(concat2(concat2(concat2(concat2(concat(concat2(concat(concat2(concat2(concat2(concat12("<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\"",GENERAL_WIDTH),"\" height=\""),FLASHPLAYER_HEIGHT),"\"><param value=\"#FFFFFF\" name=\"bgcolor\" /><param name=\"movie\" value=\""),get_option(array('siteurl',false))),"/wp-content/plugins/embedded-video-with-link/mediaplayer/player.swf\" /><param value=\"file=###VID###&amp;showdigits=true&amp;autostart=false&amp;overstretch=false&amp;showfsbutton=false\" name=\"flashvars\" /><param name=\"wmode\" value=\"transparent\" /><!--[if !IE]> <--><object data=\""),get_option(array('siteurl',false))),"/wp-content/plugins/embedded-video-with-link/mediaplayer/player.swf?file=###VID###\" type=\"application/x-shockwave-flash\" height=\""),FLASHPLAYER_HEIGHT),"\" width=\""),GENERAL_WIDTH),"\"><param value=\"#FFFFFF\" name=\"bgcolor\"><param value=\"file=###VID###&amp;showdigits=true&amp;autostart=false&amp;overstretch=false&amp;showfsbutton=false\" name=\"flashvars\"><param name=\"wmode\" value=\"transparent\" /></object><!--> <![endif]--></object><br />")));
define(("VIDEO_TARGET"),(deconcat2(concat2(concat2(concat2(concat2(concat2(concat2(concat12("<object classid=\"clsid:22D6f312-B0F6-11D0-94AB-0080C74C7E95\" codebase=\"http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112\" width=\"",GENERAL_WIDTH),"\" height=\""),VIDEO_HEIGHT),"\" type=\"application/x-oleobject\"><param name=\"filename\" value=\"###VID###\" /><param name=\"autostart\" value=\"false\" /><param name=\"showcontrols\" value=\"true\" /><!--[if !IE]> <--><object data=\"###VID###\" width=\""),GENERAL_WIDTH),"\" height=\""),VIDEO_HEIGHT),"\" type=\"application/x-mplayer2\"><param name=\"pluginurl\" value=\"http://www.microsoft.com/Windows/MediaPlayer/\" /><param name=\"ShowControls\" value=\"true\" /><param name=\"ShowStatusBar\" value=\"true\" /><param name=\"ShowDisplay\" value=\"true\" /><param name=\"Autostart\" value=\"0\" /></object><!--> <![endif]--></object><br />")));
define(("VIDEO_LINK"),"<a title=\"Video File\" href=\"###VID###\">Download Video</a>");
define(("REGEXP_1"),"/\[(google|youtube|myvideo|clipfish|sevenload|revver|metacafe|yahoo|ifilm|myspace|brightcove|aniboom|vimeo|guba|dailymotion|garagetv|gamevideo|vsocial|veoh|gametrailers|local|video) ([[:graph:]]+) (nolink)\]/");
define(("REGEXP_2"),"/\[(google|youtube|myvideo|clipfish|sevenload|revver|metacafe|yahoo|ifilm|myspace|brightcove|aniboom|vimeo|guba|dailymotion|garagetv|gamevideo|vsocial|veoh|gametrailers|local|video) ([[:graph:]]+) ([[:print:]]+)\]/");
define(("REGEXP_3"),"/\[(google|youtube|myvideo|clipfish|sevenload|revver|metacafe|yahoo|ifilm|myspace|brightcove|aniboom|vimeo|guba|dailymotion|garagetv|gamevideo|vsocial|veoh|gametrailers|local|video) ([[:graph:]]+)\]/");
function embeddedvideo_plugin_callback ( $match ) {
$output = array('',false);
if ( ((denot_boolean(is_feed())) && (('true') == deAspis(get_option(array('embeddedvideo_pluginlink',false))))))
 $output = concat($output,concat2(concat(concat2(concat1('<small>',__(array('embedded by',false),array('embeddedvideo',false))),' <a href="http://wordpress.org/extend/plugins/embedded-video-with-link/" title="'),__(array('plugin page',false),array('embeddedvideo',false))),'"><em>Embedded Video</em></a></small><br />'));
if ( (denot_boolean(is_feed())))
 {switch ( deAspis(attachAspis($match,(1))) ) {
case ("youtube"):$output = concat2($output,YOUTUBE_TARGET);
break ;
case ("google"):$output = concat2($output,GOOGLE_TARGET);
break ;
case ("myvideo"):$output = concat2($output,MYVIDEO_TARGET);
break ;
case ("clipfish"):$output = concat2($output,CLIPFISH_TARGET);
break ;
case ("sevenload"):$output = concat2($output,SEVENLOAD_TARGET);
break ;
case ("revver"):$output = concat2($output,REVVER_TARGET);
break ;
case ("metacafe"):$output = concat2($output,METACAFE_TARGET);
break ;
case ("yahoo"):$output = concat2($output,YAHOO_TARGET);
break ;
case ("ifilm"):$output = concat2($output,IFILM_TARGET);
break ;
case ("myspace"):$output = concat2($output,MYSPACE_TARGET);
break ;
case ("brightcove"):$output = concat2($output,BRIGHTCOVE_TARGET);
break ;
case ("aniboom"):$output = concat2($output,ANIBOOM_TARGET);
break ;
case ("vimeo"):$output = concat2($output,VIMEO_TARGET);
break ;
case ("guba"):$output = concat2($output,GUBA_TARGET);
break ;
case ("gamevideo"):$output = concat2($output,GAMEVIDEO_TARGET);
break ;
case ("vsocial"):$output = concat2($output,VSOCIAL_TARGET);
break ;
case ("dailymotion"):$output = concat2($output,DAILYMOTION_TARGET);
arrayAssign($match[0],deAspis(registerTaint(array(3,false))),addTaint(array("nolink",false)));
break ;
case ("garagetv"):$output = concat2($output,GARAGE_TARGET);
arrayAssign($match[0],deAspis(registerTaint(array(3,false))),addTaint(array("nolink",false)));
break ;
case ("veoh"):$output = concat2($output,VEOH_TARGET);
break ;
case ("gametrailers"):$output = concat2($output,GAMETRAILERS_TARGET);
break ;
case ("local"):if ( deAspis(Aspis_preg_match(array("%([[:print:]]+).(mov|qt|MOV|QT)$%",false),attachAspis($match,(2)))))
 {$output = concat2($output,LOCAL_QUICKTIME_TARGET);
break ;
}elseif ( deAspis(Aspis_preg_match(array("%([[:print:]]+).(wmv|mpg|mpeg|mpe|asf|asx|wax|wmv|wmx|avi|WMV|MPG|MPEG|MPE|ASF|ASX|WAX|WMV|WMX|AVI)$%",false),attachAspis($match,(2)))))
 {$output = concat2($output,LOCAL_TARGET);
break ;
}elseif ( deAspis(Aspis_preg_match(array("%([[:print:]]+).(swf|flv|SWF|FLV)$%",false),attachAspis($match,(2)))))
 {$output = concat2($output,LOCAL_FLASHPLAYER_TARGET);
break ;
}case ("video"):if ( deAspis(Aspis_preg_match(array("%([[:print:]]+).(mov|qt|MOV|QT)$%",false),attachAspis($match,(2)))))
 {$output = concat2($output,QUICKTIME_TARGET);
break ;
}elseif ( deAspis(Aspis_preg_match(array("%([[:print:]]+).(wmv|mpg|mpeg|mpe|asf|asx|wax|wmv|wmx|avi|WMV|MPG|MPEG|MPE|ASF|ASX|WAX|WMV|WMX|AVI)$%",false),attachAspis($match,(2)))))
 {$output = concat2($output,VIDEO_TARGET);
break ;
}elseif ( deAspis(Aspis_preg_match(array("%([[:print:]]+).(swf|flv|SWF|FLV)$%",false),attachAspis($match,(2)))))
 {$output = concat2($output,FLASHPLAYER_TARGET);
break ;
}default :break ;
 }
if ( (deAspis(get_option(array('embeddedvideo_shownolink',false))) == ('false')))
 {if ( (deAspis(attachAspis($match,(3))) != ("nolink")))
 {$ev_small = get_option(array('embeddedvideo_small',false));
if ( (('true') == $ev_small[0]))
 $output = concat2($output,"<small>");
switch ( deAspis(attachAspis($match,(1))) ) {
case ("youtube"):$output = concat2($output,YOUTUBE_LINK);
break ;
case ("google"):$output = concat2($output,GOOGLE_LINK);
break ;
case ("myvideo"):$output = concat2($output,MYVIDEO_LINK);
break ;
case ("clipfish"):$output = concat2($output,CLIPFISH_LINK);
break ;
case ("sevenload"):$output = concat2($output,SEVENLOAD_LINK);
break ;
case ("revver"):$output = concat2($output,REVVER_LINK);
break ;
case ("metacafe"):$output = concat2($output,METACAFE_LINK);
break ;
case ("yahoo"):$output = concat2($output,YAHOO_LINK);
break ;
case ("ifilm"):$output = concat2($output,IFILM_LINK);
break ;
case ("myspace"):$output = concat2($output,MYSPACE_LINK);
break ;
case ("brightcove"):$output = concat2($output,BRIGHTCOVE_LINK);
break ;
case ("aniboom"):$output = concat2($output,ANIBOOM_LINK);
break ;
case ("vimeo"):$output = concat2($output,VIMEO_LINK);
break ;
case ("guba"):$output = concat2($output,GUBA_LINK);
break ;
case ("gamevideo"):$output = concat2($output,GAMEVIDEO_LINK);
break ;
case ("vsocial"):$output = concat2($output,VSOCIAL_LINK);
break ;
case ("veoh"):$output = concat2($output,VEOH_LINK);
break ;
case ("gametrailers"):$output = concat2($output,GAMETRAILERS_LINK);
break ;
case ("local"):$output = concat2($output,LOCAL_LINK);
break ;
case ("video"):$output = concat2($output,VIDEO_LINK);
break ;
default :break ;
 }
if ( (('true') == $ev_small[0]))
 $output = concat2($output,"</small>");
}}}else 
{if ( (deAspis(get_option(array('embeddedvideo_showinfeed',false))) == ('true')))
 $output = concat($output,concat2(concat(concat2(concat(concat2(__(array('[There is a video that cannot be displayed in this feed. ',false),array('embeddedvideo',false)),'<a href="'),get_permalink()),'">'),__(array('Visit the blog entry to see the video.]',false),array('embeddedvideo',false))),'</a>'));
}$output = Aspis_str_replace(array("###TXT###",false),array(LINKTEXT,false),$output);
if ( (deAspis(attachAspis($match,(1))) == ("yahoo")))
 {$temp = Aspis_explode(array(".",false),attachAspis($match,(2)));
arrayAssign($match[0],deAspis(registerTaint(array(2,false))),addTaint(attachAspis($temp,(1))));
$output = Aspis_str_replace(array("###YAHOO###",false),attachAspis($temp,(0)),$output);
}$output = Aspis_str_replace(array("###VID###",false),attachAspis($match,(2)),$output);
$output = Aspis_str_replace(array("###THING###",false),attachAspis($match,(3)),$output);
if ( (denot_boolean(is_feed())))
 $output = concat2($output,"\n<!-- generated by WordPress plugin Embedded Video -->\n");
return ($output);
 }
function embeddedvideo_plugin ( $content ) {
if ( ((isset($_GET[0][('content')]) && Aspis_isset( $_GET [0][('content')]))))
 $content = $_GET[0]['content'];
$output = Aspis_preg_replace_callback(array(REGEXP_1,false),array('embeddedvideo_plugin_callback',false),$content);
$output = Aspis_preg_replace_callback(array(REGEXP_2,false),array('embeddedvideo_plugin_callback',false),$output);
$output = Aspis_preg_replace_callback(array(REGEXP_3,false),array('embeddedvideo_plugin_callback',false),$output);
var_dump(deAspisRC($output));
return ($output);
 }
add_filter(array('the_content',false),array('embeddedvideo_plugin',false));
function embeddedvideo_option_page (  ) {
global $wpdb,$table_prefix;
if ( ((isset($_POST[0][('embeddedvideo_prefix')]) && Aspis_isset( $_POST [0][('embeddedvideo_prefix')]))))
 {$errs = array(array(),false);
$temp = Aspis_stripslashes($_POST[0]['embeddedvideo_prefix']);
$ev_prefix = wp_kses($temp,array(array(),false));
update_option(array('embeddedvideo_prefix',false),$ev_prefix);
if ( (!((empty($_POST[0][('embeddedvideo_space')]) || Aspis_empty( $_POST [0][('embeddedvideo_space')])))))
 {update_option(array('embeddedvideo_space',false),array("true",false));
}else 
{{update_option(array('embeddedvideo_space',false),array("false",false));
}}if ( (!((empty($_POST[0][('embeddedvideo_small')]) || Aspis_empty( $_POST [0][('embeddedvideo_small')])))))
 {update_option(array('embeddedvideo_small',false),array("true",false));
}else 
{{update_option(array('embeddedvideo_small',false),array("false",false));
}}if ( (!((empty($_POST[0][('embeddedvideo_pluginlink')]) || Aspis_empty( $_POST [0][('embeddedvideo_pluginlink')])))))
 {update_option(array('embeddedvideo_pluginlink',false),array("true",false));
}else 
{{update_option(array('embeddedvideo_pluginlink',false),array("false",false));
}}if ( (!((empty($_POST[0][('embeddedvideo_shownolink')]) || Aspis_empty( $_POST [0][('embeddedvideo_shownolink')])))))
 {update_option(array('embeddedvideo_shownolink',false),array("true",false));
}else 
{{update_option(array('embeddedvideo_shownolink',false),array("false",false));
}}if ( (!((empty($_POST[0][('embeddedvideo_showinfeed')]) || Aspis_empty( $_POST [0][('embeddedvideo_showinfeed')])))))
 {update_option(array('embeddedvideo_showinfeed',false),array("true",false));
}else 
{{update_option(array('embeddedvideo_showinfeed',false),array("false",false));
}}$ev_width = $_POST[0]['embeddedvideo_width'];
if ( ($ev_width[0] == ("")))
 arrayAssignAdd($errs[0][],addTaint(__(array('Object width must be set!',false),array('embeddedvideo',false))));
elseif ( ((($ev_width[0] > (800)) || ($ev_width[0] < (250))) || (denot_boolean(Aspis_preg_match(array("/^[0-9]{3}$/",false),$ev_width)))))
 arrayAssignAdd($errs[0][],addTaint(__(array('Object width must be a number between 250 and 800!',false),array('embeddedvideo',false))));
else 
{update_option(array('embeddedvideo_width',false),$ev_width);
}if ( ((empty($errs) || Aspis_empty( $errs))))
 {echo AspisCheckPrint(concat2(concat1('<div id="message" class="updated fade"><p>',__(array('Options updated!',false),array('embeddedvideo',false))),'</p></div>'));
}else 
{{echo AspisCheckPrint(array('<div id="message" class="error fade"><ul>',false));
foreach ( $errs[0] as $name =>$msg )
{restoreTaint($name,$msg);
{echo AspisCheckPrint(concat2(concat1('<li>',wptexturize($msg)),'</li>'));
}}echo AspisCheckPrint(array('</ul></div>',false));
}}}if ( (('true') == deAspis(get_option(array('embeddedvideo_space',false)))))
 {$ev_space = array('checked="true"',false);
}else 
{{$ev_space = array('',false);
}}if ( (('true') == deAspis(get_option(array('embeddedvideo_small',false)))))
 {$ev_small = array('checked="true"',false);
}else 
{{$ev_small = array('',false);
}}if ( (('true') == deAspis(get_option(array('embeddedvideo_pluginlink',false)))))
 {$ev_pluginlink = array('checked="true"',false);
}else 
{{$ev_pluginlink = array('',false);
}}if ( (('true') == deAspis(get_option(array('embeddedvideo_shownolink',false)))))
 {$ev_shownolink = array('checked="true"',false);
}else 
{{$ev_shownolink = array('',false);
}}if ( (('true') == deAspis(get_option(array('embeddedvideo_showinfeed',false)))))
 {$ev_showinfeed = array('checked="true"',false);
}else 
{{$ev_showinfeed = array('',false);
}};
?>

	<div style="width:75%;" class="wrap" id="embeddedvideo_options_panel">
	<h2><?php echo AspisCheckPrint(_e(array('Embedded Video',false),array('embeddedvideo',false)));
;
?></h2>

	<a href="http://www.oscandy.com/"><img src="/wp-content/plugins/embedded-video-with-link/embedded-video-logo.png" title="<?php echo AspisCheckPrint(_e(array('Logo by Azzam/OpenSource Solutions Blog',false)));
?>" alt="<?php echo AspisCheckPrint(_e(array('Logo by Azzam/OpenSource Solutions Blog',false)));
?>" align="right" /></a>

	<p><strong><?php echo AspisCheckPrint(_e(array('Edit the prefix of the linktext and the width of the embedded flash object!',false),array('embeddedvideo',false)));
;
?></strong><br /><?php echo AspisCheckPrint(_e(array('For detailed information see the',false),array('embeddedvideo',false)));
;
?> <a href="http://wordpress.org/extend/plugins/embedded-video-with-link/" title="<?php echo AspisCheckPrint(_e(array('plugin page',false),array('embeddedvideo',false)));
;
?>"><?php echo AspisCheckPrint(_e(array('plugin page',false),array('embeddedvideo',false)));
;
?></a>.</p>

	<p><i><?php echo AspisCheckPrint(_e(array('Examples for the prefix settings:',false),array('embeddedvideo',false)));
;
?></i><br />
	<?php echo AspisCheckPrint(_e(array('If you type in',false),array('embeddedvideo',false)));
;
?> <strong>[youtube abcd12345 super video]</strong> <?php echo AspisCheckPrint(_e(array('and you choose the prefix',false),array('embeddedvideo',false)));
;
?> <strong>"<?php echo AspisCheckPrint(_e(array('- Link to',false),array('embeddedvideo',false)));
;
?>"</strong> <?php echo AspisCheckPrint(_e(array('with a following space, the linktext will be',false),array('embeddedvideo',false)));
;
?> <strong>"<?php echo AspisCheckPrint(_e(array('YouTube - Link to super video',false),array('embeddedvideo',false)));
;
?>"</strong>.<br /><br />
	<?php echo AspisCheckPrint(_e(array('If you type in',false),array('embeddedvideo',false)));
;
?> <strong>[sevenload abcd12345 dings]</strong> <?php echo AspisCheckPrint(_e(array('and you choose the prefix',false),array('embeddedvideo',false)));
;
?> <strong>"<?php echo AspisCheckPrint(_e(array('Direct',false),array('embeddedvideo',false)));
;
?>"</strong> <?php echo AspisCheckPrint(_e(array('without a following space, the linktext will be',false),array('embeddedvideo',false)));
;
?> <strong>"<?php echo AspisCheckPrint(_e(array('Sevenload Directdings',false),array('embeddedvideo',false)));
;
?>"</strong>.</p>
	<div class="wrap">
		<form method="post">
			<div>
				<label for="embeddedvideo_shownolink" style="cursor: pointer;"><input type="checkbox" name="embeddedvideo_shownolink" id="embeddedvideo_shownolink" value="<?php echo AspisCheckPrint(get_option(array('embeddedvideo_shownolink',false)));
?>" <?php echo AspisCheckPrint($ev_shownolink);
;
?> /> <?php echo AspisCheckPrint(_e(array('Never show the video link (exception: feeds)',false),array('embeddedvideo',false)));
;
?></label><br />
				<label for="embeddedvideo_showinfeed" style="cursor: pointer;"><input type="checkbox" name="embeddedvideo_showinfeed" id="embeddedvideo_showinfeed" value="<?php echo AspisCheckPrint(get_option(array('embeddedvideo_showinfeed',false)));
?>" <?php echo AspisCheckPrint($ev_showinfeed);
;
?> /> <?php echo AspisCheckPrint(_e(array('In feed, show link to blog post (video embedding in feed not yet available)',false),array('embeddedvideo',false)));
;
?></label><br />
				<?php echo AspisCheckPrint(_e(array('Prefix:',false),array('embeddedvideo',false)));
;
?> <input type="text" value="<?php echo AspisCheckPrint(get_option(array('embeddedvideo_prefix',false)));
?>" name="embeddedvideo_prefix" id="embeddedvideo_prefix" /><br />
				<label for="embeddedvideo_space" style="cursor: pointer;"><input type="checkbox" name="embeddedvideo_space" id="embeddedvideo_space" value="<?php echo AspisCheckPrint(get_option(array('embeddedvideo_space',false)));
?>" <?php echo AspisCheckPrint($ev_space);
;
?> /> <?php echo AspisCheckPrint(_e(array('Following space character',false),array('embeddedvideo',false)));
;
?></label><br />
				<label for="embeddedvideo_small" style="cursor: pointer;"><input type="checkbox" name="embeddedvideo_small" id="embeddedvideo_small" value="<?php echo AspisCheckPrint(get_option(array('embeddedvideo_small',false)));
?>" <?php echo AspisCheckPrint($ev_small);
;
?> /> <?php echo AspisCheckPrint(_e(array('Use smaller font size for link',false),array('embeddedvideo',false)));
;
?></label><br />
				<?php echo AspisCheckPrint(_e(array('Video object width',false),array('embeddedvideo',false)));
;
?> (250-800):<input type="text" value="<?php echo AspisCheckPrint(get_option(array('embeddedvideo_width',false)));
?>" name="embeddedvideo_width" id="embeddedvideo_width" size="5" maxlength="3" /><br />
				<label for="embeddedvideo_pluginlink" style="cursor: pointer;"><input type="checkbox" name="embeddedvideo_pluginlink" id="embeddedvideo_pluginlink" value="<?php echo AspisCheckPrint(get_option(array('embeddedvideo_pluginlink',false)));
?>" <?php echo AspisCheckPrint($ev_pluginlink);
;
?> /> <?php echo AspisCheckPrint(_e(array('Show link to plugin page',false),array('embeddedvideo',false)));
;
?></label><br /><br />
				<input type="submit"  id="embeddedvideo_update_options" value="<?php echo AspisCheckPrint(_e(array('Save settings',false),array('embeddedvideo',false)));
;
?> &raquo;" />
			</div>
		</form>
	</div>
	<p><?php echo AspisCheckPrint(_e(array('The following video portals are currently supported:',false),array('embeddedvideo',false)));
;
?><br/>
	YouTube, Google Video, dailymotion, MyVideo, Clipfish, Sevenload, Revver, Metacaf&eacute;, Yahoo! Video, ifilm, MySpace Video, Brightcove, aniBOOM, vimeo, GUBA, Garage TV, GameVideos, vSocial, Veoh, GameTrailers</p>

	<h3><?php echo AspisCheckPrint(_e(array('Preview',false),array('embeddedvideo',false)));
;
?></h3>
	<div class="wrap">
	<p><?php echo AspisCheckPrint(_e(array('Your current settings produce the following output:',false),array('embeddedvideo',false)));
;
?></p>
	<p><?php if ( (('true') == deAspis(get_option(array('embeddedvideo_pluginlink',false)))))
 echo AspisCheckPrint(concat2(concat1('<small>',__(array('embedded by',false),array('embeddedvideo',false))),' <a href="http://wordpress.org/extend/plugins/embedded-video-with-link/" title="Plugin Page"><em>Embedded Video</em></a></small><br />'));
;
?>
	<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/gcFS5cnnWAM" width="<?php echo AspisCheckPrint(get_option(array('embeddedvideo_width',false)));
;
?>" height="<?php echo AspisCheckPrint(attAspis(floor(((deAspis(get_option(array('embeddedvideo_width',false))) * (14)) / (17)))));
;
?>"><param name="movie" value="http://www.youtube.com/v/gcFS5cnnWAM" /></object><br />
	<?php if ( (('false') == deAspis(get_option(array('embeddedvideo_shownolink',false)))))
 {$ev_issmall = get_option(array('embeddedvideo_small',false));
if ( (('true') == $ev_issmall[0]))
 echo AspisCheckPrint(array("<small>",false));
;
?>
	<a title="YouTube" href="http://www.youtube.com/watch?v=nglMDkUbRSk">YouTube <?php echo AspisCheckPrint(get_option(array('embeddedvideo_prefix',false)));
if ( (('true') == deAspis(get_option(array('embeddedvideo_space',false)))))
 echo AspisCheckPrint(array("&nbsp;",false));
;
?>blahdiblah</a><?php if ( (('true') == $ev_issmall[0]))
 echo AspisCheckPrint(array("</small>",false));
};
?>
	</p>
	</div>

	<p><?php echo AspisCheckPrint(_e(array('Check the',false),array('embeddedvideo',false)));
;
?> <a href="http://wordpress.org/extend/plugins/embedded-video-with-link/" title="Embedded Video Plugin Page"><?php echo AspisCheckPrint(_e(array('plugin page',false),array('embeddedvideo',false)));
;
?></a> <?php echo AspisCheckPrint(_e(array('for updates regularly!',false),array('embeddedvideo',false)));
;
?><br />
		<?php echo AspisCheckPrint(_e(array('Video icon by',false),array('embeddedvideo',false)));
;
?> <a href="http://famfamfam.com" title="famfamfam">famfamfam</a>!
	</p>
	</div>

	<?php  }
function embeddedvideo_add_options_panel (  ) {
add_options_page(array('Embedded Video',false),array('Embedded Video',false),array('manage_options',false),array('embeddedvideo_options_page',false),array('embeddedvideo_option_page',false));
 }
function embedded_video_mcebutton ( $buttons ) {
Aspis_array_push($buttons,array("|",false),array("embedded_video",false));
return $buttons;
 }
function embedded_video_mceplugin ( $ext_plu ) {
if ( (is_array($ext_plu[0]) == false))
 {$ext_plu = array(array(),false);
}$url = concat2(get_option(array('siteurl',false)),"/wp-content/plugins/embedded-video-with-link/editor_plugin.js");
$result = Aspis_array_merge($ext_plu,array(array(deregisterTaint(array("embedded_video",false)) => addTaint($url)),false));
return $result;
 }
function embeddedvideo_mceinit (  ) {
if ( function_exists(('load_plugin_textdomain')))
 load_plugin_textdomain(array('embeddedvideo',false),array('/wp-content/plugins/embedded-video-with-link/langs',false));
if ( (('true') == deAspis(get_user_option(array('rich_editing',false)))))
 {add_filter(array("mce_external_plugins",false),array("embedded_video_mceplugin",false),array(0,false));
add_filter(array("mce_buttons",false),array("embedded_video_mcebutton",false),array(0,false));
} }
function embeddedvideo_script (  ) {
echo AspisCheckPrint(concat2(concat1("<script type='text/javascript' src='",get_option(array('siteurl',false))),"/wp-content/plugins/embedded-video-with-link/embedded-video.js'></script>\n"));
 }
if ( function_exists(('add_action')))
 {if ( ((((isset($_GET[0][('activate')]) && Aspis_isset( $_GET [0][('activate')]))) && (deAspis($_GET[0]['activate']) == ('true'))) || (deAspis(get_option(array('embeddedvideo_version',false))) != EV_VERSION)))
 {add_action(array('init',false),array('embeddedvideo_initialize',false));
}add_action(array('init',false),array('embeddedvideo_mceinit',false));
add_action(array('admin_print_scripts',false),array('embeddedvideo_script',false));
add_action(array('admin_menu',false),array('embeddedvideo_add_options_panel',false));
}};
?>
<?php 