<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use GuzzleHttp;
use function Termwind\ValueObjects\with;
class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            //return ("Error en los datos enviados a la api" . $validator->errors());
            $data = [
                'status'=>0,
                'token' => '0',
                'user' => '0',
                'msg'=>"Error en los datos enviados a la api" . $validator->errors(),
            ];
            return response()->json([$data]);
        }

        $input = $request->all();
        $input["password"] = bcrypt($request->get("password"));

        if (User::where('email', '=', $request["email"])->count() > 0) {
            $data = [
                'status'=>0,
                'token' => '0',
                'user' => '0',
                'msg'=>"El correo que intenta registrar ya existe",
            ];
            return response()->json([$data]);
        }

        $user = User::create($input);
        $token = $user->createToken("MyApp")->accessToken;

        $data = [
            'status'=>1,
            'token' => $token,
            'user' => $user
        ];
        return response()->json([$data]);
    }

}
