<?php
session_start();

ob_start();

include_once 'conexao.php';

$btnCadItem = filter_input(INPUT_POST, 'btnCadItem', FILTER_SANITIZE_STRING);

if ($btnCadItem) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (empty($dados['desconto_valor'])) {
        $dados['desconto_valor'] = 0.00;
    }
    if (empty($dados['comissao_valor'])) {
        $dados['comissao_valor'] = 0.00;
    }
    if (empty($dados['desconto_percentual'])) {
        $dados['desconto_percentual'] = 0.00;
    }
    if (empty($dados['comissao_percentual'])) {
        $dados['comissao_percentual'] = 0.00;
    }


    $result_item = "INSERT INTO tbl_item (id_contrato, descricao, valor_contratado, desconto_valor, comissao_valor, desconto_percentual, comissao_percentual, status_item) VALUES (
		'" . $dados['id_contrato'] . "',
		'" . $dados['descricao'] . "',
		'" . $dados['valor_contratado'] . "',
		'" . $dados['desconto_valor'] . "',
		'" . $dados['comissao_valor'] . "',
        '" . $dados['desconto_percentual'] . "',
        '" . $dados['comissao_percentual'] . "',
        '" . $dados['status_item'] . "'
		)";


    $resultado_item = $conn->prepare($result_item);
    $resultado_item->execute();

    header("Location: caditem.php");

    /*if(pg_insert($conn)){
			$_SESSION['msgcad'] = "Item cadastrado com sucesso";
			header("Location: caditem.php");
		}else{
			$_SESSION['msg'] = "Contrato já cadastrado";
			var_dump($conn);
            header("Location: caditem.php"); */
}



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Cadastro de Itens</title>
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/png">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
</head>

<body>
    <header>
        <nav class="navbar fixed-top navbar-expand-md navbar-dark">
            <div class="header">
                <div class="logo">
                    <img src="assets/img/logobco.png" type="image/png" width=80>
                </div>
                <div class="session">
                    <a id="session">
                        <i class="fas fa-user"></i>
                        <?php
                        if (!empty($_SESSION['id_usuario'])) {
                            echo $_SESSION['nome_completo'] . " - " . $_SESSION['matricula'];
                        } else {
                            header("Location: index.php");
                        }
                        ?>
                    </a>
                </div>
                <!--Logo-->
                <div class="buttonHamb">
                    <!--Menu Hamburger-->
                    <button class="navbar-toggler" data-toggle="collapse" data-target="#nav-target">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <!--navegação-->
                <div class="collapse navbar-collapse" id="nav-target">
                    <ul class="navbar-nav ml-auto">

                        <!-- início -->
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="menu.php" id="navbarSupportedContent" role="button"
                                aria-haspopup="true" aria-expanded="false" style="margin-right:.5rem">
                                <i class="fas fa-home"></i>
                                Início
                            </a>
                        </li>

                        <!-- Menu Cadastrar -->
                        <?php
                        if ($_SESSION['funcao'] < 3) {
                            echo '                            
                                        <li class="nav-item dropdown">                            
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Cadastrar
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="cadviagem.php">Viagem</a>
                                                <a class="dropdown-item" href="cadpassagem.php">Passagem</a>
                                                <a class="dropdown-item" href="cadpessoa.php">Passageiro</a>
                                    ';
                        }
                        if ($_SESSION['funcao'] == 1) {
                            echo '
                                                <a class="dropdown-item" href="cadcontrato.php">Contrato</a>
                                                <a class="dropdown-item" href="cadaditivo.php">Aditivo</a>
                                    ';
                        }
                        if ($_SESSION['funcao'] < 3) {
                            echo '
                                            </div>
                                        </li>
                                        
                                        <!-- Menu Editar -->

                                        <li class="nav-item dropdown">                            
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Editar
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="editviagem.php">Viagem</a>
                                                <a class="dropdown-item" href="editpassagem.php">Passagem</a>
                                                <a class="dropdown-item" href="editpessoa.php">Passageiro</a>
                                    ';
                        }
                        if ($_SESSION['funcao'] == 1) {

                            echo '
                                                <a class="dropdown-item" href="editcontrato.php">Contrato</a>
                                                <a class="dropdown-item" href="edititem.php">Item de Contrato</a>
                                                <a class="dropdown-item" href="editaditivo.php">Aditivo</a>
                                    ';
                        }
                        if ($_SESSION['funcao'] < 3) {
                            echo '
                                            </div>
                                        </li>
                                    ';
                        }
                        ?>
                        <?php
                        if ($_SESSION['funcao'] < 3) {
                            echo '
                                        <!--Menu Pagamento -->
                                        <li class="nav-item dropdown">                            
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Pagamento
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="cadpagamento.php">Lançar</a>
                                                <a class="dropdown-item" href="editpagamento.php">Alterar</a>
                                            </div>
                                        </li>
                                    ';
                        }
                        ?>

                        <!-- Menu Consultar -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Consultar
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="consultar_viagem.php">Viagem</a>
                                <a class="dropdown-item" href="consulta_passagem.php">Passagem</a>
                                <a class="dropdown-item" href="cadpessoa.php">Passageiro</a>
                                <a class="dropdown-item" href="consulta_pagamento.php">Pagamento</a>
                            </div>
                        </li>

                        <!-- Menu Administrador -->
                        <?php
                        if ($_SESSION['funcao'] < 3) {
                            echo '
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Administrador
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-left text-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="cadcidade.php">Cadastrar Cidade</a>
                                    ';
                        }
                        if ($_SESSION['funcao'] == 1) {
                            echo '
                                                <a class="dropdown-item" href="cadusuario.php">Cadastrar Usuário</a>
                                                <a class="dropdown-item" href="cadcontrato.php">Cadastrar Contrato</a>
                                                <a class="dropdown-item" href="cadaditivo.php">Cadastrar Aditivo</a>
                                    ';
                        }
                        ?>
                        <?php
                        if ($_SESSION['funcao'] < 3) {
                            echo '
                                            </div>							
                                        </li>
                                    ';
                        }
                        ?>

                        <!-- Menu Sair -->
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="sair.php">
                                <span>Sair</span>
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section class="col-md-auto">
        <div class="content-center" id="conteiner">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>

            <form method="POST" action="">
                <!-- Inicio Campos -->
                <h1>&nbsp Item de Contrato</h1>
                <div class="row">
                    <!-- Select Contrato -->
                    <div class="col-md-3">
                        <?php

                        $result_contrato = "SELECT * FROM tbl_contrato
                                                        WHERE status_contrato LIKE 'vigente'
                                                        ORDER BY id_contrato";

                        $resultado_contrato = $conn->prepare($result_contrato);
                        $resultado_contrato->execute();



                        echo '<label id="date-side" for="contrato">Contrato</label><select class="custom-select" name="id_contrato" id="id_contrato">
                                        <option value="id_contrato" disabled">Selecione</option>';

                        while ($row_contrato = $resultado_contrato->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option selected="selected value="' . $row_contrato['id_contrato'] . '">' . $row_contrato['num_contrato'] . '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                    <div class="col-md-6">
                        <label id="date-side" for="descricao">Descrição</label>
                        <select class="custom-select" name="descricao" id="inlineFormCustomSelectPref"
                            required="required">
                            <option selected disabled>Selecione</option>
                            <option name="descricao" value="Passagem Aérea Nacional">Passagem Aérea Nacional</option>
                            <option name="descricao" value="Passagem Aérea Internacional">Passagem Aérea Internacional
                            </option>
                            <option name="descricao" value="Passagem Rodoviária Nacional">Passagem Rodoviária Nacional
                            </option>
                            <option name="descricao" value="Seguro Viagem Internacional">Seguro Viagem Internacional
                            </option>

                        </select>
                    </div>

                    <div class="col-md-3 ">
                        <label id="date-side" for="valor_contratado">Valor Total</label>
                        <input type="text" min="" step="any" class="form-control" name="valor_contratado"
                            id="valor_contratado" placeholder="0.00" required="required">
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-3 ">
                        <label id="date-side">Desconto em Valor Monetário R$</label>
                        <input type="text" min="" step="any" class="form-control" name="desconto_valor"
                            id="desconto_valor" placeholder="0.00" required="required">
                    </div>

                    <div class="col-md-3 ">
                        <label id="date-side">Desconto em Percentual %</label>
                        <input type="text" min="" max="100" step="any" class="form-control" name="desconto_percentual"
                            id="desconto_percentual" placeholder="0.00" required="required">
                    </div>
                    <div class="col-md-3 ">
                        <label id="date-side">Comissão em Valor Monetário R$</label>
                        <input type="text" min="" step="any" class="form-control" name="comissao_valor"
                            id="comissao_valor" placeholder="0.00" required="required">
                    </div>

                    <div class="col-md-3 ">
                        <label id="date-side">Comissão em Percentual %</label>
                        <input type="text" min="" max="100" step="any" class="form-control" name="comissao_percentual"
                            id="comissao_percentual" placeholder="0.00" required="required">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <input type="submit" onclick="return checkSubmission()" id="btnCadItem" value="Salvar"
                            name="btnCadItem"></input>
                    </div>

                    <div class="col-md-4">
                        <input type="submit" name="btnCancela" id="btnCancela" value="Cancelar"></input>
                    </div>

                    <div class="col-md-4">
                        <input type="submit" id="btnConcluir" value="Concluir"></input>
                    </div>

                </div>
                <input type="hidden" class="form-control" name="status_item" id="status_item" value="ativo">
                <!-- Fim Campos -->
            </form>

        </div>
        </div>
        </div>
    </section>
    <footer>
        <div class="footer">©️ Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens
        </div>
    </footer>
    <!-- Verificar se o ja aconteceu um 'submit' -->
    <script>
    var submissionflag = false;

    function checkSubmission() {
        if (!submissionflag) {
            submissionflag = true;
            document.getElementById("btnsave").disabled = true;
            return true;
        } else {
            return false;
        }
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <script src="assets/css/bootstrap.min.css"></script>
    <script src="assets/js/jquery.mask.min.js"></script>
</body>

</html>