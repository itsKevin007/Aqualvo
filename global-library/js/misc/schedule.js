// JavaScript Document

function add()
{
	window.location.href = 'index.php?view=add';
}

function mod(id)
{
	window.location.href = 'index.php?view=modify&id=' + id;
}

function delc(id,nu)
{
	if (confirm('Delete this customer?')) {
		window.location.href = 'processDelete.php?id=' + id + '&nu=' + nu;
	}
}

function delimg(id)
{
	if (confirm('Delete this image?')) {
		window.location.href = 'processDeleteImage.php?id=' + id;
	}
}
