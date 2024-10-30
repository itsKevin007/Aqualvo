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
	if (confirm('Delete this customer?')) {
		window.location.href = 'processDelete.php?id=' + id;
	}
}

function inactive(id)
{
	if (confirm('Are you sure changing the status of the customer?')) {
		window.location.href = 'processInac.php?id=' + id;
	}
}

function delimg(id)
{
	if (confirm('Delete this image?')) {
		window.location.href = 'processDeleteImage.php?id=' + id;
	}
}
