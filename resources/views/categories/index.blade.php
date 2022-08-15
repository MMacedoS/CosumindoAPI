@extends('layouts.app', ['page' => 'categorias', 'pageSlug' => 'categorias'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="card-title">Categorias do Mercado Livre</h2>
                    </div>

                    <div class="col-md-4 text-right">
                        <a href="{{ route('atualizaCateg') }}" class="btn btn-sm btn-primary">Sincronizar com API</a>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="card-columns">
                    @forelse($data as $item)
                        <a href="{{ route('categoria.filhos', $item->catId )}}">
                            <div class="card bg-success">
                                <div class="card-body text-center">
                                    <img src="{{ $item->picture }}" alt="" height="50" srcset="">
                                    <h4 class="card-text text-dark">{{ $item->name }}</h4>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p>Não foram encontradas categorias no banco de dados local</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
