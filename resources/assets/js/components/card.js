(function () {
	var $editCardForm = $('.edit-card-form');
	activate();

	function activate()
	{
		addEvents();	
	}

	function addEvents()
	{
		$('#board').on('click', '.create-card', showCreate);
		$('#board').on('click', '.create-card-hide', hideCreate);
		$('#board').on('click', '.store-card', store);
		$('#board').on('click', '.edit-card', showEdit);
		$('#board').on('click', '.edit-card-hide', hideEdit);
		$('#board').on('click', '.update-card', update);
		$('#board').on('click', '.delete-card', _delete);
	}

	function hideCreate()	{ $(this).closest('.create-card-form').removeClass('active');	}

	function hideEdit()	{ $('.edit-card-form').removeClass('active');	}

	function update()
	{
		var url = $(this).attr('data-href');
		$.ajax({
			url: url,
			method: 'PATCH',
			data: {
				_token: $('meta[name="csrf-token"]').attr('content'),
				name: $(this).closest('.edit-card-form').find('.card-name').val()
			},
			error: function (e) { console.log(e.statusText) },
			success: function (r) {
				hideEdit();
				$('.card[href="' + url + '"] .card-name').text(r.message);
			}
		});
	}

	function store()
	{
		var $list = $(this).closest('.list');
		$.ajax({
			url: '/cards',
			method: 'POST',
			data: {
				_token: $('meta[name="csrf-token"]').attr('content'),
				name: $(this).closest('.create-card-form').find('.card-name').val(),
				list_id: $list.attr('data-list-id'),
				order: ($list.find('.card').length + 1)
			},
			error:  function (r) {
				console.log('Error: ' + r.statusText);
			},
			success: function (r) {
				if(r.status == 'success') {
					hideCreate();
					var card = '<a href="' + r.message.href + '" class="card"><span class="card-name">' + r.message.name + '</span><span class="edit-card"></span><span class="delete-card"></span></a>';
					$list.find('.create-card').before(card);
				}
			}
		});
	}

	function showCreate(e)
	{
		e.preventDefault();
		e.stopPropagation();
		$(this).next('.create-card-form').addClass('active');
	}

	function showEdit(e)
	{
		e.preventDefault();
		e.stopPropagation();
		var cardName = $(this).closest('.card').find('.card-name').text();
		$editCardForm.find('.card-name').val(cardName);
		$editCardForm.addClass('active')
			.find('.update-card').attr('data-href', $(this).closest('.card').attr('href'));
	}

	function _delete(e)
	{
		e.preventDefault();
		e.stopPropagation();
		var $card = $(this).closest('.card');
		$.ajax({
			url: $card.attr('href'),
			method: 'DELETE',
			data: { _token: $('meta[name="csrf-token"]').attr('content') },
			error:  function (r) {
				console.log('Error: ' + r.statusText);
			},
			success: function (r) {
				if(r.status == 'success') {
					$card.remove();
				}
			}
		});
	}

})();