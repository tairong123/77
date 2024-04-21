<!DOCTYPE html>
<html>
<head>
    <title>逢甲大學選課系統</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0; /* Light gray background */
            font-family: Arial, sans-serif; /* Font */
        }
        .container {
            text-align: center;
            background-color: #fff; /* White background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Box shadow for a slight elevation effect */
        }
        form {
            margin-top: 20px;
        }
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 200px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50; /* Green background */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }
        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green background on hover */
        }
    </style>
</head>
<body>

<div class="container">
    <h2>選課系統</h2>
    <form name="loginForm" method="post" action="action.php">
        學號: <input type="text" name="student_id"><br><br>
        <input type="submit" value="登入">
    </form>
</div>

</body>
</html>
