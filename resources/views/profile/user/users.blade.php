@extends('layout/app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Usuários Internos

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('us.lista') }}"><i class=""></i> Usuários Internos</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">



        <div class="box box-primary">
            <div class="box-header">

                <form action="{{ route('us.lista') }}" method="get">
                    {{ csrf_field() }}
                    <label class="control-label">PESQUISAR</label>
                   <div class="input-group">
                    <input type="search" class="form-control input-sm" style="width: 400px" name="search" value="{{ $search }}">
                    <div class="input-group-btn">
                    <button type="submit" style="margin-right:1550px" class="btn btn-primary btn-sm" title="Pesquisar">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </button>
                    </div>
                   </div>
                </form>
                <h3 class="box-title"></h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('us.form') }}" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Criar</a>

                </div>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>PERFIL</th>
                            <th>NOME</th>
                            <th>SOBRENOME</th>
                            <th>TELEFONE</th>
                            <th>E-MAIL</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                        @if ($user->tipo == 'i')
                        <tr>
                            <td>{{$user->perfil()->get()->first()->nome}}</td>
                            <td><a href="{{ route('us.ver', $user->cpf) }}">{{$user->nome}}</a></td>
                            <td>{{$user->sobrenome}}</td>
                            <td>{{$user->telefone}}</td>
                            <td>{{$user->email}}</td>

                            <td>
                                <a href="{{ route('us.ver', $user->cpf ) }}" class="btn btn-success"><i class="fa fa-desktop"></i></a>
                                <a href="{{ route('us.editar', $user->cpf ) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                @if ($user->status == 's')
                                <a href="{{ route('us.status', $user->cpf ) }}" class="btn btn-danger" ><i class="fa fa-close"></i></a>
                                @else
                                <a href="{{ route('us.status', $user->cpf ) }}" class="btn btn-success"><i class="fa fa-check"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="box-footer">

            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
