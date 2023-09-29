$(document).ready(function(){
});
var textPattern = "^[a-z A-Z ñ Ñ]{1,255}$";
var textPattern2 = "^[a-z A-Z ñ Ñ á Á é É í Í ó Ó ú Ú Ü + -- & ]{1,255}$";
var alfanumericPattern = "^[a-z A-Z ñ Ñ 0-9]{1,255}$";
var alfanumericPattern2 = "^[a-z A-Z ñ Ñ 0-9 á Á é É í Í ó Ó ú Ú Ü + & -- .,!¡¿?]{1,255}$";
var alfanumericPattern3 = "^[a-z A-Z ñ Ñ 0-9 á Á é É í Í ó Ó ú Ú Ü + & -- .,! ¡ ¿ ? @ / # $ % ^ & * ( ) _ ` ~ ]{1,255}$";
var alfanumericPatternName = "^[a-z A-Z ñ Ñ á Á é É í Í ó Ó ú Ú Ü]{1,255}$";
var alfanumericPatternEmpty = "^[a-z A-Z ñ Ñ 0-9]$";
var numberPattern = "^[0-9]{1,255}$";
var numberPattern2 = "^[0-9 . , ]{1,255}$";
var numberPattern3 = "^[0-9 . ]{1,255}$";
var emailPattern = "^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$";
function checkInput(idInput, pattern) {
	return idInput.match(pattern) ? true : false;
}
function checkRadioBox(nameRadioBox) {
return $(nameRadioBox).is(":checked") ? true : false;
}
function checkTextarea(idText) {
return $(idText).val().length > 12 ? true : false;	
}
function checkSelect(idSelect) {
return $(idSelect).val() ? true : false;
}

function colorInput(color,clase){
	$(clase).removeClass("border-green");
	$(clase).removeClass("border-red");
	$(clase).addClass(color);
}

