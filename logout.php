<?php
  require_once('include/load.php');
  if(!$session->logout()) {redirect("index.php");}
?>
