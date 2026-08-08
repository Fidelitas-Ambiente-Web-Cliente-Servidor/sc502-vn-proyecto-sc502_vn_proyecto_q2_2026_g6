<?php
class Database
{
    private string $host = "db";
    private string $db   = "BdProyectoCruzRoja";
    private string $user = "root";
    private string $pass = "root";

    public function connect(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";

        $pdo = new PDO($dsn, $this->user, $this->pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        return $pdo;
    }
}