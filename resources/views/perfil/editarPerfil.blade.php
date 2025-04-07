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

        <div class="panel" style="background-color: #f39c12;">
            <div class="panel-heading" style="color: white;">
                Perfil de {{$perfil->nome}}
            </div>
            <div class="panel-body" style="background-color: white;">
            <input type="hidden" value="{{$perfil->id_perfil}}" id="id_perfil">
                <form action="{{ route('pf.atualizar', $perfil->id_perfil) }}" method="POST" class="row">
                    @csrf()
                    <div class="col-md-6">
                        <div class="box box-warning">
                            <div class="box-header">
                                DADOS DO PERFIL
                            </div>
                            <div class="panel-body">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Nome:</label>

                                    <input type="text" class="form-control" placeholder="" name="nome" value="{{$perfil->nome}}">

                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Status:</label>
                                    <select name="status" class="form-control">

                                        @if ($perfil->status == 's')
                                        <option value="s" selected>Ativo</option>
                                        <option value="n">Inativo</option>
                                        @else
                                        <option value="s">Ativo</option>
                                        <option value="n" selected>Inativo</option>
                                        @endif
                                    </select>

                                </div>
                                <a href="{{ route('pf.listar') }}" class="btn btn-danger"><i class="fa fa-close"></i> Cancelar</a>
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salva</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-warning">
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
                                            <input id="{{$p->id_permissao}}" name="{{$p->id_permissao}}" type="checkbox">
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

                </form>
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
                    $('#' + data[i].id_permissao).attr('checked', true);
                }
            })

    });
</script>

@endsection