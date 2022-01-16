<?php
require('./auth.php');
if ($_SESSION['role'] == "student") load('index.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Groups</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php include("includes/nav.php");?>
        <div class="title">
            <h1>Groups</h1>
            <a href="/create-group.php">Create Group</a>
        </div>
        <?php
        $user_id = $_SESSION['user_id'];
        $names = ($_SESSION['role'] == "admin") ? mysqli_query($db, "SELECT * FROM `group`;") : mysqli_query($db, "SELECT * FROM `group` WHERE owner_id = $user_id;");
        while ($row = mysqli_fetch_assoc($names)) {
            $name = $row['name'];
            $group_id = $row['group_id'];
            $student_nums = mysqli_query($db, "SELECT COUNT(*) FROM group_member, user WHERE group_member.user_id = user.user_id AND group_member.group_id = $group_id AND user.role = 'student';");
            $student_num = $student_nums ? mysqli_fetch_array($student_nums)[0] : 0;

            echo "<div class='group' onclick=\"location.href='/group.php?id=$group_id';\" style='cursor: pointer;'>
                    <p>Name: $name</p><br>
                    <p>Students: $student_num</p>
                  </div>";
        }
        ?>
    </body>
</html>