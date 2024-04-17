<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;

use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function addDummyData()
    {
        Artisan::call('db:seed');
        return redirect()->back()->with('status', 'Dummy Data added successfully in sales and sales item tables.');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xls,xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Excel::import(new ProductsImport, $request->file('file'));
        
        return redirect()->back()->with('success', 'Products imported successfully.');
    }
}
