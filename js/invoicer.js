$(document).ready(function(){
	// project info toggle
	$('.view_project #project_info').hide();
	$('#project_info_label').click(function(){
		if ($('#project_info').is(":visible")) {
			$('#project_info').hide();
			$('#project_info_label span').text('>');
		} else {
			$('#project_info').show();
			$('#project_info_label span').text('v');
		}
	});

	// chunk type toggle
	if ($('.flat input').val()) {
		$('.flat, .hourly').toggle();
		$('.flat input, .hourly input').toggleDisabled();
	}
	$('.type-toggle').click(function(){
		$('.flat, .hourly').toggle().find('input');
		$('.flat input, .hourly input').toggleDisabled();
	});
})

$.fn.toggleDisabled = function(){
	return this.each(function(){
		this.disabled = !this.disabled;
	});
};