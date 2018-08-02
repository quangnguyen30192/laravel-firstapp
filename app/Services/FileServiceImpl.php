<?php
/**
 * Created by PhpStorm.
 * User: qnguyen
 * Date: 8/2/18
 * Time: 1:01 PM
 */

namespace App\Services;


class FileServiceImpl implements FileService {

    public function moveToTempFolder($file) {
        $fileName = time() . $file->getClientOriginalName();
        $file->move('images', $fileName);
        return $fileName;
    }
}