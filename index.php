<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-top: 30px;
        }
        form {
            margin-bottom: 30px;
            padding: 25px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        label {
            display: inline-block;
            width: 120px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type=text], input[type=email] {
            padding: 8px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type=submit] {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type=submit]:hover {
            background-color: #2980b9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9e9e9;
        }
        .profile-pic {
            max-width: 50px;
            height: auto;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .profile-pic:hover {
            transform: scale(1.1);
        }
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.9);
        }
        .modal-content {
            margin: auto;
            display: block;
            max-width: 80%;
            max-height: 80%;
        }
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }
        .close:hover {
            color: #bbb;
        }
        .action-btn {
            background-color: #e74c3c;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .action-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center; color: #2c3e50; border-bottom: none; margin-bottom: 30px;">USER DATABASE MANAGEMENT SYSTEM</h2>
        
        <form action="process.php" method="POST" enctype="multipart/form-data">
            <label>Name:</label>
            <input type="text" name="name" required><br><br>
            
            <label>Email:</label>
            <input type="email" name="email" required><br><br>
            
            <label>Profile Picture:</label>
            <input type="file" name="profile_picture" accept="image/*"><br><br>
            
            <input type="submit" value="Add User" style="margin-left: 125px;">
        </form>

        <h2>User List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Profile Picture</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            <?php
            $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>";
                if ($row['profile_picture']) {
                    echo "<img class='profile-pic' src='uploads/{$row['profile_picture']}' alt='Profile Picture' onclick=\"openModal('uploads/{$row['profile_picture']}')\">";
                } else {
                    echo "No image";
                }
                echo "</td>
                    <td>{$row['created_at']}</td>
                    <td>
                        <form action='delete.php' method='POST' style='display: inline;'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <input type='submit' class='action-btn' value='Delete'>
                        </form>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </div>

    <!-- The Modal for image preview -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        // Function to open the modal with the clicked image
        function openModal(imageSrc) {
            var modal = document.getElementById('imageModal');
            var modalImg = document.getElementById('modalImage');
            modal.style.display = "block";
            modalImg.src = imageSrc;
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('imageModal').style.display = "none";
        }

        // Close the modal when clicking outside the image
        window.onclick = function(event) {
            var modal = document.getElementById('imageModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>