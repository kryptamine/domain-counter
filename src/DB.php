<?php

namespace App;

use PDO;
use PDOException;

/**
 * Class DB
 * @package App
 */
class DB
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * DB constructor.
     *
     * @param string $host
     * @param string $dbName
     * @param string $user
     * @param string $password
     * @param int    $port
     */
    public function __construct(string $host, string $dbName, string $user, string $password, int $port = 3306)
    {
        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
        } catch (PDOException $e) {

        }
    }

    public function getInstance()
    {
        return $this->db;
    }
}