@extends('app')

@section('title', 'Dyslexia Learning - Home')

@section('content')
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <h1 class="mt-5" style="color: grey;">WHAT IS<br>
                <span style="color: purple;">D</span>
                <span style="color: red;">Y</span>
                <span style="color: lightgreen;">S</span>
                <span style="color: orchid;">L</span>
                <span style="color: blueviolet;">E</span>
                <span style="color: chocolate;">X</span>
                <span style="color: darkolivegreen;">I</span>
                <span style="color: midnightblue;">A</span>
                <span style="color: wheat;">?</span>
            </h1>
            <p class="px-5 my-4">
                <i>Dyslexia is a specific learning disability that affects reading and related language-based processing
                    skills. Individuals with dyslexia struggle
                    with word recognition, decoding, and spelling.</i>
            </p>
            <p class="px-5">
                <b>Welcome to Dyslexia Learning, we're here to assist you with learning words! You may begin your journey by
                    first registering/login into our website!</b>
            </p>
            <div class="mt-3">
                <a href="{{ route('register') }}" class="btn btn-info mx-5 px-5 py-2" style="border-radius: 20px;">Register</a>
                <a href="{{ route('login') }}" class="btn btn-danger mx-5 px-5 py-2" style="border-radius: 20px;">Login</a>
            </div>
        </div>
    </div>

    {{-- <div class="text-center">
        <h1 class="mt-5" style="color:grey">WHAT IS<br>
            <span style="color:purple">D</span>
            <span style="color:red">Y</span>
            <span style="color:lightgreen">S</span>
            <span style="color:orchid">L</span>
            <span style="color:blueviolet">E</span>
            <span style="color:chocolate">X</span>
            <span style="color:darkolivegreen">I</span>
            <span style="color:midnightblue">A</span>
            <span style="color:wheat">?</span>
        </h1>
        <p class="px-5 my-4">
            <i>Dyslexia is a specific learning disability that affects reading and related language-based processing skills.
                Individuals with dyslexia struggle
                with word recognition, decoding, and spelling.</i>
        </p>
        <p class="px-5">
            <b>Welcome to Dyslexia Learning, we're here to assist you with learning words! You may begin your journey by
                first registering/login into our website!</b>
        </p>
        <div class="mt-3">
            <button type="button" class="btn btn-info mx-5 px-5 py-2" style="border-radius:20px;">Register</button>
            <button type="button" class="btn btn-danger mx-5 px-5 py-2" style="border-radius:20px;">Login</button>
        </div>
    </div> --}}
@endsection
