<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    protected $messages = [
        'name.required'             => 'El nombre es requerido.',
        'name.min'                  => 'El nombre es requiere minimo :min caracteres.',
        'name.unique'               => 'El nombre debe ser unico.',
        'description.required'      => 'La descripcion es requerida.',
        'syncPermissions.required'  => 'Debe seleccionar al menos un permiso.',
    ];

    protected function rules()
    {
        return [
            'name'              => 'required|min:4|unique:roles,name,'.$this->role_id,
            'description'       => 'required',
            'syncPermissions'   => 'required'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('livewire.roles.index', [
            'roles' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('livewire.roles.add', [
            'permissions' => Permission::all()
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
            'name'              => 'required|min:4|unique:roles,name',
            'description'       => 'required',
            'syncPermissions'   => 'required'
        ];

        $messages = [
            'name.required'             => 'El nombre es requerido.',
            'name.min'                  => 'El nombre es requiere minimo :min caracteres.',
            'name.unique'               => 'El nombre debe ser unico.',
            'description.required'      => 'La descripcion es requerida.',
            'syncPermissions.required'  => 'Debe seleccionar al menos un permiso.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $role = Role::create([
                    'name'        => $request->name,
                    'description' => $request->description
                ])->syncPermissions($request->syncPermissions);
        if($role){
            return redirect()->route('admin.roles.index')->with(['action' => 'store', 'message' => 'Rol registrado exitosamente']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($role)
    {
        $syncPermissions = DB::table('role_has_permissions')->select('permission_id')->where('role_id',  $role)->pluck('permission_id')->toArray();
        return view('livewire.roles.show', [
            'permissions'       => Permission::whereIn('id', $syncPermissions)->get(),
            'role'              => Role::findOrFail($role),
            'syncPermissions'   => $syncPermissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($role)
    {
        $syncPermissions = DB::table('role_has_permissions')->select('permission_id')->where('role_id',  $role)->pluck('permission_id')->toArray();
        return view('livewire.roles.edit', [
            'permissions'       => Permission::all(),
            'role'              => Role::findOrFail($role),
            'syncPermissions'   => $syncPermissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role)
    {
        $rules =  [
            'name'              => 'required|min:4|unique:roles,name,'.$role,
            'description'       => 'required',
            'syncPermissions'   => 'required'
        ];

        $messages = [
            'name.required'             => 'El nombre es requerido.',
            'name.min'                  => 'El nombre es requiere minimo :min caracteres.',
            'name.unique'               => 'El nombre debe ser unico.',
            'description.required'      => 'La descripcion es requerida.',
            'syncPermissions.required'  => 'Debe seleccionar al menos un permiso.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return  redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $role = Role::findOrFail($role);

        $update = $role->update([
            'name'         => $request->name,
            'description'  => $request->description
        ]);
        $role->syncPermissions($request->syncPermissions, true);
        if($update){
            return redirect()->route('admin.roles.index')->with(['action' => 'update', 'message' => 'Rol actualizado exitosamente']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($role)
    {
        $delete = Role::destroy($role);
        if($delete){
            return redirect()->route('admin.roles.index')->with(['action' => 'delete', 'message' => 'Rol eliminado exitosamente']);
        }
    }
}
