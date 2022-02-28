<?php

namespace Blog\Models;

use Blog\Config\Database;
use PDO;
use PDOException;

class Post 
{
    public $id;

    public $title;

    public $content;

    public $userId;

    public function save() {
        // connect
        $host=Database::HOST_NAME;
        $dbname=Database::DB_NAME;

        try {
            $dsn="mysql:host=$host;dbname=$dbname";
            $conn = new PDO($dsn, Database::USERNAME, Database::PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // insert sql
            $sql = "Insert into posts(title, content, user_id) values (:title, :content, :userID)";
            $stmt = $conn->prepare($sql);            
            $stmt->bindParam(':title', $this->title);            
            $stmt->bindParam(':content', $this->content);            
            $stmt->bindParam(':userID', $this->userId);
            $stmt->execute();
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function update()
    {
        // connect
        $host=Database::HOST_NAME;
        $dbname=Database::DB_NAME;

        try {
            $dsn="mysql:host=$host;dbname=$dbname";
            $conn = new PDO($dsn, Database::USERNAME, Database::PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // insert sql
            $sql = "update posts set title=:title, content=:content, user_id=:userID where id=:id";
            $stmt = $conn->prepare($sql);            
            $stmt->bindParam(':title', $this->title);            
            $stmt->bindParam(':content', $this->content);            
            $stmt->bindParam(':userID', $this->userId);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function all() {
        $posts = [];
        // connect
        $host=Database::HOST_NAME;
        $dbname=Database::DB_NAME;     

        $dsn="mysql:host=$host;dbname=$dbname";
        $conn = new PDO($dsn, Database::USERNAME, Database::PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("Select * from posts");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        foreach($stmt->fetchAll() as $row) {
            $posts[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'content' => $row['content'],
                'user_id' => $row['user_id'],
            ];
        }

        return $posts;
    }

    public static function show($id) { 
        $post = null;
        // connect
        $host=Database::HOST_NAME;
        $dbname=Database::DB_NAME;     

        $dsn="mysql:host=$host;dbname=$dbname";
        $conn = new PDO($dsn, Database::USERNAME, Database::PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("Select * from posts where id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();
        
        $post = new Post;
        $post->id = $row['id'];
        $post->title = $row['title'];
        $post->content = $row['content'];
        $post->userId = $row['user_id'];
        
        return $post;
    }
}