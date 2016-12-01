(function () {
	activate();

	function activate()
	{
		attachEvents();
	}

	function attachEvents()
	{
		$('.create-list').click(create);
		$('.create-list-hide').click(hideCreate);
		$('.store-list').click(store);
		$('#board').on('click', '.list-name', edit);
		$('#board').on('click', '.update-list', update);
		$('#board').on('click', '.delete-list', _delete);
	}

	function hideCreate()
	{
		$('.create-list-form').removeClass('is-shown');
	}

	function create()
	{
		$('.create-list-form').addClass('is-shown');
	}

	function store()
	{
		var $form = $(this).closest('.create-list-form');
		$.ajax({
			url: '/lists',
			method: 'POST',
			data: {
				_token: $('meta[name="csrf-token"]').attr('content'),
				board_id: $('#board').attr('data-board-id'),
				order: $('.list').length,
				name: $form.find('.list-name').val(),
			},
			error: function (e) { console.log(e.statusText); },
			success: function (r) {
				if(r.status == 'success') {
					var list = '<li class="list-wrapper"><div class="list" data-list-id="' + r.list.id + '"><div class="list-header"><span><strong class="list-name">' + r.list.name + '</strong></span><button class="rename-list">Rename</button><span class="delete-list"></span></div><a href="#" class="create-card">Add a card...</a><div class="create-card-form"><header class="create-card-header"><span>Create Card</span><span class="create-card-hide"></span></header><div class="create-card-body"><div class="form-group"><label for="create-card-name" class="control-label">Title</label><input type="text" class="form-control card-name" required="required" placeholder="New Card Name" name="name"></div><button class="btn btn-primary store-card">Create</button></div></div></div></li>';
					$('.create-list-wrapper').before(list);
					$form.find('.list-name').val('');
					hideCreate();
				}
			}
		});
	}

	function edit()
	{
		$(this).attr('contenteditable', '');
		$('.rename-list').addClass('is-shown');
	}

	function hideEdit()
	{
		var $btn = $(this);
		$btn.closest('.list-header').find('.list-name').removeAttr('contenteditable');
		$btn.removeClass('is-shown');
	}

	function update()
	{
		var $list = $(this).closest('.list');
		$.ajax({
			url: $list.attr('data-list-id'),
			method: 'PATCH',
			data: {
				_token: $('meta[name="csrf-token"]').attr('content'),
				name: $list.find('.list-name')
			},
			error: function (e) { console.log(e.statusText); },
			success: function (r) { if(r.status == 'success') hideEdit(); }
		});
	}

	function _delete()
	{
		$list = $(this).closest('.list');
		$.ajax({
			url: '/lists/' + $list.attr('data-list-id'),
			method: 'DELETE',
			data: {
				_token: $('meta[name="csrf-token"]').attr('content'),
				_method: 'DELETE'
			},
			error: function (e) {  },
			success: function (r) {
				if(r.status == 'success') {
					$list.parent().slideUp(300, function () {
						$(this).remove();
					});
				}
			}
		});
	}
})();