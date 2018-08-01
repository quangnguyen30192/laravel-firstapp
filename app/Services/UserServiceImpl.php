<?php
/**
 * Created by PhpStorm.
 * User: qnguyen
 * Date: 8/1/18
 * Time: 11:00 AM
 */

namespace App\Services;

class UserServiceImpl implements UserService {

    public function store($request) {
        User::create($request->all());
    }
}