
function validats(){
    var password1 = document.getElementById("psw").value;
   var password2 = document.getElementById("pswrepeat").value;
   var reg = new RegExp("^(?=(.*[a-z]){3,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){2,})(?=(.*[!@#$%^&*()\-__+.]){1,}).{12,}$"); //password strength RegExp
   //if both passwords match and meet the specified complexity
   if(password1.localeCompare(password2)==0 && reg.test(password1)){
       var DOB_day = document.getElementById("DOB_d").value;
       var DOB_month = document.getElementById("DOB_m").value;
       var DOB_year = document.getElementById("DOB_y").value;
       var gender = document.getElementById("gender").value;
       if(DOB_day.length!=0 && DOB_month.length!=0 && DOB_year.length!=0 && gender.length!=0) {
           var surname = document.getElementById("surname").value;
           var firstname = document.getElementById("first_name").value;
           var reg2 = new RegExp("^[a-zA-Z ]*$");
           //if firstname and surname comprise of only alphabetic letters
           if(reg2.test(surname) && surname.length!=0 && reg2.test(firstname) && firstname.length!=0) {
               var phone_no = document.getElementById("phone"); 
               var phoneformat = /^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/;
               //if phone number matches the specified regular expression
               if(phone_no.value.match(phoneformat)) {
                   var email = document.getElementById("email"); 
                   var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                   //if email matches the regular expression for emails
                   if(email.value.match(mailformat)) return true;
                   else return false;
               }
               else return false;
           }else return false;
       } else return false;
   } else return false;
}
function valids(){
    var pass1 = document.getElementById("psw").value;
   var pass2 = document.getElementById("pswrep").value;
   var reg = new RegExp("^(?=(.*[a-z]){3,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){2,})(?=(.*[!@#$%^&*()\-__+.]){1,}).{8,}$");
   if(pass1.localeCompare(pass2)==0 && reg.test(pass1)){
       
       return true;
   } else return false;
        
    
}
function validateEmail(str) {
    if (str.length == 0) {
        document.getElementById("mailspan").innerHTML = "field is required";
        return;
    } else {
	 document.getElementById("mailspan").innerHTML = ""; 
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("mailspan").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "validbiodata.php?q=" + str, true);
        xmlhttp.send();
    }
}
function validatepass1(str) {
    if (str.length === 0) {
        document.getElementById("pass1span").innerHTML = "field is required";
        return;
    } else {
	document.getElementById("pass1span").innerHTML = ""; 
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("pass2span").innerHTML = xmlhttp.responseText;
            }
        };
	var p= document.getElementById("pswrepeat").value;
        xmlhttp.open("GET", "validatepasswd.php?q=" + str + "&p=" + p, true);
        xmlhttp.send();
        
    }
}
function validatepass2(str) {
    if (str.length == 0) {
        document.getElementById("pass2span").innerHTML = "field is required";
        return;
    } else {
	/* document.getElementById("pass2span").innerHTML = ""; */
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("pass2span").innerHTML = xmlhttp.responseText;
            }
        };
	var p= document.getElementById("psw").value;
        xmlhttp.open("GET", "validatepasswd.php?q=" + str + "&p=" + p, true);
        xmlhttp.send();
    }
}
function validsurname(str) {
    if (str.length == 0) {
        document.getElementById("surnamespan").innerHTML = "field is required";
        return;
    } else {
	/* document.getElementById("pass2span").innerHTML = ""; */
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("surnamespan").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "validatenames.php?q=" + str, true);
        xmlhttp.send();
    }
}
function validPhone(str){
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                return xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "validatenames.php?ph=" + str, true);
        xmlhttp.send();
        
}
function validatePhone(str) {
    if (str.length == 0) {
        document.getElementById("phonespan").innerHTML = "field is required";
        return;
    } else {
	/* document.getElementById("pass2span").innerHTML = ""; */
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("phonespan").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "validatenames.php?r=" + str, true);
        xmlhttp.send();
    }
}
function validname(str) {
    if (str.length == 0) {
        return;
    } else {
	/* document.getElementById("pass2span").innerHTML = ""; */
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("namespan").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "validatenames.php?p=" + str, true);
        xmlhttp.send();
    }
}
function verify(){
	var name = document.getElementById("username").value;
	var pass = document.getElementById("password").value;
	
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("loginerror").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "authenticate.php?p=" + name + "&q=" + pass, true);
        xmlhttp.send();
}
function loadpic(){
	var file = document.getElementById("passport").value;
	var biod = document.getElementById("bio").value;
	
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("dpspan").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("POST", "ajax_upload.php?p=" + file + "&q=" + biod + "&r=1", true);
        xmlhttp.send();
}
function dropbooks(){
	var age = document.getElementById("test").value;
	var favb = document.getElementById("bok").value;
	
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("booke").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "ajax_upload.php?p=" + age + "&q=" + favb + "&r=2", true);
        xmlhttp.send();
}
function dropchapters(){
	var bk = document.getElementById("booke").value;
	var favch = document.getElementById("chap").value;
	
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("chapterz").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "ajax_upload.php?p=" + bk + "&q=" + favch + "&r=3", true);
        xmlhttp.send();
}
function dropverses(){
	var bk = document.getElementById("booke").value;
	var ch = document.getElementById("chapterz").value;
	var vs = document.getElementById("ves").value;
	
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("versetext").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "ajax_upload.php?p=" + bk + "&q=" + ch + "&s=" + vs + "&r=4", true);
        xmlhttp.send();
}
function loadtest(){
	var age = document.getElementById("test").value;
	//var favb = document.getElementById("bok").value;
	
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("booke").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "ajax_devotion.php?p=" + age + "&r=2", true);
        xmlhttp.send();
}
function loadchapters(){
	var bk = document.getElementById("booke").value;
	//var favch = document.getElementById("chap").value;
	
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("chapterz").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "ajax_devotion.php?p=" + bk + "&r=3", true);
        xmlhttp.send();
}
function loadverses(){
	var bk = document.getElementById("booke").value;
	var ch = document.getElementById("chapterz").value;
	//var vs = document.getElementById("ves").value;
	
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("versetext").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "ajax_devotion.php?p=" + bk + "&q=" + ch + "&r=4", true);
        xmlhttp.send();
}
function validform(){
    var error="";
 var sname = document.getElementById( "surname" );
 if( sname.length == 0 )
 {
  error = " Surname is required ";
  document.getElementById( "surnamespan" ).innerHTML = error;
  return false;
 }

 var fname = document.getElementById( "first_name" );
 if( fname.length == 0 )
 {
  error = " First name is required ";
  document.getElementById( "namespan" ).innerHTML = error;
  return false;
 }
 
 var fname = document.getElementById( "DOB_d" );
 if( fname.length == 0 )
 {
  error = " Date of birth is required ";
  document.getElementById( "namespan" ).innerHTML = error;
  return false;
 }
 
 var fname = document.getElementById( "DOB_m" );
 if( fname.length == 0 )
 {
  error = " Month of birth is required ";
  document.getElementById( "namespan" ).innerHTML = error;
  return false;
 }
 
 var fname = document.getElementById( "phone" );
 if( fname.length == 0 )
 {
  error = " Phone number is required ";
  document.getElementById( "namespan" ).innerHTML = error;
  return false;
 }
 var fname = document.getElementById( "sex" );
 if( fname.length == 0 )
 {
  error = " Gender is required ";
  document.getElementById( "namespan" ).innerHTML = error;
  return false;
 }
 var email = document.getElementById( "email" );
 if( email.length == 0 || email.value.indexOf( "@" ) == -1 )
 {
  error = " Valid Email Address is required. ";
  document.getElementById( "error_para" ).innerHTML = error;
  return false;
 }
 else{
    return true;
 }
}