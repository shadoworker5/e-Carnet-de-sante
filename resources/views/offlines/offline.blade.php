@extends('layouts.app', ['title' => 'Hors ligne'])

@section('main_content')
    <div class="row">
        <div class="offset-md-2">
            <h3> Vous devez être connecter pour consulter cette page </h3>
            <a href="#" onclick="javascript:history.back();" class="btn btn-primary"> Revenir en arrière </a>
        </div>
    </div>
@endsection