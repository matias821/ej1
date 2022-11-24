<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    private $res;

    public function __construct($res)
    {
        $this->res=$res;
    }


    public function toArray($request)
    {
        return [
            'id'      =>   $request->comment_id,
            'res'     => $this->res,
          ];
      //  return parent::toArray($request);
    }
}
