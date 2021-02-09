@extends(in_array(Auth::user()->user_role, ['root']) ? 'layouts.app_admin' : 'layouts.app', ['title' => 'Liste des patients'])

@section('main_content')
    @livewire('list-patients')
@endsection