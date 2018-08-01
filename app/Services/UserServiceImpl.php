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
            $fileName = $this->moveToTempFolder($file);
            $user->photos()->save(new Photo(['path' => $fileName]));
        }

    }

    public function update($request, $id) {
        $user = User::findOrFail($id);
        $input = $request->all();
        $file = $request->file('file');
        if ($file) {
            $fileName = $this->moveToTempFolder($file);
            $user->photos()->save(new Photo(['path' => $fileName]));
        }

        if ($request->role_id) {
            $role = Role::find($request->role_id);
            $user->roles()->save($role);
        }

        $user->update($input);
    }

    private function moveToTempFolder($file) {
        $fileName = time() . $file->getClientOriginalName();
        $file->move('images', $fileName);
        return $fileName;
    }
}