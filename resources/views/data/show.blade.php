@extends('layouts.app')

@section('content')
<div class="container" style='text-align: -webkit-center;'>
<div class="card" style="max-width:700px;">
    <div class="card-header">
    {{$data->titre}}
    </div>
    <!--width="220" height="100%"-->
    @if ($data->extension=='docx' || $data->extension=='doc')
        <div >
            <img src="/images/file.png" alt="..." style=" width: 20%;max-height:150px; ">
        </div>
    @else
        <div style="background-color:rgb(142, 163, 146);">
            <img src="/{{$data->doc}}" alt="..." style=" width: 90%;max-height:530px; " />
        </div>
    @endif
    

    <div class="card-body">
      <blockquote class="blockquote mb-0">
        <p>{{$data->message}}</p>
        <footer class="blockquote-footer">Date : <cite title="Source Title">{{$data->created_at}}</cite></footer>
      </blockquote>
    </div>
   
        @if ($data->extension=='docx' || $data->extension=='doc')
            <div class="card-footer">
                <form action="{{route('upload',$data->id)}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary" >  <i class="bi bi-arrow-down-circle-fill"></i> Telecharger</button> 
                </form> 
            </div>
        @endif
  
        <div class="card-footer">
            <a href="{{route('display')}}" class="btn btn-warning">Go Back</a>
        </div>
  </div>
</div>


@stop