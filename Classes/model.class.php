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
    $RES->execute();
    return $RES->fetchAll(PDO::FETCH_ASSOC);
  }
  
}

?>
