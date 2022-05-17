<?php
session_start();
include "db_conn.php";

if(isset($_POST['ename']) && isset($_POST['password'])){

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$ename = validate($_POST['ename']);
$pass = validate($_POST['password']);

if(empty($ename)){
    header("Location: index.php?error=Email is required");
    exit();
}
else if(empty($pass)){
    header("Location: index.php?error=Password is required");
    exit();
}

$sql = "SELECT * FROM users WHERE Email='$ename' and password='$pass'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) === 1){
    $row = mysqli_fetch_assoc($result);
    if($row['Email'] === $ename && $row['password'] === $pass){
        echo "Logged in";
        $_SESSION['Email'] = $row['Email'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['id'] = $row['id'];
        header("Location: home.php");
        exit();
    }
    else{
        header("Location: index.php?error=Incorrect Email or Password");
        exit();
    }
}
else{
        header("Location: index.php");
        exit();
}
mysqli_close($conn);
?>
