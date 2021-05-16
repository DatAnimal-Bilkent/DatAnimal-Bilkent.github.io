<?php
   session_start();

   if(session_destroy()) {
      $message  = 'Good bye' ;
      header("Location: VisitorHomePage.php");
   }
?>
