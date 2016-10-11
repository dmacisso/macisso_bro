<?php
//LOGIN SYSTEM

session_start();

$link = mysqli_connect("localhost", "cl19-brotherdb", "JfY/eg9wm", "cl19-brotherdb");


if ($_POST['submit'] == "Sign UP") {
    
    if (!$_POST['email']) $error .= "<br />Please submit an email address";
        else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $error .= "<br />Please enter a valid email address";
    
    
    if (!$_POST['password']) $error .= "<br /> Please enter a password";
        else {
            
            if(strlen($_POST['password']) <8) $error .= "<br /> The password must be at least 8 characters";
            if (!preg_match('`[A-Z]`', $_POST['password'])) $error .= "<br \>The password needs at least one capital letter";
                    
        }    
    
    
    if ($error) echo "<br \>This were error(s) in your submission;".$error;
    else {
       
       

        $query = "SELECT * FROM `users` WHERE email='".mysqli_real_escape_string($link, $_POST['email'])."'";  
        
        $result = mysqli_query($link, $query);                          //run query
        
       // echo $result;
        
       $results = mysqli_num_rows($result);
    
        if ($results) echo "That email address is already registered. Do you want to log in?";
        else {                
        
        $query="INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."','".md5(md5($_POST['email']).$_POST['password'])."')";
         
           
   
            
            mysqli_query($link, $query);   
                                                       
            echo  "You have been signed up!";
            
            $_SESSION['id'] = mysqli_insert_id($link);
            
            print_r($_SESSION);
            
            //Redirect to logged in page.
            
            
        }
            
                    
    }
    
}

 if ($_POST['submit'] == "Log In") {

     
    //$query="SELECT * FROM `users` WHERE email='".mysql_real_escape_string($link, $_POST['loginemail'])."' AND password='".md5(md5($_POST['loginemail']) .$_POST['loginpassword']). "' LIMIT 1";
     
     
    $query = "SELECT * FROM users WHERE email='".mysqli_real_escape_string($link, $_POST['loginemail'])."'AND password='" .md5(md5($_POST['loginemail']) .$_POST['loginpassword']). "'LIMIT 1";
     
     $result = mysqli_query($link, $query);
     
     $row = mysqli_fetch_array($result);
     
     print_r($row);
     
 }

?>


<form method="post">

<input type="email" name="email" id="email" value="<?php echo addslashes($_POST['email']); ?>"/>

<input type="password" name="password" value="<?php echo addslashes($_POST['password']); ?> "/>
    
<input type="submit" name="submit"  value="Sign UP"   />

</form>

<form method="post">

<input type="email" name="loginemail" id="loginemail" value="<?php echo addslashes($_POST['email']); ?>"/>

<input type="password" name="loginpassword" value="<?php echo addslashes($_POST['password']); ?> "/>
    
<input type="submit" name="submit"  value="Log In"   />

</form>