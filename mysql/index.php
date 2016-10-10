<?php


$link = mysqli_connect("localhost", "cl19-brotherdb", "JfY/eg9wm", "cl19-brotherdb");


if (mysqli_connect_error()) {
    
    //echo "Could not connect";
    die("Could not connect to the database");
};


// $query = "INSERT INTO `users` (`name`, `email`, `password`) VALUES('Marc', 'tom@abc.gov', 'testing')";

// $query = "UPDATE `users` SET `email` = 'tommy@xyz.com' WHERE `id` = 2 LIMIT 1";





//$query = "UPDATE `users` SET `name`='David O\'Macisso' WHERE id=1 LIMIT 1";

 //mysqli_query($link, $query);

$name="David O'Macisso";

// $name="Tommy";

$query = "SELECT `name` FROM users WHERE name='".mysqli_real_escape_string($link, $name)."'";

// $query = "SELECT * from users";

if ($result = mysqli_query($link, $query)) {
    
    echo mysqli_num_rows($result);
    
    while ($row = mysqli_fetch_array($result))  {
        
    print_r($row);
        
    }
    
} else {
    
    echo "It failed";
}
    
    
?>
    