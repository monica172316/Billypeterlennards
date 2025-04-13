<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $profile_picture = null;

    // Handle file upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $tempName = $_FILES['profile_picture']['tmp_name'];
        $extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $newFilename = uniqid() . '.' . $extension;
        $destination = $uploadDir . $newFilename;

        if (move_uploaded_file($tempName, $destination)) {
            $profile_picture = $newFilename;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, profile_picture) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $profile_picture]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>