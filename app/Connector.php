<?php
  class Connector {
    const MODE = TRUE;
    private $production_mode;
    private $DBhost;
    private $DBname;
    private $DBuser;
    private $DBpass;
    private $connector;
    public function __construct(){
      $this->production_mode = self::MODE;
      if ($this->production_mode) {
        $this->DBhost = 'localhost';
        $this->DBname = 'adm_sienna';
        $this->DBuser = 'root';
        $this->DBpass = '';
      }
      else {
        $this->DBhost = 'localhost';
        $this->DBname = 'adm_sienna';
        $this->DBuser = 'root';
        $this->DBpass = '';
      }
      $this->connector = new PDO("mysql:host=$this->DBhost;dbname=$this->DBname;charset=utf8",
      $this->DBuser,
      $this->DBpass,
      array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
      $this->connector->query("SET lc_time_names = 'es_ES';");
    }
    function __destruct(){
      $this->connector = null;
    }
    public function consult($query, $params = null, $single = NULL){
      $response = array();
      $sentencia = $this->connector->prepare($query);
      if ($sentencia->execute($params)) {
        while ($fila = $sentencia->fetch(PDO::FETCH_ASSOC)) {
          $response[] = $fila;
        }
      } 
      else {
        if (!$this->production_mode) {
          echo "-- ERROR LIST: ";
          print_r($sentencia->errorInfo());
        }
        $response = null;
      }
      if ($single) return reset($response);
      else return $response;
    }
    public function execute($query, $params){
      $response = null;
      $sentencia = $this->connector->prepare($query);
      if ($sentencia->execute($params)) {
        if ($this->connector->lastInsertId()) $response = $this->connector->lastInsertId();
        else $response = true;
      }
      else {
        if (!$this->production_mode) {
          echo "-- ERROR LIST: ";
          print_r($sentencia->errorInfo());
        }
      }
      return $response;
    }
  }
?>