<?php


namespace Blog\Models;

use Blog\Config\Database;
use PDO;
use PDOException;

class User 
{
    public $id;
   
    public $name;
    public $email;
    public $password;

    public function create() 
    {
         // connect
         $host=Database::HOST_NAME;
         $dbname=Database::DB_NAME;
 
         try {
             $dsn="mysql:host=$host;dbname=$dbname";
             $conn = new PDO($dsn, Database::USERNAME, Database::PASSWORD);
             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             // insert sql
             $sql = "Insert into users(email, password, name) values (:email, :password, :name)";
             $stmt = $conn->prepare($sql);            
             $stmt->bindParam(':email', $this->email);            
             $stmt->bindParam(':password', $this->password);            
             $stmt->bindParam(':name', $this->name);
             $stmt->execute();
         } catch(PDOException $e) {
             echo "Connection failed: " . $e->getMessage();
         }
    }

    public static function attempt(array $credentials)
    {
        // connect
        $host=Database::HOST_NAME;
        $dbname=Database::DB_NAME;

        try {
            $dsn="mysql:host=$host;dbname=$dbname";
            $conn = new PDO($dsn, Database::USERNAME, Database::PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // insert sql
            $sql = "Select * from users where email=:email and password = :password";
            $stmt = $conn->prepare($sql);            
            $stmt->bindParam(':email', $credentials['email']);            
            $stmt->bindParam(':password', $credentials['password']);            
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            
            $user = new User;
            $user->id = $row['id'];
            $user->email = $row['email'];
            $user->name = $row['name'];
            
            return $user;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}