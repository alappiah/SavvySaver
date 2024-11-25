<?php
header("Content-Type: application/json");
require 'db.php'; // Database connection file

// Helper function to parse JSON request body
function getJsonBody() {
    return json_decode(file_get_contents('php://input'), true);
}

// Router
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET['endpoint'] == 'users') {
        getUsers();
    } elseif ($_GET['endpoint'] == 'food_items') {
        getFoodItemsByUserId($_GET['user_id']);
    } elseif ($_GET['endpoint'] == 'notifications') {
        getNotificationsByUserId($_GET['user_id']);
    } elseif ($_GET['endpoint'] == 'recipes') {
        getRecipes();
    } elseif ($_GET['endpoint'] == 'daily_tip') {
        getDailyTip();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = getJsonBody();
    if ($_GET['endpoint'] == 'users') {
        addUser($data);
    } elseif ($_GET['endpoint'] == 'food_items') {
        addFoodItem($data);
    } elseif ($_GET['endpoint'] == 'feedback') {
        addFeedback($data);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"), $data);
    if ($_GET['endpoint'] == 'notifications') {
        markNotificationAsSeen($data['notification_id']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ($_GET['endpoint'] == 'food_items') {
        deleteFoodItem($_GET['item_id']);
    }
}

// Functions

function addUser($data) {
    global $pdo;
    $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $stmt->execute([':username' => $data['username'], ':email' => $data['email'], ':password' => $hashed_password]);
    echo json_encode(["user_id" => $pdo->lastInsertId()]);
}

function getUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM users");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function getFoodItemsByUserId($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM food_items WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function addFoodItem($data) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO food_items (user_id, item_name, expiration_date, quantity) VALUES (:user_id, :item_name, :expiration_date, :quantity)");
    $stmt->execute([':user_id' => $data['user_id'], ':item_name' => $data['item_name'], ':expiration_date' => $data['expiration_date'], ':quantity' => $data['quantity']]);
    echo json_encode(["item_id" => $pdo->lastInsertId()]);
}

function deleteFoodItem($item_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM food_items WHERE item_id = :item_id");
    $stmt->execute([':item_id' => $item_id]);
    echo json_encode(["status" => "success"]);
}

function getNotificationsByUserId($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function markNotificationAsSeen($notification_id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE notifications SET seen = 1 WHERE notification_id = :notification_id");
    $stmt->execute([':notification_id' => $notification_id]);
    echo json_encode(["status" => "success"]);
}

function getRecipes() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM recipes");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function getDailyTip() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM daily_tips ORDER BY RAND() LIMIT 1");
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

function addFeedback($data) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO feedback (user_id, feedback_text) VALUES (:user_id, :feedback_text)");
    $stmt->execute([':user_id' => $data['user_id'], ':feedback_text' => $data['feedback_text']]);
    echo json_encode(["status" => "success"]);
}
?>
