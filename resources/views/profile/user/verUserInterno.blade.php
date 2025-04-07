@extends('layout/app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Usuário Interno

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('usi.ver', $user->cpf) }}"><i class=""></i> Usuários</a></li>

        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="panel" style="background-color: #00a65a;">
            <div class="panel-heading" style="color: white;">
                {{$user->nome}}
            </div>
            <div class="panel-body" style="background-color: white;">
                <form action="" method="" class="row">
                    @csrf()
                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header">
                                DADOS DO USUÁRIO
                            </div>
                            <div class="panel-body">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Nome:</label>

                                    <input type="text" class="form-control" placeholder="" name="nome" value="{{$user->nome}}" disabled>

                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Sobrenome:</label>

                                    <input type="text" class="form-control" placeholder="" name="sobrenome" value="{{$user->sobrenome}}" disabled>

                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">CPF:</label>

                                    <input id="cpf" type="text" class="form-control" placeholder="" name="cpf" value="{{$user->cpf}}" disabled>

                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Telefone:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>

                                        <input id="telefone" type="text" class="form-control" placeholder="" name="telefone" value="{{$user->telefone}}" disabled>

                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Email:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div>

                                        <input type="text" class="form-control" placeholder="" name="email" value="{{$user->email}}" disabled>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header">
                                SEGURANÇA
                            </div>
                            <div class="panel-body">

                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">PERFIL DE ACESSO:</label>

                                    <input type="text" class="form-control" id="perfil" placeholder="" name="perfil" value="{{$user->perfil()->get()->first()->nome}}" disabled>

                                </div>

                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">UNIDADE DE LOTAÇÃO:</label>

                                    <input type="text" class="form-control" id="unidade" placeholder="" name="unidade" value="{{$user->unidade()->get()->first()->nome}}" disabled>

                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">STATUS:</label>

                                    @if ($user->status == 's')
                                    <input type="text" class="form-control" value="Ativo" disabled>
                                    @else
                                    <input type="text" class="form-control" value="Inativo" disabled>

                                    @endif

                                </div>


                            </div>

                        </div>

                        <div class="box-footer">

                        </div>

                </form>

            </div>
            <a href="{{ route('usi.listar') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Voltar</a>
            <a href="{{ route('usi.editar', $user->cpf) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Editar</a>

        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
