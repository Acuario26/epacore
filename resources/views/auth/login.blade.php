

<!DOCTYPE html>
<html>
<head>
	<title>EPA EP</title>
	<link href="{{ url('adminlte/bootstrap/bootstrap4.min.css') }}" rel="stylesheet">
	<link href="{{ url('adminlte/css/styleLogin.css') }}" rel="stylesheet">

	<link href="{{ url('web-fonts-with-css/css/fontawesome-all.min.css') }}" rel="stylesheet" type="text/css">
	
</head>
<body>
<div class="container">
	<div style="margin-top:120px;float:left" >
		<div class="card">
			<div class="card-header">
				<img src="logo_d2.png" style="float:right"/>
			</div>
			<div class="card-body">
					<form class="login100-form validate-form"
								role="form"
								method="POST"
								action="{{ url('login') }}">
								<input type="hidden"
									name="_token"
									value="{{ csrf_token() }}">
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" class="form-control" name="name" maxlength="13"
											value="{{ old('name') }}" placeholder="username">
								
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" class="form-control" name="password" placeholder="password">
							</div>
						
							<div class="form-group">
								<input type="submit" value="Iniciar Sesión" class="btn float-right login_btn">
							</div>
					</form>
				
                 
				      @if (count($errors) > 0)
						 <div class="alert alert-danger">
							 <strong></strong> Existe un problema con el dato ingresado:
							 <br><br>
							 <ul>
								 @foreach ($errors->all() as $error)
									 <li>{{ $error }}</li>
								 @endforeach
							 </ul>
						 </div>
					 @endif
			</div>
			<div class="card-footer">
				
				<div class="d-flex justify-content-center">
				<a href="{{route('auth.password.reset')}}" class="txt2 hov1" style="color:#fff">
                                         Olvidaste tu contraseña?
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>

