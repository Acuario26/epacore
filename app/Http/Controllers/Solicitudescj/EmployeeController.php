<?php
namespace App\Http\Controllers\Solicitudescj;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Core\Entities\Solicitudescj\Place;
use Spatie\Permission\Models\Role;
use App\Mail\CreateUserStudent as CreateUserStudent;
use Yajra\Datatables\Datatables;
use Mail;

class EmployeeController extends Controller
{
	public function index(){
        /*$users=User::whereHas('roles', function ($query) {
		    $query->whereIn('abv',['SUP','TUT','SEC']);
		})->get();
		dd($users);*/
		//dd($users[0]->roles_label);
		//dd(User::all());
		return view('modules.Solicitudescj.employees.index');
	}

	public function create(){
		$roles = Role::selectRaw('name, concat(abv,"-",id) as id')->whereIn('abv',['SUP','MON','SEC'])->pluck('name','id');

        $places = Place::pluck('descripcion','id');

		return view('modules.Solicitudescj.employees.create',compact('roles','places'));
	}

	public function getDatatable()
    {


	    $users=User::whereHas('roles', function ($query) {
		    $query->whereIn('abv',['SUP','MON','SEC']);
		})->get();

    	//dd($postulants);

        return DataTables::of($users)->addColumn('actions', function ($select) {
			return '<p class="text-center"><a title="Gestionar Empleado" href="'.route('employees.show',$select->id).'"><span class="fa fa-cog"></span></a><p>';
        })->addColumn('roles_label', function ($select) {
            return $select->roles_label;
        })->addColumn('estado_label', function ($select) {
            return $select->estado_label;
        })->rawColumns(['actions','roles_label','estado_label'])
        ->make(true);


    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:mysql.users,email',
            'persona_id' => 'required|unique:mysql.users,persona_id',
            'roles' => 'required',
            'lugar' => 'required_with:lugar'
        ];
        $messages = [
            'name.required' => 'Escriba el nombre ',
            'email.required' => 'El Correo es requerido',
            'email.unique' => 'El correo ya se encuentra registrado',
            'persona_id.required' => 'La identificacion es requerida',
            'persona_id.unique' => 'La identificacion ya se encuentra registrada',

        ];
        $this->validate($request, $rules, $messages);

        /*dd($request->lugar,$request->all(),isset($request->lugar),isset($request->all()['lugar']));

        if(isset($request->all()['lugar'])){
	        $this->validate($request,[
	        	'lugar'=>'required'
	        ]);
		}

		dd(1);*/


        $password=str_random(8);

        $roles=explode('-',$request->roles);
        
        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password = bcrypt($password); 
        $user->persona_id = $request->persona_id;
        $user->estado = 'A';
        $user->lugarasignado_id = $request->lugarasignado_id;
        $user->abv=$roles[0];
        $user->save();

        

        //dd($roles);
        
        $user->assignRole([$roles[1]]);

        Mail::to($user->email)->send(new CreateUserStudent($user, $password));

        return redirect()->route('employees.index');
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:mysql.users,email,'.$id.',id',
            'persona_id' => 'required|unique:mysql.users,persona_id,'.$id.',id',
            'roles' => 'required',
            'lugar' => 'required_with:lugar'
            //'sale_price' => 'required_if:roles,==,TUT|required_if:roles,==,SUP'
        ];
        $messages = [
            'name.required' => 'Escriba el nombre ',
            'email.required' => 'El Correo es requerido',
            'email.unique' => 'El correo ya se encuentra registrado',
            'persona_id.required' => 'La identificacion es requerida',
            'persona_id.unique' => 'La identificacion ya se encuentra registrada',

        ];
        $this->validate($request, $rules, $messages);

        $roles=explode('-',$request->roles);

        $user = User::findOrFail($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->persona_id = $request->persona_id;
        $user->lugarasignado_id = $request->lugarasignado_id;
        $user->abv=$roles[0];
        $user->save();

        

        //dd($roles);
        
        $user->syncRoles([$roles[1]]);

        return redirect()->route('employees.index');
    }


    public function show($id){
     
        $employee=User::whereHas('roles', function ($query) {
		    $query->whereIn('abv',['SUP','MON','SEC']);
		})->find($id);

		$roles = Role::selectRaw('name, concat(abv,"-",id) as id')->whereIn('abv',['SUP','MON','SEC'])->pluck('name','id');

        $places = Place::pluck('descripcion','id');
        //dd($postulant);

        //dd($employee->roles_type);


        if(!$employee){
            return redirect()->route('postulant.index')->with('danger','No se ha encontrado el empleado');
        }  

        //dd($postulant);

        return view('modules.Solicitudescj.employees.show', compact('employee','roles','places'));
    }
}