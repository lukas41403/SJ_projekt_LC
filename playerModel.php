<?php

class Player {

    private $conn;
    private $table = "players";

    public $id;
    public $name;
    public $position;
    public $jersey_number;
    public $date_of_birth;
    public $photo;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY position, name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (name, position, jersey_number, date_of_birth, photo) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->position = htmlspecialchars(strip_tags($this->position));
        if($stmt->execute([
            $this->name,
            $this->position,
            $this->jersey_number,
            $this->date_of_birth,
            $this->photo
        ])) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET name = ?, position = ?, jersey_number = ?, 
                      date_of_birth = ?, photo = ?
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->position = htmlspecialchars(strip_tags($this->position));
        if($stmt->execute([
            $this->name,
            $this->position,
            $this->jersey_number,
            $this->date_of_birth,
            $this->photo,
            $this->id
        ])) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt->execute([$this->id])) {
            return true;
        }
        return false;
    }
}