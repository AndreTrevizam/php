@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
  @auth
  
  <div class="create-product">
    <h2>Cadastre um produto</h2>
    <div>
      <form action="/create-product" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nome do produto">
        <input type="text" name="description" placeholder="Descrição"></input>
        <input type="number" name="price" placeholder="Preço do produto" step="0.01" min="0">
        <input type="number" name="quantity" placeholder="Quantidade do produto">
        <button>Cadastrar</button>
      </form>
    </div>
  </div>

  <div class="all-products">
    <h2>Todos os produtos</h2>
    @foreach ($products as $product)
    <div class="product-item">
      <h3>{{$product['name']}}</h3>
      <div>
        {{$product['description']}} /
        R$ {{$product['price']}} /
        Quantidade: {{$product['quantity']}}
      </div>
      <p>
        <a href="/edit-product/{{$product->id}}">Editar</a>
      </p>
      <form action="/delete-product/{{$product->id}}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
        @csrf
        @method('DELETE')
        <button>Excluir</button>
      </form>
    </div>
    @endforeach
  </div>

  <div class="create-sale">
    <h2>Cadastrar venda</h2>
    <div>
      <form action="/create-sale" method="POST">
        @csrf
        <div>
          <label for="product_id">Produto:</label>
          <select name="product_id" id="product_id" required>
              @foreach ($products as $product)
                  <option value="{{ $product->id }}">{{ $product->name }} (Estoque: {{ $product->quantity }})</option>
              @endforeach
          </select>
        </div>
    
        <div>
          <label for="quantity">Quantidade vendida:</label>
          <input type="number" name="quantity" min="1" required>
        </div>
    
        <button type="submit">Registrar Venda</button>
      </form>
    </div>
  </div>

  <div class="sales-table">
    <h2>Relatório de Vendas</h1>
      <table border="1" cellpadding="8" cellspacing="0">
        <thead>
          <tr>
            <th>Produto</th>
            <th>Quantidade Vendida</th>
            <th>Total (R$)</th>
          </tr>
        </thead>
        <tbody>
          @php $totalGeral = 0; @endphp
          @foreach ($sales as $sale)
            @php
              $preco = $sale->product->price;
              $subtotal = $sale->total_quantity * $preco;
              $totalGeral += $subtotal;
            @endphp
            <tr>
              <td>{{ $sale->product->name }}</td>
              <td>{{ $sale->total_quantity }}</td>
              <td>R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"><strong>Total Geral</strong></td>
            <td><strong>R$ {{ number_format($totalGeral, 2, ',', '.') }}</strong></td>
          </tr>
        </tfoot>
      </table>
  </div>

  {{-- Se o usuário estiver deslogado exibe isso --}}
  @else
  <div class="login-container">
    <div class="card">

      <div class="login">
        <h2>Login</h2>
        <div class="form-wrapper">
          <form action="/login" method="post">
            @csrf
            <input type="text" placeholder="E-mail" name="loginemail">
            <input type="password" placeholder="Senha" name="loginpassword">
            <button>Log in</button>
          </form>
        </div>
      </div>
      <div class="item-center">
        <div class="line"></div>
        Ou
        <div class="line"></div>
      </div>
      <div class="login">
        <h2>Registre-se</h2>
        <div class="form-wrapper">
          <form action="/register" method="post">
            @csrf
            <input type="text" placeholder="Nome" name="name">
            <input type="text" placeholder="E-mail" name="email">
            <input type="password" placeholder="Senha" name="password">
            <button>Cadastrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  @endauth
@endsection