@extends('layout/app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Cadastro de Kit
                <small></small>

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('estoque.listar') }}"><i class=""></i> Estoque</a></li>
                <li></i> Cadastro de Kit</li>

            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="panel" style="background-color: #3c8dbc;">
                <div class="panel-heading" style="color: white;">


                </div>
                <div class="panel-body" style="background-color: white;">
                    <form action="{{ route('kits.salvar') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="unidade">Unidade de Origem:</label>
                            <select name="unidade" id="unidade" class="form-control" required>
                                <option value="">Selecione a unidade</option>
                                @foreach ($unidades as $unidade)
                                    <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nome">Nome do Kit:</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Selecionar Produtos:</label>
                            <select id="produto-select" class="form-control">
                                <option value="">Selecione um produto</option>
                                <!-- Produtos serão carregados via AJAX -->
                            </select>
                            <button type="button" id="adicionar-produto" class="btn btn-success mt-2">Adicionar
                                Produto</button>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="lista-produtos">
                                <!-- Produtos adicionados aparecerão aqui -->
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Criar Kit</button>
                    </form>


                </div>

            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <script>
        $(document).ready(function() {});


        document.getElementById('valor').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = (parseInt(value, 10) / 100).toLocaleString('pt-BR', {
                minimumFractionDigits: 2
            });
            e.target.value = value !== "NaN" ? value : "";
        });
    </script>
    <script>
        document.getElementById('unidade').addEventListener('change', function() {
            let unidadeId = this.value;
            let produtoSelect = document.getElementById('produto-select');

            produtoSelect.innerHTML = '<option value="">Carregando...</option>';

            fetch(`/api/produtos/unidade/${unidadeId}`)
                .then(response => response.json())
                .then(data => {
                    produtoSelect.innerHTML = '<option value="">Selecione um produto</option>';
                    data.forEach(produto => {
                        let option = document.createElement('option');
                        option.value = produto.id;
                        option.textContent = `${produto.nome} (Qtd: ${produto.quantidade})`;
                        produtoSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erro ao buscar produtos:', error));
        });

        // Adicionar Produto à Lista
        document.getElementById('adicionar-produto').addEventListener('click', function() {
            let produtoSelect = document.getElementById('produto-select');
            let produtoId = produtoSelect.value;
            let produtoNome = produtoSelect.options[produtoSelect.selectedIndex].text;

            if (!produtoId) return alert('Selecione um produto!');

            let lista = document.getElementById('lista-produtos');

            // Verifica se já existe o produto na lista
            if (document.querySelector(`tr[data-id="${produtoId}"]`)) {
                return alert('Este produto já foi adicionado!');
            }

            let row = document.createElement('tr');
            row.setAttribute('data-id', produtoId);
            row.innerHTML = `
            <td>${produtoNome} <input type="hidden" name="produtos[]" value="${produtoId}"></td>
            <td><input type="number" name="quantidades[]" value="1" min="1" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger btn-remover">Remover</button></td>
        `;

            lista.appendChild(row);

            // Resetar o select
            produtoSelect.value = "";
        });

        // Remover Produto da Lista
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-remover')) {
                e.target.closest('tr').remove();
            }
        });
    </script>
@endsection
