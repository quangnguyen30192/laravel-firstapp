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

    public function store($request) {
        $user = User::create($request->all());

        // save the role
        $user->roles()->attach($request->role_id);

        // or
//        $role = Role::find($request->role_id);
//        $user->roles()->save($role);

        $file = $request->file('file');
        if ($file) {
            $fileName = $file->getClientOriginalName();
            $file->move('images', $fileName);
        }

        $user->photos()->save(new Photo(['path' => $fileName]));
    }
}