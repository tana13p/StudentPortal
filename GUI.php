<?php
require_once 'includes/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Data Interaction</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 500px;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s ease-in-out;
        }
        .container:hover {
            transform: translateY(-5px);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
            text-align: left;
            font-size: 16px;
        }
        
        select,
        input[type="text"],
        input[type="email"],
        input[type="date"]{
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        select:focus,
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus {
            outline: none;
            border-color: #4CAF50;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 16px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Information</h2>
        <form method="post" action="process_data.php">
            <label>Select Registration Type:</label>
            <select name="registration_type">
                <option value="existing">Already Registered</option>
                <option value="new">New Registration</option>
            </select>
            <br><br>
            <label>Role:</label>
            <select name="role">
                <option value="student">Student</option>
                <option value="Professor">Professor</option>
            </select>
            <br><br>
            <label>ID:</label>
            <input type="text" name="id">
            <br><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>




