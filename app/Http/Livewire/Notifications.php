<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    public $notifications;

    public function mount()
    {
        $this->notifications = Auth::user()->notifications;
    }
    
    public function render()
    {
        return view('livewire.notifications');
    }
}
