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

			$row = $result[0];

			$this->setIdusuario($row['idusuario']);
			$this->setLogin($row['login']);
			$this->setSenha($row['senha']);
			$this->setDtcadastro(new DateTime($row['dtcadastro']));

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

			$row = $result[0];

			$this->setIdusuario($row['idusuario']);
			$this->setLogin($row['login']);
			$this->setSenha($row['senha']);
			$this->setDtcadastro(new DateTime($row['dtcadastro']));

		}else {
			throw new Exception("Login e/ou senha inválidos.");
		} 

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