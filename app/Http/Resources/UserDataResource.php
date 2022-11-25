<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDataResource extends JsonResource
{
    private $res;

    public function __construct($res)
    {
        $this->res=$res;
    }


    public function toArray($request)
    {
        $success='';$meta_data='';$msg='';$errores='';
        if (isset($this->res["success"])){
            $success=$this->res["success"];
        }
        if (isset( $this->res["meta_data"])){
            $meta_data=$this->res["meta_data"];
        }
        if (isset($this->res["msg"])){
            $msg=$this->res["msg"];
        }
        if (isset($this->res["errores"])){
            $errores=$this->res["errores"];
        }
        return [
            'success'       =>      $success,
            'meta_data'     =>      $meta_data,
            'msg'           =>      $msg,
            'errors'        =>      $errores,
          ];
      //  return parent::toArray($request);
    }
}
