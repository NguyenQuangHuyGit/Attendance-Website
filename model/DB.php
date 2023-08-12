<?php
    class DB{
        private $host = 'localhost';
        private $username = "root";
        private $password = "270402";
        private $database = "ql_diemdanh";
        private $conn;

        protected function __construct()
        {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->database . ";charset=utf8";
            try{
                $this->conn = new PDO($dsn, $this->username, $this->password);
            }catch(PDOException $ex){
                die("Lỗi kết nối!");
            }
        }

        protected function getStatement($sql){
            $statement = $this->conn->prepare($sql); 
            return $statement;
        }

        protected function pdo(string $sql, array $arguments = null)
        {
            try{
                if (!$arguments) {                   
                    return $this->conn->query($sql);      
                }
                $statement = $this->conn->prepare($sql);    
                $statement->execute($arguments);     
                return $statement;                
            }catch(PDOException $ex){
                echo $ex->getMessage();
            }
        }

        protected function getLastInsertId(){
            $lastID = $this->conn->lastInsertId();
            return $lastID;
        }
    }
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i');
?>

