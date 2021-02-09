@extends('layouts.app', ['title' => 'Calendrier de vaccination'])

@section('main_content')
    <div class="row">
        <h1 class="text-center"> Calendrier de vaccination au Burkina Faso </h1>
        
        {{-- <div>
            <label for="search"> Rechercher </label>
            <input type="text" placeholder="John Doe" wire:model="search" id="search" name="search"/>
        </div>

        <div>
            <select wire:model.lazy="per_page" name="choose" id="choose">
                @for($i = 5; $i <= 100; $i += 5)
                    <option value="{{ $i }}"> {{ $i }} <option>
                @endfor
            </select>
        </div> --}}
        <div class="table-responsive-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            {{ __('Age') }}
                        </th>

                        <th>
                            {{ __('Nom du vaccin') }}
                        </th>
                        
                        <th>
                            {{ __('Prevention contre') }}
                        </th>
                        
                        <th>
                            {{ __('Validité') }}
                        </th>

                        <th>
                            {{ __('Action') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($vacines as $vacine)
                        <tr class="{{ $loop->index % 2 == 0 ? 'bg-info text-white' : '' }}">
                            <td>
                                {{ $vacine->patient_age }}
                            </td>

                            <td>
                                {{ $vacine->name_vaccine }}
                            </td>
                            
                            <td>
                                {{ $vacine->illness_against }}
                            </td>

                            <td>
                                {{ $vacine->status === '1'? 'En cours' : 'Interdit' }}
                            </td>
                            
                            <td>
                                <a href="{{ route('calendar.edit', $vacine) }}" class="btn btn-success">
                                    {{ __('Modifier') }}
                                </a>
                            </td>
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