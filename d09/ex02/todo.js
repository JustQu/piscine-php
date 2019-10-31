
if(document.cookie)
{
	arr = document.cookie.split(';');
	let arr2 = new Array();
	let list = document.getElementById("ft_list");
	for(var i = 0; i < arr.length; i++){
		b = arr[i].split('=');
		b[0] = parseInt(b[0]);
		newTODO = document.createElement('div');
		newTODO.setAttribute('onclick', 'remove_element(this)');
		text = document.createTextNode(b[1]);
		newTODO.appendChild(text);
		arr2[b[0]] = newTODO;
	}
	for (i = 0; i < arr2.length; i++){
		list.appendChild(arr2[i]);
	}
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

function func()
{
	var TODO = prompt("Pleaser fill the TODO", "");
	var list = document.getElementById("ft_list");
	if (!(TODO == "" || TODO == null)){
		newTODO = document.createElement("div");
		newTODO.setAttribute("onclick", 'remove_element(this)');
		text = document.createTextNode(TODO);
		newTODO.appendChild(text);
		list.insertBefore(newTODO, list.firstChild);

		c = list.childNodes;
		id = 0;
		for (i = 0; i < c.length; i++){
			if (c[i].nodeName == '#text'){
				continue;
			}
			createCookie(id, c[i].textContent);
			id++;
		}
	}
}

function createCookie(name,value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name,"",-100);
}