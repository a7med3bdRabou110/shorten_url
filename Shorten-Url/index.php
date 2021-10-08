<?php 

  $new_url= '';
include "php/config.php";
    if(isset($_GET)){
      foreach($_GET as $key=>$val){

        $u = mysqli_real_escape_string($conn ,$key);
        $new_url = str_replace("/" , "" , $u);
      }
      //getting the full url of that short url which we are getting from url
      $sql = mysqli_query($conn , "SELECT full_url FROM url WHERE shorten_url = '{$new_url}' ");

      if(mysqli_num_rows($sql) > 0) {
        $count_query = mysqli_query($conn , "UPDATE url SET	clicks = 	clicks + 1 WHERE shorten_url = '{$new_url}'");
        if($count_query){

          // let's redirect user
          $ful_url = mysqli_fetch_assoc($sql);
          header("Location:".$ful_url["full_url"]);
        }
      }

    }

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shorten Url Link</title>
    <link rel="stylesheet" href="main.css" />
    <link
      rel="stylesheet"
      href="https://unicons.iconscout.com/release/v3.0.6/css/line.css"
    />
  </head>
  <body>
    <div class="wrapper">
      <form action="#">
        <input type="text" name="full_url" required placeholder="Enter or Paste a long url" />
        <i class="url-icon uil uil-link"></i>
        <button>Shorten</button>
      </form>
      <?php 
        $sql2 = mysqli_query($conn , "SELECT *  FROM url ORDER BY id DESC");
        if(mysqli_num_rows($sql2) > 0) {
      ?>
      <div class="count">
        <?php 
          $sql3 = mysqli_query($conn , "SELECT COUNT(*) FROM url");
          $res = mysqli_fetch_assoc($sql3);
          $sql4 = mysqli_query($conn , "SELECT clicks FROM url");
          $total = 0 ; 
          while($c = mysqli_fetch_assoc($sql4)){
            $total = $c["clicks"] + $total;
          }
        ?>
        <span
          >Total Links : <span> <?php echo end($res); ?> </span> & Total Click :
          <span><?php echo $total; ?></span>
        </span>
        <a href="php/delete.php?delete=all">ClearAll</a>
      </div>
      <div class="urls-area">
        <div class="title">
          <li>Shorten URL</li>
          <li>Original URL</li>
          <li>Clicks</li>
          <li>Action</li>
        </div>
          <?php 
            while($row = mysqli_fetch_assoc($sql2)){
          ?>
        <div class="data">
          <li><a href="http://localhost/shorten-url/<?php echo $row["shorten_url"]; ?>" target="_blank" >
            <?php 
                if("localhost/shorten-url/".strlen($row["shorten_url"]) > 50) {
                  echo "localhost/shorten-url/".$row["shorten_url"] , 0 , 50 ;
                }else {
                  echo "localhost/shorten-url?u=".$row["shorten_url"];
                }
            ?>
          </a></li>
          <li>
            <?php 
            if("localhost/shorten-url?u=".strlen($row["full_url"]) > 65) {
                  echo "localhost/shorten-url?u=". substr($row["full_url"] , 0 , 65). "..."  ;
                }else {
                  echo "localhost/shorten-url?u=".$row["full_url"];
                } ?>
          </li>
          <li>
            <?php echo $row["clicks"] ?>
          </li>
          <li><a href="php/delete.php?id=<?php echo $row["shorten_url"]; ?>">Delete</a></li>
        </div>
        <?php 
            }
        }
        ?>
      </div>
    </div>
    <div class="blur-effect"></div>
    <div class="popup-box">
      <div class="info-box">
        Your Short Link is Ready . You can also edit Your short Link now but
        can't edit once you saved it
      </div>
      <form action="#">
        <label> Edit Your Short URL </label>
        <input type="text" spellcheck="false"  value="" />
        <i class="copy-icon uil uil-copy-alt"></i>
        <button>Save</button>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>
