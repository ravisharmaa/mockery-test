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
        $mock = Mockery::mock()->shouldIgnoreMissing();
        $mock->shouldReceive('something')->andReturns(5);
        $this->assertSame(5, $mock->something());
        $this->assertNull($mock->somethingElse());
    }

    /**
     * @test
     */

    public function test_a_mock_object()
    {
        $mock = Mockery::mock('App\Task');
        $mock->shouldReceive('getNote')->andReturn('whatever');
        $this->assertSame('whatever', $mock->getNote());
    }
}
