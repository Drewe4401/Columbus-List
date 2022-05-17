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

$errormsg = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST['submit'] === "Search"){
        $sql = "SELECT * FROM seller WHERE title LIKE ?";
    
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_term);
            
            // Set parameters
            $param_term = '%' . $_REQUEST["searchtxt"] . '%';
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                
                // Check number of rows in the result set
                if(mysqli_num_rows($result) > 0){
                    // Fetch result rows as an associative array
                  
                } else{
                    echo "<p>No matches found</p>";
                }
    } }
}
    else if($_POST['submit'] === "Highest to Lowest"){
        $result = $conn->query("SELECT * FROM seller ORDER BY price DESC"); 
    }
    else if($_POST['submit'] === "Lowest to Highest"){
            $result = $conn->query("SELECT * FROM seller ORDER BY price ASC"); 
    }
    else if($_POST['submit'] === "Furniture"){
        $result = $conn->query("SELECT * FROM seller WHERE tag = 'Furniture' ORDER BY id DESC"); 
    }
    else if($_POST['submit'] === "Electronics"){
        $result = $conn->query("SELECT * FROM seller WHERE tag = 'Electronics' ORDER BY id DESC");
    }
    else if($_POST['submit'] === "Clothes"){
        $result = $conn->query("SELECT * FROM seller WHERE tag = 'Clothes' ORDER BY id DESC");
    }
    else if($_POST['submit'] === "Other"){
        $result = $conn->query("SELECT * FROM seller WHERE tag = 'Other' ORDER BY id DESC");
    }
    else if($_POST['submit'] === "Add to Wishlist"){

        

        $UEmail = $_SESSION['Email'];
        $idvar = $_POST['titlevar'];
        $getresult = $conn->query("SELECT * FROM seller WHERE id=$idvar");
        $row1 = mysqli_fetch_assoc($getresult);
        $result1 = $conn->query("SELECT * FROM wishlist WHERE idvar = '$idvar' AND useremail = '$UEmail'");
        if($result1->num_rows == 1){
                  header("Location: home.php?error=Item already in Wishlist!");
            }
            else{
                $title = $row1['title'];
                $pics = base64_encode($row1['pics']);
                $Email = $row1['Email'];
                $description = $row1['description'];
                $price = $row1['price'];
                $contact = $row1['contact'];
                $tag = $row1['tag'];
                $date = $row1['date'];
                $changed = '0';
                $sql = mysqli_query($conn, "INSERT INTO wishlist(idvar, useremail, title, pics, Email, description, price, contact, tag, date, changed) values ('$idvar', '$UEmail', '$title', '$pics', '$Email', '$description', '$price', '$contact', '$tag', '$date', '$changed')");
                header("Location: home.php?added=Item successfully added into your Wishlist!");
            }
        
       
        
        $result = $conn->query("SELECT * FROM seller ORDER BY id DESC"); 

    }
}
else{
$result = $conn->query("SELECT * FROM seller ORDER BY id DESC"); 
}
?>


    <!DOCTYPE html>
    <html>
    <head>
        <title>Home Page</title>
        <link rel = "stylesheet" type = "text/css" href="style2.css">
    </head>
    <body>
    <header>
        <h1>Columbus List</h1>
    </header>

    <style>
  <?php include "style2.css" ?>
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
        <button class="tablink" onclick="location.href='logout.php'">Log Out</button><br>

<form class="straightenit" method="post">
        <label>Search:</label>
        <input class="field_class" name="searchtxt" type="text" placeholder="Search Here!">
        <input type="submit" name="submit" value="Search">
</form>
        <label class="straightenit">Filters:</label>
        <label class="straightenit">Price:</label>
<form class="straightenit" method="post">
        <input type="submit" name="submit" value="Highest to Lowest">
</form>
<form class="straightenit" method="post">
        <input type="submit" name="submit" value="Lowest to Highest">
</form>
<label class="straightenit">Tags:</label>
<form class="straightenit" method="post">
        <input type="submit" name="submit" value="Furniture">
</form>
<form class="straightenit" method="post">
        <input type="submit" name="submit" value="Electronics">
</form>
<form class="straightenit" method="post">
        <input type="submit" name="submit" value="Clothes">
</form>
<form class="straightenit" method="post">
        <input type="submit" name="submit" value="Other">
</form>
<br>

<?php if (isset($_GET['added'])) { ?>
			<p class="addedtolist"> <?php echo $_GET['added']; ?> </p>
		<?php } ?>

<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>


        

<?php if($result->num_rows > 0){ ?> 
    <div class="gallery"> 
        <?php while($row = $result->fetch_assoc()){ ?> 
            <form method="post">
           <img src="data:pics/jpg;charset=utf8;base64,<?php echo base64_encode($row['pics']); ?>" />
          <br><br> <p> <b> Title: </b> <?php echo $row['title']; ?><br><br> </p>
           <p> <b> Email: </b> <?php echo $row['Email']; ?><br><br> </p>
           <p> <b> Description: </b> <?php echo $row['description']; ?><br><br> </p>
           <p> <b> Price: </b> $<?php echo $row['price'] ; ?><br><br> </p>
           <p> <b> Contact Info: </b> <?php echo $row['contact']; ?><br><br> </p>
           <p> <b> Tag: </b> <?php echo $row['tag']; ?> </p><br>
           <p> <b> Date: </b> <?php echo $row['date']; ?> </p><br>
           <input type="hidden" name="titlevar" value="<?php echo $row['id']; ?>">
           <input type="submit" name="submit" value="Add to Wishlist"><br><br>
        </form>
        <?php } ?> 
    </div> 
<?php }else{ ?> 
    <p class="status error">No Results Found</p> 
<?php } ?>
<?php
}
else{
    header("Location: index.php");
    exit();
}
?>