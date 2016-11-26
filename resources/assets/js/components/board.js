(function () {
	activate();

	function activate()
	{
		attachEvents();
	}

	function attachEvents()
	{
		$('.board-star').click(toggleFavorite);
		$('.new-board-show').click(showNewBoardForm);
		$('.new-board-hide').click(hideNewBoardForm);
	}

	function showNewBoardForm()
	{
		$('.new-board-form').addClass('active');
	}

	function hideNewBoardForm()
	{
		$('.new-board-form').removeClass('active');
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
			data: {
				_token: $star.attr('data-token'),
				is_favorite: 1
			},
			error: function (e) {
				console.log(e.statusText);
			},
			success: function (r) {
				console.log(r);
			}
		});
	}

	function removeFavorite($star)
	{
		$star.removeClass('active');
		$.ajax({
			url: $star.closest('.board').attr('href'),
			method: 'PATCH',
			data: {
				_token: $star.attr('data-token'),
				is_favorite: 0
			},
			error: function (e) {
				console.log(e.statusText);
			},
			success: function (r) {
				console.log(r);
			}
		});
	}
})();