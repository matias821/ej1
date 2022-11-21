<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Promocion;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class PromocionesController extends Controller
{
    public function index()
    {
        $promociones = DB::table("promociones")
            ->where("id_user", "=", auth()->user()->id)
            ->get();

        $result=[
            'status'=>1,
            'msg'=>'correcto',
            'data'=>$promociones
        ];
        return $result;
    }

    public function store(Request $request)
    {
        $promo = new Promocion;
        $promo->descripcion='promo1';
        $promo->precio='10.5';
        $promo->id_user=auth()->user()->id;
        $promo->save();

        $result=[
            'status'=>1,
            'msg'=>'correcto',
            'data'=>'Promo Añadida correctamente'
        ];
        return $result;
    }

    public function show(Promocion $promocion)
    {
        //
    }

    public function update(Request $request, Promocion $promocion)
    {
        //
    }

    public function destroy(Promocion $promocion)
    {
        $user=User::where('id', 14)->with('userdata')->get();
        return auth()->user()->name;
        //$promocion->delete();
        return 'listo';
        $result=[
            'status'=>1,
            'msg'=>'correcto',
            'data'=>$promocion
        ];
        return $result;
    }
    public function test(Promocion $promocion)
    {
        //$user = User::find(20);
        //Auth::login($user);
      //  return auth()->user();
        $result=[
            'status'=>1,
            'msg'=>'correcto',
            'data'=>'ghgg'
        ];
        return $result;
    }
}
