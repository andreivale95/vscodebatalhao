@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Itens vinculados à Seção: {{ $secao->nome }}</h1>
        <a href="{{ route('secoes.index', $secao->fk_unidade) }}" class="btn btn-secondary">Voltar</a>
    </section>
    <section class="content container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="box box-primary">
            <div class="box-body">
                <form action="{{ route('secoes.transferir', ['unidade' => $secao->fk_unidade, 'secao' => $secao->id]) }}" method="POST">
                    @csrf
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Selecionar</th>
                                <th>Item</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($itens as $item)
                            <tr>
                                <td><input type="checkbox" name="item_id[]" value="{{ $item->id }}"></td>
                                <td>{{ $item->produto->nome }} ({{ $item->lote }})</td>
                                <td>{{ $item->quantidade }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Nenhum item vinculado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="form-group">
                        <label for="nova_secao">Transferir selecionados para:</label>
                        <select name="nova_secao" id="nova_secao" class="form-control" required>
                            <option value="">Selecione a seção de destino</option>
                            @foreach($outrasSecoes as $s)
                                <option value="{{ $s->id }}">{{ $s->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning">Transferir</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
