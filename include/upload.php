<?php

class Media {

  /* yoel: changed to private members !!!
           minimum privilege principle
           2021.03.03
  */
  //public $imageInfo;
  //public $fileName;
  //public $fileType;
  //public $fileTempPath;
  private $imageInfo;
  private $fileName;
  private $fileType;
  private $fileTempPath;

  public $errors = array();
 	/* 
 	// English.-
  public $upload_errors = array(
    0 => 'There was no error, the file was uploaded with success',
    1 => 'The file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The file was only partially uploaded',
    4 => 'No file was uploaded',
    5 => 'The path to contain the file is undefined',
    6 => 'Missing a temporary folder',
    7 => 'Failed when writing file to disk.',
    8 => 'A PHP extension stopped the file upload.'
  );
	*/
	# Spanish.-
  public $upload_errors = array(
    0 => 'Sin error, el archivo se subió con éxito',
    1 => 'El tamaño de archivo excede la directiva upload_max_filesize en php.ini',
    2 => 'El tamaño de archivo excede la directiva MAX_FILE_SIZE especificada en el formulario HTML',
    3 => 'El archivo fue subido parcialmente',
    4 => 'No seleccionó el archivo',
    5 => 'No se ha definido la ruta para guardar el archivo',
    6 => 'Se perdió una carpeta temporal',
    7 => 'Falló la escritura del archivo en disco',
    8 => 'Una extensión PHP detuvo la carga del archivo'
  );
  /* yoel: Changed this member to *PRIVATE*, this way NOT allowing to
   *       upload other types of files (security breach) 
   *
   * 2021.02.24.-
   */
  private $upload_extensions = array(
   'gif',
   'jpg',
   'jpeg',
   'png',
  );
  
	/* === added by Yoel.- 2019.03.11 === 
	 * Constructor
	 */
	public function __construct() 
  {
		$this->set_paths( );
	}
  public function __destruct() 
  {
    $this->userPath    = "";
    $this->productPath = "";    
  }
 
 	/* === added by Yoel.- 2019.03.11 === */
	private function set_paths() 
  {
    /* Yoel changed the value for the constant SITE_ROOT */
    $this->userPath    = SITE_ROOT . DS . 'uploads/users';
    $this->productPath = SITE_ROOT . DS . 'uploads/products';    
	}
	
  /* yoel: name name changed to "is_correct_file_type"
   * 2021.02.24.- */
  public function is_correct_file_type($filename) 
  {
    return in_array($this->file_ext($filename), $this->upload_extensions);
  }
  private function file_ext($filename) 
  {
    //$ext = strtolower(substr( $filename, strrpos( $filename, '.' ) + 1 ) );   // old-code
    return end(explode('.', $filename));
  }

  public function upload($file)
  {
    if( !$file || empty($file) || !is_array($file) ) {
      $this->errors[] = "Ningún archivo subido.";
      return false;
     }
    elseif( $file['error'] != 0 ) {
      /* error per PHP upload method */ 
      $this->errors[] = $this->upload_errors[$file['error']];
      return false;
    }
    elseif( !$this->is_correct_file_type($file['name']) ) {
      $this->errors[] = 'Formato de archivo incorrecto ';
      return false;
    }
    else {
      $this->imageInfo = getimagesize($file['tmp_name']);
      $this->fileName  = basename($file['name']);
      $this->fileType  = $this->imageInfo['mime'];
      $this->fileTempPath = $file['tmp_name'];

     	return true;
   	}
  }

  /* changed by yoel to "check_file()".
   * this function actually does not "process", doesn't move the file,
   * just checks the file and the destination .
   * 2021.02.24.- 
   * -------------------------------------------------- */
	public function check_file() {
    if (!empty($this->errors)) {
      return false;
    }
    elseif (empty($this->fileName) || empty($this->fileTempPath) || empty($this->productPath)) {
      $this->errors[] = "La ubicación del archivo no esta disponible.";
      return false;
    }
    elseif (!is_writable($this->productPath)) {
      $this->errors[] = "Debe tener permisos de escritura";
      return false;
    }
    elseif (file_exists($this->productPath."/".$this->fileName)) {
      $this->errors[] = "El archivo {$this->fileName} ya existe.";
      return false;
    }
    else {
    	return true;
    }
 	}
	/*--------------------------------------------------------------
	 * Function to process media file
	 *--------------------------------------------------------------*/
  /* changed by yoel from "process_media" to "process_produt_media" 
   * 2021.02.24.- */
  public function process_product_media() 
  {
    if (!empty($this->errors)) {
      return false;
    }
    if (empty($this->fileName) || empty($this->fileTempPath) || empty($this->productPath)) {
      $this->errors[] = "La ubicación del archivo no se encuenta disponible.";
      return false;
    }
    if (!is_writable($this->productPath)) {
      $this->errors[] = sprintf("Debe tener permisos de escritura");
      return false;
    }
    if (file_exists($this->productPath.DS.$this->fileName)) {
      $this->errors[] = "El archivo {$this->fileName} ya existe.";
      return false;
    }
    if (move_uploaded_file($this->fileTempPath,$this->productPath.DS.$this->fileName)) {
	    if ($this->insert_media()) {
	      unset($this->fileTempPath);
	      return true;
	    }
    } 
    else {
      $this->errors[] = "Error en la carga del archivo, posiblemente debido a permisos incorrectos en la carpeta de carga.";
      return false;
    }
  }

  /** Replace the picture associate to a product, by another file name
   */
  public function change_product_media($id) 
  {
    global $db;
    if (!empty($this->errors)) {
      return false;
    }
    if (!is_numeric($id) || ($id = intval($id)) < 1) {
      $this->errors[] = "ID de archivo incorrecto.";
      return false;
    }
    if (empty($this->fileName) || empty($this->fileTempPath) || empty($this->productPath)) {
      $this->errors[] = "La ubicación del archivo no se encuenta disponible.";
      return false;
    }
    if (!is_writable($this->productPath)) {
      $this->errors[] = sprintf("Debe tener permisos de escritura");
      return false;
    }
    if (!file_exists($this->productPath.DS.$this->fileName)) {
      ;
    }
    if (move_uploaded_file($this->fileTempPath, $this->productPath.DS.$this->fileName)) {
      // saving the name to the 'old' file
      $old_entry = find_by_id('media', $id);
      if (isset($old_entry['file_name'])) 
        $oldFileName = $old_entry['file_name'];
      else
        $oldFileName = '';

      if (!$this->update_media($id)) {
        return false;
      }
      else
        //unset($this->fileTempPath);
        $this->fileTempPath = '';

      // cleaning:
      // then, check if any other entry in the table 'media' is using
      // this fileName, if not, delete that file
      $sql = "SELECT COUNT(*) as N_entries FROM `media` WHERE `file_name`='{$oldFileName}'";
      if ($r_set = $db->query($sql)) {
        $r = $db->fetch_assoc($r_set);
        if (isset($r['N_entries']) && is_numeric($r['N_entries']) && intval($r['N_entries']) == 0) {
          unlink($this->productPath . DS . $oldFileName);
        }
      }
      return true;
    }
    else {
      $this->errors[] = "Error en la carga del archivo, posiblemente debido a permisos incorrectos en la carpeta de carga.";
      return false;
    }
  }

  /*--------------------------------------------------------------*/
  /* Function to process user image
  /*--------------------------------------------------------------*/
  /* Changed by yoel from "process_user" to "process_user_media"
   * 2021.02.24.-
   *
   * Notes:
   *  a.- Not "unset" the variable fileTempPath, instead set it to empty string ("")
   *  b.- Invert process: FIRST, upload new image, THEN destroy the old one
   */
 	public function process_user_media($id) 
 	{
    global $db;

    if (!empty($this->errors)) {
      return false;
    }
    if (!$id || !is_numeric($id) || intval($id) < 0) {
      $this->errors[] = "ID de usuario incorrecto";
      return false;
    }
    if (empty($this->fileName) || empty($this->fileTempPath)) {
      $this->errors[] = "La ubicación del archivo no se encuentra disponible.";
      return false;
    }
    if (!is_writable($this->userPath)) {
      $this->errors[] = sprintf("Debe tener permisos de escritura");
      return false;
    }

    $ext = $this->file_ext($this->fileName);
    $new_name = randString(8).$id.'.'.$ext;

    $this->fileName = $new_name;
    if ($this->user_image_destroy($id)) {
      if (move_uploaded_file($this->fileTempPath, $this->userPath.DS.$this->fileName)) {
  			if ($this->update_user_image($id)) {
  			  $this->fileTempPath = "";
  			  return true;
  			}
        else {
          $this->errors[] = $db->get_last_error();
          return false;    
        }
      } 
      else {
        $this->errors[] = "Error en la carga del archivo, posiblemente debido a permisos incorrectos en la carpeta de carga.";
        return false;
      }
  	}
    else {
      $this->errors[] = "Error en la carga del archivo, posiblemente debido a permisos incorrectos en la carpeta de carga.";
      return false;
    }
 	}

	/*--------------------------------------------------------------*/
	/* Function to update user image
	/*--------------------------------------------------------------*/
  /* Yoel: "update" means in the DB */
  private function update_user_image($id) 
  {
    global $db;
    $sql = "UPDATE users SET";
    $sql .=" image='{$db->escape($this->fileName)}'";
    $sql .=" WHERE id='{$db->escape($id)}'";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Function to insert media image
  /*--------------------------------------------------------------*/
  /* Yoel: "insert" means in the DB */
  private function insert_media()
  {
    global $db;
    //$sql  = "INSERT INTO `media`(`file_name`,`file_type`)";
    //$sql .=" VALUES ";
    //$sql .="(
    //  '{$db->escape($this->fileName)}',
    //  '{$db->escape($this->fileType)}'
    //)";
    $sql  = "INSERT INTO `media` SET";
    $sql .=" `file_name`='{$db->escape($this->fileName)}'";
    $sql .=",`file_type`='{$db->escape($this->fileType)}'";
    return ($db->query($sql) ? true : false);
  }
  /* Yoel: method to replace */
  private function update_media($id)
  {
    global $db;
    $sql  = "UPDATE `media` SET";
    $sql .=" `file_name`='{$db->escape($this->fileName)}'";
    $sql .=",`file_type`='{$db->escape($this->fileType)}'";
    $sql .=" WHERE `id`=" . $db->escape($id);
    return ($db->query($sql) ? true : false);
  }
	/*--------------------------------------------------------------*/
	/* Function to delete the old image from the server
	/*--------------------------------------------------------------*/
  public function user_image_destroy($id) 
  {
		$image = find_by_id('users', $id);
    if (!$image) return true;
		if ($image['image'] === 'no_image.jpg') {
		  return true;
    }
		else {
		  unlink( $this->userPath.DS.$image['image'] );
		  return true;
		}
  }
	/*--------------------------------------------------------------*/
	/* Function to delete media by id
	/*--------------------------------------------------------------*/
  public function media_destroy($id, $file_name)
  {
		$this->fileName = $file_name;
		if (empty($this->fileName)) {
			$this->errors[] = "Falta el archivo de foto.";
			return false;
 		}
		if (!$id) {
		 	$this->errors[] = "Falta ID de foto.";
		 	return false;
		}
		if (delete_by_id('media',$id)) {
			return unlink($this->productPath.'/'.$this->fileName);
		}
    else {
			$this->error[] = "Se ha producido un error en la eliminación de fotografías.";
      //$this->errors[] = $db->get_last_error();
			return false;
		}
  }
}
?>