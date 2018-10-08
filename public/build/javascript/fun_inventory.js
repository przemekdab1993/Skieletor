const $li_button = $('#inventory_categories ul li');
$(function() {
	$('.inventory').not('#inv_0').hide();
	
	$li_button.on('click', function() {
		$li_button.css('backgroundColor', '#cccccc');
		$(this).css('backgroundColor', '#808080');
		
		let tag = this.id;
		tag = tag.substring(4);
		$('.inventory').hide();
		$('#inv_' + tag).show();
	});
	$('.inventory').not('#inv_0').each(function() {
		let buf = '';
		for( let i = 0; i < 27; i++)
		{
			buf += '<div class="box_inventory" id="box_' + i + '"></div>';
		}
		$(this).html(buf);
	});
});