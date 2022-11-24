<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Comentarios;
use App\Http\Controllers\Controller;

class CommentRepository extends Controller
{
    public function listar(){
        return Comentarios::where('profesional_id', auth()->user()->id)->get();
    }
    public function buscar($id){
        return Comentarios::where('id', $id);
    }
    public function guardar($request, $profesional_id){                           //utilizado para insert y update.
        $coti                   = new Comentarios;
        $coti->comentario       = $request->comment;
        $coti->cotizacion_id    = $request->cotizacion_id;
        $coti->profesional_id   = $profesional_id;
        $coti->save();
    }
    public function update($id, $comment_txt){                           //utilizado para insert y update.
        try {
           // $comment=Comentarios::where('id', $id);
            $comment=Comentarios::find($id);
            $comment->comentario=$comment_txt;
            $comment->save();
            return true;
        } catch (Exception $e) {
            $msg='No fue posible actualizar la valoracion';
            return false;
        }
    }

    public function eliminar($id){
        return Comentarios::where('id', $id)->delete();
    }
}
