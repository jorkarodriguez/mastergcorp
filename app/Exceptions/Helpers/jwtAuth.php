<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;

class jwtAuth
{
    public $key;


    public function __construct()
    {
        $this->key='ramdonm key for user -5885259';
    }


    public function signup($name, $password,$getToken=null)
    {


        // buscar si existe el usuario con las credenciales 

        $user = User::where([
            'name' => $name,
            'password' => $password
        ])->first();


        // comprobar si son correctas 

        $signup = false;

        if (is_object($user)) {
            $signup = true;
        }
        //generar el token con los datos del usuario identificado
        if ($signup) {

            $token = array(
                'sub' => $user->id,
                'name' => $user->Name,
                'password' => $user->password,
                'iat' => time(),
                'exp' => time() + (7 * 24 * 60 * 60) //una semana
            );

            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decoded=JWT::decode($jwt,$this->key,['HS256']);

            //devolver los datos decodificados o el toke en funcion de un parametro
            if(is_null($getToken)){
                $data=$jwt;
                return $data;


            }
            else {
                $data=$decoded;
                return $data;
            }
        
        } else {

            $data = array(
                'status' => 'error',
                'messege' => 'Login incorrecto'

            );
        }

       



        return $data;
    }


    public function checktoken($jwt,$guetidentiti=false){
        $auth=false;
        try{
            $jwt = str_replace('"','',$jwt);
            $decoded=JWT::decode($jwt,$this->key,['HS256']);
        }catch(\UnexpectedValueException $e){
            $auth=false;
            
        }catch(\DomainException $e){
            $auth=false;
        }
        if(!empty($decoded)&& is_object($decoded)&& isset($decoded->sub)){
            
            $auth=true;


        }else {
            $auth=false;
        }

        if($guetidentiti){
            return $decoded;  
        }
        return $auth;
        





    }
}
