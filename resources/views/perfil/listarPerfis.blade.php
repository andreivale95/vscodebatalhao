@extends('layout/app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Perfis de Acesso

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('pf.listar') }}"><i class=""></i> Perfis</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Perfis</h3>

                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($perfis as $perfil)
                                <tr>
                                    <td><a href="{{ route('pf.ver', $perfil->id_perfil) }}">{{ $perfil->nome }}</a></td>
                                    @if ($perfil->status == 's')
                                        <td>Ativo</td>
                                    @else
                                        <td>Inatino</td>
                                    @endif
                                    <td class="pull-right">
                                        <a href="{{ route('pf.ver', $perfil->id_perfil) }}" class="btn btn-success"><i
                                                class="fa fa-desktop"></i></a>
                                        <a href="{{ route('pf.editar', $perfil->id_perfil) }}" class="btn btn-warning"><i
                                                class="fa fa-edit"></i></a>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="box-footer">
                    <div class="btn-person">
                        <a href="{{ route('pf.form') }}" type="button" class="btn btn-primary add pull-right"><i
                                class="fa fa-plus"></i>
                        </a>
                    </div>




                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <style>
        .btn-person {
            position: fixed;
            right: 2%;
            bottom: 5%;
            border-radius: 50%;
            z-index: 1000;
        }

        .add {
            box-shadow: 3px 3px 10px 3px rgba(23, 22, 0, 0.5);
            border-radius: 50px;
            font-size: 20px
        }

        .add:hover {
            zoom: 135%;
        }

        @media (max-width:767px) {
            .btn-person {
                position: fixed;
                right: 7%;
                bottom: 3%;
                border-radius: 50%;
                z-index: 1000;
            }
        }
    </style>
    <!-- /.content-wrapper -->
@endsection
