<?php

namespace App\View\Components;

use Closure; // Import Closure
use Illuminate\Contracts\View\View; // Import View dari Contracts
use Illuminate\View\Component;

class AdminLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('layouts.admin-layout'); // <<< UBAH INI
    }
}
