<?php 
   include "config.php";

   // Let's get the value which are sending from js ajax

   $full_url = mysqli_real_escape_string($conn , $_POST["full_url"]);

   // if Full URL is not empty and the user entered URL is a valid URL

   if(!empty($full_url) && filter_var($full_url ,FILTER_VALIDATE_URL)){
    // generate randoms characters
    $ran_url = substr(md5(microtime()) , rand(0,26) , 5) ; 
    // checking that random generated url already existed or not
    $sql = mysqli_query($conn , "SELECT shorten_url FROM url WHERE shorten_url = '{$ran_url}'");
    if(mysqli_num_rows($sql) > 0) {
     echo "something went wrong. please , generated url again";
    }else {
     // Let's insert user typed url into table witrth short url 
     $sql2 = mysqli_query($conn , "INSERT INTO url (shorten_url , full_url , clicks) VALUES ('{$ran_url}' , '{$full_url}' , '0')");
     // if data inserted successfully 
     if($sql2){
      // Selecting data recently inserted url link
      $sql3 = mysqli_query($conn , "SELECT shorten_url FROM url WHERE shorten_url = '{$ran_url}'");
      if(mysqli_num_rows($sql3) > 0) {
       $shorten_url = mysqli_fetch_assoc($sql3);
       echo $shorten_url["shorten_url"];
      }
     }else{
       echo "something went wrong. please , try again";
      }
    }
   }else {
     echo $full_url . " - This is not valid url";
    }

?>