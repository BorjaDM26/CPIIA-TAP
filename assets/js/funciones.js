
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

// Actualiza al instante el tutelador en la vista de modificación de proyectos
function actualizarTutelador(IdTutelador, IdProyecto, IdEncargado) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  var params = "tutelador="+IdTutelador+"&proyecto="+IdProyecto+"&encargado="+IdEncargado;
  xmlhttp.open('POST', 'procesarActualizarTutelador.php', true);

  //Send the proper header information along with the request
  xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          alert(xmlhttp.responseText);
      }
  }
  xmlhttp.send(params);
}

function actualizarEstadoServicio(Estado, IdProyecto, IdEncargado) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  var params = "estado="+Estado+"&proyecto="+IdProyecto+"&encargado="+IdEncargado;
  xmlhttp.open('POST', 'procesarActualizarEstadoServicio.php', true);

  //Send the proper header information along with the request
  xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          alert(xmlhttp.responseText);
          window.location.href="AdminProyectoModificar.php?idProyecto="+IdProyecto;
      }
  }
  xmlhttp.send(params);
}