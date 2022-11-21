<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserData;
use App\Models\User;
use DB;
use Exception;
class UserDataController extends Controller
{
    function userInfo(){
        $result=[
            'status'=>1,
            'msg'=>'correcto',
            'data'=>auth()->user(),
        ];
        return $result;
    }

    function userAvanzada(){
        $dev='';
        try{
            $datos=DB::table('userdata')->where('user_id', auth()->user()->id)->first();
            $dev='No fue ingresada informacion extra a este usuario';
            if (isset($datos)){
               $dev=$datos;
            }
        } catch (Exception $e) {
            $dev='No fue posible recuperar la informacion';
        }

        $result=[
            'status'=>1,
            'msg'=>'correcto',
            'data'=>$dev
        ];
        return $result;
    }

    function userFoto(){
        $datos=DB::table('userdata')->where('user_id', auth()->user()->id)->first();
        $dev='No fue ingresada Imagen';
        if (isset($datos->imagenes) && $datos->imagenes!=''){
           $dev=$datos->imagenes;
        }
        $result=[
            'status'=>1,
            'msg'=>'correcto',
            'data'=>$dev
        ];
        return $result;
    }

    function userActividad(){
        $datos = UserData::where('user_id', auth()->user()->id)->first();
        $dev='No fue ingresada actividad';
        if (isset($datos->actividad) && $datos->actividad!=''){
           $dev=$datos->actividad;
        }

        $result=[
            'status'=>1,
            'msg'=>'correcto',
            'data'=>$dev
        ];
        return $result;
    }
    function userActividadAct(Request $request){
        $datos = UserData::where('user_id', auth()->user()->id)->first();
        //  $datos=DB::table('userdata')->where('iduser', auth()->user()->id)->first();
        $datos->actividad=$request->valor;
        $datos->save();
        $result=[
            'status'=>1,
            'msg'=>'Actualizado correctamente',
            'data'=>$datos->actividad
        ];
        return $result;
    }

    function userNameAct(Request $request){
        $datos = UserData::where('user_id', auth()->user()->id)->first();
        //  $datos=DB::table('userdata')->where('iduser', auth()->user()->id)->first();
        $datos->nombre=$request->valor;
        $datos->save();
        $result=[
            'status'=>1,
            'msg'=>'Actualizado correctamente',
            'data'=>$datos->nombre
        ];
        return $result;
    }
    function userFotoAct(Request $request){
        $datos = UserData::where('user_id', auth()->user()->id)->first();
        $datos->imagenes=$request->valor;
        $datos->save();
        $result=[
            'status'=>1,
            'msg'=>'Actualizado correctamente',
            'data'=>$datos->imagenes
        ];
        return $result;
    }


    function profesionalesListar(){
        $profesionales = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Profesional');
            }
        )->get();
        $result=[
            'status'=>1,
            'msg'=>'Actualizado correctamente',
            'data'=> $profesionales
        ];
        return $result;
    }
}
