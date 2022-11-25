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

}
