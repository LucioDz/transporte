@extends('layouts.main')

@section('title', 'Checklist cadastrar')

@section('content')

<style>
  input.larger {

    width: 22px;
    height: 22px;

  }

  .linha {
    border: 4px solid #FF0000;
    border-radius: 5px;
    font-weight: bolder;
  }
</style>

<div class="container my-5">

  <main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-center">CheckList</h1>
      </div><!-- End Page Title -->
    <section class="section">

      <div class="row my-5">

        <div class="col-lg-6 mx-auto">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Adicione um intem ao checklist</h5>
              <!-- General Form Elements -->
              <form name="add-car" method="POST" action="/checklist/cadastrar">
                @csrf
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Nome</label>
                  <div class="col-sm-10 ">
                    <input type="text" name="nome" value="{{old('nome')}}" class="form-control @error('nome') is-invalid @enderror">
                    @error('nome')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                  </div>
                </div>
                {{--  
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Tipo</label>
                  <div class="col-sm-8">
                    <select id="" name="tipo" class="form-select @error('tipo') is-invalid @enderror">
                      <option value=""></option>
                      <option value="Problema"  @if (old('tipo') == 'Problema') selected @endif>Problema</option>
                      <option value="Avaria"  @if (old('tipo') == 'Avaria') selected @endif>Avaria</option>
                      <option value="diversos"  @if (old('tipo') == 'diversos') selected @endif>Diversos</option>
                    </select>
                    @error('tipo')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                   @enderror
                  </div>
                  <div class="col-sm-2 p-1 mb-1 text-center">
                    <button class="btn btn-outline-warning btn-sm" type="submit" disabled>
                      <i class="bi bi-plus-square"></i>
                    </button>
                  </div>
                </div>
             --}}

                <div class="row mb-3 text-center">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-warning">Cadastrar</button>
                  </div>
                </div>

            </div>
          </div>

        </div>

      </div>

    
</div>
</div>
</section>

</main><!-- End #main -->

</div>


<script>
  /*
     let = document.querySelector('#modalChecklistCategoria');
     let minhaModal = new bootstrap.Modal(e);
     minhaModal.show();
*/
</script>

@endsection
