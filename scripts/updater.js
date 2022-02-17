function countwords(str) {
    if (str.length != 0) {
        document.getElementById("wordcount").innerHTML = "No of characters: " + str.length;
        return;
    } else{
        document.getElementById("wordcount").innerHTML = '';
    }
}

//
//var acc = document.getElementsByClassName("accordion");
//var i;
//
//for (i = 0; i < acc.length; i++) {
//  acc[i].onclick = function() {
//    this.classList.toggle("active");
//    var panel = this.nextElementSibling;
//    if (panel.style.maxHeight){
//      panel.style.maxHeight = null;
//    } else {
//      panel.style.maxHeight = panel.scrollHeight + "px";
//    } 
//  }
//}