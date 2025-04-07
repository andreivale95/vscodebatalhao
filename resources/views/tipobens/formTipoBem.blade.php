@extends('layout/app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Cadastro de Tipo Bem

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('tipobem.listar') }}"><i class=""></i> Tipos Bens</a></li>
                <li></i> Cadastro de Modelo</li>

            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="panel" style="background-color: #3c8dbc;">
                <div class="panel-heading" style="color: white;">


                </div>
                <div class="panel-body" style="background-color: white;">
                    <form action="{{ route('tipobem.cadastrar') }}" method="post" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-6">

                                @csrf

                                <div class="box box-primary">
                                    <div class="box-header">
                                        DADOS DO TIPO BEM
                                    </div>
                                    <div class="box-body">

                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Nome:</label>
                                            <input type="text" class="form-control" placeholder="" name="nome"
                                                value="" required>
                                        </div>

                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Descrição:</label>
                                            <input type="text" class="form-control" placeholder="" name="descricao"
                                                value="" required>
                                        </div>

                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Marca:</label>
                                            <input type="text" class="form-control" placeholder="" name="marca"
                                                value="" required>
                                        </div>

                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Ano:</label>
                                            <input type="text" class="form-control" placeholder="" name="ano"
                                                value="" required>
                                        </div>
                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Valor:</label>
                                            <input type="text" class="form-control" placeholder="" name="valor"
                                                value="" required>
                                        </div>

                                    </div>
                                </div>
                                <div class="box-foote pull-right">
                                    <a href="{{ route('tipobem.listar') }}" class="btn btn-danger"><i
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

    <script>
        $(document).ready(function() {


        });
    </script>
@endsection
