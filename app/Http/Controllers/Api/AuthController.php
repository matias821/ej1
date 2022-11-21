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


    public function roleGet()
    {
       $id=auth()->user()->id;
       $role = User::find($id)->Roles()->orderBy('name')->first();

       $roleName='Role';
       if (isset($role->name)){
           $roleName=$role->name;
       }

       $data = [
        'status'=>1,
        'msg'=>'Informacion de permisos correcta',
        'js'=>'parent.document.getElementById("role").innerHTML="' . $roleName . '";',
        'datos'=> $role
        ];
        return $data;
    }

    public function roleProfesional()
    {
       $id=auth()->user()->id;
       $role = User::find($id)->Roles()->orderBy('name')->first();


        switch ($role->pivot->role_id){
            case 1:
                $msg="Datos enviados correctamente";
                $role->pivot->role_id=2;
                $role->pivot->save();
                break;
            case 2:
                $msg="El usuario ya es profesional";
                break;
            default:
                $msg="No es posible actualizar el nivel de usuario";
        }

       $data = [
        'status'=>1,
        'msg'=>$msg,
        'js'=>'parent.document.getElementById("role").innerHTML="Profesional";',
        'datos'=> $role
        ];
        return $data;
    }

    public function roleVisita()
    {
       $id=auth()->user()->id;
       $role = User::find($id)->Roles()->orderBy('name')->first();
       $status=0;

        switch ($role->pivot->role_id){
            case 1:
            $msg="El usuario ya tiene permisos de visita";
            break;
            case 2:
                $msg="Datos enviados correctamente";
                $role->pivot->role_id=1;
                $role->pivot->save();
                $status=1;
                break;
            default:
                $msg="No es posible actualizar el nivel de usuario";
        }

       $data = [
        'status'=>$status,
        'msg'=>$msg,
        'js'=>'parent.document.getElementById("role").innerHTML="Visita";',
        'datos'=> $role
        ];
        return $data;
    }

    public function info(Request $request){
        $result=[
            'status'=>1,
            'msg'=>'correcto',
            'data'=>'Conexion Correcta'
        ];
        return $result;
    }
    public function myId(Request $request){
        return auth()->user();
    }


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
    public function test(request $request)
    {

        $request->authenticate();



        $query = http_build_query(array(
            'client_id' => '5',
            'redirect_uri' => 'http://ejer1.local/callback.php',
            'response_type' => 'code',
            'scope' => '',
        ));





     // Nuevo cliente con un url base
$client = new GuzzleHttp\Client(['base_uri' => 'https://myapp.com/api/']);

        $response = $client->get('http://ej1.mecubro.local/oauth/authorize?'.$query);

        print_r($response);

        return 'hasta aca';
        exit;

        if (isset($_GET["code"])){
            $msg='La vinculacion fue correcta';
        // check if the response includes authorization_code
                if (isset($_REQUEST['code']) && $_REQUEST['code'])
                {
                    $ch = curl_init();
                    $url = 'http://ej1.mecubro.local/oauth/token';

                    $params = array(
                        'grant_type' => 'authorization_code',
                        'client_id' => '5',
                        'client_secret' => 'ZCA6vFJjLF3AheFeG45rLyhEAclavgGvnrWSrfju',
                        'redirect_uri' => 'http://ejer1.local/callback.php',
                        'code' => $_REQUEST['code']
                    );

                    curl_setopt($ch,CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                    $params_string = '';


                    if (is_array($params) && count($params))
                    {
                        foreach($params as $key=>$value) {
                            $params_string .= $key.'='.$value.'&';
                        }

                        rtrim($params_string, '&');

                        curl_setopt($ch,CURLOPT_POST, count($params));
                        curl_setopt($ch,CURLOPT_POSTFIELDS, $params_string);
                    }

                    $result = curl_exec($ch);
                    curl_close($ch);
                    $response = json_decode($result);
                    // check if the response includes access_token
                    if (isset($response->access_token) && $response->access_token)
                    {
                        // you would like to store the access_token in the session though...
                        $access_token = $response->access_token;
                        $refresh_token = $response->refresh_token;
                    }
                    else
                    {
                        // for some reason, the access_token was not available
                        // debugging goes here
                    }
                }

            $sql="UPDATE datos SET code='" . $_GET["code"] .  "', token='$access_token', refresh_token='$refresh_token' where id=1";
            $db->cargar_sql($sql);
            $db->ejecutar_sql();
        }}
}
