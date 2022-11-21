<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comentarios;
use App\Models\Cotizacion;
use DB;
use Exception;
class ComentController extends Controller
{
    public function index()
    {
        $comentarios='';
        if ($this->role(auth()->user()->id) == 'Profesional') {
            $comentarios=Comentarios::where('profesional_id', auth()->user()->id)->get();
            $status=1;
        }else{
            $status=0;
            $msg="Solo usuarios profesionales pueden listar valoraciones";
        }
        $result=[
            'status'=>$status,
            'msg'=>'' . $msg,
            'data'=> 'Datos enviados Desc: ' . $comentarios
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

    public function store(Request $request)
    {
        $result=[
            'status'=>1,
            'msg'=>'correcto'
        ];
        //validamos si estado 4
        $cotizacion=cotizacion::find($request->cotizacion_id);

            if (isset($cotizacion->estado_id) && $cotizacion->estado_id == 4 && $cotizacion->particular_id == auth()->user()->id) {
                $coti                   = new Comentarios;
                $coti->comentario       = $request->comentario;
                $coti->cotizacion_id    = $request->cotizacion_id;
                $coti->profesional_id   =$cotizacion->profesional_id;
                $coti->save();
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
        return 'show';
    }

    public function update(Request $request, $id)
    {
        $msg='';
        $result=[
            'status'=>1,
            'msg'=>'correcto'
        ];
        try {
            $comentario=Comentarios::find($id);
            } catch (Exception $e) {
                $msg='No fue posible actualizar la valoracion';
              }

        if (isset($comentario) && $comentario->profesional_id==auth()->user()->id){
            $comentario->comentario=$request->comentario;
            $comentario->save();
        }else{
            $result=[
                'status'=>0,
                'msg'=>'No tiene permisos para este comentario o es inexistente' . $msg
            ];
        }
        return $result;
    }

    public function destroy($id)
    {
        $result=[
            'status'=>0,
            'msg'=>'Las valoraciones no es posible eliminarlas',
            'data'=> 'No tiene permisos para eliminar opiniones.'
        ];
        return $result;

    }
}
