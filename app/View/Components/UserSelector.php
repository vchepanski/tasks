<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserSelector extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct($selectedUsers = [])
    {
        $this->users = User::where('id', '!=', auth()->id())->get();
        $this->selectedUsers = $selectedUsers;
    }

    public function render()
    {
        return view('components.user-selector');
    }
}
