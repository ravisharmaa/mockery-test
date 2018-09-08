<?php
/**
 * Created by PhpStorm.
 * User: ravibastola
 * Date: 9/8/18
 * Time: 11:46 PM
 */

use PHPUnit\Framework\TestCase;
use App\File;

class GeneratorTest extends TestCase
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
        $mockedFile = Mockery::mock(File::class);
        $mockedFile->shouldReceive('put')
            ->with('foo.txt','foo bar')
            ->once();
        $generator = new \App\Generator($mockedFile);
        $generator->fire();
    }
    
}
