@extends('layouts.app')


@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <style>
    .form-control{
        text-transform: none!important;
    }
    </style>
@endsection
@section('javascript')
    <script src="{{ url('js/modules/admin/menu_rol.js') }}"></script>
@endsection
@section('content')
    <div class="modal fade" id="ModalEditRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Roles y Opciones</h4>
                </div>
                <div class="modal-body">                        <input type="hidden" id="var" value="0"/>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 form-group">
                                {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                                {!! Form::select('roles',$roles,null, ['class' => 'form-control select2']) !!}

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 form-group">
                                {!! Form::label('permission', 'Permissions', ['class' => 'control-label']) !!}
                                {!! Form::select('permission[]', $permissions, null, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div style="text-align: center;">
                        {!! Form::button('<b><i class="fa fa-save"></i></b> Agregar Cambios', array('type' => 'button', 'class' => 'btn btn-primary','id' => "btnGuardar")) !!}
                        {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', array('type' => 'button', 'class' => 'btn btn-danger','id' => "btnCancelar", 'data-dismiss'=>"modal")) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="panel panel-default">
        <div class="panel-heading">
            Listado de Roles 
            <div style="float:right">
                <a href="{{ route('admin.roles.create') }}" class="btn btn-default btn-xs" title="Agregar Nuevo Rol"> <i class="fa fa-plus"></i></a>    
            </div>
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped " id="dtop" style="width:100%!important">
                <thead>

                <th>Roles</th>
                <th></th>
                <th>Permisos</th>

                </thead>
                <tbody id="tbobyop">

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        window.route_mass_crud_entries_destroy = '{{ route('admin.roles.mass_destroy') }}';
    </script>
@endsection