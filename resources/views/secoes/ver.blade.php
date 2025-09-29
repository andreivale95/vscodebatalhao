@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Itens vinculados à Seção: {{ $secao->nome }}</h1>
        <a href="{{ route('secoes.index', $secao->fk_unidade) }}" class="btn btn-secondary">Voltar</a>
        <a href="{{ route('secoes.transferir_lote_form', ['unidade' => $secao->fk_unidade, 'secao' => $secao->id]) }}" class="btn btn-warning">Transferir Itens</a>
    </section>
    <section class="content container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="box box-primary">
            <div class="box-body">
                <form action="#" method="POST">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($itens as $item)
                            <tr>
                                <td>{{ $item->produto->nome }} ({{ $item->lote }})</td>
                                <td>{{ $item->quantidade }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center">Nenhum item vinculado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
