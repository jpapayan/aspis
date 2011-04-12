// DE lang variables

if (navigator.userAgent.indexOf('Mac OS') != -1) {
// Mac OS browsers use Ctrl to hit accesskeys
	var metaKey = 'Ctrl';
}
else {
	var metaKey = 'Alt';
}

tinyMCE.addI18n('de.embeddedvideo',{
desc : 'Embedded Video Plugin - Video einfügen'
});