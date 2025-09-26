@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Detalhes da Movimentação</h1>
    </section>
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <tr><th>Data</th><td>{{ \Carbon\Carbon::parse($movimentacao->data_movimentacao)->format('d/m/Y H:i:s') }}</td></tr>
                    <tr><th>Produto</th><td>{{ $movimentacao->produto->nome ?? '-' }}</td></tr>
                    <tr><th>Tipo</th><td>{{ $movimentacao->tipo_movimentacao }}</td></tr>
                    <tr><th>Fornecedor</th><td>{{ $movimentacao->fornecedor }}</td></tr>
                    <tr><th>Nota Fiscal</th><td>{{ $movimentacao->nota_fiscal }}</td></tr>
                    <tr><th>Quantidade</th><td>{{ $movimentacao->quantidade }}</td></tr>
                    <tr><th>Valor Unitário</th><td>{{ number_format($movimentacao->valor_unitario, 2, ',', '.') }}</td></tr>
                    <tr><th>Valor Total</th><td>{{ number_format($movimentacao->valor_total, 2, ',', '.') }}</td></tr>
                    <tr><th>Unidade</th><td>{{ $movimentacao->unidade->nome ?? '-' }}</td></tr>
                    <tr><th>Origem</th><td>{{ $movimentacao->origem->nome ?? '-' }}</td></tr>
                    <tr><th>Destino</th><td>{{ $movimentacao->destino->nome ?? '-' }}</td></tr>
                    <tr><th>Responsável</th><td>{{ $movimentacao->responsavel }}</td></tr>
                    <tr><th>Militar</th><td>{{ $movimentacao->militar }}</td></tr>
                    <tr><th>Setor</th><td>{{ $movimentacao->setor }}</td></tr>
                    <tr><th>Proc. SEI</th><td>{{ $movimentacao->sei }}</td></tr>
                    <tr><th>Data TRP</th><td>{{ \Carbon\Carbon::parse($movimentacao->data_trp)->format('d/m/Y') }}</td></tr>
                    <tr><th>Fonte</th><td>{{ $movimentacao->fonte }}</td></tr>
                    <tr><th>Observação</th><td>{{ $movimentacao->observacao }}</td></tr>
                </table>
                <a href="{{ route('movimentacoes.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Voltar</a>
            </div>
        </div>
    </section>
</div>
@endsection
