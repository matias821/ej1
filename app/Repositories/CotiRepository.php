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
        $coti->save();
        return true;
    }
    public function update($id, $request){                           //utilizado para insert y update.
        try {
            $coti=Cotizacion::find($id);
            $coti->descripcion=$request->descripcion;
            $coti->precio=$request->precio;
            $coti->estado=$request->estado;
            $coti->save();
            return true;
        } catch (Exception $e) {
            $msg='No fue posible actualizar la valoracion';
            return false;
        }
    }

    public function eliminar($id){
        return Cotizacion::where('id', $id)->delete();
    }
}
