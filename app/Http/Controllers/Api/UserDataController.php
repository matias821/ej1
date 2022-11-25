<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserData;
use App\Models\User;
use DB;
use Exception;
use App\Services\Api\UserDataService;
use App\Http\Resources\UserDataResource;
use App\Services\Api\ResultService;
use App\Http\Requests\UserDataRequest;

class UserDataController extends Controller
{
    public function __construct()
    {
        $this->userDataService=new UserDataService();
        $this->resultService=new ResultService;
    }

    function userInfo(){
        return new UserDataResource($this->resultService->mostrar($this->userDataService->userInfo()));
    }

    function userAvanzada(){
        return new UserDataResource($this->resultService->mostrar($this->userDataService->userAvanzado()));
    }

    function userFoto(){
        return new UserDataResource($this->resultService->mostrar($this->userDataService->userFoto()));
    }

    function userActivity(){
        return new UserDataResource($this->resultService->mostrar($this->userDataService->userActivity()));
    }

    function userActivityAct(UserDataRequest $request){
        return new UserDataResource($this->resultService->mostrar($this->userDataService->userActivityAct($request)));
    }

    function userNameAct(Request $request){
        return new UserDataResource($this->resultService->mostrar($this->userDataService->userNameAct($request)));
    }
    function userFotoAct(Request $request){
        return new UserDataResource($this->resultService->mostrar($this->userDataService->userFotoAct($request)));
    }

    function profesionalesListar(){
          return new UserDataResource($this->resultService->mostrar($this->userDataService->profesionalesListar()));
    }
}
