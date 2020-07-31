@extends('layouts.app')

@section('content')


@if($perfil)


<div class="container">





    <div class="row justify-content-center py-3">
        <div class="col-md-8">
            <div class="card ">
                <div class="card-header">
                    @if($perfil->user->image)
                    <img src="{{route('Devolver.Imagen',['fo'=>$perfil->user->image])}} " class="perfil" />
                    @endif

                    {{$perfil->user->name }} {{$perfil->user->surname  }} 

                    {{'@'.$perfil->user->nick  }} </span> {{ \FormatTime::LongTimeFilter($perfil->created_at) }}
                </div>

                <div class="card-body mancha">


                    <img src="{{route('image',['fo'=>$perfil->image_path])}}" class="ie" />



                    <span>{{$perfil->description}} </span> {{ \FormatTime::LongTimeFilter($perfil->created_at) }}
                    <br>

                    <img src="{{asset('image/cora.ico')}}">
                    @if($perfil->user_id==auth::user()->id)
                    <a class="btn btn-primary" href="{{route('gen',['id'=>$perfil->id])}}">Actualizar</a>
                    <a class="btn btn-danger " href="{{route('borrar.imagen',['borrar'=>$perfil->id])}}">Eliminar</a> 
                    @endif
                    <h2>Comentar ({{ count($perfil->comments) }})</h2>
                    <form method="POST"  action="{{route('insertar.comentario')}}">
                        @CSRF
                        <input type="hidden" name="id_imagen" value="{{$perfil->id}}"  >

                        <textarea name="contenido" placeholder="Inserta un comentario" class="form-control required"> </textarea>

                        <input class="btn btn-success" type="submit" value="enviar" > 
                    </form>
                    <br>

                    @foreach($perfil->comments as $comentario)
                    <span>
                        @if(auth::user()->image)
                        <img src="{{route('Devolver.Imagen',['fo'=>auth::user()->image])}} " class="perfil" />
                        @endif



                        {{'@'.auth::user()->nick  }}  {{ \FormatTime::LongTimeFilter($comentario->created_at) }}<br>
                        {{$comentario->content}}
                    </span>

                    <br>
                    @if(auth::user()->id==$comentario->user_id || $perfil->user_id==auth::user()->id)
                    <a class="btn btn-primary" href="{{route('delete.comment',['id'=>$comentario->id])}}">Eliminar</a>
                    @endif
                    <br>
                    @endforeach
                </div>
            </div>



        </div>
    </div>

</div>
@endif    


@endsection



