<?php

namespace App\Services\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Repositories\CotiRepository;
use DB;
class CotiService extends Controller
{
    private $cotiRepository;

    public function __construct()
    {
        $this->cotiRepository=new CotiRepository;
    }

    public function index($info)
    {
        $msg='';$status=0;
        $cotizaciones=$this->cotiRepository->listar($this->role(auth()->user()->id));
        $result=[
            'success'=>1,
            'msg'=>'' . $msg,
            'data'=> $cotizaciones
        ];
        return $result;
    }

    public function store($request)
    {
        $repo_result=$this->cotiRepository->guardar($request);
        return $repo_result;
    }

    public function show($id)
    {
        $cotizacion=$this->cotiRepository->buscar($id);
        $result=[
            'status'=>'1',
            'msg'=>'' ,
            'data'=> $comentarios
        ];
        return $result;
    }

    public function Update($request, $id)
    {
        $msg='';
        $result=[
            'status'=>1,
            'msg'=>'correcto'
        ];
        $result=$this->cotiRepository->update($request,$id);
        return $result;

    }
    public function Destroy($id)
    {
        $result=$this->cotiRepository->eliminar($id);
        return $result;
    }

    public function role($id)
    {
        $role=DB::table('role_user')
        ->select('role_user.*', 'roles.name as rol')
        ->leftjoin('roles', 'role_user.role_id', 'roles.id')
        ->where('role_user.user_id', $id)
        ->first();
        return $role->rol;
    }

}
