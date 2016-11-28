(function () {
	var $editCardSection = $('.edit-card-section');
	activate();

	function activate()
	{
		addEvents();	
	}

	function addEvents()
	{
		$('.create-card').click(toggleAddCard);
		$('.store-card').click(storeCard);
		$('.edit-card').click(toggleEditCard);	
		$('.delete-card').click(toggleDeleteCard);	
	}

	function storeCard()
	{
		$.ajax({
			url: '/cards',
			method: 'POST',
			data: {
				_token: $('meta[name="csrf-token"]').attr('content'),
				name: $(this).closest('.store-card-section').find('.card-name').val(),
				list_id: $(this).closest('.list').attr('data-id'),
				order: ($(this).closest('.list').find('.card').length + 1)
			},
			error:  function (r) {
				console.log('Error: ' + r.statusText);
			},
			success: function (r) {
				console.log(r);
			}
		});
	}

	function toggleAddCard(e)
	{
		e.preventDefault();
		e.stopPropagation();
		$(this).next('.store-card-section').toggleClass('active');
	}

	function toggleEditCard(e)
	{
		e.preventDefault();
		e.stopPropagation();
		var cardName = $(this).closest('.card').find('.card-name').text();
		$editCardSection.find('.card-name').val(cardName);
		$editCardSection.addClass('active');
	}

	function toggleDeleteCard(e)
	{
		e.preventDefault();
		e.stopPropagation();
		cardLink = $(this).closest('.card').attr('href');
		$.ajax({
			url: cardLink,
			method: 'POST',
			data: {
				_token: $('meta[name="csrf-token"]').attr('content'),
				_method: 'DELETE'
			},
			error:  function (r) {
				console.log('Error: ' + r.statusText);
			},
			success: function (r) {
				if(r.status == 'success') console.log('card deleted: ' + r.message);
			}
		});
	}

})();