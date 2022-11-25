<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Http\Controllers\Controller;
use DB;
class DbRepository extends Controller
{
    public function role($id){
        $role=DB::table('role_user')
        ->select('role_user.*', 'roles.name as rol')
        ->leftjoin('roles', 'role_user.role_id', 'roles.id')
        ->where('role_user.user_id', $id)
        ->first();
        return $role->rol;
    }

}
