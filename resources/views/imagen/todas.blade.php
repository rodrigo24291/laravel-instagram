@extends('layouts.app')

@section('content')



<div class="container">

    @foreach($imagen as $imagenes)



    <div class="row justify-content-center py-3">
        <div class="col-md-6">
            <div class="card ">
                <div class="card-header">
                    @if($imagenes->user->image)
                    <img src="{{route('Devolver.Imagen',['fo'=>$imagenes->user->image])}} " class="perfil" />
                    @endif  {{$imagenes->user->name }} {{$imagenes->user->surname  }} 
                    <a href="{{route('dar.per',['fo'=>$imagenes->id])}}">
                        {{'@'.$imagenes->user->nick  }}</a> </div>

                <div class="card-body mancha">


                    <img src="{{route('image',['fo'=>$imagenes->image_path])}}" class="ie" />



                    <span>{{$imagenes->description}} </span> {{ \FormatTime::LongTimeFilter($imagenes->created_at) }}
                    <br>
                    @if(count($imagenes->likes)>0)
                    {{count($imagenes->likes)}}


                    @endif
<?php $corazon=false; ?>
                    @foreach($imagenes->likes as $ima)
                    @if($ima->user_id==auth::user()->id))


                    <?php $corazon=true; ?>
                    
                    
                    
                    @endif
                    @endforeach
                    @if($corazon)
                    <img src="{{asset('image/cora.ico')}}">
                    @else
                    <img src="{{asset('image/cora2.png')}}">
                    @endif
                    <a hrf="#" class="btn btn-warning ">Comentar ({{ count($imagenes->comments) }})</a>
                    <br>
                    @foreach($imagenes->comments as $comentario)
                    <span>{{$comentario->content}}</span><br>
                    @endforeach
                </div>



            </div>
        </div>

    </div>
    @endforeach    
    <div class="row justify-content-center py-3">
        <div class="col-md-6 ">  
            {{ $imagen->links()}}

        </div>
    </div>        
</div>
@endsection

