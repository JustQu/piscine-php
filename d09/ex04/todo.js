id = 0;

$(document).ready(function() {
	$('#add').click(function(){
		let text = prompt("Pleaser fill the TODO", "");
		if (!(text == "" || text == null)){
			add_element(text);
		}
	})
});

$(window).on('load', function(){
	$.ajax({
		url: 'select.php',
	}).done(function(data){
		let elements = data.split('\n');
		let newid = 0;
		for (var i = 0; i < elements.length - 1; i++){	
			add_element(elements[i]);
		}
	})
})

function add_element(text)
{
	let el = $('<div></div>').attr('id', id).text(text);
	el.bind('click', function(){
		del(this);
	});
	$('#ft_list').prepend(el);
	$.ajax({
		method: 'POST',
		url: 'insert.php',
		data: {dat: text, id: id},
	});
	id++;
}

function del(element)
{	if (confirm("Are you sure you want to remove this element?")){
		$.ajax({
			method: 'POST',
			url: 'delete.php',
			data: {id: element.id},
		}).done(function(){
			$(element).remove();
		});
	}
}