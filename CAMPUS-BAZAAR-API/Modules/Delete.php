<?php
include_once "Common.php";

class Delete extends Common {
    protected $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function deleteCategories($id) {
        $this->logger("User", "DELETE", "Attempting to delete category with ID: $id");
        $result = $this->processDelete("categories", "category_id", $id);
        $this->logResult($result, "category", $id);
        return $result;
    }

    public function deleteItems($id) {
        $this->logger("User", "DELETE", "Attempting to delete related item_images for item_id: $id");
        $sqlString = "DELETE FROM item_images WHERE item_id = ?";
        try {
            $stmt = $this->pdo->prepare($sqlString);
            $stmt->execute([$id]);
            $this->logger("User", "DELETE", "Successfully deleted related item_images for item_id: $id");
        } catch (\PDOException $e) {
            $this->logger("User", "DELETE", "Failed to delete related item_images for item_id: $id. Error: " . $e->getMessage());
            return $this->generateResponse(null, "failed", $e->getMessage(), 400);
        }

        $this->logger("User", "DELETE", "Attempting to delete item with ID: $id");
        $result = $this->processDelete("items", "item_id", $id);
        $this->logResult($result, "item", $id);
        return $result;
    }

    public function deleteItem_images($id) {
        $this->logger("User", "DELETE", "Attempting to delete item image with ID: $id");
        $result = $this->processDelete("item_images", "image_id", $id);
        $this->logResult($result, "item image", $id);
        return $result;
    }

    public function deleteMessages($id) {
        $this->logger("User", "DELETE", "Attempting to delete message with ID: $id");
        $result = $this->processDelete("messages", "message_id", $id);
        $this->logResult($result, "message", $id);
        return $result;
    }

    public function deleteTransactions($id) {
        $this->logger("User", "DELETE", "Attempting to delete transaction with ID: $id");
        $result = $this->processDelete("transactions", "transaction_id", $id);
        $this->logResult($result, "transaction", $id);
        return $result;
    }

    public function deleteUsers($id) {
        $this->logger("User", "DELETE", "Attempting to delete user with ID: $id");
        $result = $this->processDelete("users", "user_id", $id);
        $this->logResult($result, "user", $id);
        return $result;
    }

    private function processDelete($table, $idColumn, $id) {
        $sqlString = "DELETE FROM $table WHERE $idColumn = ?";
        try {
            $stmt = $this->pdo->prepare($sqlString);
            $stmt->execute([$id]);
            return $this->generateResponse(null, "success", "Record deleted successfully.", 200);
        } catch (\PDOException $e) {
            return $this->generateResponse(null, "failed", $e->getMessage(), 400);
        }
    }

    private function logResult($result, $entity, $id) {
        if ($result['status']['remark'] === "success") {
            $this->logger("User", "DELETE", "Successfully deleted $entity with ID: $id");
        } else {
            $this->logger("User", "DELETE", "Failed to delete $entity with ID: $id");
        }
    }
}
?>
