<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportExportController extends Controller
{
    public function ImportAllTable(){
        return view('import_export.import_table');
    }
}
