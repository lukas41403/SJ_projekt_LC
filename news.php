<?php

class News {

    private $conn;
    private $table = "news";

    public $id;
    public $title;
    public $content;
    public $image;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Vsetky clanky
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Jeden clanek podla ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Posledne clanky pre homepage
    public function getLatest($limit = 3) {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC LIMIT " . (int)$limit;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Pridaj clanek
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (title, content, image) 
                  VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));

        if($stmt->execute([
            $this->title,
            $this->content,
            $this->image
        ])) {
            return true;
        }
        return false;
    }

    // Uprav clanek
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET title = ?, content = ?, image = ?
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));

        if($stmt->execute([
            $this->title,
            $this->content,
            $this->image,
            $this->id
        ])) {
            return true;
        }
        return false;
    }

    // Zmaz clanek
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        if($stmt->execute([$this->id])) {
            return true;
        }
        return false;
    }
}