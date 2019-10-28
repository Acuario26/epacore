var datosPagoArray = ''
var codigosRetencion='';
var identificacionBeneficiarios='';
var tiposContratos='';
var areaSolicitante='';
var ArregloRecurso='';
var ArregloPlantillaPie="E,R";
var ArregloTipoContratoD="";
var datosContratos='';
var nuevoBeneficiario='';
$(document).ready(function () {
    $(function () {
        $("#Modalagregar").hide();
        $("body").addClass("sidebar-collapse");
        $("#divagregabeneficiario").hide();
     //  Buscar();
       cargarCodigosRetencion();
       cargarBeneficiarios();
       cargarContratos();
       cargarArea();
       
    });
});
function cargarCodigosRetencion()
{
    var data= new FormData();
    var objApiRest = new AJAXRestFilePOST('/financiera/codigosRetencion',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            codigosRetencion=_resultContent.message;
            //mostrar
            $.each(codigosRetencion, function (_key, _value) {
                $("#cargaCodigosBienes").append("<div class='col-lg-3' style='border-bottom: 1px solid #FFF'><span name='codigoCargadoBienes'>"+_value.codigo+"</span></div>"+"<div class='col-lg-3' style='border-right: 1px solid #FFF;border-bottom: 1px solid #FFF'><span>"+_value.porcentaje*100+"%</span></div>")
                $("#cargaCodigosServicios").append("<div class='col-lg-3' style='border-bottom: 1px solid #FFF'><span  name='codigoCargadoServicios'>"+_value.codigo+"</span></div>"+"<div class='col-lg-3' style='border-right: 1px solid #FFF;border-bottom: 1px solid #FFF'><span>"+_value.porcentaje*100+"%</span></div>")
            });
        } 
    });

}
function cargarArea()
{
    var data= new FormData();
    var objApiRest = new AJAXRestFilePOST('/financiera/areaSolicitante',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            areaSolicitante=_resultContent.message;

        } 
    });

}
function cargarBeneficiarios()
{
   $("#beneficiario").html('');
   var id='';
    var data= new FormData();
    var objApiRest = new AJAXRestFilePOST('/financiera/identificacionBeneficiarios',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            identificacionBeneficiarios=_resultContent.message;
            $("#beneficiario").append("<option selected='selected' value=''>SELECCIONE</option>");
            $.each(identificacionBeneficiarios, function (_key, _value) {
                if(nuevoBeneficiario.toUpperCase()==_value.descripcion.toUpperCase())
                {
                    id=_value.id;
                }
                    $("#beneficiario").append("<option value='" + _value.id + "'>" + _value.descripcion + "["+_value.identificacion+"]</option>")
            });
            $("#beneficiario").val(id).change();
           
        } 
    });

}


function getCodigoRetencion(codigo)
{
    if(codigo=="")
    return null;
        var data = $.grep(codigosRetencion, function (element, index) {
            return element.codigo == codigo;
        });
        data=data[0];
        return porcentajeIR=data['porcentaje'];
}
function getTipoContrato(id){
    if(id=="")
    return null;
        var data = $.grep(tiposContratos, function (element, index) {
            return element.id == id;
        });
        return data=data[0];
}
function getCodigoAreaSolicitante(codigo)
{
    if(codigo=="")
    return null;
        var dataareaSolicitante = $.grep(areaSolicitante, function (element, index) {
            return element.id == codigo;
        });
        return dataareaSolicitante=dataareaSolicitante[0];
}

function getCodigoBenefeciario(codigo)
{
    if(codigo=="")
    return null;
        var dataBeneficiario = $.grep(identificacionBeneficiarios, function (element, index) {
            return element.id == codigo;
        });
        return dataBeneficiario=dataBeneficiario[0];
}

function imprimirDiv(id) {
    var data2 = $.grep(datosPagoArray, function (element, index) {
        return element.id == id;
    });
    data2=data2[0];

    var data=getTipoContrato(data2['tipoContratoId']);
    if(data==null)
    {
        alertToast("Debe de Ingresar como minimo el tipo de Contrato para poder Imprimir",3500);
        return false;
    }

    var dataBeneficiario=getCodigoBenefeciario(data2['beneficiarioId']);
    var dataareaSolicitante=getCodigoAreaSolicitante(data2['areaSolicitanteId']);

    var fechaLiquidacion=data2['fechaLiquidacion']!=null?data2['fechaLiquidacion']:'';
    
    var contrato='';
    if(ArregloTipoContratoD!=null&&ArregloTipoContratoD!='')
        contrato=data!=null?data['contratoHtmlD']:'';
    else
        contrato=data!=null?data['contratoHtml']:'';
    
    var tipoContrato=data!=null?data['descripcion']:'';
    
    var lidercontrol=data2['usuario_actualiza']!=null?data2['usuario_actualiza'].replace('.',' '):'';
    var analistacontrol=data2['usuario_ingresa']!=null?data2['usuario_ingresa'].replace('.',' '):'';
    
    var observaciones=data2['observacion']!=null?data2['observacion']:'';
    var totalIngIva=data2['total']!=null?Number(data2['total'].replace(/[^0-9.-]+/g,"")):0.00;
   // totalIngIva= Number(totalIngIva.replace(/[^0-9.-]+/g,""));
    var totalIva=totalIngIva;
    
    var objetocontrato=data2['objetoContrato']!=null?data2['objetoContrato']:'';
    var garante=data2['garante']!=null?data2['garante']:'';
    var numeroFacturaB=data2['numeroFactura']!=null?data2['numeroFactura']:'';
    var numeroFacturaS=data2['numeroFacturaS']!=null?data2['numeroFacturaS']:'';

    var contratoPlantilla=data2['contrato']!=null?data2['contrato']:'';

    var beneficiario=dataBeneficiario!=null?dataBeneficiario['descripcion']:'';
    var identificacionBeneficiario=dataBeneficiario!=null?dataBeneficiario['identificacion']:'';
    var areasolicitante=dataareaSolicitante!=null?dataareaSolicitante['descripcion']:'';

    //AMORTIZACION

var amortizacion=data2['amortizacion']!=null?Number(data2['amortizacion'].replace(/[^0-9.-]+/g,"")):0.00;
var amortizacionExterna=data2['amortizacionExterna']!=null?Number(data2['amortizacionExterna'].replace(/[^0-9.-]+/g,"")):0.00;
var amortizacionFiscal=data2['amortizacionFiscal']!=null?Number(data2['amortizacionFiscal'].replace(/[^0-9.-]+/g,"")):0.00;
var anticipo=data2['anticipo']!=null?Number(data2['anticipo'].replace(/[^0-9.-]+/g,"")):0.00;
var autogestion=data2['autogestion']!=null?Number(data2['autogestion'].replace(/[^0-9.-]+/g,"")):0.00;
var baseCero=data2['baseCero']!=null?Number(data2['baseCero'].replace(/[^0-9.-]+/g,"")):0.00;
var baseCeroS=data2['baseCeroS']!=null?Number(data2['baseCeroS'].replace(/[^0-9.-]+/g,"")):0.00;
var baseDoce=data2['baseDoce']!=null?Number(data2['baseDoce'].replace(/[^0-9.-]+/g,"")):0.00;
var baseDoceS=data2['baseDoceS']!=null?Number(data2['baseDoceS'].replace(/[^0-9.-]+/g,"")):0.00;
var baseIR=data2['baseIR']!=null?Number(data2['baseIR'].replace(/[^0-9.-]+/g,"")):0.00;
var baseIRS=data2['baseIRS']!=null?Number(data2['baseIRS'].replace(/[^0-9.-]+/g,"")):0.00;
var baseImponible=data2['baseImponible']!=null?Number(data2['baseImponible'].replace(/[^0-9.-]+/g,"")):0.00;
var baseImponibleS=data2['baseImponibleS']!=null?Number(data2['baseImponibleS'].replace(/[^0-9.-]+/g,"")):0.00;
var baseNoGravable=data2['baseNoGravable']!=null?Number(data2['baseNoGravable'].replace(/[^0-9.-]+/g,"")):0.00;
var baseNoGravableS=data2['baseNoGravableS']!=null?Number(data2['baseNoGravableS'].replace(/[^0-9.-]+/g,"")):0.00;
var baseSeguros=data2['baseSeguros']!=null?Number(data2['baseSeguros'].replace(/[^0-9.-]+/g,"")):0.00;
var baseSegurosS=data2['baseSegurosS']!=null?Number(data2['baseSegurosS'].replace(/[^0-9.-]+/g,"")):0.00;

var codigoRetencionIrId=data2['codigoRetencionIrId']!=null?data2['codigoRetencionIrId']:'';
var porcentajeIR=getCodigoRetencion(codigoRetencionIrId);
var codigoRetencionIrIdS=data2['codigoRetencionIrIdS']!=null?data2['codigoRetencionIrIdS']:'';
var porcentajeIRS=getCodigoRetencion(codigoRetencionIrIdS);
var codigoRetencionIvaId=data2['codigoRetencionIvaId']!=null?data2['codigoRetencionIvaId']:'';
var porcentajeIVA=getCodigoRetencion(codigoRetencionIvaId);
var codigoRetencionIvaIdS=data2['codigoRetencionIvaIdS']!=null?data2['codigoRetencionIvaIdS']:'';
var porcentajeIVAS=getCodigoRetencion(codigoRetencionIvaIdS);

var creditoExterno=data2['creditoExterno']!=null?Number(data2['creditoExterno'].replace(/[^0-9.-]+/g,"")):0.00;
var descNotasDebito=data2['descNotasDebito']!=null?Number(data2['descNotasDebito'].replace(/[^0-9.-]+/g,"")):0.00;
var descart34=data2['descart34']!=null?Number(data2['descart34'].replace(/[^0-9.-]+/g,"")):0.00;
var descmultas=data2['descmultas']!=null?Number(data2['descmultas'].replace(/[^0-9.-]+/g,"")):0.00;
var descotros=data2['descotros']!=null?Number(data2['descotros'].replace(/[^0-9.-]+/g,"")):0.00;
var fuenteautogestion=data2['fuenteautogestion']!=null?data2['fuenteautogestion']:'';
var fuentecreditoExterno=data2['fuentecreditoExterno']!=null?data2['fuentecreditoExterno']:'';
var fuenterecursos998=data2['fuenterecursos998']!=null?data2['fuenterecursos998']:'';
var fuenterecursosBID=data2['fuenterecursosBID']!=null?data2['fuenterecursosBID']:'';
var fuenterecursosFiscales=data2['fuenterecursosFiscales']!=null?data2['fuenterecursosFiscales']:'';
var fuenterecursosVirtuales=data2['fuenterecursosVirtuales']!=null?data2['fuenterecursosVirtuales']:'';
var iva=data2['iva']!=null?Number(data2['iva'].replace(/[^0-9.-]+/g,"")):0.00;
var ivaS=data2['ivaS']!=null?Number(data2['ivaS'].replace(/[^0-9.-]+/g,"")):0.00;
var plantillaPie=data2['plantillaPie']!=null?data2['plantillaPie']:'';
var recursos998=data2['recursos998']!=null?Number(data2['recursos998'].replace(/[^0-9.-]+/g,"")):0.00;
var recursosBID=data2['recursosBID']!=null?Number(data2['recursosBID'].replace(/[^0-9.-]+/g,"")):0.00;
var recursosExternosFiscales=data2['recursosExternosFiscales']!=null?data2['recursosExternosFiscales']:'';
var recursosFiscales=data2['recursosFiscales']!=null?Number(data2['recursosFiscales'].replace(/[^0-9.-]+/g,"")):0.00;
var recursosVirtuales=data2['recursosVirtuales']!=null?Number(data2['recursosVirtuales'].replace(/[^0-9.-]+/g,"")):0.00;
var saldoAmortizar=data2['saldoAmortizar']!=null?Number(data2['saldoAmortizar'].replace(/[^0-9.-]+/g,"")):0.00;
var total=data2['total']!=null?Number(data2['total'].replace(/[^0-9.-]+/g,"")):0.00;
var totalAmortizacion=data2['totalAmortizacion']!=null?Number(data2['totalAmortizacion'].replace(/[^0-9.-]+/g,"")):0.00;
var totalS=data2['totalS']!=null?Number(data2['totalS'].replace(/[^0-9.-]+/g,"")):0.00;
var totaldescuentos=data2['totaldescuentos']!=null?Number(data2['totaldescuentos'].replace(/[^0-9.-]+/g,"")):0.00;
var valorActualAmortizacion=data2['valorActualAmortizacion']!=null?Number(data2['valorActualAmortizacion'].replace(/[^0-9.-]+/g,"")):0.00;
var valorAmortizacionAcumulada=data2['valorAmortizacionAcumulada']!=null?Number(data2['valorAmortizacionAcumulada'].replace(/[^0-9.-]+/g,"")):0.00;
var valorAnticipo=data2['valorAnticipo']!=null?Number(data2['valorAnticipo'].replace(/[^0-9.-]+/g,"")):0.00;
var valorContrato=data2['valorContrato']!=null?Number(data2['valorContrato'].replace(/[^0-9.-]+/g,"")):0.00;
var valorPlanilla=data2['valorPlanilla']!=null?Number(data2['valorPlanilla'].replace(/[^0-9.-]+/g,"")):0.00;

var valorRetenciosIr=data2['valorRetenciosIr']!=null?Number(data2['valorRetenciosIr'].replace(/[^0-9.-]+/g,"")):0.00;
var valorRetenciosIrS=data2['valorRetenciosIrS']!=null?Number(data2['valorRetenciosIrS'].replace(/[^0-9.-]+/g,"")):0.00;
var retencionIva=data2['retencionIva']!=null?Number(data2['retencionIva'].replace(/[^0-9.-]+/g,"")):0.00;
var retencionIvaS=data2['retencionIvaS']!=null?Number(data2['retencionIvaS'].replace(/[^0-9.-]+/g,"")):0.00;
var numeroCertificacion=data2['numeroCertificacion']!=null?data2['numeroCertificacion']:'';


var DESCUENTOSTT=totaldescuentos;
var RETENCIONIVA100B=(porcentajeIVA*100)==100?retencionIva:0.00;
var RETENCIONIVA1B=(porcentajeIVA*100)==70?retencionIva:0.00;
var RETENCIONIVA30B=(porcentajeIVA*100)==30?retencionIva:0.00;
var RETENCIONIVA20B=(porcentajeIVA*100)==20?retencionIva:0.00;
var RETENCIONIVA10B=(porcentajeIVA*100)==10?retencionIva:0.00;

var RETENCIONIVA100S=(porcentajeIVAS*100)==100?retencionIvaS:0.00;
var RETENCIONIVA1S=(porcentajeIVAS*100)==70?retencionIvaS:0.00;
var RETENCIONIVA30S=(porcentajeIVAS*100)==30?retencionIvaS:0.00;
var RETENCIONIVA20S=(porcentajeIVAS*100)==20?retencionIvaS:0.00;
var RETENCIONIVA10S=(porcentajeIVAS*100)==10?retencionIvaS:0.00;

var RETENCIONIVA100=RETENCIONIVA100S+RETENCIONIVA100B;
var RETENCIONIVA1=RETENCIONIVA1S+RETENCIONIVA1B;
var RETENCIONIVA30=RETENCIONIVA30S+RETENCIONIVA30B;
var RETENCIONIVA20=RETENCIONIVA20S+RETENCIONIVA20B;
var RETENCIONIVA10=RETENCIONIVA10S+RETENCIONIVA10B;

var TOTALRETENCIONIVA=RETENCIONIVA100+RETENCIONIVA1+RETENCIONIVA30+RETENCIONIVA20+RETENCIONIVA10;

var RETENCIONIIR1B=(porcentajeIR*100)==1?valorRetenciosIr:0.00;
var RETENCIONIIR2B=(porcentajeIR*100)==2?valorRetenciosIr:0.00;
var RETENCIONIIR3B=(porcentajeIR*100)==8?valorRetenciosIr:0.00;
var RETENCIONIIR10B=(porcentajeIR*100)==10?valorRetenciosIr:0.00;

var RETENCIONIIR1S=(porcentajeIRS*100)==1?valorRetenciosIrS:0.00;
var RETENCIONIIR2S=(porcentajeIRS*100)==2?valorRetenciosIrS:0.00;
var RETENCIONIIR3S=(porcentajeIRS*100)==8?valorRetenciosIrS:0.00;
var RETENCIONIIR10S=(porcentajeIRS*100)==10?valorRetenciosIrS:0.00;


var RETENCIONIIR1=RETENCIONIIR1B+RETENCIONIIR1S;
var RETENCIONIIR2=RETENCIONIIR2B+RETENCIONIIR2S;
var RETENCIONIIR3=RETENCIONIIR3B+RETENCIONIIR3S;
var RETENCIONIIR10=RETENCIONIIR10B+RETENCIONIIR10S;


var TOTALRETENCIONIR=RETENCIONIIR1+RETENCIONIIR2+RETENCIONIIR3+RETENCIONIIR10;

var ivap=conComas((iva+ivaS).toFixed(2))
    //FACTURA 

    if(contrato!=null)
    {
        contrato=contrato.replace("#FECHALIQUIDACION",fechaLiquidacion);
        contrato=contrato.replace("#OBSERVACIONES",observaciones.toUpperCase());
        contrato=contrato.replace("#INGRESOS",totalIngIva);
        contrato=contrato.replace("#CONTRATO",contratoPlantilla.toUpperCase());
        contrato=contrato.replace("#VALORCANCELAR",totalIva.toFixed(2));
        contrato=contrato.replace("#GARANTE",garante.toUpperCase());
        contrato=contrato.replace("#OBJETOCONTRATO",objetocontrato.toUpperCase());
        contrato=contrato.replace("#BENEFICIARIO",beneficiario.toUpperCase());
        contrato=contrato.replace("#IDENTIFICACION",identificacionBeneficiario);
        contrato=contrato.replace("#AREASOLICITANTE",areasolicitante.toUpperCase());
        contrato=contrato.replace("#TIPOCONTRATO",tipoContrato.toUpperCase());
        contrato=contrato.replace("#NUMEROFACTURASB",numeroFacturaB.toUpperCase());
        contrato=contrato.replace("#NUMEROFACTURASS",numeroFacturaS.toUpperCase());
        contrato=contrato.replace("#VALORCONTRATO",conComas(valorContrato.toFixed(2)));	
        contrato=contrato.replace("#PORCENTAJEANTICIPO",conComas(anticipo.toFixed(2)));	
        contrato=contrato.replace("#VALORANTICIPO",conComas(valorAnticipo.toFixed(2)));	
         
        contrato=contrato.replace("#TOTALPLANILLA",conComas(valorPlanilla.toFixed(2)));	
        contrato=contrato.replace("#SUBTOTALBASEDOCE",conComas((baseDoce+baseDoceS).toFixed(2))); 	
       
       
         /*   TIPO DE CONTRATO CREDITO EXTERNO Y FISCAL */
         var pvalorce=$("#pvalorce").val();
         var pvalorcf=$("#pvalorcf").val();
         var amortizacionFiscal=data2['amortizacionFiscal']!=null?Number(data2['amortizacionFiscal'].replace(/[^0-9.-]+/g,"")):0.00;
         var amortizacionExterna=data2['amortizacionExterna']!=null?Number(data2['amortizacionExterna'].replace(/[^0-9.-]+/g,"")):0.00;

         var valorcf=(valorPlanilla*(pvalorcf/100))-(totaldescuentos+TOTALRETENCIONIR+TOTALRETENCIONIVA+amortizacionFiscal);
         var valorce=(valorPlanilla*(pvalorce/100))-(amortizacionExterna);
            contrato=contrato.replace("#VALORCE",conComas(valorce.toFixed(2)));
            contrato=contrato.replace("#VALORCF",conComas(valorcf.toFixed(2)));
        /* FIN DE TIPO DE CONTRATO CREDITO EXTERNO Y FISCAL */
        contrato=contrato.replace("#SUBTOTALBASENO",conComas((baseNoGravable+baseNoGravableS).toFixed(2))); 	
        contrato=contrato.replace("#SUBTOTALBASECERO",conComas((baseCeroS+baseCero).toFixed(2))); 	
        
        contrato=contrato.replace("#TOTALIVA",ivap); 	
        contrato=contrato.replace("#TOTALFACTURA",conComas((total+totalS).toFixed(2))); 	
        
        contrato=contrato.replace("#RETENCIONIVA100",conComas(RETENCIONIVA100.toFixed(2)));
        contrato=contrato.replace("#RETENCIONIVA1",conComas(RETENCIONIVA1.toFixed(2)));
        contrato=contrato.replace("#RETENCIONIVA30",conComas(RETENCIONIVA30.toFixed(2)));
        contrato=contrato.replace("#RETENCIONIVA20",conComas(RETENCIONIVA20.toFixed(2)));
        contrato=contrato.replace("#RETENCIONIVA10",conComas(RETENCIONIVA10.toFixed(2)));
        contrato=contrato.replace("#TOTALRETENCIONIVA",conComas(TOTALRETENCIONIVA.toFixed(2)));

        contrato=contrato.replace("#RETENCIONIIR1",conComas(RETENCIONIIR1.toFixed(2)));
        contrato=contrato.replace("#RETENCIONIIR2",conComas(RETENCIONIIR2.toFixed(2)));
        contrato=contrato.replace("#RETENCIONIIR3",conComas(RETENCIONIIR3.toFixed(2)));
        contrato=contrato.replace("#RETENCIONIIR10",conComas(RETENCIONIIR10.toFixed(2)));
        contrato=contrato.replace("#TOTALRETENCIONIR",conComas(TOTALRETENCIONIR.toFixed(2)));
        
        contrato=contrato.replace("#TOTALRETENCIONES",conComas((TOTALRETENCIONIR+TOTALRETENCIONIVA).toFixed(2)));
       
        contrato=contrato.replace("#SUBTOTALBASEDOCE2",conComas((baseDoce+baseDoceS).toFixed(2))); 
        contrato=contrato.replace("#SUBTOTALBASECERO2",conComas((baseCeroS+baseCero+baseNoGravable+baseNoGravableS).toFixed(2)));
        contrato=contrato.replace("#TOTALIVA2",ivap); 
        contrato=contrato.replace("#TOTALFACTURA2",conComas((total+totalS).toFixed(2))); 
        contrato=contrato.replace("#TOTALRETENCIONIVA2",conComas(TOTALRETENCIONIVA.toFixed(2)));
        contrato=contrato.replace("#TOTALRETENCIONIR2",conComas(TOTALRETENCIONIR.toFixed(2)));

        contrato=contrato.replace("#FUENTEEXTERNA",fuentecreditoExterno.toUpperCase());	
        contrato=contrato.replace("#VALORFUENTEEXTERNA",conComas(creditoExterno.toFixed(2)));  
        contrato=contrato.replace("#FUENTE998",fuenterecursos998.toUpperCase());	
        contrato=contrato.replace("#VALORFUENTE998",conComas(recursos998.toFixed(2))); 
        contrato=contrato.replace("#FUENTEFISCAL",fuenterecursosFiscales.toUpperCase());	
        contrato=contrato.replace("#VALORFUENTEFISCAL",conComas(recursosFiscales.toFixed(2))); 
        contrato=contrato.replace("#FUENTEVIRTUALES",fuenterecursosVirtuales.toUpperCase());	
        contrato=contrato.replace("#VALORFUENTEVIRTUAL",conComas(recursosVirtuales.toFixed(2))); 
        contrato=contrato.replace("#FUENTEBID",fuenterecursosBID.toUpperCase());	
        contrato=contrato.replace("#VALORFUENTEBID",conComas(recursosBID.toFixed(2))); 
        contrato=contrato.replace("#FUENTEAUTOGESTION",fuenteautogestion.toUpperCase());	
        contrato=contrato.replace("#VFUENTEAUTOGESTION",conComas(autogestion.toFixed(2))); 
       
       var totalFuentes=creditoExterno+recursos998+recursosFiscales+recursosVirtuales+recursosBID+autogestion;
       contrato=contrato.replace("#CERTIFICACION",numeroCertificacion.toUpperCase()); 

        contrato=contrato.replace("#ACTUALAMORTIZACION",conComas(valorActualAmortizacion.toFixed(2)));
        contrato=contrato.replace("#TOTALDESCUENTOS",conComas(DESCUENTOSTT.toFixed(2))); 
        contrato=contrato.replace("#SUMARETENCIONES",conComas((valorActualAmortizacion+TOTALRETENCIONIR+TOTALRETENCIONIVA+DESCUENTOSTT).toFixed(2)));
        contrato=contrato.replace("#AMORTIZACIONFISCAL",conComas(amortizacionFiscal.toFixed(2)));
        contrato=contrato.replace("#AMORTIZACIONEXTERNA",conComas(amortizacionExterna.toFixed(2)));
        contrato=contrato.replace("#SCREDITOEXT",conComas((amortizacionFiscal+amortizacionExterna+TOTALRETENCIONIR+TOTALRETENCIONIVA+DESCUENTOSTT).toFixed(2)));
        contrato=contrato.replace("#VALORRECIBIR",conComas((total+totalS-(valorActualAmortizacion+TOTALRETENCIONIR+TOTALRETENCIONIVA+DESCUENTOSTT)).toFixed(2)));
        contrato=contrato.replace("#VRCREDEXT",conComas((total+totalS-(valorActualAmortizacion+TOTALRETENCIONIR+TOTALRETENCIONIVA+DESCUENTOSTT)).toFixed(2)));

        contrato=contrato.replace("#SUMAFUENTES",conComas(totalFuentes.toFixed(2)));  
       
        var analistaArreglo=analistacontrol!=''?analistacontrol.split(','):'';
        var analista='';
        var cargoanalista='';
    
        var liderArreglo=lidercontrol!=''?lidercontrol.split(','):'';
        var lidercc='';
        var cargolidercc='';
        var ELABORADOPOR='';
        var REVISADOPOR='';
        var PE=plantillaPie.indexOf("E");
        var PR=plantillaPie.indexOf("R");
        if(liderArreglo!=''&&PR!=-1){
                lidercc=liderArreglo[0].replace('CN=','');
                cargolidercc=liderArreglo[1].replace('CARGO=','');
                REVISADOPOR='REVISADO POR';
        }
        

        if(analistaArreglo!=''&&PE!=-1){
                analista=analistaArreglo[0].replace('CN=','');
                cargoanalista=analistaArreglo[1].replace('CARGO=','');
                ELABORADOPOR='ELABORADO POR:';
        }
        contrato=contrato.replace("#ELABORADOPOR",ELABORADOPOR);	
        contrato=contrato.replace("#REVISADOPOR",REVISADOPOR);
        contrato=contrato.replace("#ELABORADOR",analista.toUpperCase());	
        contrato=contrato.replace("#REVISOR",lidercc.toUpperCase());
        contrato=contrato.replace("#CARGOELABORA",cargoanalista.toUpperCase());	
        contrato=contrato.replace("#CARGOREVISOR",cargolidercc.toUpperCase());

        contrato=contrato.replace("#DESCRIPCIONEXTERNO","R. EXTERNO");
        contrato=contrato.replace("#DESCRIPCION998","ANTICIPO A&Ntilde;OS ANTERIORES(998)");
        contrato=contrato.replace("#DESCRIPCIONFISCAL","FISCAL");
        contrato=contrato.replace("#DESCRIPCIONVIRTUAL","VIRTUALES");
        contrato=contrato.replace("#DESCRIPCIONBID","BID");
        contrato=contrato.replace("#DESCRIPCIONAUTOGESTION","AUTOGESTION");

        if(fuentecreditoExterno=='')
            contrato=contrato.replace("<tr class=xl22224005 height=24 style='height:18.0pt' id='rexterno'>","<tr class=xl22224005 height=24 style='height:18.0pt;display:none' id='rexterno'>");
        if(fuenterecursos998=='')
            contrato=contrato.replace("<tr class=xl22224005 height=24 style='height:18.0pt' id='r998'>","<tr class=xl22224005 height=24 style='height:18.0pt;display:none' id='r998'>");
        if(fuenterecursosFiscales=='')
            contrato=contrato.replace("<tr class=xl22224005 height=24 style='height:18.0pt' id='rfiscal'>","<tr class=xl22224005 height=24 style='height:18.0pt;display:none' id='rfiscal'>");

            contrato=contrato.replace("<tr class=xl22224005 height=24 style='height:18.0pt' id='rvirtual'>","<tr class=xl22224005 height=24 style='height:18.0pt;display:none' id='rvirtual'>");
        if(fuenterecursosBID=='')
            contrato=contrato.replace("<tr class=xl22224005 height=24 style='height:18.0pt' id='rbid'>","<tr class=xl22224005 height=24 style='height:18.0pt;display:none' id='rbid'>");
        if(fuenteautogestion=='')
            contrato=contrato.replace("<tr class=xl22224005 height=25 style='height:18.75pt' id='rauto'>","<tr class=xl22224005 height=25 style='height:18.75pt;display:none' id='rauto'>");
        
        contrato=contrato.replace("#ID",id);
        //descuentosh
        
       ///IMPRIME CONTENIDO
        var ventanaImpresion = window.open(' ', 'popUp');
            ventanaImpresion.document.write(contrato);
            ventanaImpresion.document.close();
            ventanaImpresion.print();
            ventanaImpresion.close();
        /// FIN IMPRIME CONTENIDO
    }
}
$("#pvalorcf,#valorPlanilla,#amortizacion,#baseDoce,#baseDoceS").on("keyup",function(){
   var porcentaje= $(this).val();
   var valorPlanilla=$("#valorPlanilla").val();
   var amortizacion=$("#amortizacion").val();
   porcentaje=porcentaje!=''?Number(porcentaje.replace(/[^0-9.-]+/g,"")):0;
   valorPlanilla=valorPlanilla!='0.00'?Number(valorPlanilla.replace(/[^0-9.-]+/g,"")):0;
   var total=valorPlanilla*(porcentaje/100);
   $("#valorcf").val(conComas(total.toFixed(2)));
   total=total*(amortizacion/100);
   $("#amortizacionFiscal").val(conComas(total.toFixed(2)));

});
$("#pvalorce,#valorPlanilla,#amortizacion,#baseDoce,#baseDoceS").on("keyup",function(){
    var porcentaje= $(this).val();
    var valorPlanilla=$("#valorPlanilla").val();
    var amortizacion=$("#amortizacion").val();
    
    porcentaje=porcentaje!=''?Number(porcentaje.replace(/[^0-9.-]+/g,"")):0;
    valorPlanilla=valorPlanilla!='0.00'?Number(valorPlanilla.replace(/[^0-9.-]+/g,"")):0;
    var total=valorPlanilla*(porcentaje/100);

    $("#valorce").val(conComas(total.toFixed(2)));
    total=total*(amortizacion/100);
    $("#amortizacionExterna").val(conComas(total.toFixed(2)));
 });

 $("#RecursosFiscales").on("keyup",function(){
    var data=$(this).val()!=''?$("#FRecursosFiscales").val('001-0000-0000'):$("#FRecursosFiscales").val('');
 });
 $("#Recursos998").on("keyup",function(){
    var data=$(this).val()!=''?$("#FRecursos998").val('998-0000-0000'):$("#FRecursos998").val('');

});
$("#Autogestion").on("keyup",function(){
    var data=$(this).val()!=''?$("#FAutogestion").val('002-0000-0000'):$("#FAutogestion").val('');

});

//SERIE DE FACTURA BIENES Y SERVICIOS
$("#contrato").on("keyup",function(){
    var id=$("#id").val()==0?$("#serieFacturaid").val($("#contrato").val()):'';
    var id=$("#id").val()==0?$("#serieFacturaidS").val($("#contrato").val()):'';

});

//FIN SERIE DE FACTURA
$("#totaldescuentos,#descNotasDebito,#descotros,#descart34,#descmultas").on("keyup",function(){
        
    var descNotasDebito= Number($("#descNotasDebito").val().replace(/[^0-9.-]+/g,""));
    var descotros= Number($("#descotros").val().replace(/[^0-9.-]+/g,""));
    var descart34= Number($("#descart34").val().replace(/[^0-9.-]+/g,""));
    var descmultas= Number($("#descmultas").val().replace(/[^0-9.-]+/g,""));
   // var descuentoIva=   Number($("#descuentoIva").val().replace(/[^0-9.-]+/g,""));
    var totalBases=descNotasDebito+descotros+descart34+descmultas;
    totalBases=totalBases>0?totalBases.toFixed(2):'0.00';
    $("#totaldescuentos").val(conComas(totalBases));
});
/*
$("#identificacionbeneficiarioagrega,#nombrebeneficiarioagrega").on("keyup",function(){
   var id=$("#identificacionbeneficiarioagrega").val();
   var nombre=$("#nombrebeneficiarioagrega").val();
    if(id==''||id==null||nombre==''||nombre==null)
     {
        $("#grababeneficiario").hide();
        $("#retornabeneficiario").show();
     }    
    else
    {
        $("#grababeneficiario").show();
        $("#retornabeneficiario").hide();
    }
});
*/

//BIENES 

$("#codRetIVA,#codRetIR").on('change',function(){
    var codRet= $(this).val();
   if(codRet!="")
   {
       var data = $.grep(codigosRetencion, function (element, index) {
           return element.codigo == codRet;
       });
       data=data[0];
       var descripcion=data['descripcion'];
       var porcentaje=data['porcentaje'];
       if(data['tipo']!="IR")
       {
           $("#porcentajeRetencionIVA").val(porcentaje*100);
           $("#descripcionretIva").html(descripcion);
       }
       else
       {
           $("#porcentajeRetencionIR").val(porcentaje*100);
           $("#descripcionretIR").html(descripcion);
       }
   }
   
});
$("#codRetIVAS,#codRetIRS").on('change',function(){
    var codRet= $(this).val();
   if(codRet!="")
   {
       var data = $.grep(codigosRetencion, function (element, index) {
           return element.codigo == codRet;
       });
       data=data[0];
       var descripcion=data['descripcion'];
       var porcentaje=data['porcentaje'];
       if(data['tipo']!="IR")
       {
           $("#porcentajeRetencionIVAS").val(porcentaje*100);
           $("#descripcionretIvaS").html(descripcion);
       }
       else
       {
           $("#porcentajeRetencionIRS").val(porcentaje*100);
           $("#descripcionretIRS").html(descripcion);
       }
   }
   
});

$("#anticipo").on("keyup",function(){
    $("#amortizacion").val($(this).val());
});
$("#iva").on("keyup",function(){
    var thisv=Number($(this).val().replace(/[^0-9.-]+/g,""));
    $("#baseImp").val(conComas(thisv.toFixed(2)));
});
$("#ivaS").on("keyup",function(){
    var thisv=Number($(this).val().replace(/[^0-9.-]+/g,""));
    $("#baseImpS").val(conComas(thisv.toFixed(2)));
});
$("#baseDoce").on("keyup",function(){
    var porcentajeiva=$("#porcentajeiva").val();
    var thisv=Number($(this).val().replace(/[^0-9.-]+/g,""));

    var tiva=thisv*(porcentajeiva/100);
    $("#iva").val(conComas(tiva.toFixed(2)));
    $("#baseImp").val(conComas(tiva.toFixed(2)));
    $("#baseIR").val(conComas(thisv.toFixed(2)));
});

$("#baseDoceS").on("keyup",function(){
    var porcentajeiva=$("#porcentajeiva").val();
    var thisv=Number($(this).val().replace(/[^0-9.-]+/g,""));
    var tiva=thisv*(porcentajeiva/100);

    $("#ivaS").val(conComas(tiva.toFixed(2)));
    $("#baseImpS").val(conComas(tiva.toFixed(2)));
    $("#baseIRS").val(conComas(thisv.toFixed(2)));
});

$("#baseIR,#baseDoce").on("keyup",function(){
    var porcentajebaseseguros=$("#porcentajebaseseguros").val();
    var thisv=Number($("#baseIR").val().replace(/[^0-9.-]+/g,""));

    var tbaseseguros=thisv*(porcentajebaseseguros/100);
    var idc=$("#tipoContrato").val();
    var BS=0.00
    if(idc!=""){
        var data=getTipoContrato(idc);
        CONTRATO=data!=null?data['descripcion']:BS=0.00;
        BS=CONTRATO.indexOf('SEGURO')!=-1?conComas(tbaseseguros.toFixed(2)):0.00;
    }
   
    $("#baseseguros").val(BS);
    var disabledBS=BS!=0.00?$("#baseseguros").attr('disabled',false):$("#baseseguros").attr('disabled',true);

});
$("#ingresos").on("keyup",function(){
    $("#baseNoGrav").val($(this).val()); 
    $("#totalbases").val($(this).val());  
    $("#totalIva").text($(this).val());  
    });
$("#baseNoGrav").on("keyup",function(){
    $("#ingresos").val($(this).val());  
});
$("#ingresos,#descotros,#descmultas,#descart34,#descNotasDebito,#totaldescuentos").on("keyup",function(){
    var ingresos=Number($("#ingresos").val().replace(/[^0-9.-]+/g,""));
    var totaldescuentos=Number($("#totaldescuentos").val().replace(/[^0-9.-]+/g,""));

    var total=ingresos-totaldescuentos;
    $("#valorRecibir").text(conComas(total.toFixed(2)));
});

$("#baseIRS,#baseDoceS").on("keyup",function(){
    var porcentajebaseseguros=$("#porcentajebaseseguros").val();
    var thisv=Number($("#baseIRS").val().replace(/[^0-9.-]+/g,""));

    var tbaseseguros=thisv*(porcentajebaseseguros/100);
    var idc=$("#tipoContrato").val();
    var BS=0.00
    if(idc!=""){
        var data=getTipoContrato(idc);
        CONTRATO=data!=null?data['descripcion']:BS=0.00;
        BS=CONTRATO.indexOf('SEGURO')!=-1?conComas(tbaseseguros.toFixed(2)):0.00;
    }
   
    $("#basesegurosS").val(BS);
    var disabledBS=BS!=0.00?$("#basesegurosS").attr('disabled',false):$("#basesegurosS").attr('disabled',true);
});
$("#tipoContrato").on("change",function(){
//limpiar();
    /*$("#baseDoce").val(0);
    $("#baseDoceS").val(0);
    $("#baseCero").val(0);
    $("#baseCeroS").val(0);
    $("#baseNoGrav").val(0);
    $("#baseNoGrav").val(0);
    $("#ivaS").val(0);
    $("#iva").val(0);
    $("#porcentajeRetencionIVA").val(0);
    $("#retencionIva").val(0);
    $("#retencionIR").val(0);
    $("#porcentajeRetencionIR").val(0);
    $("#porcentajeRetencionIVAS").val(0);
    $("#retencionIvaS").val(0);
    $("#retencionIRS").val(0);
    $("#baseIR").val(0);
    $("#baseIRS").val(0);
    $("#baseImp").val(0);
    $("#baseImpS").val(0);
    
    var ingresos=$("#ingresos").val()!=''?$("#ingresos").val():0;
    $("#totalBases").val(ingresos);
    $("#totalBasesS").val(0);*/
    
    var data=getTipoContrato($(this).val());
    var CONTRATO=data!=null?data['descripcion']:'';
    var catalogo=data!=null?data['catalogo']:'';

    BS=CONTRATO.indexOf('SEGURO')!=-1?$("#basesegurosS").attr('disabled',false):$("#basesegurosS").attr('disabled',true);
    BS=CONTRATO.indexOf('SEGURO')!=-1?$("#baseseguros").attr('disabled',false):$("#baseseguros").attr('disabled',true);
    $("#basesegurosS").val(0.00);
    $("#baseseguros").val(0.00);

    switch(catalogo)
    {
        case 'C':
                $("#bienescompleto").removeClass('hidden');
                $("#servicioscompleto").removeClass('hidden');
             //   $("#contratoscompleto").removeClass('hidden');
                $("#contratosbasico").addClass('hidden');
                $("#amortizacompleto").removeClass('hidden');
                $("#amortizacompleto").addClass('active');
                $("#descuentocompleto").removeClass('active');
                $("#recursoscompleto").removeClass('active');
                $("#amorizaitem").addClass('active');
                $("#descuentoitem").removeClass('active');
                $("#tab5").addClass('active');
                $("#tab6").removeClass('active');
                $("#tab7").removeClass('active');
                $("#valorRecibirBasico").addClass('hidden');
                $("#tipoContratoD").removeClass('hidden'); 


        break;
        case 'B':
                $("#bienescompleto").addClass('hidden');
                $("#servicioscompleto").addClass('hidden');
              //  $("#contratoscompleto").addClass('hidden');
                $("#contratosbasico").removeClass('hidden');
                $("#valorRecibirBasico").removeClass('hidden');
                $("#tipoContratoD").addClass('hidden'); 
                
                //$("#itemcompleto").addClass('hidden');
                $("#amortizacompleto").addClass('hidden');
                
                $("#amortizacompleto").removeClass('active');
                $("#descuentocompleto").addClass('active');
                $("#recursoscompleto").removeClass('active');
        
                $("#amorizaitem").removeClass('active');
                $("#descuentoitem").addClass('active');
        
                $("#tab5").removeClass('active');
                $("#tab7").removeClass('active');
                $("#tab6").addClass('active');
                $("#creditoexternoCompleto").addClass('hidden');

        break;
        case 'D':   
            $("#bienescompleto").removeClass('hidden');
            $("#servicioscompleto").removeClass('hidden');
            $("#contratoscompleto").removeClass('hidden');
            $("#contratosbasico").addClass('hidden');
            $("#amortizacompleto").removeClass('hidden');
            $("#amortizacompleto").addClass('active');
            $("#descuentocompleto").removeClass('active');
            $("#recursoscompleto").removeClass('active');
            $("#amorizaitem").addClass('active');
            $("#descuentoitem").removeClass('active');
            $("#tab5").addClass('active');
            $("#tab6").removeClass('active');
            $("#tab7").removeClass('active');
            $("#creditoexternoCompleto").removeClass('hidden');
            
        break;

    }

});
$("#baseDoce,#baseDoceS,#amortizacion,#pvalorce,#pvalorcf,#valorPlanilla,#amortizacionFiscal,#amortizacionExterna").on("keyup",function(){
    var valorPlanilla=Number($("#valorPlanilla").val().replace(/[^0-9.-]+/g,""));
    var amortizacion=Number($("#amortizacion").val().replace(/[^0-9.-]+/g,""));

    var pvalorce=Number($("#pvalorce").val().replace(/[^0-9.-]+/g,""));
    var pvalorcf=Number($("#pvalorcf").val().replace(/[^0-9.-]+/g,""));
   
    var amortizacionFiscal=Number($("#amortizacionFiscal").val().replace(/[^0-9.-]+/g,""));
    var amortizacionExterna=Number($("#amortizacionExterna").val().replace(/[^0-9.-]+/g,""));

    var tactualAmortizacion=valorPlanilla*(amortizacion/100);

    if(pvalorce!=0 || pvalorcf!=0 )
    $("#actualAmortizacion").val(conComas((amortizacionFiscal+amortizacionExterna).toFixed(2)));
    else
    $("#actualAmortizacion").val(conComas(tactualAmortizacion.toFixed(2)));
});

$("#valorPlanilla,#valorContrato,#amortizacion,#anticipo,#amortizacionAcumulada,#actualAmortizacion,#amortizacionFiscal,#amortizacionExterna"+
    ",#baseNoGravS,#baseCeroS,#baseDoceS,#ivaS,#totalBasesS"+
    ",#baseNoGrav,#baseCero,#baseDoce,#iva,#totalBases"+
    ",#porcentajeRetencionIVA,#baseImp,#retencionIva"+
    ",#porcentajeRetencionIR,#baseIR,#baseseguros,#retencionIR"+
    ",#porcentajeRetencionIVAS,#baseImpS,#retencionIvaS"+
    ",#porcentajeRetencionIRS,#baseIRS,#basesegurosS,#retencionIRS,#codRetIRS,#codRetIR,#codRetIVAS,#codRetIVA"
    ).on("keyup change",function(){

        var cc=$("#tipoContrato").val();
       //AMORTIZACION
        var valorContrato=Number($("#valorContrato").val().replace(/[^0-9.-]+/g,""));
        var anticipo=Number($("#anticipo").val().replace(/[^0-9.-]+/g,""));
        var amortizacion=Number($("#amortizacion").val().replace(/[^0-9.-]+/g,""));

        var amortizacionAcumulada=Number($("#amortizacionAcumulada").val().replace(/[^0-9.-]+/g,""));
        var actualAmortizacion=Number($("#actualAmortizacion").val().replace(/[^0-9.-]+/g,""));

        var amortizacionFiscal=Number($("#amortizacionFiscal").val().replace(/[^0-9.-]+/g,""));
        var amortizacionExterna=Number($("#amortizacionExterna").val().replace(/[^0-9.-]+/g,""));
       //SERVICIOS
        var baseNoGravS=Number($("#baseNoGravS").val().replace(/[^0-9.-]+/g,""));
        var baseCeroS=Number($("#baseCeroS").val().replace(/[^0-9.-]+/g,""));
        var baseDoceS=Number($("#baseDoceS").val().replace(/[^0-9.-]+/g,""));
        var ivaS=Number($("#ivaS").val().replace(/[^0-9.-]+/g,"")); 
        var totalBasesS=Number($("#totalBasesS").val().replace(/[^0-9.-]+/g,""));
        var porcentajeRetencionIVAS=Number($("#porcentajeRetencionIVAS").val().replace(/[^0-9.-]+/g,""));
        var baseImpS=Number($("#baseImpS").val().replace(/[^0-9.-]+/g,""));
        var retencionIvaS=Number($("#retencionIvaS").val().replace(/[^0-9.-]+/g,""));
        var porcentajeRetencionIRS=Number($("#porcentajeRetencionIRS").val().replace(/[^0-9.-]+/g,"")); 
        var baseIRS=Number($("#baseIRS").val().replace(/[^0-9.-]+/g,""));
        var basesegurosS=Number($("#basesegurosS").val().replace(/[^0-9.-]+/g,""));
        var retencionIRS=Number($("#retencionIRS").val().replace(/[^0-9.-]+/g,""));
        //BIENES
        var baseNoGrav=Number($("#baseNoGrav").val().replace(/[^0-9.-]+/g,""));
        var baseCero=Number($("#baseCero").val().replace(/[^0-9.-]+/g,""));
        var baseDoce=Number($("#baseDoce").val().replace(/[^0-9.-]+/g,""));
        var iva=Number($("#iva").val().replace(/[^0-9.-]+/g,"")); 
        var totalBases=Number($("#totalBases").val().replace(/[^0-9.-]+/g,""));
        var porcentajeRetencionIVA=Number($("#porcentajeRetencionIVA").val().replace(/[^0-9.-]+/g,""));
        var baseImp=Number($("#baseImp").val().replace(/[^0-9.-]+/g,""));
        var retencionIva=Number($("#retencionIva").val().replace(/[^0-9.-]+/g,""));
        var porcentajeRetencionIR=Number($("#porcentajeRetencionIR").val().replace(/[^0-9.-]+/g,"")); 
        var baseIR=Number($("#baseIR").val().replace(/[^0-9.-]+/g,""));
        var baseseguros=Number($("#baseseguros").val().replace(/[^0-9.-]+/g,""));
        var retencionIR=Number($("#retencionIR").val().replace(/[^0-9.-]+/g,""));
     
        //CALCULOS 
        var tvalorAnticipo=valorContrato*(anticipo/100);
        var ttotalamortizado=amortizacionAcumulada+actualAmortizacion;
        var tsaldoAmortizar=tvalorAnticipo-ttotalamortizado;
           
        var ttotalbasesB=baseNoGrav+baseCero+baseDoce;
        var ttotalbasesS=baseNoGravS+baseCeroS+baseDoceS;

        var ttotalIva=ttotalbasesB+iva;
        var ttotalIvaS=ttotalbasesS+ivaS;
       
        var tretencionIvaB=baseImp*(porcentajeRetencionIVA/100);
        var tretencionIRB=baseseguros>0?baseseguros*(porcentajeRetencionIR/100):baseIR*(porcentajeRetencionIR/100);
        
        var tretencionIvaS=baseImpS*(porcentajeRetencionIVAS/100);
        var tretencionIRS=basesegurosS>0?basesegurosS*(porcentajeRetencionIRS/100):baseIRS*(porcentajeRetencionIRS/100);
       
        //SET TOTALES
        var valorplanilla=conComas((ttotalbasesB+ttotalbasesS).toFixed(2));
        ttotalbasesB=conComas(ttotalbasesB.toFixed(2));
        $("#valorPlanilla").val(valorplanilla);
        $("#totalBases").val(ttotalbasesB);
        $("#totalBasesS").val(conComas(ttotalbasesS.toFixed(2)));
        $("#totalIva").text(conComas(ttotalIva.toFixed(2)));
        $("#totalIvaS").text(conComas(ttotalIvaS.toFixed(2)));
        $("#retencionIva").val(conComas(tretencionIvaB.toFixed(2)));
        $("#retencionIR").val(conComas(tretencionIRB.toFixed(2)));
        $("#retencionIvaS").val(conComas(tretencionIvaS.toFixed(2)));
        $("#retencionIRS").val(conComas(tretencionIRS.toFixed(2)));
        $("#valorAnticipo").text(conComas(tvalorAnticipo.toFixed(2)));
        $("#totalAmortizado").text(conComas(ttotalamortizado.toFixed(2)));
        $("#saldoAmortizar").text(conComas(tsaldoAmortizar.toFixed(2)));
    });
//DATOS GENERALES


$("#btnGuardar").on('click',function(){
    var fechaLiquidacion=$("#fechaLiquidacion").val(); 
    if(fechaLiquidacion==null || fechaLiquidacion=='')
    {
        alertToast("Debe colocar como minimo Fecha del Contrato",3500);
        return false;
    }
    var totalrecursos=ArregloTipoContratoD;
    var fechaLiquidacion=$("#fechaLiquidacion").val(); 
    var beneficiario=$("#beneficiario").val(); 
    var tipoContrato=$("#tipoContrato").val(); 
    var contrato=$("#contrato").val(); 
    var valorContrato=$("#valorContrato").val(); 
    var objetoContrato=$("#objetoContrato").val(); 
    var observaciones=$("#observaciones").val(); 
    var Area=$("#Area").val();
    var NumeroPlanilla =$("#NumeroPlanilla").val();
    var Garante=$("#Garante").val();
    var datefilterPeriodo=$("#datefilterPeriodo").val();
    var valorPlanilla=$("#valorPlanilla").val();
    var anticipo=$("#anticipo").val();
    var amortizacion=$("#amortizacion").val();
    var amortizacionAcumulada=$("#amortizacionAcumulada").val();
    var actualAmortizacion=$("#actualAmortizacion").val();
    var totalAmortizado=$("#totalAmortizado").text();
    var saldoAmortizar=$("#saldoAmortizar").text();
    var valorAnticipo=$("#valorAnticipo").text();
//bienes    
    var serieFacturaid=$("#serieFacturaid").val();
    var datefilterFactura=$("#datefilterFactura").val();
    var NumeroFactura=$("#NumeroFactura").val();
    var baseNoGrav=$("#baseNoGrav").val();
    var baseCero=$("#baseCero").val();
    var baseDoce=$("#baseDoce").val();
    var iva=$("#iva").val();
    var totalIva=$("#totalIva").text();
    var codRetIVA=$("#codRetIVA").val();
    var retencionIva=$("#retencionIva").val();
    var baseseguros=$("#baseseguros").val();
    var baseImp=$("#baseImp").val();
    var codRetIR=$("#codRetIR").val();
    var utilidadConsultoria=$('#utilidadConsultoria').prop('checked')?'SI':'NO';
    var retencionIR=$("#retencionIR").val();
    var baseIR=$("#baseIR").val();
    //servicios
    var serieFacturaidS=$("#serieFacturaidS").val();

    var datefilterFacturaS=$("#datefilterFacturaS").val();
    var NumeroFacturaS=$("#NumeroFacturaS").val();
    var baseNoGravS=$("#baseNoGravS").val();
    var baseCeroS=$("#baseCeroS").val();
    var baseDoceS=$("#baseDoceS").val();
    var ivaS=$("#ivaS").val();
    var totalIvaS=$("#totalIvaS").text();
    var codRetIVAS=$("#codRetIVAS").val();
    var retencionIvaS=$("#retencionIvaS").val();
    var basesegurosS=$("#basesegurosS").val();
    var baseImpS=$("#baseImpS").val();
    var codRetIRS=$("#codRetIRS").val();
    var utilidadConsultoriaS=$('#utilidadConsultoriaS').prop('checked')?'SI':'NO';
    var retencionIRS=$("#retencionIRS").val();
    var baseIRS=$("#baseIRS").val();

    //siguiente tab
    var CreditoExterno=$("#CreditoExterno").val();
    var RecursosVirtuales=$("#RecursosVirtuales").val();
    var Autogestion=$("#Autogestion").val();
    var RecursosFiscales=$("#RecursosFiscales").val();
    var NroCertificacion=$("#NroCertificacion").val();
    var TipoGasto=$("#TipoGasto").val();
    var Item =$("#Item").val();
    var Fuente=$("#Fuente").val();
    var Recurso=ArregloRecurso;
    var PlantillaPie=ArregloPlantillaPie;
    var FCreditoExterno=$("#FCreditoExterno").val();
    var FRecursosVirtuales=$("#FRecursosVirtuales").val();
    var FAutogestion=$("#FAutogestion").val();
    var FRecursosFiscales=$("#FRecursosFiscales").val();
   ///RECURSOS BID Y 998
    var FRecursosBID=$("#FRecursosBID").val();
    var FRecursos998=$("#FRecursos998").val();
    var Recursos998=$("#Recursos998").val();
    var RecursosBID=$("#RecursosBID").val();

    //DESCUENTOS
    var descNotasDebito=$("#descNotasDebito").val();
    var descart34=$("#descart34").val();
    var descmultas=$("#descmultas").val();
    var descotros=$("#descotros").val();
    var totaldescuentos=$("#totaldescuentos").val();

    //CREDITO EXT LIQ.
    var amortizacionFiscal=$("#amortizacionFiscal").val();
    var amortizacionExterna=$("#amortizacionExterna").val();
   
    var pvalorce=$("#pvalorce").val();
    var pvalorcf=$("#pvalorcf").val();

    var id=$("#id").val(); 

    var data= new FormData();
    data.append('Recurso', Recurso);
    data.append('fechaLiquidacion', fechaLiquidacion);
    data.append('beneficiario', beneficiario);
    data.append('tipoContrato', tipoContrato);
    data.append('contrato', contrato);
    data.append('valorContrato', valorContrato);
    data.append('objetoContrato', objetoContrato);
    data.append('observaciones', observaciones);
    data.append('Area', Area);
    ///////////////////////////////////
    data.append('NumeroPlanilla', NumeroPlanilla);
    data.append('Garante', Garante);
    data.append('datefilterPeriodo', datefilterPeriodo);
    data.append('valorPlanilla', valorPlanilla);
    data.append('anticipo', anticipo);
    data.append('amortizacion', amortizacion);
    data.append('amortizacionAcumulada', amortizacionAcumulada);
    data.append('actualAmortizacion', actualAmortizacion);
    data.append('totalAmortizado', totalAmortizado); 
    data.append('saldoAmortizar', saldoAmortizar);
    data.append('valorAnticipo', valorAnticipo);
//bienes
    data.append('serieFacturaid', serieFacturaid);
    data.append('datefilterFactura', datefilterFactura);
    data.append('NumeroFactura', NumeroFactura);
    data.append('baseNoGrav', baseNoGrav);
    data.append('baseCero', baseCero);
    data.append('baseDoce', baseDoce);
    data.append('iva', iva);
    data.append('totalIva', totalIva);
    data.append('codRetIVA', codRetIVA);
    data.append('retencionIva', retencionIva);
    data.append('baseseguros', baseseguros);
    data.append('baseImp', baseImp);
    data.append('codRetIR', codRetIR);
    data.append('utilidadConsultoria', utilidadConsultoria);
    data.append('retencionIR', retencionIR);
    data.append('baseIR', baseIR);
//servicios
    data.append('serieFacturaidS', serieFacturaidS);
    data.append('datefilterFacturaS', datefilterFacturaS);
    data.append('NumeroFacturaS', NumeroFacturaS);
    data.append('baseNoGravS', baseNoGravS);
    data.append('baseCeroS', baseCeroS);
    data.append('baseDoceS', baseDoceS);
    data.append('ivaS', ivaS);
    data.append('totalIvaS', totalIvaS);
    data.append('codRetIVAS', codRetIVAS);
    data.append('retencionIvaS', retencionIvaS);
    data.append('basesegurosS', basesegurosS);
    data.append('baseImpS', baseImpS);
    data.append('codRetIRS', codRetIRS);
    data.append('utilidadConsultoriaS', utilidadConsultoriaS);
    data.append('retencionIRS', retencionIRS);
    data.append('baseIRS', baseIRS);

//siguiente tab
    data.append('CreditoExterno', CreditoExterno);
    data.append('RecursosVirtuales', pvalorce);
    data.append('Autogestion', Autogestion);
    data.append('RecursosFiscales', RecursosFiscales);
    //RECURSOS BID Y 998
    data.append('RecursosBID', RecursosBID);
    data.append('Recursos998', Recursos998);

    data.append('totalrecursos', totalrecursos);
    data.append('NroCertificacion', NroCertificacion);
    data.append('TipoGasto', TipoGasto);
    data.append('Item', Item);
    data.append('Fuente', Fuente);

    data.append('PlantillaPie', PlantillaPie);
    data.append('FCreditoExterno', FCreditoExterno);
    data.append('FRecursosVirtuales', pvalorcf);
    data.append('FAutogestion', FAutogestion);
    data.append('FRecursosFiscales', FRecursosFiscales);
     //FUENTE RECURSOS BID Y 998
    data.append('FRecursosBID', FRecursosBID);
    data.append('FRecursos998', FRecursos998);

    data.append('id', id);

    //DESCUENTOS

    data.append('descotros', descotros);
    data.append('totaldescuentos', totaldescuentos); 
    data.append('descmultas', descmultas);
    data.append('descart34', descart34); 
    data.append('descNotasDebito', descNotasDebito);

    //CREDITO EXT. LIQ
    data.append('amortizacionFiscal', amortizacionFiscal);
    data.append('amortizacionExterna', amortizacionExterna);


    var objApiRest = new AJAXRestFilePOST('/financiera/savePago',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message,3500);
            $("#btnCancelar").click();
            BuscarFechaD();
            //location.reload();
        } else {
            alertToast(_resultContent.message,3500);

        }
    });


});
$('[name="plantillaPie[]"]').click(function() {
      
    var arr = $('[name="plantillaPie[]"]:checked').map(function(){
      return this.value;
    }).get();
    ArregloPlantillaPie= arr.join(',');  
});
$('[name="recursos[]"]').click(function() {
      
    var arr = $('[name="recursos[]"]:checked').map(function(){
      return this.value;
    }).get();
    ArregloRecurso= arr.join(',');  
});
$('[name="tipoContratoD"]').click(function() {
    var arr = $('[name="tipoContratoD"]:checked').map(function(){
      return this.value;
    }).get();
    var arr2=arr==""?$("#creditoexternoCompleto").addClass("hidden"):$("#creditoexternoCompleto").removeClass("hidden");
    ArregloTipoContratoD= arr;  
});



$("#beneficiario").on("change",function(){
    var valor=$(this).val();
    if(valor==null || valor=='')
    $("#borrabeneficiario").hide();
    else
    $("#borrabeneficiario").show();
});
function agregabeneficiario()
{
    $("#divbeneficiario").hide();
    $("#divagregabeneficiario").show();
}
function retornabeneficiario(){
    $("#divagregabeneficiario").hide();
    $("#divbeneficiario").show();
}

function grababeneficiario(){
    var data= new FormData();
    var identificacion=$("#identificacionbeneficiarioagrega").val();
    var beneficiario=$("#nombrebeneficiarioagrega").val();

    if(identificacion==null||beneficiario==null||identificacion==''||beneficiario=='')
    {
        alertToast("Debe tener lleno los campos de identificaci&oacute;n y Nombre del Beneficiario",3500);
        return false;
    }
    data.append('identificacion',identificacion);
    data.append('beneficiario',beneficiario);
    var objApiRest = new AJAXRestFilePOST('/financiera/agregaBeneficiarios',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message,3500);
             nuevoBeneficiario=beneficiario;
             cargarBeneficiarios();
             identificacion=$("#identificacionbeneficiarioagrega").val('');
             beneficiario=$("#nombrebeneficiarioagrega").val('');
             retornabeneficiario();
        } else{
            alertToast(_resultContent.message,3500);
        }
    });
}
function borrarbeneficiario()
{
    var id=$("#beneficiario").val();
    var data= new FormData();
    data.append('id',id);

    var objApiRest = new AJAXRestFilePOST('/financiera/borrarBeneficiario',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            cargarBeneficiarios();
            alertToastSuccess(_resultContent.message,3500);
        }else{
            alertToast(_resultContent.message,3500);
        }

    });
}
function cargarContratos()
{
    var data= new FormData();
    var objApiRest = new AJAXRestFilePOST('/financiera/tiposContratos',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            tiposContratos=_resultContent.message;
        } 
    });

}

function limpiar() {
    modal.style.display = "block";

    $(".form-control").each(function(){	
			$($(this)).val('');
	});
    $("#Modalagregar").show();
    $("#nuevoRegistro").click();
    $("#id").val(0);
    //select
    $("#beneficiario").val('').change(); 
    $("#tipoContrato").val('').change(); 
    $("#codRetIR").val('').change(); 
    $("#codRetIVA").val('').change(); 
    $("#codRetIRS").val('').change(); 
    $("#codRetIVAS").val('').change(); 
    $("#TipoRecurso").val('').change(); 
    $("#TipoGasto").val('').change(); 
    $("#Area").val('').change(); 
    //span text
    $("#totalIva").text('0.00');  
    $("#totalAmortizado").text('0.00');  
    $("#saldoAmortizar").text('0.00');  
    $("#valorAnticipo").text('0.00');  
  
    //textarea
    $("#objetoContrato").html(''); 
    $("#observaciones").html(''); 
    $("#descripcionretIva").html(''); 
    $("#descripcionretIR").html(''); 
    $("#descripcionretIvaS").html(''); 
    $("#descripcionretIRS").html(''); 
    $("#Fuente").html(''); 
    $("#Item").html(''); 
    $("#tipoContrato").val(7).change();
    document.getElementById("recursosF").checked=false;

}
function buscarContrato(){
    var data= new FormData();
    var contrato=$("#contrato").val();
    if(contrato==null||contrato=="")
    {
        alertToast("Debe de Ingresar un Numero de Contrato",3500);
        return false;
    }
    data.append('contrato',contrato);
    var objApiRest = new AJAXRestFilePOST('/financiera/buscarcontratos',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            datosContratos=_resultContent.message;
            var data=datosContratos;
            if(data!=null){
                $("#beneficiario").val(data['beneficiarioId']).change(); 
                $("#tipoContrato").val(data['tipoContratoId']).change();
                $("#valorContrato").val(data['valorContrato']); 
                $("#objetoContrato").val(data['objetoContrato']); 
                $("#observaciones").val(data['observacion']); 
                $("#Area").val(data['areaSolicitanteId']).change();
                $("#anticipo").val(data['anticipo']);
                $("#amortizacion").val(data['amortizacion']);
                $("#amortizacionAcumulada").val(data['totalAmortizacion']);
                if(data['recursosExternosFiscales']!=null)
                {
                    document.getElementById("recursosF").checked=data['recursosExternosFiscales'].includes("A")?true:false;
                    ArregloRecurso=data['recursosExternosFiscales'];
                }else{
                    document.getElementById("recursosF").checked=false;

                }
            }else{
                alertToast("No se encuentran datos del Contrato",3500);
            }
        } 
    });
}
function Buscar() {
    var objApiRest = new AJAXRest('/financiera/datatablePago/', {}, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            var dt = {
                draw: 1,
                recordsFiltered: _resultContent.datos.length,
                recordsTotal: _resultContent.datos.length,
                data: _resultContent.datos
            };
            datosPagoArray=_resultContent.datos;
            
            $('#tbobymenu').show();
            $.fn.dataTable.ext.errMode = 'throw';
            $("#dtmenu").dataTable({
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend:    'copyHtml5',
                        text:      '<i class="fa fa-files-o"></i>',
                        titleAttr: 'Copy'
                    },
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel'
                    },
                    {
                        extend:    'csvHtml5',
                        text:      '<i class="fa fa-file-text-o"></i>',
                        titleAttr: 'CSV'
                    },
                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'PDF'
                    }
                ],
                "lengthMenu": [[5, -1], [5, "TODOS"]],
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "draw": dt.draw,
                "recordsFiltered": dt.recordsFiltered,
                "recordsTotal": dt.recordsTotal,
                "data": dt.data,
                "order": [[1, "desc"]],

                "columnDefs": [
                    { "targets": [0], "orderable": true }
                ],
                "columns": [
                            {title:'N&deg;',data: 'id', "width": "10%"},
                            {title:'Fecha Contrato',data: 'fechaLiquidacion', "width": "5%"
                                ,"render": function (data, type, row) {
                                    return row.fechaLiquidacion!=null?row.fechaLiquidacion:'--';
                                }
                            },
                            {title:'Tipo Contrato',data: 'tipoContrato', "width": "10%"
                                ,"render": function (data, type, row) {
                                    return row.tipoContrato!=null?row.tipoContrato.toUpperCase():'--';
                                }
                            },

                            {title:'Objeto/Contrato',data: 'objetoContrato', "width": "15%"
                                ,"render": function (data, type, row) {
                                    var objetoContrato='--';
                                    if(row.objetoContrato!=null)
                                    objetoContrato=row.objetoContrato.length>100?row.objetoContrato.substring(0,100)+'<strong>..........</strong>':row.objetoContrato;
                                    return '<span style="text-align:justify">'+objetoContrato.toUpperCase()+'</span>';
                                }
                            },
                            {title:'Contrato',data: 'contrato', "width": "10%"
                                ,"render": function (data, type, row) {
                                    var Contrato=row.contrato!=null?row.contrato:'--';
                                    return '<span style="text-align:justify">'+Contrato.toUpperCase()+'</span>';
                                }
                            },
                            {title:'Beneficiario',data: 'beneficiario', "width": "10%"
                                ,"render": function (data, type, row) {
                                    var beneficiario=row.beneficiario!=null?row.beneficiario:'--';
                                    return '<span style="text-align:justify">'+beneficiario.toUpperCase()+'</span>';
                                }
                            },
                            {title:'Valor/Contrato',data: 'valorContrato', "width": "10%"
                                ,"render": function (data, type, row) {
                                    var v=row.valorContrato!=null?row.valorContrato:'0.00';
                                    return '<span style="float:left">$</span>'+'<span style="float:right">'+v+'</span>';
                                }
                            }, 
                            {title:'Total/Ingresos',data: 'total', "width": "15%"
                                ,"render": function (data, type, row) {
                                    var v=row.total!=null!=null?Number(row.total.replace(/[^0-9.-]+/g,"")):0.00;
                                    v=v.toFixed(2);
                                    return '<span style="float:left">$</span>'+'<span style="float:right">'+conComas(v)+'</span>';
                                }
                        
                            },
                            {title:'Total/Descuentos',data: 'totaldescuentos', "width": "10%"
                            ,"render": function (data, type, row) {
                              //  var v=row.total!=null?Number(row.total.replace(/[^0-9.-]+/g,"")):0.00;
                               // var v1=row.totalS!=null?Number(row.totalS.replace(/[^0-9.-]+/g,"")):0.00;
                                var descuentos=row.totaldescuentos!=null?Number(row.totaldescuentos.replace(/[^0-9.-]+/g,"")):0.00;
                            
                                var retencionIvaS=row.retencionIvaS!=null?Number(row.retencionIvaS.replace(/[^0-9.-]+/g,"")):0.00;
                                var retencionIva=row.retencionIva!=null?Number(row.retencionIva.replace(/[^0-9.-]+/g,"")):0.00;

                                var valorRetenciosIrS=row.valorRetenciosIrS!=null?Number(row.valorRetenciosIrS.replace(/[^0-9.-]+/g,"")):0.00;
                                var valorRetenciosIr=row.valorRetenciosIr!=null?Number(row.valorRetenciosIr.replace(/[^0-9.-]+/g,"")):0.00;


                                //var tt=v+v1;
                                var totalrecibir=descuentos+valorRetenciosIrS+valorRetenciosIr+retencionIva+retencionIvaS;

                                totalrecibir=totalrecibir.toFixed(2);
                                return '<span style="float:left">$</span>'+'<span style="float:right">'+conComas(totalrecibir)+'</span>';
                            }
                    },
                    {title:'Total a Recibir', "width": "10%"
                        ,"render": function (data, type, row) {
                            var v=row.total!=null?Number(row.total.replace(/[^0-9.-]+/g,"")):0.00;
                            var v1=row.totalS!=null?Number(row.totalS.replace(/[^0-9.-]+/g,"")):0.00;
                            var descuentos=row.totaldescuentos!=null?Number(row.totaldescuentos.replace(/[^0-9.-]+/g,"")):0.00;
                           
                            var retencionIvaS=row.retencionIvaS!=null?Number(row.retencionIvaS.replace(/[^0-9.-]+/g,"")):0.00;
                            var retencionIva=row.retencionIva!=null?Number(row.retencionIva.replace(/[^0-9.-]+/g,"")):0.00;

                            var valorRetenciosIrS=row.valorRetenciosIrS!=null?Number(row.valorRetenciosIrS.replace(/[^0-9.-]+/g,"")):0.00;
                            var valorRetenciosIr=row.valorRetenciosIr!=null?Number(row.valorRetenciosIr.replace(/[^0-9.-]+/g,"")):0.00;


                            var tt=v+v1;
                            var totalrecibir=tt-(descuentos+valorRetenciosIrS+valorRetenciosIr+retencionIva+retencionIvaS);

                            totalrecibir=totalrecibir.toFixed(2);
                            return '<span style="float:left">$</span>'+'<span style="float:right">'+conComas(totalrecibir)+'</span>';
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
                                  return '<a href="#" onclick="Actualizar(\'' + row.id + '\');" data-hover="tooltip" data-placement="top"'+ 
                                                    'data-target="#Modalagregar" data-toggle="modal" id="modal"'+
                                                    'class="label label-primary">'+
                                                    '<span class="glyphicon glyphicon-edit"></span></a>'+
                                                    '<a href="#" onclick="PedirConfirmacion(\'' + row.id + '\',\'eliminar\');"'+
                                                    'class="label label-danger">'+
                                                    '<span class="glyphicon glyphicon-trash"></span></a>'+
                                                    '<a href="#" onclick="imprimirDiv(\'' + row.id + '\');"'+
                                                    'class="label label-primary">'+
                                                    '<span class="glyphicon glyphicon-print"></span></a>'
                                                    ;
                              }
                          }

                ],
            });

        } else {
            alertToast("ERROR AL CARGAR DATOS.", 3500);
        }
    });
     
  }
  function BuscarFechaD() {
    var fecha=$("#fechaconsulta").val();
   /* if($('#tbobymenu').html()!='')
    {
        $('#dtmenu').DataTable().destroy();
        $('#tbobymenu').html('');
    }*/
    if(fecha==""||fecha==null)
    Buscar();
    else
    BuscarFecha();
  }

function BuscarFecha() {
   //  alert("cargando..");
    var fecha=$("#fechaconsulta").val();

    data = new FormData();
    data.append('fecha', fecha);
    var objApiRest = new AJAXRestFilePOST('/financiera/getDatatableFecha', data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            var dt = {
                draw: 1,
                recordsFiltered: _resultContent.datos.length,
                recordsTotal: _resultContent.datos.length,
                data: _resultContent.datos
            };
            datosPagoArray=_resultContent.datos;
            $("#tablaConsulta").attr('style','margin-top:50px');

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
                        exportOptions: {
                            columns: [0, 1,2,3,4,5,6,7,8,9,10] //exportar solo la primera y segunda columna
                        },
                        title:'.',
                        footer: true,
                        pageSize: 'A4',
                        filename:'Epacore- Control Previo',
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
                            {title:'Fecha de Liquidaci&oacute;n',data: 'fechaLiquidacion', "width": "5%"
                                ,"render": function (data, type, row) {
                                    return row.fechaLiquidacion!=null?row.fechaLiquidacion:'--';
                                }
                            },
                            {title:'Ord&eacute;n Gasto',data: 'fuente', "width": "5%"
                                ,"render": function (data, type, row) {
                                    return row.fuente!=null?row.fuente.toUpperCase():'--';
                                }
                           },
                            {title:'Tipo Contrato',data: 'tipoContrato', "width": "10%"
                                ,"render": function (data, type, row) {
                                    return row.tipoContrato!=null?row.tipoContrato.toUpperCase():'--';
                                }
                            },

                            {title:'Objeto de Contrato',data: 'objetoContrato', "width": "15%"
                                ,"render": function (data, type, row) {
                                    var objetoContrato='--';
                                    if(row.objetoContrato!=null)
                                    objetoContrato=row.objetoContrato.length>100?row.objetoContrato.substring(0,100)+'<strong>..........</strong>':row.objetoContrato;
                                    return '<span style="text-align:justify">'+objetoContrato.toUpperCase()+'</span>';
                                }
                            },
                            {title:'Contrato',data: 'contrato', "width": "10%"
                                ,"render": function (data, type, row) {
                                    var Contrato=row.contrato!=null?row.contrato:'--';
                                    return '<span style="text-align:justify">'+Contrato.toUpperCase()+'</span>';
                                }
                            },
                            {title:'Beneficiario',data: 'beneficiario', "width": "10%"
                                ,"render": function (data, type, row) {
                                    var beneficiario=row.beneficiario!=null?row.beneficiario:'--';
                                    return '<span style="text-align:justify">'+beneficiario.toUpperCase()+'</span>';
                                }
                            },
                            {title:'Valor de Contrato',data: 'valorContrato', "width": "10%"
                                ,"render": function (data, type, row) {
                                    var v=row.valorContrato!=null?row.valorContrato:'0.00';
                                    return '<span style="float:left">$</span>'+'<span style="float:right">'+v+'</span>';
                                }
                            }, 
                            {title:'Total de Ingresos',data: 'total', "width": "15%"
                                ,"render": function (data, type, row) {

                                    var baseNoGrav= row.baseNoGravable!=null?Number(row.baseNoGravable.replace(/[^0-9.-]+/g,"")):0.00;
                                    var baseCero= row.baseCero!=null?Number(row.baseCero.replace(/[^0-9.-]+/g,"")):0.00;
                                    var baseDoce= row.baseDoce!=null?Number(row.baseDoce.replace(/[^0-9.-]+/g,"")):0.00;
                                    var iva= row.iva!=null?Number(row.iva.replace(/[^0-9.-]+/g,"")):0.00;

                                    var baseNoGravS= row.baseNoGravableS!=null?Number(row.baseNoGravableS.replace(/[^0-9.-]+/g,"")):0.00;
                                    var baseCeroS= row.baseCeroS!=null?Number(row.baseCeroS.replace(/[^0-9.-]+/g,"")):0.00;
                                    var baseDoceS= row.baseDoceS!=null?Number(row.baseDoceS.replace(/[^0-9.-]+/g,"")):0.00;
                                    var ivaS= row.ivaS!=null?Number(row.ivaS.replace(/[^0-9.-]+/g,"")):0.00;

                                    var v=baseNoGrav+baseCero+baseDoce+iva+baseNoGravS+baseCeroS+baseDoceS+ivaS;
                                    var totalrecibir=v.toFixed(2);
                                    return '<span style="float:left">$</span>'+'<span style="float:right">'+conComas(totalrecibir)+'</span>';
                                }
                        
                            },
                            {title:'Total de Descuentos',data: 'totaldescuentos', "width": "10%"
                            ,"render": function (data, type, row) {
                                var descuentos=row.totaldescuentos!=null?Number(row.totaldescuentos.replace(/[^0-9.-]+/g,"")):0.00;
                            
                                var retencionIvaS=row.retencionIvaS!=null?Number(row.retencionIvaS.replace(/[^0-9.-]+/g,"")):0.00;
                                var retencionIva=row.retencionIva!=null?Number(row.retencionIva.replace(/[^0-9.-]+/g,"")):0.00;

                                var valorRetenciosIrS=row.valorRetenciosIrS!=null?Number(row.valorRetenciosIrS.replace(/[^0-9.-]+/g,"")):0.00;
                                var valorRetenciosIr=row.valorRetenciosIr!=null?Number(row.valorRetenciosIr.replace(/[^0-9.-]+/g,"")):0.00;
                                var totalrecibir=descuentos+valorRetenciosIrS+valorRetenciosIr+retencionIva+retencionIvaS;

                                totalrecibir=totalrecibir.toFixed(2);
                                return '<span style="float:left">$</span>'+'<span style="float:right">'+conComas(totalrecibir)+'</span>';
                            }
                    },
                    {title:'Total a Recibir', "width": "10%"
                        ,"render": function (data, type, row) {
                            var v=row.total!=null?Number(row.total.replace(/[^0-9.-]+/g,"")):0.00;
                            var v1=row.totalS!=null?Number(row.totalS.replace(/[^0-9.-]+/g,"")):0.00;
                            var descuentos=row.totaldescuentos!=null?Number(row.totaldescuentos.replace(/[^0-9.-]+/g,"")):0.00;
                           
                            var retencionIvaS=row.retencionIvaS!=null?Number(row.retencionIvaS.replace(/[^0-9.-]+/g,"")):0.00;
                            var retencionIva=row.retencionIva!=null?Number(row.retencionIva.replace(/[^0-9.-]+/g,"")):0.00;

                            var valorRetenciosIrS=row.valorRetenciosIrS!=null?Number(row.valorRetenciosIrS.replace(/[^0-9.-]+/g,"")):0.00;
                            var valorRetenciosIr=row.valorRetenciosIr!=null?Number(row.valorRetenciosIr.replace(/[^0-9.-]+/g,"")):0.00;


                            var tt=v+v1;
                            var totalrecibir=tt-(descuentos+valorRetenciosIrS+valorRetenciosIr+retencionIva+retencionIvaS);

                            totalrecibir=totalrecibir.toFixed(2);
                            return '<span style="float:left">$</span>'+'<span style="float:right">'+conComas(totalrecibir)+'</span>';
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
                                      return '<a href="#" onclick="Actualizar(\'' + row.id + '\');" id="myBtnEdit"'+ 
                                                        'class="label label-primary">'+
                                                        '<span class="glyphicon glyphicon-edit"></span></a>'+
                                                        '<a href="#" onclick="PedirConfirmacion(\'' + row.id + '\',\'eliminar\');"'+
                                                        'class="label label-danger">'+
                                                        '<span class="glyphicon glyphicon-trash"></span></a>'+
                                                        '<a href="#" onclick="imprimirDiv(\'' + row.id + '\');"'+
                                                        'class="label label-primary">'+
                                                        '<span class="glyphicon glyphicon-print"></span></a>'
                                                        ;
                                  }
                              },

                ],
            });

        } else {
            alertToast(_resultContent.message, 3500);
        }
    });
     
  }

function Actualizar(id)
{
    

    retornabeneficiario();
   var data = $.grep(datosPagoArray, function (element, index) {
        return element.id == id;
    });
    data=data[0];
 
    $("#fechaLiquidacion").val(data['fechaLiquidacion']); 
    $("#beneficiario").val(data['beneficiarioId']).change(); 
    $("#tipoContrato").val(data['tipoContratoId']).change();
    $("#contrato").val(data['contrato']); 
    $("#valorContrato").val(data['valorContrato']); 
    $("#objetoContrato").val(data['objetoContrato']); 
    $("#observaciones").val(data['observacion']); 
    $("#Area").val(data['areaSolicitanteId']).change();
    $("#NumeroPlanilla").val(data['numeroPlanilla']);
    $("#Garante").val(data['garante']);
    $("#datefilterPeriodo").val(data['periodoPlanilla']);
    $("#valorPlanilla").val(data['valorPlanilla']);
    $("#anticipo").val(data['anticipo']);
    $("#amortizacion").val(data['amortizacion']);
    $("#amortizacionAcumulada").val(data['valorAmortizacionAcumulada']);
    $("#actualAmortizacion").val(data['valorActualAmortizacion']);
    $("#totalAmortizado").text(data['totalAmortizacion']);
    $("#saldoAmortizar").text(data['saldoAmortizar']);
    $("#valorAnticipo").text(data['valorAnticipo']);
    ///BIENES 
    $("#serieFacturaid").val(data['serieFacturaid']);
    $("#amortizacionFiscal").val(data['amortizacionFiscal']);
    $("#datefilterFactura").val(data['fechaFactura']);
    $("#NumeroFactura").val(data['numeroFactura']);
    $("#baseNoGrav").val(data['baseNoGravable']!="0"?data['baseNoGravable']:0);
    $("#baseCero").val(data['baseCero']!="0"?data['baseCero']:0);
    $("#baseDoce").val(data['baseDoce']!="0"?data['baseDoce']:0);
    var baseNoGrav= Number($("#baseNoGrav").val().replace(/[^0-9.-]+/g,""));
    var baseCero= Number($("#baseCero").val().replace(/[^0-9.-]+/g,""));
    var baseDoce= Number($("#baseDoce").val().replace(/[^0-9.-]+/g,""));
    var iva= Number($("#iva").val().replace(/[^0-9.-]+/g,""));
    var totalBases=baseNoGrav+baseCero+baseDoce;
    totalBases=totalBases>0?totalBases.toFixed(2):'0.00';
    $("#totalBases").val(conComas(totalBases));
    $("#iva").val(data['iva']);
    $("#ingresos").val(conComas(data['total']));
    $("#totalIva").text(conComas(data['total']));
    $("#codRetIVA").val(data['codigoRetencionIvaId']).change();
    $("#retencionIva").val(data['retencionIva']);
    $("#baseseguros").val(data['baseSeguros']);
    $("#baseImp").val(data['baseImponible']);
    $("#codRetIR").val(data['codigoRetencionIrId']).change();
    $("#utilidadConsultoria").val(data['utilidadConsultoria']);
    $("#retencionIR").val(data['valorRetenciosIr']);
    $("#baseIR").val(data['baseIR']);
    //SERVICIOS
    $("#serieFacturaidS").val(data['serieFacturaidS']);

     $("#amortizacionExterna").val(data['amortizacionExterna']);
     $("#datefilterFacturaS").val(data['fechaFacturaS']);
     $("#NumeroFacturaS").val(data['numeroFacturaS']);
      $("#baseNoGravS").val(data['baseNoGravableS']!="0"?data['baseNoGravableS']:0);
     $("#baseCeroS").val(data['baseCeroS']!="0"?data['baseCeroS']:0);
     $("#baseDoceS").val(data['baseDoceS']!="0"?data['baseDoceS']:0);
     var baseNoGravS= Number($("#baseNoGravS").val().replace(/[^0-9.-]+/g,""));
     var baseCeroS= Number($("#baseCeroS").val().replace(/[^0-9.-]+/g,""));
     var baseDoceS= Number($("#baseDoceS").val().replace(/[^0-9.-]+/g,""));
     var ivaS= Number($("#ivaS").val().replace(/[^0-9.-]+/g,""));
     var totalBasesS=baseNoGravS+baseCeroS+baseDoceS;
     totalBasesS=totalBasesS>0?totalBasesS.toFixed(2):'0.00';
     $("#totalBasesS").val(conComas(totalBasesS));
     $("#ivaS").val(data['ivaS']);
     $("#totalIvaS").text(data['totalS']);
     $("#codRetIVAS").val(data['codigoRetencionIvaIdS']).change();
     $("#retencionIvaS").val(data['retencionIvaS']);
     $("#basesegurosS").val(data['baseSegurosS']);
     $("#baseImpS").val(data['baseImponibleS']);
     $("#codRetIRS").val(data['codigoRetencionIrIdS']).change();
     $("#retencionIRS").val(data['valorRetenciosIrS']);
     $("#baseIRS").val(data['baseIRS']);

    $("#CreditoExterno").val(data['creditoExterno']);

    $("#RecursosVirtuales").val(data['recursosVirtuales']);
    $("#FRecursosVirtuales").val(data['fuenterecursosVirtuales']);

    
    $("#pvalorce").val(data['recursosVirtuales']);
    $("#pvalorcf").val(data['fuenterecursosVirtuales']);

    $("#Autogestion").val(data['autogestion']);
    $("#RecursosFiscales").val(data['recursosFiscales']);
    $("#FCreditoExterno").val(data['fuentecreditoExterno']);
    $("#FAutogestion").val(data['fuenteautogestion']);
    $("#FRecursosFiscales").val(data['fuenterecursosFiscales']);
    $("#NroCertificacion").val(data['numeroCertificacion']);
    $("#TipoGasto").val(data['tipoGastoId']).change();
    $("#Item").val(data['item']);
    $("#Fuente").val(data['fuente']);

    $("#Recursos998").val(data['recursos998']);
    $("#RecursosBID").val(data['recursosBID']);
    $("#FRecursosBID").val(data['fuenterecursosBID']);
    $("#FRecursos998").val(data['fuenterecursos998']);

    $("#descNotasDebito").val(data['descNotasDebito']);
    $("#descotros").val(data['descotros']);
    $("#descart34").val(data['descart34']);
    $("#descmultas").val(data['descmultas']);
    $("#totaldescuentos").val(data['totaldescuentos']);

    var id=$("#id").val(data['id']); 
    
//RECURSOS   
if(data['recursosExternosFiscales']!=null)
{
    document.getElementById("recursosF").checked=data['recursosExternosFiscales'].includes("A")?true:false;
    ArregloRecurso=data['recursosExternosFiscales'];
}else{
    document.getElementById("recursosF").checked=false;
}
 
if(data['plantillaPie']!=null)
{
// PLANTILLA PIE
    document.getElementById("plantillaPieElabora").checked=data['plantillaPie'].includes("E")?true:false;
    document.getElementById("plantillaPieRevisado").checked=data['plantillaPie'].includes("R")?true:false;
    ArregloPlantillaPie=data['plantillaPie'];
}else{
    document.getElementById("plantillaPieElabora").checked=false;
    document.getElementById("plantillaPieRevisado").checked=false;
}

document.getElementById("tipoContratoD").checked=false;
ArregloTipoContratoD="";
if(data['totalRecursos']!=null)
{
    document.getElementById("tipoContratoD").checked=data['totalRecursos'].includes("D")?true:false;
    var cv=data['totalRecursos'].includes("D")?$("#creditoexternoCompleto").removeClass("hidden"):$("#creditoexternoCompleto").addClass("hidden");
    ArregloTipoContratoD=data['totalRecursos'];
}
    document.getElementById("utilidadConsultoriaS").checked=data['utilidadConsultoriaS']=="SI"?true:false;
    document.getElementById("utilidadConsultoria").checked=data['utilidadConsultoria']=="SI"?true:false;

    var porcentajece= $("#pvalorce").val();
    var valorPlanillace=$("#valorPlanilla").val();
    var amortizacionce=$("#amortizacion").val();
    var porcentajecf= $("#pvalorcf").val();
    var valorPlanillacf=$("#valorPlanilla").val();
    var amortizacioncf=$("#amortizacion").val();
    /*credito externo*/
    porcentajece=porcentajece!=''?Number(porcentajece.replace(/[^0-9.-]+/g,"")):0;
    valorPlanillace=valorPlanillace!='0.00'?Number(valorPlanillace.replace(/[^0-9.-]+/g,"")):0;
    var totalce=valorPlanillace*(porcentajece/100);

    $("#valorce").val(conComas(totalce.toFixed(2)));
    totalce=totalce*(amortizacionce/100);
    $("#amortizacionExterna").val(conComas(totalce.toFixed(2)));

    /*credito fiscal*/
    porcentajecf=porcentajecf!=''?Number(porcentajecf.replace(/[^0-9.-]+/g,"")):0;
    valorPlanillacf=valorPlanillacf!='0.00'?Number(valorPlanillacf.replace(/[^0-9.-]+/g,"")):0;
    var totalcf=valorPlanillacf*(porcentajecf/100);

    $("#valorcf").val(conComas(totalcf.toFixed(2)));
    totalcf=totalcf*(amortizacioncf/100);
    $("#amortizacionFiscal").val(conComas(totalcf.toFixed(2)));

    modal.style.display = "block";
}

function Eliminar(id) {

    var objApiRest = new AJAXRest('/financiera/eliminaPago',
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

