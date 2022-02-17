function loadbooks() {
    
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("bookspan").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "bookloader.php" , true);
        xmlhttp.send();
    
}
function JesusChrist_ig() {
    
       var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("bookspan").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "bookloader.php" , true);
        xmlhttp.send();
    
}
function bookpane(){
    document.getElementById('id03').style.display='block';
}

function viewbook(){
    document.getElementById('id03').style.display='none';
}

function loadcommentary(){
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("commentaryspan").innerHTML = xmlhttp.responseText;
            }
        };
        var str = document.getElementById("topic_id").value;
        xmlhttp.open("GET", "commentaryhelp.php?p=" + str, true);
        xmlhttp.send();
}
function loadNewsDetails(){
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("commentaryspan").innerHTML = xmlhttp.responseText;
            }
        };
        var str = document.getElementById("topics").value;
        var a = document.getElementById("a").value;
        xmlhttp.open("GET", "newshelper.php?p=" + str + "&q=" + a, true);
        xmlhttp.send();
        loadingcomments();
        var y = document.getElementById('myDIV');
        y.style.display = 'none';
        var x = document.getElementById('resp');
        x.style.display = 'block';
}
function loadingcomments(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("respondspan").innerHTML = xmlhttp.responseText;
            }
        };
        var str = document.getElementById("topics").value;
        var a = document.getElementById("a").value;
        xmlhttp.open("GET", "newsresponse.php?p=" + str + "&q=" + a + "&r=1", true);
        xmlhttp.send();
}

function sendresponse(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("respondspan").innerHTML = xmlhttp.responseText;
            }
        };
        var str = document.getElementById("topics").value;
        var a = document.getElementById("a").value;
        var text = document.getElementById("comment").value;
        var pers = document.getElementById("userid").value;
        xmlhttp.open("GET", "newsresponse.php?p=" + str + "&q=" + a + "&r=2&s=" + text + "&t=" + pers, true);
        xmlhttp.send();
        $("#form")[0].reset(); 
}
function advise(){
    var current = document.getElementById('comment').value;
    if(current.length!==0)
        document.getElementById('success').innerHTML = 'Please, ensure that your contributions are engrafted in the Word and spirit-filled!';
    else
        document.getElementById('success').innerHTML = "";
}
function loadforward(){
        var xmlhttp = new XMLHttpRequest();
        var str = document.getElementById('topics').value;
        var str2 = document.getElementById('chaps').value;
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                if(str==5 && str2>=7)
                document.getElementById("commentaryspan").innerHTML = xmlhttp.responseText;
                else if(str==5)
                document.getElementById("chaps").innerHTML = xmlhttp.responseText;
                
                else
                document.getElementById("commentaryspan").innerHTML = xmlhttp.responseText;
            }
        };
        if(str==5 && str2>=7) str= str2;
        xmlhttp.open("GET", "synopsishelp.php?p=" + str, true);
        xmlhttp.send();
}
