<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('livewire.users.add',[
            'roles' => Role::all(),
            'departments' => Department::where('status', 1)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =  [
            'name'              => 'required|min:3',
            'surname'           => 'required|min:3',
            'email'             => 'required|email|unique:users,email',
            'department_id'     => 'required',
            'role'              => 'required',
            'password'          => 'required|min:8',
            'cpassword'         => 'required|same:password'
        ];

        $messages = [
            'name.required'             => 'El nombre es requerido.',
            'name.min'                  => 'El nombre requiere minimo :min caracteres.',
            'surname.required'          => 'El apellido es requerido.',
            'surname.min'               => 'El apellido requiere minimo :min caracteres.',
            'email.required'            => 'El emai es requerido.',
            'email.email'               => 'El emai ingresado es icorrecto.',
            'email.unique'              => 'El emai ingresado es ya esta en uso por otro usuario.',
            'department_id.required'    => 'El departamento es requerido.',
            'role.required'             => 'El role es requerido.',
            'password.required'         => 'La contraseña es requerida.',
            'password.min'              => 'La contraseña requiere minimo :min caracteres.',
            'cpassword.required'        => 'Repetir contraseña es requerido.',
            'cpassword.same'            => 'Los campos contraseña y repetir  debe coincidir',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::create([
            'name'        => $request->name,
            'surname'     => $request->surname,
            'email'       => $request->email,
            'department_id'  => $request->department_id,
            'password'    => bcrypt($request->password),
            'email_verified_at' => now(),
        ])->assignRole($request->role);

        if($user){
            return redirect()->route('admin.users.index')->with(['action' => 'store', 'message' => 'Usuario registrado exitosamente']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        return view('livewire.users.show',[
            'user'          => User::findOrFail($user),
            'permissions'   => User::findOrFail($user)->getAllPermissions()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        $userRole = DB::table('model_has_roles')->select('role_id')->where('model_id',  $user)->pluck('role_id')->toArray();
        return view('livewire.users.edit',[
            'roles' => Role::all(),
            'departments' => Department::where('status', 1)->get(),
            'user' => User::findOrFail($user),
            'userRole' => $userRole
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $rules =  [
            'name'              => 'required|min:3',
            'surname'           => 'required|min:3',
            'email'             => 'required|email|unique:users,email,'.$user,
            'department_id'     => 'required',
            'role'              => 'required',
            'password'          => 'nullable|min:8',
            'cpassword'         => 'nullable|same:password'
        ];

        $messages = [
            'name.required'             => 'El nombre es requerido.',
            'name.min'                  => 'El nombre requiere minimo :min caracteres.',
            'surname.required'          => 'El apellido es requerido.',
            'surname.min'               => 'El apellido requiere minimo :min caracteres.',
            'email.required'            => 'El emai es requerido.',
            'email.email'               => 'El emai ingresado es icorrecto.',
            'email.unique'              => 'El emai ingresado es ya esta en uso por otro usuario.',
            'department_id.required'    => 'El departamento es requerido.',
            'role.required'             => 'El role es requerido.',
            'password.required'         => 'La contraseña es requerida.',
            'password.min'              => 'La contraseña requiere minimo :min caracteres.',
            'cpassword.required'        => 'Repetir contraseña es requerido.',
            'cpassword.same'            => 'Los campos contraseña y repetir  debe coincidir',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::findOrFail($user);
        $update = $user->update([
            'name'          => $request->name,
            'surname'       => $request->surname,
            'email'         => $request->email,
            'department_id' => $request->department_id,
            'password'      => isset($request->password) ? bcrypt($request->password) : $user->password,
        ]);
        $user->syncRoles($request->role);

        if($update){
            return redirect()->route('admin.users.index')->with(['action' => 'update', 'message' => 'Usuario actualizado exitosamente']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        $delete = User::destroy($user);
        if($delete){
            return redirect()->route('admin.users.index')->with(['action' => 'delete', 'message' => 'Usuario eliminado exitosamente']);
        }
    }
}
