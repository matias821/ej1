<?php
namespace App\Services\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cotizacion;
use DB;
use Exception;
use App\Repositories\CommentRepository;

class ResultService extends Controller
// Convierte todos los resultados en array con las caracteristicas elegidas
// Puedo elegir que mostrar
// Errores de Requests estan en ApiFormRequest!
{
    private $result;
    public function __construct()
    {
        $this->result=[
            'success'=>0,
            'msg'=>'',
            'meta_data'=>'',
            'errores'=>''
        ];
    }
    public function mostrar($datos){
        // Asiganaciones basicas
        if (isset($datos["success"]) && $datos["success"]==1){
            $this->result["success"]=1;
        }
        if ($this->result["success"]==0 && isset($datos) && $datos==true && !isset($datos["errores"])){
            $this->result["success"]=1;
        }
        if (isset($datos["msg"])){
            $this->result["msg"]=$datos["msg"];
        }
        if (isset($datos["data"])){
            $this->result["meta_data"]=$datos["data"];
        }
        if (isset($datos["errores"])){
            $this->result["errores"]=$datos["errores"];
        }
        //correcciones
        if ($this->result["success"]==1 and $this->result["msg"]==''){
            $this->result["msg"]='Solicitud realizada correctamente';
        }
        if (isset($datos) and !isset($datos["data"])){
            $this->result["meta_data"]=$datos;
        }

        // Si hay errores no mostrar meta_data para evitar mostrar errores que no es posible controlar
        if ( $this->result["success"]==0){
            $this->result["meta_data"]='';
        }
        return $this->result;
    }
   }
