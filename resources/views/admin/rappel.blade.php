@extends('layouts.app_admin', ['title' => 'Ajouter une campagne'])

@section('main_content')
    <div class="row">
        <div class="col-md-6 mt-3 offset-md-3 mb-2">
            <h2 class="text-center"> {{ __('Notifier les rappels') }}</h2>

            <form action="{{ route('notify') }}" id="form_rappel" class="needs-validation" novalidate method="post">
                @csrf

                <div class="text-center mb-3 mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="value_sms" id="sms">
                        <label class="form-check-label" for="sms">
                            Par SMS
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="value_mail" id="mail">
                        <label class="form-check-label" for="mail">
                            Par mail
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="value_vocal" id="vocal">
                        <label class="form-check-label" for="vocal">
                            Par message vocal
                        </label>
                    </div>
                </div>

                <div class="mt-2 align-center offset-md-4">
                    <button class="btn btn-danger"  onclick="javascript:history.back();">
                        {{ __('Annuler') }}
                    </button>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Envoyé') }}
                    </button>
                </div>
            </form>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"> {{ __('Notifier les rappels') }} </h6>
                </div>

                <div class="card-body">
                    <div class="chart-area">

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"> {{ __('Notifier les retards') }} </h6>
                </div>

                <div class="card-body">
                    <div class="chart-area">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/form_validate.js') }}"></script>
@endsection
