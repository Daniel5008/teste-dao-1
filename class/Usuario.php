<?php

class Usuario {

	private $idusuario;
	private $login;
	private $senha;
	private $dtcadastro;

	public function getIdusuario() {
		return $this->idusuario;
	}

	public function setIdusuario($value){
		$this->idusuario = $value;
	} 

	public function getLogin() {
		return $this->login;
	}

	public function setLogin($value){
		$this->login = $value;
	} 

	public function getSenha() {
		return $this->senha;
	}

	public function setSenha($value){
		$this->senha = $value;
	} 

	public function getDtcadastro() {
		return $this->dtcadastro;
	}

	public function setDtcadastro($value){
		$this->dtcadastro = $value;
	} 


	public function loadById($id){

		$sql = new Sql();

		$result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
			":ID"=>$id
		));

		if(count($result) > 0) {

			$this->setData($result[0]);

		}

	}

	public static function getList(){

		$sql = new Sql();

		$result = $sql->select("SELECT * FROM tb_usuarios ORDER BY login;");

		return $result;

	}

	public static function search($login) {

		$sql = new Sql();

		$result = $sql->select("SELECT * FROM tb_usuarios WHERE login LIKE :SEARCH ORDER BY login;", array(
			":SEARCH"=>"%" . $login . "%"
		));

		return $result;

	}

	public function login($login, $password){

		$sql = new Sql();

		$result = $sql->select("SELECT * FROM tb_usuarios WHERE login = :LOGIN AND senha = :PASSWORD", array(
			":LOGIN"=>$login,
			":PASSWORD"=>$password
		));

		if(count($result) > 0) {

			$this->setData($result[0]);

		}else {
			throw new Exception("Login e/ou senha inválidos.");
		} 

	}

	public function setData($data){

		$this->setIdusuario($data['idusuario']);
		$this->setLogin($data['login']);
		$this->setSenha($data['senha']);
		$this->setDtcadastro(new DateTime($data['dtcadastro']));

	}


	public function insert(){

		$sql = new Sql();

		$result = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			":LOGIN"=>$this->getLogin(),
			":PASSWORD"=>$this->getSenha()
		));

		if(count($result)){
			$this->setData($result[0]);
		}

	}


	public function update($login, $password){

        $this->setLogin($login);
        $this->setSenha($password);

        $sql = new Sql();

        $sql->sqlQuery("UPDATE tb_usuarios SET login = :LOGIN, senha = :PASSWORD WHERE idusuario = :ID", array(

            ':LOGIN'=>$this->getLogin(),
            ':PASSWORD'=>$this->getSenha(),
            ':ID'=>$this->getIdusuario()

        ));

    }

	public function __construct($login = "", $password = ""){
		$this->setLogin($login);
		$this->setSenha($password);
	}


	public function __toString(){

		return json_encode(array(
			"idusuario"=>$this->getIdusuario(),
			"login"=>$this->getLogin(),
			"senha"=>$this->getSenha(),
			"dtcadastro"=>$this->getDtcadastro()->format("d-m-Y H:i:s")
		));

	}

}

?>