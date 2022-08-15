@extends('layouts.app', ['page' => 'categorias', 'pageSlug' => 'categorias'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="card-title">Categoria: {{ $data->name }}</h2>
                    </div>

                    <div class="col-md-4 text-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">Voltar</a>
                    </div>
                    <div class="col-md-5">
                        <h3 class="card-title">Código: {{ $data->catId }}</h3>
                        <h3 class="card-title"><a href="{{ $data->permalink }}">Acessar</a></h3>
                        <h3 class="card-title">Total de Itens na Categoria: {{ $data->total_itens }}</h3>
                    </div>
                    <div class="col-md-6 text-center"><img src="{{ $data->picture}}" alt="imagem categoria" height="200" ></div>
                    <div class="col-md-12">
                        <h2 class="card-title">Sub-Categorias</h2>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="card-columns">

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
