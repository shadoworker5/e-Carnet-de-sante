<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;

/**
 * Ce trait verifie si le compte de l'utilisateur qui tente de se connecter
 * est actif
 */
trait VerifyStatus{
    public function getStatus(){
        if(Auth::user()->account_status !== '1'){
            return redirect()->route('verify_status');
        }
    }
}
