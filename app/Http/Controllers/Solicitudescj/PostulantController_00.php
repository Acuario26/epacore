<?php

namespace App\Http\Controllers\Solicitudescj;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\Solicitudescj\Postulant;
use App\Core\Entities\Solicitudescj\RequestPostulant;
use Yajra\Datatables\Datatables;

class PostulantAController extends Controller
{
	public function index(){
		
		return view('modules.Solicitudescj.postulants.index');

	}

	public function getDatatable()
    {


    	$postulants=Postulant::with(['career','request','request.state'])->get();

    	//dd($postulants);

        return DataTables::of($postulants)->addColumn('actions', function ($select) {

            return '';
        })
            ->make(true);
    }

}
