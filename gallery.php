<?php

class Gallery {

    private $conn;
    private $table = "gallery";

    public $id;
    public $title;
    public $filename;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Vsetky fotky
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Jedna fotka podla ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Pridaj fotku
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (title, filename) 
                  VALUES (?, ?)";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));

        if($stmt->execute([
            $this->title,
            $this->filename
        ])) {
            return true;
        }
        return false;
    }

    // Zmaz fotku
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        if($stmt->execute([$this->id])) {
            return true;
        }
        return false;
    }
}