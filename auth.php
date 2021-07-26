<?php include_once('include/load.php'); ?>

<?php
  $req_fields = array('username','password' );
  validate_fields($req_fields);
  $username = remove_junk($_POST['username']);
  $password = remove_junk($_POST['password']);

  if(empty($errors)){
    $user_id = authenticate($username, $password);
    if ($user_id > 0) {
      //create session with id
       $session->login($user_id);
      //Update Sign in time
       updateLastLogIn($user_id);
       $session->msg("s", "Bienvenido a EASY BUSINESS ___ By Yoel Monsalve, Abril 2021.");
       redirect(SITE_URL.'home.php',false);
    } else if ($user_id == -2) {
      $session->msg("w", "Usuario inactivo");
      redirect(SITE_URL.'index.php',false); 
    }
    else {
      $session->msg("d", "Nombre de usuario y/o contraseña incorrecto.");
      redirect(SITE_URL.'index.php',false);
    }
  } 
  else {
   $session->msg("d", $errors);
   redirect(SITE_URL.'index.php',false);
  }
?>
