@extends('layouts.app', ['title' => 'Accueil'])

@section('main_content')
<nav >
    {{-- style='background-image:url("images/image_index.jpg"); height: 450px' --}}
    <div id="carouselCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            {{-- <button type="button" data-bs-target="#carouselCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button> --}}
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/image_index.jpg" class="d-block" height="600px"  width="100%" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2> e-Carnet de vaccination </h2>
                    <p> Avec e-Carnet de vaccination votre carnet de santé devient mobile et accessible partout dans le monde </p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="images/image_index.jpg" class="d-block" height="600px"  width="100%" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5> Rappel des vaccinations </h5>
                    <p> Vous recevez des notifications en temps réel pour vous mettre à jours des vaccinations </p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="images/image_index.jpg" class="d-block" height="600px"  width="100%" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5> Utilisable hors ligne </h5>
                    <p> Avec e-Carnet de vaccination vous pouvez collecter les données en mode hors ligne. </p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselCaptions" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden"> Previous </span>
        </a>

        <a class="carousel-control-next" href="#carouselCaptions" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden"> Next </span>
        </a>
    </div>
    {{-- <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="text-center d-md-block mt-5">
                    <h2> e-Carnet de vaccination </h2>
                    <p> Avec e-Carnet de vaccination votre carnet de santé devient mobile et accessible partout dans le monde </p>
                </div>
            </div>

            <div class="carousel-item">
                <div class="text-center d-md-block mt-5">
                    <h5> Rappel des vaccinations </h5>
                    <p> Vous recevez des notifications en temps réel pour vous mettre à jours des vaccinations </p>
                </div>
            </div>

            <div class="carousel-item">
                <div class="text-center d-md-block mt-5">
                    <h5> Utilisable hors ligne </h5>
                    <p> Avec e-Carnet de vaccination vous pouvez collecter les données en mode hors ligne. </p>
                </div>
            </div>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden"> Previous </span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden"> Next </span>
        </a>
    </div> --}}
</nav>
@endsection

@section('script_js')
    <script>
        var myCarousel = document.querySelector('#myCarousel')
        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: 1000,
            wrap: false
        })
    </script>
@endsection