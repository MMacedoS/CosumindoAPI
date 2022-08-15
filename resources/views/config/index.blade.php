@extends('layouts.app', ['page' => 'Configuração', 'pageSlug' => 'Configuração'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="card-title">Instruções da API Mercado Livre</h4>
                    </div>

                    <div class="col-md-4 text-right">
                        <a href="{{ route('config.create') }}" class="btn btn-sm btn-primary">Adicionar Novo</a>
                    </div>

                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive-xl">
                    <table id="tree-table" class="table table-striped">
                        <thead class=" text-primary">
                            <th scope="col">ID</th>
                            <th scope="col">APPID</th>
                            <th scope="col">Url</th>
                            <th scope="col">SiteId</th>
                            <th scope="col">Autorização</th>
                            <th scope="col" class="text-right">Ação</th>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->appId }} </td>
                                <td>{{ $item->url }}</td>
                                <td>{{ $item->siteId }}</td>
                                <td>@if(is_null($item->authorization))

                                    @else
                                        <span class="success"><i class="tim-icons icon-check-2"></i></span>
                                    @endif
                                    <a href="{{route('authorization', $item->id)}}">Autorizar</a>
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <form action="{{ route('config.destroy', $item->id) }}" method="post"
                                                id="form-{{ $item->id }}">
                                                @csrf
                                                @method('delete')
                                               <a class="dropdown-item"
                                                    href="{{ route('config.show', $item->id ) }}">Visualizar</a>

                                                <a class="dropdown-item"
                                                    href="{{ route('config.edit', $item->id ) }}">Editar</a>

                                                <button type="button" class="dropdown-item btn-delete">
                                                    Excluir
                                                </button>

                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                             @empty
                            <tr>
                                <td colspan="20" style="text-align: center; font-size: 1.1em;">
                                    Nenhuma informação cadastrada.
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
