var id = 1;
var sum = 0;
var i = 0;
var contadorObsequios = 0;


$("#btnImprimir").on('click', function () {

    var tlineas = $('[name^="tlineas"]').val();
    var ic = 0;
    var band = 0;
    var checklinea = [];
    do {
        if (document.getElementById("ddiprintc[" + ic + "]").checked == true) {
            var band = 1;
            checklinea.push(ic);
        }
        ic++;
    } while (ic < tlineas);
    alert(checklinea);
    if (band != 0) {
        var select = document.getElementById("formatos_imprimir"), //El <select>
            value = select.value, //El valor seleccionado
            text = select.options[select.selectedIndex].innerText;
        var lineas = [];
        var fecha = "";
        var hora = "";
        var otros_text = "";
        var natural = "";
        var juridico = "";
        var otros = "";
        var actual_pre = "";
        var actual_pos = "";


        var ic = 0;
        $('[name^="addcelular["]').each(function () {
            lineas.push($(this).val());
        });

        var receptor = "Claro";
        var del = "1";
        var al = parseInt(lineas.length);
        var cant_portar = parseInt(lineas.length);
        var num_anexos = "";
        var cli = $('input[name^="name_natural"]').val();
        var cli_raz = $('input[name^="razon_juridico"]').val();

        if (cli != "" && cli != null) {
            var cliente = cli;
        } else {
            var cliente = cli_raz;
        }
        if ($('input[name^="tipo_persona"]').val() == "JURIDICO") {
            var juridico = "X";
        } else {
            var natural = "X";
        }
        var razon_soc = cli_raz;
        var nom_abonado = $('input[name^="nombre_rl_juridico"]').val()
        if (typeof (razon_soc) == "undefined") {
            razon_soc = '';
        }
        if (typeof (nom_abonado) == "undefined" || nom_abonado == '' || nom_abonado == null) {
            nom_abonado = cli;
        } else {
            nom_abonado = nom_abonado;
        }
        switch (text) {
            case 'PORTABILIDAD':
                alert('PORTABILIDAD');

                var tipo_linea = $("#linea").val();

                if (tipo_linea == "Migracion") {
                    var actual_pre = "X";
                }

                if (tipo_linea == "Pospago") {
                    var actual_pos = "X";
                }

                if (tipo_linea == "Prepago") {
                    var actual_pre = "X";
                }

                var nuevo_pos = "X";
                var nuevo_pre = "";
                var nip = "";
                var donante = $("#oper").val();
                var html;
                var disp_setting = "toolbar=yes,location=no,";
                disp_setting += "directories=yes,menubar=yes,";
                disp_setting += "scrollbars=yes,width=650, height=600, left=100, top=25";
                //var contenido= document.getElementById("areaImprimir").innerHTML;
                var docprint = window.open("", "", disp_setting);
                docprint.document.open();
                html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"';
                html += '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
                html += '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">';
                html += '<head><title>Formato de Portabilidad</title>';
                html += '<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">';
                html += '</head><body><center>';
                html += '<div id="ficha_impresion"><div id="encabezado_imp"><div id="logo"><img src="/img/log_claro.jpg"></div>';
                html += '<div id="enc_titulo_imp" class=""><label>FORMATO DE SOLICITUD DE PORTABILIDAD DE NÚMEROS TELEFÓNICOS MÓVILES</label>';
                html += '</div></div><div id="container_imp" class="container"><table class="tb_print_1" style="width:90%">';
                html += '<tr><td>NÚMERO:<label>';
                html += '<input type="text" id="numero" name="numero" value="' + numero + '" class="form-control" style="width: 100px; height: 10px;">';
                html += '</label></td><td>FECHA:<label>';
                html += '<input type="text" id="fecha" name="fecha" value="' + fecha + '" class="form-control" style="width: 100px; height: 10px;">';
                html += '</label></td><td>HORA:<label>';
                html += '<input type="text" id="hora" name="hora" value="' + hora + '" class="form-control" style="width: 100px; height: 10px;">';
                html += '</label></td></tr></table><table class="tb_print" style="width:100%"><thead><tr><th colspan = "2" class="titel_section">DATOS DEL ABONADO:</th>';
                html += '</tr></thead><tbody><tr><td>PERSONA NATURAL:<label>';
                html += '<label id="nat"><input type="text" id="natural" name="natural" value="' + natural + '" style="width: 10px; height: 10px;"></label>';
                html += '</label></td><td>PERSONA JURÍDICA:<label>';
                html += '<label id="nat"><input type="text" id="juridico" name="juridico" value="' + juridico + '" style="width: 10px; height: 10px;"></label>';
                html += '</tr><tr><td >OTROS (Órganos públicos, asociaciones, gremios):</td><td ><label >';
                html += '<label id="nat"><input type="text" id="otros" name="otros" value="' + otros + '" style="width: 10px; height: 10px;"></label>';
                html += '</label><label>';
                html += '<input type="text" id="otros_text" name="otros_text" value="' + otros_text + '" class="form-control" style="width: 350px; height: 10px;">';
                html += '</td></tr><tr><td colspan = "2">NOMBRE DEL ABONADO/REPRESENTANTEN LEGAL:<label>';
                html += '<input type="text" id="nom_abonado" name="nom_abonado" value="' + nom_abonado + '" class="form-control" style="width: 343px; height: 10px;"></label></td>';
                html += '</tr><tr><td colspan = "2">RAZÓN SOCIAL:<label>';
                html += '<input type="text" id="razon_soc" name="razon_soc" value="' + razon_soc + '" class="form-control" style="width: 555px; height: 10px;"></label></td>';
                html += '</tr></tbody></table><table class="tb_print" style="width:100%"><tbody><tr><td><label>MODALIDAD DE PAGO ACTUAL:</label></td>';
                html += '<td>PREPAGO:<label>';
                html += '<label id="nat"><input type="text" id="actual_pre" name="actual_pre" value="' + actual_pre + '" style="width: 10px; height: 10px;"></label>';
                html += '<td>POSPAGO:<label>';
                html += '<label id="nat"><input type="text" id="actual_pos" name="actual_pos" value="' + actual_pos + '" style="width: 10px; height: 10px;"></label>';
                html += '</tr><tr><td><label>NUEVA MODALIDAD:</label></td><td>PREPAGO:<label>';
                html += '<label id="nat"><input type="text" id="nuevo_pre" name="nuevo_pre" value="' + nuevo_pre + '" style="width: 10px; height: 10px;"></label>';
                html += '<td>POSPAGO:<label>';
                html += '<label id="nat"><input type="text" id="nuevo_pos" name="nuevo_pos" value="' + nuevo_pos + '" style="width: 10px; height: 10px;"></label>';
                html += '</tr></tbody></table><table class="tb_print" style="width:100%"><thead>';
                html += '<tr><th>DATOS DEL PROVEEDOR DEL SERVICIO DE TELEFONÍA MÓVIL:</th></tr>';
                html += '</thead><tbody><tr><td>PRESTADOR DONANTE:<label>';
                html += '<input type="text" id="donante" name="donante" value="' + donante + '" class="form-control" style="width: 238px; height: 10px;"></label></td>';
                html += '</tr><tr><td>PRESTADOR RECEPTOR:<label>';
                html += '<input type="text" id="receptor" name="receptor" value="' + receptor + '" class="form-control" style="width: 230px; height: 10px;"></label></td>';
                html += '</tr><tr><td>NÚMERO DE IDENTIFICACIÓN PERSONAL (NIP):<label>';
                html += '<input type="text" id="nip" name="nip" value="' + nip + '" class="form-control" style="width: 100px; height: 10px;"></label></td>';
                html += '</tr></tbody></table><table class="tb_print" style="width:100%"><thead><tr><th colspan = "5">NÚMEROS A SER PORTADOS:</th>';
                html += '</tr></thead><tbody>';

                var j = 0;
                var jrow = 0;
                var k = 0;
                var krow = 0;

                if(lineas.length>4)
                {
                    krow=parseFloat(lineas.length/4);
                    jrow=1;
                }else
                {
                    krow=lineas.length;
                    jrow=1;
                }

                do {
                    html += '<tr>';
                    var y=0;
                    do {

                        html += '<td>&nbsp;&nbsp;' + parseInt(k + 1) + ':<label>';
                        html += '<input type="text" id="num_1" name="num_1" value="' + lineas[k] + '" class="form-control" style="width: 100px; height: 10px;">';
                        html += '</label></td>';
                        k++;
                        y++;
                    } while (y < 3);

                    html += '</tr>';
                    j++;
                } while (j < jrow);


                html += '</tbody></table><table class="tb_print" style="width:100%"><thead><tr><th>INTERVALO DE NÚMEROS A SER PORTADOS:</th>';
                html += '</tr></thead><tbody><tr><td>DEL:<label>';
                html += '<input type="text" id="del" name="del" value="' + del + '" class="form-control" style="width: 100px; height: 10px;"></label>';
                html += 'AL:<label>';
                html += '<input type="text" id="al" name="al" value="' + al + '" class="form-control" style="width: 100px; height: 10px;"></label></td>';
                html += '</tr><tr><td colspan = "2">CANTIDAD DE NÚMEROS A SER PORTADOS:<label>';
                html += '<input type="text" id="cant_portar" name="cant_portar" value="' + cant_portar + '" class="form-control" style="width: 137px; height: 10px;"></label></td>';
                html += '</tr><tr><td colspan = "2">NÚMERO DE DOCUMENTOS ANEXOS:<label>';
                html += '<input type="text" id="num_anexos" name="num_anexos" value="' + num_anexos + '" class="form-control" style="width: 175px; height: 10px;"></label></td>';
                html += '</tr></tbody></table><table class="tb_print" style="width:98%"><tbody><tr><td><strong>NOTAS:</strong></td></tr><tr><td colspan="2">';
                html += '<p ALIGN="justify" style="font-size: 10px;">';
                html += '“ El Abonado acepta que con la firma de la presente Solicitud de Portabilidad, manifiesta su consentimiento de terminar la relación contractual con el ';
                html += 'Prestador Donante únicamente de los  servicios de telecomunicaciones cuya prestación requiere de los números telefónicos a ser portados, a partir de la ';
                html += 'fecha efectiva en que se realice la portabilidad de los mismos”.';
                html += '</br>';
                html += '</br>';
                html += '“El Abonado acepta que el portar su(s) número(s), no lo exime del cumplimiento de las obligaciones que haya contraído por la relación contractual con ';
                html += 'el Prestador Donante. Sin perjuicio de la Portabilidad Numérica, el abonado deberá cancelar todo valor pendiente de pago que adeude al Prestador ';
                html += 'Donante relacionado con la prestación de servicios con el equipo terminal. ';
                html += '</br>';
                html += '</br>';
                html += '”El Abonado reconoce que la Portabilidad del (los) número (s) solicitada está sujeta al cumplimiento de todos los requisitos establecidos en el ';
                html += 'Reglamento para la aplicación de la Portabilidad Numérica en la Telefonía Móvil y sus Especificaciones Técnicas y Operativas “. ';
                html += '</br>';
                html += '</br>';
                html += '”El firmante declara que los datos asentados en la presente solicitud y, en su caso, los documentos que la acompañan son verdaderos “. ';
                html += '</br>';
                html += '</br>';
                html += ' El numeral 9.2 del Reglamento para la Aplicación de la Portabilidad Numérica en la Telefonía Móvil, dispone ” Cuando una solicitud de Portabilidad es ';
                html += 'rechazada, por causas imputables al abonado, establecidas en las Especificaciones Técnicas y Operativas, los costos y gastos derivados de su ';
                html += 'tramitación serán asumidos por éste. El valor para cubrir dichos costos y gastos será determinado por el Comité Técnico de Portabilidad y aprobado ';
                html += 'por el CONATEL “.';
                html += '</br>';
                html += '</br>';
                html += 'Mediante resolución No. 326-13-CONATEL-2009, el Consejo Nacional de Telecomunicaciones estableció en 4,81 dólares americanos ($4,3 + IVA) el valor ';
                html += 'que el abonado debe pagar al Prestador Receptor por solicitud de Portabilidad rechazada por causas imputables al Abonado. ';
                html += '</br>';
                html += '</br>';
                html += 'Causas de rechazo de una solicitud. entre otros: (I) La Factura presentada por el Abonado no corresponde con la emitida por el Prestador Donante, o la ';
                html += 'fecha de emisión sea mayor a 30 días contados desde la fecha de presentación al Prestador Receptor, (II) El solicitante se presentó como abonado del ';
                html += 'servicio en el esquema de Prepago y se encuentra suscrito bajo el esquema Postpago; (III) De ser aplicable, el o los números objeto de la Solicitud de ';
                html += 'Portabilidad no estén amparados en la Factura o en la porción del contrato de prestación de servicios, según sea el caso; (IV) El abonado haya realizado ';
                html += 'consumo de Roaming Internacional dentro de los 2 (dos) meses previos a la presentación de la Solicitud de Portabilidad. ';
                html += '</br>';
                html += '</br>';
                html += '”Cuando se trate de su tercera solicitud de portabilidad dentro de un año calendario (1 de enero al 31 de diciembre) el Abonado debe pagar, ';
                html += 'conjuntamente con la solicitud, el respectivo valor por la portabilidad, el mismo que no es reembolsable”. ';
                html += '</br>';
                html += '</br>';
                html += '“El cobro por el proceso de portabilidad, cuando sea aplicable, es por cada número a portar ”. ';
                html += '</br>';
                html += '</br>';
                html += '“El único  documento habilitante para la devolución de la garantía entregada por el abonado es el original del Recibo de Garantía”. ';
                html += '</br>';
                html += '</br>';
                html += '“En función de lo anterior, el abonado declara que ha revisado el contenido de la información descrita en esta solicitud, y como tal, acepta los términos ';
                html += 'y condiciones expuestas en ella.';
                html += '</br>';
                html += '</br>';
                html += '</br>';
                html += '</br>';
                html += '</p></td></tr>';
                html += '<tr aling="center"><td><label><input type="text" id="clie" name="clie" value="  ' + cliente + '" class="form-control" style="width: 300px; height: 10px;"></label></td><td><label>__________________________________________</label></td>';
                html += '</tr><tr aling="center"><td><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOMBRE DEL SUSCRIPTOR/REPRESENTANTE LEGAL</label></td><td align="center"><label>FIRMA</label></td></tr>';
                html += '</tbody></table></div></div>';
                html += '</center></body></html>';
                docprint.document.write(html);
                docprint.document.close();
                docprint.focus();


                break;
            case 'CARTA DE AUTORIZACION':
                alert('CARTA DE AUTORIZACION');
                var hoy = new Date();
                var dd = hoy.getDate();
                var yyyy = hoy.getFullYear();

                var month = new Array();
                month[0] = "Enero";
                month[1] = "Febrero";
                month[2] = "Marzo";
                month[3] = "Abril";
                month[4] = "Mayo";
                month[5] = "Junio";
                month[6] = "Julio";
                month[7] = "Agosto";
                month[8] = "Septiembre";
                month[9] = "Octubre";
                month[10] = "Noviembre";
                month[11] = "Diciembre";
                var mm = month[hoy.getMonth()];


                var cliente = $("#cliente").val();
                var ciudad = $("#ciudad").val();
                var ident = $("#identificacion").val();
                var numeros = $("#movil").val();
                var numeros1 = $("#movil1").val();
                var numeros2 = $("#movil2").val();
                var numeros3 = $("#movil3").val();
                var numeros4 = $("#movil4").val();
                var numeros5 = $("#movil5").val();
                var numeros6 = $("#movil6").val();
                var numeros7 = $("#movil7").val();
                var numeros8 = $("#movil8").val();
                var numeros9 = $("#movil9").val();
                var numeros10 = $("#movil10").val();
                var numeros11 = $("#movil11").val();
                var numeros12 = $("#movil12").val();
                var numeros13 = $("#movil13").val();
                var numeros14 = $("#movil14").val();
                var numeros15 = $("#movil15").val();
                var numeros16 = $("#movil16").val();
                var numeros17 = $("#movil17").val();
                var numeros18 = $("#movil18").val();
                var numeros19 = $("#movil19").val();
                var numerito = numeros + ' ' + numeros1 + ' ' + numeros2 + ' ' + numeros3 + ' ' + numeros4 + ' ' + numeros5 + ' ' + numeros6 + ' ' +
                    numeros7 + ' ' + numeros8 + ' ' + numeros9 + ' ' + numeros10 + ' ' + numeros11 + ' ' + numeros12 + ' ' + numeros13 + ' ' + numeros14 + ' ' +
                    numeros15 + ' ' + numeros16 + ' ' + numeros17 + ' ' + numeros18 + ' ' + numeros19;

                /*var contenido= document.getElementById("areaImprimir").innerHTML;
                var contenidoOriginal= document.body.innerHTML;

                document.body.innerHTML = contenido;
                $("#cli").val(cliente);
                $("#ced").val(ident);
                $("#ciud").val(ciudad);
                $("#dia").val(dd);
                $("#mes").val(mm);
                $("#yyyy").val(yyyy);
                $("#num").val(numeros+' '+numeros1+' '+numeros2+' '+numeros3+' '+numeros4+' '+numeros5+' '+numeros6+' '+
                numeros7+' '+numeros8+' '+numeros9+' '+numeros10+' '+numeros11+' '+numeros12+' '+numeros13+' '+numeros14+' '+
                numeros15+' '+numeros16+' '+numeros17+' '+numeros18+' '+numeros19);

                window.print();
                //$('#frmDialogo').find('input, textarea, button, select').removeAttr('disabled');
                document.body.innerHTML = contenidoOriginal;*/

                //source = $('.pvtRendererArea')[0];
                var html;
                var disp_setting = "toolbar=yes,location=no,";
                disp_setting += "directories=yes,menubar=yes,";
                disp_setting += "scrollbars=yes,width=650, height=600, left=100, top=25";
                //var contenido= document.getElementById("areaImprimir").innerHTML;
                var docprint = window.open("", "", disp_setting);
                docprint.document.open();

                html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"';
                html += '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
                html += '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">';
                html += '<head><title>Cartas de Solicitudes</title>';
                html += '<style type="text/css">body{ margin:0px;';
                html += 'font-family:verdana,Arial;color:#000;';
                html += 'font-family:Verdana, Geneva, sans-serif; font-size:12px;}';
                html += 'a{color:#000;text-decoration:none;} ';
                html += '</style>';
                html += '</head><body onLoad="self.print()"><center>';
                html += '<div id="areaImprimir"><p><span style="font-size:14px;float:right">' + ciudad + ', ' + dd + '&nbsp;de ' + mm + ' del ' + yyyy + '.</span></p>';
                html += '<br/>';
                html += '<br/>';
                html += '<p><span style="font-size:12px;">&nbsp;</span></p><p><span style="font-size:12px;float:left">Se&ntilde;ores</span></p>';
                html += '<br/>';
                html += '<p><span style="font-size:12px;float:left">Publynext S.A. - Distribuidor Autorizado de CLARO</span></p>';
                html += '<br/>';
                html += '<p><span style="font-size:12px;float:left">Ciudad.-</span></p><p>&nbsp;</p>';
                html += '<br/>';
                html += '<br/>';
                html += '<p align="justify">';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">De mis consideraciones</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Por medio de la presente, yo ';
                html += cliente + ' con cedula ';
                html += ident + '&nbsp;autorizo a la compa&ntilde;&iacute;a que usted representa en calidad';
                html += ' de Distribuidor Autorizado&nbsp; de CONECEL a que realice todos los tr&aacute;mites necesarios ';
                html += 'para la ejecuci&oacute;n del proceso de cambio de operadora de mi(s) n&uacute;mero(s) ';
                html += numerito + '</span></p>';
                html += '<br/>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Esta autorizaci&oacute;n se limita &uacute;nica y exclusivamente a que su representada recepte toda la documentaci&oacute;n necesaria y gestione con CONECEL.</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;"></span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Portaci&oacute;n antes referida bajo la modalidad del servicio solicitado.</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Atentamente,</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">______________</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Firma del cliente &nbsp;</span></p></div>';
                html += '<p/>';

                html += '</center></body></html>';
                docprint.document.write(html);
                docprint.document.close();
                docprint.focus();
                break;
            case 'FORMATO CARTA AUT. JURÍDICO':
                alert('FORMATO CARTA AUT. JURÍDICO');
                var hoy = new Date();
                var dd = hoy.getDate();
                var yyyy = hoy.getFullYear();

                var month = new Array();
                month[0] = "Enero";
                month[1] = "Febrero";
                month[2] = "Marzo";
                month[3] = "Abril";
                month[4] = "Mayo";
                month[5] = "Junio";
                month[6] = "Julio";
                month[7] = "Agosto";
                month[8] = "Septiembre";
                month[9] = "Octubre";
                month[10] = "Noviembre";
                month[11] = "Diciembre";
                var mm = month[hoy.getMonth()];


                var cliente = $("#rep").val();
                var ciudad = $("#ciudad_empr").val();
                var ident = $("#cirep").val();
                var pjuridico = $("#razon").val();
                var NumeroContribuyente = $("#ruc").val();

                var numeros = $("#movil").val();
                var numeros1 = $("#movil1").val();
                var numeros2 = $("#movil2").val();
                var numeros3 = $("#movil3").val();
                var numeros4 = $("#movil4").val();
                var numeros5 = $("#movil5").val();
                var numeros6 = $("#movil6").val();
                var numeros7 = $("#movil7").val();
                var numeros8 = $("#movil8").val();
                var numeros9 = $("#movil9").val();
                var numeros10 = $("#movil10").val();
                var numeros11 = $("#movil11").val();
                var numeros12 = $("#movil12").val();
                var numeros13 = $("#movil13").val();
                var numeros14 = $("#movil14").val();
                var numeros15 = $("#movil15").val();
                var numeros16 = $("#movil16").val();
                var numeros17 = $("#movil17").val();
                var numeros18 = $("#movil18").val();
                var numeros19 = $("#movil19").val();
                var numerito = numeros + ' ' + numeros1 + ' ' + numeros2 + ' ' + numeros3 + ' ' + numeros4 + ' ' + numeros5 + ' ' + numeros6 + ' ' +
                    numeros7 + ' ' + numeros8 + ' ' + numeros9 + ' ' + numeros10 + ' ' + numeros11 + ' ' + numeros12 + ' ' + numeros13 + ' ' + numeros14 + ' ' +
                    numeros15 + ' ' + numeros16 + ' ' + numeros17 + ' ' + numeros18 + ' ' + numeros19;

                var html;
                var disp_setting = "toolbar=yes,location=no,";
                disp_setting += "directories=yes,menubar=yes,";
                disp_setting += "scrollbars=yes,width=650, height=600, left=100, top=25";
                //var contenido= document.getElementById("areaImprimir").innerHTML;
                var docprint = window.open("", "", disp_setting);
                docprint.document.open();

                html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"';
                html += '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
                html += '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">';
                html += '<head><title>Cartas de Solicitudes</title>';
                html += '<style type="text/css">body{ margin:0px;';
                html += 'font-family:verdana,Arial;color:#000;';
                html += 'font-family:Verdana, Geneva, sans-serif; font-size:12px;}';
                html += 'a{color:#000;text-decoration:none;} ';
                html += '</style>';
                html += '</head><body onLoad="self.print()"><center>';
                html += '<div id="areaImprimir"><p><span style="font-size:14px;float:right">' + ciudad + ', ' + dd + '&nbsp;de ' + mm + ' del ' + yyyy + '.</span></p>';
                html += '<br/>';
                html += '<br/>';
                html += '<p><span style="font-size:12px;">&nbsp;</span></p><p><span style="font-size:12px;float:left">Se&ntilde;ores</span></p>';
                html += '<br/>';
                html += '<p><span style="font-size:12px;float:left">Publynext S.A. - Distribuidor Autorizado de CLARO</strong></span></p>';
                html += '<br/>';
                html += '<p><span style="font-size:12px;float:left">Ciudad.-</span></p><p>&nbsp;</p>';
                html += '<br/>';
                html += '<br/>';
                html += '<p align="justify">';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">De mis consideraciones</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Por medio de la presente, yo ';
                html += cliente + ' con cedula de identidad ';
                html += ident + '&nbsp;representante legal de la empresa ' + pjuridico + ' con RUC ' + NumeroContribuyente + ' ';
                html += 'autorizo a la compa&ntilde;&iacute;a que usted representa en calidad';
                html += ' de Distribuidor Autorizado&nbsp; de CONECEL a que realice todos los tr&aacute;mites necesarios ';
                html += 'para la ejecuci&oacute;n del proceso de cambio de operadora de mi(s) n&uacute;mero(s) ';
                html += numerito + '</span></p>';
                html += '<br/>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Esta autorizaci&oacute;n se limita &uacute;nica y exclusivamente a que su representada recepte toda la documentaci&oacute;n necesaria y gestione con CONECEL.</strong></span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;"></span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Portaci&oacute;n antes referida bajo la modalidad del servicio solicitado.</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Atentamente,</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">______________</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;"><strong>Firma del cliente &nbsp;</strong></span></p></div>';
                html += '<p/>';

                html += '</center></body></html>';
                docprint.document.write(html);
                docprint.document.close();
                docprint.focus();

                break;
            case 'CARTA DESANCLE':
                alert('CARTA DESANCLE');
                var hoy = new Date();
                var dd = hoy.getDate();
                var yyyy = hoy.getFullYear();

                var month = new Array();
                month[0] = "Enero";
                month[1] = "Febrero";
                month[2] = "Marzo";
                month[3] = "Abril";
                month[4] = "Mayo";
                month[5] = "Junio";
                month[6] = "Julio";
                month[7] = "Agosto";
                month[8] = "Septiembre";
                month[9] = "Octubre";
                month[10] = "Noviembre";
                month[11] = "Diciembre";
                var mm = month[hoy.getMonth()];


                var cli = $("#cliente").val();
                var cli_raz = $("#razon").val();

                if (cli_raz == "" || cli_raz == null) {
                    var cliente = cli;
                } else {
                    var cliente = cli_raz;
                }

                var ced = $("#identificacion").val();
                var ruc = $("#ruc").val();
                if (ruc == "" || ruc == null) {
                    var ident = ced;
                } else {
                    var ident = ruc;
                }


                var ciu = $("#ciudad").val();
                var ciud = $("#ciudad_empr").val();
                if (ciud == "" || ciud == null) {
                    var ciudad = ciu;
                } else {
                    var ciudad = ciud;
                }


                var numeros = $("#movil").val();
                var numeros1 = $("#movil1").val();
                var numeros2 = $("#movil2").val();
                var numeros3 = $("#movil3").val();
                var numeros4 = $("#movil4").val();
                var numeros5 = $("#movil5").val();
                var numeros6 = $("#movil6").val();
                var numeros7 = $("#movil7").val();
                var numeros8 = $("#movil8").val();
                var numeros9 = $("#movil9").val();
                var numeros10 = $("#movil10").val();
                var numeros11 = $("#movil11").val();
                var numeros12 = $("#movil12").val();
                var numeros13 = $("#movil13").val();
                var numeros14 = $("#movil14").val();
                var numeros15 = $("#movil15").val();
                var numeros16 = $("#movil16").val();
                var numeros17 = $("#movil17").val();
                var numeros18 = $("#movil18").val();
                var numeros19 = $("#movil19").val();
                var numerito = numeros + ' ' + numeros1 + ' ' + numeros2 + ' ' + numeros3 + ' ' + numeros4 + ' ' + numeros5 + ' ' + numeros6 + ' ' +
                    numeros7 + ' ' + numeros8 + ' ' + numeros9 + ' ' + numeros10 + ' ' + numeros11 + ' ' + numeros12 + ' ' + numeros13 + ' ' + numeros14 + ' ' +
                    numeros15 + ' ' + numeros16 + ' ' + numeros17 + ' ' + numeros18 + ' ' + numeros19;

                var html;
                var disp_setting = "toolbar=yes,location=no,";
                disp_setting += "directories=yes,menubar=yes,";
                disp_setting += "scrollbars=yes,width=650, height=600, left=100, top=25";
                //var contenido= document.getElementById("areaImprimir").innerHTML;
                var docprint = window.open("", "", disp_setting);
                docprint.document.open();

                html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"';
                html += '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
                html += '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">';
                html += '<head><title>Cartas de Solicitudes</title>';
                html += '<style type="text/css">body{ margin:0px;';
                html += 'font-family:verdana,Arial;color:#000;';
                html += 'font-family:Verdana, Geneva, sans-serif; font-size:12px;}';
                html += 'a{color:#000;text-decoration:none;} ';
                html += '</style>';
                html += '</head><body onLoad="self.print()"><center>';
                html += '<div id="areaImprimir"><p><span style="font-size:14px;float:right">' + ciudad + ', ' + dd + '&nbsp;de ' + mm + ' del ' + yyyy + '.</span></p>';
                html += '<br/>';
                html += '<br/>';
                html += '<p><span style="font-size:12px;">&nbsp;</span></p><p><span style="font-size:12px;float:left">Se&ntilde;ores</span></p>';
                html += '<br/>';
                html += '<p><span style="font-size:12px;float:left">CONECEL</strong></span></p>';
                html += '<br/>';
                html += '<p><span style="font-size:12px;float:left">Ciudad.-</span></p><p>&nbsp;</p>';
                html += '<br/>';
                html += '<br/>';
                html += '<p align="justify">';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">De mis consideraciones</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Por medio de la presente, yo ';
                html += cliente + ' con cedula de identificaci&oacute;n ';
                html += ident + '&nbsp;autorizo a la compa&ntilde;&iacute;a que usted representa en calidad';
                html += ' de Distribuidor Autorizado de CONECEL a que realice todos los tr&aacute;mites necesarios ';
                html += 'para la ejecuci&oacute;n del proceso de la portabilidad de mi linea ';
                html += numerito + '</span></p>';
                html += '<br/>';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Atentamente,</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">______________</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;"><strong>Firma del cliente &nbsp;</strong></span></p></div>';
                html += '<p/>';

                html += '</center></body></html>';

                html += '</center></body></html>';
                docprint.document.write(html);
                docprint.document.close();
                docprint.focus();

                break;
            case 'CARTA DE SESIÓN':
                alert('CARTA DE SESIÓN');
                var html;
                var disp_setting = "toolbar=yes,location=no,";
                disp_setting += "directories=yes,menubar=yes,";
                disp_setting += "scrollbars=yes,width=650, height=600, left=100, top=25";
                //var contenido= document.getElementById("areaImprimir").innerHTML;
                var docprint = window.open("", "", disp_setting);
                docprint.document.open();

                html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"';
                html += '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
                html += '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">';
                html += '<head><title>Cartas de Solicitudes</title>';
                html += '<style type="text/css">body{ margin:0px;';
                html += 'font-family:verdana,Arial;color:#000;';
                html += 'font-family:Verdana, Geneva, sans-serif; font-size:12px;}';
                html += 'a{color:#000;text-decoration:none;} ';
                html += '</style>';
                html += '</head><body onLoad="self.print()"><center>';
                html += '<div id="areaImprimir"><p><span style="font-size:14px;float:left"><strong>' + ciudad + ', ' + dd + '&nbsp;de ' + mm + ' del ' + yyyy + '.</strong></span></p>';
                html += '<br/>';
                html += '<p style="text-align: center;><span style="font-size:12px;"><strong>&nbsp;</strong></span></p><p><span style="font-size:12px;float:left"><strong>CARTA DE CESIÓN DE DERECHOS DE PERSONA NATURAL A PERSONA NATURAL</strong></span></p>';
                html += '<br/>';
                html += '<br/>';

                html += '<p align="justify">';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">Yo, ';
                html += nomb_don + ' con n&uacute;mero de c&eacute;dula/ciudadan&iacute;a N° ' + ci_don + ' ';
                html += ', titular de la cuenta celular N° ' + CuentaCelular + '';
                html += ', por medio del presente procedo a ceder los derechos respecto de la l&iacute;nea N°. ';
                html += numerito + ' a favor de: ' + cliente + ' con n&uacute;mero de c&eacute;dula/ciudadan&iacute;a N° ' + ident + '. </span></p>';
                html += '<br/>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Sin otro particular por el momento me suscribo.</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Atentamente,</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">______________</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + nomb_don + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + ci_don + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;"><strong>CEDENTE</strong></span></p></div>';

                html += '<p/>';
                html += '<br/>';
                html += '<br/>';
                html += '<br/>';
                html += '<p><span style="font-size:12px;"><strong>&nbsp;</strong></span></p><p><span style="font-size:12px;float:left"><strong>ACEPTACION</strong></span></p>';
                html += '<br/>';
                html += '<br/>';

                html += '<p align="justify">';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">Yo, ';
                html += cliente + ', portadora de la c&eacute;dula de ciudadan&iacute;a N°: ' + ident + ' ';
                html += ', mediante la suscripci&oacute;n del presente instrumento expresamente acepto la cesi&oacute;n  de derechos que a mi favor efectúa ' + nomb_don + '';
                html += ', titular de la l&iacute;nea N° ' + numerito + ';';
                html += ' por lo que renuncio a ejercer cualquier tipo de acci&oacute;n civil o penal por tal concepto,';
                html += ' acorde con lo establecido en el Art. 11 del C&oacute;digo Civil Ecuatoriano.';
                html += '</span></p>';
                html += '<br/>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Atentamente,</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">______________</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + cliente + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + ident + '</p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;"><strong>CESIONARIO</strong></span></p></div>';

                html += '</center></body></html>';
                docprint.document.write(html);
                docprint.document.close();
                docprint.focus();

                break;
            case 'CARTA DE SESIÓN J-N':
                alert('CARTA DE SESIÓN J-N');
                var hoy = new Date();
                var dd = hoy.getDate();
                var yyyy = hoy.getFullYear();

                var month = new Array();
                month[0] = "Enero";
                month[1] = "Febrero";
                month[2] = "Marzo";
                month[3] = "Abril";
                month[4] = "Mayo";
                month[5] = "Junio";
                month[6] = "Julio";
                month[7] = "Agosto";
                month[8] = "Septiembre";
                month[9] = "Octubre";
                month[10] = "Noviembre";
                month[11] = "Diciembre";
                var mm = month[hoy.getMonth()];

                var rep_legal = nomb_l;
                var ciudad = $("#ciudad").val();
                var cargo_rep = cargo_l;

                var cliente = $("#cliente").val();
                var cedula = $("#identificacion").val();

                var CuentaCelular = cta_cell;


                if ($("#tipo").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante").val();
                    var ci_don = $("#cidonante").val();
                    var numeros = $("#movil").val();
                }

                if ($("#tipo1").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante1").val();
                    var ci_don = $("#cidonante1").val();
                    var numeros1 = $("#movil1").val();
                }

                if ($("#tipo2").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante2").val();
                    var ci_don = $("#cidonante2").val();
                    var numeros2 = $("#movil2").val();
                }

                if ($("#tipo3").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante3").val();
                    var ci_don = $("#cidonante3").val();
                    var numeros3 = $("#movil3").val();
                }

                if ($("#tipo4").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante4").val();
                    var ci_don = $("#cidonante4").val();
                    var numeros4 = $("#movil4").val();
                }

                if ($("#tipo5").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante5").val();
                    var ci_don = $("#cidonante5").val();
                    var numeros5 = $("#movil5").val();
                }

                if ($("#tipo6").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante6").val();
                    var ci_don = $("#cidonante6").val();
                    var numeros6 = $("#movil6").val();
                }

                if ($("#tipo7").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante7").val();
                    var ci_don = $("#cidonante7").val();
                    var numeros7 = $("#movil7").val();
                }

                if ($("#tipo8").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante8").val();
                    var ci_don = $("#cidonante8").val();
                    var numeros8 = $("#movil8").val();
                }

                if ($("#tipo9").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante9").val();
                    var ci_don = $("#cidonante9").val();
                    var numeros9 = $("#movil9").val();
                }

                if ($("#tipo10").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante10").val();
                    var ci_don = $("#cidonante10").val();
                    var numeros10 = $("#movil10").val();
                }

                if ($("#tipo11").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante11").val();
                    var ci_don = $("#cidonante11").val();
                    var numeros11 = $("#movil11").val();
                }

                if ($("#tipo12").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante12").val();
                    var ci_don = $("#cidonante12").val();
                    var numeros12 = $("#movil2").val();
                }

                if ($("#tipo13").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante13").val();
                    var ci_don = $("#cidonante13").val();
                    var numeros13 = $("#movil13").val();
                }

                if ($("#tipo14").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante14").val();
                    var ci_don = $("#cidonante14").val();
                    var numeros14 = $("#movil14").val();
                }

                if ($("#tipo15").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante15").val();
                    var ci_don = $("#cidonante15").val();
                    var numeros15 = $("#movil15").val();
                }

                if ($("#tipo16").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante16").val();
                    var ci_don = $("#cidonante16").val();
                    var numeros16 = $("#movil16").val();
                }

                if ($("#tipo17").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante17").val();
                    var ci_don = $("#cidonante17").val();
                    var numeros17 = $("#movil17").val();
                }

                if ($("#tipo18").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante18").val();
                    var ci_don = $("#cidonante18").val();
                    var numeros18 = $("#movil18").val();
                }

                if ($("#tipo19").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante19").val();
                    var ci_don = $("#cidonante19").val();
                    var numeros19 = $("#movil19").val();
                }

                if ($("#movil").val() == "" || $("#movil").val() == null) {
                    var numeros = "";
                } else {
                    var numeros = $("#movil").val();
                }

                if ($("#movil1").val() == "" || $("#movil1").val() == null) {
                    var numeros1 = "";
                } else {
                    var numeros1 = $("#movil1").val();
                }

                if ($("#movil2").val() == "" || $("#movil2").val() == null) {
                    var numeros2 = "";
                } else {
                    var numeros2 = $("#movil2").val();
                }

                if ($("#movil3").val() == "" || $("#movil3").val() == null) {
                    var numeros3 = "";
                } else {
                    var numeros3 = $("#movil3").val();
                }

                if ($("#movil4").val() == "" || $("#movil4").val() == null) {
                    var numeros4 = "";
                } else {
                    var numeros4 = $("#movil4").val();
                }

                if ($("#movil5").val() == "" || $("#movil5").val() == null) {
                    var numeros5 = "";
                } else {
                    var numeros5 = $("#movil5").val();
                }

                if ($("#movil6").val() == "" || $("#movil6").val() == null) {
                    var numeros6 = "";
                } else {
                    var numeros6 = $("#movil6").val();
                }

                if ($("#movil7").val() == "" || $("#movil7").val() == null) {
                    var numeros7 = "";
                } else {
                    var numeros7 = $("#movil7").val();
                }
                if ($("#movil8").val() == "" || $("#movil8").val() == null) {
                    var numeros8 = "";
                } else {
                    var numeros8 = $("#movil8").val();
                }
                if ($("#movil9").val() == "" || $("#movil9").val() == null) {
                    var numeros9 = "";
                } else {
                    var numeros9 = $("#movil9").val();
                }

                if ($("#movil10").val() == "" || $("#movil10").val() == null) {
                    var numeros10 = "";
                } else {
                    var numeros10 = $("#movil10").val();
                }

                if ($("#movil11").val() == "" || $("#movil11").val() == null) {
                    var numeros11 = "";
                } else {
                    var numeros11 = $("#movil11").val();
                }

                if ($("#movil12").val() == "" || $("#movil12").val() == null) {
                    var numeros12 = "";
                } else {
                    var numeros12 = $("#movil12").val();
                }

                if ($("#movil13").val() == "" || $("#movil13").val() == null) {
                    var numeros13 = "";
                } else {
                    var numeros13 = $("#movil13").val();
                }

                if ($("#movil14").val() == "" || $("#movil14").val() == null) {
                    var numeros14 = "";
                } else {
                    var numeros14 = $("#movil14").val();
                }

                if ($("#movil15").val() == "" || $("#movil15").val() == null) {
                    var numeros15 = "";
                } else {
                    var numeros15 = $("#movil15").val();
                }

                if ($("#movil16").val() == "" || $("#movil16").val() == null) {
                    var numeros16 = "";
                } else {
                    var numeros16 = $("#movil16").val();
                }

                if ($("#movil17").val() == "" || $("#movil17").val() == null) {
                    var numeros17 = "";
                } else {
                    var numeros17 = $("#movil17").val();
                }
                if ($("#movil18").val() == "" || $("#movil18").val() == null) {
                    var numeros18 = "";
                } else {
                    var numeros18 = $("#movil18").val();
                }
                if ($("#movil19").val() == "" || $("#movil19").val() == null) {
                    var numeros19 = "";
                } else {
                    var numeros19 = $("#movil19").val();
                }


                var numerito = numeros + ' ' + numeros1 + ' ' + numeros2 + ' ' + numeros3 + ' ' + numeros4 + ' ' + numeros5 + ' ' + numeros6 + ' ' +
                    numeros7 + ' ' + numeros8 + ' ' + numeros9 + ' ' + numeros10 + ' ' + numeros11 + ' ' + numeros12 + ' ' + numeros13 + ' ' + numeros14 + ' ' +
                    numeros15 + ' ' + numeros16 + ' ' + numeros17 + ' ' + numeros18 + ' ' + numeros19;


                var html;
                var disp_setting = "toolbar=yes,location=no,";
                disp_setting += "directories=yes,menubar=yes,";
                disp_setting += "scrollbars=yes,width=650, height=600, left=100, top=25";
                //var contenido= document.getElementById("areaImprimir").innerHTML;
                var docprint = window.open("", "", disp_setting);
                docprint.document.open();

                html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"';
                html += '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
                html += '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">';
                html += '<head><title>Cartas de Solicitudes</title>';
                html += '<style type="text/css">body{ margin:0px;';
                html += 'font-family:verdana,Arial;color:#000;';
                html += 'font-family:Verdana, Geneva, sans-serif; font-size:12px;}';
                html += 'a{color:#000;text-decoration:none;} ';
                html += '</style>';
                html += '</head><body onLoad="self.print()"><center>';
                html += '<div id="areaImprimir"><p><span style="font-size:14px;float:left"><strong>' + ciudad + ', ' + dd + '&nbsp;de ' + mm + ' del ' + yyyy + '.</strong></span></p>';
                html += '<br/><center>';
                html += '<p><span style="font-size:12px;"><strong>&nbsp;</strong></span></p><p><span style="font-size:12px;float:left"><strong>CARTA DE CESIÓN DE DERECHOS DE PERSONA JURIDICA A PERSONA </strong></span></p>';
                html += '<p><span style="font-size:12px;float:left"><strong>&nbsp;NATURAL</strong></span></p></center>';
                html += '<br/>';
                html += '<br/>';

                html += '<p align="justify">';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">Yo, ';
                html += rep_legal + ', en mi calidad de ' + cargo_rep + ' y como tal representante legal de ' + nomb_don + ' ';
                html += ' con Registro &uacute;nico de Contribuyentes N° ' + ci_don + '';
                html += ', titular de la cuenta celular N° ' + CuentaCelular + '';
                html += ', por medio del presente procedo a ceder los derechos respecto de la l&iacute;nea N°. ';
                html += numerito + ' a favor de: ';
                html += cliente + ' con n&uacute;mero de c&eacute;dula/ciudadan&iacute;a N° ' + cedula + ' ';
                html += '. </span></p>';
                html += '<br/>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Sin otro particular por el momento me suscribo.</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Atentamente,</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">______________</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + rep_legal + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + cargo_rep + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;"><strong>CEDENTE</strong></span></p></div>';

                html += '<p/>';
                html += '<br/>';
                html += '<br/>';
                html += '<br/>';
                html += '<p><span style="font-size:12px;"><strong>&nbsp;</strong></span></p><p><span style="font-size:12px;float:left"><strong>ACEPTACION</strong></span></p>';
                html += '<br/>';
                html += '<br/>';

                html += '<p align="justify">';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">Yo, ';
                html += cliente + ', portador de la c&eacute;dula de ciudadan&iacute;a N°: ' + cedula + ' ';
                html += ', mediante la suscripci&oacute;n del presente instrumento expresamente acepto la cesi&oacute;n  de derechos que a mi favor efectúa ' + nomb_don + '';
                html += ', de la l&iacute;nea celular N° ' + numerito + ';';
                html += ' por lo que renuncio a ejercer cualquier tipo de acci&oacute;n civil o penal por tal concepto,';
                html += ' acorde con lo establecido en el Art. 11 del C&oacute;digo Civil Ecuatoriano.';
                html += '</span></p>';
                html += '<br/>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Atentamente,</strong></span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">______________</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + cliente + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + cedula + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;"><strong>CESIONARIO</strong></span></p></div>';

                html += '</center></body></html>';
                docprint.document.write(html);
                docprint.document.close();
                docprint.focus();
                break;
            case 'CARTA DE SESIÓN J-J':
                alert('CARTA DE SESIÓN J-J');
                var hoy = new Date();
                var dd = hoy.getDate();
                var yyyy = hoy.getFullYear();

                var month = new Array();
                month[0] = "Enero";
                month[1] = "Febrero";
                month[2] = "Marzo";
                month[3] = "Abril";
                month[4] = "Mayo";
                month[5] = "Junio";
                month[6] = "Julio";
                month[7] = "Agosto";
                month[8] = "Septiembre";
                month[9] = "Octubre";
                month[10] = "Noviembre";
                month[11] = "Diciembre";
                var mm = month[hoy.getMonth()];

                var rep_legal = nomb_l;
                var ciudad = $("#ciudad_empr").val();
                var cargo_rep = cargo_l;

                var emp_rep = $("#rep").val();
                var cargo_rl = $("#cargorl").val();


                var cliente = $("#razon").val();
                var ident = $("#ruc").val();

                var CuentaCelular = cta_cell;


                if ($("#tipo").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante").val();
                    var ci_don = $("#cidonante").val();
                    var numeros = $("#movil").val();
                }

                if ($("#tipo1").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante1").val();
                    var ci_don = $("#cidonante1").val();
                    var numeros1 = $("#movil1").val();
                }

                if ($("#tipo2").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante2").val();
                    var ci_don = $("#cidonante2").val();
                    var numeros2 = $("#movil2").val();
                }

                if ($("#tipo3").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante3").val();
                    var ci_don = $("#cidonante3").val();
                    var numeros3 = $("#movil3").val();
                }

                if ($("#tipo4").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante4").val();
                    var ci_don = $("#cidonante4").val();
                    var numeros4 = $("#movil4").val();
                }

                if ($("#tipo5").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante5").val();
                    var ci_don = $("#cidonante5").val();
                    var numeros5 = $("#movil5").val();
                }

                if ($("#tipo6").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante6").val();
                    var ci_don = $("#cidonante6").val();
                    var numeros6 = $("#movil6").val();
                }

                if ($("#tipo7").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante7").val();
                    var ci_don = $("#cidonante7").val();
                    var numeros7 = $("#movil7").val();
                }

                if ($("#tipo8").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante8").val();
                    var ci_don = $("#cidonante8").val();
                    var numeros8 = $("#movil8").val();
                }

                if ($("#tipo9").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante9").val();
                    var ci_don = $("#cidonante9").val();
                    var numeros9 = $("#movil9").val();
                }

                if ($("#tipo10").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante10").val();
                    var ci_don = $("#cidonante10").val();
                    var numeros10 = $("#movil10").val();
                }

                if ($("#tipo11").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante11").val();
                    var ci_don = $("#cidonante11").val();
                    var numeros11 = $("#movil11").val();
                }

                if ($("#tipo12").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante12").val();
                    var ci_don = $("#cidonante12").val();
                    var numeros12 = $("#movil2").val();
                }

                if ($("#tipo13").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante13").val();
                    var ci_don = $("#cidonante13").val();
                    var numeros13 = $("#movil13").val();
                }

                if ($("#tipo14").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante14").val();
                    var ci_don = $("#cidonante14").val();
                    var numeros14 = $("#movil14").val();
                }

                if ($("#tipo15").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante15").val();
                    var ci_don = $("#cidonante15").val();
                    var numeros15 = $("#movil15").val();
                }

                if ($("#tipo16").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante16").val();
                    var ci_don = $("#cidonante16").val();
                    var numeros16 = $("#movil16").val();
                }

                if ($("#tipo17").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante17").val();
                    var ci_don = $("#cidonante17").val();
                    var numeros17 = $("#movil17").val();
                }

                if ($("#tipo18").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante18").val();
                    var ci_don = $("#cidonante18").val();
                    var numeros18 = $("#movil18").val();
                }

                if ($("#tipo19").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante19").val();
                    var ci_don = $("#cidonante19").val();
                    var numeros19 = $("#movil19").val();
                }

                if ($("#movil").val() == "" || $("#movil").val() == null) {
                    var numeros = "";
                } else {
                    var numeros = $("#movil").val();
                }

                if ($("#movil1").val() == "" || $("#movil1").val() == null) {
                    var numeros1 = "";
                } else {
                    var numeros1 = $("#movil1").val();
                }

                if ($("#movil2").val() == "" || $("#movil2").val() == null) {
                    var numeros2 = "";
                } else {
                    var numeros2 = $("#movil2").val();
                }

                if ($("#movil3").val() == "" || $("#movil3").val() == null) {
                    var numeros3 = "";
                } else {
                    var numeros3 = $("#movil3").val();
                }

                if ($("#movil4").val() == "" || $("#movil4").val() == null) {
                    var numeros4 = "";
                } else {
                    var numeros4 = $("#movil4").val();
                }

                if ($("#movil5").val() == "" || $("#movil5").val() == null) {
                    var numeros5 = "";
                } else {
                    var numeros5 = $("#movil5").val();
                }

                if ($("#movil6").val() == "" || $("#movil6").val() == null) {
                    var numeros6 = "";
                } else {
                    var numeros6 = $("#movil6").val();
                }

                if ($("#movil7").val() == "" || $("#movil7").val() == null) {
                    var numeros7 = "";
                } else {
                    var numeros7 = $("#movil7").val();
                }
                if ($("#movil8").val() == "" || $("#movil8").val() == null) {
                    var numeros8 = "";
                } else {
                    var numeros8 = $("#movil8").val();
                }
                if ($("#movil9").val() == "" || $("#movil9").val() == null) {
                    var numeros9 = "";
                } else {
                    var numeros9 = $("#movil9").val();
                }

                if ($("#movil10").val() == "" || $("#movil10").val() == null) {
                    var numeros10 = "";
                } else {
                    var numeros10 = $("#movil10").val();
                }

                if ($("#movil11").val() == "" || $("#movil11").val() == null) {
                    var numeros11 = "";
                } else {
                    var numeros11 = $("#movil11").val();
                }

                if ($("#movil12").val() == "" || $("#movil12").val() == null) {
                    var numeros12 = "";
                } else {
                    var numeros12 = $("#movil12").val();
                }

                if ($("#movil13").val() == "" || $("#movil13").val() == null) {
                    var numeros13 = "";
                } else {
                    var numeros13 = $("#movil13").val();
                }

                if ($("#movil14").val() == "" || $("#movil14").val() == null) {
                    var numeros14 = "";
                } else {
                    var numeros14 = $("#movil14").val();
                }

                if ($("#movil15").val() == "" || $("#movil15").val() == null) {
                    var numeros15 = "";
                } else {
                    var numeros15 = $("#movil15").val();
                }

                if ($("#movil16").val() == "" || $("#movil16").val() == null) {
                    var numeros16 = "";
                } else {
                    var numeros16 = $("#movil16").val();
                }

                if ($("#movil17").val() == "" || $("#movil17").val() == null) {
                    var numeros17 = "";
                } else {
                    var numeros17 = $("#movil17").val();
                }
                if ($("#movil18").val() == "" || $("#movil18").val() == null) {
                    var numeros18 = "";
                } else {
                    var numeros18 = $("#movil18").val();
                }
                if ($("#movil19").val() == "" || $("#movil19").val() == null) {
                    var numeros19 = "";
                } else {
                    var numeros19 = $("#movil19").val();
                }


                var numerito = numeros + ' ' + numeros1 + ' ' + numeros2 + ' ' + numeros3 + ' ' + numeros4 + ' ' + numeros5 + ' ' + numeros6 + ' ' +
                    numeros7 + ' ' + numeros8 + ' ' + numeros9 + ' ' + numeros10 + ' ' + numeros11 + ' ' + numeros12 + ' ' + numeros13 + ' ' + numeros14 + ' ' +
                    numeros15 + ' ' + numeros16 + ' ' + numeros17 + ' ' + numeros18 + ' ' + numeros19;


                var html;
                var disp_setting = "toolbar=yes,location=no,";
                disp_setting += "directories=yes,menubar=yes,";
                disp_setting += "scrollbars=yes,width=650, height=600, left=100, top=25";
                //var contenido= document.getElementById("areaImprimir").innerHTML;
                var docprint = window.open("", "", disp_setting);
                docprint.document.open();

                html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"';
                html += '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
                html += '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">';
                html += '<head><title>Cartas de Solicitudes</title>';
                html += '<style type="text/css">body{ margin:0px;';
                html += 'font-family:verdana,Arial;color:#000;';
                html += 'font-family:Verdana, Geneva, sans-serif; font-size:12px;}';
                html += 'a{color:#000;text-decoration:none;} ';
                html += '</style>';
                html += '</head><body onLoad="self.print()"><center>';
                html += '<div id="areaImprimir"><p><span style="font-size:14px;float:left"><strong>' + ciudad + ', ' + dd + '&nbsp;de ' + mm + ' del ' + yyyy + '.</strong></span></p>';
                html += '<br/><center>';
                html += '<p><span style="font-size:12px;"><strong>&nbsp;</strong></span></p><p><span style="font-size:12px;float:left"><strong>CARTA DE CESIÓN DE DERECHOS DE PERSONA JURIDICA A PERSONA</strong></span></p>';
                html += '<p><span style="font-size:12px;float:left"><strong>&nbsp;JURIDICA</strong></span></p></center>';
                html += '<br/>';
                html += '<br/>';

                html += '<p align="justify">';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">Yo, ';
                html += rep_legal + ', en mi calidad de ' + cargo_rep + ' y como tal representante legal de ' + nomb_don + ' ';
                html += ' con Registro &uacute;nico de Contribuyentes N° ' + ci_don + '';
                html += ', titular de la cuenta celular N° ' + CuentaCelular + '';
                html += ', por medio del presente procedo a ceder los derechos respecto de la l&iacute;nea N°. ';
                html += numerito + ' a favor de: ' + cliente + ' con Registro &uacute;nico de Contribuyentes N° ' + ident + '. </span></p>';
                html += '<br/>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Sin otro particular por el momento me suscribo.</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Atentamente,</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">______________</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + rep_legal + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + cargo_rep + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;"><strong>CEDENTE</strong></span></p></div>';

                html += '<p/>';
                html += '<br/>';
                html += '<br/>';
                html += '<br/>';
                html += '<p><span style="font-size:12px;"><strong>&nbsp;</strong></span></p><p><span style="font-size:12px;float:left"><strong>ACEPTACION</strong></span></p>';
                html += '<br/>';
                html += '<br/>';

                html += '<p align="justify">';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">Yo, ';
                html += emp_rep + ', en mi calidad de ' + cargo_rl + ' y como tal representante legal de ' + cliente + ' ';
                html += ' con Registro &uacute;nico de Contribuyentes N° ' + ident + ',';
                html += ' mediante la suscripci&oacute;n del presente instrumento expresamente acepto la cesi&oacute;n de derechos que a favor de mi representada efect&uacute;a';
                html += ' ' + nomb_don + ', de la l&iacute;nea celular N°. ' + numerito + '; por lo que renuncio a ejercer cualquier tipo de acci&oacute;n civil o penal por tal concepto,';
                html += ' acorde con lo establecido en el Art. 11 del C&oacute;digo Civil Ecuatoriano.';
                html += '</span></p>';


                html += '<br/>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Atentamente,</strong></span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">______________</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + emp_rep + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + cargo_rl + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;"><strong>CESIONARIO</strong></span></p></div>';

                html += '</center></body></html>';

                docprint.document.write(html);
                docprint.document.close();
                docprint.focus();

                break;
            case 'CARTA DE SESIÓN N-J':
                alert('CARTA DE SESIÓN N-J');
                var hoy = new Date();
                var dd = hoy.getDate();
                var yyyy = hoy.getFullYear();

                var month = new Array();
                month[0] = "Enero";
                month[1] = "Febrero";
                month[2] = "Marzo";
                month[3] = "Abril";
                month[4] = "Mayo";
                month[5] = "Junio";
                month[6] = "Julio";
                month[7] = "Agosto";
                month[8] = "Septiembre";
                month[9] = "Octubre";
                month[10] = "Noviembre";
                month[11] = "Diciembre";
                var mm = month[hoy.getMonth()];

                var rep_legal = $("#rep").val();
                var ciudad = $("#ciudad_empr").val();
                var cargo_rep = $("#cargorl").val();

                var pjuridico = $("#razon").val();
                var NumeroContribuyente = $("#ruc").val();

                var CuentaCelular = cta_cell;


                if ($("#tipo").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante").val();
                    var ci_don = $("#cidonante").val();
                    var numeros = $("#movil").val();
                }

                if ($("#tipo1").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante1").val();
                    var ci_don = $("#cidonante1").val();
                    var numeros1 = $("#movil1").val();
                }

                if ($("#tipo2").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante2").val();
                    var ci_don = $("#cidonante2").val();
                    var numeros2 = $("#movil2").val();
                }

                if ($("#tipo3").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante3").val();
                    var ci_don = $("#cidonante3").val();
                    var numeros3 = $("#movil3").val();
                }

                if ($("#tipo4").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante4").val();
                    var ci_don = $("#cidonante4").val();
                    var numeros4 = $("#movil4").val();
                }

                if ($("#tipo5").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante5").val();
                    var ci_don = $("#cidonante5").val();
                    var numeros5 = $("#movil5").val();
                }

                if ($("#tipo6").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante6").val();
                    var ci_don = $("#cidonante6").val();
                    var numeros6 = $("#movil6").val();
                }

                if ($("#tipo7").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante7").val();
                    var ci_don = $("#cidonante7").val();
                    var numeros7 = $("#movil7").val();
                }


                if ($("#tipo8").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante8").val();
                    var ci_don = $("#cidonante8").val();
                    var numeros8 = $("#movil8").val();
                }

                if ($("#tipo9").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante9").val();
                    var ci_don = $("#cidonante9").val();
                    var numeros9 = $("#movil9").val();
                }

                if ($("#tipo10").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante10").val();
                    var ci_don = $("#cidonante10").val();
                    var numeros10 = $("#movil10").val();
                }

                if ($("#tipo11").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante11").val();
                    var ci_don = $("#cidonante11").val();
                    var numeros11 = $("#movil11").val();
                }

                if ($("#tipo12").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante12").val();
                    var ci_don = $("#cidonante12").val();
                    var numeros12 = $("#movil2").val();
                }

                if ($("#tipo13").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante13").val();
                    var ci_don = $("#cidonante13").val();
                    var numeros13 = $("#movil13").val();
                }

                if ($("#tipo14").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante14").val();
                    var ci_don = $("#cidonante14").val();
                    var numeros14 = $("#movil14").val();
                }

                if ($("#tipo15").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante15").val();
                    var ci_don = $("#cidonante15").val();
                    var numeros15 = $("#movil15").val();
                }

                if ($("#tipo16").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante16").val();
                    var ci_don = $("#cidonante16").val();
                    var numeros16 = $("#movil16").val();
                }

                if ($("#tipo17").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante17").val();
                    var ci_don = $("#cidonante17").val();
                    var numeros17 = $("#movil17").val();
                }

                if ($("#tipo18").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante18").val();
                    var ci_don = $("#cidonante18").val();
                    var numeros18 = $("#movil18").val();
                }

                if ($("#tipo19").val() == "Transferencia Beneficiaria") {
                    var nomb_don = $("#nombdonante19").val();
                    var ci_don = $("#cidonante19").val();
                    var numeros19 = $("#movil19").val();
                }

                if ($("#movil").val() == "" || $("#movil").val() == null) {
                    var numeros = "";
                } else {
                    var numeros = $("#movil").val();
                }

                if ($("#movil1").val() == "" || $("#movil1").val() == null) {
                    var numeros1 = "";
                } else {
                    var numeros1 = $("#movil1").val();
                }

                if ($("#movil2").val() == "" || $("#movil2").val() == null) {
                    var numeros2 = "";
                } else {
                    var numeros2 = $("#movil2").val();
                }

                if ($("#movil3").val() == "" || $("#movil3").val() == null) {
                    var numeros3 = "";
                } else {
                    var numeros3 = $("#movil3").val();
                }

                if ($("#movil4").val() == "" || $("#movil4").val() == null) {
                    var numeros4 = "";
                } else {
                    var numeros4 = $("#movil4").val();
                }

                if ($("#movil5").val() == "" || $("#movil5").val() == null) {
                    var numeros5 = "";
                } else {
                    var numeros5 = $("#movil5").val();
                }

                if ($("#movil6").val() == "" || $("#movil6").val() == null) {
                    var numeros6 = "";
                } else {
                    var numeros6 = $("#movil6").val();
                }

                if ($("#movil7").val() == "" || $("#movil7").val() == null) {
                    var numeros7 = "";
                } else {
                    var numeros7 = $("#movil7").val();
                }

                if ($("#movil8").val() == "" || $("#movil8").val() == null) {
                    var numeros8 = "";
                } else {
                    var numeros8 = $("#movil8").val();
                }

                if ($("#movil9").val() == "" || $("#movil9").val() == null) {
                    var numeros9 = "";
                } else {
                    var numeros9 = $("#movil9").val();
                }

                if ($("#movil10").val() == "" || $("#movil10").val() == null) {
                    var numeros10 = "";
                } else {
                    var numeros10 = $("#movil10").val();
                }

                if ($("#movil11").val() == "" || $("#movil11").val() == null) {
                    var numeros11 = "";
                } else {
                    var numeros11 = $("#movil11").val();
                }

                if ($("#movil12").val() == "" || $("#movil12").val() == null) {
                    var numeros12 = "";
                } else {
                    var numeros12 = $("#movil12").val();
                }

                if ($("#movil13").val() == "" || $("#movil13").val() == null) {
                    var numeros13 = "";
                } else {
                    var numeros13 = $("#movil13").val();
                }

                if ($("#movil14").val() == "" || $("#movil14").val() == null) {
                    var numeros14 = "";
                } else {
                    var numeros14 = $("#movil14").val();
                }

                if ($("#movil15").val() == "" || $("#movil15").val() == null) {
                    var numeros15 = "";
                } else {
                    var numeros15 = $("#movil15").val();
                }

                if ($("#movil16").val() == "" || $("#movil16").val() == null) {
                    var numeros16 = "";
                } else {
                    var numeros16 = $("#movil16").val();
                }

                if ($("#movil17").val() == "" || $("#movil17").val() == null) {
                    var numeros17 = "";
                } else {
                    var numeros17 = $("#movil17").val();
                }
                if ($("#movil18").val() == "" || $("#movil18").val() == null) {
                    var numeros18 = "";
                } else {
                    var numeros18 = $("#movil18").val();
                }
                if ($("#movil19").val() == "" || $("#movil19").val() == null) {
                    var numeros19 = "";
                } else {
                    var numeros19 = $("#movil19").val();
                }


                var numerito = numeros + ' ' + numeros1 + ' ' + numeros2 + ' ' + numeros3 + ' ' + numeros4 + ' ' + numeros5 + ' ' + numeros6 + ' ' +
                    numeros7 + ' ' + numeros8 + ' ' + numeros9 + ' ' + numeros10 + ' ' + numeros11 + ' ' + numeros12 + ' ' + numeros13 + ' ' + numeros14 + ' ' +
                    numeros15 + ' ' + numeros16 + ' ' + numeros17 + ' ' + numeros18 + ' ' + numeros19;


                var html;
                var disp_setting = "toolbar=yes,location=no,";
                disp_setting += "directories=yes,menubar=yes,";
                disp_setting += "scrollbars=yes,width=650, height=600, left=100, top=25";
                //var contenido= document.getElementById("areaImprimir").innerHTML;
                var docprint = window.open("", "", disp_setting);
                docprint.document.open();

                html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"';
                html += '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
                html += '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">';
                html += '<head><title>Cartas de Solicitudes</title>';
                html += '<style type="text/css">body{ margin:0px;';
                html += 'font-family:verdana,Arial;color:#000;';
                html += 'font-family:Verdana, Geneva, sans-serif; font-size:12px;}';
                html += 'a{color:#000;text-decoration:none;} ';
                html += '</style>';
                html += '</head><body onLoad="self.print()"><center>';
                html += '<div id="areaImprimir"><p><span style="font-size:14px;float:left"><strong>' + ciudad + ', ' + dd + '&nbsp;de ' + mm + ' del ' + yyyy + '.</strong></span></p>';
                html += '<br/><center>';
                html += '<p><span style="font-size:12px;"><strong>&nbsp;</strong></span></p><p><span style="font-size:12px;float:left"><strong>CARTA DE CESIÓN DE DERECHOS DE PERSONA NATURAL A PERSONA</strong></span></p>';
                html += '<p><span style="font-size:12px;float:left"><strong>&nbsp;JURIDICA</strong></span></p></center>';
                html += '<br/>';
                html += '<br/>';

                html += '<p align="justify">';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">Yo, ';
                html += nomb_don + ' con n&uacute;mero de c&eacute;dula/ciudadan&iacute;a N° ' + ci_don + ' ';
                html += ', titular de la cuenta celular N°' + CuentaCelular + '';
                html += ', por medio del presente procedo a ceder los derechos respecto de la l&iacute;nea N°. ';
                html += numerito + ' a favor de: ' + pjuridico + ' con Registro &uacute;nico de Contribuyentes N° ' + NumeroContribuyente + '. </span></p>';
                html += '<br/>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Sin otro particular por el momento me suscribo.</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Atentamente,</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">______________</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + nomb_don + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + ci_don + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;"><strong>CEDENTE</strong></span></p></div>';

                html += '<p/>';
                html += '<br/>';
                html += '<br/>';
                html += '<br/>';
                html += '<p><span style="font-size:12px;"><strong>&nbsp;</strong></span></p><p><span style="font-size:12px;float:left"><strong>ACEPTACION</strong></span></p>';
                html += '<br/>';
                html += '<br/>';

                html += '<p align="justify">';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">Yo, ';
                html += rep_legal + ', en mi calidad de ' + cargo_rep + ' y como tal representante legal de ' + pjuridico + ' ';
                html += ', con Registro &uacute;nico de Contribuyentes N° ' + NumeroContribuyente + ', ';
                html += ' mediante la suscripci&oacute;n del presente instrumento expresamente acepto la cesi&oacute;n de derechos que a favor de mi representada efect&uacute;a';
                html += ' ' + nomb_don + ', de la l&iacute;nea celular N°. ' + numerito + '; por lo que renuncio a ejercer cualquier tipo de acci&oacute;n civil o penal por tal concepto,';
                html += ' acorde con lo establecido en el Art. 11 del C&oacute;digo Civil Ecuatoriano.';
                html += '</span></p>';
                html += '<br/>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Atentamente,</strong></span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">______________</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + rep_legal + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + cargo_rep + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;"><strong>CESIONARIO</strong></span></p></div>';

                html += '</center></body></html>';
                docprint.document.write(html);
                docprint.document.close();
                docprint.focus();

                break;
            case 'ACUERDO JURÍDICO':
                alert('ACUERDO JURÍDICO');
                var hoy = new Date();
                var dd = hoy.getDate();
                var yyyy = hoy.getFullYear();

                var month = new Array();
                month[0] = "Enero";
                month[1] = "Febrero";
                month[2] = "Marzo";
                month[3] = "Abril";
                month[4] = "Mayo";
                month[5] = "Junio";
                month[6] = "Julio";
                month[7] = "Agosto";
                month[8] = "Septiembre";
                month[9] = "Octubre";
                month[10] = "Noviembre";
                month[11] = "Diciembre";
                var mm = month[hoy.getMonth()];

                var rep_legal = $("#rep").val();

                var ciudad = $("#ciudad_empr").val();
                var ident = $("#cirep").val();
                var pjuridico = $("#razon").val();
                var NumeroContribuyente = $("#ruc").val();

                var html;
                var disp_setting = "toolbar=yes,location=no,";
                disp_setting += "directories=yes,menubar=yes,";
                disp_setting += "scrollbars=yes,width=650, height=600, left=100, top=25";
                //var contenido= document.getElementById("areaImprimir").innerHTML;
                var docprint = window.open("", "", disp_setting);
                docprint.document.open();

                html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"';
                html += '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
                html += '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">';
                html += '<head><title>Cartas de Solicitudes</title>';
                html += '<style type="text/css">body{ margin:0px;';
                html += 'font-family:verdana,Arial;color:#000;';
                html += 'font-family:Verdana, Geneva, sans-serif; font-size:12px;}';
                html += 'a{color:#000;text-decoration:none;} ';
                html += '</style>';
                html += '</head><body onLoad="self.print()"><center>';
                html += '<div id="areaImprimir"><p><span style="font-size:14px;float:right">' + ciudad + ', ' + dd + '&nbsp;de ' + mm + ' del ' + yyyy + '.</span></p>';
                html += '</br>';
                html += '</br>';
                html += '<p align="justify">';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">Yo, ';
                html += rep_legal + ' en calidad de Representante Legal de la compañía  ' + pjuridico + ', ';
                html += 'confirmo haber leído y aceptado las condiciones comerciales de los planes que el CONSORCIO ECUATORIANO DE TELECOMUNICACIONES S.A. CONECEL  ofrece y que contienen servicios con características de ilimitados.';
                html += '</span></p>';
                html += '<p align="justify"><strong>';
                html += 'USO RAZONABLE PARA SERVICIOS DE LLAMADAS ILIMITADAS ONNET';
                html += '</strong></p>';
                html += '<p align="justify">';
                html += 'Los planes de telefonía móvil o fija que incluyan componentes de llamadas ilimitadas Onnet permitirán comunicación ilimitada entre el cliente o usuario con el servicio y los abonados de la red Onnet local de la operadora, es decir, llamadas a otros abonados de la red de Claro. El consumo que realice el cliente, se descontará primero de la cuota mensual de minutos asignados a cada plan, conforme su tarifa básica de voz. Una vez alcanzado el límite de la cuota de minutos del plan contratado, el cliente podrá comenzar a utilizar el servicio de llamadas ilimitadas a números móviles o fijos Claro (según el plan contratado). ';
                html += '</p>';
                html += '<br/>';
                html += '<p align="justify">';
                html += 'El servicio de llamadas ilimitadas a Claro Móvil/Fijo (On Net) es para uso personal (comunicación persona a persona) y no comercial. La siguiente lista incluye, sin embargo, no limita las prácticas que NO podrían considerarse Uso Razonable o podría ser considerado uso Comercial:';
                html += '</p>';
                html += '<p align="justify">';
                html += '<ul>';
                html += '<li style="text-align: justify;">Uso de planes para telemarketing u operaciones de centros de llamadas.';
                html += '</li>';
                html += '<li style="text-align: justify;">Reventa de minutos de un plan a través de cabinas, locutorios o cibercafés.';
                html += '</li>';
                html += '<li style="text-align: justify;">Servicios de monitoreo (Ej. Babycalling).';
                html += '</li>';
                html += '<li style="text-align: justify;">Uso compartido de planes entre usuarios a través de un sistema PBX, centro de llamadas, equipo informático o cualquier otro medio.';
                html += '</li>';
                html += '<li style="text-align: justify;">Patrones de llamadas inusuales que no sean consecuentes con el uso normal y personal del plan.';
                html += '</li>';
                html += '<li style="text-align: justify;">La utilización como puerta de enlace de envío de comunicaciones tipo Bypass.';
                html += '</li>';
                html += '<li style="text-align: justify;">La utilización de estos planes en equipos E1 o SIMBOX para actividades comerciales';
                html += '</li>';
                html += '<li style="text-align: justify;">Uso de planes para telemarketing u operaciones de centros de llamadas.';
                html += '</li>';
                html += '</ul>';

                html += '</p>';
                html += '<br/>';
                html += '<p style="text-align: justify;">';
                html += 'En caso de incumplimiento de las condiciones descritas, CONECEL podrá dar por terminado el contrato con el cliente.';
                html += '</p>';
                html += '<br/>';
                html += '<p align="justify"><strong>';
                html += 'USO RAZONABLE PARA SERVICIOS DE LLAMADAS ILIMITADAS MULTIDESTINO';
                html += '</strong></p>';
                html += '<p align="justify">';
                html += 'Los planes que incluyan componentes de llamadas ilimitadas Multidestino, permitirán comunicación entre el cliente o usuario con el servicio y los abonados de las redes de telefonía fija y móvil del territorio nacional, excluye números especiales, SMS Premium, marcaciones cortas, 1700-1800, Larga Distancia Internacional, entre otros servicios que se podrán agregar en el tiempo.';
                html += '</p>';
                html += '<br/>';
                html += '<p align="justify">';
                html += 'El servicio de llamadas ilimitadas Multidestino es para uso personal (comunicación persona a persona) y no comercial. La siguiente lista incluye, sin embargo, no limita las prácticas que NO podrían considerarse Uso Razonable o podría ser considerado uso Comercial:';
                html += '</p>';
                html += '<ul>';
                html += '<li style="text-align: justify;">Uso de planes para telemarketing u operaciones de centros de llamadas.</li>';
                html += '<li style="text-align: justify;">Reventa de minutos de un plan a través de cabinas, locutorios o cibercafés.</li>';
                html += '<li style="text-align: justify;">Servicios de monitoreo (Ej. Babycalling).</li>';
                html += '<li style="text-align: justify;">Uso compartido de planes entre usuarios a través de un sistema PBX, centro de llamadas, equipo informático o cualquier otro medio.</li>';
                html += '<li style="text-align: justify;">Patrones de llamadas inusuales que no sean consecuentes con el uso normal y personal del plan.</li>';
                html += '<li style="text-align: justify;">La utilización como puerta de enlace de envío de comunicaciones tipo Bypass.</li>';
                html += '<li style="text-align: justify;">La utilización de estos planes en equipos E1 o SIMBOX para actividades comerciales.</li>';
                html += '</ul>';

                html += '<p align="justify">';
                html += 'Cualquier otra funcionalidad que no se encuentre detallada en el numeral anterior, y que correspondan a innovaciones y/o features adicionales habilitados por el proveedor de la aplicación oficial. En caso de incumplimiento de las condiciones descritas, CONECEL podrá supender el servicio contratado o dar por terminado el contrato con el cliente. ';
                html += '</p>';
                html += '<br/>';
                html += '<p align="justify"><strong>';
                html += 'USO RAZONABLE PARA EL SERVICIO DE WHATSAPP Y REDES SOCIALES';
                html += '</strong></p>';
                html += '<p align="justify">';
                html += 'El servicio de WhatsApp y Redes Sociales (RS) tienen las siguientes condiciones:';
                html += '</p>';
                html += '<p align="justify">';
                html += 'El uso de Whatsapp y RS  se descontarán al cliente, primero del saldo de megas que tiene asignado según el plan contratado y que aplica a la promoción. Una vez terminado el saldo de megas podrá hacer uso de la promoción de Chat en Whatsapp o acceso a RS; vía la aplicación oficial, se mantendrá incluido para el cliente.';
                html += '</p>';

                html += '<p align="justify">';
                html += '1) A continuación se enlistan las funcionalidades incluidas para Whatsapp:';
                html += '</p>';
                html += '<ul>';
                html += '<li style="text-align: justify;">Envío de textos (mensajear).</li>';
                html += '<li style="text-align: justify;">Envío de notas de voz (icono de micrófono).</li>';
                html += '<li style="text-align: justify;">Envío o compartir fotos y videos.</li>';
                html += '<li style="text-align: justify;">Descargas o guardar fotos y videos.</li>';
                html += '<li style="text-align: justify;">Envío o compartir contactos de la agenda.</li>';
                html += '<li style="text-align: justify;">Recibir notificaciones desde la aplicación oficial de WhatsApp.</li>';
                html += '</ul>';
                html += '<p align="justify">';
                html += '1.1) No se incluyen las siguientes funcionalidades:';
                html += '</p>';

                html += '<ul>';
                html += '<li style="text-align: justify;">La carga y descarga de fotos fuera de la app oficial de WhatsApp; por ejemplo, utilizando apps como: Instagram, Retrica, Vine, etc.</li>';
                html += '<li style="text-align: justify;">La funcionalidad para compartir, reproducir, cargar o descargar videos fuera de la app oficial de WhatsApp; por ejemplo, utilizando apps como: YouTube®, Vimeo o DailyMotion®, etc.</li>';
                html += '<li style="text-align: justify;">El redireccionamiento a cualquier link o URL externa a WhatsApp; aun cuando este haya sido compartido por un mensaje de WhatsApp. Ejemplo: notas de periódico, artículos de revistas especializadas, descargas de aplicaciones, descargas/uso de juegos, etc.</li>';
                html += '<li style="text-align: justify;">El servicio de llamadas, videollamadas o servicios voz a través de la aplicación de WhatsApp.</li>';

                html += '</ul>';
                html += '<p align="justify">';

                html += 'Cualquier otra funcionalidad que no se encuentre detallada en el numeral anterior, y que correspondan a innovaciones y/o features adicionales habilitados por el proveedor de la aplicación oficial. El servicio de WhatsApp Gratis es para uso personal (comunicación persona a persona) y no comercial.';
                html += '</p>';
                html += '<p align="justify">';
                html += '2) El uso de las aplicaciones móviles oficiales que Facebook® ha liberado bajo su propia marca tales como: Facebook®, Facebook Pages®, Facebook Camera® y Facebook Messenger®, así como el dominio www.facebook.com; serán de uso gratuito. A continuación se enlistan las funcionalidades, incluidas dentro de este paquete o promoción respectivamente:';
                html += '</p>';
                html += '<ul>';
                html += '<li style="text-align: justify;">Visualización del muro personal o de cualquier otra persona o grupo.</li>';
                html += '<li style="text-align: justify;">Publicar mi “estado” personal o comentar el “estado” de cualquier otra persona o grupo.</li>';
                html += '<li style="text-align: justify;">Publicar o cargar fotos y video en mi muro utilizando las apps oficiales de Facebook®.</li>';
                html += '<li style="text-align: justify;">Guardar fotos de mi muro o de cualquier persona o grupo.</li>';
                html += '<li style="text-align: justify;">Reproducción de videos que no sean direccionados a una web diferente a la de Facebook, como es youtube.</li>';
                html += '<li style="text-align: justify;">Dar “me gusta” a alguna historia personal o de cualquier otra persona o grupo.</li>';
                html += '<li style="text-align: justify;">Comentar cualquier historia personal o de cualquier otra persona o grupo.</li>';
                html += '<li style="text-align: justify;">Compartir cualquier historia en el muro personal o de cualquier otra persona o grupo.</li>';
                html += '<li style="text-align: justify;">Mensajear (enviar textos) a través de Facebook Messenger®.</li>';
                html += '<li style="text-align: justify;">Compartir imágenes a traves de Facebook Messenger®.</li>';
                html += '<li style="text-align: justify;">Recibir notificaciones desde las aplicaciones oficiales de Facebook®</li>';

                html += '</ul>';

                html += '<p align="justify">';
                html += '2.1) Cuando el usuario acceda a través de las aplicaciones: Facebook®, Facebook Pages®, Facebook Camera® y Facebook Messenger® a alguna de la funcionalidades que a continuación se enlistan, el consumo de datos que se generen se cobrará conforme al paquete de datos o por evento adicional con costo según el plan contratado.';
                html += '</p>';
                html += '</p>';
                html += '<ul>';
                html += '<li style="text-align: justify;">La carga y descarga de fotos fuera de las apps oficiales de Facebook®; por ejemplo utilizando apps como: Instagram®, Retrica®, Vine®, etc.</li>';
                html += '<li style="text-align: justify;">La reproducción de videos alojados fuera de Facebook® ni la funcionalidad para compartirlos, utilizando apps como: YouTube®, Vimeo® o DailyMotion®, etc; aun cuando estos sean reproducidos o accedidos desde las apps oficiales de Facebook®.</li>';
                html += '<li style="text-align: justify;" >El redireccionamiento a cualquier link o URL externa a Facebook®; aun cuando este haya sido compartido por este medio a través de algún post o mensaje de algún contacto o grupo dentro de Facebook®. Ejemplo: notas de periódicos, artículos de revistas especializadas, descargas de aplicaciones, descargas/uso de juegos, etc.</li>';
                html += '<li style="text-align: justify;">El servicio de llamadas o servicios voz a través de la aplicación de Facebook Messenger®.Compartir mi ubicación.</li>';
                html += '<li style="text-align: justify;">Consultar la ubicación de cualquier contacto.</li>';
                html += '<li style="text-align: justify;">Servicio de VideoLlamadas, validas desde la app oficial, o apps relacionadas a facebook</li>';
                html += '</ul>';
                html += '<p align="justify">';
                html += '3) A continuación se enlistan las funcionalidades incluidas para Twitter:';
                html += '</p>';
                html += '<ul>';
                html += '<li style="text-align: justify;">Visualizar el timeline personal o de terceros.</li>';
                html += '<li style="text-align: justify;">Publicar un tweet.</li>';
                html += '<li style="text-align: justify;">Comentar un tweet.</li>';
                html += '<li style="text-align: justify;">Dar favorito en un tweet.</li>';
                html += '<li style="text-align: justify;">Retwitter un tweet.</li>';
                html += '<li style="text-align: justify;">Citar tweet.</li>';
                html += '<li style="text-align: justify;">Enviar un mensaje directo.</li>';
                html += '<li style="text-align: justify;">Recibir notificaciones.</li>';
                html += '<li style="text-align: justify;">Publicar o cargar fotos en tu timeline.</li>';
                html += '<li style="text-align: justify;">Descargar fotos.</li>';
                html += '<li style="text-align: justify;">Compartir mi ubicación.</li>';
                html += '</ul>';
                html += '<p align="justify">';
                html += '3.2). Cuando el usuario acceda a través de la aplicación para Twitter® a alguna de la funcionalidades que a continuación se enlistan, el consumo de datos que se generen se cobrará conforme al paquete de datos o por evento adicional con costo según el plan contratado.';
                html += '</p>';
                html += '<ul>';
                html += '<li style="text-align: justify;">La carga y descarga de fotos fuera del app oficial de Twitter®; por ejemplo, utilizando apps como: Instagram®, Retrica®, Vine®, etc.</li>';
                html += '<li style="text-align: justify;">La reproducción de videos ni la funcionalidad para compartirlos, ya sea desde el app de Twitter® o utilizando apps como: YouTube®, Vimeo® o DailyMotion®, etc.</li>';
                html += '<li style="text-align: justify;">El redireccionamiento a cualquier link o URL externa a Twitter®; aun cuando este haya sido compartido por un mensaje de Twitter®. Ejemplo: notas de períodico, artículos de revistas especializadas, descargas de aplicaciones, descargas/uso de juegos, etc..</li>';
                html += '<li style="text-align: justify;">Cualquier otra funcionalidad que no se encuentre detallada en el numeral 1 anterior, y que correspondan a innovaciiones y/o features adicionales habilitados por el proveedor de la aplicación oficial.</li>';
                html += '</ul>';
                html += '<p align="justify">';
                html += 'El uso de las aplicaciones de WhatApp, Facebook® yTwitter®, se realiza con la capacidad, calidad, velocidad y cobertura disponible en el servicio de acceso a internet de CONECEL.';
                html += '</p>';
                html += '<p align="justify">';
                html += 'En caso de identificarse el mal uso de los servicios descritos en el presente documento o que puedan agregarse en el tiempo y en cumplimiento del procedimiento pre establecido en el artículo 25 numeral 2 de la Ley Orgánica de Telecomunicaciones, CONECEL   se reserva el derecho de bloquear y/o suspender el servicio objeto de mala práctica o de terminar anticipadamente el contrato de prestación de servicios de telecomunicaciones que posea con los abonados/clientes o usuarios, cuando éste incurra en  dicho incumplimiento, tomando en cuenta que el mal uso del servicio constituiría un incumplimiento de contrato por parte de los abonados/clientes o usuarios.';
                html += '</p>';

                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">&nbsp;</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">______________</span></p>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">Firma</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + rep_legal + '</span></p></div>';
                html += '<p style="text-align: justify;"><span style="font-size:12px;">' + pjuridico + '</span></p></div>';

                html += '</center></body></html>';
                docprint.document.write(html);
                docprint.document.close();
                docprint.focus();

                break;
        }
    } else {
        alertToast("Debe de checkear por lo menos una linea", 2500);
    }


})
;
$("#estado_solicitud_credito").on('change', function () {

    var select = document.getElementById("estado_solicitud_credito"), //El <select>
        value = select.value, //El valor seleccionado
        text = select.options[select.selectedIndex].innerText;

    if (this.value != '') {
        switch (text) {
            case 'DEUDA CREDITO':
                $("#creditoAdendum").show();
                break;
            default:
                $("#creditoAdendum").hide();
                break;
        }
    }
});
$("#inicio_deuda").on('change', function () {
    var fecha_ini = $('#inicio_deuda').val();
    var date_1 = new Date(fecha_ini);
    var date_2 = new Date();

    var hoy = new Date();
    var dia = hoy.getDate();
    var mes = hoy.getMonth() + 1;
    var anio = hoy.getFullYear();

    var fecha_actual = String(anio + "-" + mes + "-" + dia);

    if (validate_fechaMayorQue(fecha_ini, fecha_actual) != 0) {
        var day_as_milliseconds = 86400000;
        var diff_in_millisenconds = date_2 - date_1;
        var dias = diff_in_millisenconds / day_as_milliseconds;
        if ($('#inicio_deuda').val() != '' && $('#inicio_deuda').val() != null) {
            $("#tiempo_vencido").val(parseInt(dias) + ' ' + 'días');
        } else {
            $("#tiempo_vencido").val(0 + ' ' + 'días');
        }
    } else {
        $("#tiempo_vencido").val(0);

    }
});

function validate_fechaMayorQue(fechaInicial, fechaFinal) {
    valuesStart = fechaInicial.split("-");
    valuesEnd = fechaFinal.split("-");

    // Verificamos que la fecha no sea posterior a la actual
    var dateStart = new Date(valuesStart[0], (valuesStart[1] - 1), valuesStart[2]);
    var dateEnd = new Date(valuesEnd[0], (valuesEnd[1] - 1), valuesEnd[2]);
    if (dateStart > dateEnd) {
        return 0;
    }
    return 1;
}

$("#otros_ce").on({
    "focus": function (event) {
        $(event.target).select();
    },
    "keyup": function (event) {
        $(event.target).val(function (index, value) {
            return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, "");
        });
        sumarDeudaCredito();
    },

});
$("#adendum_ce").on({
    "focus": function (event) {
        $(event.target).select();
    },
    "keyup": function (event) {
        $(event.target).val(function (index, value) {
            return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, "");
        });
        sumarDeudaCredito();
    },

});
$("#financiamiento_ce").on({
    "focus": function (event) {
        $(event.target).select();
    },
    "keyup": function (event) {
        $(event.target).val(function (index, value) {
            return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, "");
        });
        sumarDeudaCredito();
    },

});
$("#castigo_cartera_ce").on({

    "focus": function (event) {
        $(event.target).select();
    },
    "keyup": function (event) {
        $(event.target).val(function (index, value) {
            return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, "");
        });
        sumarDeudaCredito();
    },


});
$("#consumo_ce").on({
    "focus": function (event) {
        $(event.target).select();
    },
    "keyup": function (event) {
        $(event.target).val(function (index, value) {
            return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, "");
        });
        sumarDeudaCredito();

    },

});


function sumarDeudaCredito() {
    if ($("#consumo_ce").val() == null || $("#consumo_ce").val() == '') {
        $("#consumo_ce").val(0);
    }
    if ($("#castigo_cartera_ce").val() == null || $("#castigo_cartera_ce").val() == '') {
        $("#castigo_cartera_ce").val(0);
    }
    if ($("#financiamiento_ce").val() == null || $("#financiamiento_ce").val() == '') {
        $("#financiamiento_ce").val(0);
    }
    if ($("#adendum_ce").val() == null || $("#adendum_ce").val() == '') {
        $("#adendum_ce").val(0);
    }
    if ($("#otros_ce").val() == null || $("#otros_ce").val() == '') {
        $("#otros_ce").val(0);
    }
    var consumo_ce = parseFloat($("#consumo_ce").val());
    var castigo_cartera_ce = parseFloat($("#castigo_cartera_ce").val());
    var financiamiento_ce = parseFloat($("#financiamiento_ce").val());
    var adendum_ce = parseFloat($("#adendum_ce").val());
    var otros_ce = parseFloat($("#otros_ce").val());

    var suma = consumo_ce + castigo_cartera_ce + financiamiento_ce + adendum_ce + otros_ce;

    $("#total_ce").val(suma.toFixed(2));
}

$("#bandejaSeguimiento").on('change', function () {

    if (this.value != '') {

        switch (this.value) {
            case '0':
                //pendiente de estado
                changeDatatable(0);

                break;
            case '1':

                //bandeja
                changeDatatable(1);

                break;
            case '2':
                //saliente
                changeDatatable(2);

                break;

        }
    }
});

$(document).ready(function () {
    $(function () {
        changeDatatable(0);
        ocultars();
        $("#facturado").hide();
        $("#regularizado").hide();
        changeDatatable3();
        $("#asesorh").hide();

    });
});

function ocultars() {
    $("#asesorh").hide();
    $('#dtmenu2').DataTable().destroy();
    $("#contenidoBANDEJA_CREDITO").hide();
    $("#contenidoBANDEJA_CALIDAD").hide();
    $("#contenidoBANDEJA_RECEPCION").hide();
    $("#contenidoBANDEJA_REGULARIZACION").hide();
    $("#contenido").hide();
    $("#dtmenu22").hide();
    $("#creditoAdendum").hide();
}

function viewChanges(id, bandeja, salida) {

    ocultars();
    $("#contenido").show();
    document.getElementById("identificacion").disabled = true;
    $('#formulario').find('input, textarea, button, select').attr('disabled', true);
    busquedaDatos(0, id, bandeja, salida);
    if (salida == 0) {
        var valida = 0;
        var objApiRest = new AJAXRest('/lider/CambioEstados', {
            bandeja: bandeja,
            solicitud: id,
            valida: valida,
            verifica: 1
        }, 'post');
        objApiRest.extractDataAjax(function (_resultContent) {

            if (_resultContent.status == 200) {
                $("#contenido" + bandeja).show();
            } else {
                ocultars();
            }
        });
    }
}

function viewChangesPro(usuario_ing,
                        n_solicitud,
                        entrega_ciudad_id,
                        direccion_entrega,
                        provincia_id,
                        region,
                        fecha_lote,
                        lote,
                        ciclo_facturacion,
                        fecha_activacion,
                        fecha_facturacion,
                        celular_entrega,
                        estado,
                        empleado_id,
                        gestor_id,
                        cliente_id,
                        usuario_mod,
                        created_at,
                        updated_at,
                        observacion,
                        tchip,
                        tobsequios,
                        tlineas,
                        n_solicitud_axis,
                        name,
                        identificacion,
                        tipo_persona,
                        nombres,
                        correo,
                        cedula_RL,
                        nombre_RL,
                        fecha_vence_emp,
                        cargo_RL,
                        direccion_domicilio,
                        referencia_domicilio,
                        convencional,
                        convencional_perteneciente,
                        movil,
                        ciudad_domicilio_id,
                        provincia_domicilio_id,
                        fecha_nacimiento,
                        created_at,
                        updated_at,
                        usuario_ing,
                        usuario_mod,
                        estado,
                        estado_civil,
                        empresa,
                        direccion_laboral,
                        ciudad_laboral_id,
                        provincia_laboral_id,
                        convencional_laboral,
                        cargo,
                        tiempo_laboral,
                        ingresos_laboral,
                        forma_pago,
                        banco_id,
                        cta_ahorro,
                        cta_corriente,
                        nombre_tarjeta,
                        numero_tarjeta,
                        codigo_seguridad_tarjeta,
                        vencimiento_tarjeta,
                        cupo,
                        deuda,
                        valor_garantia, bandeja, salida, deposito_garantia, adendum_cdc,
                        castigo_cartera_cdc,
                        consumo_cdc,
                        financimiento_cdc,
                        otros_cdc,
                        total_cdc,
                        inicio_deuda) {

    contadorObsequios = 0;

    $("#consumo_ce").val(consumo_cdc);
    $("#castigo_cartera_ce").val(castigo_cartera_cdc);
    $("#financiamiento_ce").val(financimiento_cdc);
    $("#adendum_ce").val(adendum_cdc);
    $("#otros_ce").val(otros_cdc);
    $("#total_ce").val(total_cdc);


    if (inicio_deuda != null && inicio_deuda != '') {
        $("#inicio_deuda").val(inicio_deuda);
        var fecha_ini = inicio_deuda;
        var date_1 = new Date(fecha_ini);
        var date_2 = new Date();

        var hoy = new Date();
        var dia = hoy.getDate();
        var mes = hoy.getMonth() + 1;
        var anio = hoy.getFullYear();

        var fecha_actual = String(anio + "-" + mes + "-" + dia);
        if (validate_fechaMayorQue(fecha_ini, fecha_actual) != 0) {
            var day_as_milliseconds = 86400000;
            var diff_in_millisenconds = date_2 - date_1;
            var dias = diff_in_millisenconds / day_as_milliseconds;
            $("#tiempo_vencido").val(parseInt(dias) + ' ' + 'días');
        } else {
            $("#tiempo_vencido").val(0);

        }
    } else {
        $("#inicio_deuda_sp").text('--/--/--');
        $("#tiempo_v").text(0);

    }


    $("#n_solicitud_axis").val(n_solicitud_axis);
    $("#fecha_activacion").val(fecha_activacion);
    $("#ciclo_facturacion").val(ciclo_facturacion);
    $("#fecha_facturacion").val(fecha_facturacion);
    $("#lote").val(lote);
    $("#fecha_lote").val(fecha_lote);

    var objApiRest = new AJAXRest('/asesor/concatenaObservaciones', {
        solicitud_id: n_solicitud
    }, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {

        if (_resultContent.status == 200) {
            $.each(_resultContent.message, function (_key, _value) {
                console.log(_key);
                switch (_key) {
                    case 'BANDEJA_VALIDACION':
                        $("#bvalidacion").text(_value.join('//'));
                        break;
                    case 'BANDEJA_CREDITO':
                        $("#bcredito").text(_value.join('//'));
                        break;
                    case 'BANDEJA_CALIDAD':
                        $("#bcalidad").text(_value.join('//'));
                        break;
                    case 'BANDEJA_RECEPCION':
                        $("#brecepcion").text(_value.join('//'));
                        break;
                    case 'BANDEJA_REGULARIZACION':
                        $("#bregularizacion").text(_value.join('//'));
                        break;
                }
            });

        }
    });
    if (salida == 1) {
        $("#observaciones").hide();

    } else {
        $("#observaciones").show();

    }

    $("#asesorh").hide();
    ocultars();
    $("#contenido").show();
    document.getElementById("identificacion").disabled = true;
    var dato = 0;
    var objApiRest1 = new AJAXRest('/asesor/SearchCedula', {dato: dato, solicitud_id: n_solicitud}, 'post');
    objApiRest1.extractDataAjax(function (_resultContent) {
        $('#formulario').find('input, textarea, button, select').attr('disabled', true);

        switch (_resultContent.status) {
            case 300:
                limpiar();
                id = 0;
                var iden = 0;
                var clineas = 0;
                if (_resultContent.lineas != 0) {
                    var c = 0;
                    $.each(_resultContent.lineas, function (_key, _value) {
                        Add();
                        c = id - 1;

                        datos_lineas(_value, c, bandeja);

                    });

                }
                $('input[name="control"]').val(1);
                $('input[name^="identificacion"]').val(identificacion);
                $('input[name^="tipo_persona"]').val(tipo_persona);
                switch (tipo_persona) {
                    case 'JURIDICO':
                        juridico();

                        break;
                    default:
                        natural();
                        break;
                }
                if (deposito_garantia == 1) {
                    document.getElementById("deposito_garantia").checked = true;
                } else {
                    document.getElementById("deposito_garantia").checked = false;
                }
                $('input[name^="name_natural"]').val(nombres);
                $('input[name^="email_natural"]').val(correo);
                $('input[name^="fecha_nacimiento_natural"]').val(fecha_nacimiento);
                $('select[name^="civil_natural"]').val(estado_civil).change();
                $('input[name^="razon_juridico"]').val(nombres);
                $('input[name^="cedula_rl_juridico"]').val(cedula_RL);
                $('input[name^="fecha_vencimiento_juridico"]').val(fecha_vence_emp);
                $('input[name^="email_juridico"]').val(correo);
                $('input[name^="nombre_rl_juridico"]').val(nombre_RL);
                $('input[name^="cargo_rl_juridico"]').val(cargo_RL);
                $('input[name^="domicilio_natural"]').val(direccion_domicilio);
                $('input[name^="referencia_natural"]').val(referencia_domicilio);
                $('input[name^="convencional_natural"]').val(convencional);
                $('select[name^="cperteneciente_natural"]').val(convencional_perteneciente).change();
                $('input[name^="celular_natural"]').val(movil);
                $("#dprovincia").val(provincia_domicilio_id).change();
                $('#dciudadi').val(ciudad_domicilio_id).change();
                $('input[name^="razon_laborales"]').val(empresa);
                $('input[name^="direccion_laborales"]').val(direccion_laboral);
                $('select[name^="lprovincia_laborales"]').val(provincia_laboral_id).change();
                $('#dlaboralesi').val(ciudad_laboral_id).change();
                $('input[name^="convencional_laborales"]').val(convencional_laboral);
                $('input[name^="cargo_laborales"]').val(cargo);
                $('input[name^="tiempo_laborales"]').val(tiempo_laboral);
                $('input[name^="ingresos_laborales"]').val(ingresos_laboral);
                $('select[name^="forma_pago"]').val(forma_pago).change();
                $('input[name^="valor_garantia"]').val(valor_garantia);
                $('select[name^="banco"]').val(banco_id).change();
                if (cta_ahorro != null && cta_ahorro != '') {
                    $('select[name^="tipo_cuenta_banco"]').val("AHORRO").change();
                    $('input[name^="n_cuenta_banco"]').val(cta_ahorro);
                }
                if (cta_corriente != null && cta_corriente != '') {
                    $('select[name^="tipo_cuenta_banco"]').val("CORRIENTE").change();
                    $('input[name^="n_cuenta_banco"]').val(cta_corriente);
                }
                $('input[name^="tarjeta"]').val(nombre_tarjeta);
                $('input[name^="n_tarjeta"]').val(numero_tarjeta);
                $('input[name^="codigo_tarjeta"]').val(codigo_seguridad_tarjeta);
                $('input[name^="fecha_caducidad_tarjeta"]').val(vencimiento_tarjeta);

                $('input[name="control_solicitud"]').val(1);
                $('input[name="n_solicitud"]').val(n_solicitud);
                $('input[name="direccion_entrega"]').val(direccion_entrega);
                $('select[name="provincia_entrega"]').val(provincia_id).change();
                $('select[name="region_entrega"]').val(region).change();
                $('input[name="celular_entrega"]').val(celular_entrega);
                $('select[name="gestor"]').val(gestor_id).change();
                $("#usuario").val(name);

                $('textarea[name="observacion"]').val(observacion);
                $('input[name="tchip"]').val(tchip);
                $('input[name="tobsequios"]').val(contadorObsequios);
                $('#dentregai').val(entrega_ciudad_id).change();

                //datos de solicitud - con estado

                $('[name="solicitud_axis_s"]').val(n_solicitud_axis);
                $('[name="fecha_activa_s"]').val(fecha_activacion);
                $('[name="ciclo_factura_s"]').val(ciclo_facturacion);
                $('[name="fecha_factura_s"]').val(fecha_facturacion);
                $("#lote_s").val(lote);
                $('[name="fecha_lote_s"]').val(fecha_lote);

                $('#formulario').find('input, textarea, button, select').css('border', '1px solid');
                $('#formulario').find('input, textarea, button, select').css('border-color', '#d2d6de');

                document.getElementById("identificacion").disabled = true;
                document.getElementById("tipo_persona").disabled = true;
                document.getElementById("usuario").disabled = true;

                $("#tobsequios").attr('disabled', true);
                $("#n_solicitud").attr('disabled', true);
                $("#tlineas").attr('disabled', true);

                //Solicitud Axis
                $('[name="solicitud_axis_s"]').attr('disabled', true);
                $('[name="fecha_activa_s"]').attr('disabled', true);
                $('[name="ciclo_factura_s"]').attr('disabled', true);
                $('[name="fecha_factura_s"]').attr('disabled', true);
                $('[name="lote_s"]').attr('disabled', true);
                $('[name="fecha_lote_s"]').attr('disabled', true);

                switch (tipo_persona) {
                    case 'JURIDICO':
                        mostrar();
                        juridico();
                        break;
                    default:
                        mostrar();
                        natural();
                        break;
                }

                switch (bandeja) {

                    case 'BANDEJA_CREDITO':

                        $('[name*="as1["]').show();
                        document.getElementById("region").disabled = false;
                        //  $('[name*="formatos_imprimir"').attr('disabled', true);

                        document.getElementById("btnImprimir").disabled = false;
                        document.getElementById("formatos_imprimir").disabled = false;

                        $('[name*="addequipo["]').attr('disabled', true);
                        $('Input[name*="addmarca["]').attr('disabled', true);
                        $('Input[name*="addmodelo["]').attr('disabled', true);
                        $('Input[name*="addimei["]').attr('disabled', false);

                        $('[name*="addaxisestado["]').attr('disabled', false);
                        $('[name*="addaxis["]').attr('disabled', false);
                        break;
                    case 'BANDEJA_CALIDAD':

                        $('[name*="addaxisestado["]').attr('disabled', true);
                        $('[name*="addaxis["]').attr('disabled', true);
                        if (salida == 1) {
                            $('[name*="simcard"]').show();

                        } else {
                            $('[name*="simcard"]').show();
                            $('[name*="simcard"]').attr('disabled', false);
                        }
                        break;
                    case 'BANDEJA_RECEPCION':
                        $('[name*="addaxisestado["]').attr('disabled', true);
                        $('[name*="addaxis["]').attr('disabled', true);
                        if (salida == 1) {
                            $('[name*="simcard"]').show();
                            $('[name*="cobsequio1"]').show();
                            $('[name*="cobsequio2"]').show();

                        } else {
                            $('[name*="addaxisestado["]').attr('disabled', true);
                            $('[name*="addaxis["]').attr('disabled', true);
                            $('[name*="simcard"]').show();
                            $('[name*="cobsequio1"]').show();
                            $('[name*="cobsequio2"]').show();
                            $('[name*="cobsequio1"]').attr('disabled', false);
                            $('[name*="cobsequio2"]').attr('disabled', false);
                            document.getElementById("provincia_entrega").disabled = false;
                            document.getElementById("dato_entrega_ciudad").disabled = false;
                        }
                        break;
                    case 'BANDEJA_REGULARIZACION':
                        $('[name*="addaxisestado["]').attr('disabled', true);
                        $('[name*="addaxis["]').attr('disabled', true);
                        if (salida == 1) {
                            $('[name*="simcard"]').show();
                            $('[name*="cobsequio1"]').show();
                            $('[name*="cobsequio2"]').show();
                        }
                        else {
                            $('[name*="simcard"]').show();
                            $('[name*="cobsequio1"]').show();
                            $('[name*="cobsequio2"]').show();
                        }
                        break;
                }

                alertToastSuccess("Registro Encontrado", 3500);
                break;

        }

        if (salida != 0) {
            $('#formulario').find('input, textarea, button, select').attr('disabled', true);
            $('[name*="add"]').attr('disabled', true);
        }
        $('[name*="ddiaddborra"]').hide();
        $("#agregaitem").hide();
        $('#formulario').find('input, textarea, button, select').css('border', '0');
        $('#item').find('input, textarea, button, select').css('border', '0');

    });


    if (salida == 0) {
        var valida = 0;
        var objApiRest = new AJAXRest('/lider/CambioEstados', {
            bandeja: bandeja,
            solicitud: n_solicitud,
            valida: valida,
            verifica: 1
        }, 'post');
        objApiRest.extractDataAjax(function (_resultContent) {

            if (_resultContent.status == 200) {
                $("#contenido" + bandeja).show();
            } else {
                ocultars();
            }
        });
    }

}

function changeDatatable3() {
    $('#dtmenu3').DataTable().destroy();
    $('#tbobymenu3').html('');

    $('#dtmenu3').show();
    $.fn.dataTable.ext.errMode = 'throw';
    $('#dtmenu3').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                'print'
            ],
            responsive: true, "oLanguage":
                {
                    "sUrl": "/js/config/datatablespanish.json"
                },
            "lengthMenu": [[10, -1], [10, "All"]],
            "order": [[1, 'desc']],
            "searching": true,
            "info": false,
            "ordering": false,
            "bPaginate": true,
            "processing": true,
            "serverSide": true,
            "deferRender": true,
            "destroy": true,
            "ajax": "/asesordepartamental/datatableDepartamentoSalida/",
            "columns": [

                {data: 'Contacto', "width": "10%"},
                {data: 'Cliente', "width": "15%"},
                {data: 'Solicitud', "width": "10%"},
                {data: 'Asesor', "width": "15%"},
                {data: 'Fecha_c', "width": "10%"},
                {data: 'Fecha_e', "width": "10%"},
                {data: 'Estado_Solicitud', "width": "10%"},
                {
                    data: 'estado',
                    "width": "15%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.estado).text();
                    }
                },

            ],

        }).ajax.reload();


}

function changeDatatable(dato) {
    $('#dtmenu').DataTable().destroy();
    $('#tbobymenu').html('');

    $('#dtmenu').show();
    $.fn.dataTable.ext.errMode = 'throw';
    $('#dtmenu').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                'print'
            ],
            responsive: true, "oLanguage":
                {
                    "sUrl": "/js/config/datatablespanish.json"
                },
            "lengthMenu": [[10, -1], [10, "All"]],
            "order": [[1, 'desc']],
            "searching": true,
            "info": false,
            "ordering": false,
            "bPaginate": true,
            "processing": true,
            "serverSide": true,
            "deferRender": true,
            "destroy": true,
            "ajax": "/asesordepartamental/datatableDepartamentoS/" + dato,
            "columns": [

                {data: 'Contacto', "width": "10%"},
                {data: 'Cliente', "width": "15%"},
                {data: 'Solicitud', "width": "10%"},
                {data: 'Asesor', "width": "15%"},
                {data: 'Fecha_c', "width": "10%"},
                {data: 'Fecha_e', "width": "10%"},
                {data: 'Estado_Solicitud', "width": "10%"},
                {
                    data: 'estado',
                    "width": "15%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.estado).text();
                    }
                },

            ],

        }).ajax.reload();


}

function changeDatatable2(id) {
    $('#dtmenu2').DataTable().destroy();
    $('#tbobymenu2').html('');

    $('#dtmenu22').show();
    $.fn.dataTable.ext.errMode = 'throw';
    $('#dtmenu2').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                'print'
            ],
            responsive: true, "oLanguage":
                {
                    "sUrl": "/js/config/datatablespanish.json"
                },
            "lengthMenu": [[10, -1], [10, "All"]],
            "order": [[1, 'desc']],
            "searching": true,
            "info": false,
            "ordering": false,
            "bPaginate": true,
            "processing": true,
            "serverSide": true,
            "deferRender": true,
            "destroy": true,
            "ajax": "/asesordepartamental/datatableDepartamentoSB/" + id,
            "columns": [

                {data: 'Usuario', "width": "10%"},
                {data: 'Observacion', "width": "40%"},
                {data: 'Fecha_e', "width": "10%"},
                {data: 'Tiempo', "width": "10%"},
                {
                    data: 'Estado_Solicitud',
                    "width": "10%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.Estado_Solicitud).text();
                    }
                },
                {data: 'departamento', "width": "10%"},

                {
                    data: 'estado',
                    "width": "10%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.estado).text();
                    }
                },

            ],

        }).ajax.reload();


}

function SeguimientoChanges(id, identificacion,
                            tipo_persona, nombres,
                            fecha_lote, lote,
                            ciclo_facturacion,
                            fecha_activacion,
                            fecha_facturacion,
                            tchip, tobsequios, tlineas, Asesor, uestado, adendum_sp, castigoc_sp, consumo_sp, financiamiento_sp, tcredito_sp, otros_sp, region, inicio_deuda) {

    $("#observaciones").hide();

    var clase = '';
    var u = 1;
    ocultars();
    $("#dtmenu22").show();
    changeDatatable2(id);
    $("#asesorh").show();

    $("#estado_sg").text(uestado);

    if (uestado == 'DEUDA CREDITO') {
        $("#destado_sg").show();
        $("#adendum_sp").text(adendum_sp);
        $("#castigoc_sp").text(castigoc_sp);
        $("#consumo_sp").text(consumo_sp);
        $("#financiamiento_sp").text(financiamiento_sp);
        $("#tcredito_sp").text(tcredito_sp);
        $("#otros_sp").text(otros_sp);
        if (inicio_deuda != null && inicio_deuda != '') {
            $("#inicio_deuda_sp").text(inicio_deuda);
            var fecha_ini = inicio_deuda;
            var date_1 = new Date(fecha_ini);
            var date_2 = new Date();

            var hoy = new Date();
            var dia = hoy.getDate();
            var mes = hoy.getMonth() + 1;
            var anio = hoy.getFullYear();

            var fecha_actual = String(anio + "-" + mes + "-" + dia);

            if (validate_fechaMayorQue(fecha_ini, fecha_actual) != 0) {
                var day_as_milliseconds = 86400000;
                var diff_in_millisenconds = date_2 - date_1;
                var dias = diff_in_millisenconds / day_as_milliseconds;
                $("#tiempo_v").text(parseInt(dias) + ' ' + 'días');
            } else {
                $("#tiempo_v").text(0);

            }
        } else {
            $("#inicio_deuda_sp").text('--/--/--');
            $("#tiempo_v").text(0);

        }


        clase = 'col-lg-12';
        u = 0;
    } else {
        $("#destado_sg").hide();
        $("#adendum_sp").text(0);
        $("#castigoc_sp").text(0);
        $("#consumo_sp").text(0);
        $("#financiamiento_sp").text(0);
        $("#tcredito_sp").text(0);
        $("#otros_sp").text(0);

    }

    $('[name*=obsequioR]').remove();
    var objApiRest = new AJAXRest('/asesor/CantidadObsequio', {
        solicitud_id: id
    }, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {

        if (_resultContent.status == 200) {
            $("#cantidadObsequios").append("<div name='icantidadobsequioR' class='" + clase + "' ><div name='dcantidadobsequioR' class='col-lg-12'><hr/></div><h5 name='hcantidadobsequioR' style='color: #4985d2;text-decoration: underline'><strong>Obsequios:</strong>");
            $.each(_resultContent.message, function (_key, _value) {
                if (u == 1) {
                    $("#cantidadObsequios").append("<h5 name='encantidadobsequioR'>");
                }
                $("#cantidadObsequios").append("<strong name='kcantidadobsequioR' style='color: #4985d2;margin-left:10px' class='" + clase + "'>" + _key + ":<span  name='vcantidadobsequioR'style='margin-right:10px'>" + _value + "</span></strong>");
                if (u == 1) {
                    $("#cantidadObsequios").append("</h5>");
                }
            });
            $("#cantidadObsequios").append("<div name='lcantidadobsequioR' class='col-lg-12'><hr/></div>");

            $("#cantidadObsequios").append("</h5></div>");

        }
    });

    $("#asesor_sg").text(Asesor);
    $("#n_solicitud_sg").text(id);
    $("#identificacion_sg").text(identificacion);
    $("#cliente_sg").text(nombres);
    $("#ciclo_fact_sg").text(ciclo_facturacion);

    $("#fecha_activa_sg").text(fecha_activacion);
    $("#fecha_lote_sg").text(fecha_lote);
    $("#fecha_fact_sg").text(fecha_facturacion);
    $("#lote_sg").text(lote);
    $("#region_sg").text(region);

    if (ciclo_facturacion != null && ciclo_facturacion != '') {
        $("#ciclo_fact_sg").text(ciclo_facturacion);

    } else {
        $("#ciclo_fact_sg").text('Aun no definido');

    }


    if (fecha_facturacion != null && fecha_facturacion != '') {
        $("#fecha_fact_sg").text(fecha_facturacion);

    } else {
        $("#fecha_fact_sg").text('Aun no definido');

    }

    if (fecha_lote != null && fecha_lote != '') {
        $("#fecha_lote_sg").text(fecha_lote);

    } else {
        $("#fecha_lote_sg").text('Aun no definido');

    }
    if (lote != null && lote != '') {
        $("#lote_sg").text(lote);

    } else {
        $("#lote_sg").text('Aun no definido');

    }

    if (fecha_activacion != null && fecha_activacion != '') {
        $("#fecha_activa_sg").text(fecha_activacion);

    } else {
        $("#fecha_activa_sg").text('Aun no definido');

    }


    if (tlineas != null && tlineas != '') {
        $("#n_lineas_sg").text(tlineas);

    } else {
        $("#n_lineas_sg").text(0);

    }
    if (tchip != null && tchip != '') {
        $("#n_chip_sg").text(tchip);

    } else {
        $("#n_chip_sg").text(0);

    }
}


$("#btnEstadoCredito").on('click', function () {
    var observacion = $("#observacion_credito").val();

    var estado = $("#estado_solicitud_credito").val();
    var solicitud_id = $("#n_solicitud").val();
    var bandeja = 'BANDEJA_CREDITO';
    var band = 1;
    if (estado != null && estado != 0) {
        cambioEstado(observacion, estado, solicitud_id, bandeja, band);
    } else {
        alertToast("Seleccione un estado para la solictud", 4500);
    }


});
$("#btnEstadoCalidad").on('click', function () {
    var observacion = $("#observacion_calidad").val();

    var estado = $("#estado_solicitud_calidad").val();
    var solicitud_id = $("#n_solicitud").val();
    var bandeja = 'BANDEJA_CALIDAD';
    var band = 2;

    if (estado != null && estado != 0) {
        cambioEstado(observacion, estado, solicitud_id, bandeja, band);
    } else {
        alertToast("Seleccione un estado para la solictud", 4500);
    }


});
$("#btnEstadoRecepcion").on('click', function () {
    var observacion = $("#observacion_recepcion").val();

    var estado = $("#estado_solicitud_recepcion").val();
    var solicitud_id = $("#n_solicitud").val();
    var bandeja = 'BANDEJA_RECEPCION';
    var band = 3;

    if (estado != null && estado != 0) {
        cambioEstado(observacion, estado, solicitud_id, bandeja, band);
    } else {
        alertToast("Seleccione un estado para la solictud", 4500);
    }


});
$("#btnEstadoRegularizacion").on('click', function () {


    var observacion = $("#observacion_regularizacion").val();

    var estado = $("#estado_solicitud_regularizacion").val();
    var solicitud_id = $("#n_solicitud").val();
    var bandeja = 'BANDEJA_REGULARIZACION';
    var band = 6;

    var select = document.getElementById("estado_solicitud_regularizacion"), //El <select>
        value = select.value, //El valor seleccionado
        text = select.options[select.selectedIndex].innerText;


    switch (text) {
        case 'REGULARIZADO ACT':
            band = 5;
            break;
        case 'FACTURA ACT':
            band = 4;
            break;
    }

    if (estado != null && estado != 0) {
        cambioEstado(observacion, estado, solicitud_id, bandeja, band);
    } else {
        alertToast("Seleccione un estado para la solictud", 4500);
    }


});

function recargar() {
    $('#dtmenu').dataTable()._fnAjaxUpdate();
    $('#dtmenu3').dataTable()._fnAjaxUpdate();


}

function recargar2() {
    $('#dtmenu2').dataTable()._fnAjaxUpdate();
}

function cambioEstado(observacion, estado, solicitud_id, bandeja, band) {

    if (band != 4) {
        var lineas = [];
        var lineaclean = [];
        var ic = 0;
        $('[name^="add"]').each(function () {
            lineas.push($(this).val());
        });


        var n_lineas = parseInt(lineas.length) / 31;

        do {

            lineaclean[ic] = lineas.splice(0, 31);

            ic++;
        } while (ic < (n_lineas));

        var lineaclean = lineaclean.filter(Boolean);

    }
    else {
        var lineaclean = 0;
    }
    var region = 0;
    var ciudad_entrega = 0;
    var fecha_activacion = 0;
    var ciclo_facturacion = 0;
    var fecha_facturacion = 0;
    var lote = 0;
    var fecha_lote = 0;
    var solicitud_axis = 0;
    var alerta = 0;
    var provincia_entrega = 0;


    var adendum_cdc = 0;
    var castigo_cartera_cdc = 0;
    var consumo_cdc = 0;
    var financimiento_cdc = 0;
    var otros_cdc = 0;
    var total_cdc = 0;
    var inicio_deuda = 0;

    var select = document.getElementById("estado_solicitud_credito"), //El <select>
        value = select.value, //El valor seleccionado
        text = select.options[select.selectedIndex].innerText;

    var deudavalida = 0;
    switch (text) {
        case 'DEUDA CREDITO':
            if ($("#total_ce").val() == 0) {
                alertToast("Debe de haber un valor ingresado por deuda", 3500);
                var deudavalida = 1;

            } else {
                consumo_cdc = $("#consumo_ce").val();
                castigo_cartera_cdc = $("#castigo_cartera_ce").val();
                financimiento_cdc = $("#financiamiento_ce").val();
                adendum_cdc = $("#adendum_ce").val();
                otros_cdc = $("#otros_ce").val();
                total_cdc = $("#total_ce").val();
                inicio_deuda = $("#inicio_deuda").val();
                if (inicio_deuda == '' || inicio_deuda == null) {
                    alertToast("Debe Ingresar el inicio de la deuda", 3500);
                    var deudavalida = 1;

                }
            }

            break;
        case 'APROBADO CREDITO':
            solicitud_axis = $("#n_solicitud_axis").val();

            break;
        default:
            break;
    }

    if (deudavalida == 0) {
        switch (band) {
            case 1:
                region = $("#region").val();
                solicitud_axis = $("#n_solicitud_axis").val();
                if (region == null || region == 0) {
                    alerta = "Region";
                }

                break;
            case 3:
                ciudad_entrega = $("#dato_entrega_ciudad").val();
                provincia_entrega = $("#provincia_entrega").val();
                if (ciudad_entrega == null || ciudad_entrega == 0) {
                    alerta = "Ciudad de Entrega";
                }
                if (provincia_entrega == null || provincia_entrega == 0) {
                    alerta = "Provincia de Entrega";
                }

                break;
            case 4:
                var fecha_activacion = $("#fecha_activacion").val();
                var ciclo_facturacion = $("#ciclo_facturacion").val();
                var fecha_facturacion = $("#fecha_facturacion").val();
                if (fecha_activacion == null || fecha_activacion == 0) {
                    alerta = "Fecha de Activacion";
                }
                if (ciclo_facturacion == null || ciclo_facturacion == 0) {
                    alerta = "Ciclo de Facturación";
                }
                if (fecha_facturacion == null || fecha_facturacion == 0) {
                    alerta = "Fecha de Facturación";
                }
                break;
            case 5:
                var lote = $("#lote").val();
                var fecha_lote = $("#fecha_lote").val();

                if (lote == null || lote == 0) {
                    alerta = "Lote";
                }
                if (fecha_lote == null || fecha_lote == 0) {
                    alerta = "Fecha del Lote";
                }
                break;


        }
        if (alerta != 0) {
            alertToast(alerta, 4500);

        } else {
            var objApiRest = new AJAXRest('/lider/EstadosBandeja', {
                    observacion: observacion,
                    estado: estado,
                    solicitud_id: solicitud_id,
                    bandeja: bandeja,
                    lineas: lineaclean,
                    region: region,
                    ciudad_entrega: ciudad_entrega,
                    provincia_entrega: provincia_entrega,
                    fecha_activacion: fecha_activacion,
                    ciclo_facturacion: ciclo_facturacion,
                    fecha_facturacion: fecha_facturacion,
                    lote: lote,
                    fecha_lote: fecha_lote,
                    band: band,
                    solicitud_axis: solicitud_axis,
                    consumo_cdc: consumo_cdc,
                    castigo_cartera_cdc: castigo_cartera_cdc,
                    financimiento_cdc: financimiento_cdc,
                    adendum_cdc: adendum_cdc,
                    otros_cdc: otros_cdc,
                    total_cdc: total_cdc,
                    inicio_deuda: inicio_deuda
                },
                'post'
                )
            ;
            objApiRest.extractDataAjax(function (_resultContent) {
                if (_resultContent.status == 200) {
                    alertToastSuccess(_resultContent.message, 4500);
                    location.reload();

                } else {

                    alertToast(_resultContent.message, 4500);

                }
            });
        }
    }

}


$("#estado_solicitud_regularizacion").on('change', function () {

    $("#fecha_activacion").html('');
    $("#fecha_facturacion").html('');
    $("#lote").html('');
    $("#fecha_lote").html('');

    var select = document.getElementById("estado_solicitud_regularizacion"), //El <select>
        value = select.value, //El valor seleccionado
        text = select.options[select.selectedIndex].innerText;

    if (this.value != '') {
        switch (text) {
            case 'FACTURA ACT':
                $("#facturado").show();
                $("#regularizado").hide();

                break;
            case 'REGULARIZADO ACT':
                $("#facturado").hide();
                $("#regularizado").show();
                break;
            default:
                $("#facturado").hide();
                $("#regularizado").hide();
                break;

        }


    }


});



$( "#n_solicitud_axis" ).keyup(function( event ) {
  console.log('...');
});


