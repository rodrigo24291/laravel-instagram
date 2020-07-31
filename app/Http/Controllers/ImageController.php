<?php

namespace App\Http\Controllers;
use App\Image;
use App\User;
use App\Like;
use App\Comment;
use Illuminate\Http\Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;



class ImageController extends Controller
{
    function index(){
        
        return view('imagen.subir');
    }
    
    function subir(Request $request){
        $id=\auth::user()->id;
        $validacion=$request->validate([
            'imagen'=>'required|image',
            'descripcion'=>'string'
            
        ]);
        
        $imagen=$request->file('imagen');
        $descripcion=$request->input('descripcion');
        
        $imagen_nombre=time().$imagen->getClientOriginalName();
        
        $ima=storage::disk('imagen')->put($imagen_nombre,file::get($imagen));
        
        
        $imagenes=new image();
        $imagenes->user_id=$id;
        $imagenes->image_path=$imagen_nombre;
        $imagenes->description=$descripcion;
        $imagenes->save();
        
        
    }
    
       function enviar($file){
        
        $image= storage::disk('imagen')->get($file);
     return new Response($image, 200);   
    }
    
    function dada(){
        
        
      
       $images=Image::OrderBy('id','desc')->paginate(4);
        return view('imagen.todas',['imagen'=>$images]);
        
    }
    
    function dess($imagen){
        $perfil=storage::disk('user')->get($imagen);
        
        return new Response($perfil,200);
        
    }
    
    function perfil($imag){
        
        $per=Image::find($imag);
        
        return view('imagen.perfil',['perfil'=>$per]);
    }
    
     
    function borrarimagen($borrar){
      
        $imagen=Image::find($borrar);
        
        
        $coment=Comment::where('image_id',$imagen)->get();
        $likes=Like::where('image_id',$imagen)->get();
        if(count($coment)>=1){
            foreach($coment as $comentario)
       $comentario->delete();     
        }
        
        if(count($likes)>=1){
            foreach($likes as $like)
       $like->delete();     
        }
        storage::disk('imagen')->delete($imagen->image_path);
        
        $imagen->delete();
        return redirect()->route('index');
    }
    
    function actualizarimagen($id){
        
        $imagen=Image::find($id);
        return view('imagen.update',['imagen'=>$imagen]);
    }
    
    function mostrarimagen($id){
        $imagen=Image::find($id);
        $nombre=$imagen->image_path;
        $nombre_imagen=storage::disk('imagen')->get($nombre);
        
        return response($nombre_imagen,200);
    }
    
    
   
            
    function actualizado(Request $request){
        
        $id=$request->input('id');
        $description=$request->input('description');
        $img=$request->file('Imagen');
        
        
        $vali=$request->validate([
        'description'=>'string',
         'Imagen'=>'image'   
        ]);
        $nombre_imagen=time().$img->getClientOriginalName();
        storage::disk('imagen')->put($nombre_imagen,file::get($img));
        $imagen=Image::find($id);

        $imagen->image_path=$nombre_imagen;
        $imagen->description=$description;
        $imagen->update();
        
        return redirect()->route('gen',['id'=>$id]);
    }
    
    
    
    
}
