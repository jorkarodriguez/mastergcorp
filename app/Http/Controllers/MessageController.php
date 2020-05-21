<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use App\Message;
class MessageController extends Controller
{
    //validacion de usuario 

    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['index', 'show']]);
    }


    public function index(){
        $message= Message::all()->load('Tag');
        return response()->json([
            'code'=>200,
            'status'=>"succsess",
            'Messege'=>$message
        ],200);
    }
    
}
