<?php include_once('include/load.php'); ?>
<?php
$req_fields = array('username','password' );
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

  if(empty($errors)){

    $user = authenticate_v2($username, $password);

        if($user):
           //create session with id
           $session->login($user['id']);
           //Update Sign in time
           updateLastLogIn($user['id']);
           // redirect user to group home page by user level
           if($user['user_level'] === '1'):
             $session->msg("s", "Hello ".$user['username'].", Welcome to OSWA-INV.");
             redirect(SITE_PATH.'admin.php',false);
           elseif ($user['user_level'] === '2'):
              $session->msg("s", "Hello ".$user['username'].", Welcome to OSWA-INV.");
             redirect(SITE_PATH.'special.php',false);
           else:
              $session->msg("s", "Hello ".$user['username'].", Welcome to OSWA-INV.");
             redirect(SITE_PATH.'home.php',false);
           endif;

        else:
          $session->msg("d", "Sorry Username/Password incorrect.");
          redirect(SITE_PATH.'index.php',false);
        endif;

  } else {

     $session->msg("d", $errors);
     redirect(SITE_PATH.'login_v2.php',false);
  }

?>
