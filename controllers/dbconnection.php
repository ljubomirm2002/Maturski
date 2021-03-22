<?php

declare(strict_types=1);

namespace Controllers;

use PDOException;

final class Dbconnection
{
    private $username = 'root';
    private $password = '';
    private $host = 'localhost';
    private $dbname = 'maturski';
    private $dbh;
    function __construct()
    {

        try {
            $konekcioni_string = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $this->dbh = new \PDO($konekcioni_string, $this->username, $this->password);
            $this->dbh->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            echo "Greska: ";
            echo $e->getMessage();
        }
    }
    function __construct4(string $username, string $password, string $host, string $dbname)
    {
        try {
            $this->username = $username;
            $this->password = $password;
            $this->host = $host;
            $this->dbname = $dbname;
            $konekcioni_string = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $this->dbh = new \PDO($konekcioni_string, $this->username, $this->password);
        } catch (PDOException $e) {
            echo "Greska: ";
            echo $e->getMessage();
        }
    }
    function fetch(string $query, bool $more = false)
    {
        try {
            if ($more)
                return $this->dbh->query($query)->fetchAll(\PDO::FETCH_ASSOC);
            else return $this->dbh->query($query)->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Greska: ";
            echo $e->getMessage();
        }
    }

    function execute(string $query): void
    {
        try {
            $this->dbh->query($query);
        } catch (PDOException $e) {
            echo "Greska: ";
            echo $e->getMessage();
        }
    }
}
