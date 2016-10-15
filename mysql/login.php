<?php
//LOGIN SYSTEM

session_start();

if ($_GET["logout"]==1 AND $_SESSION['id'] ) {
    session_destroy();
    
    $message = "You have been logged out.. Have a nice day";
}

include("connection.php");


if ($_POST['submit'] == "Sign UP") {
    
    if (!$_POST['email']) $error .= "<br />Please submit an email address";
        else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $error .= "<br />Please enter a valid email address";
    
    
    if (!$_POST['password']) $error .= "<br /> Please enter a password";
        else {
            
            if(strlen($_POST['password']) <8) $error .= "<br /> The password must be at least 8 characters";
            if (!preg_match('`/[A-Z/]`', $_POST['password'])) $error .= "<br \>The password needs at least one capital letter";
                    
        }    
    
    
    if ($error) $error =  "<br \>This were error(s) in your submission;".$error;
    else {
       
        $query = "SELECT * FROM `users` WHERE email='".mysqli_real_escape_string($link, $_POST['email'])."'";  
        
        $result = mysqli_query($link, $query);                          //run query
        
       // echo $result;
        
       $results = mysqli_num_rows($result);
    
        if ($results) $error =  "That email address is already registered. Do you want to log in?";
        
        else {                
        
        $query="INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."','".md5(md5($_POST['email']).$_POST['password'])."')";
         
           
   
            
            mysqli_query($link, $query);   
                                                       
            $success =  "You have been signed up!";
            
            $_SESSION['id'] = mysqli_insert_id($link);
            
           header("Location:mainpage.php");
            
            //Redirect to logged in page.
            
            
        }
            
                    
    }
    
}

 if ($_POST['submit'] == "Log In") {

     
    //$query="SELECT * FROM `users` WHERE email='".mysql_real_escape_string($link, $_POST['loginemail'])."' AND password='".md5(md5($_POST['loginemail']) .$_POST['loginpassword']). "' LIMIT 1";
     
     
    $query = "SELECT * FROM users WHERE email='".mysqli_real_escape_string($link, $_POST['loginemail'])."'AND password='" .md5(md5($_POST['loginemail']) .$_POST['loginpassword']). "'LIMIT 1";
     
     $result = mysqli_query($link, $query);
     
     $row = mysqli_fetch_array($result);
     
     if ($row) {
         
         $_SESSION['id'] = $row['id'];
         
         
          header("Location:mainpage.php");
         
         //Redirect to logged in page
      } else {
         
         $error =  "We could not find a user with that email and password.  Please try again.";
     }
     
 }

?>

