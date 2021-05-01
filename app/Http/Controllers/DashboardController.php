<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedure;

class DashboardController extends Controller
{

    public function index(){
        $procject_completed = Procedure::where('status', 'Completado')->count();
        $procject_pending = Procedure::where('status', 'Pendiente')->count();
        $procedures = Procedure::paginate(10);
        return view('dashboard', compact('procject_completed', 'procject_pending', 'procedures'));
    }
}
