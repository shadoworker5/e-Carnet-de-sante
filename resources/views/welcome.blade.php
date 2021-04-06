@extends('layouts.app', ['title' => 'Accueil'])

@section('main_content')
    <br>
    <div class="row mb-2">
        <div class="col-md-6 col-xs-*">
            <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item" data-bs-interval="2000">
                        <img src="images/image_index.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block text-white">
                            <h2> e-Carnet de vaccination </h2>
                            <p> Avec e-Carnet de vaccination votre carnet de santé devient mobile et accessible partout dans le monde </p>
                        </div>
                    </div>

                    <div class="carousel-item active" data-bs-interval="10000">
                        <img src="images/image_index.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block text-white">
                            <h5> Rappel des vaccinations </h5>
                            <p> Vous recevez des notifications en temps réel pour vous mettre à jours des vaccinations </p>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="images/image_index.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block text-white">
                            <h5> Utilisable hors ligne </h5>
                            <p> Avec e-Carnet de vaccination vous pouvez collecter les données en mode hors ligne. </p>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </a>

                <a class="carousel-control-next" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        <div class="col-md-6 col-xs-*">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Bienvenue sur e-Carnet de vaccination</h5>

                    <p class="card-text">
                        L'application e-Carnet de santé premet de digitaliser les carnets de santé. Elle est accessible partout dans le mode et aussi utilisable en mode hors ligne. Chaque patient enregistré sur la plateforme a la possibilité de consulter son carnet ou celui de son (ou ses) enfant(s).
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
