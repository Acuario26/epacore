var datosPagoArray = ''
var Informes='';
var UsuarioGlpi='';
var Arreglochecklist='';
var ProblemasEquipos='';
var checklistProblemas ='';
var ini='N';
var ArreglochecklistlsProblemas='';
var take=1;
var ArregloCargos='';
var ArregloAreas='';
var cimagen=0;
$(document).ready(function () {
    $(function () {
        $("#Modalagregar").hide();
        $("body").addClass("sidebar-collapse");
       cargarInformes();
       cargarUsuarioGlpi();
       cargarProblemasEquipos('N');
       cargarCargos();
       cargarAreas();
       BuscarFechaD();
    });
});
$("#anadirElementoAnexo").on('click',function(){
   // alert("data");
    $("#divAnexo").append('<div class="col-lg-6">');
    $("#divAnexo").append('<i>');
    $("#divAnexo").append('</div>');
});

function cargarCargos()
{
    var data= new FormData();
    var objApiRest = new AJAXRestFilePOST('/getCargos',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            ArregloCargos=_resultContent.message;
            $.each(ArregloCargos, function (_key, _value) {
                $("[name='cargos']").append('<option value="'+_value.descripcion+ '">'+_value.descripcion+'</option>')
            }); 
        } 
        else
        {
            alertToast("Error al cargar Cargos , Recargue la Página o Comuniquese con el administrador".indexOf,3000);
        }
    });
}
function cargarAreas()
{
    var data= new FormData();
    var objApiRest = new AJAXRestFilePOST('/getAreas',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            ArregloAreas=_resultContent.message;
            $.each(ArregloAreas, function (_key, _value) {
                $("select[name='areas']").append('<option value="'+_value.descripcion+ '">'+_value.descripcion+'</option>')
                //$("#areas").append('<option value="'+_value.descripcion+ '">'+_value.descripcion+'</option>')
           }); 
        } 
        else
        {
            alertToast("Error al cargar Areas , Recargue la Página o Comuniquese con el administrador",3000);
        }
    });
}
$("#cargoElaborado,#areaElaborado"+
 ",#cargoRevisado,#areaRevisado"+
 ",#cargoAprobado,#areaAprobado"+
 ",#cargoRecibido,#areaRecibido"+
 "").on('change',function(){
   var cargoElaborado=$("#cargoElaborado").val()!=""?$("#cargoElaborado").val():"";
   var areaElaborado= $("#areaElaborado").val()!=""?$("#areaElaborado").val():"";

   var cargoRevisado= $("#cargoRevisado").val()!=""?$("#cargoRevisado").val():"";
   var areaRevisado= $("#areaRevisado").val()!=""?$("#areaRevisado").val():"";

   var cargoAprobado= $("#cargoAprobado").val()!=""?$("#cargoAprobado").val():"";
   var areaAprobado= $("#areaAprobado").val()!=""?$("#areaAprobado").val():"";

   var cargoRecibido= $("#cargoRecibido").val()!=""? $("#cargoRecibido").val():"";
   var areaRecibido= $("#areaRecibido").val()!=""?$("#areaRecibido").val():"";
   var delaR="";
   var delaRe="";
   var delaA="";
   var delaE="";
       if(cargoRecibido!=""&&areaRecibido!="")
         delaR=" de la ";
       if(cargoAprobado!=""&&areaAprobado!="")
          delaA=" de la ";
       if(cargoRevisado!=""&&areaRevisado!="")
         delaRe=" de la ";
       if(cargoElaborado!=""&&areaElaborado!="")
         delaE=" de la ";
   var usuariorecibidocargo="CARGO="+cargoRecibido+delaR+"AREA="+areaRecibido;
   var usuarioaprobadocargo="CARGO="+cargoAprobado+delaA+"AREA="+areaAprobado;
   var usuariorevisadocargo="CARGO="+cargoRevisado+delaRe+"AREA="+areaRevisado; 
   var usuarioelaboradocargo="CARGO="+cargoElaborado+delaE+"AREA="+areaElaborado;
    
   $("#usuariorecibidocargo").val(usuariorecibidocargo);
   $("#usuarioaprobadocargo").val(usuarioaprobadocargo);
   $("#usuariorevisadocargo").val(usuariorevisadocargo);
   $("#usuarioelaboradocargo").val(usuarioelaboradocargo);

});   
function grabaitem(tipo)
{
    var data= new FormData();
    var descripcion=$("#agregaitem"+tipo+"").val();
    var tipodispositivo=tipo;

    if(descripcion==null||descripcion=="")
    {
        alertToast("Debe Escribir el nombre del problema para grabar",3500);
        return false;
    }
    data.append('descripcion',descripcion);
    data.append('tipoDispositivo',tipodispositivo);
    var objApiRest = new AJAXRestFilePOST('/informe/agregaProblemas',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message,3500);
            cargarProblemasEquipos('S');
             $("#agregaitem"+tipo+"").val('');
        } else{
            alertToast(_resultContent.message,3500);
        }
    });
}
function borraritem(id)
{
    var data= new FormData();
    data.append('id',id);

    var objApiRest = new AJAXRestFilePOST('/informe/borrarProblemas',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            cargarProblemasEquipos('S');
            alertToastSuccess(_resultContent.message,3500);
        }else{
            alertToast(_resultContent.message,3500);
        }

    });
}
function cargarProblemasEquipos(borrar)
{
    if(borrar!='N'){
        $("#checklistPerifericos").html('');
        $("#checklistmouse").html('');
        $("#checklistmonitor").html('');
        $("#checklistcomputador").html('');
        $("#checklistdispositivos").html('');
        $("#checklistimpresora").html('');

    }
    var data= new FormData();
    var objApiRest = new AJAXRestFilePOST('/informe/getCargarProblemasEquipos',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            ProblemasEquipos=_resultContent.message;
            $.each(ProblemasEquipos, function (_key, _value) {
                var html='';
                html+="<li class='list-group-item' style='padding:8px!important'>";
                html+="<i class='glyphicon glyphicon-trash btn btn-xs btn-danger' onclick='borraritem("+_value.id+")'></i>&nbsp;";
                html+="<span>"+_value.descripcion.toUpperCase()+"</span>";
                html+="<label class='switch'>";
                html+="<input type='checkbox' class='primary c' value='"+_value.id+"' name='checklistProblemas[]' onclick='getProblemas()'";
                checked=">";
                if(checklistProblemas!=''&&checklistProblemas!=null)
                {
                     checked=checklistProblemas.includes(_value.id)?"checked>":">";
                }
                html+=checked;
                html+="<span class='slider round'></span></label></li>";
                $("#nohayregistroProblemas"+_value.tipoDispositivo+"").addClass('hidden');
                $("#checklist"+_value.tipoDispositivo+"").append(html);
            });
        }
        else
        {
            alertToast("Error al cargar Listado de Problemas , Recargue la Página o Comuniquese con el administrador",3000);
        }
    });
}

function cargarProblemasEquiposAbrir(borrar){
    if(borrar!='N'){
        $("#checklistPerifericos").html('');
        $("#checklistmouse").html('');
        $("#checklistmonitor").html('');
        $("#checklistcomputador").html('');
        $("#checklistdispositivos").html('');
        $("#checklistimpresora").html('');

    }
            $.each(ProblemasEquipos, function (_key, _value) {
                var html='';
                html+="<li class='list-group-item' style='padding:8px!important'>";
                html+="<i class='glyphicon glyphicon-trash btn btn-xs btn-danger' onclick='borraritem("+_value.id+")'></i>&nbsp;";
                html+="<span>"+_value.descripcion.toUpperCase()+"</span>";
                html+="<label class='switch'>";
                html+="<input type='checkbox' class='primary c' value='"+_value.id+"' name='checklistProblemas[]' onclick='getProblemas()'";
                checked=">";
                if(checklistProblemas!=''&&checklistProblemas!=null)
                {
                     checked=checklistProblemas.includes(_value.id)?"checked>":">";
                }
                html+=checked;
                html+="<span class='slider round'></span></label></li>";
                $("#nohayregistroProblemas"+_value.tipoDispositivo+"").addClass('hidden');
                $("#checklist"+_value.tipoDispositivo+"").append(html);
            });
  
}
function getProblemas(){
    var arr = $('[name="checklistProblemas[]"]:checked').map(function(){
        return this.value;
      }).get();
      checklistProblemas= arr.join(',');  
}
function imagenArreglo(c){
    var index = archivo.indexOf(c.toString());
    if (index > -1) {
        archivo.splice(index, 1);
     }
   $("#ImagenAgregada"+c+"").html('');
    alertToast("Eliminado Exitoso",3000);
}
function getRedefine(redefine){
    
    redefine=redefine.replace('button data-dz-remove="" class="btn btn-danger delete btn-xs"','button data-dz-remove="" class="btn btn-danger delete btn-xs"onclick="imagenArreglo('+cimagen+')"');
    redefine=redefine.replace('<button data-dz-remove="" class="btn btn-warning cancel btn-xs">','<button data-dz-remove="" class="btn btn-warning cancel btn-xs hidden">');      
    redefine=redefine.replace('img data-dz-thumbnail=""','img data-dz-thumbnail="" name="imagen['+cimagen+']"');
    redefine=redefine.replace('<select name="tamano[]">','<strong>SLUG:</strong><span style="font-size:14px"name="textslug['+cimagen+']"></span><br/><select name="tamano['+cimagen+']">');
    redefine=redefine.replace('input type="text" value="" class="form-control" placeholder="slug"','input type="text" value="" onkeyup="cargar(this)" class="form-control" placeholder="slug" name="slug['+cimagen+']"'); 

    return redefine;
}
function cargar(e){
   var v=e.name;
   $("[name='"+'text'+v+"']").text($("[name='"+v+"']").val().toUpperCase());
}
function cargarInformes()
{
    var data= new FormData();
    var objApiRest = new AJAXRestFilePOST('/informe/getInformes',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            Informes=_resultContent.message;
        } else
        {
            alertToast("Error al cargar Informes , Recargue la Página o Comuniquese con el administrador",3000);
        }
    });
}
function cargarUsuarioGlpi()
{
    var data= new FormData();
    var usuarioGlpiCombo=[];
    var usuarioGlpiComboE=[];
    var usuarioGlpiComboR=[];
    var usuarioGlpiComboA=[];
    var usuarioGlpiComboRE=[];
    var objApiRest = new AJAXRestFilePOST('/informe/getUserGlpi',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            UsuarioGlpi=_resultContent.message;
            $.each(UsuarioGlpi, function (_key, _value) {
                var t=usuarioGlpiCombo.indexOf(_value.idUsuario);
                if(t<0){
                    usuarioGlpiCombo.push(_value.idUsuario);
                    $("#usuario").append('<option value="'+_value.idUsuario+ '">'+_value.name+'</option>')
                }
            });
            $.each(UsuarioGlpi, function (_key, _value) {
                var t=usuarioGlpiComboA.indexOf(_value.idUsuario);
                if(t<0){
                    usuarioGlpiComboA.push(_value.idUsuario);
                    $("#usuarioaprobado").append('<option value="'+_value.nameauth+ '">'+_value.name+'</option>')
                }
            });
            $.each(UsuarioGlpi, function (_key, _value) {
                var t=usuarioGlpiComboRE.indexOf(_value.idUsuario);
                if(t<0){
                    usuarioGlpiComboRE.push(_value.idUsuario);
                    $("#usuariorecibido").append('<option value="'+_value.nameauth+ '">'+_value.name+'</option>')
                }
            });
            $.each(UsuarioGlpi, function (_key, _value) {
                var t=usuarioGlpiComboR.indexOf(_value.idUsuario);
                if(t<0){
                    usuarioGlpiComboR.push(_value.idUsuario);
                    $("#usuariorevisado").append('<option value="'+_value.nameauth+ '">'+_value.name+'</option>')
                }
            });
            $.each(UsuarioGlpi, function (_key, _value) {
                var t=usuarioGlpiComboE.indexOf(_value.idUsuario);
                if(t<0){
                    usuarioGlpiComboE.push(_value.idUsuario);
                    $("#usuarioelaborado").append('<option value="'+_value.nameauth+ '">'+_value.name+'</option>')
                }
            });
        } else
        {
            alertToast("Error al cargar Usuarios del GLPI , Recargue la Página o Comuniquese con el administrador",3000);
        }
    });
}
function getBienes(value,card){    
    var arr = $('[name="checklist[]"]:checked').map(function(){
      return this.value;
    }).get();
    Arreglochecklist= arr.join(','); 
    if(arr!=[])
    {
        var data=ArreglochecklistlsProblemas.indexOf(card+"_"+value) 
        var dataCheck=Arreglochecklist.search(value) 
        if(dataCheck==-1 && data!=-1)
          {
            ArreglochecklistlsProblemas=ArreglochecklistlsProblemas.replace(","+card+"_"+value,"");
            ArreglochecklistlsProblemas=ArreglochecklistlsProblemas.replace(card+"_"+value+",","");
            ArreglochecklistlsProblemas=ArreglochecklistlsProblemas.replace(card+"_"+value,"");
          }  
         if(dataCheck!=-1 && data==-1)
          {

              ArreglochecklistlsProblemas = ArreglochecklistlsProblemas!=""?ArreglochecklistlsProblemas+','+card+"_"+value:card+"_"+value;
          }
    }else{
        ArreglochecklistlsProblemas='';
    }

}
/*
function getProblemasListado(){    
    var arr = $('[name="checklist[]"]:checked').map(function(){
      return this.value;
    }).get();
    ArreglochecklistlsProblemas= arr.join(',');  
}*/
function getInformes(catalogo){
    if(Informes=="")
     return null;
        var data = $.grep(Informes, function (element, index) {
            return element.catalogo == catalogo;
        });
      return data=data[0];
}

function getUserGlpi(id){
if(UsuarioGlpi=="")
     return null;
    var data = $.grep(UsuarioGlpi, function (element, index) {
         return element.idUsuario == id;
    });
      return data;
}   

function eliminarcheck(){
    $("input[type=checkbox]").prop('checked', false);
}

$("#tabdatostecnicos,#tabdatoselaboracion").on('click',function(){
    
    $("#cardComputador").addClass("hidden");
    $("#cardMonitor").addClass("hidden");
    $("#cardPeriferico").addClass("hidden");
    $("#cardImpresora").addClass("hidden");

     var cardComputador= ArreglochecklistlsProblemas.includes("cardComputador")?$("#cardComputador").removeClass("hidden"):"";
     var cardMonitor= ArreglochecklistlsProblemas.includes("cardMonitor")?$("#cardMonitor").removeClass("hidden"):"";
     var cardPeriferico= ArreglochecklistlsProblemas.includes("cardPeriferico")?$("#cardPeriferico").removeClass("hidden"):"";
     var cardImpresora= ArreglochecklistlsProblemas.includes("cardImpresora")?$("#cardImpresora").removeClass("hidden"):"";

    $("#contentTab2").addClass("hidden");
    $("#contentTab3").addClass("hidden");
    $("#contentMensajeTab2").addClass("hidden");
    $("#contentMensajeTab3").addClass("hidden");
    if(Arreglochecklist=='' || Arreglochecklist==null)
    {
        $("#contentMensajeTab2").removeClass("hidden");
        $("#contentMensajeTab3").removeClass("hidden");

    }else{
        $("#contentTab2").removeClass("hidden");
        $("#contentTab3").removeClass("hidden");
    }
     

});
$("#usuario").on('change',function(){
   if(ini!='S'||take==2){
        Arreglochecklist='';
        ArreglochecklistlsProblemas='';
        checklistProblemas='';
        cargarProblemasEquiposAbrir('S');
   }

    $("#checklistUsuario").html('');
    var UsuarioGlpiData=getUserGlpi($(this).val());
    if(UsuarioGlpiData!=null){
        $.each(UsuarioGlpiData, function (_key, _value) {
            var Equipo=_value.Equipo!=null&_value.Equipo!=""?_value.Equipo:"";
            var Serial=_value.Serial!=null&_value.Serial!=""?_value.Serial:"";
            var Modelo=_value.Modelo!=null&_value.Modelo!=""?_value.Modelo:"";
            var Tipo=_value.Tipo!=null&_value.Tipo!=""?_value.Tipo:"";
            var Card=_value.card!=null&_value.card!=""?_value.card:"";
            
            var html='';
            html+="<li class='list-group-item'>"+Equipo+"&nbsp;<span style='font-weight:bold'>"+Modelo+" "+Tipo+"</span>";
            html+="<br/><span style='font-weight:bold;font-size:12px'>Serie:("+Serial+")</span><label class='switch'>";
            
            html+="<input type='checkbox' class='primary c' value='"+_value.idEquipo+"' name='checklist[]' onclick='getBienes(\"" + _value.idEquipo + "\",\"" + Card + "\")' ";
            checked=">";
            if(Arreglochecklist!='' && Arreglochecklist!=null)
            {
                    var d=Arreglochecklist.indexOf(',');
                    var e=[];
                        if(d!=-1)
                            e=Arreglochecklist.split(',');
                        else
                            e[0]=Arreglochecklist;

                            checked=e.indexOf(_value.idEquipo.toString())!=-1?"checked>":">";
            }
            html+=checked;
            html+="<span class='slider round'></span></label></li>";
            $("#checklistUsuario").append(html);
        });
    }else{
        alertToast("El usuario no tiene bienes asignados",3500);
        modal.style.display = "none";
    }
    
});

function removeItemFromArr(arr,item ) {
    var i = arr.indexOf(item);
 
    if ( i !== -1 ) {
        checklistProblemas=arr.substr(i+1,item.length+1);  
    }
}
$("#anexosd").on('click',function(){
     
    var divName="cargaAnexos";
    var ficha=document.getElementById(divName);
    var ventimp=window.open(' ','popimpr');
    ventimp.document.write(ficha.innerHTML);
   ventimp.document.close();
    ventimp.print();
    ventimp.close();
  
});
    
function imprimirDiv(id) {
    var data = $.grep(datosPagoArray, function (element, index) {
        return element.id == id;
    });
    data=data[0];
    var informe=getInformes('T');
        informe=informe['Html'];
        if(informe!=null && data!=null)
        {
            var obj=data['objetivos']!=null?data['objetivos']:'';
            var conc=data['conclusiones']!=null?data['conclusiones']:'';
            var rec=data['recomendaciones']!=null?data['recomendaciones']:'';
            var ant=data['antecedentes']!=null?data['antecedentes']:'';
            var acciones=data['acciones']!=null?data['acciones']:'';
            $("#cargaAnexos").html(data['anexos']);
            //datos=datos.replace(/Ã/g, '&iacute;');
            obj=obj.replace(/<p>/g, '<p style="text-align:justify">');
            conc=conc.replace(/<p>/g, '<p style="text-align:justify">');
            rec=rec.replace(/<p>/g, '<p style="text-align:justify">');
            ant=ant.replace(/<p>/g, '<p style="text-align:justify">');

            informe=informe.replace("#FECHA",data['created_at']!=null?data['created_at'].substring(0,10):'');
            informe=informe.replace("#ANTECEDENTES",ant);
            informe=informe.replace("#ASUNTO",data['asunto']!=null?data['asunto']:'');
            informe=informe.replace("#OBJETIVO",obj);
            informe=informe.replace("#ACCIONES",acciones);
            informe=informe.replace("#CONCLUSIONES",conc);
            informe=informe.replace("#RECOMENDACIONES",rec);
            informe=informe.replace("#TABLAEQUIPOS",data['tablaEquipos']!=null?data['tablaEquipos']:'');
            informe=informe.replace("#CHECKLIST",data['tablaProblemas']!=null?data['tablaProblemas']:'');
            informe=informe.replace("#PIEDEELABORACION",data['tablaPiePaginas']!=null?data['tablaPiePaginas']:'');
            

            informe=informe.replace("#ID",id);
            $("#imprimirContenido").html('');
            $("#imprimirContenido").append(informe);
            modalPrint.style.display = "block";

        }else{
            alertToast('NO EXISTE INFORME RELACIONADO',3500);
        }
       
}
$("#printDiv").on("click",function()
{ 
   
    var divName="imprimirContenido";
    var ficha=document.getElementById(divName);
    var ventimp=window.open(' ','popimpr');
    ventimp.document.write(ficha.innerHTML);
    ventimp.document.close();
    ventimp.print();
    ventimp.close()
} 

);
function getTablaAnexos()
{
    var html='';
    var conteo=0;
    html+= '<table>';
    html+= '<tr height=20 style="mso-height-source:userset;height:15.0pt">';
    html+= '<td colspan=8 height=20 class=xl676521 style="height:15.0pt">7. Anexos</td>';
    html+= '</tr>';
    html+=  '</table>';
    if(archivo!=[])
    {
        archivo.forEach( function(valor, indice, array) {
            conteo=conteo+1;
            var tamano=$("[name='tamano["+valor+"]']").val();
            var imagen=$("[name='imagen["+valor+"]']").attr('src');
            var slug= $("[name='textslug["+valor+"]']").text();
            html+='<table width="100%">';
            var imagenConteo='Imagen:'+conteo+'';
            switch(tamano){
                case 'Derecha':
                        html+= '<tr width="100%" height="50%">';
                        html+=  '<td colspan="1" width="50%"><center>&nbsp;</center></td>';
                        html+=  '<td colspan="2" width="50%"><center><img src="'+imagen+'"width="350px" height="400px"></center></td>';
                        html+=  '</tr>';
                        html+= '<tr width="100%" height="50%">';
                        html+=  '<td width="50%"><i style="font-size:12px">&nbsp;</i></td>';
                        html+=  '<td width="25%"><i style="font-size:12px">'+slug.toUpperCase()+'</i></td>';
                        html+=  '<td width="25%"><i style="font-size:12px">'+imagenConteo.toUpperCase()+'</i></td>';
                        html+=  '</tr>';
                     break;
                case 'Izquierda':
                        html+= '<tr width="100%" height="50%">';
                        html+=  '<td colspan="1" width="50%"><center><img src="'+imagen+'"width="350px" height="400px"></center></td>';
                        html+=  '<td colspan="1" width="50%"><center>&nbsp;</center></td>';
                        html+=  '</tr>';
                        html+= '<tr width="100%" height="50%">';
                        html+=  '<td width="25%"><i style="font-size:12px">'+slug.toUpperCase()+'</i></td>';
                        html+=  '<td width="25%"><i style="font-size:12px">'+imagenConteo.toUpperCase()+'</i></td>';
                        html+=  '<td width="50%"><i style="font-size:12px">&nbsp;</i></td>';
                        html+=  '</tr>';
                     break;
                case 'Mitad':
                        html+= '<tr width="100%" height="50%">';
                        html+=  '<td colspan="2"><center><img src="'+imagen+'" width="800px" height="500px"></center></td>';
                        html+=  '</tr>';
                        html+= '<tr width="100%" height="50%">';
                        html+=  '<td width="50%"><i style="font-size:12px">'+slug.toUpperCase()+'</i></td>';
                        html+=  '<td width="50%"><i style="font-size:12px">'+imagenConteo.toUpperCase()+'</i></td>';
                        html+=  '</tr>';
                     break;
                case 'Completa':
                        html+= '<tr width="100%" height="100%">';
                        html+=  '<td colspan="2" height="100%"><center><img src="'+imagen+'" width="800px" height="100%"></center></td>';
                        html+=  '</tr>';
                        html+= '<tr width="100%" height="50%">';
                        html+=  '<td width="50%"><i style="font-size:12px">'+slug.toUpperCase()+'</i></td>';
                        html+=  '<td width="50%"><i style="font-size:12px">'+imagenConteo.toUpperCase()+'</i></td>';
                        html+=  '</tr>';
                     break;
            }
            html+='</table>';

            
        });
    }
    return html;
}


function getTablaProblemas(problemas)
{
    html='<p style="line-height:3">';
    html+='El equipo recibido tiene las siguientes caracter&iacute;sticas';
    html+='</p>';
    html+='<table style="width:100%" border=1>';
    html+='<tr>';
    html+='<td width="80%"><span style="font-weight:bold;text-align:center">DESCRIPCI&Oacute;N</span>';
    html+='</td>';
    html+='<td width="20%"><span style="font-weight:bold;text-align:center">CHECKLIST</span>';
    html+='</td>';
    html+='</tr>';
    $.each(ProblemasEquipos, function (_key, _value) { 
        var t=problemas.indexOf(_value.id);
        if(t>-1)
        {
            html+='<tr>';

            html+='<td width="80%">'+_value.descripcion.toUpperCase()+'';
            html+='</td>';
            html+='<td width="20%">&#x2714;';
            html+='</td>';

            html+='</tr>';
        }
    });
    html+='</table>';
    return html;
}
function getTablaPiePaginas(usuarioelaborado,
usuariorecibido,
usuariorevisado,
usuarioaprobado,
usuarioelaboradocargo,
usuariorecibidocargo,
usuariorevisadocargo,
usuarioaprobadocargo,
){

    
    usuarioaprobadocargo=usuarioaprobadocargo.replace("AREA=","");
    usuariorevisadocargo=usuariorevisadocargo.replace("AREA=","");
    usuariorecibidocargo=usuariorecibidocargo.replace("AREA=","");
    usuarioelaboradocargo=usuarioelaboradocargo.replace("AREA=","");
    
    usuarioaprobadocargo=usuarioaprobadocargo.replace("CARGO=","");
    usuariorevisadocargo=usuariorevisadocargo.replace("CARGO=","");
    usuariorecibidocargo=usuariorecibidocargo.replace("CARGO=","");
    usuarioelaboradocargo=usuarioelaboradocargo.replace("CARGO=","");

    var html='';
    if(
                !(usuarioelaborado==null || usuarioelaboradocargo=="")||
                !(usuariorevisado==null || usuariorevisadocargo=="")||
                !(usuariorecibido==null || usuariorecibidocargo=="")||
                !(usuarioaprobado==null || usuarioaprobadocargo=="")
       )
    {
        html+='<table style="width:100%" border=1>';
        html+='<tr>';
        html+='<td width="25%"><span style="font-weight:bold;">Acci&oacute;n</span>';
        html+='</td>';
        html+='<td  width="25%"><span style="font-weight:bold;">Nombre</span>';
        html+='</td>';
        html+='<td  width="30%"><span style="font-weight:bold;">Cargo</span>';
        html+='</td>';
        html+='<td  width="20%"><span style="font-weight:bold;">Firma</span>';
        html+='</td>';
        html+='</tr>';
    }
    if(usuarioelaborado!=null && usuarioelaboradocargo!="")
    {
        html+='<tr>';
        html+='<td><span style="font-weight:bold;">Elaborado por:</span>';
        html+='</td><td>';
        html+='<span style="font-weight:normal;">'+usuarioelaborado!=null?usuarioelaborado:""+'</span>';
        html+='</td><td>';
        html+='<span style="font-weight:normal;">'+usuarioelaboradocargo!=null?usuarioelaboradocargo:""+'</span>';
        html+='</td>';
        html+='<td><span style="font-weight:normal;">&nbsp;</span>';
        html+='</td>';
        html+='</tr>';
    }
    if(usuariorevisado!=null && usuariorevisadocargo!="")
    {
        html+='<tr>';
        html+='<td><span style="font-weight:bold;">Revisado por:</span>';
        html+='</td><td>';
        html+='<span style="font-weight:normal;">'+usuariorevisado!=null?usuariorevisado:""+'</span>';
        html+='</td><td>';
        html+='<span style="font-weight:normal;">'+usuariorevisadocargo!=null?usuariorevisadocargo:""+'</span>';
        html+='</td><td>';
        html+='<span style="font-weight:normal;">&nbsp;</span>';
        html+='</td>';
        html+='</tr>';
    }
    if(usuarioaprobado!=null && usuarioaprobadocargo!="")
    {
        html+='<tr>';
        html+='<td><span style="font-weight:bold;">Aprobado por:</span>';
        html+='</td><td>';
        html+='<span style="font-weight:normal;">'+usuarioaprobado!=null?usuarioaprobado:""+'</span>';
        html+='</td><td>';
        html+='<span style="font-weight:normal;">'+usuarioaprobadocargo!=null?usuarioaprobadocargo:""+'</span>';
        html+='</td><td>';
        html+='<span style="font-weight:normal;">&nbsp;</span>';
        html+='</td>';
        html+='</tr>';
    }
    if(usuariorecibido!=null && usuariorecibidocargo!="")
    {
        html+='<tr>';
        html+='<td><span style="font-weight:bold;">Recibido por:</span>';
        html+='</td><td>';
        html+='<span style="font-weight:normal;">'+usuariorecibido!=null?usuariorecibido:""+'</span>';
        html+='</td><td>';
        html+='<span style="font-weight:normal;">'+usuariorecibidocargo!=null?usuariorecibidocargo:""+'</span>';
        html+='</td>';
        html+='<td><span style="font-weight:normal;">&nbsp;</span>';
        html+='</td>';
        html+='</tr>';
    }

    if(
        !(usuarioelaborado==null || usuarioelaboradocargo=="")&&
        !(usuariorevisado==null || usuariorevisadocargo=="")&&
        !(usuariorecibido==null || usuariorecibidocargo=="")&&
        !(usuarioaprobado==null || usuarioaprobadocargo=="")
    ){

        html+='</table>';
    }
    return html;
}
function getTablaEquipos(usuarioInforme,checklist)
{
    
    var UsuarioGlpiData=getUserGlpi(usuarioInforme);

    html='';
    html+='<table style="width:100%" border=1>';
    html+='<tr>';
    html+='<td><span style="font-weight:bold;">Custodio</span>';
    html+='</td>';
    html+='<td><span style="font-weight:bold;">Equipo</span>';
    html+='</td>';
    html+='<td><span style="font-weight:bold;">Serial</span>';
    html+='</td>';
   html+='<td><span style="font-weight:bold;">C&oacute;digo EPA</span>';
    html+='</td>';
    html+='<td><span style="font-weight:bold;">Modelo</span>';
    html+='</td>';
    html+='<td><span style="font-weight:bold;">Tipo</span></td>';
    html+='</tr>';

    $.each(UsuarioGlpiData, function (_key, _value) { 
        var d=checklist.indexOf(',');
        var e=[];
            if(d!=-1)
                e=checklist.split(',');
            else
                e[0]=checklist;                

        var t=e.indexOf(_value.idEquipo.toString());

        if(t>-1)
        {
            html+='<tr><td>';
            html+=''+_value.name!=null?_value.name:'-';
            html+='</td><td>';
          
            html+=''+_value.Equipo!=null?_value.Equipo:'-';
            html+='</td><td>';
         
            html+=''+_value.Serial!=null?_value.Serial:'-';
            html+='</td><td>';
           
            html+=''+_value.OtroSerial!=null?_value.OtroSerial:'-';
            html+='</td><td>';
       
            html+=''+_value.Modelo!=null?_value.Modelo:'-';
            html+='</td><td>';

            html+=''+_value.Tipo!=null?_value.Tipo:'-';
            html+='</td>';

            html+='</tr>';
        }
    });
    html+='</table>';
    return html;
}
$("#btnGuardar").on('click',function(){
   var conteido1= CKEDITOR.instances['objetivos'].updateElement();
    var conteido2= CKEDITOR.instances['recomendaciones'].updateElement();
    var conteido3= CKEDITOR.instances['conclusiones'].updateElement();
    var conteido4= CKEDITOR.instances['antecedentes'].updateElement();
    var conteido5= CKEDITOR.instances['acciones'].updateElement();

    var id=$("#id").val(); 
    var asunto=$("#asunto").val(); 
    var objetivos=$("#objetivos").val(); 
    var recomendaciones=$("#recomendaciones").val(); 
    var conclusiones=$("#conclusiones").val(); 
    var antecedentes=$("#antecedentes").val(); 
    var acciones=$("#acciones").val(); 
    var checklist=Arreglochecklist; 
    
    if(checklist==null || checklist=="")
        {
            alertToast("No puede Grabar sin tener seleccionado un Equipo",3500);
            return false;
        }


    var usuarioInforme=$("#usuario").val(); 
    var tablaEquipos=getTablaEquipos(usuarioInforme,checklist);
    var problemas=checklistProblemas;   
    var tablaProblemas=getTablaProblemas(problemas);
    UsuarioEncargado=$("#usuario option:selected" ).text();

    usuarioelaborado=$("#usuarioelaborado").val();
    usuariorecibido=$("#usuariorecibido").val();
    usuariorevisado=$("#usuariorevisado").val();
    usuarioaprobado=$("#usuarioaprobado").val();
    usuarioelaboradocargo=$("#usuarioelaboradocargo").val();
    usuariorecibidocargo=$("#usuariorecibidocargo").val();
    usuariorevisadocargo=$("#usuariorevisadocargo").val();
    usuarioaprobadocargo=$("#usuarioaprobadocargo").val();


    usuarioelaboradot=$("#usuarioelaborado option:selected" ).text();
    usuariorecibidot=$("#usuariorecibido option:selected" ).text();
    usuariorevisadot=$("#usuariorevisado option:selected" ).text();
    usuarioaprobadot=$("#usuarioaprobado option:selected" ).text();

    var tablaPiePaginas=getTablaPiePaginas(
        usuarioelaboradot=="Seleccione un Usuario"?'':usuarioelaboradot,
        usuariorecibidot=="Seleccione un Usuario"?'':usuariorecibidot,
        usuariorevisadot=="Seleccione un Usuario"?'':usuariorevisadot,
        usuarioaprobadot=="Seleccione un Usuario"?'':usuarioaprobadot,
        usuarioelaboradocargo,
        usuariorecibidocargo,
        usuariorevisadocargo,
        usuarioaprobadocargo,
        );
     var anexosCarga=$("#previews").html();
    anexos=getTablaAnexos();
    //ArreglochecklistlsProblemas = ArreglochecklistlsProblemas; // [foo, blue, 5]
    var data= new FormData();
    data.append('id', id);
    data.append('asunto', asunto);
    data.append('objetivos', objetivos);
    data.append('recomendaciones', recomendaciones);
    data.append('conclusiones', conclusiones);
    data.append('antecedentes', antecedentes);
    data.append('acciones', acciones);
    data.append('checklist', checklist);
    data.append('usuarioInforme', usuarioInforme);
    data.append('UsuarioEncargado', UsuarioEncargado);
    data.append('tablaEquipos', tablaEquipos);
    data.append('problemas', problemas);
    data.append('tablaProblemas', tablaProblemas);
    data.append('usuarioelaborado', usuarioelaborado);
    data.append('usuariorevisado', usuariorevisado);
    data.append('usuariorecibido', usuariorecibido);
    data.append('usuarioaprobado', usuarioaprobado);
    data.append('usuarioelaboradocargo', usuarioelaboradocargo);
    data.append('usuariorevisadocargo', usuariorevisadocargo);
    data.append('usuariorecibidocargo', usuariorecibidocargo);
    data.append('usuarioaprobadocargo', usuarioaprobadocargo);
    data.append('tablaPiePaginas', tablaPiePaginas);
    data.append('categoriasProblemas', ArreglochecklistlsProblemas);
    data.append('anexos',anexos);
    data.append('arregloanexos',archivo);
    data.append('anexosCarga',anexosCarga);

    
    var objApiRest = new AJAXRestFilePOST('/informe/saveInforme',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message,3500);
            Arreglochecklist='';
            checklistProblemas='';
            ArreglochecklistlsProblemas='';
            $("#btnCancelar").click();
            $("#previews").html('');
            archivo=[];
            BuscarFechaD();
        } else {
            alertToast(_resultContent.message,3500);

        }
    });


});

$(".cerrarmodalPrint").on("click",function(){
    $("#imprimirConteido").val('');
    $('body').attr('style','overflow-y: auto!important;');
    modalPrint.style.display = "none";
});
 


function limpiar() {
    take=1;
    $('body').attr('style','overflow-y: hidden!important;');
    modal.style.display = "block";
    eliminarcheck();
    Arreglochecklist='';
    checklistProblemas='';
    ArreglochecklistlsProblemas='';
    CKEDITOR.instances['objetivos'].document.$.activeElement.innerHTML='';
    CKEDITOR.instances['antecedentes'].document.$.activeElement.innerHTML='';
    CKEDITOR.instances['conclusiones'].document.$.activeElement.innerHTML='';
    CKEDITOR.instances['recomendaciones'].document.$.activeElement.innerHTML='';
    CKEDITOR.instances['acciones'].document.$.activeElement.innerHTML='';
    $("#usuario").val('').change();
    $("#asunto").val('');
    $("#checklistUsuario").html('');
    $("#id").val(0);
    $(".form-control").each(function(){	
        $($(this)).val('');
    });
    $("select[name='cargos']").val("").change();
    $("select[name='areas']").val("").change();
    $("#usuarioaprobado").val('').change(); 
    $("#usuariorevisado").val('').change(); 
    $("#usuariorecibido").val('').change(); 
    $("#usuarioelaborado").val('').change(); 
    $("#usuarioaprobadocargo").val('');
    $("#usuariorevisadocargo").val('');
    $("#usuariorecibidocargo").val('');
    $("#usuarioelaboradocargo").val('');
    var d=getAnexoVacio();
    $("#previews").html('');
    //$("#dropzoneFileUpload").html('');
   // $("#dropzoneFileUpload").html(d);

}
function getAnexoVacio(){
    html='<div class="row">';
html+='<div id="content" class="col-lg-12">';
html+='<div class="fallback">';
html+='<input name="file" type="file" multiple />';
html+='</div>';
html+='<div id="actions" class="row">';
html+='<div class="col-lg-7">';
html+='<span class="btn btn-success fileinput-button">';
html+='<i class="glyphicon glyphicon-plus"></i>';
html+='<span>A&ntilde;adir im&aacute;genes...</span>';
html+='</span>';
html+='<button type="submit" class="btn btn-primary start" style="display: none;">';
html+='<i class="glyphicon glyphicon-upload"></i>';
html+='<span>Start upload</span>';
html+='</button>';
html+='<button type="reset" class="btn btn-warning cancel" style="display: none;">';
html+='<i class="glyphicon glyphicon-ban-circle"></i>';
html+='<span>Cancel upload</span>';
html+='</button>';
html+='</div>';
html+='<div class="col-lg-5">';
html+='<span class="fileupload-process">';
html+='<div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">';
html+='<div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>';
html+='</div>';
html+='</span>';
html+=' </div>';
html+='</div>';
html+='<div class="table table-striped files" id="previews">';
html+='<div id="template" class="file-row row">';
html+='<div class="col-xs-12 col-lg-3">';
html+='<span class="preview" style="width:160px;height:160px;">';
html+='<img data-dz-thumbnail style="width:160px;height:160px;"/>';
html+='</span>';
html+='<br/>';
html+='<button class="btn btn-primary start" style="display:none;">';
html+='<i class="glyphicon glyphicon-upload"></i>';
html+='<span>Empezar</span>';
html+='</button>';
html+='<button data-dz-remove class="btn btn-warning cancel btn-xs">';
html+='<i class="icon-ban-circle fa fa-ban-circle"></i>';
html+='<span>Cancelar</span>';
html+='</button>';
html+='<button data-dz-remove class="btn btn-danger delete btn-xs" >';
html+='<i class="icon-trash fa fa-trash"></i>';
html+='<span>Eliminar</span>';
html+='</button>';
html+='</div>';
html+='<div class="col-xs-12 col-lg-9">';
html+='<input type="text" value="" class="form-control" placeholder="slug"><p class="name" data-dz-name></p>';
html+='<p class="size" data-dz-size></p>';
html+='<select name="tamano[]">';
html+='<option value="Izquierda">Izquierda Slot</option>';
html+='<option value="Derecha">Derecha Slot</option>';
html+='<option value="Mitad">Mitad Slot</option>';
html+='<option value="Completa">Completa Slot</option>';
html+=' </select>';
html+='<div>';
html+='<strong class="error text-danger" data-dz-errormessage></strong>';
html+='</div>';
html+='<div>';
html+=' <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">';
html+=' <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>';
html+=' </div>';
html+='</div>';
html+='  </div>';
html+=' </div>';
html+=' </div>';
html+='<div class="dropzone-here">Cargar Archivos.</div>';
html+='</div>';
html+=' </div>';

return html;
}
function BuscarFechaD() {
    var fecha=$("#fechaconsulta").val();
       BuscarFecha();
  }

function BuscarFecha() {
    var fecha=$("#fechaconsulta").val();
    var pantalla=$("#pantalla").val();

    data = new FormData();
    data.append('fecha', fecha);
    data.append('pantalla', pantalla);
    var objApiRest = new AJAXRestFilePOST('/informe/getDatatableFecha', data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            var dt = {
                draw: 1,
                recordsFiltered: _resultContent.datos.length,
                recordsTotal: _resultContent.datos.length,
                data: _resultContent.datos
            };
            datosPagoArray=_resultContent.datos;
            $("#tablaConsulta").attr('style','margin-top:10px');

            $('#tbobymenu').show();
            $.fn.dataTable.ext.errMode = 'throw';
            $("#dtmenu").dataTable({
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend:    'excelHtml5',
                        text:      '<img src="/images/icons/excel.png" width="25px" heigh="20px">',
                        titleAttr: 'Excel'
                    },
                 
                    {
                        extend:    'pdfHtml5',
                        text:      '<img src="/images/icons/pdf.png" width="25px" heigh="20px">',
                        titleAttr: 'PDF',
                        orientation: 'landscape',
                       /* exportOptions: {
                            columns: [0, 1,2,3,4,5,6,7,8,9,10] //exportar solo la primera y segunda columna
                        },*/
                        title:'.',
                        footer: true,
                        pageSize: 'A4',
                        filename:'Epacore-Informes Tecnico',
                        customize: function ( doc ) {
                            doc.content.splice( 1, 0, {
                                margin: [ 0, 0, 0, 12 ],
                                alignment: 'center',
                                image:'data:image/png;base64,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'
                            } );
                        }
                    }
                ],
                "lengthMenu": [[5, -1], [5, "TODOS"]],
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "draw": dt.draw,
                "destroy":true,
                "recordsFiltered": dt.recordsFiltered,
                "recordsTotal": dt.recordsTotal,
                "data": dt.data,
                "order": [[1, "desc"]],

                "columnDefs": [
                    { "targets": [0], "orderable": true }
                ],
                "columns": [
                  
                            {title:'N&deg;',data: 'id', "width": "5%"},
                            {title:'Fecha',data: 'asunto', "width": "10%"
                                ,"render": function (data, type, row) {
                                    var created_at='--';
                                    if(row.created_at!=null)
                                    created_at=row.created_at.substring(0,10);
                                    return '<span style="text-align:justify">'+created_at+'</span>';
                                }
                            },
                            {title:'Asunto',data: 'asunto', "width": "35%"
                                ,"render": function (data, type, row) {
                                    var asunto='--';
                                    if(row.asunto!=null)
                                    asunto=row.asunto;
                                    return '<span style="text-align:justify">'+asunto+'</span>';
                                }
                            },
                            {title:'Revisado',data: 'revisado', "width": "5%",
                            "render": function (data, type, row) {
                                    var asunto=row.revisado;
                                    var d= '<span style="text-align:justify" class="label label-success label-xs">'+asunto+'</span>';
                                    if(asunto=='SI') 
                                    d= '<span style="text-align:justify" class="label label-info label-xs">'+asunto+'</span>';
                                    return d;
                                }
                            },
                            {title:'Aprobado',data: 'aprobado', "width": "5%",
                            "render": function (data, type, row) {
                                    var asunto=row.aprobado;
                                    var d= '<span style="text-align:justify" class="label label-success label-xs">'+asunto+'</span>';
                                    if(asunto=='SI') 
                                    d= '<span style="text-align:justify" class="label label-info label-xs">'+asunto+'</span>';
                                    return d;
                                }
                            },
                            {title:'Usuario/Ingresa', "width": "10%" ,"render": function (data, type, row) {
                                    u=row.usuarioelaborado;
                                    
                                    var data = $.grep(UsuarioGlpi, function (element, index) {
                                        return element.nameauth == u;
                                    });
                                    var name='--';
                                    if(data.length>0){
                                        data=data[0];
                                        name=data['name'];
                                    }
                                    
                                    
                                    
                                    return '<span style="text-align:justify">'+name+'</span>';
                                }
                            },
    
                            {
                                title:'',
                                  data: 'actions',
                                  "width": "5%",
                                  "bSortable": false,
                                  "searchable": false,
                                  "targets": 0,
                                  "render": function (data, type, row) {
                                     var pantalla=$("#pantalla").val();
                                    var html='';
							 if(row.revisado=='NO'||row.aprobado=='NO'){           
							        html+='<a href="#" onclick="Actualizar(\'' + row.id + '\');" id="myBtnEdit"'+ 
                                                               'class="label label-primary">'+'<span class="glyphicon glyphicon-edit"></span></a>';
							 }
                                                         html+='<a href="#" onclick="PedirConfirmacion(\'' + row.id + '\',\'eliminar\');"'+
                                                        'class="label label-danger">'+
                                                        '<span class="glyphicon glyphicon-trash"></span></a>'+
                                                        '<a href="#" onclick="imprimirDiv(\'' + row.id + '\');"'+
                                                        'class="label label-primary">'+
                                                        '<span class="glyphicon glyphicon-print"></span></a>';
                                                        if((row.revisado=='NO'||row.aprobado=='NO')&&pantalla!='crea'){
                                                            html+='<a href="#" onclick="aprobarInforme(\'' + row.id + '\');"'+
                                                            'class="label label-success">'+
                                                            '<span class="fa fa-check"></span></a>';
                                                        }
                                        return html;
                                  }
                              },

                ],
            });

        } else {
            alertToast(_resultContent.message, 3500);
        }
    });
     
}
function aprobarInforme(id)
{
    var objApiRest = new AJAXRest('/informe/aprobarInforme',
    {
        id:id
    }, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            BuscarFechaD();
        } else {
            alertToast(_resultContent.message, 3500);
        }
    });
}

function Actualizar(id)
{
    var usuarioelaboradocargoChange="";
    var usuariorecibidocargoChange="";
    var usuariorevisadocargoChange="";
    var usuarioaprobadocargoChange="";
    
    var usuarioelaboradoAreaChange="";
    var usuariorecibidoAreaChange="";
    var usuariorevisadoAreaChange="";
    var usuarioaprobadoAreaChange="";
    ini='S';
    take=1;
    $('body').attr('style','overflow-y: hidden!important;');

   var data = $.grep(datosPagoArray, function (element, index) {
        return element.id == id;
    });
    data=data[0];
    if(data['revisado']=='SI'&&data['aprobado']=='SI')
        $("#btnGuardar").addClass('hidden');
    else
        $("#btnGuardar").removeClass('hidden');
    CKEDITOR.instances['objetivos'].document.$.activeElement.innerHTML=data['objetivos'];
    CKEDITOR.instances['antecedentes'].document.$.activeElement.innerHTML=data['antecedentes'];
    CKEDITOR.instances['conclusiones'].document.$.activeElement.innerHTML=data['conclusiones'];
    CKEDITOR.instances['recomendaciones'].document.$.activeElement.innerHTML=data['recomendaciones'];
    CKEDITOR.instances['acciones'].document.$.activeElement.innerHTML=data['acciones'];

  //  CKEDITOR.instances['objetivos'].setData(data['objetivos']);
    $("#id").val(data['id']); 
    $("#asunto").val(data['asunto']); 

    Arreglochecklist=data['checklist']!=null?data['checklist']:''; 
    checklistProblemas=data['problemas']!=null?data['problemas']:''; 
    ArreglochecklistlsProblemas=data['categoriasProblemas']!=null?data['categoriasProblemas']:''; 
    
    $("#usuario").val(data['usuarioInforme']).change(); 
    $("#usuarioaprobado").val(data['usuarioaprobado']).change(); 
    $("#usuariorevisado").val(data['usuariorevisado']).change(); 
    $("#usuariorecibido").val(data['usuariorecibido']).change(); 
    $("#usuarioelaborado").val(data['usuarioelaborado']).change(); 

    var usuarioaprobadocargo=data['usuarioaprobadocargo']!=null?data['usuarioaprobadocargo']:'';
    var usuariorevisadocargo=data['usuariorevisadocargo']!=null?data['usuariorevisadocargo']:'';
    var usuariorecibidocargo=data['usuariorecibidocargo']!=null?data['usuariorecibidocargo']:'';
    var usuarioelaboradocargo=data['usuarioelaboradocargo']!=null?data['usuarioelaboradocargo']:'';


    var usuarioaprobadocargoF="";
    var usuariorevisadocargoF="";
    var usuariorecibidocargoF="";
    var usuarioelaboradocargoF="";

    usuarioaprobadocargoF=usuarioaprobadocargo.replace("AREA=","");
    usuariorevisadocargoF=usuariorevisadocargo.replace("AREA=","");
    usuariorecibidocargoF=usuariorecibidocargo.replace("AREA=","");
    usuarioelaboradocargoF=usuarioelaboradocargo.replace("AREA=","");
    
    usuarioaprobadocargoF=usuarioaprobadocargo.replace("CARGO=","");
    usuariorevisadocargoF=usuariorevisadocargo.replace("CARGO=","");
    usuariorecibidocargoF=usuariorecibidocargo.replace("CARGO=","");
    usuarioelaboradocargoF=usuarioelaboradocargo.replace("CARGO=","");

    var usuarioaprobadocargoC=usuarioaprobadocargo.split("AREA=");
    var usuariorevisadocargoC=usuariorevisadocargo.split("AREA=");
    var usuariorecibidocargoC=usuariorecibidocargo.split("AREA=");
    var usuarioelaboradocargoC=usuarioelaboradocargo.split("AREA=");

    
    usuarioelaboradoAreaChange=usuarioelaboradocargoC[1];
    usuariorecibidoAreaChange=usuariorecibidocargoC[1];
    usuariorevisadoAreaChange=usuariorevisadocargoC[1];
    usuarioaprobadoAreaChange=usuarioaprobadocargoC[1];


    usuarioelaboradocargoChange=usuarioelaboradocargoC[0].replace("CARGO=","");
    usuarioelaboradocargoChange=usuarioelaboradocargoChange.replace(" de la ","");

    usuariorecibidocargoChange=usuariorecibidocargoC[0].replace("CARGO=","");
    usuariorecibidocargoChange=usuariorecibidocargoChange.replace(" de la ","");

    usuariorevisadocargoChange=usuariorevisadocargoC[0].replace("CARGO=","");
    usuariorevisadocargoChange=usuariorevisadocargoChange.replace(" de la ","");

    usuarioaprobadocargoChange=usuarioaprobadocargoC[0].replace("CARGO=","");
    usuarioaprobadocargoChange=usuarioaprobadocargoChange.replace(" de la ","");


    $("#cargoElaborado").val(usuarioelaboradocargoChange).change();
    $("#areaElaborado").val(usuarioelaboradoAreaChange).change();

    $("#cargoRevisado").val(usuariorevisadocargoChange).change();
    $("#areaRevisado").val(usuariorevisadoAreaChange).change();
    
    $("#cargoAprobado").val(usuarioaprobadocargoChange).change();
    $("#areaAprobado").val(usuarioaprobadoAreaChange).change();
    
    $("#cargoRecibido").val(usuariorecibidocargoChange).change();
    $("#areaRecibido").val(usuariorecibidoAreaChange).change();
    
    $("#usuarioaprobadocargo").val(usuarioaprobadocargoF);
    $("#usuariorevisadocargo").val(usuariorevisadocargoF);
    $("#usuariorecibidocargo").val(usuariorecibidocargoF);
    $("#usuarioelaboradocargo").val(usuarioelaboradocargoF);
    
    cargarProblemasEquiposAbrir('S');
    modal.style.display = "block";
    take=2;
    html=data['anexosCarga'];
    archivo=data['arregloanexos']!=null?data['arregloanexos'].split(','):[];
    for(i = 0; i < archivo.length; i++){
        if (parseInt(archivo[i]) > cimagen)
        {
            cimagen = parseInt(archivo[i]);
        }
    }

    $("#previews").html('');
    if(archivo==null|| archivo==[] ||archivo.length==0)
         return false;
    $("#previews").html(html);
    $('.dropzone-here').addClass('hidden');
}

function Eliminar(id) {
    var objApiRest = new AJAXRest('/informe/eliminardata',
    {
        id:id
    }, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            BuscarFechaD();
        } else {
            alertToast(_resultContent.message, 3500);
        }
    });

}
function reFresh() {
    location.reload(true)
}
