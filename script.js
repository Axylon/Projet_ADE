function selectAjout(){
    hideAll1();
    var x = document.getElementById("selectAjout").value;
    document.getElementById(x).style.display="block";
}

/*function selectAffiche(){
    hideAll2();
    var x = document.getElementById("selectAffiche").value;
    console.log(x);
    document.getElementById(x).style.display="block";
}*/

function hideAll1(){
    document.getElementById("promotion").style.display="none";
    document.getElementById("user").style.display="none";
    document.getElementById("matiere").style.display="none";
    document.getElementById("salle").style.display="none";
    document.getElementById("crenaux").style.display="none";
}

function hideAll2(){
    document.getElementById("affiche_cours").style.display="none";
}

function semaineX(){
    var x = document.getElementById("semaineX").value;
    return x;
}