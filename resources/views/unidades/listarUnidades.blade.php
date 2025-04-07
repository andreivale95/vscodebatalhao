@extends('layout/app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Unidades

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('unidades.listar') }}"><i class=""></i> Unidades</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">



            <div class="box box-primary">

                <div class="box-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>

                                <th> UNIDADE</th>
                                <th> AÇÕES</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($unidades as $unidade)
                                <tr>
                                    <td>{{ $unidade->nome }}</td>



                                    <td> <a class="btn btn-warning" href="{{ route('unidade.editar', $unidade->id) }}"
                                            style="color: white">
                                            <i class="fa fa-edit"></i></a>
                                        <a class="btn btn-primary" href="{{ route('unidade.ver', $unidade->id) }}"
                                            style="color: white">
                                            <i class="fa fa-television"></i></a>
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="box-footer">
                    <div class="btn-person">
                        <a href="{{ route('unidade.form') }}" type="button" class="btn btn-primary add pull-right"><i
                                class="fa fa-plus"></i>
                        </a>
                    </div>



                    <div>
                        {{ $unidades->links() }} <!-- Exibe os links de navegação -->
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
