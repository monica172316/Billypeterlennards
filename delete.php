<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    try {
        // Get profile picture filename
        $stmt = $pdo->prepare("SELECT profile_picture FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();

        // Delete record
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        // Delete profile picture
        if ($user['profile_picture']) {
            $filePath = 'uploads/' . $user['profile_picture'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>