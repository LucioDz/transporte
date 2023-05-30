@extends('layouts.main')

@section('title', 'Listar Checklist')

@section('content')

    <div class="container my-5">

        <h2 class="text-center my-5 ">
            <i class="text-warning bi bi-list-columns"></i>
            lista de itens do checklist
        </h2>

        <div class="col-md-4 col-sm-6 mx-auto mb-3">

            <form class="d-flex" action="/checklist/pesquisar" method="POST">
                @csrf
                <input name="pesquisar" type="search" placeholder="pesquisar" aria-label="Search"
                    class="form-control me-2
                @error('pesquisar') is-invalid @enderror"
                    value="{{ old('pesquisar') }}">
                @error('pesquisar')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <button class="btn btn-outline-warning" type="submit">Pesquisar</button>
            </form>

        </div>

        <div class="card-body table-responsive">
            @if (isset($pesquisar))
                <div class="pagetitle">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/checklist/listar">checklist</a></li>
                            <li class="breadcrumb-item"><a href="/cadastrar/checklist">cadastrar</a></li>
                            <li class="breadcrumb-item active">checklist</li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->
            @else
                <div class="pagetitle">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/cadastrar/checklist">cadastrar</a></li>
                            <li class="breadcrumb-item active">checklist</li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->
            @endif
            <table class="table table-striped table-bordered datatable">


                <thead>
                    <tr>
                        <th>id</th>
                        <th>Descricao</th>
                        <th>editar</th>
                        <th>Deletar</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>id</th>
                        <th>Descricao</th>
                        <th>editar</th>
                        <th>Deletar</th>
                    </tr>
                </tfoot>
                <tbody>

                    @if (count($checklists) > 0)

                        @foreach ($checklists as $checklist)
                            <tr>
                                <td>{{ $checklist->id_checklist }}</td>
                                <td>{{ $checklist->nome_item }}</td>

                                <td class="text-center" title="Editar">
                                    <a class="btn btn-primary" href="/checklist/editar/{{ $checklist->id_checklist }}"><i
                                            class="bi bi-pen-fill"></i>
                                </td></a> 
                                <td class="text-center" title="Deletar">
                                    <form action="/checklist/deletar/{{ $checklist->id_checklist }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr> 
                        @endforeach
                    @else
                        <tr>
                            <td colspan='15'>
                                <div class="alert alert-danger mx-auto col-12 m-2 text-center fs-5">
                                    Nenhum resultado encontrado
                                </div>
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    {!! $checklists->appends([
                            'pesquisar' => request()->get('pesquisar', ''),
                        ])->links() !!}
                </ul>
            </nav>

        </div>

    </div>

@endsection
