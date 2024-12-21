<?php 

// Import necessary files
require_once "./config/database.php";
require_once "./Modules/Get.php";
require_once "./Modules/Post.php";
require_once "./Modules/Patch.php";
require_once "./Modules/Delete.php";
require_once "./Modules/Authentication.php";
require_once "./Modules/Crypt.php";

header('Content-Type: application/json'); // Ensure JSON response

$db = new Connection();
$pdo = $db->connect();

// Instantiate required classes
$post = new Post($pdo);
$get = new Get($pdo);
$patch = new Patch($pdo);
$delete = new Delete($pdo);
$authentication = new Authentication($pdo);
$crypt = new Crypt();

// Retrieve and split request URL
if (isset($_REQUEST['request'])) {
    $request = explode("/", $_REQUEST['request']);
} else {
    echo json_encode(["error" => "URL does not exist."]);
    exit;
}

// Apply authorization check to all routes except login and register
if (!in_array($request[0], ["login", "user"])) {
    $authentication->isAuthorized(); // Check authorization
}

// Handle HTTP request methods
switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if (isset($request[0])) {
            switch ($request[0]) {
                case "categories":
                    if (count($request) > 1) {
                        echo json_encode($get->getCategories($request[1]));
                    } else {
                        echo json_encode($get->getCategories());
                    }
                    break;

                case "items":
                    if (count($request) > 1) {
                        echo json_encode($get->getItems($request[1]));
                    } else {
                        echo json_encode($get->getItems());
                    }
                    break;

                case "item_images":
                    if (count($request) > 1) {
                        echo json_encode($get->getItem_images($request[1]));
                    } else {
                        echo json_encode($get->getItem_images());
                    }
                    break;

                case "messages":
                    if (count($request) > 1) {
                        echo json_encode($get->getMessages($request[1]));
                    } else {
                        echo json_encode($get->getMessages());
                    }
                    break;

                case "transactions":
                    if (count($request) > 1) {
                        echo json_encode($get->getTransactions($request[1]));
                    } else {
                        echo json_encode($get->getTransactions());
                    }
                    break;

                case "users":
                    if (count($request) > 1) {
                        echo json_encode($get->getUsers($request[1]));
                    } else {
                        echo json_encode($get->getUsers());
                    }
                    break;

                case "logs":
                    echo json_encode($get->getLogs($request[1] ?? date("Y-m-d")));
                    break;

                default:
                    http_response_code(401);
                    echo json_encode(["error" => "This is an invalid endpoint."]);
                    break;
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "No endpoint specified for GET request."]);
        }
        break;

    case "POST":
        $body = json_decode(file_get_contents("php://input"));
        if (!isset($request[0])) {
            http_response_code(400);
            echo json_encode(["error" => "No endpoint specified for POST request."]);
            break;
        }

        switch ($request[0]) {
            case "login":
                echo json_encode($authentication->login($body));
                break;

            case "user":
                echo json_encode($authentication->addAccount($body));
                break;

            case "categories":
                echo json_encode($post->postCategories($body));
                break;

            case "items":
                echo json_encode($post->postItems($body));
                break;

            case "item_images":
                echo json_encode($post->postItem_images($body));
                break;

            case "messages":
                echo json_encode($post->postMessages($body));
                break;

            case "transactions":
                echo json_encode($post->postTransactions($body));
                break;

            case "users":
                echo json_encode($post->postUsers($body));
                break;

            default:
                http_response_code(401);
                echo json_encode(["error" => "This is an invalid endpoint."]);
                break;
        }
        break;

    case "PATCH":
        switch ($request[0]) {
            case "users":
                echo json_encode($patch->patchUsers(json_decode(file_get_contents("php://input")), $request[1]));
                break;

            case "categories":
                echo json_encode($patch->patchCategories(json_decode(file_get_contents("php://input")), $request[1]));
                break;

            case "items":
                echo json_encode($patch->patchItems(json_decode(file_get_contents("php://input")), $request[1]));
                break;

            case "item_images":
                echo json_encode($patch->patchItem_images(json_decode(file_get_contents("php://input")), $request[1]));
                break;

            case "messages":
                echo json_encode($patch->patchMessages(json_decode(file_get_contents("php://input")), $request[1]));
                break;

            case "transactions":
                echo json_encode($patch->patchTransactions(json_decode(file_get_contents("php://input")), $request[1]));
                break;

            default:
                http_response_code(401);
                echo json_encode(["error" => "This is an invalid endpoint."]);
                break;
        }
        break;

    case "DELETE":
        switch ($request[0]) {
            case "categories":
                echo json_encode($delete->deleteCategories($request[1]));
                break;

            case "items":
                echo json_encode($delete->deleteItems($request[1]));
                break;

            case "item_images":
                echo json_encode($delete->deleteItem_images($request[1]));
                break;

            case "messages":
                echo json_encode($delete->deleteMessages($request[1]));
                break;

            case "transactions":
                echo json_encode($delete->deleteTransactions($request[1]));
                break;

            case "users":
                echo json_encode($delete->deleteUsers($request[1]));
                break;

            case "archiveUsers":
                echo json_encode($patch->archiveUsers($request[1]));
                break;

            default:
                http_response_code(401);
                echo json_encode(["error" => "This is an invalid endpoint."]);
                break;
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(["error" => "Invalid Request Method."]);
        break;
}
?>
