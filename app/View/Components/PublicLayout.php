<?php

namespace App; // <-- Pastikan namespace ini benar
namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PublicLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.public'); // <-- Ini mengarah ke file Blade yang baru kita buat
    }
}