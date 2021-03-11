
<?php
   $objConnect = mysqli_connect("db1.telecorp.co.th","telecorp","@Telecorp$12345");
   if($objConnect)
   {
      echo "Database Connected.";
   }
   else
   {
      echo "Database Connect Failed.";
   }

   mysql_close($objConnect);
?>
