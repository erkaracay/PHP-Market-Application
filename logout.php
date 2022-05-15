<?php
   session_destroy();

   setcookie(session_name(), "", 1 , "/");
   header("Location: login.php");