@extends('layouts.app', ['title' => 'Calendrier de vaccination'])

@section('main_content')
    <div class="row">
        <h1 class="text-center"> Calendrier de vaccination au Burkina Faso </h1>
        
        <div class="table-responsive-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th> {{ __('Age') }} </th>

                        <th> {{ __('Nom du vaccin') }} </th>
                        
                        <th> {{ __('Prevention contre') }} </th>
                        
                        <th> {{ __('Validité') }} </th>
                        
                        @if(!in_array(Auth::user()->user_right, ['collector', 'guest']))
                            <th> {{ __('Action') }} </th>                            
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @foreach($vacines as $vacine)
                        <tr class="{{ $loop->index % 2 == 0 ? 'bg-info text-white' : '' }}">
                            <td> {{ $vacine->patient_age }} </td>

                            <td> {{ $vacine->name_vaccine }} </td>
                            
                            <td> {{ $vacine->illness_against }} </td>

                            <td> {{ $vacine->status === '1'? 'En cours' : 'Interdit' }} </td>
                            
                            @if(!in_array(Auth::user()->user_right, ['collector', 'guest']))
                                <td>
                                    <a href="{{ route('calendar.edit', $vacine) }}" class="btn btn-success">
                                        {{ __('Modifier') }}
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="offset-md-5">
            {{ $vacines->links() }}
        </div>
    </div>
@endsection