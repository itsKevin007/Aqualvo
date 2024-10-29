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
	if (confirm('Delete this expense?')) {
		window.location.href = 'process.php?action=delete&id=' + id;
	}
}

function delbeg(id)
{
	if (confirm('Delete this amount?')) {
		window.location.href = 'process.php?action=delbeg&id=' + id;
	}
}