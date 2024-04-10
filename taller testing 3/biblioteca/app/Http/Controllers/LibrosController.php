<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Libros; 

class LibrosController extends Controller
{
    public function index(){
        $datos = DB::table('libros')->paginate(8);
        return view("welcome")->with("datos", $datos);
    }

    public function create(Request $request){
        try {
                if($request->hasFile('portada') && $request->file('portada')->isValid()) {
                    $imagen = $request->file('portada');
                    $nombre_imagen = time().'_'.$imagen->getClientOriginalName();
                    $imagen->move(public_path('portadas'), $nombre_imagen);
                } else {
                    $nombre_imagen = 'default.jpg'; 
                }
    
           
            $sql = DB::insert('insert into libros (nombre, descripcion, portada, autor) values (?, ?, ?, ?)', [
                $request->txtnombre,
                $request->txtdescripcion,
                $nombre_imagen, 
                $request->txtautor,
            ]);
            
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto","libro Registrado");
        } else {
            return back()->with("incorrecto","Error al registrar el libro");
        }
    }
    

    public function update(Request $request)
    {
        try {
            if($request->hasFile('portada') && $request->file('portada')->isValid()) {
                $imagen = $request->file('portada');
                $nombre_imagen = time().'_'.$imagen->getClientOriginalName();
                $imagen->move(public_path('portadas'), $nombre_imagen);
            } else {
                $nombre_imagen = $request->txtportada; 
            }
    
            $sql = DB::update('update libros set nombre=?, descripcion=?, portada=?, autor=? where id=?',
                [
                    $request->txtnombre,
                    $request->txtdescripcion,
                    $nombre_imagen, 
                    $request->txtautor,
                    $request->txtcodigo,
                ]);
                
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto","libro modificado");
        } else {
            return back()->with("incorrecto","Error al modificar el libro");
        }
    }
    
    public function delete($id)
    {
        try {
            $sql=DB::delete("delete from libros where id=$id");
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto","el libro se elimino exitosamente");
        } else {
            return back()->with("incorrecto","Error al eliminar el libro");
        }

    }

    public function buscar(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
    
        $resultados = libros::where('nombre', 'like', '%' . $searchTerm . '%')
                               ->orWhere('autor', 'like', '%' . $searchTerm . '%')
                               ->paginate(8);
    
        if ($resultados->isEmpty()) {
            return back()->with("correcto", "No se encontraron resultados para '$searchTerm'")->withInput();
        } else {
            return view('welcome')->with("datos", $resultados);
        }
    }
}