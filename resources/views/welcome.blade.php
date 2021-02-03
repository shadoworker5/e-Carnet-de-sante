@extends('layouts.app', ['title' => 'Accueil'])

@section('main_content')
<nav style='background-image:url("images/img2.jpg"); height: 450px'>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <!-- <ol class="carousel-indicators">
            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>
            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></li>
        </ol> -->

        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="text-center d-md-block text-white mt-5">
                    <h2> Carte de santé digital </h2>
                    <p> Avec e-Santé votre carnet de santé devient mobile et accessible partout dans le monde</p>
                </div>
            </div>

            <div class="carousel-item">
                <div class="text-center d-md-block text-white mt-5">
                    <h5> Rappel des vaccinations </h5>
                    <p> Vous recevez des notifications en temps réel pour vous mettre à jours des vaccinations </p>
                </div>
            </div>

            <div class="carousel-item">
                <div class="text-center d-md-block text-white mt-5">
                    <h5> Utilisable hors ligne </h5>
                    <p> Avec e-Santé vous pouvez collecter les données en mode hors ligne. </p>
                </div>
            </div>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>
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