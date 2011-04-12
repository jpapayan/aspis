=== myLinksDump ===

Contributors: silvercover
Tags: link, spam
Requires at least: 2.5
Tested up to: 2.9.2
Stable tag: 4.2

Plugin for displaying daily links. Inserting favorite links while you are surfing web into yout blog.

== Description ==

You can make link dump of favorite links you visit regualry.This plug-in
can record number of visitors who click on each link. You can also have 
a bar called Branding bar on top of destination url to personalize and 
publicize your blog. on the other side there are some options that you can
change to customize your link dump behaviour.If you prefer widget to 
display your link dump then you can activate myLinksDump widget.

You can add link to your links dump while you are surfing web using your browser.
In order to do this, bookmark generated link(in setting pane) and press it when
ever you see a good link. When you press this bookmark, you'll be presented with 
pop-up window filled with the URL and title of the link you've just saw. By the
time you did this, you can type your remark on that link and press Add My Link!
button.

Thanks to myLinksDump RSS output you can share your links with others and let
them to pur your links dump on their blogs or sites.

Required .po file is also available for localization. So if you like to 
do so then please e-mail your .mo file to ham55464@yahoo.com to be put in
plug-in distribution package.


== Installation ==

1. Upload `myLinksDump` folder to the `/wp-content/plugins/` directory.
2. Move myLDAdd.php, myLDlinker.php and myLDRSS.php files from myLinksDump/extra
   folder to your wordpress installation root where your wp-config.php is.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Place `<?php echo myLinksDump_show() ;?>` in your templates.
5. If you want archive page, then make normal page and find its ID and then go
   to myLinksDump setting page and enter it in Archive Page ID field. Finally
   place `<?php myLinksDump_Archive() ;?>` in page.php of your theme.
6. You can also activate plug-in's widget if you like.
7. Some configuration options will be available under setting pane.

== Frequently Asked Questions ==

= Is there any RSS feed for my link dump?

Yes there is. you can call myLinksDumpRSS.php file to show your link dump RSS feed. There is
also an option to replace your feedburner address rather than http://yoursite/myLinksDumpRSS.php .

= How can i customize the look of my link dump?

By default there are some predefined styles in myLinksDump/styles folder in which you set the
one you like the most. You can also put your stylesheet in  myLinksDump/styles folder and then
activate it through admin panel.

= How can i find page ID?

Click on Pages-> Edit link on wp admin area. Then click on the desired link and
wait for the next page to load. after this watch your browser address bar for 
destination link it shows. It must be something like this:

http://www.xyz.com/wp-admin/page.php?action=edit&post=14

the last number in query string (14) is what we need.

= What are the right places for putting `<?php echo myLinksDump_show() ;?>` and `<?php myLinksDump_Archive() ;?>`?

- `<?php echo myLinksDump_show() ;?>` must be out of content loop. Because if you put it in content loop,
you'll see lots of link dumps as much as your post entries.

- `<?php myLinksDump_Archive() ;?>` must be in content area. usually the best place to put this code is
right after `<?php the_content(); ?>` line in page.php of your theme.

= How can i share my links with others?

Thanks to myLinksDump RSS output you can share your links with others. It's good idea to write some lines in 
about Archive page on how others can grab your links dump RSS output and use that in their blogs or sites.
Normal RSS address of your links dump is '<yoursiteurl>/myLDRSS.php' (e.g: http://www.xyz.com/myLDRSS.php),
but if you prefer you can burn this feed in feedburner and provide feedburner address instead.

== Screenshots ==

1. Options page.
2. Add/Edit links page.
3. List entered links page.
4. Front-end view.

