<?php
/**
 * Created by PhpStorm.
 * User: ravibastola
 * Date: 9/8/18
 * Time: 5:12 PM.
 */

namespace App;
use App\File;

class FileGenerator
{
    /**
     * @var File
     */
    protected $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function getContent()
    {
        return 'foo bar';
    }

    public function fire()
    {
        $content = $this->getContent();
        $this->file->put('foo.txt', $content);
    }
}
