<?php require_once('AspisMain.php'); ?><?php
if ( (defined(('WP_USE_THEMES')) && deAspis(attAspisRC(constant(('WP_USE_THEMES'))))))
 {do_action(array('template_redirect',false));
if ( deAspis(is_robots()))
 {do_action(array('do_robots',false));
return ;
}else 
{if ( deAspis(is_feed()))
 {do_feed();
return ;
}else 
{if ( deAspis(is_trackback()))
 {include (deconcat12(ABSPATH,'wp-trackback.php'));
return ;
}else 
{if ( (deAspis(is_404()) && deAspis($template = get_404_template())))
 {include deAspis(($template));
return ;
}else 
{if ( (deAspis(is_search()) && deAspis($template = get_search_template())))
 {include deAspis(($template));
return ;
}else 
{if ( (deAspis(is_tax()) && deAspis($template = get_taxonomy_template())))
 {include deAspis(($template));
return ;
}else 
{if ( (deAspis(is_home()) && deAspis($template = get_home_template())))
 {include deAspis(($template));
return ;
}else 
{if ( (deAspis(is_attachment()) && deAspis($template = get_attachment_template())))
 {remove_filter(array('the_content',false),array('prepend_attachment',false));
include deAspis(($template));
return ;
}else 
{if ( (deAspis(is_single()) && deAspis($template = get_single_template())))
 {include deAspis(($template));
return ;
}else 
{if ( (deAspis(is_page()) && deAspis($template = get_page_template())))
 {include deAspis(($template));
return ;
}else 
{if ( (deAspis(is_category()) && deAspis($template = get_category_template())))
 {include deAspis(($template));
return ;
}else 
{if ( (deAspis(is_tag()) && deAspis($template = get_tag_template())))
 {include deAspis(($template));
return ;
}else 
{if ( (deAspis(is_author()) && deAspis($template = get_author_template())))
 {include deAspis(($template));
return ;
}else 
{if ( (deAspis(is_date()) && deAspis($template = get_date_template())))
 {include deAspis(($template));
return ;
}else 
{if ( (deAspis(is_archive()) && deAspis($template = get_archive_template())))
 {include deAspis(($template));
return ;
}else 
{if ( (deAspis(is_comments_popup()) && deAspis($template = get_comments_popup_template())))
 {include deAspis(($template));
return ;
}else 
{if ( (deAspis(is_paged()) && deAspis($template = get_paged_template())))
 {include deAspis(($template));
return ;
}else 
{if ( file_exists((deconcat12(TEMPLATEPATH,"/index.php"))))
 {include (deconcat12(TEMPLATEPATH,"/index.php"));
return ;
}}}}}}}}}}}}}}}}}}}else 
{{if ( deAspis(is_robots()))
 {do_action(array('do_robots',false));
return ;
}else 
{if ( deAspis(is_feed()))
 {do_feed();
return ;
}else 
{if ( deAspis(is_trackback()))
 {include (deconcat12(ABSPATH,'wp-trackback.php'));
return ;
}}}}};
