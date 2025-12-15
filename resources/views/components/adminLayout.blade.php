<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    public ?string $title;
    public ?string $header;
    public ?string $icon;

    public function __construct(?string $title = null, ?string $header = null, ?string $icon = null)
    {
        $this->title = $title;
        $this->header = $header;
        $this->icon = $icon;
    }

    public function render(): View
    {
        return view('layouts.admin');
    }
}