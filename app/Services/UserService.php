<?php
/**
 * Created by PhpStorm.
 * User: qnguyen
 * Date: 8/1/18
 * Time: 10:59 AM
 */

namespace App\Services;


interface UserService {
    public function store($request);
    public function update($request, $id);
}