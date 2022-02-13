@extends('layouts.app')

@section('content')
    <div class="container" style='text-align:center'>
        @if (Session::has('message'))
          <div class="alert alert-success" role="alert">
              {{Session::get('message')}}
          </div>
            
        @endif
        <h2>Toutes les Testimonials Approuvé </h2><br>
        @if ($data->isEmpty())
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">No Data to Display</h1>
              <p class="lead">No Data to Display</p>
            </div>
          </div>
        @else
            @foreach ($data as $item)
            <div class="card" style="max-width: 70%;margin-bottom:30px">
                <div class="row no-gutters">
                    @if ($item->extension=='docx' || $item->extension=='doc')
                    <div class="col-md-4">
                        <img src="images/file.png" alt="..." width="220" height="100%">
                    </div>
                    @else
                    <div class="col-md-4">
                        <img src="{{$item->doc}}" alt="..." width="220" height="100%">
                    </div>
                    @endif
                <div class="col-md-8" style="background-color:rgb(80, 77, 82);color:honeydew">
                    <div class="card-body">
                    <h5 class="card-title">{{$item->titre}}</h5>
                    <p class="card-text"> {{ Str::limit( $item->message, 20,'...') }}&nbsp;&nbsp;<a href="{{route('show',$item->id)}}" class="btn btn-primary">Afficher tout</a>
                    </p>

                    <p class="card-text"><small class="text-muted">Last updated  {{$item->updated_at }}</small></p>
                    </div>
                </div>
                </div>
            </div>
            @endforeach
        @endif
  
@stop