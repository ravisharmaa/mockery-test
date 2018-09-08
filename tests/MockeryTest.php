<?php

use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: ravibastola
 * Date: 9/8/18
 * Time: 4:56 PM.
 */
class MockeryTest extends TestCase
{
    /**
     * @test
     */
    public function that_it_mocks_an_object()
    {
        $mock = Mockery::mock();
        $mock->shouldReceive('something','somethingElse')->andReturns(5);
        $this->assertSame(5, $mock->something());
        $this->assertSame(5, $mock->somethingElse());
    }
}
