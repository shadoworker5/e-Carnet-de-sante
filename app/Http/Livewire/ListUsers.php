<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ListUsers extends Component
{
    use WithPagination;
    
    public $per_page = 10;
    public $user_name, $user_mail;

    public function whereTag($column, $value, $count_item){
        return User::where($column, 'like', '%'.$value.'%')->paginate($count_item);
    }

    public function getUserBy($per_page, $user_name = null, $user_mail = null){
        if($user_name !== null)
            return $this->whereTag('name', $user_name, $per_page);
        elseif($user_mail !== null) {
            return $this->whereTag('email', $user_mail, $per_page);
        }else{
            return User::paginate($this->per_page);
        }
    }

    public function searchUser(){
        return $this->getUserBy($this->per_page, $this->user_name, $this->user_mail);
    }

    public function updating(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.list-users', [
            'users' => $this->searchUser()
        ]);
    }
}
