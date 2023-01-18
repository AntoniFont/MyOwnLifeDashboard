<?php
class DatabaseManager
{
    private $host = '127.0.0.1';
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
        return $stmt->fetchAll();
    }

}

?>