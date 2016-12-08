(function () {
	activate();

	function activate() { attachEvents();	}
	
	function attachEvents()
	{
		$('.board-visibility').change(updateVisiblity);
		$('.create-board-show').click(create);
		$('.create-board-hide').click(hideCreate);
		$('.board-name').click(edit);
		$('.favorite-board').click(toggleFavorite);
		$('.rename-board').click(updateName);
		$('.delete-board').click(_delete);
	}

	function create() { $('.create-board-form').addClass('active'); }
	function hideCreate()	{	$('.create-board-form').removeClass('active'); }

	function edit()
	{
		$(this).attr('contenteditable', '');
		$('.rename-board').addClass('is-shown');
	}

	function hideEdit()
	{
		$(this).removeAttr('contenteditable');
		$('.rename-board').removeClass('is-shown');
	}

	function toggleFavorite(e)
	{
		e.preventDefault();
		e.stopPropagation();
		var $star = $(this);

		if(!$star.hasClass('active')) addFavorite($star);
		else removeFavorite($star);
	}

	function addFavorite($star)
	{
		$star.addClass('active');
		$.ajax({
			url: $star.closest('.board').attr('href'),
			method: 'PATCH',
			data: { is_favorite: 1 },
			error: function (e) { console.log(e.statusText); },
			success: function (r) { console.log(r); }
		});
	}

	function removeFavorite($star)
	{
		$star.removeClass('active');
		$.ajax({
			url: $star.closest('.board').attr('href'),
			method: 'PATCH',
			data: { is_favorite: 0 },
			error: function (e) { console.log(e.statusText); },
			success: function (r) { console.log(r); }
		});
	}

	function updateName()
	{
		$.ajax({
			url: $('#board').attr('data-board-id'),
			method: 'PATCH',
			data: {
				name: $('.board-name').text()
			},
			error: function (e) { console.log(e.statusText); },
			success: function (r) { console.log(r);if(r.status == 'success') hideEdit(); }
		});
	}

	function updateVisiblity()
	{
		$.ajax({
			url: '/boards/' + $('#board').attr('data-board-id'),
			method: 'PATCH',
			data: { visibility: $(this).val() },
			error: function (e) { console.log(e.statusText); },
			success: function (r) { console.log(r); }
		});
	}

	function _delete(e)
	{
		e.preventDefault();
		e.stopPropagation();
		var $board = $(this).closest('.board');
		$.ajax({
			url: $board.attr('href'),
			method: 'DELETE',
			error: function (e) { console.log(e.statusText); },
			success: function (r) {
				if(r.status == 'success') {
					$board.parent('.board-wrapper')
						.slideUp(300, function () {
							$(this).remove();
						});
				}
			}
		});
	}
})();