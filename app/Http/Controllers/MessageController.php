<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use App\MessageModel;
use App\Helpers\jwtAuth;

class MessageController extends Controller
{
    //validacion de usuario 

    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['index', 'show']]);
    }


    public function index()
    {
        $message = MessageModel::all()->load('tag')->load('user');
        return response()->json([
            'code' => 200,
            'status' => "succsess",
            'Messege' => $message
        ], 200);
    }
    public function show($id)
    {
        $message = MessageModel::find($id)->load('tag');
        if (is_object($message)) {
            $data = [

                'code' => 200,
                'status' => 'success',
                'Message' => $message
            ];
        } else {

            $data = [
                'code' => 404,
                'status' => 'error',
                'Message' => "la entrada no existe"
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function store(Request $request)
    {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);


        if (!empty($params_array)) {
            $jwtauth = new jwtAuth();

            $token = $request->header('Authorization', null);
            $user = $jwtauth->checktoken($token, true);

            $validate = \Validator::make($params_array, [
                'title' => 'required',
                'content' => 'required',
                'tag_id' => 'required'
            ]);


            if ($validate->fails()) {

                $data = [
                    'code' => 400,
                    'status' => 'success',
                    'Message' => "no se guardo el mensaje faltan datos"


                ];
            } else {

                $message = new MessageModel();
                $message->user_id = $user->sub;
                $message->tag_id = $params->tag_id;
                $message->title = $params->title;
                $message->content = $params->content;
                $message->save();
                $data = [
                    'code' => 200,
                    'status' => 'succes',
                    'Message' => $message
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'Message' => "envia los datos correctamente"
            ];
        }

        return response()->json($data, $data['code']);
    }
}
