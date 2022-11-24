<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Models\user;
use DB;
use Exception;
use GuzzleHttp;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
//use Nyholm\Psr7\Request;

class CotiController extends Controller
{
    public function index ()
    {
        $msg='';$status=0;
        try{
            if ($this->role(auth()->user()->id) == 'Profesional') {
                $cotizaciones=DB::table('cotizaciones')->where('profesional_id', auth()->user()->id)->get();
            }else{
                $cotizaciones=DB::table('cotizaciones')->where('particular_id', auth()->user()->id)->get();
            }
            $status=1;
        } catch (Exception $e) {
            $cotizaciones='No se obtuvieron resultados.';
        }
        $result=[
            'status'=>$status,
            'msg'=>'' . $msg,
            'data'=> response()->json([$cotizaciones])
        ];
        return $result;
    }

    public function role($id)
    {
        $role=DB::table('role_user')
        ->select('role_user.*', 'roles.name as rol')
        ->leftjoin('roles', 'role_user.role_id', 'roles.id')
        ->where('role_user.user_id', $id)
        ->first();
        if (!isset($role->rol)){
            return false;
        }
        return $role->rol;
    }

    public function store(Request $request)
    {
        $result=[
            'status'=>1,
            'msg'=>'correcto'
        ];
        //validamos si existe y es profesional
        if ($this->role($request->profesional_id) == 'Profesional' && auth()->user()->id != $request->profesional_id) {
            $coti                   = new Cotizacion;
            $coti->descripcion      = $request->descripcion;
            $coti->precio           = $request->precio;
            $coti->particular_id    = auth()->user()->id;
            $coti->profesional_id   = $request->profesional_id;
            $coti->estado_id        = '1';
            $coti->num_ip           = $_SERVER['REMOTE_ADDR'];
            $coti->save();
        }else{
            $result=[
                'status'=>0,
                'msg'=>'(error) el usuario no es profesional o eres tu mismo.',
                'data'=> 'Datos enviados Desc: ' . $request->descripcion . ' precio: ' . $request->precio . ' profesional_id: ' . $request->profesional_id . ' '
            ];
        }
        return $result;
    }


    public function cotiGeo(Request $request){
        $coti=Cotizacion::find($request->cotizacion_id);
        if (isset($coti->num_ip)){
            $response = Http::get('http://ipwho.is/' . $coti->num_ip);
            $datos=$response->object();
        }else{
           $datos='No fue detectado ip para esta solicitud';
        }




        $result=[
            'status'=>1,
            'msg'=>'Solicitud recibida',
            'data'=>$datos
        ];
        return $result;
    }


    public function show($id)
    {
        //
    }

    public function update($Cotizacion, Request $request)
    {
        $msg='';
        $coti=Cotizacion::find($Cotizacion);
        if ($this->role(auth()->user()->id) == 'Profesional' &&  $coti->profesional_id==auth()->user()->id) {     // es un profesional actualizaciondo el estado de una cotizacion
            if (isset($request->estado_id)){$coti->estado_id=$request->estado_id;}
            $msg.='ingreso a a actualizar profesional';
            // if (isset($request->descripcion)){$coti->descripcion=$request->descripcion;}
            //if (isset($request->precio)){$coti->precio=$request->precio;}
        }
        if ($this->role(auth()->user()->id) == 'Particular' &&  $coti->particular_id==auth()->user()->id) {        // es un Particular, no puede actualizar el estado
            if (isset($request->descripcion)){$coti->descripcion=$request->descripcion;}
            if (isset($request->precio)){$coti->precio=$request->precio;}
            $msg.="Ingreso a actualizar Particular";
          //  if (isset($request->estado_id)){$coti->estado_id=$request->estado_id;}
        }

        $coti->save();
        $result=[
            'status'=>1,
            'msg'=>'',
            'data'=> 'Actualizacion correcta -' . $msg . ' datos enviados desc: ' . $request->descripcion . ' precio: ' . $request->precio . ' nuevo estado: ' . $request->estado_id
        ];
        return $result;
    }

    public function destroy($id)
    {
        $msg='';
        $status=0;
        try {
            $cotizacion=Cotizacion::findOrFail($id);
            if ($cotizacion->particular_id==auth()->user()->id){
                $cotizacion->delete();
                $status=1;
                $msg='Cotizacion eliminada correctamente';
            }else{
                $msg='La cotizacion indicada no puede eliminarse o no pertenece al usuario creador';
            }

            } catch (Exception $e) {
              $msg='No existe la cotizacion' . $e->getMessage() ;
            }

        $result=[
            'status'=>$status,
            'msg'=>$msg,
            'data'=> 'Datos enviados Desc: ' . $msg
        ];
        return $result;
    }
}
