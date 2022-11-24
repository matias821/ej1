<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class CotiRequest extends ApiFormRequest
{
    public function rules()
    {
        $method = $this->route()->getActionMethod();
        $arr["store"]=[
            'descripcion'              => 'required|string',
            'precio'                   => 'required',
            'profesional_id'           => 'required|numeric'
        ];
        $arr["index"]=[

        ];
        $arr["update"]=[
            'descripcion'                => 'required|string',
            'precio'                     => 'required|string',
            'estado'                     => 'required|string'
           // 'comment_id'        => 'required|numeric'    se envia por get en url
        ];
        $arr["destroy"]=[
            //'coti_id'           =>'required|numeric',
        ];
        $arr["show"]=[
           // 'coti_id'           =>'required|numeric',
        ];
        return $arr[$method];
    }
}
