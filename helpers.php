<?php

error_reporting( E_ALL );
ini_set('display_errors', 1);


function get($key, $default = "") {
  if(isset($_GET[$key])) {
    return $_GET[$key];
  }
  
  return $default;
}

?>