(function () {
	var currentSearch, lastSearch;
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
		$('.show-board-settings').click(showBoardSettings);
		$('.hide-board-settings').click(hideBoardSettings);
		$('.member-to-invite').keyup(getUsers);
		$('.potential-members-list').on('click', '.potential-member-to-invite', addMember);
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

	function showBoardSettings()
	{
		$('.board-settings').addClass('is-shown');
	}

	function hideBoardSettings()
	{
		$('.board-settings').removeClass('is-shown');
	}

	function toggleFavorite(e)
	{
		e.preventDefault();
		e.stopPropagation();
		var $star = $(this);

		if(!$star.hasClass('active')) addFavorite($star);
		else removeFavorite($star);
	}

	function addMember()
	{
		var $member = $(this);
		$.ajax({
			url: '/boards/' + $('#board').attr('data-board-id') + '/addMember',
			method: 'POST',
			data: { id: $member.attr('data-member-id') },
			error: function (e) { console.log(e.statusText); },
			success: function (r) {
				var name = $member.text();
				var id = $member.attr('data-member-id');
				var member = '<div class="member" data-member-id="' + id + '"><div class="member-name">' + name + '</div></div>';
				$(member).appendTo($('.members'));
				$member.remove();
			}
		});
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
			url: '/boards/' + $('#board').attr('data-board-id'),
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
			data: { is_private: $(this).val() },
			error: function (e) { console.log(e.statusText); },
			success: function (r) {  }
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

	function members()
	{
		var members = [];
		$.each($('.members .member-name'), function (i, v) {
			members.push($(v).text());
		});
		return members;
	}

	function getUsers()
	{
		var $list = $('.potential-members-list');
		var $input = $(this);
		currentSearch = $input.val();
		if(currentSearch.length >= 3 && currentSearch != lastSearch) {
			$.ajax({
				url: '/boards/' + $('#board').attr('data-board-id') + '/nonMembers',
				method: 'GET',
				data: {
					name: currentSearch,
					members: members
				},
				error: function (e) { console.log(e.statusText); },
				success: function (r) {
					var users = '', i;
					var nbOfUsers = r.users.length;
					for(i=0; i<nbOfUsers; i++) {
						users += '<li class="potential-member-to-invite" data-member-id="' + r.users[i].id + '">' + r.users[i].name + '</li>';
					}
					$list.html('').addClass('is-shown');
					$(users).appendTo($list);
				}
			});
		}
		else if(currentSearch.length == 0) $list.removeClass('is-shown');
		lastSearch = currentSearch;
	}
})();