<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use App\Models\TypeProcedure;
use App\Models\Section;
use App\Models\Stage;
use App\Models\Document;
use App\Models\Procedure;
use App\Models\Deparment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use File;

class ProcedureController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $error  = [];

        if($request->input('procedure')!=NULL){
            $type = TypeProcedure::find($request->input('procedure'));
            if($type){
                $data = [];
                foreach($type->stages as $item){
                    array_push($data, [
                        'stage'     => $item->name,
                        'sections'  => Stage::find($item->id)->sections
                    ]);
                }
            }
        }

        return view('livewire.procedures.add', [
            'departments'   => Department::where('status', 1)->get(),
            'types'         => TypeProcedure::all(),
            'procedures'    =>  $data ?? 0,
            'error'         =>  $error
        ]);
    }

    /* public function type(Request $request){
        $type = TypeProcedure::find($request->id);
        if($type){
            $data = [];
            foreach($type->stages as $item){
                array_push($data, [
                    'stage'     => $item->name,
                    'sections'  => Stage::find($item->id)->sections
                ]);
            }
            return $data;
            //return response()->json(['success' => true, 'view' =>  (string) view('livewire.procedures.structure', ['data' => $data])], 200);
        }
        //return response()->json(['error' => true, 'message' => 'Error en la carga de los datos'], 404);
    } */

    function get_file_size($size)
    {
        $units = array('Bytes', 'KB', 'MB');
        return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2).' '.$units[$i];
    }

    public function downloadFile(Request $request)
    {
        $document = Document::find($request->file);
        return response()->download($document->file_path.$document->file_name);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $error   = [];
        $format = ['pdf'];

        $rules =  [
            "number"        => "required|unique:procedures,number",
            "year"          => "required",
            "type"          => "required",
            "document"      => "required_with:type",
            "status"        => "required",
            "department"    => "required",
        ];

        $messages = [
            'document.required_with' => 'Debe adjuntar al menos un documento y en formato PDF',
             /*'document.mimes'         => 'Al menos unos de los documento adjuntado debe ser formato en PDF',
            'document.max'           => 'Al menos unos de los documento adjuntado debe tener un peso maximo de max:', */
            'number.required'        => 'Numero sercop es obligatorio.',
            'number.unique'          => 'Numero sercop debe ser unico.',
            'year.required'          => 'Debe seleccionar un anio',
            'type.required'          => 'Debe seleccionar un tipo de procedimiento, para cargar las secciones y el documento correspondiente.',
            'status.required'        => 'Debe seleccionar el estado.',
            'department.required'    => 'Debe seleccionar un departamento.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        foreach($request->file('document') as $doc => $document){
            $extension  = $document->getClientOriginalExtension();
            if (!in_array($extension, $format)) {
                $error['file_format'] = "Al menos unos de los documento adjuntado no cumple con el formato PDF";
                break;
            }
        }

        if(count($error) > 0){
            return redirect()->back()
                ->withErrors($error)
                ->withInput();
        }

        $procedure = Procedure::create([
            'number'        => $request->number,
            'description'   => $request->description,
            'year'          => $request->year,
            'status'        => $request->status,
            'department_id'  => $request->department,
            'user_id'       => Auth::user()->id,
            'type_procedure_id'  => $request->type,
            'description'  => $request->description,
            'created_at'  => $request->created_at,
        ]);

        $dir = public_path() . '/documents/';
        if (!File::exists($dir)) {
            File::makeDirectory($dir , 0777, true);
        }

        $year = $dir.$request->year;
        if (!File::exists($year)) {
            File::makeDirectory($year , 0777, true);
        }

        $department = $year .'/'.Department::find($request->department)->name;
        if (!File::exists($department)) {
            File::makeDirectory($department , 0777, true);
        }

        $type =  $department.'/'.TypeProcedure::find($request->department)->name;
        if (!File::exists($type)) {
            File::makeDirectory($type , 0777, true);
        }

        $number = $type.'/'.$request->number;
        if (!File::exists($number)) {
            File::makeDirectory($number , 0777, true);
        }
        if($procedure){
            foreach($request->section as $sec => $section){
                foreach($request->file('document') as $doc => $document){
                    if($sec ==  $doc){
                        if (File::exists($dir)) {
                            $stage = $number.'/'.Stage::find(Section::find($section)->stage_id)->name;
                            if (!File::exists($stage)) {
                                File::makeDirectory($stage , 0777, true);
                            }

                            $seccion = $stage.'/'.Section::find($section)->name;
                            if (!File::exists($seccion)) {
                                File::makeDirectory($seccion , 0777, true);
                            }

                           $sec_initial = Str::limit(Section::find($section)->name, 2, '');
                           $stage_initial = Str::limit(Stage::find(Section::find($section)->stage_id)->name, 3, '');

                           $fileName =  $sec_initial.'_'.$stage_initial.'_'.$request->number.'_'.$request->year.'.'.$document->getClientOriginalExtension();

                        }

                        $filesize = $document->move($seccion, $fileName);

                        Document::create([
                            'name'          => $document->getClientOriginalName(),
                            'file_name'     => $fileName,
                            'file_path'     => 'documents/'.$request->year.'/'.Department::find($request->department)->name.'/'.TypeProcedure::find($request->department)->name.'/'.$request->number.'/'.Stage::find(Section::find($section)->stage_id)->name.'/'.Section::find($section)->name.'/',
                            'file_path_delete'     => $request->number.'/'.Stage::find(Section::find($section)->stage_id)->name.'/'.Section::find($section)->name.'/',
                            'file_size'     => $this->get_file_size(filesize($filesize)),
                            'file_type'     => $document->getClientOriginalExtension(),
                            'procedure_id'  => $procedure->id,
                            'section_id'    => $section,
                        ]);
                    }
                }
            }
            return redirect()->route('admin.procedures.index')->with(['action' => 'store', 'message' => 'Procedimiento registrado exitosamente']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $procedure = Procedure::findOrFail($id);
        return view('livewire.procedures.show', [
            'procedure'   => $procedure
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $procedure  = Procedure::find($id);

        foreach ($procedure->documents as $key => $document) {
            if (File::exists(public_path($document->file_path.$document->file_name))) {
                File::delete(public_path($document->file_path.$document->file_name));
            }
        }
        $delete = $procedure->delete();

        if($delete){
            return redirect()->route('admin.procedures.index')->with(['action' => 'delete', 'message' => 'Procedimiento eliminado exitosamente']);
        }
    }
}
