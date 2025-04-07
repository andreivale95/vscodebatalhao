@extends('layout/app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Tipos Bens
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('tipobem.listar') }}"><i class=""></i> Veículos</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <form method="GET" action="{{ route('tipobem.listar') }}">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="row">

                            <div class="form-group has-feedback col-md-1 pull-right">
                                <label class="control-label" for=""> </label>
                                <button type="submit" class="btn btn-primary form-control"><i class="fa fa-filter"></i>
                                    Filtrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="box box-primary">

                <div class="box-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> FOTO </th>
                                <th> TIPO BEM</th>
                                <th> AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($tiposbens as $tiposbem)
                                <tr>
                                    <td>

                                        <a href="{{ route('tipobem.ver', $tiposbem->id) }}"> <img
                                                src="{{ asset('/privace/images/' . $tiposbem->image) }}" alt="Tipo sem Foto"
                                                class="imagem-redimensionada"> </a>


                                    </td>
                                    <td>{{ $tiposbem->nome }}</td>


                                    <td> <a class="btn btn-warning" href="{{ route('tipobem.editar', $tiposbem->id) }}"
                                            style="color: white">
                                            <i class="fa fa-edit"></i></a>
                                        <a class="btn btn-primary" href="{{ route('tipobem.ver', $tiposbem->id) }}"
                                            style="color: white">
                                            <i class="fa fa-television"></i></a>

                                        <div class="box-body" style="display: inline-block">
                                            <form action="{{ route('tipobem.deletar', $tiposbem->id) }}" method="POST"
                                                onsubmit="return confirm('Tem certeza que deseja deletar este Tipo?');">
                                                @csrf
                                                @method('DELETE') <!-- Isso transforma o POST em DELETE -->
                                                <button type="submit" class="btn btn-danger"> <i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </div>


                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="box-footer">
                    <div class="btn-person">
                        <a href="{{ route('tipobem.form') }}" type="button" class="btn btn-primary add pull-right"><i
                                class="fa fa-plus"></i>
                        </a>
                    </div>



                    <div>
                        {{ $tiposbens->links() }} <!-- Exibe os links de navegação -->
                    </div>

                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <style>
        .imagem-redimensionada {
            width: 75px;
            /* Define a largura */
            height: auto;
            /* Mantém a proporção */
        }


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
