<?php 
      // Let's get these values which are sent from ajax to php
      include "./config.php";
      $org_url = mysqli_real_escape_string($conn , $_POST["shorten_url"]);
      $full_url = str_replace(" " , "" , $org_url);
      $hidden_url = mysqli_real_escape_string($conn,  $_POST["hidden_url"]);
      if(!empty($full_url)) {
            $domain = "localhost";
            if(preg_match("/{$domain}/i" , $full_url) && preg_match("/\//i" , $full_url)){
                  $explodeURL = explode("/",$full_url);
                  $short_url = end($explodeURL);
                  if($short_url !== ""){
                        $sql = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$short_url}' && shorten_url != '{$hidden_url}'");
                        if(mysqli_num_rows($sql) == 0) {
                              $sql2 = mysqli_query($conn , "UPDATE url SET shorten_url = '{$short_url}' WHERE shorten_url = '{$hidden_url}'");
                              if($sql2) {
                                    echo "Success";
                              }else{
                                    echo "Something went wrong !";
                              }
                        }else{
                              echo "Error - This is url already Exist";
                        }
                  }else {
                        echo "Error - This is short url";
                  }
            }else{
                  echo "Invalid URL - you can't edit domain name";
            }
      }else {
            echo "Error - You have to enter short URL";
      }
?>