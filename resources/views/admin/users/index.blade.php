@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
            <div style="float:right">
              <a href="{{ route('admin.users.create') }}" class="btn btn-default btn-xs"><i class="fa fa-plus"></i></a>

            </div>
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($users) > 0 ? 'datatable' : '' }} dt-select" style="width:100%!important">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>

                        <th>Usuario</th>
                        <th>cedula</th>
                        <th>Apellidos y Nombres</th>
                        <th>Correo</th>
                        <th>@lang('global.users.fields.roles')</th>
                        <th>Estado</th>
                        <th>&nbsp;</th>

                    </tr>
                </thead>
                
                <tbody>
                    @if (count($users) > 0)
                        @foreach ($users as $user)
                            <tr data-entry-id="{{ $user->id }}">
                                <td></td>

                                <td>{{ $user->name }}</td>
                                <td>{{ $user->persona_id }}</td>
                                <td>@foreach ($user->persona()->pluck('nombres','apellidos') as $key=>$value)
                                          {{ $key.' '.$value }}
                                    @endforeach</td>
                                
                                <td>{{ $user->email }}</td>
                                
                                <td>
                                    @foreach ($user->roles()->pluck('name') as $role)
                                        <span class="label label-info label-many">{{ $role }}</span>
                                    @endforeach
                                </td>
                                <td>
                                @if($user->estado=='A')
                                <span class="label label-primary label-many">Activo</span>

                                @endif
                                @if($user->estado=='I')
                                <span class="label label-danger label-many">Inactivo</span>

                                @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit',[$user->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.users.destroy', $user->id])) !!}
                                    {!! Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    <a href="{{ route('admin.userstate',[$user->id]) }}" class="btn btn-xs btn-warning"><i class="fa fa-sync"></i></a>
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
     @if(isset($m))
	alert('{{$m}}');

	@endif
        window.route_mass_crud_entries_destroy = '{{ route('admin.users.mass_destroy') }}';
    </script>
@endsection