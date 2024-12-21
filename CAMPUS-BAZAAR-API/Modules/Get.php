<?php
include_once "Common.php";

class Get extends Common {
    protected $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getLogs($date){
        $filename = "./logs/" . $date . ".log";
        
        $file = file_get_contents("./logs/$filename");
        $logs = explode(PHP_EOL, $file);

        
        $logs = array();
        try{
            $file = new SplFileObject($filename);
            while(!$file->eof()){
                array_push($logs, $file->fgets());
            }
            $remarks = "success";
            $message = "Successfully retrieved logs.";
        }
        catch(Exception $e){
            $remarks = "failed";
            $message = $e->getMessage();
        }
        

        return $this->generateResponse(array("logs"=>$logs), $remarks, $message, 200);
    }
    
    

    private function fetchAllRecords($tableName) {
        $sqlString = "SELECT * FROM " . $tableName;
        $data = [];
        $errmsg = "";
        $code = 0;

        $this->logger("User", "GET", "Fetching all records from table: $tableName");

        try {
            if ($result = $this->pdo->query($sqlString)->fetchAll()) {
                foreach ($result as $record) {
                    array_push($data, $record);
                }
                $result = null;
                $code = 200;
                $this->logger("User", "GET", "Successfully fetched records from table: $tableName");
                return ["code" => $code, "data" => $data];
            } else {
                $errmsg = "No data found";
                $code = 404;
                $this->logger("User", "GET", "No data found in table: $tableName");
            }
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 403;
            $this->logger("User", "GET", "Failed to fetch records from table: $tableName. Error: $errmsg");
        }
        return ["code" => $code, "errmsg" => $errmsg];
    }

    public function getCategories($category_id = null) {
        $this->logger("User", "GET", "Fetching category records with ID: " . ($category_id ?? "ALL"));
        $result = $this->fetchRecordsById("categories", "category_id", $category_id);
        if ($result['code'] == 200) {
            $this->logger("User", "GET", "Successfully fetched category records.");
            return $this->generateResponse($result['data'], "success", "Successfully retrieved records.", $result['code']);
        }
        $this->logger("User", "GET", "Failed to fetch category records. Error: " . $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    public function getItems($item_id = null) {
        $this->logger("User", "GET", "Fetching item records with ID: " . ($item_id ?? "ALL"));
        $result = $this->fetchRecordsById("items", "item_id", $item_id);
        if ($result['code'] == 200) {
            $this->logger("User", "GET", "Successfully fetched item records.");
            return $this->generateResponse($result['data'], "success", "Successfully retrieved records.", $result['code']);
        }
        $this->logger("User", "GET", "Failed to fetch item records. Error: " . $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    public function getItem_images($image_id = null) {
        $this->logger("User", "GET", "Fetching item image records with ID: " . ($image_id ?? "ALL"));
        $result = $this->fetchRecordsById("item_images", "image_id", $image_id);
        if ($result['code'] == 200) {
            $this->logger("User", "GET", "Successfully fetched item image records.");
            return $this->generateResponse($result['data'], "success", "Successfully retrieved records.", $result['code']);
        }
        $this->logger("User", "GET", "Failed to fetch item image records. Error: " . $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    public function getMessages($message_id = null) {
        $this->logger("User", "GET", "Fetching message records with ID: " . ($message_id ?? "ALL"));
        $result = $this->fetchRecordsById("messages", "message_id", $message_id);
        if ($result['code'] == 200) {
            $this->logger("User", "GET", "Successfully fetched message records.");
            return $this->generateResponse($result['data'], "success", "Successfully retrieved records.", $result['code']);
        }
        $this->logger("User", "GET", "Failed to fetch message records. Error: " . $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    public function getTransactions($transaction_id = null) {
        $this->logger("User", "GET", "Fetching transaction records with ID: " . ($transaction_id ?? "ALL"));
        $result = $this->fetchRecordsById("transactions", "transaction_id", $transaction_id);
        if ($result['code'] == 200) {
            $this->logger("User", "GET", "Successfully fetched transaction records.");
            return $this->generateResponse($result['data'], "success", "Successfully retrieved records.", $result['code']);
        }
        $this->logger("User", "GET", "Failed to fetch transaction records. Error: " . $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    public function getUsers($user_id = null) {
        $this->logger("User", "GET", "Fetching user records with ID: " . ($user_id ?? "ALL"));
        $result = $this->fetchRecordsById("users", "user_id", $user_id);
        if ($result['code'] == 200) {
            $this->logger("User", "GET", "Successfully fetched user records.");
            return $this->generateResponse($result['data'], "success", "Successfully retrieved records.", $result['code']);
        }
        $this->logger("User", "GET", "Failed to fetch user records. Error: " . $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    private function fetchRecordsById($tableName, $idColumn, $id = null) {
        $sqlString = "SELECT * FROM " . $tableName;
        if ($id !== null) {
            $sqlString .= " WHERE " . $idColumn . "= :id";
        }

        $data = [];
        $errmsg = "";
        $code = 0;

        $this->logger("User", "GET", "Executing query on table: $tableName with ID: " . ($id ?? "ALL"));

        try {
            $stmt = $this->pdo->prepare($sqlString);
            if ($id !== null) {
                $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
            }
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            if ($result) {
                foreach ($result as $record) {
                    array_push($data, $record);
                }
                $code = 200;
                $this->logger("User", "GET", "Query executed successfully on table: $tableName.");
                return ["code" => $code, "data" => $data];
            } else {
                $errmsg = "No data found";
                $code = 404;
                $this->logger("User", "GET", "No data found for table: $tableName.");
            }
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 403;
            $this->logger("User", "GET", "Query failed on table: $tableName. Error: $errmsg");
        }
        return ["code" => $code, "errmsg" => $errmsg];
    }
}
