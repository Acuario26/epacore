@extends('layouts.app')


@section('content')
<hr/>
<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Inicio</div>

					<div class="panel-body">
					<h3>
						<center>Bienvenido al Sistema Integrado de la Empresa P&uacute;blica del Agua</center></h3>
						<hr/>
						
						<div class="col-lg-3 col-xs-6" style="display:none">
								<div class="small-box bg-aqua">
									<div class="inner">
									<h3><span style="font-size:16px">&nbsp;Producci&oacute;n</span></h3>

									<p>Sistema de Control Previo</p>
									</div>
									<div class="icon">
									<i class="ion ion-bag"></i>
									</div>
									<a href="{{route('financiera.ControlPrevioLink')}}"target="_blank" class="small-box-footer">Click Aqu&iacute;<i class="fa fa-arrow-circle-right"></i></a>
								</div>
						</div>
						<div class="col-lg-3 col-xs-6" style="display:none">
								<div class="small-box bg-yellow">
									<div class="inner">
									<h3><span style="font-size:16px">&nbsp;Producci&oacute;n</span></h3>

									<p>Sistema de Informes T&eacute;cnicos</p>
									</div>
									<div class="icon">
									<i class="ion ion-person-add"></i>
									</div>
									<a href="{{route('informe.informesLink')}}"target="_blank" class="small-box-footer">Click Aqu&iacute;<i class="fa fa-arrow-circle-right"></i></a>
								</div>
						</div>
						<div class="col-lg-3 col-xs-6" style="display:none">
								<div class="small-box bg-green">
									<div class="inner">
									<h3><span style="font-size:16px">&nbsp;Pendiente</span></h3>

									<p>Sistema de Talento Humano</p>
									</div>
									<div class="icon">
									<i class="ion ion-stats-bars"></i>
									</div>
									<a href="#" class="small-box-footer"target="_blank">Click Aqu&iacute;<i class="fa fa-arrow-circle-right"></i></a>
								</div>
						</div>
						<div class="col-lg-3 col-xs-6" style="display:none">
								<div class="small-box bg-primary">
									<div class="inner">
									<h3><span style="font-size:16px">&nbsp;Producci&oacute;n</span></h3>

									<p>Intranet</p>
									</div>
									<div class="icon">
									<i class="ion ion-pie-graph"></i>
									</div>
									<a href="http://intranet.epaep.gob.ec/" target="_blank" class="small-box-footer">Click Aqu&iacute;<i class="fa fa-arrow-circle-right"></i></a>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>

@endsection
