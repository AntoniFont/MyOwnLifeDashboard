<?php
class DatabaseManager
{
    //The default values.
    private $host = 'localhost';
    private $db = 'academicdashboard';
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
       $this->loadCredentials("/passwords/databaseCredentials.json");
       $this->openIfItWasClosed();
    }
    private function loadCredentials($credentialsDIR){
        try{
            //Why is php so weird? I have to use this to catch the error.
            //file_get_contents throws a warning if the file does not exist instead of an exception.
            set_error_handler(function ($severity, $message, $file, $line) { 
                //If a warning is thrown, turn it into an exception.
                throw new \ErrorException($message, $severity, $severity, $file, $line);
            });
            
            $json = file_get_contents($credentialsDIR);
            
            restore_error_handler(); //Restore the error handler to the default one.

            $credentials = json_decode($json, true);
            $this->db = $credentials["database"];
            $this->user = $credentials["user"];
            $this->pass = $credentials["password"];
        }catch(Exception $e){
            //do nothing, use the default values.
        }
    }

    public function useSpecialCredentials(){
        $this->loadCredentials("/passwords/specialSpotifyFeatureCredentials.json");
        $this->close(); //reopen
        $this->openIfItWasClosed();
    }

    public function query($queryString, $values)
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

    public function lastInsertID(){
        return intval($this->pdo->lastInsertId());
    }

    public function close()
    {
        $this->pdo = null;
    }
  
    public function openIfItWasClosed()
    {
        if ($this->pdo != null) {
            return;
        }
        try {
            $this->dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $this->pdo = new PDO($this->dsn, $this->user, $this->pass, $this->options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }    
    }

}

?>