(function () {
	var $editCardForm = $('.edit-card-form');
	activate();

	function activate()
	{
		addEvents();	
	}

	function addEvents()
	{
		var $board = $('#board');
		$board.on('click', '.create-card', create);
		$board.on('click', '.create-card-hide', hideCreate);
		$board.on('click', '.store-card', store);
		$board.on('click', '.edit-card', edit);
		$board.on('click', '.edit-card-hide', hideEdit);
		$board.on('click', '.update-card', update);
		$board.on('click', '.delete-card', _delete);
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
				name: $(this).closest('.edit-card-form').find('.card-name').val(),
				board_id: $('#board').attr('data-board-id'),
				list_id: $('.card[href="' + url + '"]').closest('.list').attr('data-list-id'),
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
		var $storeBtn = $(this);
		var $list = $storeBtn.closest('.list');
		$.ajax({
			url: '/cards',
			method: 'POST',
			data: {
				name: $storeBtn.closest('.create-card-form').find('.card-name').val(),
				list_id: $list.attr('data-list-id'),
				board_id: $('#board').attr('data-board-id'),
				order: ($list.find('.card').length + 1)
			},
			error:  function (r) {
				console.log('Error: ' + r.statusText);
			},
			success: function (r) {
				if(r.status == 'success') {
					$storeBtn.closest('.create-card-form').removeClass('active');
					var card = '<a href="' + r.card.href + '" class="card"><span class="card-name">' + r.card.name + '</span><span class="edit-card"></span><span class="delete-card"></span></a>';
					$list.find('.create-card').before(card);
					$list.find('.create-card-form .card-name').val('');
				}
			}
		});
	}

	function create(e)
	{
		e.preventDefault();
		e.stopPropagation();
		$(this).next('.create-card-form').addClass('active');
	}

	function edit(e)
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
			data: {
				board_id: $('#board').attr('data-board-id'),
				list_id: $(this).closest('.list').attr('data-list-id'),
			},
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