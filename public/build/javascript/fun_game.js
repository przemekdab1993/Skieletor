//Funkcje gry

$( function() {
	//sprwadzanie czy wszystkie zasoby się wczytały
	if ($('.field_box').length < 80) 
	{
		$('#field').text("Przepraszamy za utrudnienia");
	}
	
	// naciśnięcie przycisku listy wyboru narzędzi
	$('.button_game_off').on('click', function(e) {
		let $target = $(e.target);
		$('.button_game_off').removeClass('button_game_on');
		$target.addClass('button_game_on');	
	});
});