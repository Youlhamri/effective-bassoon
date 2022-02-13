@extends('layouts.app')

@section('content')

@if ($data->isEmpty())
<div class="container" >
<div class="jumbotron">
    <h1 class="display-4">Hello, world!</h1>
    <p class="lead"></p>
    <hr class="my-4">
    <a class="btn btn-primary btn-lg" href="{{route('create')}}" role="button">Creér Un Témoignage</a>
  </div>
</div>
@else
<div class="container" style='text-align:center'>
    @if (Session::has('message'))
      <div class="alert alert-success" role="alert">
          {{Session::get('message')}}
      </div>
        
    @endif
    
  <table class="table table-bordered table-hover" style='width:70%'>
      <thead class="thead-dark">
        <tr>
                <th>title</th>
                <th>date</th>
                <th>statut</th>
                <th>Approbation</th>
        </tr>
          
      </thead>
      <tbody>
          @foreach ($data as $item)
          <tr>
            <td>{{$item->titre}}</td>
            <td>{{$item->created_at}}</td>
            <td>
                @if ($item->status=='approuve')
                <span class="badge badge-pill badge-success">{{$item->status}}</span></td>
                @else
                <span class="badge badge-pill badge-danger">{{$item->status}}</span></td>
                @endif
            <td>
                @if ($item->status=='attente')
                    <form action="{{route('status',$item->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="text" name="status" value="1" style="display:none">
                        <button type="submit" class="badge badge-pill badge-success" >approuvé</button>
                    </form>
                    <form action="{{route('destroy',$item->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="status" value="2" style="display:hidden">
                        <button type="submit" class="badge badge-pill badge-warning" >rejeter</button>
                    </form> 
                @endif
                <a href="{{route('edit',$item->id)}}" title="edit"><i class="bi bi-pencil-square"></i></a>

            </td>
         </tr>
          @endforeach
         
      </tbody>
  </table>
  <div style="text-align: center">{{$data->links()}}</div>
</div>
@endif
  
    <style>
        form{display: inline}
    </style>
@stop