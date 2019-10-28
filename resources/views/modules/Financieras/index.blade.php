@extends('layouts.app')

@section('contentheader_title')
  
@endsection

@section('contentheader_description')
    
@endsection


@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <style>
       .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #eee;
        }
        .divider{
            position:absolute;
            left:50%;
            top:10%;
            bottom:10%;
            border-left:1px solid #ccc;
            height: 400px;
        }
        .colorC{
            padding-left: 12px!important;
            padding-right: 15px!important;
            padding-top: 5px!important;
            padding-bottom: 12px!important;
            background-color: #2a6f93;
            height:410px;

        }
        .colorC label{
            color:#ffffff;
            font-size: 12px;
        }
        .colorC span{
            color:#ffffff;
            font-size: 12px;
        }
        .colorD{
            padding-left: 12px!important;
            padding-right: 15px!important;
            padding-top: 5px!important;
            padding-bottom: 12px!important;
            background-color: #7b7b7b;
            height:410PX;
        }
        .colorD label{
            color:#ffffff;
            font-size: 12px;
        }
        .colorD span{
            color:#ffffff;
            font-size: 12px;
        }
        .sc{
            padding-left: 12px!important;
            padding-right: 15px!important;
            padding-top: 14px!important;
            padding-bottom: 12px!important;
        }
        .sc span{
            font-size: 12px;
        }
        .sc label{
            font-size: 12px;
        }
    </style>
@endsection
@section('javascript')
    <script src="{{ url('js/modules/financiera/pago.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datepicker/') }}/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
         $(".tablinks").on("click",function(){
                    var id=$(this).val();
                    if(id=="tab5"||id=="tab6"||id=="tab7"){
                        document.getElementById("tab1").style.display = "block";
                        $("#tabdatosgenerales").addClass("active");
                    }
                    if(id=="tab1")
                    {
                        document.getElementById("tab5").style.display = "block";
                        $("#amortizacompleto").addClass("active");
                    }
            });
         $(function () {
                $('#fechaLiquidacion,#datefilterFactura,#datefilterFacturaS').datepicker({
                    formatSubmit: 'yyyy-mm-dd',
                    format: 'yyyy-mm-dd',
                    selectYears: true,
                    editable: true,
                    autoclose: true,
                    orientation: 'top'
  
                });
            });
    </script>
     <script type="text/javascript">
            $(function() {
            /*    $('.periodo').daterangepicker();*/

                      $('input[name="datefilterPeriodo"]').daterangepicker({
                          autoUpdateInput: false,
                          locale: {
                              cancelLabel: 'Clear'
                          }
                      });

                      $('input[name="datefilterPeriodo"]').on('apply.daterangepicker', function(ev, picker) {
                          $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                          fecha_ini = picker.startDate.format('DD/MM/YYYY');
                          fecha_fin = picker.endDate.format('DD/MM/YYYY');
                      });
                    
                      $('input[name="datefilterPeriodo"]').on('cancel.daterangepicker', function(ev, picker) {
                          $(this).val('');
                      });
                            ////FECHA CONSULTA
                     
                     $('input[name="fechaconsulta"]').daterangepicker({
                                "locale": {
                                    "format": "YYYY-MM-DD",
                                    "separator": "/",
                                    "applyLabel": "Guardar",
                                    "cancelLabel": "Cancelar",
                                    "fromLabel": "Desde",
                                    "toLabel": "Hasta",
                                    "customRangeLabel": "Personalizar",
                                    "daysOfWeek": [
                                        "Do",
                                        "Lu",
                                        "Ma",
                                        "Mi",
                                        "Ju",
                                        "Vi",
                                        "Sa"
                                    ],
                                    "monthNames": [
                                        "Enero",
                                        "Febrero",
                                        "Marzo",
                                        "Abril",
                                        "Mayo",
                                        "Junio",
                                        "Julio",
                                        "Agosto",
                                        "Setiembre",
                                        "Octubre",
                                        "Noviembre",
                                        "Diciembre"
                                    ],
                                    "firstDay": 1
                                },
                                "opens": "center"
                            });

                     $('input[name="fechaconsulta"]').daterangepicker({
                          autoUpdateInput: false,
                          locale: {
                              cancelLabel: 'Clear'
                          }
                      });

                      $('input[name="fechaconsulta"]').on('apply.daterangepicker', function(ev, picker) {
                          $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
                          fecha_ini = picker.startDate.format('YYYY-MM-DD');
                          fecha_fin = picker.endDate.format('YYYY-MM-DD');
                      });
                    
                      $('input[name="fechaconsulta"]').on('cancel.daterangepicker', function(ev, picker) {
                          $(this).val('');
                      });

                    });
            </script>

@endsection
@section('content')
<div id="myModal" class="modal">
    <div class="modal-content">

        <div class="">
                                <div class="">
                                <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12">
                                            
                                                <div class="tabbable" id="tabs-555441">
                                                <div class="tabbable-line">
                                                <div class="col-lg-12" style="background-color: #f1f1f1;">
                                                    <div class="tab col-lg-11" style="float:left">
                                                        <button class="tablinks active" value="tab1" id="tabdatosgenerales">Datos Generales</button>
                                                        <button class="tablinks" value="tab2" id="bienescompleto">Facturaci&oacute;n Bienes</button>
                                                        <button class="tablinks" value="tab4" id="servicioscompleto">Facturaci&oacute;n Servicios</button>
                                                        
                                                    </div>
                                                    <div class="col-lg-1" style="float:right;">
                                                    {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b>', array('type' => 'button', 'class' => 'btn btn-danger btn-xs cerrarmodal','style'=>'float:right;margin-top:7px','id' => "btnCancelar")) !!}
                                                    </div>
                                                    <br/>
                                                </div>                                                            <div class="tab-content">
                                                                <div class="tabcontent active" id="tab1">
                                                                    <input type="hidden" id="id"/>
                                                                    <div class="col-lg-12" style="margin-top:20px!important">

                                                                    <div class="col-lg-8">
                                                                        <div class="col-lg-12">
                                                                        <span id="pseg" style="display:none">{!! $porcentajeSeguro !!}</span>
                                                                        <span id="piva" style="display:none">{!! $porcentajeIva !!}</span>
                                                                            <div class="col-lg-6">
                                                                                    <div class="col-lg-12">
                                                                                    <div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                                <label for="name" class="control-label"> Tipo/Contrato:</label><br/>
                                                                                            </div>
                                                                                            <div class="col-lg-11">
                                                                                            {!! Form::select('tipoContrato',$tipoContrato,null,['class'=>'select2','id'=>'tipoContrato']) !!}
                                                                                            </div>
                                                                                            <div class="col-lg-1">
                                                                                                <input type="checkbox" class="checkmark" value="D" id="tipoContratoD" name="tipoContratoD"/>
                                                                                            </div> 
                                                                                        </div>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                    <div class="form-group ">
                                                                                    <label for="name" class="control-label">Fecha:</label><br/>
                                                                                    {!! Form::text('fechaLiquidacion',null,['class'=>'form-control pickadate','placeholder'=>'fecha','id'=>'fechaLiquidacion']) !!}
                                                                                    </div>
                                                                            </div>
                                                                        
                                                                            <div id="divbeneficiario" class="col-lg-6">
                                                                                <div class="col-lg-11">
                                                                                    <div class="form-group ">
                                                                                    <a href="#" onclick="agregabeneficiario()"><i class="fa fa-plus"></i></a>
                                                                                    <label for="name" class="control-label">Beneficiario</label><br/>
                                                                                    {!! Form::select('beneficiario',[],NULL,['class'=>'select2','placeholder'=>'SELECCIONE','id'=>'beneficiario']) !!}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-1">
                                                                                    <div class="form-group ">
                                                                                    <label for="name" class="control-label"></label><br/>
                                                                                    
                                                                        <i  id="borrabeneficiario" class="glyphicon glyphicon-trash btn btn-xs btn-danger" onclick="borrarbeneficiario()" ></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div id="divagregabeneficiario" class="col-lg-6">
                                                                                <div class="col-lg-5">
                                                                                    <div class="form-group ">
                                                                                    <label for="name" class="control-label">Identificaci&oacute;n:</label><br/>
                                                                                    <input type="text" id="identificacionbeneficiarioagrega" class="form-control" maxlength="13" onkeypress="return soloNumeros(event)">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-5">
                                                                                    <div class="form-group ">
                                                                                        <label for="name" class="control-label">Nombres Benef.:</label><br/>
                                                                                        <input type="text" id="nombrebeneficiarioagrega" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-2">
                                                                                    <div class="form-group ">
                                                                                    <label for="name" class="control-label"></label><br/>
                                                                                    <a href="#" onclick="grababeneficiario()" class="btn btn-info btn-xs" id="grababeneficiario"><i class="fa fa-save"></i></a>
                                                                                    <a href="#" onclick="retornabeneficiario()"id="retornabeneficiario"><i class="fa fa-arrow-circle-left"></i></a>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="form-group ">
                                                                                        <label for="name" class="control-label">Area Solicitante:</label>
                                                                                        {!! Form::select('Area',$areas,null ,['class'=>'select2','id'=>'Area','placeholder'=>'SELECCIONE EL AREA']) !!}
                                                                                    </div>
                                                                            </div>  
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                        
                                                                            <div id="contratoscompleto">
                                                                                <div class="col-lg-6">
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">Contrato:</label>
                                                                                            <br/>
                                                                                            <div class="col-lg-11">
                                                                                            <input type="text" id="contrato" name="contrato" class="form-control">
                                                                                            </div>
                                                                                            <div class="col-lg-1">
                                                                                            <a href="#"onclick="buscarContrato()"> <i class="fa fa-search" ></i></a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                {!! FormField::text('valorContrato',['class'=>'moneda']) !!}
                                                                                </div>
                                                                            </div>
                                                                        
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            {!! FormField::textarea('objetoContrato',['class' => 'form-control-t','placeholder'=>'objeto/Contrato',"style"=>"height:80px!important;","id"=>"objetoContrato"]) !!}
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            {!! FormField::textarea('observaciones',['class' => 'form-control-t','placeholder'=>'Observaciones',"style"=>"height:80px!important;","id"=>"observaciones"]) !!}
                                                                        </div>
                                                                        <div id="itemcompleto">
                                                                                                            <div class="col-lg-6">
                                                                                                                    <div class="form-group ">
                                                                                                                            <label for="name" class="control-label">N Orden/Gasto:</label><br/>
                                                                                                                            <input type="text"id="Fuente" name="Fuente" class="form-control"placeholder="N° Orden">
                                                                                                                        </div>
                                                                                                            </div>
                                                                        </div>
                                                                    
                                                                
                                                                    </div>

                                                                    <!--TAB DESCUENTOS-->
                            

                                                                    <div class="col-lg-4">
                                                                                <div class="tabbable" id="tabs-555441">
                                                                                        <div class="tabbable-line">
                                                                                                   <div class="tab">
                                                                                                        <button class="tablinks active" value="tab5" id="amortizacompleto">Amortiza</button>
                                                                                                        <button class="tablinks" value="tab6" id="descuentocompleto">Valor/Recibir</button>
                                                                                                        <button class="tablinks" value="tab7" id="recursoscompleto">Recursos</button>
                                                                                                        <br/>
                                                                                                    </div>
                                                                                            

                                                                                            <div class="tab-content colorC">
                                                                                        
                                                                                                <div class="tabcontent active" id="tab5">
                                                                                                <div class="col-lg-6">
                                                                                                            <div class="form-group ">
                                                                                                                <label for="name" class="control-label">Numero de Planilla</label>
                                                                                                                <input type="text" name="NumeroPlanilla" value=""  class="form-control" id="NumeroPlanilla"/>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-lg-6">
                                                                                                            <div class="form-group ">
                                                                                                                <label for="name" class="control-label">Garante</label>
                                                                                                                <input type="text" name="Garante" value=""  class="form-control" id="Garante" onkeypress="return soloLetras(event)"/>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-lg-6">
                                                                                                            <div class="form-group ">
                                                                                                                <label for="name" class="control-label">Periodo de Planilla</label>
                                                                                                                <input type="text" name="datefilterPeriodo" value=""  class="form-control periodo" id="datefilterPeriodo"/>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-lg-6">
                                                                                                            <div class="form-group ">
                                                                                                                <label for="name" class="control-label">Valor de Planilla</label>
                                                                                                                <input type="text" name="valorPlanilla" value=""  class="form-control moneda" id="valorPlanilla"/>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-lg-12">
                                                                                                        <hr style="margin-top:10px;margin-bottom:10px"/>
                                                                                                        </div>
                                                                                                        <div id="creditoexternoCompleto">
                                                                                                        <div class="col-lg-6">
                                                                                                            <div class="form-group ">
                                                                                                                <div class="col-lg-12">
                                                                                                                    <label for="name" class="control-label">% Fiscal</label>
                                                                                                                </div>
                                                                                                                <div class="col-lg-5">
                                                                                                                    <input type="text" name="pvalorcf" value="0"id="pvalorcf"  class="form-control moneda" maxlength="6"/>
                                                                                                                </div>
                                                                                                                <div class="col-lg-7">
                                                                                                                <input type="text" name="valorcf" id="valorcf"  class="form-control moneda"/>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-lg-6">
                                                                                                            <div class="form-group ">
                                                                                                                <div class="col-lg-12">
                                                                                                                    <label for="name" class="control-label">% Externo</label>
                                                                                                                </div>
                                                                                                                <div class="col-lg-5">
                                                                                                                <input type="text" name="pvalorce" value="0" id="pvalorce"  class="form-control moneda" maxlength="6"/>
                                                                                                                </div>
                                                                                                                <div class="col-lg-7">
                                                                                                                <input type="text" name="valorce" id="valorce"  class="form-control moneda"/>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                        <div class="col-lg-6">
                                                                                                            <div class="form-group ">
                                                                                                                <label for="name" class="control-label">% Anticipo</label>
                                                                                                                <input type="text" name="anticipo" value="" id="anticipo"  class="form-control moneda"/>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-lg-6">
                                                                                                            <div class="form-group ">
                                                                                                                <label for="name" class="control-label">% Amortizaci&oacute;n</label>
                                                                                                                <input type="text" name="amortizacion" value="" id="amortizacion"  class="form-control moneda"/>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <div class="col-lg-6">
                                                                                                            <div class="form-group ">
                                                                                                                <label for="name" class="control-label">Amort. Acumulado</label>
                                                                                                                <input type="text" name="amortizacionAcumulada" id="amortizacionAcumulada"value=""  class="form-control moneda"/>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-lg-6">
                                                                                                            <div class="form-group ">
                                                                                                                <label for="name" class="control-label">Actual Amort.</label>
                                                                                                                <input type="text" name="actualAmortizacion"id="actualAmortizacion" value=""  class="form-control moneda"/>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                
                                                                                                        <div class="col-lg-6">
                                                                                                            <div class="form-group ">
                                                                                                                <label for="name" class="control-label">Amort. Fiscal</label>
                                                                                                                <input type="text" name="amortizacionFiscal" id="amortizacionFiscal"value=""  class="form-control moneda"/>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-lg-6">
                                                                                                            <div class="form-group ">
                                                                                                                <label for="name" class="control-label">Amort.Externa</label>
                                                                                                                <input type="text" name="amortizacionExterna"id="amortizacionExterna" value=""  class="form-control moneda"/>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-lg-12">
                                                                                                        <hr style="margin-top:5px;margin-bottom:10px"/>
                                                                                                        </div>
                                                                                                        <div class="col-lg-4">
                                                                                                                <div class="form-group ">
                                                                                                                    <label for="name" class="control-label">Total Amortiza</label><br/>                                                                
                                                                                                                    <span id="totalAmortizado" style="font-size:18px">0.00</span>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <div class="col-lg-4">
                                                                                                                <div class="form-group ">
                                                                                                                <label for="name" class="control-label">Saldo/Amortizar:</label><br/>
                                                                                                                <span id="saldoAmortizar" style="font-size:18px">0.00</span>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <div class="col-lg-4"> 
                                                                                                                <div class="form-group ">
                                                                                                                    <label for="name" class="control-label">Valor/Anticipo</label><br/>
                                                                                                                    <span id="valorAnticipo" style="font-size:18px">0.00</span>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                                <div class="tabcontent" id="tab6">
                                                                                                            <div class="col-lg-12" style="color:#ffffff"> 
                                                                                                                    <div id="contratosbasico" style="padding:7px;">
                                                                                                                    <h4 style="line-height:1px">Total de Ingresos</h4>
                                                                                                                        <hr style="margin-top:10px;margin-bottom:10px"/>
                                                                                                                        <div class="col-lg-12">
                                                                                                                                            <input type="text" id="ingresos" class="form-control moneda">
                                                                                                                                            <br/>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div style="padding:7px;">
                                                                                                                    <h4 style="line-height:1px">Descuentos</h4>
                                                                                                                    <hr style="margin-top:10px;margin-bottom:10px"/>
                                                                                                                        <div class="col-lg-12"> 
                                                                                                                                    <label for="name" class="control-label">DESC. NOTAS/D&Eacute;BITO:</label>
                                                                                                                                    <input type="text" name="descNotasDebito" value=""  class="form-control moneda" id="descNotasDebito"/>
                                                                                                                                
                                                                                                                        </div>
                                                                                                                        <div class="col-lg-12"> 
                                                                                                                                    <label for="name" class="control-label">DESC.ART.34:</label>
                                                                                                                                    <input type="text" name="descart34" value=""  class="form-control moneda" id="descart34"/>
                                                                                                                                
                                                                                                                        </div>
                                                                                                                        <div class="col-lg-12"> 
                                                                                                                                    <label for="name" class="control-label">DESC. MULTAS:</label>
                                                                                                                                    <input type="text" name="descmultas" value=""  class="form-control moneda" id="descmultas"/>
                                                                                                                                
                                                                                                                        </div>
                                                                                                                        <div class="col-lg-12"> 
                                                                                                                                    <label for="name" class="control-label">DESC. OTROS:</label>
                                                                                                                                    <input type="text" name="descotros" value=""  class="form-control moneda" id="descotros"/>
                                                                                                                                
                                                                                                                        </div>
                                                                                                                    
                                                                                                        
                                                                                                
                                                                                                                        <div class="col-lg-12"> 
                                                                                                                                    <label for="name" class="control-label">TOTAL/DESCUENTOS:</label>
                                                                                                                                    <input type="text" name="totaldescuentos" value=""  class="form-control moneda" id="totaldescuentos"disabled="disabled"/>
                                                                                                                                
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div style="padding:7px;" class="col-lg-12 hidden" id="valorRecibirBasico">
                                                                                                                    <br/>
                                                                                                                        <div style="float:left" class="col-lg-6">
                                                                                                                            <h4 style="line-height:1px">Valor/Recibir:</h3>
                                                                                                                        </div>
                                                                                                                        <div style="float:rigth" class="col-lg-6">
                                                                                                                            <h4 style="line-height:1px;text-align:right" id="valorRecibir">$0.00</h3>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                </div>
                                                                                                <div class="tabcontent" id="tab7">
                                                                                                            <div class="col-lg-6"> 
                                                                                                                    <div class="form-group ">
                                                                                                                        <label for="name" class="control-label">Cred.Ext:</label><br/>
                                                                                                                        <input type="text" name="CreditoExterno" value=""  class="form-control moneda" id="CreditoExterno" placeholder="Valor Cred.Ext"/>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="col-lg-6"> 
                                                                                                                    <div class="form-group ">
                                                                                                                        <label for="name" class="control-label">Fuente Cred. Ext.:</label><br/>
                                                                                                                        <input type="text" name="FCreditoExterno" value=""  class="form-control" id="FCreditoExterno"/>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="col-lg-6 hidden"> 
                                                                                                                    <div class="form-group ">
                                                                                                                        <label for="name" class="control-label">Rec. Virtuales:</label><br/>
                                                                                                                        <input type="text" name="RecursosVirtuales" value=""  class="form-control moneda" id="RecursosVirtuales" placeholder="Valor Rec. Virtuales"/>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="col-lg-6 hidden"> 
                                                                                                                    <div class="form-group ">
                                                                                                                        <label for="name" class="control-label">Fuente Rec. Virtuales:</label><br/>
                                                                                                                        <input type="text" name="FRecursosVirtuales" value=""  class="form-control" id="FRecursosVirtuales"/>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="col-lg-6"> 
                                                                                                                    <div class="form-group ">
                                                                                                                        <label for="name" class="control-label">Autogesti&oacute;n:</label><br/>
                                                                                                                        <input type="text" name="Autogestion" value=""  class="form-control moneda" id="Autogestion" placeholder="Valor Autogestion"/>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="col-lg-6"> 
                                                                                                                    <div class="form-group ">
                                                                                                                        <label for="name" class="control-label">Fuente Autogesti&oacute;n:</label><br/>
                                                                                                                        <input type="text" name="FAutogestion" value=""  class="form-control" id="FAutogestion"/>
                                                                                                                    </div>
                                                                                                            </div>                            
                                                                                                            <div class="col-lg-6"> 
                                                                                                                    <div class="form-group ">
                                                                                                                        <label for="name" class="control-label">Rec. Fiscales:</label><br/>
                                                                                                                        <input type="text" name="RecursosFiscales" value=""  class="form-control moneda" id="RecursosFiscales" placeholder="Valor Recursos Fiscales"/>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="col-lg-6"> 
                                                                                                                    <div class="form-group ">
                                                                                                                        <label for="name" class="control-label">Fuente Rec. Fiscales:</label><br/>
                                                                                                                        <input type="text" name="FRecursosFiscales" value=""  class="form-control" id="FRecursosFiscales"/>
                                                                                                                    </div>
                                                                                                            </div>   
                                                                                                            <div class="col-lg-6"> 
                                                                                                                    <div class="form-group ">
                                                                                                                        <label for="name" class="control-label">Rec. BID:</label><br/>
                                                                                                                        <input type="text" name="RecursosBID" value=""  class="form-control moneda" id="RecursosBID" placeholder="Valor Recursos BID"/>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="col-lg-6"> 
                                                                                                                    <div class="form-group ">
                                                                                                                        <label for="name" class="control-label">Fuente BID:</label><br/>
                                                                                                                        <input type="text" name="FRecursosBID" value=""  class="form-control" id="FRecursosBID"/>
                                                                                                                    </div>
                                                                                                            </div>   
                                                                                                
                                                                                                            <div class="col-lg-6"> 
                                                                                                                    <div class="form-group ">
                                                                                                                        <label for="name" class="control-label">Rec. 998:</label><br/>
                                                                                                                        <input type="text" name="Recursos998" value=""  class="form-control moneda" id="Recursos998" placeholder="Valor Recursos 998"/>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="col-lg-6"> 
                                                                                                                    <div class="form-group ">
                                                                                                                        <label for="name" class="control-label">Fuente 998:</label><br/>
                                                                                                                        <input type="text" name="FRecursos998" value=""  class="form-control" id="FRecursos998"/>
                                                                                                                    </div>
                                                                                                            </div>   

                                                                                                            <!-- CERTIFICACION-->
                                                                                                            <div class="col-lg-6">

                                                                                                                    <div class="form-group ">
                                                                                                                        <label for="name" class="control-label">Certificaci&oacute;n</label><br/>
                                                                                                                        <input type="text" name="NroCertificacion" value=""  class="form-control" id="NroCertificacion"/>
                                                                                                                    </div>

                                                                                                            </div>

                                                                                                            <div class="col-lg-6">
                                                                                                                {!! FormField::select('TipoGasto',$tipoGasto,['class'=>'select2']) !!}
                                                                                                            </div>
                                                                                                            <div class="col-lg-12">
                                                                                                                        <div class="form-group ">
                                                                                                                            <label for="name" class="control-label">Item:</label><br/>
                                                                                                                            <textarea id="Item" name="Item" placeholder="Item" style="width:100%"></textarea>
                                                                                                                        </div>
                                                                                                            </div> 
                                                                                                        
                                                                                                </div>
                                                                                                
                                                                                            </div>
                                                                                        </div>
                                                                                </div>
                                                                                
                                                                        </div>
                                                                <div>
                                                               			 </div>
									</div>
                                                                </div>
                                                                <!-- BIENES -->
                                                                <div class="tabcontent" id="tab2">
                                                                            
                                                                            <div class="col-lg-5 colorC"style="background-color:#24a2b2" >
                                                                            
                                                                                <div class="col-lg-6 hidden"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">Serie/Factura:</label><br/>
                                                                                            <input type="text" name="serieFacturaid" value=""  class="form-control" id="serieFacturaid"/>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-6"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">FECHA/FACTURA:</label><br/>
                                                                                            <input type="text" name="datefilterFactura" value=""  class="form-control" id="datefilterFactura"/>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-12">
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">N&Uacute;MERO/FACTURA:</label><br/>
                                                                                            <textarea class="form-control form-control-t" id="NumeroFactura" style="height:80px!important;" placeholder="Numero de Facturas" rows="3" name="NumeroFactura" cols="50"></textarea>                                                        
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-12 hidden">
                                                                                    <hr style="margin-top:10px;margin-bottom:10px"/>
                                                                                    <div class="col-lg-6"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">BASE ICE.:</label><br/>
                                                                                            <input type="text" name="baseICEB" value=""  class="form-control moneda" id="baseICEB"/>
                                                                                        </div>
                                                                                    </div>
                                                                                        <div class="col-lg-6"> 
                                                                                                <div class="form-group ">
                                                                                                    <label for="name" class="control-label">PORCENTAJE BASE ICE:</label><br/>
                                                                                                    <input type="text" name="porcentajebaseICEB" value=""  class="form-control moneda" id="porcentajebaseICEB">
                                                                                                </div>
                                                                                        </div>
                                                                                    
                                                                                </div>
                                                                                <div class="col-lg-12">
                                                                                <hr style="margin-top:10px;margin-bottom:10px"/>
                                                                                </div>
                                                                                <div class="col-lg-4"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">BASE NO GRAV.:</label><br/>
                                                                                            <input type="text" name="baseNoGrav" value=""  class="form-control moneda" id="baseNoGrav"/>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-4"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">BASE 0%:</label><br/>
                                                                                            <input type="text" name="baseCero" value=""  class="form-control moneda" id="baseCero"/>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-4"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">BASE 12%:</label><br/>
                                                                                            <input type="text" name="baseDoce" value=""  class="form-control moneda" id="baseDoce"/>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-4"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">TOTAL/BASES:</label><br/>
                                                                                            <input type="text" name="totalBases" value=""  class="form-control moneda" id="totalBases"/>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-4"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">IVA:</label><br/>
                                                                                            <input type="hidden" name="porcentajeiva" value="{!! $porcentajeIva !!}"  class="form-control moneda" id="porcentajeiva"/>
                                                                                    
                                                                                            <input type="text" name="iva" value=""  class="form-control moneda" id="iva"/>
                                                                                        </div>
                                                                                </div>
                                                                            
                                                                                <div class="col-lg-3"> 
                                                                                            <label for="name" class="control-label">TOTAL:</label>
                                                                                            <span name="totalIva" value="" id="totalIva" style="font-size:20px;float:right">0.00</span>
                                                                                        
                                                                                </div>

                                                                                
                                                                            </div>
                                                                            <div class="col-lg-5 colorD" >
                                                                        
                                                                            <div class="col-lg-4"> 
                                                                                    <div class="form-group ">
                                                                                        <label for="name" class="control-label">COD. RET. IVA.:</label><br/>
                                                                                        {!! Form::select('codRetIVA',$codRetIva,NULL,['class'=>'select2','placeholder'=>'SELECCIONE','id'=>'codRetIVA']) !!}
                                                                                    </div>
                                                                            </div>
                                                                            <div class="col-lg-8"> 
                                                                                    <div class="form-group ">
                                                                                        <textarea class="form-control form-control-t" id="descripcionretIva" style="height:60px!important;" placeholder="Descripcion Cod.Ret.Iva" rows="3" name="descripcionretIva" cols="50" disabled></textarea>                                                        
                                                                                    </div>
                                                                            </div> 
                                                                            <div class="col-lg-3"> 
                                                                                    <div class="form-group ">
                                                                                        <label for="name" class="control-label">% RET. IVA:</label><br/>
                                                                                        <input type="text" name="porcentajeRetencionIVA" value=""  class="form-control moneda" id="porcentajeRetencionIVA"/>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="col-lg-6"> 
                                                                                    <div class="form-group ">
                                                                                        <label for="name" class="control-label">BASE IMP.:</label><br/>
                                                                                        <input type="text" name="baseImp" value=""  class="form-control moneda" id="baseImp"/>
                                                                                    </div>
                                                                            </div>

                                                                            <div class="col-lg-3"> 
                                                                                    <div class="form-group ">
                                                                                        <label for="name" class="control-label">RET. IVA:</label><br/>
                                                                                        <input type="text" name="retencionIva" value=""  class="form-control moneda" id="retencionIva"/>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="col-lg-12"> 
                                                                            <hr/>
                                                                                </div>
                                                                            <div class="col-lg-4"> 
                                                                                    <div class="form-group ">
                                                                                        <label for="name" class="control-label">COD. RET. IR.:</label><br/>
                                                                                        {!! Form::select('codRetIR',$codRetIR,NULL,['class'=>'select2','placeholder'=>'SELECCIONE','id'=>'codRetIR']) !!}
                                                                                    </div>
                                                                            </div>
                                                                            <div class="col-lg-8"> 
                                                                                    <div class="form-group ">
                                                                                        <textarea class="form-control form-control-t" id="descripcionretIR" style="height:60px!important;" placeholder="Descripcion Cod.Ret.IR" rows="3" name="descripcionretIR" cols="50" disabled></textarea>                                                        
                                                                                    </div>
                                                                            </div>
                                                                            <div class="col-lg-3"> 
                                                                                    <div class="form-group ">
                                                                                        <label for="name" class="control-label">% RET. IR:</label><br/>
                                                                                        <input type="text" name="porcentajeRetencionIR" value=""  class="form-control moneda" id="porcentajeRetencionIR"/>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="col-lg-3"> 
                                                                                    <div class="form-group ">
                                                                                        <label for="name" class="control-label">BASE IMP.:</label><br/>
                                                                                        <input type="text" name="baseIR" value=""  class="form-control moneda" id="baseIR"/>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="col-lg-3"> 
                                                                                    <div class="form-group ">
                                                                                        <input type="hidden" name="porcentajebaseseguros" value="{!! $porcentajeSeguro !!}"  class="form-control moneda" id="porcentajebaseseguros"/>

                                                                                        <label for="name" class="control-label">BASE/SEG.10%:</label><br/>
                                                                                        <input type="text" name="baseseguros" value=""  class="form-control moneda" id="baseseguros"/>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="col-lg-3"> 
                                                                                    <div class="form-group ">
                                                                                        <label for="name" class="control-label">RET. IR:</label><br/>
                                                                                        <input type="text" name="retencionIR" value=""  class="form-control moneda" id="retencionIR"/>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                <label>Utilidad/Consultoria</label>
                                                                                    <br/>
                                                                                    <span>No</span>
                                                                                    <label class="switch">
                                                                                        <input type="checkbox" name="utilidadConsultoria"id="utilidadConsultoria">
                                                                                        <span class="slider round"></span>
                                                                                    </label>
                                                                                    <span>Si</span>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <div style="background:#24a2b2" class="colorD">
                                                                                    <div class="col-lg-6">
                                                                                        <span style="font-weigth:bold">Cod.&nbsp;&nbsp; %</span>
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <span style="font-weigth:bold">Cod.&nbsp;&nbsp;  %</span>
                                                                                    </div>
                                                                                    <div name="cargaCodigos" id="cargaCodigosBienes">
                                                                                    </div>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                            <!-- SERVICIOS -->
                                                                <div class="tabcontent" id="tab4">
                                                                                
                                                                                <div class="col-lg-5 colorC" >
                                                                                
                                                                                    <div class="col-lg-6 hidden"> 
                                                                                            <div class="form-group ">
                                                                                                <label for="name" class="control-label">Serie/Factura:</label><br/>
                                                                                                <input type="text" name="serieFacturaidS" value=""  class="form-control" id="serieFacturaidS"/>
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="col-lg-6"> 
                                                                                            <div class="form-group ">
                                                                                                <label for="name" class="control-label">FECHA/FACTURA:</label><br/>
                                                                                                <input type="text" name="datefilterFacturaS" value=""  class="form-control" id="datefilterFacturaS"/>
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                            <div class="form-group ">
                                                                                                <label for="name" class="control-label">N&Uacute;MERO/FACTURA:</label><br/>
                                                                                                <textarea class="form-control form-control-t" id="NumeroFacturaS" style="height:80px!important;" placeholder="Numero de Facturas" rows="3" name="NumeroFacturaS" cols="50"></textarea>                                                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="col-lg-4"> 
                                                                                            <div class="form-group ">
                                                                                                <label for="name" class="control-label">BASE NO GRAV.:</label><br/>
                                                                                                <input type="text" name="baseNoGravS" value=""  class="form-control moneda" id="baseNoGravS"/>
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="col-lg-4"> 
                                                                                            <div class="form-group ">
                                                                                                <label for="name" class="control-label">BASE 0%:</label><br/>
                                                                                                <input type="text" name="baseCeroS" value=""  class="form-control moneda" id="baseCeroS"/>
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="col-lg-4"> 
                                                                                            <div class="form-group ">
                                                                                                <label for="name" class="control-label">BASE 12%:</label><br/>
                                                                                                <input type="text" name="baseDoceS" value=""  class="form-control moneda" id="baseDoceS"/>
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="col-lg-4"> 
                                                                                            <div class="form-group ">
                                                                                                <label for="name" class="control-label">TOTAL/BASES:</label><br/>
                                                                                                <input type="text" name="totalBasesS" value=""  class="form-control moneda" id="totalBasesS"/>
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="col-lg-4"> 
                                                                                            <div class="form-group ">
                                                                                                <label for="name" class="control-label">IVA:</label><br/>
                                                                                                <input type="text" name="ivaS" value=""  class="form-control moneda" id="ivaS"/>
                                                                                            </div>
                                                                                    </div>
                                                                                
                                                                                    <div class="col-lg-3"> 
                                                                                                <label for="name" class="control-label">TOTAL:</label>
                                                                                                <span name="totalIvaS" value="" id="totalIvaS" style="font-size:20px;float:right">0.00</span>
                                                                                            
                                                                                    </div>
                                                                            
                                                    
                                                                                    
                                                                                </div>
                                                                                <div class="col-lg-5 colorD ">
                                                                                
                                                                                <div class="col-lg-4"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">COD. RET. IVA.:</label><br/>
                                                                                            {!! Form::select('codRetIVAS',$codRetIva,NULL,['class'=>'select2','placeholder'=>'SELECCIONE','id'=>'codRetIVAS']) !!}
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-8"> 
                                                                                        <div class="form-group ">
                                                                                            <textarea class="form-control form-control-t" id="descripcionretIvaS" style="height:60px!important;" placeholder="Descripcion Cod.Ret.Iva" rows="3" name="descripcionretIvaS" cols="50" disabled></textarea>                                                        
                                                                                        </div>
                                                                                </div> 
                                                                                <div class="col-lg-3"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">% RET. IVA:</label><br/>
                                                                                            <input type="text" name="porcentajeRetencionIVAS" value=""  class="form-control moneda" id="porcentajeRetencionIVAS"/>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-6"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">BASE IMP.:</label><br/>
                                                                                            <input type="text" name="baseImpS" value=""  class="form-control moneda" id="baseImpS"/>
                                                                                        </div>
                                                                                </div>
                                                                                
                                                                                

                                                                                <div class="col-lg-3"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">RET. IVA:</label><br/>
                                                                                            <input type="text" name="retencionIvaS" value=""  class="form-control moneda" id="retencionIvaS"/>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-12"> 
                                                                                <hr/>
                                                                                    </div>
                                                                                <div class="col-lg-4"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">COD. RET. IR.:</label><br/>
                                                                                            {!! Form::select('codRetIRS',$codRetIR,NULL,['class'=>'select2','placeholder'=>'SELECCIONE','id'=>'codRetIRS']) !!}
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-8"> 
                                                                                        <div class="form-group ">
                                                                                            <textarea class="form-control form-control-t" id="descripcionretIRS" style="height:60px!important;" placeholder="Descripcion Cod.Ret.IR" rows="3" name="descripcionretIRS" cols="50" disabled></textarea>                                                        
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-3"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">% RET. IR:</label><br/>
                                                                                            <input type="text" name="porcentajeRetencionIRS" value=""  class="form-control moneda" id="porcentajeRetencionIRS"/>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-3"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">BASE IMP.:</label><br/>
                                                                                            <input type="text" name="baseIRS" value=""  class="form-control moneda" id="baseIRS"/>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-3"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">BASE/SEG.10%:</label><br/>
                                                                                            <input type="text" name="basesegurosS" value=""  class="form-control moneda" id="basesegurosS"/>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-3"> 
                                                                                        <div class="form-group ">
                                                                                            <label for="name" class="control-label">RET. IR:</label><br/>
                                                                                            <input type="text" name="retencionIRS" value=""  class="form-control moneda" id="retencionIRS"/>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-lg-12">
                                                                                    <label>Utilidad/Consultoria</label>
                                                                                        <br/>
                                                                                        <span>No</span>
                                                                                        <label class="switch">
                                                                                            <input type="checkbox" name="utilidadConsultoriaS"id="utilidadConsultoriaS">
                                                                                            <span class="slider round"></span>
                                                                                        </label>
                                                                                        <span>Si</span>
                                                                                </div>
                                                                                                                                                                                                                
                                                                                
                                                                            </div>
                                                                            <div class="col-lg-2">
                                                                                <div style="background:#448eaf" class="colorD">
                                                                                        <div class="col-lg-6">
                                                                                            <span style="font-weigth:bold">Cod.&nbsp;&nbsp; %</span>
                                                                                        </div>
                                                                                        <div class="col-lg-6">
                                                                                            <span style="font-weigth:bold">Cod.&nbsp;&nbsp;  %</span>
                                                                                        </div>
                                                                                        <div name="cargaCodigos" id="cargaCodigosServicios">
                                                                                        </div>
                                                                                </div>
                                                                            </div>
                                                                    
                                                                    </div>
                                                                
                                                                </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        </div>
        <div class="modal-footer">
                                                            <div class="col-lg-6" style="float:left">
                                                                <div class="col-lg-4">                                   
                                                                            <label class="switch">
                                                                                <input type="checkbox" name="plantillaPie[]"id="plantillaPieElabora" checked value="E">
                                                                                <span class="slider round"></span>
                                                                            </label>
                                                                            <span>Elaborado Por</span>
                                                                </div> 
                                                                <div class="col-lg-4">                                   
                                                                            <label class="switch"> 
                                                                                <input type="checkbox" name="plantillaPie[]"id="plantillaPieRevisado" checked value="R">
                                                                                <span class="slider round"></span>
                                                                            </label>
                                                                            <span>Revisado Por</span>
                                                                </div> 
                                                                <div class="col-lg-4 hidden" >
                                                                                                        <label class="switch">
                                                                                                            <input type="checkbox" name="recursos[]"id="recursosF"value="A">
                                                                                                            <span class="slider round"></span>
                                                                                                        </label>
                                                                                                        <span>Aprobado</span>
                                                                                                                                            
                                                                </div>
                                                            </div>
                        {!! Form::button('<b><i class="fa fa-save"></i></b> Guardar Cambios', array('type' => 'button', 'class' => 'btn btn-primary','id' => "btnGuardar")) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">

<div class="panel-body">

    <div class="col-lg-2"> 
        <label for="name" class="control-label">Periodo de Fechas:</label><br/>
    </div>
    <div class="col-lg-2"> 
        <input type="text" name="fechaconsulta" value=""  class="form-control-i" id="fechaconsulta"/>

    </div>
    <div class="col-lg-2"> 
                        <button class="btn btn-primary btn-xs" onclick="BuscarFechaD()">Buscar</button>
                        <button id="myBtn" onclick="limpiar();" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
      
    </div>


    <div class="table table-responsive" id="tablaConsulta">
      
        <table class="table table-bordered table-striped" id="dtmenu" style="width:100%!important">
            <thead>

            </thead>
            <tbody id="tbobymenu">

            </tbody>
        </table>
    </div>
</div>

@endsection
