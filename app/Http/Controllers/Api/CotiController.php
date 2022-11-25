<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\Api\CotiService;
use App\Http\Requests\CotiRequest;
use App\Http\Resources\CotiResource;
use Illuminate\Http\Request;
//use App\Models\Cotizacion;
//use App\Models\user;
use DB;
use Exception;
use GuzzleHttp;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


class CotiController extends Controller
{
    private $cotiService;

    public function __construct()
    {
        $this->cotiService=new CotiService;
    }

    public function index(CotiRequest $request)
    {
        return new CotiResource($this->cotiService->index($request));
    }

    public function store(CotiRequest $request)
    {
        return new CotiResource($this->cotiService->store($request));
    }

    public function show(CotiRequest $request, $id)
    {
        return new CotiResource($this->cotiService->show($id));
    }

    public function update(CotiRequest $request, $id)
    {
        return new CotiResource($this->cotiService->update($request,$id));
    }

    public function destroy($id)
    {
        return new CotiResource($this->cotiService->Destroy($id));
    }

    public function cotiGeo(Request $request){
        $coti=Cotizacion::find($request->cotizacion_id);
        if (isset($coti->num_ip)){
            $response = Http::get('http://ipwho.is/' . $coti->num_ip);
            $datos=$response->object();
        }else{
           $datos='No fue detectado ip para esta solicitud';
        }
        $result=[
            'status'=>1,
            'msg'=>'Solicitud recibida',
            'data'=>$datos
        ];
        return $result;
    }
}
