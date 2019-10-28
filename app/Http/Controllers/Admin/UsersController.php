<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use App\Http\Controllers\Ajax\SelectController;
use App\Core\Entities\Solicitudes\Empleados;
use DB;
use Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all()->sortByDesc("created_at");
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {

        $roles = Role::get()->pluck('name', 'name');
        
        $persona_id = Empleados::
        select(DB::raw("CONCAT(apellidos,' ',nombres) as name"),'identificacion')
        ->get()->pluck('name','identificacion');


        return view('admin.users.create')->with(['roles' => $roles,'persona_id'=>$persona_id]);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'persona_id' => 'required',
        ];
        $messages = [
            'name.required' => 'Escriba el nombre ',
            'email.unique' => 'El email es requerido',
            'persona_id.required' => 'La identificacion es requerida',

        ];
        $this->validate($request, $rules, $messages);

        $result = DB::connection('mysql')
            ->table('users')
            ->where('persona_id', $request->persona_id)
            ->get()->toArray();
        if (count($result) < 1) {
            $user = User::create($request->all());
            $roles = $request->input('roles') ? $request->input('roles') : [];
            $user->assignRole($roles);
        }else{
            $users = User::all()->sortByDesc("created_at");
            $m='El usuario ya esta registrado';
            return view('admin.users.index', compact('users','m'));
        }

        return redirect()->route('admin.users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $roles = Role::get()->pluck('name', 'name');

        $user = User::findOrFail($id);
        $persona_id = Empleados::
        select(DB::raw("CONCAT(apellidos,' ',nombres) as name"),'identificacion')
        ->get()->pluck('name','identificacion');

   
        return view('admin.users.edit')->with(['user'=>$user, 'roles'=>$roles,'persona_id'=>$persona_id]);
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {

            $user = User::findOrFail($id);
            $user->update($request->all());
            $roles = $request->input('roles') ? $request->input('roles') : [];
            $user->syncRoles($roles);

       

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove User from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index');
    }
    public function userstate($id)
    {
        $user = User::findOrFail($id);
        if($user->estado=='A')
        {
            $user->estado='I';
        }else
        {
            $user->estado='A';
        }
        $user->save();

        return redirect()->route('admin.users.index');
    }
    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {

        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }



}
