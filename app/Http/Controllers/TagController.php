<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Tag;
use Hamcrest\Type\IsObject;

class TagController extends Controller
{
    public function __construct()
    {

        $this->middleware('api.auth', ['except' => ['index', 'show']]);
    }
    public function index()
    {
        $tag = Tag::all();
        return response()->json(
            [
                'code' => 200,
                'status' => 'success',
                'tags' => $tag
            ]
        );
    }

    public function show($id)
    {

        $tag = Tag::find($id);
        if (is_object($tag)) {

            $data = [
                'code' => 200,
                'status' => "succes",
                'Tag' => $tag

            ];
        } else {

            $data = [
                'code' => 404,
                'status' => "error",
                'message' => "la categoria no existe"
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function store(Request $request)
    {
        //recoger datos por post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {






            //validad dartos 
            $validate = \Validator::make($params_array, [

                'name' => 'required'


            ]);

            //guardar la categoria
            if ($validate->fails()) {

                $data = [
                    'code' => 400,
                    'status' => "error",
                    'message' => "no se ha guardado la categorial"
                ];
            } else {

                $tag = new Tag();
                $tag->name = $params_array['name'];
                $tag->save();

                $data = [
                    'code' => 200,
                    'status' => "succses",
                    'tag' => $tag
                ];
            }
        } else {

            $data = [
                'code' => 403,
                'status' => "alert",
                'menssage' => "no has enviado ni una categoria"
            ];
        }

        //regresar el resultado

        return response()->json($data, $data['code']);
    }

    public function update($id, Request $request)
    {

        $json =  $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [
                'name' => 'required'
            ]);

            unset($params_array['id']);
            unset($params_array['create_at']);


            //update

            $tag = Tag::where('id', $id)->update($params_array);

            $data = [
                'code' => 200,
                'status' => "succes",
                'tag' => $params_array
            ];
        } else {

            $data = [
                'code' => 403,
                'status' => "alert",
                'menssage' => "no has enviado ni una categoria"
            ];
        }

        return response()->json($data, $data['code']);
    }
}
