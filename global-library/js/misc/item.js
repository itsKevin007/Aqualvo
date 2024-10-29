// JavaScript Document

function add()
{
	window.location.href = 'index.php?view=add';
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