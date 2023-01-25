<?php
class DatabaseManager
{
    private $host = 'localhost';
    private $db = 'myowndashboard';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8';
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    private $pdo;
    private $dsn;
    
    function __construct()
    {
        try {
            $this->dsn = "mysql:host=".$this->host.";dbname=".$this->db.";charset=".$this->charset;
            $this->pdo = new PDO($this->dsn, $this->user, $this->pass,$this->options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }
    public function query($queryString,$values)
    {
        $stmt = $this->pdo->prepare($queryString);
        $stmt->execute($values);
        $keyPairs = $stmt->fetchAll();
        /*
        25-January-2023
        Before this class existed, we used a normal array with indices 0,1,2... instead of a key pair array.
        To keep the old code working, we need to convert the key pair array into a normal array.
        */
        $normalArray = array();
        $count = 0;
        foreach ($keyPairs as $key => $value) {
            $normalArray[$count] = array_values($value);
            $count++;
        }
        return $normalArray;
    }

    public function close()
    {
        $this->pdo = null;
    }

}

?>