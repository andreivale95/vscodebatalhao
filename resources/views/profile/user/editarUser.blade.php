@extends('layout/app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
         Dados do Usuário

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('us.editar', $user->cpf) }}"><i class=""></i> Editar</a></li>


        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="panel" style="background-color: #00a65a;">
            <div class="panel-heading" style="color: white;">
            {{$user->nome}}
            </div>
            <div class="panel-body" style="background-color: white;">
                <form action="{{ route('us.atualizar', $user->cpf) }}" method="post" class="row">
                    @csrf()

                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header">
                                DADOS DO USUÁRIO
                            </div>
                            <div class="panel-body">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Nome:</label>

                                    <input type="text" class="form-control" placeholder="" name="nome" value="{{$user->nome}}">

                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">CPF:</label>

                                    <input id="cpf" type="text" class="form-control" placeholder="" name="cpf" value="{{$user->cpf}}">

                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Telefone:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>

                                        <input id="telefone" type="text" class="form-control" placeholder="" name="telefone" value="{{$user->telefone}}" >

                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" id="email" name="email" type="email">Email:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div>

                                        <input type="text" class="form-control" placeholder="" name="email" value="{{$user->email}}" >

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header">
                                DADOS DE PERFIL
                            </div>
                            <div class="panel-body">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">PERFIL DE ACESSO:</label>



                                    <div class="input-group">

                                      <select name="regional" class="form-control">



                                        @foreach ($perfils as $perfil)
                                          <option value="{{ $perfil->id }}" {{ ( $perfil->id_perfil == $user->fk_perfil) ? 'selected' : '' }}> {{ $perfil->nome }} </option>
                                        @endforeach
                                       </select>
                                    </div>


                                </div>

                        </div>

                    </div>

                    <div class="box-footer">

                    </div>
                    <button type="submit" class="btn btn-primary">
                        Salvar
                    </button>

                </form>

            </div>

            <a href="{{ route('us.lista') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Voltar</a>

        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
