<div>
    @if($patient === 'error')
        <div class="alert alert-warning mt-2 alert-dismissible fade show" id="offline_banner" role="alert">
            {{ __("Le code que vous avez rentré est incorrect. Veuillez réessayer svp") }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="form-floating">
        <input type="text" class="form-control" wire:model.defer.defer="code_patient" required placeholder="Veuillez saisir votre code" id="code_patient" name="code_patient">
        <label for="code_patient"> {{ __("Veuillez saisir votre code") }} </label>
        <div class="invalid-feedback">
            Veuillez saisir votre code patient
        </div>
    </div>

    <div class="mt-2 align-center offset-md-4">
        <button type="submit" id="submit_search" wire:click="searchPatient" class="btn btn-primary">
            {{ __('Afficher') }}
        </button>
    </div>
</div>