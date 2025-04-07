@include('alert')
@extends('layout/app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Setores de Atividade Técnica

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('us.lista') }}"><i class=""></i> Usuários</a></li>
            <li><a href="{{ route('st.form') }}"><i class=""></i> Formulário</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="panel panel-primary">
            <div class="panel-heading">
                Formulário de Cadastro
            </div>
            <div class="panel-body">
                <form action="{{ route('us.criar') }}" method="post" class="row">
                    @csrf()
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header">
                               CADASTRO USUÁRIO INTERNO
                            </div>
                            <div class="panel-body">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Nome:</label>

                                    <input type="text" class="form-control" placeholder="" name="nome" >

                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Sobrenome:</label>

                                    <input type="text" class="form-control" placeholder="" name="sobrenome" >

                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">CPF:</label>

                                    <input id="cpf" type="text" class="form-control" placeholder="" name="cpf" >

                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Telefone:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>

                                        <input id="telefone" type="text" class="form-control" placeholder="" name="telefone">

                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Email:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div>

                                        <input type="text" class="form-control" placeholder="" name="email" >

                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Perfil de Acesso:</label>
                                    <div class="input-group">

                                        <select name="fk_perfil" class="form-control">



                                          @foreach ($perfils as $perfil)
                                            <option  value="{{ $perfil->id_perfil }}"> {{ $perfil->nome }} </option>
                                          @endforeach
                                         </select>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header">
                                SEGURANÇA
                            </div>
                            <div class="panel-body">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">SENHA:</label>

                                    <input type="password" class="form-control"  data-validate="Password is required" id="password" placeholder="" name="password" >

                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">REPITA A SENHA:</label>

                                    <input type="password" class="form-control"  data-validate="Password is required" id="confirm_password" placeholder="" name="confirm_password" >

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
                        <a href="{{ route('st.lista') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Voltar</a>
                    </div>

                </form>
            </div>

        </div>
        <script>


        var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Senhas diferentes!");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;</script>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


@endsection
