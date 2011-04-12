<?php require_once('AspisMain.php'); ?><?php
function mce_put_file ( $path,$content ) {
if ( function_exists(('file_put_contents')))
 return @array(file_put_contents(deAspisRC($path),deAspisRC($content)),false);
$newfile = array(false,false);
$fp = @attAspis(fopen($path[0],('wb')));
if ( $fp[0])
 {$newfile = attAspis(fwrite($fp[0],$content[0]));
fclose($fp[0]);
}return $newfile;
 }
function mce_escape ( $text ) {
global $language;
if ( (('en') == $language[0]))
 return $text;
else 
{return esc_js($text);
} }
$lang = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('tinyMCE.addI18n({',$language),':{
common:{
edit_confirm:"'),mce_escape(__(array('Do you want to use the WYSIWYG mode for this textarea?',false)))),'",
apply:"'),mce_escape(__(array('Apply',false)))),'",
insert:"'),mce_escape(__(array('Insert',false)))),'",
update:"'),mce_escape(__(array('Update',false)))),'",
cancel:"'),mce_escape(__(array('Cancel',false)))),'",
close:"'),mce_escape(__(array('Close',false)))),'",
browse:"'),mce_escape(__(array('Browse',false)))),'",
class_name:"'),mce_escape(__(array('Class',false)))),'",
not_set:"'),mce_escape(__(array('-- Not set --',false)))),'",
clipboard_msg:"'),mce_escape(__(array('Copy/Cut/Paste is not available in Mozilla and Firefox.',false)))),'",
clipboard_no_support:"'),mce_escape(__(array('Currently not supported by your browser, use keyboard shortcuts instead.',false)))),'",
popup_blocked:"'),mce_escape(__(array('Sorry, but we have noticed that your popup-blocker has disabled a window that provides application functionality. You will need to disable popup blocking on this site in order to fully utilize this tool.',false)))),'",
invalid_data:"'),mce_escape(__(array('Error: Invalid values entered, these are marked in red.',false)))),'",
more_colors:"'),mce_escape(__(array('More colors',false)))),'"
},
contextmenu:{
align:"'),mce_escape(__(array('Alignment',false)))),'",
left:"'),mce_escape(__(array('Left',false)))),'",
center:"'),mce_escape(__(array('Center',false)))),'",
right:"'),mce_escape(__(array('Right',false)))),'",
full:"'),mce_escape(__(array('Full',false)))),'"
},
insertdatetime:{
date_fmt:"'),mce_escape(__(array('%Y-%m-%d',false)))),'",
time_fmt:"'),mce_escape(__(array('%H:%M:%S',false)))),'",
insertdate_desc:"'),mce_escape(__(array('Insert date',false)))),'",
inserttime_desc:"'),mce_escape(__(array('Insert time',false)))),'",
months_long:"'),mce_escape(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(__(array('January',false)),','),__(array('February',false))),','),__(array('March',false))),','),__(array('April',false))),','),__(array('May',false))),','),__(array('June',false))),','),__(array('July',false))),','),__(array('August',false))),','),__(array('September',false))),','),__(array('October',false))),','),__(array('November',false))),','),__(array('December',false))))),'",
months_short:"'),mce_escape(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(__(array('Jan_January_abbreviation',false)),','),__(array('Feb_February_abbreviation',false))),','),__(array('Mar_March_abbreviation',false))),','),__(array('Apr_April_abbreviation',false))),','),__(array('May_May_abbreviation',false))),','),__(array('Jun_June_abbreviation',false))),','),__(array('Jul_July_abbreviation',false))),','),__(array('Aug_August_abbreviation',false))),','),__(array('Sep_September_abbreviation',false))),','),__(array('Oct_October_abbreviation',false))),','),__(array('Nov_November_abbreviation',false))),','),__(array('Dec_December_abbreviation',false))))),'",
day_long:"'),mce_escape(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(__(array('Sunday',false)),','),__(array('Monday',false))),','),__(array('Tuesday',false))),','),__(array('Wednesday',false))),','),__(array('Thursday',false))),','),__(array('Friday',false))),','),__(array('Saturday',false))))),'",
day_short:"'),mce_escape(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(__(array('Sun',false)),','),__(array('Mon',false))),','),__(array('Tue',false))),','),__(array('Wed',false))),','),__(array('Thu',false))),','),__(array('Fri',false))),','),__(array('Sat',false))))),'"
},
print:{
print_desc:"'),mce_escape(__(array('Print',false)))),'"
},
preview:{
preview_desc:"'),mce_escape(__(array('Preview',false)))),'"
},
directionality:{
ltr_desc:"'),mce_escape(__(array('Direction left to right',false)))),'",
rtl_desc:"'),mce_escape(__(array('Direction right to left',false)))),'"
},
layer:{
insertlayer_desc:"'),mce_escape(__(array('Insert new layer',false)))),'",
forward_desc:"'),mce_escape(__(array('Move forward',false)))),'",
backward_desc:"'),mce_escape(__(array('Move backward',false)))),'",
absolute_desc:"'),mce_escape(__(array('Toggle absolute positioning',false)))),'",
content:"'),mce_escape(__(array('New layer...',false)))),'"
},
save:{
save_desc:"'),mce_escape(__(array('Save',false)))),'",
cancel_desc:"'),mce_escape(__(array('Cancel all changes',false)))),'"
},
nonbreaking:{
nonbreaking_desc:"'),mce_escape(__(array('Insert non-breaking space character',false)))),'"
},
iespell:{
iespell_desc:"'),mce_escape(__(array('Run spell checking',false)))),'",
download:"'),mce_escape(__(array('ieSpell not detected. Do you want to install it now?',false)))),'"
},
advhr:{
advhr_desc:"'),mce_escape(__(array('Horizontale rule',false)))),'"
},
emotions:{
emotions_desc:"'),mce_escape(__(array('Emotions',false)))),'"
},
searchreplace:{
search_desc:"'),mce_escape(__(array('Find',false)))),'",
replace_desc:"'),mce_escape(__(array('Find/Replace',false)))),'"
},
advimage:{
image_desc:"'),mce_escape(__(array('Insert/edit image',false)))),'"
},
advlink:{
link_desc:"'),mce_escape(__(array('Insert/edit link',false)))),'"
},
xhtmlxtras:{
cite_desc:"'),mce_escape(__(array('Citation',false)))),'",
abbr_desc:"'),mce_escape(__(array('Abbreviation',false)))),'",
acronym_desc:"'),mce_escape(__(array('Acronym',false)))),'",
del_desc:"'),mce_escape(__(array('Deletion',false)))),'",
ins_desc:"'),mce_escape(__(array('Insertion',false)))),'",
attribs_desc:"'),mce_escape(__(array('Insert/Edit Attributes',false)))),'"
},
style:{
desc:"'),mce_escape(__(array('Edit CSS Style',false)))),'"
},
paste:{
paste_text_desc:"'),mce_escape(__(array('Paste as Plain Text',false)))),'",
paste_word_desc:"'),mce_escape(__(array('Paste from Word',false)))),'",
selectall_desc:"'),mce_escape(__(array('Select All',false)))),'"
},
paste_dlg:{
text_title:"'),mce_escape(__(array('Use CTRL+V on your keyboard to paste the text into the window.',false)))),'",
text_linebreaks:"'),mce_escape(__(array('Keep linebreaks',false)))),'",
word_title:"'),mce_escape(__(array('Use CTRL+V on your keyboard to paste the text into the window.',false)))),'"
},
table:{
desc:"'),mce_escape(__(array('Inserts a new table',false)))),'",
row_before_desc:"'),mce_escape(__(array('Insert row before',false)))),'",
row_after_desc:"'),mce_escape(__(array('Insert row after',false)))),'",
delete_row_desc:"'),mce_escape(__(array('Delete row',false)))),'",
col_before_desc:"'),mce_escape(__(array('Insert column before',false)))),'",
col_after_desc:"'),mce_escape(__(array('Insert column after',false)))),'",
delete_col_desc:"'),mce_escape(__(array('Remove column',false)))),'",
split_cells_desc:"'),mce_escape(__(array('Split merged table cells',false)))),'",
merge_cells_desc:"'),mce_escape(__(array('Merge table cells',false)))),'",
row_desc:"'),mce_escape(__(array('Table row properties',false)))),'",
cell_desc:"'),mce_escape(__(array('Table cell properties',false)))),'",
props_desc:"'),mce_escape(__(array('Table properties',false)))),'",
paste_row_before_desc:"'),mce_escape(__(array('Paste table row before',false)))),'",
paste_row_after_desc:"'),mce_escape(__(array('Paste table row after',false)))),'",
cut_row_desc:"'),mce_escape(__(array('Cut table row',false)))),'",
copy_row_desc:"'),mce_escape(__(array('Copy table row',false)))),'",
del:"'),mce_escape(__(array('Delete table',false)))),'",
row:"'),mce_escape(__(array('Row',false)))),'",
col:"'),mce_escape(__(array('Column',false)))),'",
cell:"'),mce_escape(__(array('Cell',false)))),'"
},
autosave:{
unload_msg:"'),mce_escape(__(array('The changes you made will be lost if you navigate away from this page.',false)))),'"
},
fullscreen:{
desc:"'),mce_escape(__(array('Toggle fullscreen mode',false)))),' (Alt+Shift+G)"
},
media:{
desc:"'),mce_escape(__(array('Insert / edit embedded media',false)))),'",
delta_width:"'),mce_escape(_x(array('0',false),array('media popup width',false)))),'",
delta_height:"'),mce_escape(_x(array('0',false),array('media popup height',false)))),'",
edit:"'),mce_escape(__(array('Edit embedded media',false)))),'"
},
fullpage:{
desc:"'),mce_escape(__(array('Document properties',false)))),'"
},
template:{
desc:"'),mce_escape(__(array('Insert predefined template content',false)))),'"
},
visualchars:{
desc:"'),mce_escape(__(array('Visual control characters on/off.',false)))),'"
},
spellchecker:{
desc:"'),mce_escape(__(array('Toggle spellchecker',false)))),' (Alt+Shift+N)",
menu:"'),mce_escape(__(array('Spellchecker settings',false)))),'",
ignore_word:"'),mce_escape(__(array('Ignore word',false)))),'",
ignore_words:"'),mce_escape(__(array('Ignore all',false)))),'",
langs:"'),mce_escape(__(array('Languages',false)))),'",
wait:"'),mce_escape(__(array('Please wait...',false)))),'",
sug:"'),mce_escape(__(array('Suggestions',false)))),'",
no_sug:"'),mce_escape(__(array('No suggestions',false)))),'",
no_mpell:"'),mce_escape(__(array('No misspellings found.',false)))),'"
},
pagebreak:{
desc:"'),mce_escape(__(array('Insert page break.',false)))),'"
}}});

tinyMCE.addI18n("'),$language),'.advanced",{
style_select:"'),mce_escape(_x(array('Styles',false),array('TinyMCE font styles',false)))),'",
font_size:"'),mce_escape(__(array('Font size',false)))),'",
fontdefault:"'),mce_escape(__(array('Font family',false)))),'",
block:"'),mce_escape(__(array('Format',false)))),'",
paragraph:"'),mce_escape(__(array('Paragraph',false)))),'",
div:"'),mce_escape(__(array('Div',false)))),'",
address:"'),mce_escape(__(array('Address',false)))),'",
pre:"'),mce_escape(__(array('Preformatted',false)))),'",
h1:"'),mce_escape(__(array('Heading 1',false)))),'",
h2:"'),mce_escape(__(array('Heading 2',false)))),'",
h3:"'),mce_escape(__(array('Heading 3',false)))),'",
h4:"'),mce_escape(__(array('Heading 4',false)))),'",
h5:"'),mce_escape(__(array('Heading 5',false)))),'",
h6:"'),mce_escape(__(array('Heading 6',false)))),'",
blockquote:"'),mce_escape(__(array('Blockquote',false)))),'",
code:"'),mce_escape(__(array('Code',false)))),'",
samp:"'),mce_escape(__(array('Code sample',false)))),'",
dt:"'),mce_escape(__(array('Definition term ',false)))),'",
dd:"'),mce_escape(__(array('Definition description',false)))),'",
bold_desc:"'),mce_escape(__(array('Bold',false)))),' (Ctrl / Alt+Shift + B)",
italic_desc:"'),mce_escape(__(array('Italic',false)))),' (Ctrl / Alt+Shift + I)",
underline_desc:"'),mce_escape(__(array('Underline',false)))),'",
striketrough_desc:"'),mce_escape(__(array('Strikethrough',false)))),' (Alt+Shift+D)",
justifyleft_desc:"'),mce_escape(__(array('Align left',false)))),' (Alt+Shift+L)",
justifycenter_desc:"'),mce_escape(__(array('Align center',false)))),' (Alt+Shift+C)",
justifyright_desc:"'),mce_escape(__(array('Align right',false)))),' (Alt+Shift+R)",
justifyfull_desc:"'),mce_escape(__(array('Align full',false)))),' (Alt+Shift+J)",
bullist_desc:"'),mce_escape(__(array('Unordered list',false)))),' (Alt+Shift+U)",
numlist_desc:"'),mce_escape(__(array('Ordered list',false)))),' (Alt+Shift+O)",
outdent_desc:"'),mce_escape(__(array('Outdent',false)))),'",
indent_desc:"'),mce_escape(__(array('Indent',false)))),'",
undo_desc:"'),mce_escape(__(array('Undo',false)))),' (Ctrl+Z)",
redo_desc:"'),mce_escape(__(array('Redo',false)))),' (Ctrl+Y)",
link_desc:"'),mce_escape(__(array('Insert/edit link',false)))),' (Alt+Shift+A)",
link_delta_width:"'),mce_escape(_x(array('0',false),array('link popup width',false)))),'",
link_delta_height:"'),mce_escape(_x(array('0',false),array('link popup height',false)))),'",
unlink_desc:"'),mce_escape(__(array('Unlink',false)))),' (Alt+Shift+S)",
image_desc:"'),mce_escape(__(array('Insert/edit image',false)))),' (Alt+Shift+M)",
image_delta_width:"'),mce_escape(_x(array('0',false),array('image popup width',false)))),'",
image_delta_height:"'),mce_escape(_x(array('0',false),array('image popup height',false)))),'",
cleanup_desc:"'),mce_escape(__(array('Cleanup messy code',false)))),'",
code_desc:"'),mce_escape(__(array('Edit HTML Source',false)))),'",
sub_desc:"'),mce_escape(__(array('Subscript',false)))),'",
sup_desc:"'),mce_escape(__(array('Superscript',false)))),'",
hr_desc:"'),mce_escape(__(array('Insert horizontal ruler',false)))),'",
removeformat_desc:"'),mce_escape(__(array('Remove formatting',false)))),'",
forecolor_desc:"'),mce_escape(__(array('Select text color',false)))),'",
backcolor_desc:"'),mce_escape(__(array('Select background color',false)))),'",
charmap_desc:"'),mce_escape(__(array('Insert custom character',false)))),'",
visualaid_desc:"'),mce_escape(__(array('Toggle guidelines/invisible elements',false)))),'",
anchor_desc:"'),mce_escape(__(array('Insert/edit anchor',false)))),'",
cut_desc:"'),mce_escape(__(array('Cut',false)))),'",
copy_desc:"'),mce_escape(__(array('Copy',false)))),'",
paste_desc:"'),mce_escape(__(array('Paste',false)))),'",
image_props_desc:"'),mce_escape(__(array('Image properties',false)))),'",
newdocument_desc:"'),mce_escape(__(array('New document',false)))),'",
help_desc:"'),mce_escape(__(array('Help',false)))),'",
blockquote_desc:"'),mce_escape(__(array('Blockquote',false)))),' (Alt+Shift+Q)",
clipboard_msg:"'),mce_escape(__(array('Copy/Cut/Paste is not available in Mozilla and Firefox.',false)))),'",
path:"'),mce_escape(__(array('Path',false)))),'",
newdocument:"'),mce_escape(__(array('Are you sure you want to clear all contents?',false)))),'",
toolbar_focus:"'),mce_escape(__(array('Jump to tool buttons - Alt+Q, Jump to editor - Alt-Z, Jump to element path - Alt-X',false)))),'",
more_colors:"'),mce_escape(__(array('More colors',false)))),'",
colorpicker_delta_width:"'),mce_escape(_x(array('0',false),array('colorpicker popup width',false)))),'",
colorpicker_delta_height:"'),mce_escape(_x(array('0',false),array('colorpicker popup height',false)))),'"
});

tinyMCE.addI18n("'),$language),'.advanced_dlg",{
about_title:"'),mce_escape(__(array('About TinyMCE',false)))),'",
about_general:"'),mce_escape(__(array('About',false)))),'",
about_help:"'),mce_escape(__(array('Help',false)))),'",
about_license:"'),mce_escape(__(array('License',false)))),'",
about_plugins:"'),mce_escape(__(array('Plugins',false)))),'",
about_plugin:"'),mce_escape(__(array('Plugin',false)))),'",
about_author:"'),mce_escape(__(array('Author',false)))),'",
about_version:"'),mce_escape(__(array('Version',false)))),'",
about_loaded:"'),mce_escape(__(array('Loaded plugins',false)))),'",
anchor_title:"'),mce_escape(__(array('Insert/edit anchor',false)))),'",
anchor_name:"'),mce_escape(__(array('Anchor name',false)))),'",
code_title:"'),mce_escape(__(array('HTML Source Editor',false)))),'",
code_wordwrap:"'),mce_escape(__(array('Word wrap',false)))),'",
colorpicker_title:"'),mce_escape(__(array('Select a color',false)))),'",
colorpicker_picker_tab:"'),mce_escape(__(array('Picker',false)))),'",
colorpicker_picker_title:"'),mce_escape(__(array('Color picker',false)))),'",
colorpicker_palette_tab:"'),mce_escape(__(array('Palette',false)))),'",
colorpicker_palette_title:"'),mce_escape(__(array('Palette colors',false)))),'",
colorpicker_named_tab:"'),mce_escape(__(array('Named',false)))),'",
colorpicker_named_title:"'),mce_escape(__(array('Named colors',false)))),'",
colorpicker_color:"'),mce_escape(__(array('Color:',false)))),'",
colorpicker_name:"'),mce_escape(__(array('Name:',false)))),'",
charmap_title:"'),mce_escape(__(array('Select custom character',false)))),'",
image_title:"'),mce_escape(__(array('Insert/edit image',false)))),'",
image_src:"'),mce_escape(__(array('Image URL',false)))),'",
image_alt:"'),mce_escape(__(array('Image description',false)))),'",
image_list:"'),mce_escape(__(array('Image list',false)))),'",
image_border:"'),mce_escape(__(array('Border',false)))),'",
image_dimensions:"'),mce_escape(__(array('Dimensions',false)))),'",
image_vspace:"'),mce_escape(__(array('Vertical space',false)))),'",
image_hspace:"'),mce_escape(__(array('Horizontal space',false)))),'",
image_align:"'),mce_escape(__(array('Alignment',false)))),'",
image_align_baseline:"'),mce_escape(__(array('Baseline',false)))),'",
image_align_top:"'),mce_escape(__(array('Top',false)))),'",
image_align_middle:"'),mce_escape(__(array('Middle',false)))),'",
image_align_bottom:"'),mce_escape(__(array('Bottom',false)))),'",
image_align_texttop:"'),mce_escape(__(array('Text top',false)))),'",
image_align_textbottom:"'),mce_escape(__(array('Text bottom',false)))),'",
image_align_left:"'),mce_escape(__(array('Left',false)))),'",
image_align_right:"'),mce_escape(__(array('Right',false)))),'",
link_title:"'),mce_escape(__(array('Insert/edit link',false)))),'",
link_url:"'),mce_escape(__(array('Link URL',false)))),'",
link_target:"'),mce_escape(__(array('Target',false)))),'",
link_target_same:"'),mce_escape(__(array('Open link in the same window',false)))),'",
link_target_blank:"'),mce_escape(__(array('Open link in a new window',false)))),'",
link_titlefield:"'),mce_escape(__(array('Title',false)))),'",
link_is_email:"'),mce_escape(__(array('The URL you entered seems to be an email address, do you want to add the required mailto: prefix?',false)))),'",
link_is_external:"'),mce_escape(__(array('The URL you entered seems to external link, do you want to add the required http:// prefix?',false)))),'",
link_list:"'),mce_escape(__(array('Link list',false)))),'"
});

tinyMCE.addI18n("'),$language),'.media_dlg",{
title:"'),mce_escape(__(array('Insert / edit embedded media',false)))),'",
general:"'),mce_escape(__(array('General',false)))),'",
advanced:"'),mce_escape(__(array('Advanced',false)))),'",
file:"'),mce_escape(__(array('File/URL',false)))),'",
list:"'),mce_escape(__(array('List',false)))),'",
size:"'),mce_escape(__(array('Dimensions',false)))),'",
preview:"'),mce_escape(__(array('Preview',false)))),'",
constrain_proportions:"'),mce_escape(__(array('Constrain proportions',false)))),'",
type:"'),mce_escape(__(array('Type',false)))),'",
id:"'),mce_escape(__(array('Id',false)))),'",
name:"'),mce_escape(__(array('Name',false)))),'",
class_name:"'),mce_escape(__(array('Class',false)))),'",
vspace:"'),mce_escape(__(array('V-Space',false)))),'",
hspace:"'),mce_escape(__(array('H-Space',false)))),'",
play:"'),mce_escape(__(array('Auto play',false)))),'",
loop:"'),mce_escape(__(array('Loop',false)))),'",
menu:"'),mce_escape(__(array('Show menu',false)))),'",
quality:"'),mce_escape(__(array('Quality',false)))),'",
scale:"'),mce_escape(__(array('Scale',false)))),'",
align:"'),mce_escape(__(array('Align',false)))),'",
salign:"'),mce_escape(__(array('SAlign',false)))),'",
wmode:"'),mce_escape(__(array('WMode',false)))),'",
bgcolor:"'),mce_escape(__(array('Background',false)))),'",
base:"'),mce_escape(__(array('Base',false)))),'",
flashvars:"'),mce_escape(__(array('Flashvars',false)))),'",
liveconnect:"'),mce_escape(__(array('SWLiveConnect',false)))),'",
autohref:"'),mce_escape(__(array('AutoHREF',false)))),'",
cache:"'),mce_escape(__(array('Cache',false)))),'",
hidden:"'),mce_escape(__(array('Hidden',false)))),'",
controller:"'),mce_escape(__(array('Controller',false)))),'",
kioskmode:"'),mce_escape(__(array('Kiosk mode',false)))),'",
playeveryframe:"'),mce_escape(__(array('Play every frame',false)))),'",
targetcache:"'),mce_escape(__(array('Target cache',false)))),'",
correction:"'),mce_escape(__(array('No correction',false)))),'",
enablejavascript:"'),mce_escape(__(array('Enable JavaScript',false)))),'",
starttime:"'),mce_escape(__(array('Start time',false)))),'",
endtime:"'),mce_escape(__(array('End time',false)))),'",
href:"'),mce_escape(__(array('Href',false)))),'",
qtsrcchokespeed:"'),mce_escape(__(array('Choke speed',false)))),'",
target:"'),mce_escape(__(array('Target',false)))),'",
volume:"'),mce_escape(__(array('Volume',false)))),'",
autostart:"'),mce_escape(__(array('Auto start',false)))),'",
enabled:"'),mce_escape(__(array('Enabled',false)))),'",
fullscreen:"'),mce_escape(__(array('Fullscreen',false)))),'",
invokeurls:"'),mce_escape(__(array('Invoke URLs',false)))),'",
mute:"'),mce_escape(__(array('Mute',false)))),'",
stretchtofit:"'),mce_escape(__(array('Stretch to fit',false)))),'",
windowlessvideo:"'),mce_escape(__(array('Windowless video',false)))),'",
balance:"'),mce_escape(__(array('Balance',false)))),'",
baseurl:"'),mce_escape(__(array('Base URL',false)))),'",
captioningid:"'),mce_escape(__(array('Captioning id',false)))),'",
currentmarker:"'),mce_escape(__(array('Current marker',false)))),'",
currentposition:"'),mce_escape(__(array('Current position',false)))),'",
defaultframe:"'),mce_escape(__(array('Default frame',false)))),'",
playcount:"'),mce_escape(__(array('Play count',false)))),'",
rate:"'),mce_escape(__(array('Rate',false)))),'",
uimode:"'),mce_escape(__(array('UI Mode',false)))),'",
flash_options:"'),mce_escape(__(array('Flash options',false)))),'",
qt_options:"'),mce_escape(__(array('Quicktime options',false)))),'",
wmp_options:"'),mce_escape(__(array('Windows media player options',false)))),'",
rmp_options:"'),mce_escape(__(array('Real media player options',false)))),'",
shockwave_options:"'),mce_escape(__(array('Shockwave options',false)))),'",
autogotourl:"'),mce_escape(__(array('Auto goto URL',false)))),'",
center:"'),mce_escape(__(array('Center',false)))),'",
imagestatus:"'),mce_escape(__(array('Image status',false)))),'",
maintainaspect:"'),mce_escape(__(array('Maintain aspect',false)))),'",
nojava:"'),mce_escape(__(array('No java',false)))),'",
prefetch:"'),mce_escape(__(array('Prefetch',false)))),'",
shuffle:"'),mce_escape(__(array('Shuffle',false)))),'",
console:"'),mce_escape(__(array('Console',false)))),'",
numloop:"'),mce_escape(__(array('Num loops',false)))),'",
controls:"'),mce_escape(__(array('Controls',false)))),'",
scriptcallbacks:"'),mce_escape(__(array('Script callbacks',false)))),'",
swstretchstyle:"'),mce_escape(__(array('Stretch style',false)))),'",
swstretchhalign:"'),mce_escape(__(array('Stretch H-Align',false)))),'",
swstretchvalign:"'),mce_escape(__(array('Stretch V-Align',false)))),'",
sound:"'),mce_escape(__(array('Sound',false)))),'",
progress:"'),mce_escape(__(array('Progress',false)))),'",
qtsrc:"'),mce_escape(__(array('QT Src',false)))),'",
qt_stream_warn:"'),mce_escape(__(array('Streamed rtsp resources should be added to the QT Src field under the advanced tab.',false)))),'",
align_top:"'),mce_escape(__(array('Top',false)))),'",
align_right:"'),mce_escape(__(array('Right',false)))),'",
align_bottom:"'),mce_escape(__(array('Bottom',false)))),'",
align_left:"'),mce_escape(__(array('Left',false)))),'",
align_center:"'),mce_escape(__(array('Center',false)))),'",
align_top_left:"'),mce_escape(__(array('Top left',false)))),'",
align_top_right:"'),mce_escape(__(array('Top right',false)))),'",
align_bottom_left:"'),mce_escape(__(array('Bottom left',false)))),'",
align_bottom_right:"'),mce_escape(__(array('Bottom right',false)))),'",
flv_options:"'),mce_escape(__(array('Flash video options',false)))),'",
flv_scalemode:"'),mce_escape(__(array('Scale mode',false)))),'",
flv_buffer:"'),mce_escape(__(array('Buffer',false)))),'",
flv_startimage:"'),mce_escape(__(array('Start image',false)))),'",
flv_starttime:"'),mce_escape(__(array('Start time',false)))),'",
flv_defaultvolume:"'),mce_escape(__(array('Default volume',false)))),'",
flv_hiddengui:"'),mce_escape(__(array('Hidden GUI',false)))),'",
flv_autostart:"'),mce_escape(__(array('Auto start',false)))),'",
flv_loop:"'),mce_escape(__(array('Loop',false)))),'",
flv_showscalemodes:"'),mce_escape(__(array('Show scale modes',false)))),'",
flv_smoothvideo:"'),mce_escape(__(array('Smooth video',false)))),'",
flv_jscallback:"'),mce_escape(__(array('JS Callback',false)))),'"
});

tinyMCE.addI18n("'),$language),'.wordpress",{
wp_adv_desc:"'),mce_escape(__(array('Show/Hide Kitchen Sink',false)))),' (Alt+Shift+Z)",
wp_more_desc:"'),mce_escape(__(array('Insert More tag',false)))),' (Alt+Shift+T)",
wp_page_desc:"'),mce_escape(__(array('Insert Page break',false)))),' (Alt+Shift+P)",
wp_help_desc:"'),mce_escape(__(array('Help',false)))),' (Alt+Shift+H)",
wp_more_alt:"'),mce_escape(__(array('More...',false)))),'",
wp_page_alt:"'),mce_escape(__(array('Next page...',false)))),'",
add_media:"'),mce_escape(__(array('Add Media',false)))),'",
add_image:"'),mce_escape(__(array('Add an Image',false)))),'",
add_video:"'),mce_escape(__(array('Add Video',false)))),'",
add_audio:"'),mce_escape(__(array('Add Audio',false)))),'",
editgallery:"'),mce_escape(__(array('Edit Gallery',false)))),'",
delgallery:"'),mce_escape(__(array('Delete Gallery',false)))),'"
});

tinyMCE.addI18n("'),$language),'.wpeditimage",{
edit_img:"'),mce_escape(__(array('Edit Image',false)))),'",
del_img:"'),mce_escape(__(array('Delete Image',false)))),'",
adv_settings:"'),mce_escape(__(array('Advanced Settings',false)))),'",
none:"'),mce_escape(__(array('None',false)))),'",
size:"'),mce_escape(__(array('Size',false)))),'",
thumbnail:"'),mce_escape(__(array('Thumbnail',false)))),'",
medium:"'),mce_escape(__(array('Medium',false)))),'",
full_size:"'),mce_escape(__(array('Full Size',false)))),'",
current_link:"'),mce_escape(__(array('Current Link',false)))),'",
link_to_img:"'),mce_escape(__(array('Link to Image',false)))),'",
link_help:"'),mce_escape(__(array('Enter a link URL or click above for presets.',false)))),'",
adv_img_settings:"'),mce_escape(__(array('Advanced Image Settings',false)))),'",
source:"'),mce_escape(__(array('Source',false)))),'",
width:"'),mce_escape(__(array('Width',false)))),'",
height:"'),mce_escape(__(array('Height',false)))),'",
orig_size:"'),mce_escape(__(array('Original Size',false)))),'",
css:"'),mce_escape(__(array('CSS Class',false)))),'",
adv_link_settings:"'),mce_escape(__(array('Advanced Link Settings',false)))),'",
link_rel:"'),mce_escape(__(array('Link Rel',false)))),'",
height:"'),mce_escape(__(array('Height',false)))),'",
orig_size:"'),mce_escape(__(array('Original Size',false)))),'",
css:"'),mce_escape(__(array('CSS Class',false)))),'",
s60:"'),mce_escape(__(array('60%',false)))),'",
s70:"'),mce_escape(__(array('70%',false)))),'",
s80:"'),mce_escape(__(array('80%',false)))),'",
s90:"'),mce_escape(__(array('90%',false)))),'",
s100:"'),mce_escape(__(array('100%',false)))),'",
s110:"'),mce_escape(__(array('110%',false)))),'",
s120:"'),mce_escape(__(array('120%',false)))),'",
s130:"'),mce_escape(__(array('130%',false)))),'",
img_title:"'),mce_escape(__(array('Edit Image Title',false)))),'",
caption:"'),mce_escape(__(array('Edit Image Caption',false)))),'",
alt:"'),mce_escape(__(array('Edit Alternate Text',false)))),'"
});
');
