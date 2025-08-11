@extends('layout/app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $categoria->nome }}

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('categorias.listar') }}"><i class=""></i> Categorias</a></li>


            </ol>
        </section>


        <!-- Main content -->
        <section class="content container-fluid">

            <div class="panel" style="background-color: #3c8dbc;">
                <div class="panel-heading" style="color: white;">


                </div>
                <div class="panel-body" style="background-color: white;">

                    <div class="row">

                        <div class="col-md-6">
                            <form action="{{ route('categoria.atualizar', $categoria->id) }}" method="post"
                                enctype="multipart/form-data">

                                @csrf

                                <div class="box box-primary">
                                    <div class="box-header">
                                        DADOS DA CATEGORIA

                                        <!-- Button trigger modal -->
                                    </div>

                                    <div class="box-body">




                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="categoria">Categoria:</label>
                                            <input type="text" name="nome" class="form-control"
                                                value="{{ $categoria->nome }}" >
                                        </div>











                                    </div>
                                </div>
                                <div class="box-foote pull-right">
                                    <a href="{{ route('categoria.ver', $categoria) }}" class="btn btn-danger"><i
                                            class="fa fa-close"></i>
                                        Cancelar</a>
                                    <button class="btn btn-success "><i class="fa fa-save"></i> Salvar</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

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

            <style>
                .imagem-redimensionada {
                    width: 600px;
                    /* Define a largura */
                    height: auto;
                    /* Mantém a proporção */
                }
            </style>



        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->



    <script>
        $(document).ready(function() {


        });
    </script>
@endsection
