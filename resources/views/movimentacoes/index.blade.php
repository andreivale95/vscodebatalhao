@extends('layout.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Histórico de Movimentações</h1>
    </section>

    <section class="content container-fluid">
        <form method="GET" action="{{ route('movimentacoes.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-2">
                    <label>Produto</label>
                    <select name="produto" class="form-control select2">
                        <option value="">Todos</option>
                        @foreach ($produtos as $produto)
                        <option value="{{ $produto->id }}"
                            {{ request('produto') == $produto->id ? 'selected' : '' }}>
                            {{ $produto->nome }} -
                            {{ optional($produto->tamanho()->first())->tamanho ?? 'Tamanho Único' }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1">
                    <label>Tipo</label>
                    <select name="tipo" class="form-control">
                        <option value="">Todos</option>
                        <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="saida" {{ request('tipo') == 'saida' ? 'selected' : '' }}>Saída</option>
                        <option value="transferencia" {{ request('tipo') == 'transferencia' ? 'selected' : '' }}>
                            Transferência</option>
                        <option value="saida_kit" {{ request('tipo') == 'saida_kit' ? 'selected' : '' }}>Saída Kit
                        </option>
                        <option value="Saida_manual_multipla"
                            {{ request('tipo') == 'Saida_manual_multipla' ? 'selected' : '' }}>Saída Múltipla</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Data Inicial</label>
                    <input type="date" name="data_inicio" class="form-control" value="{{ request('data_inicio') }}">
                </div>

                <div class="col-md-2">
                    <label>Data Final</label>
                    <input type="date" name="data_fim" class="form-control" value="{{ request('data_fim') }}">
                </div>

                <div class="col-md-2">
                    <label>Militar</label>
                    <input type="text" name="militar" class="form-control" value="{{ request('militar') }}">
                </div>

                <div class="col-md-2">
                    <label>Fonte</label>
                    <input type="text" name="fonte" class="form-control" value="{{ request('fonte') }}">
                </div>

                <div class="col-md-2">
                    <label>Estoque</label>
                    <input type="text" name="estoque" class="form-control" value="{{ request('estoque') }}">
                </div>

                <div class="col-md-2">
                    <label>Proc. SEI</label>
                    <input type="text" name="sei" class="form-control" value="{{ request('sei') }}">
                </div>

                <div class="col-md-1">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
                </div>
            </div>
        </form>
        <br>

        <table class="table table-bordered table-hover">
            <thead class="bg-primary" style="color:white;">
                <tr>
                    <th>Data</th>
                    <th>Produto</th>
                    <th>Tipo</th>
                    <th>Fornecedor</th>
                    <th>N.F.</th>
                    <th>Qtd.</th>
                    <th>V. Unitário</th>
                    <th>V. Total</th>
                    <th>Unidade</th>
                    <th>Responsável</th>
                    <th>Estoque</th>
                    <th>Origem</th>
                    <th>Destino</th>
                    <th>Militar</th>
                    <th>Setor</th>
                    <th>Proc. SEI</th>
                    <th>D. TRP</th>
                    <th>Fonte</th>
                    <th>Observação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movimentacoes as $m)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($m->data_movimentacao)->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $m->produto->nome ?? '—' }} -
                        {{ optional($m->produto()->first()?->tamanho()->first())->tamanho ?? 'Tamanho Único' }}
                    </td>
                    <td>{{ $m->tipo_movimentacao }}</td>
                    <td>{{ $m->fornecedor }}</td>
                    <td>{{ $m->nota_fiscal }}</td>
                    <td>{{ $m->quantidade }}</td>
                    <td>{{ number_format($m->valor_unitario, 2, ',', '.') }}</td>
                    <td>{{ number_format($m->valor_total, 2, ',', '.') }}</td>
                    <td>{{ $m->produto->unidade }}</td>
                    <td>{{ $m->responsavel }}</td>
                    <td>{{ $m->unidade->nome }}</td>
                    <td>{{ $m->origem->nome ?? '-' }}</td>
                    <td>{{ $m->destino->nome ?? '-' }}</td>
                    <td>{{ $m->militar }}</td>
                    <td>{{ $m->setor }}</td>
                    <td>{{ $m->sei }}</td>
                    <td>{{ \Carbon\Carbon::parse($m->data_trp)->format('d/m/Y') }}</td>
                    <td>{{ $m->fonte }}</td>
                    <td>{{ $m->observacao }}</td>
                    <td>
                        <form action="{{ route('movimentacao.desfazer', $m->id) }}" method="POST" class="form-desfazer">
                            @csrf
                            @method('PUT')
                            <button type="button" class="btn btn-warning btn-sm btn-confirm-desfazer" data-id="{{ $m->id }}">Desfazer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Nenhuma movimentação encontrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $movimentacoes->links() }}
    </section>
</div>

<!-- Modal de confirmação -->
<div class="modal fade" id="modalConfirmDesfazer" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDesfazerLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalConfirmDesfazerLabel">Confirmar Desfazer Movimentação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Tem certeza que deseja desfazer esta movimentação? Esta ação não pode ser desfeita.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-warning" id="btnModalConfirmarDesfazer">Desfazer</button>
      </div>
    </div>
  </div>
</div>

<script>
    let formDesfazerSelecionado = null;
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Selecione um Produto",
            allowClear: true,
            width: '100%'
        });

        // Modal de confirmação para desfazer
        $('.btn-confirm-desfazer').on('click', function(e) {
            e.preventDefault();
            formDesfazerSelecionado = $(this).closest('form');
            $('#modalConfirmDesfazer').modal('show');
        });
        $('#btnModalConfirmarDesfazer').on('click', function() {
            if (formDesfazerSelecionado) {
                formDesfazerSelecionado.submit();
            }
        });
    });
</script>
@endsection