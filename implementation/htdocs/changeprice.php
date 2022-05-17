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

$userEmail = $_SESSION['Email'];
$varid = $_GET['idp'];
$result = $conn->query("SELECT * FROM seller WHERE id = '$varid' ORDER BY id DESC"); 




if($_POST['submit1'] === "submit"){

    $title = $_POST['titlevar'];
    $newprice =$_POST['newprice'];
    $varcha = "1";

    $sql = "UPDATE seller SET Price='$newprice' WHERE id=$title";
   

    if ($conn->query($sql) === TRUE) {
      
        $sql = "UPDATE wishlist SET changed='$varcha' WHERE idvar=$title";
        if ($conn->query($sql) === TRUE){
        $sql = "UPDATE wishlist SET price='$newprice' WHERE idvar='$title'";
        header("Location: youritems.php?changed=Items price successfully changed.");
        }
      } else {
        echo "Error updating record: " . $conn->error;
      }
}
else if($_POST['submit1'] === "Cancel"){
    header("Location: youritems.php");
}




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

        <h1 class="Titlecl">Your items</h1>
       
        <?php if($result->num_rows > 0){ ?> 
    <div class="gallery"> 
    <div id="newElementId">Change the Price of Item:</div>
        <?php while($row = $result->fetch_assoc()){ ?> 
            <form method="post">
           <img src="data:pics/jpg;charset=utf8;base64,<?php echo base64_encode($row['pics']); ?>" />
          <br><br> <p> <b> Title: </b> <?php echo $row['title']; ?><br><br> </p>
           <p> <b> Email: </b> <?php echo $row['Email']; ?><br><br> </p>
           <p> <b> Description: </b> <?php echo $row['description']; ?><br><br> </p>
           <p > <b> Price: </b> $<input type="text" name="newprice"> </p><br>
           <p> <b> Contact Info: </b> <?php echo $row['contact']; ?><br><br> </p>
           <p> <b> Tag: </b> <?php echo $row['tag']; ?> </p><br>
           <p> <b> Date: </b> <?php echo $row['date']; ?> </p><br>
           <input type="hidden" name="titlevar" value="<?php echo $row['id']; ?>">
           <input type="submit" name="submit1" value="Cancel">
           <input type="submit" name="submit1" value="submit"><br><br><br>
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
