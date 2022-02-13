@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('message'))
          <div class="alert alert-success" role="alert">
              {{Session::get('message')}}
          </div>
            
        @endif
        <form action="{{route('update',$data->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="titre">TITRE <span style="color: red">*<span></label>
                <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{$data->titre}}">
                @error('titre')
                   <small class="form-text text-muted alert alert-danger">{{$message}}</small>
                @enderror
           
            </div>

              
            <div class="form-group">
                <label for="file">IMAGE</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">

                @error('image')
                <div class="alert alert-danger">  <small class="form-text text-muted">{{$message}}</small></div>
                @enderror
            </div>

            <div class="form-group">
                <label for="message">MESSAGE <span style="color: red">*<span></label>
                <textarea  class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="8" >{{$data->message}}</textarea>
             
                @error('message')
                <div class="alert alert-danger">  <small class="form-text text-muted">{{$message}}</small></div>
                @enderror
            </div>

            <div class="form-group">
                <input type="submit" value="UPDATE OLD TESTMONIAL" class="btn btn-outline-warning">
            </div>

        </form>
        
        <div class="card-footer">
            <a href="{{route('admin')}}" class="btn btn-warning">Go Back</a>
        </div>
    </div>
@stop