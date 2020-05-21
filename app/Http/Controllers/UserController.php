<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;


class UserController extends Controller
{

    public function Register(Request $request)
    {
        //recoger los datos del usuario 

        $json = $request->input('json', null);
        //decodificar datos
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        //limpiardatos

        $params_array = array_map('trim', $params_array);
        //validar datos

        $validate = \Validator::make($params_array, [
            'name' => 'required|alpha|unique:user',
            'password' => 'required|'
        ]);
        if (!empty($params_array) && (!empty($params))) {

            if ($validate->fails()) {
                // validacion ha fallado
                $data = array(
                    'status' => 'error',
                    'code' => 403,
                    'message' => 'el usuario no se ha creado porque esta duplicado',
                    'errors' => $validate->errors()
                );
            } else {
                // validacion pasada correctamente 
                //cifrar la contraseña
                $pwd = hash('sha256', $params->password);
                //comprovar si el usuario existe ya(para no duplicar)

                $user = new User();

                $user->name = $params_array['name'];
                $user->password = $pwd;




                //crear el usuario.

                $user->save();
                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'el usuario se ha creado correctamente'
                );
            }
        } else {
            $data = array(
                'status' => 'success',
                'code' => 404,
                'message' => 'los datos enviados no son correctos'
            );
        }
        return response()->json($data, $data['code']);
    }

    public function login(Request $request)
    {
        $jwtAuth = new \jwtAuth();
        //recibir el post 
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        $validate = \Validator::make($params_array, [
            'name' => 'required|alpha',
            'password' => 'required|'
        ]);
        if ($validate->fails()) {
            $signup = array(
                'status' => 'error',
                'code' => 403,
                'message' => 'el usuario no se ha podido identificar ',
                'errors' => $validate->errors()
            );
        } else {
            $pwd = hash('sha256', $params->password);
            $signup = $jwtAuth->signup($params->name, $pwd);
            if (!empty($params->getToken)) {

                $signup = $jwtAuth->signup($params->name, $pwd, true);
            }
        }

        return response()->json($signup, 200);
    }

    public function update(Request $request)
    {
        $token = $request->header('Authorization');
        $jwtAuth = new \jwtAuth();

        $chectoken = $jwtAuth->checktoken($token);

        //recojer los datos por post 
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if ($chectoken && !empty($params_array)) {


            //saccar usuario 
            $user = $jwtAuth->checktoken($token, true);


            //validar los datos
            $validate = \Validator::make($params_array, [
                'name' => 'required|alpha|unique:user' . $user->sub
            ]);


            //quitar los campos que no quiero actualizar 
            unset($params_array['user_id']);
            unset($params_array['passord']);
            unset($params_array['updated_at']);



            //acutalizar en el db 

            $user_update = User::where('id', $user->sub)->update($params_array);
            //devolver un array con el resultado

            $data = array(

                'code' => 200,
                'status' => 'success',
                'user' => $user,
                'Changes' => $params_array,
                
                'udate'=>$user_update
            );
        } else {

            $data = array(

                'code' => 400,
                'status' => 'error',
                'mensaje' => 'el usuario no esta identificado'

            );
        }

        return response()->json($data, $data['code']);
    }
}
