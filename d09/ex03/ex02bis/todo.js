$(document).ready(function() {
	$('#add').click(function(){
		let text = prompt("Pleaser fill the TODO", "");
		if (!(text == "" || text == null)){
			let el = $('<div></div>').text(text);
			el.bind("click", function(){
				remove_element(this);
			})
			$('#ft_list').prepend(el);
		}

		lists = $('#ft_list').children();
		id = 0;
		for(let i = 0; i < lists.length; i++){
			if (jQuery.type(lists[i]) == "undefined"){
				continue;
			}
			createCookie(id, lists[i].textContent);
			id++;
		}
	})
});

$(window).on('load', function(){
	if (document.cookie){
		arr = document.cookie.split(';');
		let arr2 = new Array();

		for (let i = 0; i < arr.length; i++){
			let element = arr[i].split('=');
			element[0] = parseInt(element[0]);
			let text = $('<div></div>').text(element[1]);
			text.bind('click', function(){
				remove_element(this);
			})
			arr2[element[0]] = text;
		}

		for (i = 0; i < arr2.length; i++){
			$('#ft_list').append(arr2[i]);
		}
	}
})

function createCookie(name,value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function eraseCookie(name) {
    createCookie(name,"",-100);
}

function remove_element(el){
	if (confirm("Are you sure you want to remove this element?")){
		el.parentNode.removeChild(el);

		var list = document.getElementById("ft_list");
		c = list.childNodes;
		id = 0;
		for (i = 0; i < c.length; i++){
			if (c[i].nodeName == '#text'){
				continue;
			}
			createCookie(id, c[i].textContent);
			id++;
		}
		eraseCookie(c.length - 1);
	}
}