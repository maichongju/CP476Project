   <?php

class DbConnect
{
    private $conn = null;
    public function __construct()
    {
        // Read database settings from setting file
        if ($settings = parse_ini_file("config.ini", TRUE)){
            $dsn = $settings['database']['dsn'];
            $usr = $settings['database']['usr'];
            $pwd = $settings['database']['pwd'];
            // Define the options array
            $options = array( PDO::ATTR_TIMEOUT => 5,PDO::ATTR_PERSISTENT => true,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_FOUND_ROWS => true );
            // Connect to the Database
            $this->conn = new PDO($dsn,$usr,$pwd,$options);
        }else{
            // Setting file can not find 
            throw new exception("ERROR: Unable to open settings file.");
        }
    }

    public function getConnection(){
        return ($this->conn);
    }
    
    public function testConnection(){
        return ($this->conn === null);
    }
    
    public function closeConnection(){
        $this->conn = null;
    }
}


?>
