<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CotiResource extends JsonResource
{
    private $res;

    public function __construct($res)
    {
        $this->res=$res;
    }


    public function toArray($request)
    {
        $success=0;$meta_data='';$errores='';$msg='';
        if (isset($this->res["success"]) && $this->res["success"]==1){ $success=1; }
        if (isset($this->res["data"])){$meta_data=$this->res["data"];}
        if (isset($this->res["msg"])){$msg=$this->res["msg"];}
        return [
            'success'       =>     $success,
            'meta_data'     =>     $meta_data,
            'msg'           =>     $msg,
            'errors'        =>     $errores
          ];
      //  return parent::toArray($request);
    }
}
