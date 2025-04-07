@extends('layout/app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-user"></i>
                Alterar Foto do Perfil

            </h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>

            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="panel" style="background-color: #f39c12;">
                <div class="panel-heading" style="color: white;">
                    {{ Auth::user()->nome }} {{ Auth::user()->sobrenome }}<br>

                </div>
                <div class="panel-body" style="background-color: white;">




                    <form action="{{ route('foto.update', Auth::user()->cpf) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <div class="box box-warning">
                                <div class="box-header">
                                   FOTO PERFIL
                                </div>
                                <div class="col-md-5">
                                    <div class="text-center">

                                        <img id="blah" src="{{ asset('/storage/images/' . Auth::user()->image) }}"
                                            alt="your image" class="avatar img-circle img-thumbnail" alt="avatar">
                                        <h6>Trocar Foto de Perfil</h6>


                                        <input accept="image/*" name="image" class="form-control" type='file'
                                            id="imgInp">
                                        <input type="submit" value="Atualizar">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>




                </div>

            </div>

        </section>
        <script>
            imgInp.onchange = evt => {
                const [file] = imgInp.files
                if (file) {
                    blah.src = URL.createObjectURL(file)
                }
            }
        </script>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
