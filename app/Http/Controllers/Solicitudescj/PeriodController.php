<?php
namespace App\Http\Controllers\Solicitudescj;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\Solicitudescj\Period;
use Yajra\Datatables\Datatables;

class PeriodController extends Controller
{
	public function index(){
        /*$users=User::whereHas('roles', function ($query) {
		    $query->whereIn('abv',['SUP','TUT','SEC']);
		})->get();
		dd($users);*/
		//dd($users[0]->roles_label);
		//dd(User::all());
		return view('modules.Solicitudescj.periods.index');
	}

	public function create(){
		
		return view('modules.Solicitudescj.periods.create');
	}

	public function store(Request $request)
    {
        $rules = [
            'descripcion' => 'required|unique:mysql_solicitudescj.periodos,descripcion',
            'fechai' => 'required',
            'fechaf' => 'required',
        ];
        $messages = [
            'descripcion.required' => 'Escriba el descripcion ',
            'fechai.required' => 'Escriba la fecha inicio ',
            'fechaf.required' => 'Escriba la fecha final',
        ];
        $this->validate($request, $rules, $messages);
        $obj=Period::where('estado','A')->update(['estado'=>'I','habilita'=>'I']);
        $period = new Period();
        $period->descripcion=$request->descripcion;
        $period->fechai=$request->fechai;
        $period->fechaf=$request->fechaf;
        $period->recepcioni=$request->recepcioni;
        $period->recepcionf=$request->recepcionf;
        $period->mesi=$request->mesi;
        $period->mesf=$request->mesf;
        $period->notificai=$request->notificai;
        $period->notificaf=$request->notificaf;
        $period->estado = 'A';
        $period->save();

        return redirect()->route('periods.index');
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'descripcion' => 'required|unique:mysql_solicitudescj.periodos,descripcion,'.$id.',id',
            'fechai' => 'required',
            'fechaf' => 'required',
           
        ];
        $messages = [
            'descripcion.required' => 'Escriba el descripcion ',
            'fechai.required' => 'Escriba la fecha inicio ',
            'fechaf.required' => 'Escriba la fecha final',
        ];
        $this->validate($request, $rules, $messages);


        
        $period = Period::find($id);
        $period->descripcion=$request->descripcion;
        $period->fechai=$request->fechai;
        $period->fechaf=$request->fechaf;
        $period->recepcioni=$request->recepcioni;
        $period->recepcionf=$request->recepcionf;
        $period->mesi=$request->mesi;
        $period->mesf=$request->mesf;
        $period->notificai=$request->notificai;
        $period->notificaf=$request->notificaf;
        $period->estado = 'A';
        $period->save();

        return redirect()->route('periods.index');
    }

	public function getDatatable()
    {


	    $periods=Period::get();

    	//dd($postulants);

        return DataTables::of($periods)->addColumn('actions', function ($select) {
            $m='';
            $m.='<p class="text-center">';
            $m.='<a title="Gestionar Periodo" href="'.route('periods.show',$select->id).'"><span class="btn btn-success btn-sm fa fa-cog"></span></a>';
            if($select->estado=='A')
            {
                if($select->habilita!='A')
                {
                    $m.='&nbsp;<a href="'.route('periods.habilita',$select->id).'" class="btn btn-primary btn-sm fa fa-check">&nbsp;Habilitar</a>';

                }else{
                    $m.='&nbsp;<a href="'.route('periods.habilita',$select->id).'" class="btn btn-danger btn-sm fa fa-times">&nbsp;Deshabilitar</a>';

                }
            }
            $m.='<p>';

            return $m;
        })->addColumn('estado_label', function ($select) {
            return $select->estado_label;
        })->rawColumns(['actions','estado_label'])
        ->make(true);


    }

    public function habilita($id)
    {
        $period=Period::find($id);
        if($period->habilita=='A')
        {
            $period->habilita='I';

        }else {
            $period->habilita='A';
 
        }
        $period->save();

        return redirect()->route('periods.index');

    }
    public function show($id){
     	$period=Period::find($id);

		if(!$period){
            return redirect()->route('period.index')->with('danger','No se ha encontrado el periodo');
        }  

        //dd($postulant);

        return view('modules.Solicitudescj.periods.edit', compact('period'));
    }
}