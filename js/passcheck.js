//Adaugare EventListener la incarcarea paginii 
window.addEventListener("load", start, false);

//Adaugare EventListener la introducerea parolelor noi
function start(){
	document.getElementById('parola3').addEventListener('input',verEgalitate,false);
	document.getElementById('parola2').addEventListener('input',verEgalitate,false);
}

//Functie pentru verificarea egalitatii dintre parolele noi
function verEgalitate() {
	if(document.getElementById("parola2").value == document.getElementById("parola3").value) {
	document.getElementById("chkForm1").style.backgroundColor = "green";
	document.getElementById("message").innerHTML = 'New passwords match';
	}
else {
	document.getElementById("chkForm1").style.backgroundColor = "red";
	document.getElementById("message").innerHTML = 'New passwords do not match';
}
}

