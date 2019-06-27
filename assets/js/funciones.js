ajaxdir='/cpiia-tap/ajax/';

// Muestra el listado de territorios existentes asociados a un tipo de lista
function showTerritoriosTipoLst(idTipoLst, publica) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("auxTerritTipoLst").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET",ajaxdir+"territoriosTipoLst.php?idTipoLst="+idTipoLst+"&pub="+publica,true);
  xmlhttp.send();
}

// Muestra los campos "Público" y "Territorios" en la creación y modificación de listas
function showPublicoTerritoriosXTipoLst(grupo) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("auxPubTerritXGrupo").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET",ajaxdir+"publicaTerritoriosXGrupo.php?grupo="+grupo,true);
  xmlhttp.send();
}