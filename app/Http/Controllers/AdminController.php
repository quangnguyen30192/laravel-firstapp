<?php

namespace App\Http\Controllers;

use App\Category;
use App\Photo;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {

    /**
     * AdminController constructor.
     */
    public function __construct() {
        $this->middleware([
                              'isAdmin',
                              'auth'
                          ]);
    }

    public function index() {
        $user = Auth::user();
        $userCount = User::count();
        $postCount = Post::count();
        $categoryCount = Category::count();
        $mediaCount = Photo::count();

        return view('admin.index', compact('user', 'userCount', 'postCount', 'categoryCount', 'mediaCount'));
    }
}
