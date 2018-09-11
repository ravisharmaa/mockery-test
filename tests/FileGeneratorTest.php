<?php
/**
 * Created by PhpStorm.
 * User: ravibastola
 * Date: 9/8/18
 * Time: 11:46 PM
 */

use PHPUnit\Framework\TestCase;
use App\FileGenerator;
use App\File;


class FileGeneratorTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function it_works()
    {
        /*Must add fully qualified path name*/
        $mockedFile = Mockery::mock('App\File');
        
        $mockedFile->shouldReceive('put')
            ->with('foo.txt','foo bar')
            ->once();
        
        $generator = new FileGenerator($mockedFile);
        
        $generator->fire();
    }
    
}
