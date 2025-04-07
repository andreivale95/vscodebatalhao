@extends('layout/app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-user"></i>
                Minha Conta

            </h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="modal modal-danger fade" id="modal-senha" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" method="POST">

                            <div class="modal-header bg-red">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">
                                    <center><i class="fa fa-warning"></i> ATENÇÃO <i class="fa fa-warning"></i></center>
                                </h4>
                            </div>
                            <div class="modal-body">
                                Digite a senha para as alterações: <br />
                                <div class="form-group has-feedback">
                                    <label class="control-label" id="password" name="password" type="password">SENHA
                                        ATUAL:</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </div>


                                        <input type="password" class="form-control" name="password" id="senha-atual">

                                    </div>
                                </div>
                                @csrf()
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Fechar</button>
                                <button id="btn_salvar" type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                    Confirmar</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>

            <div class="panel" style="background-color: #f39c12;">
                <div class="panel-heading" style="color: white;">
                    {{ Auth::user()->nome }} {{ Auth::user()->sobrenome }}<br>

                </div>
                <div class="panel-body" style="background-color: white;">
                    <form action="{{ route('profile.update', Auth::user()->cpf) }}" method="post" class="row"
                        id="form_principal" enctype="multipart/form-data">
                        @csrf()

                        <div class="col-md-6">
                            <div class="box box-warning">
                                <div class="box-header">
                                    DADOS DA CONTA
                                </div>
                                <div class="col-md-5">
                                    <div class="text-center">

                                        <img id="blah" src="{{ asset('/privace/images/' . Auth::user()->image) }}"
                                            alt="your image" class="avatar img-circle img-thumbnail" alt="avatar">
                                        <h6>Trocar Foto de Perfil</h6>


                                        <input accept="image/*" name="image" class="form-control" type='file'
                                            id="imgInp" />
                                    </div>
                                </div>


                                <div class="panel-body col-md-5">
                                    <div class="form-group has-feedback">
                                        <label class="control-label" for="">Nome:</label>

                                        <input type="text" class="form-control" style="width: 300px" name="nome"
                                            value="{{ $user->nome }}">

                                    </div>
                                    <div class="form-group has-feedback">
                                        <label class="control-label" for="">Sobrenome:</label>

                                        <input type="text" class="form-control" style="width: 300px" name="sobrenome"
                                            value="{{ $user->sobrenome }}">

                                    </div>
                                    <div class="form-group has-feedback">
                                        <label class="control-label" for="">CPF:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-indent"></i>
                                            </div>


                                            <input id="cpf" type="text" class="form-control" placeholder=""
                                                name="cpf" value="{{ $user->cpf }}" disabled>
                                        </div>

                                    </div>
                                    <div class="form-group has-feedback">
                                        <label class="control-label" for="">Telefone:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>

                                            <input id="telefone" type="text" class="form-control" placeholder=""
                                                name="telefone" value="{{ $user->telefone }}">

                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label class="control-label" id="email" name="email"
                                            type="email">Email:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                            </div>

                                            <input type="text" class="form-control" placeholder="" name="email"
                                                value="{{ $user->email }}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box box-warning">
                                <div class="box-header">
                                    SEGURANÇA
                                </div>
                                <div class="panel-body">


                                    <div class="form-group has-feedback">

                                        <label class="control-label" for="">PERFIL DE ACESSO:</label>

                                        <select name="perfil" class="form-control"disabled>

                                            @foreach ($perfis as $perfil)
                                                <option value="{{ $perfil->id_perfil }}"
                                                    {{ $perfil->id_perfil == $user->fk_perfil ? 'selected' : '' }}
                                                    disabled> {{ $perfil->nome }} </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="form-group has-feedback">

                                            <label class="control-label" for="">STATUS:</label>
                                            <select name="status" class="form-control" disabled>

                                                @if ($perfil->status == 's')
                                                    <option value="s" selected>Ativo</option>
                                                    <option value="n">Inativo</option>
                                                @else
                                                    <option value="s">Ativo</option>
                                                    <option value="n" selected>Inativo</option>
                                                @endif
                                            </select>


                                    </div>



                                    <div class="form-group has-feedback">
                                        <label class="control-label" id="password_new" name="password_new"
                                            type="password">REDEFINIR SENHA:</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-lock"></i>
                                            </div>


                                            <input type="password" class="form-control" placeholder="Nova Senha"
                                                name="password_new">

                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="password" id="senha-hidden">




                                </div>


                            </div>


                            <a href="{{ route('profile.update', $user->cpf) }}" class="btn btn-danger"><i
                                    class="fa fa-close"></i> Cancelar</a>
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#modal-senha"> <i class="fa fa-save"></i> Salvar
                            </button>

                    </form>

                    @if ($errors->all())
                        @foreach ($errors->all() as $error)
                            <div class="modal modal-danger fade in" id="modal-alert" style="display: block;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="" method="POST">

                                            <div class="modal-header bg-red">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">
                                                    <center><i class="fa fa-warning"></i> ATENÇÃO <i
                                                            class="fa fa-warning"></i></center>
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                Digite a senha para as alterações: <br />
                                                <div class="form-group has-feedback">
                                                    <label class="control-label" id="password" name="password"
                                                        type="password">SENHA
                                                        ATUAL:</label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-lock"></i>
                                                        </div>


                                                        <input type="password" class="form-control" name="password"
                                                            id="senha-atual">

                                                    </div>
                                                </div>
                                                @csrf()
                                            </div>
                                            <div class="modal-footer">
                                                <button id="btn_fechar" type="button" class="btn btn-danger pull-left"
                                                    data-dismiss="modal">Fechar</button>
                                                <button id="btn_salvar" type="submit" class="btn btn-success"><i
                                                        class="fa fa-save"></i>
                                                    Confirmar</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        @endforeach
                    @endif

                </div>

            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <style>
        body {
            margin-top: 20px;
        }

        .avatar {
            width: 200px;
            height: 200px;
        }
    </style>
    <script>
        $(document).ready(function() {

            $('#btn_salvar').click((event) => {
                event.preventDefault();
                $('#senha-hidden').val($('#senha-atual').val());
                $('#form_principal').submit();
            });

            $('#btn_fechar').click((event) => {
                event.preventDefault();
                $('#modal-alert').hide();
            });

        });
    </script>
    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>

@endsection
