<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
	public function index(){
		return view('welcome');
	}
	
	public function anyData(Request $request){
		$filtro = $request->get('filtro');
		
		if($filtro == 'todos')
			$usuarios = User::withTrashed()->select(['id', 'name', 'email', 'created_at','deleted_at']);
		
		if($filtro == 'activos')
			$usuarios = User::select(['id', 'name', 'email', 'created_at','deleted_at']);
		
		if($filtro == 'eliminados')
			$usuarios = User::onlyTrashed()->select(['id', 'name', 'email', 'created_at','deleted_at']);
		
		return DataTables::of($usuarios)
			->editColumn('deleted_at', function ($usuario) {
                
				if(is_null($usuario->deleted_at))
					$eliminado = '<button type="button" onclick="cambiar('.$usuario->id.')" class="btn btn-danger">Eliminar</button>';
				else
					$eliminado = '<button type="button" onclick="cambiar('.$usuario->id.')" class="btn btn-success">Activar</button>';
				
                return $eliminado;
               
            })
			->rawColumns(['deleted_at'])
			->make(true);
	}
	
	public function changeStatus($id){
		$user = User::withTrashed()->find($id);
		
		if(is_null($user->deleted_at))
			$user->delete();
		else
			$user->deleted_at = null; $user->save();
		
		$data = array(
			'code' => 200,
		);
		
		return json_encode($data);
	}
}
