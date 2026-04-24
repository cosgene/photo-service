<?php

class UserRepository {

    private PDO $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function findByVkId($vkId) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE vk_id = ?");
        $stmt->execute([$vkId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($vkId) {
        $stmt = $this->db->prepare("
            INSERT INTO users (vk_id) 
            VALUES (?) 
            ON DUPLICATE KEY UPDATE vk_id = vk_id
        ");
        $stmt->execute([$vkId]);
    }

    public function setRole($vkId, $role) {
        $stmt = $this->db->prepare("
            UPDATE users 
            SET role = ? 
            WHERE vk_id = ?
        ");
        $stmt->execute([$role, $vkId]);
    }
}
