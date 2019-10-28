@extends('layouts.app')

@section('contentheader_title')
	JuridiCore
@endsection

@section('contentheader_description')
	Sistema Integrado 
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
@endsection
@section('javascript')
<script>
@if(isset($m))
	alert('{{$m}}');

	@endif
	</script>

@endsection
@section('content')
<hr/>

<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Evidencia de Practicas Pre profesionales</div>
					<div class="panel-body">

							<div class="col-md-12">
						
								<div class="tab-content">
									<div class="tab-pane active" id="tab3">
									@foreach($images as $image)
										<div class="col-md-4">
											<div class="panel panel-default">
												<div class="panel-body">
												<img src="/storage/{{$image->filename}}" class="img-responsive">
												</div>
												<div class="panel-footer">
												<input type="hidden" value="{{$image->filename}}" name="filename">
					
												</form>
												</div>
											</div>
										</div>
										@endforeach
								</div>
								
								</div>
			</div>
		</div>	

	</div>
		</div>	

@endsection

