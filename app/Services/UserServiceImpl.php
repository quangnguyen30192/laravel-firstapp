<?php
/**
 * Created by PhpStorm.
 * User: qnguyen
 * Date: 8/1/18
 * Time: 11:00 AM
 */

namespace App\Services;

use App\Photo;
use App\Role;
use App\User;

class UserServiceImpl implements UserService {

    private $fileService;

    /**
     * UserServiceImpl constructor.
     *
     * @param $fileService
     */
    public function __construct(FileService $fileService) {
        $this->fileService = $fileService;
    }


    public function store($request) {
        $user = User::create($request->all());

        // save the role
        $user->roles()->attach($request->role_id);

        // or
//        $role = Role::find($request->role_id);
//        $user->roles()->save($role);

        $file = $request->file('file');
        if ($file) {
            $fileName = $this->fileService->moveToTempFolder($file);
            $user->photos()->save(new Photo(['path' => $fileName]));
        }

    }

    public function update($request, $id) {
        $user = User::findOrFail($id);
        $input = $request->all();
        $file = $request->file('file');
        if ($file) {
            $fileName = $this->fileService->moveToTempFolder($file);
            $user->photos()->save(new Photo(['path' => $fileName]));
        }

        if ($request->role_id) {
            $role = Role::find($request->role_id);
            $user->roles()->save($role);
        }

        $user->update($input);

        return $user;
    }
}