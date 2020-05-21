<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        $jwtAuth = new \jwtAuth();

        $chectoken = $jwtAuth->checktoken($token);

        if ($chectoken ) {

            return $next($request);


        }else {

            $data = array(

                'code' => 400,
                'status' => 'error',
                'mensaje' => ' no esta identificado'

            );

            return response()->json($data, $data['code']);

        }



        
    }
}