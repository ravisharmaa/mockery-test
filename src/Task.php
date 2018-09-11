<?php
/**
 * Created by PhpStorm.
 * User: ravi
 * Date: 9/11/18
 * Time: 3:37 PM.
 */

namespace App;

/**
 * Class Task
 * @package App
 */
class Task
{
    /**
     * @var
     */
    private $note;


    /**
     * Task constructor.
     * @param $note
     */
    public function __construct($note)
    {
        $this->note = $note;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }
}
