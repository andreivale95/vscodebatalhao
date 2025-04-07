@extends('layout/app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $tipobem_id->nome }}

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('tipobem.listar') }}"><i class=""></i> Tipos Bens</a></li>


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
                            <form action="{{ route('tipobem.atualizar', $tipobem_id->id) }}" method="post"
                                enctype="multipart/form-data">

                                @csrf

                                <div class="box box-primary">
                                    <div class="box-header">
                                        DADOS DO TIPO BEM

                                        <!-- Button trigger modal -->
                                    </div>

                                    <div class="box-body">


                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Nome:</label>
                                            <input type="text" class="form-control" placeholder="" name="nome" value="<?= htmlspecialchars($tipobem_id->nome); ?>" readonly>
                                        </div>

                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Descrição:</label>
                                            <input type="text" class="form-control" placeholder="" name="descricao" value="<?= htmlspecialchars($tipobem_id->descricao); ?>" readonly>
                                        </div>

                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Marca:</label>
                                            <input type="text" class="form-control" placeholder="" name="marca" value="<?= htmlspecialchars($tipobem_id->marca); ?>" readonly>
                                        </div>

                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Ano:</label>
                                            <input type="text" class="form-control" placeholder="" name="ano" value="<?= htmlspecialchars($tipobem_id->ano); ?>" readonly>
                                        </div>

                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Valor:</label>
                                            <input type="text" class="form-control" placeholder="" name="valor" value="<?= htmlspecialchars($tipobem_id->valor); ?>" readonly>
                                        </div>






                                    </div>
                                </div>
                                <div class="box-foote pull-right">
                                    <a href="{{ route('tipobem.listar') }}" class="btn btn-danger"><i
                                            class="fa fa-back"></i>
                                        Voltar</a>
                                    <a class="btn btn-warning" href="{{ route('tipobem.editar', $tipobem_id) }}"
                                        style="color: white">
                                        <i class="fa fa-edit"></i>Editar</a>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6">


                            <div class="box box-primary">
                                <div class="box-header">
                                    FOTO DO TIPO BEM
                                </div>


                                <img src="{{ asset('/privace/images/' . $tipobem_id->image) }}" alt="Tipo sem Foto"
                                    class="imagem-redimensionada">

                            </div>
                        </div>
                    </div>

                </div>


            </div>

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
