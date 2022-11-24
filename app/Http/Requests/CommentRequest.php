<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class CommentRequest extends ApiFormRequest
{
    public function rules()
    {
        $method = $this->route()->getActionMethod();
        $arr["store"]=[
            'comment'           => 'required|string',
            'cotizacion_id'     => 'required|numeric'
        ];
        $arr["index"]=[

        ];
        $arr["update"]=[
            'comment'           => 'required|string',
           // 'comment_id'        => 'required|numeric'    se envia por get en url
        ];
        $arr["destroy"]=[
            'comment_id'           =>'required|numeric',
        ];
        $arr["show"]=[
            'comment_id'           =>'required|numeric',
        ];
        return $arr[$method];
    }
}
