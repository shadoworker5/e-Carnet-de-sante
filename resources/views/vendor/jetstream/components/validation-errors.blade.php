@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">{{ __('Une erreur s\'est produit ') }}</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <div>
            Veuillez contacter <a href="mailto:kassoum.traore@africasys.com"  class="text-blue-600"> un administrateur </a> si le problème persiste
        </div>
    </div>
@endif
