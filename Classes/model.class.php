<?php 

/* DBZ MODELE KAMEHAMEHA */

class Model {
  
  private $PDO = NULL;
  
  public function __construct ($pdo) {
    $this->PDO = $pdo;
  }
  
  // db name
  public function Name_DB () {
    return $this->PDO->Query('select database()')->fetchColumn();
  }
  
  // list table
  public function Request ($sql) {
    $RES = $this->PDO->prepare($sql);
    if($RES->execute()) return $RES->fetchAll(PDO::FETCH_ASSOC);
    else return false;

  }

  public function Exec_request($sql){
    $RES = $this->PDO->prepare($sql);
    if($RES->execute()) return true;
    else return false;
  }
  
}

?>
