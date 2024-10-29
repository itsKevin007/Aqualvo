// JavaScript Document

function add(id)
{
	window.location.href = '../index.php?id=' + id;
}

function detail(oId)
{
	window.location.href = 'index.php?view=detail&oid=' + oId;
}

function del(oId)
{
	if (confirm('Delete this transaction?')) {
		window.location.href = 'processDelete.php?oid=' + oId;
	}
}

function delitem(oId)
{
	if (confirm('Delete this item?')) {
		window.location.href = 'processDeleteItem.php?oid=' + oId;
	}
}