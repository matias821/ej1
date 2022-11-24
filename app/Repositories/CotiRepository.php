<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Http\Controllers\Controller;
use DB;
class CotiRepository extends Controller
{
    public function listar($rol){
        switch ($rol){
            case 'Particular':
                $cotizaciones=DB::table('cotizaciones')->where('particular_id', auth()->user()->id)->get();
                break;
            case 'Profesional':
                $cotizaciones=DB::table('cotizaciones')->where('profesional_id', auth()->user()->id)->get();
                break;
        }
        return $cotizaciones;
    }
    public function buscar($id){
        return Cotizacion::where('id', $id);
    }
    public function guardar($request){                           //utilizado para insert y update.
        $coti                            = new Cotizacion;
        $coti->descripcion               = $request->descripcion;
        $coti->precio                    = $request->precio;
        $coti->profesional_id            = $request->profesional_id;
        $coti->particular_id             = auth()->user()->id;
        $coti->estado_id                 = '1';
        $coti->num_ip                    = $_SERVER['REMOTE_ADDR'];

        try{
            if ($coti->save()){
                $result=[
                    'success'=>1,
                    'msg'=>'Cotizacion añadida correctamente',
                    'data'=> 'Insercion correcta'//'Save ejecutado correctamente'
                ];
            }
         }
         catch(\Exception $e){
            $result=[
                'success'=>0,
                'msg'=>'Ocurrio un error al crear una cotizacion',
                'data'=> $e->getMessage()//'Save ejecutado correctamente'
            ];

         }
       return $result;
    }
    public function update($request,$id){                           //utilizado para insert y update.
        try {
            $coti=Cotizacion::find($id);
            if ($coti){
                if ($request->descripcion){
                    $coti->descripcion=$request->descripcion;
                }
                if ($request->precio){
                    $coti->precio=$request->precio;
                }
                if ($request->estado){
                    $coti->estado_id=$request->estado;
                }
                $coti->save();
                $result=[
                    'success'=>1,
                    'msg'=>'Actualizacion correcta',
                    'data'=> 'Actualizacion correcta'
                ];
            }else{
                $result=[
                    'success'=>0,
                    'msg'=>'La cotizacion indicada no existe o no tiene permisos para editarlo',
                    'data'=> 'error'
                ];
            }
        } catch (Exception $e) {
            $result=[
                'success'=>0,
                'msg'=>'Ocurrio un error al crear una cotizacion',
                'data'=> $e->getMessage()//'Save ejecutado correctamente'
            ];
        }
        return $result;
    }

    public function eliminar($id){
        try{
            $cotizacion=Cotizacion::where('id', $id);
            if ($cotizacion){
                if ($cotizacion->delete()){
                    $result=[
                        'success'=>1,
                        'msg'=>'Cotizacion eliminada correctamente',
                        'data'=> 'Correcto'
                    ];
                }else{
                    $result=[
                        'success'=>0,
                        'msg'=>'No fue posible eliminar la cotizacion solicitada',
                        'data'=> 'error'
                    ];
                }
            }else{
                $result=[
                    'success'=>0,
                    'msg'=>'No fue encontrada la cotizacion que nos indica',
                    'data'=> 'error'
                ];
            }

        } catch (Exception $e) {
            $result=[
                'success'=>0,
                'msg'=>'Ocurrio un error al eliminar una cotizacion',
                'data'=> $e->getMessage()//'Save ejecutado correctamente'
            ];
        }
        return $result;
    }
}
