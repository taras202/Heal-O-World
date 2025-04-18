<?php

namespace App\Http\Controllers\auth;

class RoleSelectionController
{
    public function index()
    {
        return view('auth.select-role');
    }
}
