<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\AdminPostRequest;
use App\Photo;
use App\Post;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;

class AdminPostsController extends Controller {

    private $fileService;

    /**
     * AdminPostsController constructor.
     *
     * @param $fileService
     */
    public function __construct(FileService $fileService) {
        $this->fileService = $fileService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $posts = Post::whereUserId(Auth::user()->id)->get();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = Category::pluck('name', 'id');
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AdminPostRequest $request) {

        $post = Auth::user()->posts()->create($request->all());

        $file = $request->file('file');
        if ($file) {
            $fileName = $this->fileService->moveToTempFolder($file);
            $post->photos()->save(new Photo(['path' => $fileName]));
        }

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $post = Post::where(['id' => $id, 'user_id' => Auth::user()->id])->first();
        $categories = Category::pluck('name', 'id');
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AdminPostRequest $request, $id) {
        $post = Post::where(['id' => $id, 'user_id' => Auth::user()->id])->first();
        $post->update($request->all());
        $file = $request->file('file');
        if ($file) {
            $fileName = $this->fileService->moveToTempFolder($file);
            $post->photos()->save(new Photo(['path' => $fileName]));
        }

        return redirect(route('posts.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $post = Post::where(['id' => $id, 'user_id' => Auth::user()->id])->first();
        $photo = $post->photos()->first();
        if ($photo !== null) {
            unlink(public_path() . "/" . $photo->path);
        }
        $post->delete();

        session()->flash('deleted_post', $post->title . ' has been deleted');
        return redirect(route('posts.index'));
    }
}
