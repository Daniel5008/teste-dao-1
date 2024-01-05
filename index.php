<?php

require_once("config.php");

// $sql = new Sql();

// $usuarios = $sql->select("SELECT * FROM tb_usuarios");

// echo json_encode($usuarios);


// Retorna somente o usuario do ID passado por parametro
// $user = new Usuario();
// $user->loadById(3);
// echo $user;


// Retorna listagem de todos os usuarios
// $lista = Usuario::getList();
// echo json_encode($lista);
// var_dump($lista[0]);


// Retorna lista de usuarios filtrando pelo login
// $search = Usuario::search("e");
// echo json_encode($search);

// Retorna informações de um usuario através de login e senha
$usuario = new Usuario();
$usuario->login("daniel", "123456789");

echo $usuario;



?>