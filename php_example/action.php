<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>課程</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0; /* Light gray background */
            font-family: Arial, sans-serif; /* Font */
            overflow: auto;
        }
        .container {
            text-align: center;
            background-color: #fff; /* White background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Box shadow for a slight elevation effect */
            margin-bottom: 20px;
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
<?php
$dbhost = '127.0.0.1';
$dbuser = 'hj';
$dbpass = 'test1234';
$dbname = 'testdb';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error with MySQL connection');
mysqli_set_charset($conn, 'utf8');


// 處理所有學生的必選課程
$sql_students = "SELECT student_id FROM students";
$result_students = mysqli_query($conn, $sql_students);

while ($row = mysqli_fetch_assoc($result_students)) {
    $student_id = $row['student_id'];
    
    // 獲取學生的年級和系所
    $sql_student_info = "SELECT department, grade FROM students WHERE student_id = ?";
    $stmt_student_info = mysqli_prepare($conn, $sql_student_info);
    mysqli_stmt_bind_param($stmt_student_info, 'i', $student_id);
    mysqli_stmt_execute($stmt_student_info);
    $result_student_info = mysqli_stmt_get_result($stmt_student_info);
    $row_student_info = mysqli_fetch_assoc($result_student_info);
    $department = $row_student_info['department'];
    $grade = $row_student_info['grade'];
    mysqli_stmt_close($stmt_student_info);

    // 查找學生尚未選擇的必修課程
    $sql_course = "SELECT course_id, isoptional, credit FROM courses WHERE grade = ? AND department = ? AND isoptional = '必修' AND course_id NOT IN (SELECT course_id FROM student_courses WHERE student_id = ?)";
    $stmt_course = mysqli_prepare($conn, $sql_course);
    mysqli_stmt_bind_param($stmt_course, 'ssi', $grade, $department, $student_id);
    mysqli_stmt_execute($stmt_course);
    $result_course = mysqli_stmt_get_result($stmt_course);

    // 遍歷查詢結果
    while($row_course = mysqli_fetch_assoc($result_course)) {
        $course_id = $row_course['course_id'];
        $credit = $row_course['credit'];

        // 將學生尚未選擇的必修課程添加到 student_courses 表中
        $sql_add_student_course = "INSERT INTO student_courses (student_id, course_id) VALUES (?, ?)";
        $stmt_add_student_course = mysqli_prepare($conn, $sql_add_student_course);
        mysqli_stmt_bind_param($stmt_add_student_course, 'ii', $student_id, $course_id);
        mysqli_stmt_execute($stmt_add_student_course);
        mysqli_stmt_close($stmt_add_student_course);

        // 將必修的課程 flag 改為 true
        $sql_update_time = "UPDATE time SET flag = true WHERE course_id = ?";
        $stmt_update_time = mysqli_prepare($conn, $sql_update_time);
        mysqli_stmt_bind_param($stmt_update_time, 'i', $course_id);
        mysqli_stmt_execute($stmt_update_time);
        mysqli_stmt_close($stmt_update_time);

        // 將必修的課程學分加到學生的總學分中
        $sql_update_credit = "UPDATE students SET total_credit = total_credit + ? WHERE student_id = ?";
        $stmt_update_credit = mysqli_prepare($conn, $sql_update_credit);
        mysqli_stmt_bind_param($stmt_update_credit, 'ii', $credit, $student_id);
        mysqli_stmt_execute($stmt_update_credit);
        mysqli_stmt_close($stmt_update_credit);
    }
    mysqli_stmt_close($stmt_course);
}
mysqli_close($conn);
?>
<div class="container">
<?php
if(isset($_POST['student_id'])) {
    // 使用者已經登入
    $student_id = $_POST['student_id'];
    $_SESSION['student_id'] = $student_id;

    // 連接資料庫
    $dbhost = '127.0.0.1';
    $dbuser = 'hj';
    $dbpass = 'test1234';
    $dbname = 'testdb';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error with MySQL connection');
    mysqli_set_charset($conn, 'utf8');

    // 查詢學生的課程信息
    $sql_student_courses = "SELECT * FROM student_courses WHERE student_id = ?";
    $stmt_student_courses = mysqli_prepare($conn, $sql_student_courses);
    mysqli_stmt_bind_param($stmt_student_courses, 'i', $student_id);
    mysqli_stmt_execute($stmt_student_courses);
    $result_student_courses = mysqli_stmt_get_result($stmt_student_courses);

    // 檢查是否有課程信息
    if(mysqli_num_rows($result_student_courses) > 0) {
        // 顯示學生的課表
        echo '<div style="text-align: center; margin: auto; width: 100%;">';
        echo '<h2>學生課表</h2>';
        echo '<table border="1">';
        echo '<tr><th>課程代號</th><th>課程</th><th>時間段</th><th>星期</th></tr>';
        while($row_student_course = mysqli_fetch_assoc($result_student_courses)) {
            // 根據課程 ID 查詢課程的時間信息
            $course_id = $row_student_course['course_id'];
            $sql_course_time = "SELECT * FROM time WHERE course_id = ?";
            $stmt_course_time = mysqli_prepare($conn, $sql_course_time);
            mysqli_stmt_bind_param($stmt_course_time, 'i', $course_id);
            mysqli_stmt_execute($stmt_course_time);
            $result_course_time = mysqli_stmt_get_result($stmt_course_time);
            $course_times = array();
        while($row_course_time = mysqli_fetch_assoc($result_course_time)) {
            $course_times[] = $row_course_time;
        }
            
            $sql_course = "SELECT * FROM courses WHERE course_id = ?";
            $stmt_course = mysqli_prepare($conn, $sql_course);
            mysqli_stmt_bind_param($stmt_course, 'i', $course_id);
            mysqli_stmt_execute($stmt_course);
            $result_course = mysqli_stmt_get_result($stmt_course);
            $row_course = mysqli_fetch_assoc($result_course);

            // 顯示課程信息
            foreach ($course_times as $row_course_time) {
            echo '<tr>';
            echo '<td>' . $row_course['course_id'] . '</td>';
            echo '<td>' . $row_course['course_name'] . '</td>';
            echo '<td>' . $row_course_time['course_time'] . '</td>';
            echo '<td>' . $row_course_time['course_week'] . '</td>';
            echo '</tr>';
            }
            mysqli_stmt_close($stmt_course);
            
            mysqli_stmt_close($stmt_course_time);
            
        }
        echo '</table>';
        echo '</div>';
    } else {
        // 學生尚未選課，顯示提示訊息
        echo '您尚未選課。';
    }

    mysqli_stmt_close($stmt_student_courses);


    // 關閉資料庫連接
    mysqli_close($conn);
    if(isset($_POST['MyHead'])) {
        $MyHead = $_POST['MyHead'];

        $dbhost = '127.0.0.1';
        $dbuser = 'hj';
        $dbpass = 'test1234';
        $dbname = 'testdb';
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error with MySQL connection');
        mysqli_set_charset($conn, 'utf8'); 

        $sql = "SELECT DISTINCT courses.*, time.flag FROM courses JOIN time ON courses.course_id = time.course_id WHERE courses.course_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $MyHead);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {
            // 課程存在，列出詳細資訊
            while($row = mysqli_fetch_array($result)) {
                echo "課程ID: " . $row['course_id'] . "<br>";
                echo "課程代號: " . $row['course_code'] . "<br>";
                echo "課程名稱: " . $row['course_name'] . "<br>";
                echo "學分: " . $row['credit'] . "<br>";
                echo "必選修: " . $row['isoptional'] . "<br>";
                echo "系所: " . $row['department'] . "<br>";
                echo "年級: " . $row['grade'] . "<br>";
                echo "教授: " . $row['professor'] . "<br>";
                echo "名額: " . $row['spot'] . "<br>";
                
                // 查询课程时间信息
        $course_id = $row['course_id'];
        $sql_course_time = "SELECT * FROM time WHERE course_id = ?";
        $stmt_course_time = mysqli_prepare($conn, $sql_course_time);
        mysqli_stmt_bind_param($stmt_course_time, 'i', $course_id);
        mysqli_stmt_execute($stmt_course_time);
        $result_course_time = mysqli_stmt_get_result($stmt_course_time);
        
        // 列出课程时间信息
        echo "時間";
        echo "(星期) : ";
        while($row_course_time = mysqli_fetch_array($result_course_time)) {
            echo  $row_course_time['course_time'] . "(";
            echo  $row_course_time['course_week'] . ") ";
        }
        
        mysqli_stmt_close($stmt_course_time);
                // 檢查課程是否已經被學生選修
                $sql_check_selected = "SELECT * FROM student_courses WHERE student_id = ? AND course_id = ?";
                $stmt_check_selected = mysqli_prepare($conn, $sql_check_selected);
                mysqli_stmt_bind_param($stmt_check_selected, 'ii', $_SESSION['student_id'], $row['course_id']);
                mysqli_stmt_execute($stmt_check_selected);
                $result_check_selected = mysqli_stmt_get_result($stmt_check_selected);
            
                // 檢查是否存在該課程的選修紀錄
                if(mysqli_num_rows($result_check_selected) > 0) {
                    // 學生已經選修該課程，顯示退選按鈕
                    echo '<form action="action.php" method="post">';
                    echo '<input type="hidden" name="student_id" value="' . $_SESSION['student_id'] . '">';
                    echo '<input type="hidden" name="course_id" value="' . $row['course_id'] . '">';
                    echo '<input type="hidden" name="credit" value="' . $row['credit'] . '">';
                    echo '<input type="submit" name="drop_course" input type="submit" value="退選"> ';
                    echo '<form action="query.php"><input type="submit" input type="submit" value="返回課程搜尋介面"></form>';
                    echo '</form>';
                } else {
                    // 學生未選修該課程，顯示加選按鈕
                    echo '<form action="action.php" method="post">';
                    echo '<input type="hidden" name="student_id" value="' . $_SESSION['student_id'] . '">';
                    echo '<input type="hidden" name="course_id" value="' . $row['course_id'] . '">';
                    echo '<input type="hidden" name="credit" value="' . $row['credit'] . '">';
                    echo '<input type="submit" name="add_course" input type="submit" value="加選"> ';
                    echo '<form action="query.php"><input type="submit" input type="submit" value="返回課程搜尋介面"></form>';
                    echo '</form>';
                    }             
            }
            } else {
                // 課程不存在
                echo "找不到該課程。";
                echo '<form action="query.php"><input type="submit" input type="submit" value="返回課程搜尋介面"></form>';

            }
            
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } elseif (isset($_POST['add_course'])) {
        
        // // 连接数据库
        $dbhost = '127.0.0.1';
        $dbuser = 'hj';
        $dbpass = 'test1234';
        $dbname = 'testdb';
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error with MySQL connection');
        mysqli_set_charset($conn, 'utf8');

        // 加選功能的處理邏輯
        $student_id = $_POST['student_id'];
        $course_id = $_POST['course_id'];
        $credit = $_POST['credit'];

        $sql_get_spot = "SELECT spot FROM courses WHERE course_id = ?";
        $stmt_get_spot = mysqli_prepare($conn, $sql_get_spot);
        mysqli_stmt_bind_param($stmt_get_spot, 'i', $course_id);
        mysqli_stmt_execute($stmt_get_spot);
        $result_get_spot = mysqli_stmt_get_result($stmt_get_spot);
        $row_get_spot = mysqli_fetch_assoc($result_get_spot);
        $spot = $row_get_spot['spot'];
        if($spot <= 0) {
            echo "該課程人數已滿，無法加選。";
            exit();
        }
        // 獲取學生的系所
        $sql_student_department = "SELECT department FROM students WHERE student_id = ?";
        $stmt_student_department = mysqli_prepare($conn, $sql_student_department);
        mysqli_stmt_bind_param($stmt_student_department, 'i', $student_id);
        mysqli_stmt_execute($stmt_student_department);
        $result_student_department = mysqli_stmt_get_result($stmt_student_department);
        $row_student_department = mysqli_fetch_assoc($result_student_department);
        $student_department = $row_student_department['department'];
        mysqli_stmt_close($stmt_student_department);

        // 獲取課程名稱
        $course_name = "";
        $sql_get_course_name = "SELECT course_name FROM courses WHERE course_id = ?";
        $stmt_get_course_name = mysqli_prepare($conn, $sql_get_course_name);
        mysqli_stmt_bind_param($stmt_get_course_name, 'i', $course_id);
        mysqli_stmt_execute($stmt_get_course_name);
        $result_get_course_name = mysqli_stmt_get_result($stmt_get_course_name);
        if ($row_get_course_name = mysqli_fetch_assoc($result_get_course_name)) {
            $course_name = $row_get_course_name['course_name'];
        }

        $sql_get_course_department = "SELECT department FROM courses WHERE course_id = ?";
        $stmt_get_course_department = mysqli_prepare($conn, $sql_get_course_department);
        mysqli_stmt_bind_param($stmt_get_course_department, 'i', $course_id);
        mysqli_stmt_execute($stmt_get_course_department);
        $result_get_course_department = mysqli_stmt_get_result($stmt_get_course_department);
        $row_get_course_department = mysqli_fetch_assoc($result_get_course_department);
        $course_department = $row_get_course_department['department'];
    
        // Check if the student's department matches the course's department
        if($student_department != $course_department) {
            echo "您的科系與該課程的科系不同，無法加選。";
            echo '<form action="query.php"><input type="submit" value="返回課程搜尋介面"></form>';
            exit();
        }     

        // 检查是否已经选择了同名的课程
        $sql_check_same_name_course = "SELECT c1.course_name 
        FROM student_courses sc1 
        INNER JOIN courses c1 ON sc1.course_id = c1.course_id 
        WHERE sc1.student_id = ? 
        AND c1.course_id != ? 
        AND c1.course_name = ?";
        $stmt_check_same_name_course = mysqli_prepare($conn, $sql_check_same_name_course);
        mysqli_stmt_bind_param($stmt_check_same_name_course, 'iis', $_SESSION['student_id'], $course_id, $course_name);
        mysqli_stmt_execute($stmt_check_same_name_course);
        $result_check_same_name_course = mysqli_stmt_get_result($stmt_check_same_name_course);

        if (mysqli_num_rows($result_check_same_name_course) > 0) {
        // 已经选择了同名的课程，提示学生重新选择
        echo "您已經選擇了同名的課程，無法重複選擇，請重複選擇。<br>";
        echo '<form action="query.php"><input type="submit" value="返回課程搜索頁面"></form>';
        exit();
        }

       // 檢查是否有時間衝突的課程
        $sql_conflict = "SELECT t1.* FROM time t1
        INNER JOIN time t2 ON t1.course_time = t2.course_time AND t1.course_week = t2.course_week
        WHERE t1.course_id IN (SELECT course_id FROM student_courses WHERE student_id = ?) 
        AND t2.course_id = ?";
        $stmt_conflict = mysqli_prepare($conn, $sql_conflict);
        mysqli_stmt_bind_param($stmt_conflict, 'ii', $student_id, $course_id);
        mysqli_stmt_execute($stmt_conflict);
        $result_conflict = mysqli_stmt_get_result($stmt_conflict);


        if(mysqli_num_rows($result_conflict) > 0) {
            // 存在時間衝突的課程，顯示警告訊息
            echo "您已經選擇了與已選課程時間衝突的課程，請重新選擇。<br>";
            echo '<form action="query.php"><input type="submit" value="返回課程搜尋介面"></form>';
            exit();
        }


        // 查詢學生的總學分
        $sql_total_credit = "SELECT total_credit FROM students WHERE student_id = ?";
        $stmt_total_credit = mysqli_prepare($conn, $sql_total_credit);
        mysqli_stmt_bind_param($stmt_total_credit, 'i', $student_id);
        mysqli_stmt_execute($stmt_total_credit);
        $result_total_credit = mysqli_stmt_get_result($stmt_total_credit);
        $row_total_credit = mysqli_fetch_assoc($result_total_credit);
        $total_credit = $row_total_credit['total_credit'];

        // 顯示學分
        echo "目前總學分為：" . $total_credit . "<br>";

        if ($total_credit >= 30) {
            // 學生已達到學分上限，不允許加選
            echo "您已達到學分上限，無法再加選課程。<br>";
            echo '<form action="query.php"><input type="submit" value="返回課程搜尋介面"></form>';
            exit();
        }
        // 檢查是否已經選擇過該課程
        $sql_check_selected = "SELECT * FROM student_courses WHERE student_id = ? AND course_id = ?";
        $stmt_check_selected = mysqli_prepare($conn, $sql_check_selected);
        mysqli_stmt_bind_param($stmt_check_selected, 'ii', $student_id, $course_id);
        mysqli_stmt_execute($stmt_check_selected);
        $result_check_selected = mysqli_stmt_get_result($stmt_check_selected);

        if(mysqli_num_rows($result_check_selected) > 0) {
            // 學生已經選修過該課程，提示學生重新選擇
            echo "您已經選修過該課程，請勿重複選修。<br>";
            echo '<form action="query.php"><input type="submit" value="返回課程搜尋介面"></form>';
            exit();
        }

        // 將課程添加到 student_courses 表中
        $sql_add_student_course = "INSERT INTO student_courses (student_id, course_id) VALUES (?, ?)";
        $stmt_add_student_course = mysqli_prepare($conn, $sql_add_student_course);
        mysqli_stmt_bind_param($stmt_add_student_course, 'ii', $student_id, $course_id);
        mysqli_stmt_execute($stmt_add_student_course);
        mysqli_stmt_close($stmt_add_student_course);

       

        // 更新學生的總學分
        $dbhost = '127.0.0.1';
        $dbuser = 'hj';
        $dbpass = 'test1234';
        $dbname = 'testdb';
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error with MySQL connection');
        mysqli_set_charset($conn, 'utf8');

        // 取得原始總學分
        $sql = "SELECT total_credit FROM students WHERE student_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $student_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $total_credit = $row['total_credit'];

        // 更新總學分
        $total_credit += $credit;
        $sql = "UPDATE students SET total_credit = ? WHERE student_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $total_credit, $student_id);
        mysqli_stmt_execute($stmt);

        // 減少課程的 spot
        $sql_update_spot = "UPDATE courses SET spot = spot - 1 WHERE course_id = ?";
        $stmt_update_spot = mysqli_prepare($conn, $sql_update_spot);
        mysqli_stmt_bind_param($stmt_update_spot, 'i', $course_id);
        mysqli_stmt_execute($stmt_update_spot);

        // 標記課程已被選修（更新 time 表的 flag 欄位）
        $sql_update_flag = "UPDATE time SET flag = true WHERE course_id = ?";
        $stmt_update_flag = mysqli_prepare($conn, $sql_update_flag);
        mysqli_stmt_bind_param($stmt_update_flag, 'i', $course_id);
        mysqli_stmt_execute($stmt_update_flag);

        // 檢查受影響的行數，確保更新操作成功
        $affected_rows = mysqli_stmt_affected_rows($stmt_update_spot);

        if ($affected_rows > 0) {
            // 更新操作成功
            // 顯示學分並返回按鈕
            echo "您已成功加選課程，目前總學分為：" . $total_credit . "<br>";
            echo '<form action="query.php"><input type="submit" value="返回課程搜尋介面"></form>';
        } else {
            // 更新操作失敗
            echo "加選課程失敗，請重試。";
            echo '<form action="query.php"><input type="submit" value="返回課程搜尋介面"></form>';
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } elseif (isset($_POST['drop_course'])) {
        // 退選功能的處理邏輯
        $student_id = $_POST['student_id'];
        $course_id = $_POST['course_id'];
        $credit = $_POST['credit'];
    
        // 更新學生的總學分
        $dbhost = '127.0.0.1';
        $dbuser = 'hj';
        $dbpass = 'test1234';
        $dbname = 'testdb';
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error with MySQL connection');
        mysqli_set_charset($conn, 'utf8');

        $sql_check_optional = "SELECT isoptional FROM courses WHERE course_id = ?";
        $stmt_check_optional = mysqli_prepare($conn, $sql_check_optional);
        mysqli_stmt_bind_param($stmt_check_optional, 'i', $course_id);
        mysqli_stmt_execute($stmt_check_optional);
        $result_check_optional = mysqli_stmt_get_result($stmt_check_optional);
        $row_check_optional = mysqli_fetch_assoc($result_check_optional);
        $is_optional = $row_check_optional['isoptional'];
        mysqli_stmt_close($stmt_check_optional);
    
        // 如果該課程是必修課程，顯示警告訊息並中止退選操作
        if ($is_optional === '必修') {
            echo "警告：該課程為必修，無法退選，預退選請找助教。<br>";
            echo '<form action="query.php"><input type="submit" value="返回課程搜尋介面"></form>';
            exit();
        }   
        // 取得原始總學分
        $sql = "SELECT total_credit FROM students WHERE student_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $student_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $total_credit = $row['total_credit'];
    
        // 更新總學分
        $total_credit -= $credit;
        $sql = "UPDATE students SET total_credit = ? WHERE student_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $total_credit, $student_id);
        mysqli_stmt_execute($stmt);

         // 將課程從 student_courses 表中移除
        $sql_remove_course = "DELETE FROM student_courses WHERE student_id = ? AND course_id = ?";
        $stmt_remove_course = mysqli_prepare($conn, $sql_remove_course);
        mysqli_stmt_bind_param($stmt_remove_course, 'ii', $student_id, $course_id);
        mysqli_stmt_execute($stmt_remove_course);
        mysqli_stmt_close($stmt_remove_course);
    
        // 將課程的 flag 設置為 false
        $sql_update_flag = "UPDATE time SET flag = false WHERE course_id = ?";
        $stmt_update_flag = mysqli_prepare($conn, $sql_update_flag);
        mysqli_stmt_bind_param($stmt_update_flag, 'i', $course_id);
        mysqli_stmt_execute($stmt_update_flag);
    
        // 增加課程的 spot
        $sql_update_spot = "UPDATE courses SET spot = spot + 1 WHERE course_id = ?";
        $stmt_update_spot = mysqli_prepare($conn, $sql_update_spot);
        mysqli_stmt_bind_param($stmt_update_spot, 'i', $course_id);
        mysqli_stmt_execute($stmt_update_spot);
    
        // 檢查受影響的行數，確保更新操作成功
        $affected_rows = mysqli_stmt_affected_rows($stmt_update_spot);
    
        if ($affected_rows > 0) {
            // 更新操作成功
            // 顯示學分並返回按鈕
            echo "您已成功退選課程，目前總學分為：" . $total_credit . "<br>";
            echo '<form action="query.php"><input type="submit" value="返回課程搜尋介面"></form>';
        } else {
            // 更新操作失敗
            echo "退選課程失敗，請重試。";
            echo '<form action="query.php"><input type="submit" value="返回課程搜尋介面"></form>';
            echo '<form action="action.php" method="post">';
            echo '<input type="hidden" name="student_id" value="' . $student_id . '">';
            echo '<input type="hidden" name="course_id" value="' . $course_id . '">';
            echo '<input type="hidden" name="credit" value="' . $credit . '">';
            echo '<input type="submit" name="add_course" value="加選">';
            echo '</form>';
        }
    
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
     
    else {
        // 沒有收到課程代碼或加選按鈕
        header("Location: query.php");
        exit();
    }
} else {
    // 使用者未登入，導向回登入頁面
    header("Location: index.php");
    exit();
}
?>
</div>
</body>
</html>