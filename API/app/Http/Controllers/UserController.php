<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Input;
use Redirect;
use Log;
class UserController extends Controller
{
public function index() {
        $User = User::all() ->toArray();
        return response() ->json($User);
    }

    public function store(Request $request)
    {
        try{
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);
            return response()->json(['status'=>true, 'Muchas gracias'], 200);

        } catch (\Exception $e){
            Log::critical("No se ha podido añadir: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
            return response('Someting bad', 500 );
        }
    }


    public function show($id)
    {
        try{
            $User = User::find($id);

            if(!$User){
                return response()->json(['No existe...'], 404);
            }
            
            return response()->json($User, 200);

        } catch (\Exception $e){
            Log::critical("No se ha podido añadir: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
            return response('Someting bad', 500 );
        }
    }

     public function update(Request $request, $id)
    {
        try{
            $User = User::find($id);

            if(!$User){
                return response()->json(['No existe...'], 404);
            }
            
            $User->update($request->all());

            return response(array(
                'error' => false,
                'message' =>'User Modificado...',
               ),200);

        } catch (\Exception $e){
            Log::critical("No se ha podido añadir: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
            return response('Someting bad', 500 );
        }
    }


    public function destroy($id)
    {
        try{
            $User = User::find($id);

            if(!$User){
                return response()->json(['No existe...'], 404);
            }
            
            $User->delete();

            return response()->json('User eliminado..', 200);

        } catch (\Exception $e){
            Log::critical("No se ha podido añadir: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
            return response('Someting bad', 500 );
        }
    }
}
