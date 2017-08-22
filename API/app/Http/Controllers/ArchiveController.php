<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Archive;
use Auth;
use Input;
use Redirect;
use Log;
class ArchiveController extends Controller
{
    /*
        metodo index del Archive
    */
    public function index() {
        $Archive = Archive::all() ->toArray();
        return response() ->json($Archive);
    }
    /*
        metodo store del Archive
    */
    public function store(Request $request)
    {
        try{
            Archive::create([
                'name'=>$request->input('name'),
                'date'=>$request->input('date'),
                'text'=> $this->encrypt_string($request->input('text')),
                'user_id'=> $request->input('user_id'),
            ]);
            return response()->json(['status'=>true, 'Muchas gracias'], 200);

        } catch (\Exception $e){
            Log::critical("No se ha podido añadir: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
            return response('Someting bad', 500 );
        }
    }
    /*
        metodo show del Archive
    */
    public function show($id)
    {
        try{
            $Archive=Archive::find($id);

            if(!$Archive){
                return response()->json(['No existe...'], 404);
            }
            $text = $Archive->text;
            $Archive->text = $this->decrypt_string($text);
            return response()->json($Archive, 200);

        } catch (\Exception $e){
            Log::critical("No se ha podido añadir: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
            return response('Someting bad', 500 );
        }
    }
    /*
        metodo profile del Archive
    */
    public function profile(Request $request)
    {
        $id = $request->only('user_id');
        $Archive = Archive::where('user_id', '=', $id)->get();
        try {

            return response()->json(($Archive), 200);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
    }
    /*
        metodo update del Archive
    */
    public function update(Request $request, $id)
    {
        try{
            $Archive = Archive::find($id);

            if(!$Archive){
                return response()->json(['No existe...'], 404);
            }
            
            $Archive->update($request->all());

            return response(array(
                'error' => false,
                'message' =>'User Modificado...',
               ),200);

        } catch (\Exception $e){
            Log::critical("No se ha podido añadir: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
            return response('Someting bad', 500 );
        }
    }
    /*
        metodo destroy del Archive
    */
    public function destroy($id)
    {
        try{
            $Archive = Archive::find($id);

            if(!$Archive){
                return response()->json(['No existe...'], 404);
            }
            
            $Archive->delete();

            return response()->json('Archive eliminado..', 200);

        } catch (\Exception $e){
            Log::critical("No se ha podido añadir: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
            return response('Someting bad', 500 );
        }
    }
    /*
        metodo de encriptar
    */
    function encrypt_string($input)
    {    
        $search = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',' ','1','2','3','4','5','6','7','8','9','0',',','.');
        $replace = array('☺','☻','♥','♦','♣','♠','•','◘','◙','♂','♀','♪','♫','☼','►','◄','↕','¶','§','▬','↨','↑','↓','→','←','∟','↔','▲','▼','ß','Ô','µ','þ','Þ','Û','±','¾','¹','³');  
        $input = str_ireplace($search,$replace,$input);
        return $input;
    }
    /*
        metodo de desencriptar
    */
    function decrypt_string($input)
    {
        $search = array('☺','☻','♥','♦','♣','♠','•','◘','◙','♂','♀','♪','♫','☼','►','◄','↕','¶','§','▬','↨','↑','↓','→','←','∟','↔','▲','▼','ß','Ô','µ','þ','Þ','Û','±','¾','¹','³'); 
        $replace = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',' ','1','2','3','4','5','6','7','8','9','0',',','.');
        $input = str_ireplace($search,$replace,$input);
        return $input;
    }
}
