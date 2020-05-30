$(document).ready(function() {
	$(function () {
		 $("#task").change(function() {
			 $('.task-result').html('');
			 $("#tasks-content > div").hide();
			 $("#" + $("#task option:selected").attr('id') + "form").show();
		}).trigger('change');
	});
});