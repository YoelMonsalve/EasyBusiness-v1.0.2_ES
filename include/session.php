<?php

class Session {

  public $msg;
  private $user_is_logged_in = FALSE;

  function __construct(){
    $this->flash_msg();
    $this->userLoginSetup();
  }

  public function isUserLoggedIn() {
    return $this->user_is_logged_in;
  }

  public function login($user_id) {
    $_SESSION['user_id'] = $user_id;
  }

  private function userLoginSetup() {
    if( isset($_SESSION['user_id']) ) {
      $this->user_is_logged_in = TRUE;
    } else {
      $this->user_is_logged_in = FALSE;
    }
  }

  public function logout() {
    unset($_SESSION['user_id']);
  }

  /** Sets the message of the session, for the given type, at the given value .
   *  This function edit the field 'msg' in the supervariable $_SESSION.
   *  @type Allowed values are: 'd', 'i', 'w', 's'
            'd': danger 
            'i': info
            'w': warning
            's': success
      @msg The text of the message to set. If empty, the function rather returns
           the current message already set in the object.
  */
  public function msg($type='', $msg='') {
    if( !empty($msg) ){
       if( strlen(trim($type)) == 1 ){
          $type = str_replace( array('d', 'i', 'w','s'), array('danger', 'info', 'warning','success'), $type );
          $_SESSION['msg'][$type] = $msg;
       }
    } else {
      return $this->msg;
    }
  }

  /** At creation of the object, this function serves to retrieve the current value
   *  of the message from the supervariable $_SESSION.
   */
  private function flash_msg() {
    if( isset($_SESSION['msg']) ) {
      $this->msg = $_SESSION['msg'];
      unset($_SESSION['msg']);
    } else {
      $this->msg;
    }
  }

  /* added by Yoel at 2020.05.23 */  
  public function __destruct() {
    session_write_close();
  }
}

/* === prevention code ===
 * added by Yoel at 2019.03.11 */
if ( session_status( ) !== PHP_SESSION_ACTIVE ) {
  session_start();
}

/* loading an object Session, from the current PHP session */
$session = new Session();
$msg = $session->msg();

?>