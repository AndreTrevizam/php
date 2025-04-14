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
    <h2>Relatório de Vendas</h2>
    
    @if($groupedSales->isEmpty())
        <div class="alert alert-info">Nenhuma venda registrada.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Produto</th>
                    <th class="text-right">Preço Unitário</th>
                    <th class="text-right">Qtd. Total Vendida</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupedSales as $sale)
                    <tr>
                        <td>{{ $sale['product']->name ?? 'Produto não encontrado' }}</td>
                        <td class="text-right">R$ {{ number_format($sale['unit_price'], 2, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($sale['total_quantity'], 0, ',', '.') }}</td>
                        <td class="text-right">R$ {{ number_format($sale['total_value'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-primary">
                    <th colspan="2">Totais</th>
                    <th class="text-right">{{ number_format($totalQuantidade, 0, ',', '.') }}</th>
                    <th class="text-right">R$ {{ number_format($totalGeral, 2, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    @endif
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