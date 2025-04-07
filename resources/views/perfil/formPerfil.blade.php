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

        <div class="panel panel-primary" style="background-color: #00a65a;">
            <div class="panel-heading" style="color: white;">
                Perfil
            </div>
            <div class="panel-body" style="background-color: white;">
                <form action="{{ route('pf.criar') }}" method="post" class="row">

                    @csrf()
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header">
                                DADOS DO PERFIL
                            </div>
                            <div class="panel-body">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Nome:</label>

                                    <input type="text" class="form-control" placeholder="" name="nome" value="" require>

                                </div>
                                <a href="{{route('pf.listar')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Voltar</a>
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-primary">
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
                                            <input id="inp_{{$p->id_permissao}}" type="checkbox" name="{{$p->id_permissao}}">
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

</script>

@endsection
