// Skrypt do formularza rejestracyjnego nowego użytkownika
// sprawdzanie poprawności wypełnianych input'ów

$text_box = $(':input:not(:submit):not(:checkbox)');
$(function() {
	$text_box.on('focusout', function(e) {
		let target = e.target;
		
		if($(target).val() == '')
		{
			$(target).css('borderColor', '#ff6666');
			$('#span_' + target.id).text("Wypełnij pole");
		}
		else
		{
			$(target).css('borderColor', '#fff');
			$('#span_' + target.id).text('');
		}
	});
	$('form').on('submit', function(e) {
		if (flag == false)
		{
			e.preventDefault();
		}
	});
});