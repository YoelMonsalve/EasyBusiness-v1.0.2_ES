<?php
require_once(LIB_PATH_INC.'load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
  global $db;
  if (tableExists($table)) {
    return find_by_sql("SELECT * FROM ".$db->escape($table));
  }
}
/*--------------------------------------------------------------*/
/*s Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
  return $result_set;
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
 * Returns the entire row of a table, matching by id.
/*--------------------------------------------------------------*/
function find_by_id($table, $id)
{
  global $db;
  $id = (int)$id;
  if (tableExists($table)) {
    $sql  = "SELECT * FROM ".$db->escape($table);
    $sql .= " WHERE id=".$db->escape($id);
    $sql .= " LIMIT 1";
    $sql_result = $db->query($sql);
    if( $result = $db->fetch_assoc($sql_result) )
      return $result;
    else
      return NULL;
  }
  else
    return NULL;
}

/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table, $id)
{
  global $db;
  if(tableExists($table))
  {
    $sql  = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $sql_result = $db->query($sql);
    if ($sql_result) {
      return ($db->affected_rows() === 1) ? TRUE : FALSE;  
    }
    else {
      return FALSE;
    }
  }
  return NULL;
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/

function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $sql_result = $db->query($sql);
    return $db->fetch_assoc($sql_result);
  }
  else
    return NULL;
}
/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
  if($table_exit) {
    if($db->num_rows($table_exit) > 0)
      return TRUE;
    else
      return FALSE;
  }
}

 /*--------------------------------------------------------------*/
 /* Login with the data provided in $_POST,
 /* coming from the login form.
/*--------------------------------------------------------------*/
function authenticate($username='', $password='') {
  global $db;
  $username = $db->escape($username);
  $password = $db->escape($password);
  $sql  = sprintf("SELECT id,username,password,user_level,status FROM users WHERE username ='%s' LIMIT 1", $username);
  $result = $db->query($sql);
  if ($db->num_rows($result)) {
    $user = $db->fetch_assoc($result);
    $password_request = hash("sha512", $password);
    if (is_numeric($user['status']) && ($status = intval($user['status'])) > 0) {
      if ($password_request === $user['password'])
        return $user['id'];
      else
        return -1;    // password doesn't match
    }
    else
      return -2;    // user is not active
  }
  return -1;   // default, don't concede access
}
/*--------------------------------------------------------------*/
/* Login with the data provided in $_POST,
/* coming from the login_v2.php form.
/* If you use this method then remove authenticate function.
/*--------------------------------------------------------------*/
function authenticate_v2($username='', $password='')
{
  global $db;
  $username = $db->escape($username);
  $password = $db->escape($password);
  $sql  = sprintf("SELECT id,username,password,user_level,status FROM users WHERE username ='%s' LIMIT 1", $username);
  $result = $db->query($sql);
  if ($db->num_rows($result)) {
    $user = $db->fetch_assoc($result);
    $password_request = hash("sha512", $password);
    if (is_numeric($user['status']) && ($status = intval($user['status'])) > 0) {
      if ($password_request === $user['password'])
        return $user['id'];
      else
        return -1;    // password doesn't match
    }
    else
      return -2;    // user is not active
  }
  return -1;   // default, don't concede access
}


/*--------------------------------------------------------------*/
/* Find current log in user by session id
/*--------------------------------------------------------------*/
function current_user() {
  static $current_user;
  global $db;
  if( !$current_user ) {
    if(isset($_SESSION['user_id'])) {
      $user_id = intval($_SESSION['user_id']);
      $current_user = find_by_id('users',$user_id);
    }
  }
  return $current_user;
}
/*--------------------------------------------------------------*/
/* Find all user by
/* Joining users table and user gropus table
/*--------------------------------------------------------------*/
function find_all_user() {
  global $db;
  $results = array();
  $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
  $sql .="g.group_name ";
  $sql .="FROM users u ";
  $sql .="LEFT JOIN user_groups g ";
  $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
  $result = find_by_sql($sql);
  return $result;
}

/**
 * Find all images
 * Retrieving id, and file_name from table `media`
 *
 * Author: Yoel Monsalve.
 * --------------------------------------------------------
 */
/*function find_all_media() {
  global $db;
  $results = array();
  $sql = "SELECT `id`,`file_name`,`file_type` FROM `media`";
  $result = find_by_sql($sql);
  return $result;
}*/

/*--------------------------------------------------------------*/
/* Function to update the last log in of a user
/*--------------------------------------------------------------*/

function updateLastLogIn($user_id)
{
	global $db;
  $date = make_date();
  $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
  $result = $db->query($sql);
  return ($result && $db->affected_rows() === 1 ? TRUE : FALSE);
}

/*--------------------------------------------------------------*/
/* Find all Group name
/*--------------------------------------------------------------*/
function find_by_groupName($val)
{
  global $db;
  $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
  $result = $db->query($sql);
  return($db->num_rows($result) === 0 ? TRUE : FALSE);
}
/*--------------------------------------------------------------*/
/* Find group level
/*--------------------------------------------------------------*/
function find_by_groupLevel($level)
{
  global $db;
  //$sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
  $sql = "SELECT * FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
  $result = $db->query($sql);
  //return($db->num_rows($result) === 0 ? TRUE : FALSE);
  return $result->fetch_assoc();
}
/*--------------------------------------------------------------*/
/* Function for checking which user level has access to page
/*--------------------------------------------------------------*/
function page_require_level($required_level) 
{
  global $session;
  $current_user = current_user();

  /* caution */
  /* === added by Yoel.- 2019.05.23 === */
  if ( !$current_user ) {
    redirect(SITE_URL.'/home.php', FALSE);
    return FALSE;
  }

  $login_group = find_by_groupLevel($current_user['user_level']);

  // if user is not logged in
  if (!$session->isUserLoggedIn(TRUE)) {
    $session->msg('d','Por favor Iniciar sesión...');
    redirect(SITE_URL.'/index.php', FALSE);
  }
  // if group status is inactive
  elseif($login_group['group_status'] === '0') {
    $session->msg('d','Este nivel de usaurio esta inactivo!');
    redirect(SITE_URL.'/home.php',FALSE);
  }
  // checking for (user level) <= (required level)
  elseif($current_user['user_level'] <= (int)$required_level) {
    return TRUE;
  }
  else {
    $session->msg("d", "¡Lo siento! no tienes permiso para ver la página.");
    redirect(SITE_URL.'/home.php', FALSE);
  }
}
/*--------------------------------------------------------------*/
/* Function for Finding all product name
/* JOIN with categorie and media database table
/*--------------------------------------------------------------*/
function join_product_table() 
{
  global $db;
  $sql  =" SELECT p.id,p.name,p.partNo,p.quantity,p.buy_price,p.sale_price,p.location,p.media_id,p.date,c.name";
  $sql  .=" AS categorie,m.file_name AS image";
  $sql  .=" FROM products p";
  $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
  $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
  $sql  .=" ORDER BY p.id ASC";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Finding all product name
/* Request coming from ajax.php for auto suggest
/*--------------------------------------------------------------*/
function find_product_by_title($product_name) 
{
  global $db;
  $p_name = remove_junk($db->escape($product_name));
  $sql = "SELECT name FROM products WHERE name like '%$p_name%' LIMIT 5";
  $result = find_by_sql($sql);
  return $result;
 }

/** Search a product by its name
 * 
 *  By Yoel Monsalve -- June, 2020.
 */
function find_product_by_name( $p_name ) 
{
  global $db;        // <-- ???

  $p_name = remove_junk( $db->escape( $p_name ) );
  $sql_query  = "SELECT * FROM `products`";
  $sql_query .= " WHERE `name`='${p_name}'";
  $sql_query .= " LIMIT 1";
  $sql_result = $db->query( $sql_query );
  if ( $result = $db->fetch_assoc( $sql_result) ) {
    return $result;
  }
  else
    return NULL;        /* yoel: 'NULL' is on pretty old C-style */
}

/** Search a product by its partNo/COD
 * 
 *  By Yoel Monsalve -- June, 2020.
 */
function find_product_by_partNo( $partNo, $mode = 0 ) 
{
  global $db;        // <-- ???

  $partNo = remove_junk( $db->escape( $partNo ) );
  /* exact match */
  if ( $mode == 0 ) {
    $sql_query  = "SELECT * FROM `products`";
    $sql_query .= " WHERE `partNo`='${partNo}'";
    $sql_query .= " LIMIT 1";

    $sql_result = $db->query( $sql_query );
    $result = $db->fetch_assoc( $sql_result);
  }
  /* partial match */
  else {
    $sql_query  = "SELECT `partNo` FROM `products`";
    $sql_query .= " WHERE `partNo` LIKE '%${partNo}%'";
    $sql_query .= " LIMIT 5"; 

    $result = find_by_sql( $sql_query);
  }
  if ( $result ) {
    return $result;
  }
  else
    return NULL;        /* yoel: this 'NULL' is on pretty old C-style, so nice! */
}

/*--------------------------------------------------------------*/
/* Function for Finding all product info by product title
/* Request coming from ajax.php
/*--------------------------------------------------------------*/
function find_all_product_info_by_title($title) {
  global $db;
  $sql  = "SELECT * FROM products ";
  $sql .= " WHERE name ='{$title}'";
  $sql .=" LIMIT 1";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Function for Update product quantity
/*--------------------------------------------------------------*/
function substract_product_qty($qty, $p_id) {
  global $db;
  $qty = (int)$qty;
  $id  = (int)$p_id;
  if (!is_numeric($qty)) return FALSE;
  if ($qty >= 0)
    $sql  =  "UPDATE products SET quantity = quantity - '{$qty}'";
  else {
    $qty = -$qty;
    $sql  =  "UPDATE products SET quantity = quantity + '{$qty}'";
  }
  
  $sql .= " WHERE id = '{$id}'";
  $result = $db->query($sql);
  return($db->affected_rows() === 1 ? TRUE : FALSE);
}

function add_product_qty($qty, $p_id) {
  global $db;
  $qty = (int)$qty;
  $id  = (int)$p_id;
  if (!is_numeric($qty)) return FALSE;
  if ($qty >= 0)
    $sql  =  "UPDATE products SET quantity = quantity + '{$qty}'";
  else {
    $qty = -$qty;
    $sql  =  "UPDATE products SET quantity = quantity - '{$qty}'";
  }

  $sql .= " WHERE id = '{$id}'";
  $result = $db->query($sql);
  return($db->affected_rows() === 1 ? TRUE : FALSE);
}

/** Update the product quantity
 * 
 *  By Yoel Monsalve -- June, 2020.
 */
function update_product_qty($p_id, $p_qty) {
  global $db;
  $qty = (int)$p_qty;
  $id  = (int)$p_id;
  $sql  =  "UPDATE products SET quantity = '{$p_qty}'";
  $sql .= " WHERE id = '{$id}'";

  $result = $db->query($sql);
  return($db->affected_rows() === 1 ? TRUE : FALSE);
}

/*--------------------------------------------------------------*/
/* Function for Display Recent product Added
/*--------------------------------------------------------------*/
function find_recent_product_added($limit){
 global $db;
 $sql   = " SELECT p.id,p.name,p.sale_price,p.media_id,c.name AS categorie,";
 $sql  .= "m.file_name AS image FROM products p";
 $sql  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
 $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
 $sql  .= " ORDER BY p.id DESC LIMIT ".$db->escape((int)$limit);
 return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Find Highest saleing Product
/*--------------------------------------------------------------*/
function find_higest_saleing_product($limit){
 global $db;
 $sql  = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.qty) AS totalQty";
 $sql .= " FROM sales s";
 $sql .= " LEFT JOIN products p ON p.id = s.product_id ";
 $sql .= " GROUP BY s.product_id";
 $sql .= " ORDER BY SUM(s.qty) DESC LIMIT ".$db->escape((int)$limit);
 return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for find all sales
/*--------------------------------------------------------------*/
function find_all_sales(){
 global $db;
 $sql  = "SELECT s.id,s.product_id,s.qty,s.sale_price,s.total_sale,s.destination,s.date,p.name";
 $sql .= " FROM sales s";
 $sql .= " LEFT JOIN products p ON s.product_id = p.id";
 $sql .= " ORDER BY s.date DESC";
 return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Display Recent sale
/*--------------------------------------------------------------*/
function find_recent_sale_added($limit){
  global $db;
  $sql  = "SELECT s.id,s.qty,s.sale_price,s.date,p.name";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " ORDER BY s.date DESC LIMIT ".$db->escape((int)$limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function find_sale_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date,p.name,s.destination,p.sale_price,p.buy_price,";
  $sql .= "COUNT(s.product_id) AS total_records,";
  //$sql .= "SUM(s.qty) AS total_sales,";
  $sql .= "SUM(s.qty) AS total_qty,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.product_sid = p.id";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(s.date),p.name";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
}

/** --------------------------------------------------------------
 *  Generate Daily sales report
 *  --------------------------------------------------------------
 *  Changed by Yoel.-
 *  Summary of sales, totalized by each distinct product, in a
 *  specific day.
 */
function dailySales($year, $month, $day){
  global $db;

  /*$sql  = "SELECT s.qty,s.destination,";
  $sql .= "DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,p.partNo,";
  $sql .= "SUM(s.total_sale) AS total_saleing_price,";
  $sql .= "SUM(s.qty) AS total_qty,";
  $sql .= "SUM(s.profit) AS total_profit";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y-%m') = '{$year}-{$month}'";
  $sql .= " GROUP BY DATE_FORMAT(s.date, '%e'),s.product_id";
  $sql .= " ORDER BY DATE_FORMAT(s.date, '%c') ASC";
  return find_by_sql($sql);*/

  if (!is_numeric($year) || $year < 1970) return NULL;
  if (!is_numeric($month) || $month < 1 || $month > 12) return NULL;
  if (!is_numeric($day) || $day < 1 || $day > 31) return NULL;

  /* formatting date fields properly, to the SQL pattern %Y-%m-%d */
  $year  = sprintf("%04d", intval($year));
  $month = sprintf("%02d", intval($month));
  $day   = sprintf("%02d", intval($day));

  $sql  = "SELECT DATE_FORMAT(s.date, '%Y-%m-%d') AS date";
  $sql .= ",p.partNo,p.name,s.destination";
  $sql .= ",SUM(s.qty) AS total_qty";
  $sql .= ",SUM(s.total_sale) AS total_sale";
  $sql .= ",SUM(s.profit) AS total_profit";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y-%m-%d') = '{$year}-{$month}-{$day}'";
  $sql .= " GROUP BY date,p.name,p.partNo,s.destination";
  $sql .= " ORDER BY date ASC";
  
  return find_by_sql($sql);
}

/** --------------------------------------------------------------
 *  Generate Weekly sales report
 *  --------------------------------------------------------------
 *  Changed by Yoel.-
 *  Summary of sales, totalized by each distinct product, in a
 *  specific day.
 */
function weeklySales($year, $month, $day){
  global $db;

  if (!is_numeric($year) || $year < 1970) return NULL;
  if (!is_numeric($month) || $month < 1 || $month > 12) return NULL;
  if (!is_numeric($day) || $day < 1 || $day > 31) return NULL;

  /* formatting date fields properly, to the SQL pattern %Y-%m-%d */
  $year  = sprintf("%04d", intval($year));
  $month = sprintf("%02d", intval($month));
  $day   = sprintf("%02d", intval($day));

  $sql  = "SELECT ";
  $sql .= "p.partNo,p.name";
  $sql .= ",SUM(s.qty) AS total_qty";
  $sql .= ",SUM(s.total_sale) AS total_sale";
  $sql .= ",SUM(s.profit) AS total_profit";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%v') = DATE_FORMAT('{$year}-{$month}-{$day}','%v')";
  $sql .= " GROUP BY p.name,p.partNo";
  $sql .= " ORDER BY total_sale DESC";

  return find_by_sql($sql);
}


/** --------------------------------------------------------------
 *  Generate Monthly sales report
 *  --------------------------------------------------------------
 *  Changed by Yoel.-
 *  Summary of sales, totalized by each distinct product, in a
 *  specific month.
 */
function monthlySales($year, $month) {
  global $db;

  if (!is_numeric($year) || $year < 1970) return NULL;
  if (!is_numeric($month) || $month < 1 || $month > 12) return NULL;

  /* formatting date fields properly, to the SQL pattern %Y-%m-%d */
  $year  = sprintf("%04d", intval($year));
  $month = sprintf("%02d", intval($month));

  $sql  = "SELECT ";
  $sql .= "p.partNo,p.name";
  $sql .= ",SUM(s.qty) AS total_qty";
  $sql .= ",SUM(s.total_sale) AS total_sale";
  $sql .= ",SUM(s.profit) AS total_profit";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y-%m') = '{$year}-{$month}'";
  $sql .= " GROUP BY p.name,p.partNo";
  $sql .= " ORDER BY total_sale DESC";
  
  return find_by_sql($sql);
}

/** --------------------------------------------------------------
 *  Generate a sales report by date renge
 *  --------------------------------------------------------------
 *  Changed by Yoel.-
 *  Summary of sales, totalized by each distinct product, in a
 *  specific month.
 */
function salesByDateRange($date_start, $date_end) {
  global $db;

  /* ! replaces is_null(), empty(), etc */
  if (!$date_start || !$date_end) return NULL;

  $sql  = "SELECT ";
  //$sql .= "p.partNo,p.name,s.destination";
  $sql .= "p.partNo,p.name";
  $sql .= ",SUM(s.qty) AS total_qty";
  $sql .= ",SUM(s.total_sale) AS total_sale";
  $sql .= ",SUM(s.profit) AS total_profit";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE s.date BETWEEN '{$date_start}' AND '{$date_end}'";
  $sql .= " GROUP BY p.name,p.partNo";
  $sql .= " ORDER BY total_sale DESC";
  
  return find_by_sql($sql);
}

?>
