@extends('layout/app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Cadastro de categoria

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('categorias.listar') }}"><i class=""></i> Categorias</a></li>
                <li></i> Cadastro de Categoria</li>

            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="panel" style="background-color: #3c8dbc;">
                <div class="panel-heading" style="color: white;">


                </div>
                <div class="panel-body" style="background-color: white;">
                    <form action="{{ route('categoria.cadastrar') }}" method="post" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-6">

                                @csrf

                                <div class="box box-primary">
                                    <div class="box-header">
                                        CADASTRAR CATEGORIA
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Categoria:</label>
                                            <input type="text" class="form-control" placeholder="" name="nome"
                                                value="" required>
                                        </div>

                                    </div>
                                </div>
                                <div class="box-foote pull-right">
                                    <a href="{{ route('categorias.listar') }}" class="btn btn-danger"><i
                                            class="fa fa-close"></i>
                                        Cancelar</a>
                                    <button class="btn btn-success"><i class="fa fa-save"></i> Cadastrar</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/inputmask.min.js"></script>

    <script>
        // Adiciona a máscara ao campo
        Inputmask({
            alias: "currency",
            prefix: "R$ ",
            groupSeparator: ".",
            radixPoint: ",",
            autoGroup: true,
            digits: 2,
            digitsOptional: false,
            clearMaskOnLostFocus: false
        }).mask(".money-mask");
    </script>

    <script>
        $(document).ready(function() {


        });
    </script>

    <script>
        document.getElementById('tipo').addEventListener('change', function() {
            const tipoId = this.value;
            const modelos = document.querySelectorAll('#modelo option');

            modelos.forEach(option => {
                if (option.dataset.tipo === tipoId || option.value === "") {

                    option.style.display = 'block'; // Mostra as opções correspondentes
                } else {
                    option.style.display = 'none'; // Esconde as opções que não correspondem
                }
            });

            // Resetar a seleção do modelo
            document.getElementById('modelo').value = "";
        });
    </script>
@endsection
