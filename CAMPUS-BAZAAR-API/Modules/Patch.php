<?php
include_once "Common.php";

class Patch extends Common {
    protected $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function patchCategories($body, $id) {
        return $this->processPatch("categories", $body, "category_id", $id);
    }

    public function patchItems($body, $id) {
        return $this->processPatch("items", $body, "item_id", $id);
    }

    public function patchItem_images($body, $id) {
        return $this->processPatch("item_images", $body, "image_id", $id);
    }

    public function patchMessages($body, $id) {
        return $this->processPatch("messages", $body, "message_id", $id);
    }

    public function patchTransactions($body, $id) {
        return $this->processPatch("transactions", $body, "transaction_id", $id);
    }

    public function patchUsers($body, $id) {
        return $this->processPatch("users", $body, "user_id", $id);
    }

    public function archiveUsers($id) {
        return $this->processArchive("users", "is_active", "user_id", $id);
    }

    private function processPatch($table, $body, $idColumn, $id) {
        $columns = array_keys((array)$body); // Extract keys as column names
        $values = array_values((array)$body); // Extract values to be updated
        array_push($values, $id); // Add ID to the values array for WHERE clause

        // Generate the SQL statement dynamically
        $placeholders = implode("=?, ", $columns) . "=?";
        $sqlString = "UPDATE $table SET $placeholders WHERE $idColumn = ?";

        try {
            $stmt = $this->pdo->prepare($sqlString);
            $stmt->execute($values); // Execute the query with provided values
            return $this->generateResponse(null, "success", "Record updated successfully.", 200);
        } catch (\PDOException $e) {
            return $this->generateResponse(null, "failed", $e->getMessage(), 400);
        }
    }

    private function processArchive($table, $archiveColumn, $idColumn, $id) {
        $sqlString = "UPDATE $table SET $archiveColumn = 1 WHERE $idColumn = ?";
        try {
            $stmt = $this->pdo->prepare($sqlString);
            $stmt->execute([$id]); // Archive the record by updating the archive column
            return $this->generateResponse(null, "success", "Record archived successfully.", 200);
        } catch (\PDOException $e) {
            return $this->generateResponse(null, "failed", $e->getMessage(), 400);
        }
    }
}
?>
