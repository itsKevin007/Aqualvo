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
	if (confirm('Delete this user?')) {
		window.location.href = 'processDelete.php?id=' + id;
	}
}

function delimg(id)
{
	if (confirm('Delete this image?')) {
		window.location.href = 'processDeleteImage.php?id=' + id;
	}
}
