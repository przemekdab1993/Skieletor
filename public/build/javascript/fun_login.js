// Skrypt do formlarza logowania urzytkownika
// sprawdzanie poprawności wypełnianych input'ów

var flag_user, flag_pass;
var $submit = $('form');
var $input_user = $('#user_name');
var $input_pass = $('#password');


$( function() {
	flag_user = true;
	flag_pass = false;
	
	$input_user.on('focusout', function(e) {
		let target = e.target;
		if( $(target).val() == '')
		{
			flag_user = false;
			$('#span_' + this.name).text("Nie podałeś nazwy użytkownika");
		} else
		{
			if( $(target).val().length < 4)
			{
				flag_user = false;
				$('#span_' + this.name).text("Nazwa użytkownika jest za krótka");
			} else 
			{
				flag_user = true;
				$('#span_' + this.name).text("");
			}
		}
	});

	$input_pass.on('focusout', function(e) {
		let target = e.target;
		if( $(target).val() == '')
		{
			flag_pass = false;
			$('#span_' + this.name).text("Podaj hasło");
		} else 
		{
			flag_pass = true;
			$('#span_' + this.name).text("");
		}
	});
	$submit.on('submit', function(e) {
		if (!flag_user || !flag_pass)
		{
			e.preventDefault();
		}
	});
});