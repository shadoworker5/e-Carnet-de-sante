<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    protected function userGuard(){
        if(!in_array(Auth::user()->user_role, ['root', 'admin'])){
            return redirect()->route('home');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->userGuard();
        $password = Str::random(10);
        $msg = "Bonjour. Votre compte a été crée avec succès. Vous pouvez utiliser vos identifiant pour vous connecter.";

        $this->validate($request, [
            'name'          => 'required|min:4',
            'email'         => 'required|email',
            'user_right'    => 'required',
            'statu'         => 'required'
        ]);

        User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'account_status'    => $request->statu,
            'user_role'         => $request->user_right,
            'password'          => Hash::make($password)
        ]);
        
        Mail::to($request->email)->send(new Contact($msg, $request->email, $password));
        return redirect()->route('list_user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->userGuard();

        $this->validate($request, [
            'name'          => 'required|min:4',
            'email'         => 'required|email',
            'user_right'    => 'required',
            'statu'         => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name'              => $request->name,
            'email'             => $request->email,
            'account_status'    => $request->statu,
            'user_role'         => $request->user_right
        ]);
        
        return redirect()->route('list_user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userGuard();
        User::destroy($id);
        return redirect()->route('list_user');
    }
}
