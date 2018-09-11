<?php
/**
 * Created by PhpStorm.
 * User: ravi
 * Date: 9/11/18
 * Time: 3:45 PM.
 */
use App\Repositories\TaskRepository;
use PHPUnit\Framework\TestCase;

class TaskRepositoryTest extends TestCase
{
    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->dbMock = Mockery::mock(mysqli::class);
        $this->taskRepository = new TaskRepository($this->dbMock);
    }

    protected function tearDown()/* The :void return type declaration that should be here would cause a BC issue */
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function test_all_returns_empty_array_when_query_result_is_false()
    {
        $this->dbMock->shouldReceive('query')
            ->with('SELECT note FROM tasks ORDER BY created DESC')
            ->andReturn(false);

        $actual = $this->taskRepository->all();

        $this->assertSame([], $actual);
    }

    /**
     * @test
     */
    public function all_returns_empty_array_when_query_has_no_results()
    {
        $dummy = new stdClass();
        $dummy->num_rows = 0;

        $this->dbMock->shouldReceive('query')
            ->with('SELECT note FROM tasks ORDER BY created DESC')
            ->andReturn($dummy)
            ->once();
        $actual = $this->taskRepository->all();

        $this->assertEmpty($actual);
    }
}
