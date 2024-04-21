<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>課程搜尋</title>
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
    <?php
    if(isset($_SESSION['student_id'])) {
        // 學生已登入
        echo "課程搜尋";
        // 在這裡加入課程搜尋的相關程式碼
        ?>
        <form name="form1" method="post" action="action.php">
            課程號碼輸入欄位: <input name="MyHead">
            <input type="hidden" name="student_id" value="<?php echo $_SESSION['student_id']; ?>">
            <input type="submit" value="送出">
        </form>
        <form action="logout.php" method="post">
            <input type="submit" value="登出">
        </form>
        <?php
    } else {
        // 學生未登入，導向回登入頁面
        header("Location: index.php");
        exit();
    }
    ?>
</div>

</body>
</html>
