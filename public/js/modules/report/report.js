$(document).ready(function () {
    $(function () {
        $("#Modalagregar").hide();
        $("#output").empty();
    });
});

$("#btnGuardar").on('click', function () {
    $("#output").empty();
    var fechai = $("#fechai").val();
    var fechaf = $("#fechaf").val();
    var objApiRest = new AJAXRest('/reporte/prueba', {fechai: fechai, fechaf: fechaf}, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            $("#output").pivotUI(_resultContent.message,
                {
                    derivedAttributes: {},
                    rows: ["mes"],
                    cols: ["dh"],
                });
        } else {
            $(".output").empty();
            $("#Modalagregar").hide();
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            alertToast(_resultContent.message, 3500);
        }
    });
});

function EditChanges(id, r) {

    var objApiRest = new AJAXRest('/reporte/prueba2', {id: id, r: r}, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            $("#output2").pivotUI(_resultContent.message,
                {
                    derivedAttributes: {},
                    rows: ["fecha_ing", "identificacion", "estado", "nombre", "provincia", "n_solicitud", "celular", "operadora", "tipo_solicitud", "tipo_linea"]
                });

        } else {
            $("#Modalagregar").hide();
            $(".output2").empty();
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            alertToast(_resultContent.message, 3500);

        }
    });
}

function EditChangesIntern(dato1, dato2, dato3, dato4, dato5,dato6, dato7, dato8) {
    var valida=0;

    
    if (typeof(dato3) == "undefined"&&valida==0) {
        var dato3 = '0'
        var valida=2;
    }
 
    if (typeof(dato5) == "undefined"&&valida==0) {
        var dato5 = '0'
        var valida=3;
    }

    if (typeof(dato7) == "undefined"&&valida==0) {
        var dato7 = '0'
        var valida=4;
    }
    switch(valida)
    {
        case 2:
         //cuando viene 2 campos

        var dato3=0;
        var dato4=0;
        var dato5=0;
        var dato6=0;
        var dato7=0;
        var dato8=0;

        var dato1=dato1;
        var campo2=dato2;  
       

        break;
        case 3:
         //cuando viene 4 campos

        var dato5=0;
        var dato6=0;
        var dato7=0;
        var dato8=0;

        var dato1=dato1;
        var dato2=dato2;
        var campo1=dato3;
        var campo2=dato4;
    


        break;
        case 4:
        //cuando viene 6 campos

        var dato7=0;
        var dato8=0;

        var dato1=dato1;
        var dato2=dato2;
        var dato3=dato3;
        var campo1=dato4;
        var campo2=dato5;
        var campo3=dato6;


        break;
        case 0:
        //cuando viene 8 campos
        var dato1=dato1;
        var dato2=dato2;
        var dato3=dato3;
        var dato4=dato4;
        var campo1=dato5;
        var campo2=dato6;
        var campo3=dato7;
        var campo4=dato8;
       
        break;
    }
   

}