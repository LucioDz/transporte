@extends('layouts.main')

@section('title', 'Cadastrar Funcionario')

@section('content')


    <svg style="border:2px solid blue">
        <path
        stroke="black"
        stroke-width="4"
        fill="none";
        d="M40,20 L40,80 A30,30 0 0,1 100 100z"
        />
    </svg>

    <div class="my-5 col-12">

        <div class="col-2">

            <img src="/img/Tcul.png" class="d-inline-block align-top im" alt="" usemap="#tcul_carro">
            <map name="tcul_carro">
                <area id="vidro_de_traz" shape="rect" coords="77,36,196,89" href="#" alt="">
            </map>


        </div>

        <div class="col-6">

            @include('portaria.angola')

        </div>

        <div class="col-6">

            @include('portaria.carro')

        </div>

    </div>
@endsection

</body>

</html>
