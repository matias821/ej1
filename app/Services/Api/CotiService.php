<?php

namespace App\Services\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cotizacion;
use DB;
use Exception;
use App\Repositories\CotiRepository;

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
            'status'=>$status,
            'msg'=>'' . $msg,
            'data'=> response()->json([$cotizaciones])
        ];
        return $result;
    }

    public function store($request)
    {
        $result=[
            'status'=>1,
            'msg'=>'correcto'
        ];
        $this->cotiRepository->guardar($request);
        return $result;
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
        $this->cotiRepository->update($id, $request);
        return $result;

    }
    public function Destroy($info)
    {
        $result=[
            'status'=>0,
            'msg'=>'Las valoraciones no es posible eliminarlas',
            'data'=> 'No tiene permisos para eliminar opiniones.'
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
        return $role->rol;
    }

}
