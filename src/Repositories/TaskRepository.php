<?php

namespace App\Repositories;

use Exception;
use App\Task;

class TaskRepository
{
    /**
     * @var \mysqli
     */
    private $dbConnection;

    /**
     * TaskRepository constructor.
     *
     * @param \mysqli $dbConnection
     */
    public function __construct(\mysqli $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * @return array
     */
    public function all()
    {
        $result = $this->dbConnection->query('SELECT note FROM tasks ORDER BY created DESC');

        if (false === $result || 0 === $result->num_rows) {
            return [];
        }

        $tasks = [];
        while ($data = $result->fetch_assoc()) {
            $tasks[] = new Task($data['note']);
        }

        $result->free();

        return $tasks;
    }

    /**
     * @param $note
     *
     * @return Task|bool
     *
     * @throws Exception
     */
    public function create($note)
    {
        $sql = 'INSERT INTO tasks (note, created) VALUES (?, NOW())';
        $stmt = $this->dbConnection->prepare($sql);
        if (!$stmt) {
            throw new Exception($this->dbConnection->getError());
        }

        $stmt->bind_param('s', $note);

        if (!$stmt->execute()) {
            return false;
        }

        $stmt->close();

        return new Task($note);
    }
}
