@extends('app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Usuario

      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>

      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <p>{{user->nome}}</p>
      <p>{{user->email}}</p>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection
