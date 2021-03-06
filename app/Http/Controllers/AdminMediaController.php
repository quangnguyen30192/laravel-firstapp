<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMediaController extends Controller {

    private $fileService;

    /**
     * AdminMediaController constructor.
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
        $photos = Photo::all();
        return view('admin.media.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.media.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $file = $request->file('file');
        if ($file) {
            $fileName = $this->fileService->moveToTempFolder($file);
            Auth::user()->photos()->save(new Photo(['path' => $fileName]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        if (isset($request->delete_single)) {
            $photo = Photo::where([
                                      'id' => $request->media_single_id,
                                      'imageable_id' => Auth::user()->id,
                                      'imageable_type' => 'App\User'
                                  ])->first();

            if ($photo !== null) {
                unlink(public_path() . "/" . $photo->path);
                $photo->delete();
            }

            session()->flash('deleted_photo', $photo->path . ' has been deleted');
        }

        if (isset($request->delete_multiple) && !empty($request->checkBoxArray)) {
            $photoIds = $request->checkBoxArray;
            Photo::whereIn('id', $photoIds)->delete();
        }

        return redirect(route('media.index'));
    }

}
