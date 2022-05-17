<?php
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['Email'])) {
    ?>
<?php


$sname= "localhost";
$unmae= "root";
$password = "";
$db_name = "test_db";
$conn = mysqli_connect($sname, $unmae, $password, $db_name);
if (!$conn) {
    echo "Connection failed!";
}

if(isset($_POST['submit'])){

if($_POST['submit'] === "Remove"){

    $title = $_POST['titlevar'];

    $sql = "DELETE FROM wishlist WHERE id = $title";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
}
     else {
        echo "Error deleting record: " . $conn->error;
}
}
else if($_POST['submit'] === "Seen"){
    $varcha = "0";
    $varcha1 = "1";
    $emaill = $_SESSION['Email'];
    $sql = "UPDATE wishlist SET changed='$varcha' WHERE changed='$varcha1' AND useremail='$emaill'";
    if ($conn->query($sql) === TRUE){
          echo "seen";
        }

}
}


    

$email=$_SESSION['Email'];
$result = $conn->query("SELECT * FROM wishlist WHERE useremail = '$email' ORDER BY id DESC"); 


?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Home Page</title>
        <link rel = "stylesheet" type = "text/css" href="style3.css">
    </head>
    <body>
    <header>
        <h1>Columbus List</h1>
    </header>

    <style>
  <?php include "style3.css" ?>
</style>
     
</body>
        <button class="tablink" onclick="location.href='home.php'">Home</button>
        <button class="tablink" onclick="location.href='sell.php'">Sell</button>
        <button class="tablink" onclick="location.href='youritems.php'">Your items</button>
        <button class="tablink" onclick="location.href='Wishlist.php'">Wishlist <?php 

    $varcha = "1";
    $emailu = $_SESSION['Email'];
    $getresult = $conn->query("SELECT * FROM wishlist WHERE changed='$varcha' AND useremail ='$emailu'");
    $row1 = mysqli_fetch_assoc($getresult);
    if(isset($row1)){
    if($row1['changed'] === $varcha){
        echo "(1+ item(s) Price has changed.)";
    }}
    ?></button>
        <button class="tablink" onclick="location.href='logout.php'">Log Out</button>

        <h1 class="Titlecl">Wishlist</h1>

       <?php $varcha = "1";
       $emailu = $_SESSION['Email'];
    $getresult = $conn->query("SELECT * FROM wishlist WHERE changed='$varcha' AND useremail='$emailu'");
    $row1 = mysqli_fetch_assoc($getresult);
    if(isset($row1['changed'])){
if($row1['changed'] === $varcha){
    echo '<div class="addedtolist1">';
    $getresult->data_seek(0);
    while($row1 = $getresult->fetch_assoc()){
        $titlel = $row1['title'];
        $pricel = $row1['price'];
        echo $row1['title'];
        echo " price has changed to $";
        echo $row1['price'];
        echo '<br>';
        
    }
    echo '<form method = "post"> <input class="boxtext" type="submit" name="submit" value="Seen"> </form>';
    echo '</div>';
    }
}
    ?>

        <?php if($result->num_rows > 0){ ?> 
    <div class="gallery"> 
        <?php while($row = $result->fetch_assoc()){ ?> 
            <form method="post">
           <img src="data:pics/jpg;charset=utf8;base64,<?php echo $row['pics']; ?>" />
          <br><br> <p> <b> Title: </b> <?php echo $row['title']; ?><br><br> </p>
           <p> <b> Email: </b> <?php echo $row['Email']; ?><br><br> </p>
           <p> <b> Description: </b> <?php echo $row['description']; ?><br><br> </p>
           <p> <b> Price: </b> $<?php echo $row['price'] ; ?><br><br> </p>
           <p> <b> Contact Info: </b> <?php echo $row['contact']; ?><br><br> </p>
           <p> <b> Tag: </b> <?php echo $row['tag']; ?> </p><br>
           <p> <b> Date: </b> <?php echo $row['date']; ?> </p><br>
           <input type="hidden" name="titlevar" value="<?php echo $row['id']; ?>">
           <input type="submit" name="submit" value="Remove"><br><br><br>
        </form>
        <?php } ?> 
    </div> 
<?php }else{ ?> 
    <p class="status error">No Results Found</p> 
<?php } ?>

</html>

<?php
}
else{
    header("Location: index.php");
    exit();
}
?>