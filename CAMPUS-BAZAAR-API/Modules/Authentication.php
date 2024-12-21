<?php
class Authentication {

    protected $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function isAuthorized() {
        // Compare request token to database token
        $headers = array_change_key_case(getallheaders(), CASE_LOWER);
    
        if (!isset($headers['authorization'], $headers['x-auth-user'])) {
            http_response_code(401);
            echo "Unauthorized.";
            exit; // Stop further script execution
        }
    
        if ($this->getToken($headers['x-auth-user']) !== $headers['authorization']) {
            http_response_code(401);
            echo "Unauthorized.";
            exit; // Stop further script execution
        }
    
        return true; // Authorized
    }

    private function getToken($username) {
        $sqlString = "SELECT token FROM accounts WHERE username=?";
        try {
            $stmt = $this->pdo->prepare($sqlString);
            $stmt->execute([$username]);
            $result = $stmt->fetch();
            return $result ? $result['token'] : "";
        } catch (\PDOException $e) {
            error_log("Error fetching token: " . $e->getMessage());
            return "";
        }
    }

    private function generateHeader() {
        $header = [
            "typ" => "JWT",
            "alg" => "HS256",
            "app" => "CampusBazaar",
            "dev" => "Ysler Ivan"
        ];
        return base64_encode(json_encode($header));
    }

    private function generatePayload($id, $username) {
        $payload = [
            "uid" => $id,
            "uc" => $username,
            "email" => "Ysler@gmail.com",
            "date" => date_create(),
            "exp" => date("Y-m-d H:i:s", strtotime("+1 day"))
        ];
        return base64_encode(json_encode($payload));
    }

    private function generateToken($id, $username) {
        $header = $this->generateHeader();
        $payload = $this->generatePayload($id, $username);
        $signature = hash_hmac("sha256", "$header.$payload", TOKEN_KEY);
        return "$header.$payload." . base64_encode($signature);
    }

    private function isSamePassword($inputPassword, $existingHash) {
        $hash = crypt($inputPassword, $existingHash);
        return $hash === $existingHash;
    }

    private function encryptPassword($password) {
        $hashFormat = "$2y$10$"; // Blowfish
        $saltLength = 22;
        $salt = $this->generateSalt($saltLength);
        return crypt($password, $hashFormat . $salt);
    }

    private function generateSalt($length) {
        $urs = md5(uniqid(mt_rand(), true));
        $b64String = base64_encode($urs);
        $mb64String = str_replace("+", ".", $b64String);
        return substr($mb64String, 0, $length);
    }

    public function saveToken($token, $username) {
        try {
            $sqlString = "UPDATE accounts SET token=? WHERE username=?";
            $stmt = $this->pdo->prepare($sqlString);
            $stmt->execute([$token, $username]);
            return ["data" => null, "code" => 200];
        } catch (\PDOException $e) {
            error_log("Error saving token: " . $e->getMessage());
            return ["errmsg" => $e->getMessage(), "code" => 400];
        }
    }

    public function login($body) {
        $username = $body->username ?? '';
        $password = $body->password ?? '';

        try {
            $sqlString = "SELECT id, username, password, token FROM accounts WHERE username=?";
            $stmt = $this->pdo->prepare($sqlString);
            $stmt->execute([$username]);

            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch();
                if ($this->isSamePassword($password, $result['password'])) {
                    $token = $this->generateToken($result['id'], $result['username']);
                    $tokenArr = explode('.', $token);
                    $this->saveToken($tokenArr[2], $result['username']);

                    return [
                        "payload" => ["id" => $result['id'], "username" => $result['username'], "token" => $tokenArr[2]],
                        "remarks" => "success",
                        "message" => "Logged in successfully",
                        "code" => 200
                    ];
                }
                return [
                    "payload" => null,
                    "remarks" => "failed",
                    "message" => "Incorrect password",
                    "code" => 401
                ];
            }

            return [
                "payload" => null,
                "remarks" => "failed",
                "message" => "Username does not exist",
                "code" => 401
            ];
        } catch (\PDOException $e) {
            error_log("Error during login: " . $e->getMessage());
            return [
                "payload" => null,
                "remarks" => "failed",
                "message" => "An error occurred while logging in",
                "code" => 400
            ];
        }
    }

    public function addAccount($body) {
        $values = [];
        foreach ($body as $value) {
            $values[] = $value;
        }
        $values[2] = $this->encryptPassword($values[2]); // Encrypt the password

        try {
            $sqlString = "INSERT INTO accounts (user_id, username, password) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sqlString);
            $stmt->execute($values);
            return ["data" => null, "code" => 200];
        } catch (\PDOException $e) {
            error_log("Error adding account: " . $e->getMessage());
            return ["errmsg" => $e->getMessage(), "code" => 400];
        }
    }
}
