@extends('layout/app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Listagem de Kits</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Kits</li>
            </ol>
        </section>

        <section class="content container-fluid">
            <div class="box">
                <div class="box-header with-border">
                    <a href="{{ route('kits.criar') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Novo Kit
                    </a>
                </div>

                <div class="box-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nome do Kit</th>
                                <th>Unidade de Origem</th>
                                <th>Data de Criação</th>
                                <th>Itens</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kits as $kit)
                                <tr>
                                    <td>{{ $kit->nome }}</td>
                                    <td>{{ $kit->unidade->nome ?? '-' }}</td>
                                    <td>{{ $kit->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <ul style="padding-left: 16px;">
                                            @foreach ($kit->produtos as $produto)
                                                <li>{{ $produto->nome }} (Qtd: {{ $produto->pivot->quantidade }})</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <form action="{{ route('kits.remover', $kit->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Deseja desfazer este kit?')">
                                                <i class="fa fa-undo"></i> Desfazer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Nenhum kit encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="text-center">
                        {{ $kits->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
