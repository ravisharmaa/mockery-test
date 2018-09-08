<?php
/**
 * Created by PhpStorm.
 * User: ravibastola
 * Date: 9/8/18
 * Time: 5:16 PM.
 */

namespace App;

class File
{
    /**
     * @param $file
     * @param $contents
     *
     * @return bool|int
     */
    public function put($file, $contents)
    {
        return file_put_contents($file, $contents);
    }
}
