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
        return [
            'id'      =>   $request->coti_id,
            'res'     => $this->res,
          ];
      //  return parent::toArray($request);
    }
}
