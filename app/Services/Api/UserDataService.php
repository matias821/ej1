<?php
namespace App\Services\Api;
use App\Http\Controllers\Controller;

use App\Models\UserData;
use App\Models\User;
use DB;
use Exception;
use App\Repositories\UserDataRepository;
use App\Repositories\DbRepository;
use Illuminate\Http\Request;

class UserDataService extends Controller
{
    private $userDataRepository;
    private $db;

    public function __construct()
    {
        $this->userDataRepository=new UserDataRepository;
        $this->db=new DbRepository;

    }

    public function userActivityAct(Request $request){
        return $this->userAct('actividad', $request->actividad);
    }
    public function userNameAct(Request $request){
        return $this->userAct('nombre', $request->nombre);
    }
    public function userFotoAct(Request $request){
        return $this->userAct('imagenes', $request->foto);
    }
    public function userDomicilioAct(Request $request){
        return $this->userAct('domicilio', $request->domicilio);
    }
    public function userEdadAct(Request $request){
        return $this->userAct('edad', $request->edad);
    }

    public function userAct($parametro, $variable){
        if (isset($variable)){
            return $this->userDataRepository->act(auth()->user()->id,array($parametro=>$variable));
        }else{
            return [
             'success'=>0,
             'msg'=>'Error de validacion',
             'meta_data'=>'',
             'errores'=>$parametro . ' es requerido '
         ];
        }
    }

    function userInfo(){
        $result=[
            'success'=>1,
            'msg'=>'correcto',
            'data'=>auth()->user(),
        ];
        return $result;
    }

    function userAvanzado(){
        return $this->userDataRepository->get($this->db->role(auth()->user()->id));
    }

    function userFoto(){
        $dev='';$msg='El usuario no tiene fotografia';$success=0;
        $datos=$this->userDataRepository->getData($this->db->role(auth()->user()->id));
        if (isset($datos->imagenes) && $datos->imagenes!=''){
           $success=1;$dev=$datos->imagenes;$msg='Correcto';
        }
        $result=[
            'success'=>$success,
            'msg'=>$msg,
            'data'=>$dev
        ];
        return $result;
    }

    function userActivity(){
        $dev='';$msg='El usuario no tiene actividad registrada';$success=0;
        $datos=$this->userDataRepository->getData($this->db->role(auth()->user()->id));
        if (isset($datos->actividad) && $datos->actividad!=''){
           $success=1;$dev=$datos->actividad; $msg='Correcto';
        }
        $result=[
            'success'=>$success,
            'msg'=>$msg,
            'data'=>$dev
        ];
        return $result;
    }

    function profesionalesListar(){
        return $this->userDataRepository->getProf($this->db->role(auth()->user()->id));
    }


    public function roleGet()
    {
       $role = User::find(auth()->user()->id)->Roles()->orderBy('name')->first();

       $roleName='Role';
       if (isset($role->name)){
           $roleName=$role->name;
       }

       $data = [
        'status'=>1,
        'msg'=>'Informacion de permisos correcta',
        'js'=>'parent.document.getElementById("role").innerHTML="' . $roleName . '";',
        'datos'=> $role
        ];
        return $data;
    }
}
