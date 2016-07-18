function validateFormAddSong() {
    var song = document.forms["addsongform"]["name"].value;
    var artist = document.forms["addsongform"]["artist"].value;
    var albumn = document.forms["addsongform"]["albumn"].value;

	if(!song || !artist || !albumn){
		document.getElementById("error").innerHTML = "Empty Field!";
		return false;
	}

	return true;
}

function validateFormCreateAccount(){
    var email = document.forms["createaccountform"]["email"].value;
    var user = document.forms["createaccountform"]["name"].value;
    var password = document.forms["createaccountform"]["password"].value;

	if(!email || !user || !password){
		document.getElementById("error").innerHTML = "Empty Field!";
		return false;
	}

	if(!email.includes("@") && !email.includes(".")){
		document.getElementById("error").innerHTML = "Invalid Email!";
		return false;
	}

	return true;
}

function loadSongList(x) {
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			document.getElementById("songlist").innerHTML = xhttp.responseText;
			document.getElementById("songlist").style.opacity = '1';
		}
	};

	xhttp.open("GET", "songlists/video" + x + ".txt", true);
	xhttp.send();
}
