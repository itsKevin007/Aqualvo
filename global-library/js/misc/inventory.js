// JavaScript Document

function add_material()
{
	window.location.href = 'index.php?view=add_material';
}

function add_salt()
{
	window.location.href = 'index.php?view=add_salt';
}

function add_dispenser()
{
	window.location.href = 'index.php?view=add_dispenser';
}

function add_filter()
{
	window.location.href = 'index.php?view=add_filter';
}

function mod(id)
{
	window.location.href = 'index.php?view=modify&id=' + id;
}

function del(id)
{
	if (confirm('Delete this item?')) {
		window.location.href = 'processDelete.php?action=delete&id=' + id;
	}
}