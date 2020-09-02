<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Users;

class UsersController extends Controller
{
    public function getListarUsuarios(Request $request)
    {
       if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $criterio = $request->criterio;
        
        if($criterio == '' && $filtro != 'i' && $filtro != 'a'){
            $usuarios = Users::orderBy('id', 'desc')->get();            
        }        
        if($criterio == '' && ($filtro == 'i' || $filtro == 'a')){
            $usuarios = Users::where('state','=',$filtro)->orderBy('id' ,'desc')->get();    
        }
        if($filtro != '' && $criterio != ''){
            $usuarios = Users::where($filtro, 'like', '%'.$criterio.'%')->orderBy('id' ,'desc')->get();
        }

        return $usuarios;
    }

    public function setCambiarEstadoUsuario(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $usuario = Users::findOrFail($request->id);
        $usuario->state = ($usuario->state == 'A' ? 'I' : 'A');
        $usuario->save(); 
    }

    public function setRegistrarUsuario(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        $path = Storage::putFile('public/usuarios', $request->file('file'));
        $path = substr($path, 7);

        $usuario = new Users();
        $usuario->image = $path;
        $usuario->firstname = $request->firstname;
        $usuario->secondname = $request->secondname;
        $usuario->lastname = $request->lastname;
        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->state = 'A';
        $usuario->created_by = 1;
        $usuario->updated_by = 1;
        $usuario->created_at = now();
        $usuario->save();
    }

    public function getUsuarioEditar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $usuario = Users::findOrFail($request->id);
   
        return $usuario;
    }

    public function setEditarUsuario(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        $usuario = Users::findOrFail($request->id);
        $usuario->firstname = $request->firstname;
        $usuario->secondname = $request->secondname;
        $usuario->lastname = $request->lastname;
        $usuario->username = $request->username;
        $usuario->email = $request->email;        
        $usuario->created_by = 1;
        $usuario->updated_by = 1;
        $usuario->updated_at = now();
        $usuario->save();
    }
}
