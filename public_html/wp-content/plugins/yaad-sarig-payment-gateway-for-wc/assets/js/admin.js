jQuery(document).ready(function(){
	
	jQuery('ul.tabs li').click(function(){
		var tab_id = jQuery(this).attr('data-tab');

		jQuery('ul.tabs li').removeClass('current');
		jQuery('.tab-content').removeClass('current');

		jQuery(this).addClass('current');
		jQuery("#"+tab_id).addClass('current');
        window.location.hash = tab_id;
	})


	if (window.location.hash!=''){
        jQuery('ul.tabs li').removeClass('current');
        jQuery('.tab-content').removeClass('current');
        jQuery(window.location.hash).addClass('current');
        jQuery(window.location.hash+'-tab').addClass('current');
	};
})

function view_log() {
	var data = {
		'action': 'yaadpay_view_log',
	};
	jQuery.post(ajaxurl, data, function(response) {
		var logDisplay=document.getElementById('log-display');
		logDisplay.innerHTML=response;
	});
}
function delete_log() {
	var data = {
		'action': 'yaadpay_delete_log',
	};
	jQuery.post(ajaxurl, data, function(response) {
		var logDisplay=document.getElementById('log-display');
		logDisplay.innerHTML='';
	});
}