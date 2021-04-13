<nav class="navbar navbar-expand-lg navbar-light fixed-top bg_color" style="padding-top: 0px; padding-bottom: 0px">
	<a class="navbar-brand text-white" href="/">
		<img src="{{ asset('images/icon-72x72.png') }}" class="logo_menu" alt="logo">
	</a>

	<button class="navbar navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav me-auto mb-2 mb-lg-0">
			@auth
				@if(in_array(Auth::user()->user_role, ['root', 'admin']))
					<li class="nav-item">
						<a class="nav-link text-white" aria-current="page" href="{{ route('dashboard') }}"> {{ __('Dashboard') }} </a>
					</li>
				@else
					<li class="nav-item">
						<a class="nav-link text-white" aria-current="page" href="{{ route('profile') }}"> {{ __('Mon compte') }} </a>
					</li>
				@endif

				<li class="nav-item">
					<a class="nav-link text-white" href="{{ route('home') }}"> {{ __("Accueil") }} </a>
				</li>

				@if(Auth::user()->user_role !== 'guest')
					<li class="nav-item">
						<a class="nav-link text-white" href="{{ route('vaccinate.create') }}"> {{ __("Ajouter une vaccination") }} </a>
					</li>
				@endif

				@if(in_array(Auth::user()->user_role, ['root', 'admin', 'supervisor']))
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Patients
						</a>

						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="{{ route('patient.index') }}"> {{ __('Liste des patients') }} </a></li>
							<li><a class="dropdown-item" href="{{ route('patient.create') }}"> {{ __('Ajouter un patient') }} </a></li>
						</ul>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white" href="#" id="Dropdown_vaccin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Vaccins
						</a>

						<ul class="dropdown-menu" aria-labelledby="Dropdown_vaccin">
							<li><a class="dropdown-item" href="{{ route('calendar.index') }}"> {{ __('Afficher le calendrier')}} </a></li>
							<li><a class="dropdown-item" href="{{ route('calendar.create') }}">{{ __('Ajouter') }}</a> </li>
						</ul>
					</li>
				@endif
				@if(in_array(Auth::user()->user_role, ['root', 'admin', 'collector']))
					<li class="nav-item">
						<a class="nav-link text-white" href="{{ route('offline_submission') }}"> {{ __("Mon activité") }} </a>
					</li>
				@endif
			@endauth
		</ul>

		<div class="d-flex">
			<ul class="navbar-nav">
				@auth
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white" data-user="{{ base64_encode(Auth::user()->id) }}" href="#" id="Dropdown_user" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							{{ Auth::user()->name }}
						</a>

						<ul class="dropdown-menu bg_color" aria-labelledby="Dropdown_user">
							<li>
								<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
									{{ __('Déconnexion') }}
								</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
							</li>
						</ul>
					</li>
				@else
					<li class="nav-item">
						<a class="nav-link active text-white" aria-current="page" href="{{ route('login') }}"> {{ __("S'authentifier") }} </a>
					</li>

					<li class="nav-item">
						<a class="nav-link active text-white" aria-current="page" href="{{ route('register') }}"> {{ __("S'inscrire") }} </a>
					</li>

					<li class="nav-item">
						<a class="nav-link active text-white" aria-current="page" href="{{ route('search') }}"> {{ __("Patient ?") }} </a>
					</li>
				@endauth
			</ul>
		</div>
	</div>
</nav>
