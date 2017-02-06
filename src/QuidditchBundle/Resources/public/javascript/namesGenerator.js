
function generateName(target) {
	$.ajax({
		url: 'https://randomuser.me/api/',
		dataType: 'json',
		success: function(data) {
			$(target).val(
				data.results[0].name.first + " " + data.results[0].name.last
			);
		}
	});
}