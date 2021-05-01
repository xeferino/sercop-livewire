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
                foreach($type->StageProcedures as $item){
                    array_push($data, [
                        'stage'     => $item->name,
                        'sections'  => Stage::find($item->id)->sections
                    ]);
                }
            }
        }
        //dd($data);
        return view('livewire.procedures.add', [
            'departments'   => Department::where('status', 1)->get(),
            'types'         => TypeProcedure::all(),
            'procedures'    =>  $data ?? 0,
            'error'         =>  $error
        ]);
    }

    public function type(Request $request){
        $type = TypeProcedure::find($request->id);
        if($type){
            $data = [];
            foreach($type->StageProcedures as $item){
                array_push($data, [
                    'stage'     => $item->name,
                    'sections'  => Stage::find($item->id)->sections
                ]);
            }
            //return $data;
            return response()->json(['success' => true, 'view' =>  (string) view('livewire.procedures.structure', ['data' => $data])], 200);
        }
        return response()->json(['error' => true, 'message' => 'Error en la carga de los datos'], 404);
    }

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
            "status"        => "required",
            "department"    => "required",
        ];

        $messages = [
            'number.required'        => 'Numero sercop es obligatorio.',
            'number.unique'          => 'Numero sercop debe ser unico.',
            'year.required'          => 'Debe seleccionar un anio',
            'type.required'          => 'Seleccione un tipo de procedimiento',
            'status.required'        => 'Debe seleccionar el estado.',
            'department.required'    => 'Debe seleccionar un departamento.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => 'se han encontrado algunos errores, verifique!', 'errors' => $validator->getMessageBag()->toarray()], 422);
        }
        if($request->has('document')){
            foreach($request->file('document') as $doc => $document){
                $extension  = $document->getClientOriginalExtension();
                if (!in_array($extension, $format)) {
                    $error['file_format'] = "Al menos unos de los documento adjuntado no cumple con el formato PDF";
                    break;
                }
            }
        }

        if(count($error) > 0){
            return response()->json(['error' => true, 'message' => 'se han encontrado algunos errores, verifique!', 'errors' => array('documents' => $error['file_format'])], 422);
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
            if($request->has('document')){
                foreach($request->section as $sec => $section){
                    foreach($request->file('document') as $doc => $document){
                        if($sec ==  $doc){
                            foreach($request->status_document as $statu => $status){
                                if($statu == $sec){
                                    if (File::exists($dir)) {
                                        $stage = $number.'/'.Stage::find(Section::find($section)->stage_id)->name;
                                        if (!File::exists($stage)) {
                                            File::makeDirectory($stage , 0777, true);
                                        }

                                        $seccion = $stage.'/'.Section::find($section)->name;
                                        if (!File::exists($seccion)) {
                                            File::makeDirectory($seccion , 0777, true);
                                        }

                                    $sec_initial = Section::find($section)->short_name;
                                    $stage_initial = Stage::find(Section::find($section)->stage_id)->short_name;

                                    $fileName =  $sec_initial.'_'.$stage_initial.'_'.$request->number.'_'.$request->year.'.'.$document->getClientOriginalExtension();

                                    }

                                    $filesize = $document->move($seccion, $fileName);

                                    if($status == 'Borrador'){
                                        $date_draft = now();
                                    }

                                    if($status == 'Pendiente'){
                                        $date_pending = now();
                                    }

                                    if($status == 'Publicado'){
                                        $date_published = now();
                                    }

                                    if($status == 'Completado'){
                                        $date_completed = now();
                                    }

                                    Document::create([
                                        'name'              => $document->getClientOriginalName(),
                                        'file_name'         => $fileName,
                                        'file_path'         => 'documents/'.$request->year.'/'.Department::find($request->department)->name.'/'.TypeProcedure::find($request->department)->name.'/'.$request->number.'/'.Stage::find(Section::find($section)->stage_id)->name.'/'.Section::find($section)->name.'/',
                                        'file_path_delete'  => $request->number.'/'.Stage::find(Section::find($section)->stage_id)->name.'/'.Section::find($section)->name.'/',
                                        'file_size'         => $this->get_file_size(filesize($filesize)),
                                        'file_type'         => $document->getClientOriginalExtension(),
                                        'status'            => $status,
                                        'procedure_id'      => $procedure->id,
                                        'section_id'        => $section,
                                        'date_draft'        => $date_draft ?? NULL,
                                        'date_pending'      => $date_pending ?? NULL,
                                        'date_published'    => $date_published ?? NULL,
                                        'date_completed'    => $date_completed ?? NULL,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            return response()->json(['success' => true, 'message' => 'Procedimiento registrado exitosamente.', 'url' => route('admin.procedures.index') ], 200);
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
    public function edit(Request $request, $id)
    {
        $procedure = Procedure::findOrFail($id);
        $type = TypeProcedure::find($procedure->type_procedure_id);
        $data = [];

        foreach($type->StageProcedures as $item){
            array_push($data, [
                'procedure' => $procedure,
                'stage_id'  => $item->id,
                'stage'     => $item->name,
                'sections'  => Stage::find($item->id)->sections,
            ]);
        }
        if(isset($request->section) && $request->section){
            return view('livewire.procedures.edit-document', [
                'procedure'   => $procedure,
                'section'     => Section::findOrFail($request->section),
                'documents'   => $procedure->documents,
            ]);
        }
        return view('livewire.procedures.edit', [
            'procedure'   => $procedure,
            'stages'      => $data,
            'types'       => TypeProcedure::all(),
            'departments'   => Department::where('status', 1)->get(),
            'documents'   => $procedure->documents,
        ]);
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
        $error   = [];
        $format = ['pdf'];
        $doc = Document::where('procedure_id', $id)->where('section_id', $request->section)->first();
        $procedure = Procedure::find($id);

        if($request->has('document')){
            $document = $request->file('document');
            $extension  = $document->getClientOriginalExtension();
            if (!in_array($extension, $format)) {
                $error['file'] = "El documento adjuntado no cumple con el formato PDF";
            }
        }
        if($request->doc == 'new' && !$request->has('document')){
            $error['file'] = "El documento es requerido";
        }

        if(count($error) > 0){
            return redirect()->route('admin.procedures.edit', ['procedure' => $id, 'section' =>  $request->section])
                ->withErrors($error)
                ->withInput();
        }
        if($doc){
            if($request->has('document')){
                if (File::exists(public_path($doc->file_path. $doc->file_name))) {
                    File::delete(public_path($doc->file_path. $doc->file_name));
                }

                $file = $request->file('document');
                $fileName   = $doc->file_name;
                $filesize   = $file->move(public_path($doc->file_path), $fileName);

                $doc->update([
                    'name'              => $file->getClientOriginalName(),
                    'file_name'         => $fileName,
                    'file_size'         => $this->get_file_size(filesize($filesize)),
                    'file_type'         => $document->getClientOriginalExtension(),
                ]);
            }

            if($request->status == 'Borrador'){
                $date_draft = now();
            }

            if($request->status == 'Pendiente'){
                $date_pending = now();
            }

            if($request->status == 'Publicado'){
                $date_published = now();
            }

            if($request->status == 'Completado'){
                $date_completed = now();
            }

            $doc->update([
                'status'            => $request->status,
                'date_draft'        => $date_draft ?? NULL,
                'date_pending'      => $date_pending ?? NULL,
                'date_published'    => $date_published ?? NULL,
                'date_completed'    => $date_completed ?? NULL,
            ]);
        }else{
            $dir = public_path() . '/documents/';
            if (!File::exists($dir)) {
                File::makeDirectory($dir , 0777, true);
            }

            $year = $dir.$procedure->year;
            if (!File::exists($year)) {
                File::makeDirectory($year , 0777, true);
            }

            $department = $year .'/'.Department::find($procedure->department_id)->name;
            if (!File::exists($department)) {
                File::makeDirectory($department , 0777, true);
            }

            $type =  $department.'/'.TypeProcedure::find($procedure->department_id)->name;
            if (!File::exists($type)) {
                File::makeDirectory($type , 0777, true);
            }

            $number = $type.'/'.$procedure->number;
            if (!File::exists($number)) {
                File::makeDirectory($number , 0777, true);
            }

            if (File::exists($dir)) {
                $stage = $number.'/'.Stage::find(Section::find($request->section)->stage_id)->name;
                if (!File::exists($stage)) {
                    File::makeDirectory($stage , 0777, true);
                }

                $seccion = $stage.'/'.Section::find($request->section)->name;
                if (!File::exists($seccion)) {
                    File::makeDirectory($seccion , 0777, true);
                }

                $sec_initial = Section::find($request->section)->short_name;
                $stage_initial = Stage::find(Section::find($request->section)->stage_id)->short_name;

                $file = $request->file('document');
                $fileName =  $sec_initial.'_'.$stage_initial.'_'.$procedure->number.'_'.$procedure->year.'.'.$file->getClientOriginalExtension();
                $fileName   = $fileName;
                $filesize = $document->move($seccion, $fileName);

                if($request->status == 'Borrador'){
                    $date_draft = now();
                }

                if($request->status == 'Pendiente'){
                    $date_pending = now();
                }

                if($request->status == 'Publicado'){
                    $date_published = now();
                }

                if($request->status == 'Completado'){
                    $date_completed = now();
                }

                Document::create([
                    'name'              => $file->getClientOriginalName(),
                    'file_name'         => $fileName,
                    'file_path'         => 'documents/'.$procedure->year.'/'.Department::find($procedure->department_id)->name.'/'.TypeProcedure::find($procedure->department_id)->name.'/'.$procedure->number.'/'.Stage::find(Section::find($request->section)->stage_id)->name.'/'.Section::find($request->section)->name.'/',
                    'file_path_delete'  => $procedure->number.'/'.Stage::find(Section::find($request->section)->stage_id)->name.'/'.Section::find($request->section)->name.'/',
                    'file_size'         => $this->get_file_size(filesize($filesize)),
                    'file_type'         => $document->getClientOriginalExtension(),
                    'status'            => $request->status,
                    'procedure_id'      => $procedure->id,
                    'section_id'        => $request->section,
                    'date_draft'        => $date_draft ?? NULL,
                    'date_pending'      => $date_pending ?? NULL,
                    'date_published'    => $date_published ?? NULL,
                    'date_completed'    => $date_completed ?? NULL,
                ]);
            }
        }

        return redirect()->route('admin.procedures.edit', ['procedure' => $id, 'section' =>  $request->section])->with(['action' => 'update', 'message' => 'Datos actualizados exitosamente']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProcedure(Request $request, $id)
    {
        $rules =  [
            "number"        => "required|unique:procedures,number,".$id,
            "year"          => "required",
            "type"          => "required",
            "status"        => "required",
            "department"    => "required",
        ];

        $messages = [
            'number.required'        => 'Numero sercop es obligatorio.',
            'number.unique'          => 'Numero sercop debe ser unico.',
            'year.required'          => 'Debe seleccionar un anio',
            'type.required'          => 'Seleccione un tipo de procedimiento',
            'status.required'        => 'Debe seleccionar el estado.',
            'department.required'    => 'Debe seleccionar un departamento.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => 'se han encontrado algunos errores, verifique!', 'errors' => $validator->getMessageBag()->toarray()], 422);
        }
        $procedure = Procedure::find($id);
        $procedure->update([
            'status' => $request->status,
            'description' => $request->description
        ]);
        return redirect()->back()->with(['action' => 'update', 'message' => 'Estatu actualizado exitosamente']);
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
