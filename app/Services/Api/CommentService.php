<?php

namespace App\Services\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cotizacion;
use DB;
use Exception;
use App\Repositories\CommentRepository;

class CommentService extends Controller
{
    private $commentRepository;

    public function __construct()
    {
        $this->commentRepository=new CommentRepository;
    }

    public function index($info)
    {
        $comentarios='';$msg='';
        if ($this->role(auth()->user()->id) == 'Profesional') {
            $comentarios=$this->commentRepository->listar();
            $status=1;
        }else{
            $status=0;
            $msg="Solo usuarios profesionales pueden listar valoraciones22";
        }
        $result=[
            'status'=>$status,
            'msg'=>'' . $msg,
            'data'=> 'Datos enviados Desc: ' . $comentarios
        ];
        return $result;
    }

    public function store($request)
    {
        $result=[
            'status'=>1,
            'msg'=>'correcto'
        ];
        //validamos si estado 4
        $cotizacion=cotizacion::find($request->cotizacion_id);
        if (isset($cotizacion->estado_id) && $cotizacion->estado_id == 4 && $cotizacion->particular_id == auth()->user()->id) {
            $this->commentRepository->guardar($request, $cotizacion->profesional_id);
        }else{
            $result=[
                'status'=>0,
                'msg'=>'El estado de la cotizacion debe ser finalizado (4). m,'
            ];
        }
        return $result;
    }

    public function show($id)
    {
        $comentarios=$this->commentRepository->buscar($id);
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
        $this->commentRepository->update($id, $request->comment);
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
