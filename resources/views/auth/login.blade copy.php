@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


  <!-- Bootstrap link  -->
  <link rel="stylesheet" href="/css/bootstrap.min.css">

  <style>
      .bd-placeholder-img {
          font-size: 1.125rem;
          text-anchor: middle;
          -webkit-user-select: none;
          -moz-user-select: none;
          user-select: none;
      }

      @media (min-width: 768px) {
          .bd-placeholder-img-lg {
              font-size: 3.5rem;
          }
      }

  </style>

  <link href="/css/signin.css" rel="stylesheet">

  </head>

  <body class="text-center">
      {{-- - verficando se existe erro --}}


      <main class="form-signin">

                  @if( session('erro_login') != null )
                      <div class="altert alert-danger p-3 mb-3">
                            {{session('erro_login')}}
                      </div>
                  @endif

          <form method="POST" action="/entrar">
              @csrf
              <div class="text-center mb-4">
                  <img class="" src="/img/tcul_ico-300x116.png" alt="" width="200" height="100">
              </div>
              <h1 class="h3 mb-3 fw-normal text-center">Faça Login</h1>
              <div class="form-floating">
                  <input type="text" id="email" name="usuario" placeholder="voce@examplo.com" value=""
                      class="form-control @error('usuario') is-invalid @enderror " value={{old('usuario')}} >
                  <label for="email">Email</label>

                  @error('usuario')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                  @enderror

              </div>
              <div class="form-floating">
                  <input type="password" id="senha" name="senha" placeholder="Palavra Passe"
                      class="form-control  @error('senha') is-invalid @enderror ">
                  <label for="floatingPassword">Palavra Passe</label>
                  @error('senha')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                  @enderror
              </div>
              <button class="w-100 btn btn-lg btn-danger mt-3" type="submit">Entrar</button>
              <p class="mt-5 mb-3 text-muted text-center">Acesso Restrito a pessoas Autorizadas</p>
          </form>

      </main>



  </body>

  </html>
