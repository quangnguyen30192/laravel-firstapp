<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {

    /**
     * AdminController constructor.
     */
    public function __construct() {
        $this->middleware(['isAdmin', 'auth']);
    }

    public function index() {
        $user = Auth::user();
        return "Hello Administrator: " . $user->name . " - role: ". $user->roles;
    }
}
