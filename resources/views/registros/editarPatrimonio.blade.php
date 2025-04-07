@extends('layout/app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $patrimonio->tipobem()->first()->nome }} - {{ $patrimonio->numero }}

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('patrimonios.listar') }}"><i class=""></i> Patrimônios</a></li>
                <li><a href="{{ route('patrimonio.ver', $patrimonio->id) }}"><i class=""></i> {{ $patrimonio->numero }}</a></li>

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
                            <form action="{{ route('patrimonio.atualizar', $patrimonio->id) }}" method="post"
                                enctype="multipart/form-data">

                                @csrf

                                <div class="box box-primary">
                                    <div class="box-header">
                                        DADOS DO PATRIMÔNIO

                                        <!-- Button trigger modal -->
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Número:</label>
                                            <input type="text" class="form-control" placeholder="" name="numero"
                                                value="{{ $patrimonio->numero }}" >
                                        </div>
                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Ano:</label>
                                            <input type="text" class="form-control" placeholder="" name="ano"
                                                value="{{ $patrimonio->tipobem()->first()->ano }}"disabled>
                                        </div>
                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Fonte:</label>
                                            <select name="tipo" id="" class="form-control">
                                                @foreach ($fontes as $fonte)
                                                    <option value="{{ $patrimonio->fk_fonte }}"
                                                        {{ $patrimonio->fk_fonte == $fonte->id ? 'selected' : '' }}>
                                                        {{ $fonte->nome }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group has-feedback col-md-6">

                                            <label class="control-label" for="">Tipo Bem:</label>
                                            <select name="tipobem" id="" class="form-control" >
                                                @foreach ($tipobens as $tipobem)
                                                    <option value="{{ $tipobem->id }}"
                                                        {{ $patrimonio->fk_tipobem == $tipobem->id ? 'selected' : '' }}>
                                                        {{ $tipobem->nome }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group has-feedback col-md-6">

                                            <label class="control-label" for="">Unidade:</label>
                                            <select name="unidade" id="" class="form-control" >
                                                @foreach ($unidades as $unidade)
                                                    <option value="{{ $unidade->id }}"
                                                        {{ $patrimonio->unidade == $unidade->id ? 'selected' : '' }}>
                                                        {{ $unidade->nome }}</option>
                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="form-group has-feedback col-md-6">
                                            <label class="control-label" for="">Condição:</label>
                                            <select name="condicao" id="" class="form-control">
                                                @foreach ($condicoes as $condicao)
                                                    <option value="{{ $patrimonio->fk_condicao }}"
                                                        {{ $patrimonio->fk_condicao == $condicao->id ? 'selected' : '' }}>
                                                        {{ $condicao->condicao }}</option>
                                                @endforeach

                                            </select>
                                        </div>





                                    </div>
                                </div>
                                <div class="box-foote pull-right">
                                    <a href="{{ route('patrimonio.ver', $patrimonio->id) }}" class="btn btn-danger"><i
                                            class="fa fa-close"></i>
                                        Cancelar</a>
                                    <button class="btn btn-success "><i class="fa fa-save"></i> Salvar</button>
                                </div>
                            </form>
                        </div>

                    </div>
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
