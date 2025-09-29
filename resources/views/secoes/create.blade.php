@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Cadastrar Nova Seção na Unidade: {{ $unidade->nome }}</h1>
        <a href="{{ route('secoes.index', $unidade->id) }}" class="btn btn-secondary">Voltar</a>
    </section>
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-body">
                <form action="{{ route('secoes.store', $unidade->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nome">Nome da Seção</label>
                        <input type="text" name="nome" id="nome" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
