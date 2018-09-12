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

    /**
     * @test
     */
    public function all_returns_tasks_when_query_has_results()
    {
        $result = Mockery::spy();

        $result->num_rows = 2;

        $this->dbMock->shouldReceive('query')
            ->with('SELECT note FROM tasks ORDER BY created DESC')
            ->andReturn($result);

        $result->shouldReceive('fetch_assoc')
            ->andReturn(['note' => 'Task 1'], ['note' => 'Task 2'], ['note' => 'Task 3'], null);

        $actual = $this->taskRepository->all();

        $this->assertSame('Task 1', $actual[0]->getNote());
        $this->assertSame('Task 2', $actual[1]->getNote());
        $this->assertSame('Task 3', $actual[2]->getNote());

        $result->shouldHaveReceived('free');
    }

    /**
     * @test
     */
    public function create_throws_exception()
    {
        $this->dbMock->shouldReceive('prepare')
            ->with('INSERT INTO tasks (note, created) VALUES (?, NOW())')
            ->andReturn(false);

        $this->dbMock->shouldReceive('getError')
            ->andReturn('oh No');

        $this->expectException(Exception::class);

        $this->expectExceptionMessage('oh No');

        $this->taskRepository->create('Task 1');
    }

    /**
     * @test
     */
    public function create_returns_false()
    {
        $statement = Mockery::mock('mysql_stmt_mock');
        $statement->shouldReceive('bind_param')
            ->with('s', 'Task 1');

        $statement->shouldReceive('execute')
            ->andReturnFalse();

        $this->dbMock->shouldReceive('prepare')
            ->with('INSERT INTO tasks (note, created) VALUES (?, NOW())')
            ->andReturn($statement);

        $actual = $this->taskRepository->create('Task 1');

        $this->assertFalse($actual);
    }
    
    /**
     * @test
     */

    public function create_returns_the_note_created()
    {
        $statement = Mockery::spy('mysql_stmt_mock');

        $statement->shouldReceive('bind_param')
            ->with('s', 'Task 1');

        $statement->shouldReceive('execute')
            ->andReturnTrue();

        $this->dbMock->shouldReceive('prepare')
            ->with('INSERT INTO tasks (note, created) VALUES (?, NOW())')
            ->andReturn($statement);

        $actual = $this->taskRepository->create('Task 1');

        $this->assertInstanceOf(\App\Task::class, $actual);

        $this->assertSame('Task 1', $actual->getNote());
    }
}
