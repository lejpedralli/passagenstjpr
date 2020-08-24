<?php
session_start();

include_once 'conexao.php';

$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);

if($btnLogin){	
	$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

	//echo "$usuario - $senha";
	
	if((!empty($usuario)) AND (!empty($senha))){
		//Gerar a senha criptografa
		//echo password_hash($senha, PASSWORD_DEFAULT);
		//Pesquisar o usuário no BD
		$result_usuario = "SELECT tbl_usuario.id_usuario, tbl_usuario.id_pessoa, tbl_usuario.usuario, tbl_usuario.senha, tbl_pessoa.nome_completo, tbl_pessoa.matricula
		FROM tbl_pessoa
		INNER JOIN tbl_usuario ON tbl_pessoa.id_pessoa = tbl_usuario.id_pessoa
		WHERE usuario = '$usuario' LIMIT 1";

		$resultado_usuario = $conn->prepare($result_usuario);
		$resultado_usuario->execute();
		
		if($resultado_usuario){
			$row_usuario = $resultado_usuario->fetch(PDO::FETCH_ASSOC);		
			
			if(password_verify($senha, $row_usuario['senha'])){
				$_SESSION['id_usuario'] = $row_usuario['id_usuario'];
				$_SESSION['id_pessoa'] = $row_usuario['id_pessoa'];
				$_SESSION['nome_completo'] = $row_usuario['nome_completo'];
				$_SESSION['usuario'] = $row_usuario['usuario'];
				$_SESSION['senha'] = $row_usuario['senha'];
				$_SESSION['status_usuario'] = $row_usuario['status_usuario'];
				$_SESSION['matricula'] = $row_usuario['matricula'];
				
				header("Location: inicio.php");
			}else{
				$_SESSION['msg'] = "Login ou senha incorreto!";
				header("Location: index.php");
			}
		}
	}else{
		$_SESSION['msg'] = "Preencha todos os campos!";
		header("Location: index.php");
	}
}else{
	$_SESSION['msg'] = "Página não encontrada";
	header("Location: index.php");
}

?>