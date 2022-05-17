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

if($_SERVER["REQUEST_METHOD"] == "POST"){
    try
    {
      

      date_default_timezone_set('America/Chicago');

        $email=$_SESSION['Email'];
        $title=$_POST['titlevar'];
        $desc=$_POST['descvar'];
        $price=$_POST['pricevar'];
        $contact=$_POST['convar'];
        $tag=$_POST['tagvar'];
        $date = date("Y-m-d");

        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
        }

        if(empty($title)) throw new Exception("Title can not empty");
        if(empty($desc)) throw new Exception("Description can not empty");
        if(empty($price)) throw new Exception("Price can not empty");
        if(empty($contact)) throw new Exception("Contact Information can not empty");


        $sql = mysqli_query($conn, "INSERT INTO seller(Email,pics,title,description,price,contact,tag,date) values ('$email', '$imgContent', '$title', '$desc', '$price','$contact','$tag', '$date')");
    
        $success="Registration Successfully Completed";

    }
    catch(Exception $e)
    {
        $msg=$e->getMessage();
    }
}
?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Home Page</title>
        <link rel = "stylesheet" type = "text/css" href="style1.css">
    </head>
    <body>
    <header>
        <h1>Columbus List</h1>
    </header>
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
<main>
  
<div class="form_div">
        <form id="login_form" class="form_class" method="post" enctype="multipart/form-data">
        <h1> Sell A Item </h1>
        <label for="img">Select image:</label>
        <input type="file" name="image" class="input-form" accept="image/*"><br>
          <label>Title:</label>
          <input class="field_class" name="titlevar" type="text"><br>
          <label>Description:</label>
          <input class="field_class" name="descvar" type="text" ><br>
          <label>Price:</label>
          <input class="field_class" name="pricevar" type="text"><br>
          <label>Contact Information:</label>
          <input class="field_class" name="convar" type="text" placeholder="Email or phone number will work." autofocus><br>
          <label>Tag:</label>
          <select name="tagvar">
            <option value="Furniture">Furniture</option>
            <option value="Electronics">Electronics</option>
            <option value="Clothes">Clothes</option>
            <option value="Other">Other</option>
          </select>
          <input type="submit">
</div>
<div class="info_div">
            </div>
</form>
</main>
     
</body>
   
</html>

<?php
}
else{
    header("Location: index.php");
    exit();
}
?>