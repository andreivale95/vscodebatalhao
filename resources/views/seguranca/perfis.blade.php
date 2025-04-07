@extends('layout/app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Perfis de Acesso

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class=""></i> Segurança</a></li>
            <li><a href="#"><i class=""></i> Perfis de Acesso</a></li>

        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="row">
            <div class="col-lg-6">
                <div class="box box-success">
                    <div class="box-body">
                        <form action="" method="post">
                            @csrf()
                            <div class="form-group has-feedback">
                                <input type="perfil" class="form-control" placeholder="Perfill">
                            </div>
                            <div class="form-group has-feedback">
                                <select name="" id="" class="form-control" multiple>
                                    @foreach ($permissoes as $permissao)
                                    <option value="{{$permissao->id_permissao}}">{{$permissao->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">

                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-success btn-block btn-flat">Criar</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Perfis de Acesso</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>PERFIL</th>
                                    <th>PERMISSOES</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($perfis as $perfil)
                                <tr>

                                    <td>{{$perfil->nome}}</td>

                                    <td>
                                        @foreach ($perfil->perfil_permissoes()->get() as $p)
                                        {{ $p->permissao()->get()->first()->nome }}</br>
                                        @endforeach
                                    </td>

                                    <td></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="box-footer">

                    </div>
                </div>
            </div>

        </div>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection