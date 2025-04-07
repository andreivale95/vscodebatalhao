@extends('layout/app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Perfil de Acesso

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('pf.listar') }}"><i class=""></i> Perfis</a></li>

        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="modal modal-danger fade" id="modal-atribuir" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('pf.deletar', $perfil->id_perfil) }}" method="POST">
                        <input id="id_perfil" type="hidden" value="{{$perfil->id_perfil}}">
                        <div class="modal-header bg-red">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Deletar</h4>
                        </div>
                        <div class="modal-body">
                            Você tem certeza que deseja deletar esse perfil?
                            @csrf()
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Deletar</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

        <div class="panel" style="background-color: #00a65a;">
            <div class="panel-heading" style="color: white;">
                Perfil de {{$perfil->nome}}

            </div>
            <div class="panel-body" style="background-color: white;">
                <div class="row">

                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header">
                                DADOS DO PERFIL
                            </div>
                            <div class="panel-body">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Nome:</label>

                                    <input type="text" class="form-control" placeholder="" name="nome" value="{{$perfil->nome}}" disabled>

                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Status:</label>
                                    @if ($perfil->status == 's')
                                    <input id="status" type="text" class="form-control" placeholder="" name="status" value="ATIVO" disabled>
                                    @else
                                    <input id="status" type="text" class="form-control" placeholder="" name="status" value="INATIVO" disabled>

                                    @endif

                                </div>
                                <div class="form-group row">

                                    <a href="{{ route('pf.listar') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Voltar</a>
                                    <a href="{{ route('pf.editar', $perfil->id_perfil) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Editar</a>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-atribuir"> <i class="fa fa-trash"></i> Deletar
                                    </button>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header">
                                PERMISSÕES
                            </div>
                            <div class="panel-body row">
                                <div class="form-group col-md-12">

                                    @foreach ($modulos as $m )
                                    <p><b>{{$m->nome}}</b></p>
                                    @foreach ($permissoes as $p )

                                    @if ($p->modulo == $m->id_modulo)
                                    <div class="checkbox">
                                        <label>
                                            <input id="inp_{{$p->id_permissao}}" type="checkbox" disabled>
                                            {{$p->nome}}
                                        </label>
                                    </div>
                                    @endif


                                    @endforeach

                                    @endforeach
                                </div>

                            </div>

                        </div>

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
        $.get({
                url: $('body').data('host') + "/api/permissoes/perfil/" + $('#id_perfil').val(),
            })
            .done(function(data) {
                data = JSON.parse(data);
                for (let i = 0; i < data.length; i++) {
                    $('#inp_' + data[i].id_permissao).attr('checked', true);
                }
            })

    });
</script>

@endsection