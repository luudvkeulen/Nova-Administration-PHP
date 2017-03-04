<?php

class PlayerDAO
{
    private $connection;

    public function __construct(PDO $connection = null)
    {
        $this->connection = $connection;
        if ($this->connection === null) {
            $this->connection = new PDO('mysql:host=localhost;dbname=nova_administration;charset=utf8mb4', 'novaadmin', 'Nova2016');
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        }
    }

    public function find($id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM players WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Player');
        return $stmt->fetch();
    }

    public function findAll()
    {
        $stmt = $this->connection->prepare('SELECT * FROM players');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Player');

        return $stmt->fetchAll();
    }
}