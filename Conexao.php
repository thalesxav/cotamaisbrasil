<?php


ini_set('memory_limit', '128M');
set_time_limit(260);
ini_set('display_errors', 1);
error_reporting(E_ALL);

class Conexao{
  private $db;
  private $lnk;
  private $host;
  private $user;
  private $pass;

  
  public function __construct(){
    $this->lnk = false;
    //$this->db = 'nacha532_automaisbh';
    $this->db = 'cotamaisbrasil';
    //$this->host = 'localhost';
    $this->host = 'localhost';
    //$this->user = 'nacha532_admin';
    $this->user = 'root';
    //$this->pass = 'HC#cs?<I2qc&~AQNwpge';
    $this->pass = '';
  }


 public function set_db($db){
    $this->db = $db;
  }

  public function conectar(){
  	
  	try
	{
		//echo 'aki';exit;
		if(!$this->is_conected())
		{
			//var_dump($this);
			//var_dump($this->lnk = mysqli_connect($this->host, $this->user, $this->pass));
		    if ($this->lnk = mysqli_connect($this->host, $this->user, $this->pass))
		    {
		        //echo 'oi';
		         mysqli_select_db($this->lnk, $this->db); 
		    }
		    else
		    {
		    	if (mysqli_connect_errno()) {
				    throw new RuntimeException("Connect failed: %s\n", mysqli_connect_error());
				}
		    	echo 'erro';
		        throw new Exception('Unable to connect');
		    }
		}
	}
	catch(Exception $e)
	{
	    throw new $e->getMessage();
	}
  	/*
  	try{
	    if(!$this->is_conected()){
	      $this->lnk = mysqli_connect($this->host, $this->user, $this->pass) or $this->trata_erro(mysqli_error($this->lnk), __LINE__, $query);
	      mysqli_select_db($this->lnk, $this->db); 
	    }
  	}
  	catch (\Exception $e) {
		var_dump($e);
	    echo $e->getMessage();exit;
	}*/
  }

  public function desconectar(){
    mysqli_close($this -> lnk);
  }

  public function is_conected(){
    if($this->lnk === false)
      return false;
    else
      return true;
  }

  public function get_link(){
    if($this->lnk === false)
      return false;
    else
      return $this->lnk;
  }

  public function exec_query($query, $unbuffered = false){
      //var_dump($this->is_conected());
      //var_dump($this->conectar());
    if(!$this->is_conected())
      $this->conectar();
    $conn = $this->lnk;
    $query = $this->formata_str_query($query);
    $dados = mysqli_query($conn, $query) or $this->trata_erro(mysqli_error($conn), __LINE__, $query);
    return $dados;
  }

  public function trata_erro($erro, $linha, $query){
  	var_dump($erro);
    if($erro == 'MySQL server has gone away' || $erro == 'Server shutdown in progress'){
      $this->lnk = false;
      $this->exec_query($query, $leitura, false);
    }
    else
      die($this->erro($erro, $linha, $query));
  }

  public function erro($erro_mysql, $linha, $query = ''){echo $erro_mysql;exit;
    $message = $erro_mysql."\nQuery: ".$query."\n\nSERVER:".print_r($_SERVER, true);
    $ArrayMail['mails'][]='xavier.thales@gmail.com';
      $ArrayMail['assunto']='Erro mysql';
      $ArrayMail['conteudo_html']=$message;
      //require('config.class.php');
      $d = Config::MailSMTP($ArrayMail);
        if($d){
            $msg='OK';
        }
        else    
            $msg='--erro';
    /*mail('thales_xav@hotmail.com', 'Erro MySQL - '.$query, $message);
    if(!defined('CONFIG'))
      require_once('/var/www/vhosts/autoscontagem.com.br/httpdocs/config.class.php');
    if(Config::is_adm()){
      return 'Erro na linha '.$linha.'! '.$erro_mysql.' - '.$query;  
    }*/
    return 'Ops... ocorreu um erro no banco de dados. Por favor, tente novamente.'.$query.' '.$message.' ('.$msg.')';
  }

  public function formata_str_query($query){
    $aux = explode("\n", $query);
    foreach($aux as $k => $value)
      $aux[$k] = trim($value);
    return implode("\n", $aux);
  }

  function table_exists($tabela, $db){
    if(!$this -> is_conected(true))
      $this -> conectar(true);
      
    mysqli_select_db($this->lnk, $db);
    $dados = $this->exec_query('SHOW TABLES LIKE "'.$tabela.'"', true, false);
    $res = mysqli_fetch_assoc($dados);
    if($res != null)
      return true;
    else
      return false;
  }

  function retorna_id(){
    return mysqli_insert_id($this->get_link(false));
  }
}
?>