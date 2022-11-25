<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\UserData;
use App\Http\Controllers\Controller;
use DB;
use App\Models\User;
class UserDataRepository extends Controller
{

    public function getProf($rol){
        $profesionales = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Profesional');
            }
        )->get();
        return $profesionales;
    }

    public function getRoles(){
        $user=User::find(auth()->user()->id)->Roles()->orderBy('name')->first();
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
       $role = User::find($id=auth()->user()->id)->Roles()->orderBy('name')->first();
       $role->pivot->role_id=2;
       $role->pivot->save();

       $data = [
        'status'=>1,
        'msg'=>'Usuario actualizado',
        'js'=>'parent.document.getElementById("role").innerHTML="Profesional";',
        'datos'=> $role
        ];
        return $data;
    }

    public function roleVisita()
    {
       $role = User::find($id=auth()->user()->id)->Roles()->orderBy('name')->first();
       $role->pivot->role_id=1;
       $role->pivot->save();

       $data = [
        'status'=>1,
        'msg'=>'Usuario actualizado',
        'js'=>'parent.document.getElementById("role").innerHTML="Visita";',
        'datos'=> $role
        ];
        return $data;
    }

}
