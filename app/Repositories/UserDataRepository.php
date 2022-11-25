<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\UserData;
use App\Http\Controllers\Controller;
use DB;
use App\Models\User;
class UserDataRepository extends Controller
{

public function get(){
    try{
        $datos=DB::table('userdata')->where('user_id', auth()->user()->id)->first();
        $dev='No fue ingresada informacion extra a este usuario';
        if (isset($datos)){
            $result=[
                'success'=>1,
                'msg'=>'Datos obtenidos',
                'data'=> $datos//'Save ejecutado correctamente'
            ];
        }
        } catch (Exception $e) {
        $result=[
            'success'=>0,
            'msg'=>'Error al obtener datos',
            'data'=> 'Error al obtener datos'//'Save ejecutado correctamente'
        ];
    }
    return $result;
}

public function getData(){
    try{
        $datos=DB::table('userdata')->where('user_id', auth()->user()->id)->first();
        if (isset($datos)){
           return $datos;
        }
        } catch (Exception $e) {
            return false;
        }
    return false;
}




    public function getProf($rol){
        $profesionales = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Profesional');
            }
        )->get();
        return $profesionales;
    }

    public function guardar($request){                           //utilizado para insert y update.
        $coti                            = new Cotizacion;
        $coti->descripcion               = $request->descripcion;
        $coti->precio                    = $request->precio;
        $coti->profesional_id            = $request->profesional_id;
        $coti->particular_id             = auth()->user()->id;
        $coti->estado_id                 = '1';
        $coti->num_ip                    = $_SERVER['REMOTE_ADDR'];

        try{
            if ($coti->save()){
                $result=[
                    'success'=>1,
                    'msg'=>'Cotizacion añadida correctamente',
                    'data'=> 'Insercion correcta'//'Save ejecutado correctamente'
                ];
            }
         }
         catch(\Exception $e){
            $result=[
                'success'=>0,
                'msg'=>'Ocurrio un error al crear una cotizacion',
                'data'=> $e->getMessage()//'Save ejecutado correctamente'
            ];

         }
       return $result;
    }
    public function act($cliente,$arrCambios){    //ej cliente=27  arrCambios=array('nombre'=>'Perez2');
        try{
            $userData = UserData::where('user_id', $cliente)->update($arrCambios);
            return [
                'success'=>1,
                'msg'=>'Actualizacion exitosa',
                'data'=> 'Correcto'
            ];;
        } catch (Exception $e) {
            return false;
        }

    }

    public function eliminar($id){
        try{
            $cotizacion=Cotizacion::where('id', $id);
            if ($cotizacion){
                if ($cotizacion->delete()){
                    $result=[
                        'success'=>1,
                        'msg'=>'Cotizacion eliminada correctamente',
                        'data'=> 'Correcto'
                    ];
                }else{
                    $result=[
                        'success'=>0,
                        'msg'=>'No fue posible eliminar la cotizacion solicitada',
                        'data'=> 'error'
                    ];
                }
            }else{
                $result=[
                    'success'=>0,
                    'msg'=>'No fue encontrada la cotizacion que nos indica',
                    'data'=> 'error'
                ];
            }

        } catch (Exception $e) {
            $result=[
                'success'=>0,
                'msg'=>'Ocurrio un error al eliminar una cotizacion',
                'data'=> $e->getMessage()//'Save ejecutado correctamente'
            ];
        }
        return $result;
    }
}
