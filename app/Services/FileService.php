<?php
/**
 * Created by PhpStorm.
 * User: qnguyen
 * Date: 8/2/18
 * Time: 1:01 PM
 */

namespace App\Services;


interface FileService {
    public function moveToTempFolder($file);
}