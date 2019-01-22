<?php
  session_start();
  if(!isset($_SESSION["logged_in"])){
    $_SESSION["logged_in"] = false;
  }
  
  define("DB_HOST", "303.itpwebdev.com");
  define("DB_USER", "abahng_db_user");
  define("DB_PASS", "qwerasdf1234");
  define("DB_NAME", "abahng_cookery_db");
?>