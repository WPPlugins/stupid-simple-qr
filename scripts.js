/**
 * @package stupid-simple-qr
 * @author Gabriel Nagmay <gabriel@nagmay.com>
 * @link http://wordpress.org/extend/plugins/stupid-simple-qr/
 */
 
//<![CDATA[

/**
 * When the document is ready
 */
jQuery(document).ready(function() {	
	if(jQuery("#shortlink").length){ // we have a shortcode!
		ssqrCreate();
	}
});

function ssqrCreate(){
	var slug = jQuery("#shortlink").val() + ssqrAppend; // append from options if available
	jQuery("#titlediv .inside #edit-slug-box").append('<a class="button button-small" href="http://chart.apis.google.com/chart?cht=qr&chs=500x500&chl='+slug+'" target="_blank" title="Get the QR code for this page">QR</a>');

}
//]]>	