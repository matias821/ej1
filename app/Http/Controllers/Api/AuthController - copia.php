<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use GuzzleHttp;
use function Termwind\ValueObjects\with;
class AuthController extends Controller
{


    public function roleGet()
    {
       $id=auth()->user()->id;
       $role = User::find($id)->Roles()->orderBy('name')->first();

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

    public function roleProfesional()
    {
       $id=auth()->user()->id;
       $role = User::find($id)->Roles()->orderBy('name')->first();


        switch ($role->pivot->role_id){
            case 1:
                $msg="Datos enviados correctamente";
                $role->pivot->role_id=2;
                $role->pivot->save();
                break;
            case 2:
                $msg="El usuario ya es profesional";
                break;
            default:
                $msg="No es posible actualizar el nivel de usuario";
        }

       $data = [
        'status'=>1,
        'msg'=>$msg,
        'js'=>'parent.document.getElementById("role").innerHTML="Profesional";',
        'datos'=> $role
        ];
        return $data;
    }

    public function roleVisita()
    {
       $id=auth()->user()->id;
       $role = User::find($id)->Roles()->orderBy('name')->first();
       $status=0;

        switch ($role->pivot->role_id){
            case 1:
            $msg="El usuario ya tiene permisos de visita";
            break;
            case 2:
                $msg="Datos enviados correctamente";
                $role->pivot->role_id=1;
                $role->pivot->save();
                $status=1;
                break;
            default:
                $msg="No es posible actualizar el nivel de usuario";
        }

       $data = [
        'status'=>$status,
        'msg'=>$msg,
        'js'=>'parent.document.getElementById("role").innerHTML="Visita";',
        'datos'=> $role
        ];
        return $data;
    }

    public function info(Request $request){
        $result=[
            'status'=>1,
            'msg'=>'correcto',
            'data'=>'Conexion Correcta'
        ];
        return $result;
    }
    public function myId(Request $request){
        return auth()->user();
    }


    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            //return ("Error en los datos enviados a la api" . $validator->errors());
            $data = [
                'status'=>0,
                'token' => '0',
                'user' => '0',
                'msg'=>"Error en los datos enviados a la api" . $validator->errors(),
            ];
            return response()->json([$data]);
        }

        $input = $request->all();
        $input["password"] = bcrypt($request->get("password"));

        if (User::where('email', '=', $request["email"])->count() > 0) {
            $data = [
                'status'=>0,
                'token' => '0',
                'user' => '0',
                'msg'=>"El correo que intenta registrar ya existe",
            ];
            return response()->json([$data]);
        }

        $user = User::create($input);
        $token = $user->createToken("MyApp")->accessToken;

        $data = [
            'status'=>1,
            'token' => $token,
            'user' => $user
        ];
        return response()->json([$data]);
    }
    public function test(request $request)
    {
        return 'testing';
    }
}
