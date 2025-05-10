<?php
namespace Controller;

use Src\View;
use Src\Auth\Auth;

class ProfileController
{
    public function profile(): string
    {
        $user = Auth::user();
        return new View('site.profile', ['user' => $user]);
    }
}