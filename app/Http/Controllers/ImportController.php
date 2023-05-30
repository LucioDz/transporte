<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Imports\VeiculoImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    
    public function VeiculoImportar_exel() {

        Excel::import(new VeiculoImport,request()->file('arquivo'));
        
        return redirect('/')->with('success', 'All good!');
    }
}
