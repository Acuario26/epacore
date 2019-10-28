<?php

namespace App\Http\Controllers\Solicitudescj;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\Solicitudescj\End;
use App\Core\Entities\Solicitudescj\Place;
use App\Core\Entities\Solicitudescj\Postulant;
use App\Core\Entities\Solicitudescj\ProductsPhoto;


use Yajra\Datatables\Datatables;
use App\User;
use DB;
use Auth;



class DirectoraController extends Controller
{
    public function placeIndex()
    {
        return view('modules.Solicitudescj.Directora.placeIndex');

    }
    public function checkout()
    {
        return view('modules.Solicitudescj.Directora.checkout');

    }
    public function ClinicaIndex()
    {
        return view('modules.Solicitudescj.Directora.clinica');

    }
    public function ClinicaFotos($id)
    {
		$images=ProductsPhoto::where('user_id',$id)->get();

        return view('modules.Solicitudescj.Directora.clinicaFotos')->with(['images'=>$images]);

    }
    
    public function datatableClinica()
    {
        $directora= Auth::user()->evaluarole(['Directora']);
        $supervisor= Auth::user()->evaluarole(['Supervisor']);

        $result=DB::connection('mysql_solicitudescj')
        ->table('students_teachers as st')
        ->JOIN('products_photos as p','p.user_id','st.user_est_id')
        ->JOIN('core.users as u','u.id','p.user_id')
        ->JOIN('postulants as ps','ps.identificacion','u.persona_id');
        if($supervisor>0)
        {
            $result=$result->where('ps.estado','A')
            ->where('st.user_doc_id',Auth::user()->id);
        }
           

            $result=$result->select('p.user_id as id','ps.identificacion as Identificacion',
            DB::RAW('CONCAT(ps.apellidos," ",ps.nombres) as Estudiante')    
            )
            ->groupBy('p.user_id','ps.identificacion','ps.apellidos','ps.nombres')
            ->get();

       return DataTables::of($result)
              
        ->addColumn('Opciones', function ($select) {
              return '<a href="'.route('clinica.ClinicaFotos',$select->id).'" class="btn btn-primary">Ver</a>';
            })
           
          
            ->make(true);
    }
    public function datatablecheckout()
    {
        $estudiante= Auth::user()->evaluarole(['estudiante']);
        $supervisor= Auth::user()->evaluarole(['Supervisor']);

        $result=DB::connection('mysql_solicitudescj')
        ->table('postulants as p')
        ->JOIN('core.users as u','u.persona_id','p.identificacion')
        ->JOIN('students_teachers as st','st.user_est_id','u.id')
        ->where('st.tipo','SUP')->where('p.estado','A');
    
            if($supervisor>0)
            {
                $result=$result->where('st.user_doc_id',Auth::user()->id);
            }
            
            $result=$result->select('p.id as id','p.identificacion as identificacion',
            DB::RAW('CONCAT(p.apellidos," ",p.nombres) as estudiante'),
                    'p.hsitu as hsitu','p.hacademicas as hacademicas','p.hclinica','p.htrabajoc','p.capacitaciones'
            )
            ->get();

       return DataTables::of($result)
              
        ->addColumn('Opciones', function ($select) use ($estudiante) {
               // return '<a href="'.route('tutor.imprimirEvaluacion',$select->id).'" target="_blank" class="btn btn-primary btn-sm">Imprimir</a>';
               $horas=$select->hsitu+$select->hacademicas+$select->hclinica+$select->htrabajoc+$select->capacitaciones;

               $memu='';
               $memu.='<p><span class="label label-primary"><h4>'.$horas.' horas</h4></span></p>';

               if($estudiante<1)
               {
                $memu.='&nbsp<a href="'.route('all.editarcheckout',$select->id).'" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>';
              
               }
                return $memu;
            })
           
          
            ->make(true);
    }
    public function editarcheckout($id)
    {
       
        $result=DB::connection('mysql_solicitudescj')
        ->table('postulants as p')->where('p.estado','A')
        ->where('p.id',$id)
        ->select('p.id as id','p.identificacion as identificacion',
        DB::RAW('CONCAT(p.apellidos," ",p.nombres) as estudiante'),
                'p.hsitu as hsitu','p.hacademicas as hacademicas','p.hclinica','p.htrabajoc','p.capacitaciones'
        )
        ->get()->first();        
        return view('modules.Solicitudescj.Directora.editarcheckout',compact('id','result'));

    }
    public function savecheckout(request $request)
    {
        $obj=Postulant::Find($request->id);
       if(isset($request->hsitu))
       {
        $obj->hsitu="160";
       }
       if(isset($request->hacademicas))
       {
        $obj->hacademicas="80";
       }
       if(isset($request->hclinica))
       {
        $obj->hclinica="100";
       }
      
       if(isset($request->htrabajoc))
       {
        $obj->htrabajoc="80";
       }
       if(isset($request->capacitaciones))
       {
        $obj->capacitaciones="80";
       }
       $obj->save();

       return redirect()->route('all.checkout');

}
    public function uploadFinal(request $request)
    {
        $id=Auth::user()->id;
        
         $obj=End::where([
         'user_id' => Auth::user()->id
         ])->delete();
        
   
        
            if($request->file('archivo')){
                $cedula = $request->file('archivo');
                    \Storage::delete($id.'Final'.'.pdf');
                    \Storage::disk('local')->put($id.'Final'.'.pdf',  \File::get($cedula));
              }

                $obj=new End();
                $obj->user_id = Auth::user()->id;
                $obj->filename = $id.'Final'.'.pdf';
                $obj->save();
             
             $m="Subida Exitosa";
 
         
         $estudiante= Auth::user()->evaluarole(['estudiante']);
         $countEs=End::where('user_id',Auth::user()->id)
         ->whereNotIn('estado',['I'])
         ->get()->count();
         
         $cc=0;
                
     return view('modules.Solicitudescj.Directora.Final')->with(['m'=>$m,
     'estudiante'=>$estudiante,'countEs'=>$countEs,'cc'=>$cc
     ]);
 
    }
    public function datatableAllFinal()
	{
        $estudiante= Auth::user()->evaluarole(['estudiante']);
        $directora= Auth::user()->evaluarole(['Directora']);

        $result=DB::connection('mysql_solicitudescj')
            ->table('ends as f');
            if($estudiante>0)
            {
                $result=$result->where('f.user_id',Auth::user()->id);
            }
            
            $result=$result->join('core.users as u','u.id','f.user_id')
            ->join('postulants as p','p.identificacion','u.persona_id')
            ->select('f.id as id',DB::RAW('CONCAT(p.apellidos," ",p.nombres) as estudiante'),
                    'f.estado as estado','f.filename as filename','f.created_at as fecha_registro'
            )
            ->get();

       return DataTables::of($result)
       ->addColumn('Estados', function ($select) {
           switch($select->estado)
           {
               case 'P':
               return '<span class="label label-warning">Pendiente</span>';

               break;
               case 'IS':
               return '<span class="label label-danger">Negado Secretaria</span>';

               break;
               case 'I':
               return '<span class="label label-danger">Negado</span>';

               break;
               case 'AD':
               return '<span class="label label-primary">Aprobado Directora</span>';
               break;

               case 'AS':
               return '<span class="label label-success">Aprobado Secretaria</span>';
               break;
           }
        
        })
        
        ->addColumn('Opciones', function ($select) use ($estudiante,$directora) {
               // return '<a href="'.route('tutor.imprimirEvaluacion',$select->id).'" target="_blank" class="btn btn-primary btn-sm">Imprimir</a>';
               $memu='';
               if($estudiante<1)
               {
                   if($directora<1)
                   {
                       if($select->estado=='P')
                       {
                        $memu.='<a href="'.route('all.aprobarPdf',$select->id).'" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>';
                        $memu.='&nbsp<a onclick="mensaje('.$select->id.')" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>';
                       }
                  }else{
                    if($select->estado!='AD')
                    {
                        $memu.='<a href="'.route('all.aprobarPdf',$select->id).'" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>';
                        $memu.='&nbsp<a onclick="mensaje('.$select->id.')" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>';
                    }
                }
               }
                $memu.='&nbsp<a href="/storage/'.$select->filename.'" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $memu;
            })
           
          
            ->make(true);
    }
    public function negarPdf(request $request)
    {
        $directora= Auth::user()->evaluarole(['Directora']);

            $obj=End::Find($request->id);
            if($directora<1)
            {
                $obj->estado='IS';
            }else{
                $obj->estado='I';
            }
            $obj->descripcion=$request->descripcion;
            $obj->save();
            
            $user=User::Find($obj->user_id);
            if($obj->estado=='I')
            {
                $postulant=Postulant::where('identificacion',$user->persona_id)
                ->where('estado','A')->update(['estado'=>'I']);     
            }
            
            $subject='Proceso Final negado';
            $message='Se ha negado su proceso final por motivo de:'.$request->descripcion.
            ', porfavor vuelva a subir el PDF';
            $to=$user->email;
            mail($to,$subject,$message);

            $array_response['status'] = 200;
		return response()->json($array_response, 200);
           
    }
    public function aprobarPdf($id)
    {
        $directora= Auth::user()->evaluarole(['Directora']);

        $obj=End::Find($id);
        if($directora>0)
        {
            $obj->estado='AD';

        }else{
            $obj->estado='AS';
        }
        $obj->save();
        $m='Grabado Exitosamente';
        $estudiante= Auth::user()->evaluarole(['estudiante']);
        $countEs=End::where('user_id',Auth::user()->id)
        ->whereIn('estado',['AS','AD','P'])
        ->get()->count();
        $user=User::Find($obj->user_id);
        $cc=0;
        $subject='Proceso Final aprobado';
        $message='Su proceso realizado en las practicas 
        ha sido aprobado, favor acercarse en 48 horas al 
        Consultorio Jurídico a recoger su certificado.';
        $to=$user->email;
        if($directora>0)
        {
            $user->estado='I';
            $user->save();
            mail($to,$subject,$message);

        }
        return view('modules.Solicitudescj.Directora.Final')->with(['m'=>$m,
        'estudiante'=>$estudiante,'countEs'=>$countEs,'cc'=>$cc]);
    }
    public function datatableLugares()
	{
       return DataTables::of(
            DB::connection('mysql')
                ->table('places AS a')
                ->select(
                    'a.id as id',
                'a.descripcion as descripcion',
				'a.estado as estado'
               )
                ->get()

        )->addColumn('Estados', function ($select) {
            if($select->estado=="A")
            {
                return '<span class="label label-primary">Activo</span>';

            }else
            {
                return '<span class="label label-danger">Inactivo</span>';

            }

        })
        
        ->addColumn('Opciones', function ($select) {
               // return '<a href="'.route('tutor.imprimirEvaluacion',$select->id).'" target="_blank" class="btn btn-primary btn-sm">Imprimir</a>';
               return '<a href="'.route('admin.editarLugares',$select->id).'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';

            })
           
          
            ->make(true);
    }
    public function saveLugar(request $request)
    {
        if($request->id!=null && $request->id!='')
        {
            $obj=Place::Find($request->id);
            $obj->descripcion=$request->descripcion;
            $obj->estado=$request->estado;
            $obj->save();
            

        }else{
            $obj=new Place();
            $obj->descripcion=$request->descripcion;
            $obj->estado=$request->estado;
            $obj->save();
        }
        return redirect()->route('admin.placeIndex');
       
    }
    public function editarLugares($id)
    {
        $obj=Place::Find($id);
        return view('modules.Solicitudescj.Directora.editarLugares',compact('obj'));
    }
    public function crearLugar()
    {
        return view('modules.Solicitudescj.Directora.crearLugar');

    }
    public function procesoFinal()
    {
        $estudiante= Auth::user()->evaluarole(['estudiante']);
        $countEs=End::where('user_id',Auth::user()->id)
        ->whereIn('estado',['AS','AD','P'])
        ->get()->count();
        $cc=0;
        return view('modules.Solicitudescj.Directora.Final',compact('estudiante','countEs','cc'));
    }
    
}
