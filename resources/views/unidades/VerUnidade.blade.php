@extends('layout/app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $unidade_id->nome }}

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('unidades.listar') }}"><i class=""></i> Unidades</a></li>


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
                            <form action="{{ route('unidade.atualizar', $unidade_id->id) }}" method="post"
                                enctype="multipart/form-data">

                                @csrf

                                <div class="box box-primary">
                                    <div class="box-header">
                                        DADOS DA UNIDADE

                                        <!-- Button trigger modal -->
                                    </div>

                                    <div class="box-body">




                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="unidade">Unidade:</label>
                                            <input type="text" name="unidade" class="form-control"
                                                value="{{ $unidade_id->nome }}" readonly>
                                        </div>



                                    </div>
                                </div>
                                <div class="box-foote pull-right">
                                    <a href="{{ route('unidades.listar') }}" class="btn btn-danger"><i
                                            class="fa fa-back"></i>
                                        Voltar</a>
                                    <a class="btn btn-warning" href="{{ route('unidade.editar', $unidade_id) }}"
                                        style="color: white">
                                        <i class="fa fa-edit"></i>Editar</a>
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
