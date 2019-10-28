<?php

namespace App\Http\Controllers\Admin;

use App\Menu;
use App\role_has_permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Ajax\SelectController;
use Illuminate\Support\Facades\Auth;
use nextcore\Core\Repositories\AdminRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Utils;
use Yajra\Datatables\Datatables;


class MenuController extends Controller
{

    public function index()
    {
        $user = Auth::user()->name;
        $objSelect = new SelectController();
        $father = $objSelect->getFather($user);
        return view('admin.permissions.create_opciones')->with(['father' => $father]);
    }

    public function StoreOpcion(Request $request)
    {
        $rules = [
            'name' => 'required',
            'prefix' => 'required',
            'url' => 'required'
        ];
        $messages = [
            'name.required' => 'Escriba el nombre de la opción',
            'prefix.required' => 'Escriba el nombre del prefijo',
            'url.required' => 'Escriba la URL prefijo/NombredelaOpcion',
        ];
        $this->validate($request, $rules, $messages);
        $array_response = [];
        try {
            //Grabar dato

            if ($request->var != 0) {
                $oobjOption = Menu::Find($request->var);


            } else {
                $oobjOption = new Menu();

            }
            $oobjOption->name = $request->name;
            $oobjOption->order = $request->prefix;
            if ($request->optionid != null) {
                $oobjOption->parent = $request->optionid;

            } else {
                $oobjOption->parent = 0;

            }
            $oobjOption->enabled = '1';
            $intCod = Menu::where('slug', $request->url)->first();

            if (count($intCod) > 0 && $oobjOption->slug != $request->url) {
                throw new \Exception ("LA URL YA SE ENCUENTRA EN OTRA OPCION REGISTRADA");
            } else {
                $oobjOption->slug = $request->url;
                $oobjOption->save();
                $array_response['status'] = 200;
                $array_response['message'] = 'Se ha Guardado Exitosamente ';
            }
        } catch (\Exception $e) {
            $array_response['status'] = 404;
            $array_response['message'] = 'Error al guardas los datos porfavor consulte con el Administrador:' . $e->getMessage();
        }


        return response()->json($array_response, 200);
    }

    public function PermissionRole(Request $request)
    {
        $objSelect = new SelectController();

        try {

            $array_response['status'] = 200;
            $array_response['message'] = 'Se ha Eliminado Exitosamente ';


        } catch (\Exception $e) {
            $array_response['status'] = 404;
            $array_response['message'] = 'Error al Eliminar los datos porfavor consulte con el Administrador' . $e;
        }

        return response()->json($array_response, 200);
    }

    public function MenuEliminar(Request $request)
    {
        try {
            $objEliminar = Menu::find($request->id);
            $objEliminar->delete();
            $array_response['status'] = 200;
            $array_response['message'] = 'Se ha Eliminado Exitosamente ';


        } catch (\Exception $e) {
            $array_response['status'] = 404;
            $array_response['message'] = 'Error al Eliminar los datos porfavor consulte con el Administrador' . $e;
        }


        return response()->json($array_response, 200);

    }

    public function MenuRoleEliminar(Request $request)
    {

        try {
            $data=DB::connection('mysql')
            ->table('role_has_permission')->where('role_id',$request->id)->count();

            DB::connection('mysql')
                ->table('role_has_permission')
                ->where([
                    ['role_id', $request->id],
                    ['permission_id', $request->permiso]])
                ->delete();
            if($data==1)
            {
                DB::connection('mysql')
                ->table('model_has_roles')->where('role_id',$request->id)->delete();  

                 DB::connection('mysql')
                ->table('roles')->where('id',$request->id)->delete();    
            }
            $array_response['status'] = 200;
            $array_response['message'] = 'Se ha Eliminado Exitosamente ';


        } catch (\Exception $e) {
            $array_response['status'] = 404;
            $array_response['message'] = 'Error al Eliminar los datos porfavor consulte con el Administrador' . $e;
        }


        return response()->json($array_response, 200);

    }


    public function getDatatableoption()
    {

        return DataTables::of(
            DB::connection('mysql')
                ->table('role_has_permission AS g')
                ->join('roles as r', 'r.id', 'g.role_id')
                ->groupBy('r.name', 'r.id')
                ->select('r.id as id', 'r.name AS roles')
                ->get()

        )
            ->addColumn('actions', '<a href="{{ route(\'admin.roles.edit\', $id) }}"><span class="fa fa-plus"></span></a>'
            )
            ->addColumn('options', function ($select) {
                $i = 1;
                $trib = '';
                $list = DB::connection('mysql')
                    ->table('role_has_permission as m')
                    ->where('m.role_id', $select->id)
                    ->join('menus as k', 'k.id', 'm.permission_id')
                    ->select('k.id as id', 'k.name as name')
                    ->get();
                $max = count($list);
                foreach ($list as $tribunal) {
                    $add = ($max === 1 ? ' ' : ($max === $i++) ? ' ' : ', ');
                    $trib .= $tribunal->id . '-' . $tribunal->name . $add;
                }

                return $trib;
            })
            ->make(true);
    }


    public function getDatatable()
    {

        return DataTables::of(
            DB::connection('mysql')
                ->table('menus AS g')
                ->where('g.enabled', '1')
                ->select('g.id as id', 'g.name AS name', 'g.slug as slug', 'g.parent as parent', 'g.order as order')
                ->get()

        )->addColumn('actions', function ($select) {

            return '<a href="#" onclick="EditChanges(\'' . $select->id . '\',\'' . $select->name . '\',\'' . $select->slug . '\',\'' . $select->parent . '\',\'' . $select->order . '\')"
                               data-hover="tooltip" data-placement="top" 
                               data-target="#Modalagregar" data-toggle="modal" id="modal"
                               class="label label-primary">
                        <span class="glyphicon glyphicon-edit"></span></a></small>
                
                        <a href="#" onclick="PedirConfirmacion(\'' . $select->id . '\',\'' . 'delete' . '\')"
                               class="label label-danger">
                        <span class="glyphicon glyphicon-trash"></span></a></small>';
        })
            ->make(true);
    }

}
