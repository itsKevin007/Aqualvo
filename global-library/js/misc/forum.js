// JavaScript Document


function view(id)
{
	window.location.href = 'index.php?view=detail&id=' + id;
}

function delprog(id)
{
	if (confirm('Delete this forum message?')) {
		window.location.href = 'process.php?action=delete_forum&id=' + id;
	}
}

function delimg(id)
{
	if (confirm('Delete this image?')) {
		window.location.href = 'process.php?action=delete_forum_img&id=' + id;
	}
}