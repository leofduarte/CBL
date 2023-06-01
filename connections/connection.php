<?php

function new_db_connection()
{
   $hostname = "localhost";
   $username = "root";
   $password = "";
   $dbname = "astrodata";

   $local_link = mysqli_connect($hostname, $username, $password, $dbname);

   if (!$local_link) {
      die("Connection failed: " . mysqli_connect_error());
   }
   mysqli_set_charset($local_link, "utf8");
   return $local_link;
}
