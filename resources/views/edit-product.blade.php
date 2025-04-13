@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
  <h1>Editar produto</h1>
  <div class="create-product">
    <form action="/edit-product/{{$product->id}}" method="POST">
      @csrf
      @method('PUT')
      <input type="text" name="name" value="{{$product->name}}">
      <input type="text" name="description" value="{{$product->description}}"></input>
      <input type="text" name="price" value="{{$product->price}}">
      <input type="number" name="quantity" value="{{$product->quantity}}">
      <button>Salvar mudanças</button>
    </form>
  </div>

  <a href="{{ url('/')}}" class="cancel">
    <button>Cancelar</button>
  </a>
@endsection