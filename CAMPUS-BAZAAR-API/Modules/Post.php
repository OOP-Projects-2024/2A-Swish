<?php
include_once "Common.php";

class Post extends Common {
    protected $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Method to handle posting categories
    public function postCategories($body) {
        $result = $this->postData("categories", (array) $body, $this->pdo);
        if ($result['code'] == 200) {
            $this->logger("test_user", "POST", "Created a new category record.");
            return $this->generateResponse(null, "success", "Category successfully added.", 200);
        }
        $this->logger("test_user", "POST", "Failed to create category: " . $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    // Method to handle posting items
    public function postItems($body) {
        $result = $this->postData("items", (array) $body, $this->pdo);
        if ($result['code'] == 200) {
            $this->logger("test_user", "POST", "Created a new item record.");
            return $this->generateResponse(null, "success", "Item successfully added.", 200);
        }
        $this->logger("test_user", "POST", "Failed to create item: " . $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    // Method to handle posting item_images
    public function postItem_images($body) {
        $result = $this->postData("item_images", (array) $body, $this->pdo);
        if ($result['code'] == 200) {
            $this->logger("test_user", "POST", "Added a new item image.");
            return $this->generateResponse(null, "success", "Item image successfully added.", 200);
        }
        $this->logger("test_user", "POST", "Failed to add item image: " . $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    // Method to handle posting messages
    public function postMessages($body) {
        $result = $this->postData("messages", (array) $body, $this->pdo);
        if ($result['code'] == 200) {
            $this->logger("test_user", "POST", "Sent a new message.");
            return $this->generateResponse(null, "success", "Message successfully sent.", 200);
        }
        $this->logger("test_user", "POST", "Failed to send message: " . $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    // Method to handle posting transactions
    public function postTransactions($body) {
        $result = $this->postData("transactions", (array) $body, $this->pdo);
        if ($result['code'] == 200) {
            $this->logger("test_user", "POST", "Created a new transaction record.");
            return $this->generateResponse(null, "success", "Transaction successfully added.", 200);
        }
        $this->logger("test_user", "POST", "Failed to create transaction: " . $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    // Method to handle posting users
    public function postUsers($body) {
        $result = $this->postData("users", (array) $body, $this->pdo);
        if ($result['code'] == 200) {
            $this->logger("test_user", "POST", "Created a new user record.");
            return $this->generateResponse(null, "success", "User successfully added.", 200);
        }
        $this->logger("test_user", "POST", "Failed to create user: " . $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }
}
