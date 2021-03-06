<?php

session_start();

ob_start();

include_once 'conexao.php';

$btnCadPassagem = filter_input(INPUT_POST, 'btnCadPassagem', FILTER_SANITIZE_STRING);


if ($btnCadPassagem) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    //$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

    $result_passagem = "INSERT INTO tbl_passagem (id_viagem, id_pessoa, id_item, origem, destino, data_ida, data_retorno, companhia, localizador, tarifa_voucher, taxas_voucher, classe, status_passagem, id_contrato, id_usuario, unidade, grau)VALUES (
		'" . $dados['id_viagem'] . "',
		'" . $dados['id_pessoa'] . "',
		'" . $dados['id_item'] . "',
		'" . $dados['origem'] . "',
        '" . $dados['destino'] . "',
        '" . $dados['data_ida'] . "',
        '" . $dados['data_retorno'] . "',
        '" . $dados['companhia'] . "',
        '" . $dados['localizador'] . "',
        '" . $dados['tarifa_voucher'] . "',
        '" . $dados['taxas_voucher'] . "',
        '" . $dados['classe'] . "',
        '" . $dados['status_passagem'] . "',
        '" . $dados['id_contrato'] . "',
        '" . $_SESSION['id_usuario'] . "',
        '" . $_SESSION['unidade'] . "',
        '" . $dados['grau'] . "'
		)";


    $resultado_passagem = $conn->prepare($result_passagem);
    $resultado_passagem->execute();

    header("Location: cadpassagem.php");
}

/*if(pg_insert($conn)){
                            $_SESSION['msgcad'] = "Passagem cadastrada com sucesso";
                            header("Location: cadpassagem.php");
                        }else{
                            $_SESSION['msg'] = "Passagem já cadastrado";
                            var_dump($conn);
                            header("Location: cadpassagem.php"); 
                        }*/


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Passagem</title>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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

            if (isset($_SESSION['msgcad'])) {
                echo $_SESSION['msgcad'];
                unset($_SESSION['msgcad']);
            }
            ?>

            <form method="GET" action="confirma_passagem.php">

                <h1>Passagem</h1>

                <div class="row">
                    <!-- Select Viagem -->
                    <div class="col-md-3">
                        <?php
                        $result_viagem = "SELECT id_viagem, protocolo_compra FROM tbl_viagem
                                        ORDER BY id_viagem DESC";

                        $resultado_viagem = $conn->prepare($result_viagem);
                        $resultado_viagem->execute();

                        echo
                            '<label id="date-side" for="id_viagem">Protocolo da Viagem</label>
                                        <select class="custom-select" name="id_viagem" id="id_viagem" required="required">
                                        <option selected="selected" disabled>Pesquisar</option>';
                        while ($row_viagem = $resultado_viagem->fetch(PDO::FETCH_ASSOC)) {

                            echo '<option value="' . $row_viagem['id_viagem'] . '">' . $row_viagem['protocolo_compra'] . '</option>';
                        }
                        echo '</select>';

                        ?>
                    </div>
                    <!-- Select Passageiro -->
                    <div class="col-md-9">
                        <?php
                        $result_pessoa = "SELECT id_pessoa, nome_completo
                                        FROM tbl_pessoa
                                        ORDER BY nome_completo ASC";

                        $resultado_pessoa = $conn->prepare($result_pessoa);
                        $resultado_pessoa->execute();

                        echo
                            '<label id="date-side" for="id_pessoa">Passageiro</label>
                                        <select class="custom-select" name="id_pessoa" id="id_pessoa" required="required">
                                        <option selected="selected" disabled>Pesquisar</option>';
                        while ($row_pessoa = $resultado_pessoa->fetch(PDO::FETCH_ASSOC)) {

                            echo '<option value="' . $row_pessoa['id_pessoa'] . '">' . $row_pessoa['nome_completo'] . '</option>';
                        }
                        echo '</select>';

                        ?>
                    </div>
                </div>
                <div class="row">
                    <!-- Início Select Grau -->
                    <div class="col-md-3">
                        <label id="date-side" for="grau">Grau</label>
                        <select class="custom-select" name="grau" id="inlineFormCustomSelectPref">
                            <option selected enabled name="grau" value="2º">2º Grau</option>
                            <option name="grau" value="1º">1º Grau</option>
                        </select>
                    </div>
                    <!-- Select Contrato -->
                    <div class="col-md-3">
                        <?php
                        $result_contrato = "SELECT id_contrato, num_contrato
                                        FROM tbl_contrato
                                        WHERE tbl_contrato.status_contrato LIKE 'vigente'
                                        ORDER BY id_contrato";

                        $resultado_contrato = $conn->prepare($result_contrato);
                        $resultado_contrato->execute();

                        echo
                            '<label id="date-side" for="id_contrato">Contrato</label>
                                        <select class="custom-select" name="id_contrato" id="id_contrato">
                                        <option disabled>Selecione</option>';
                        while ($row_contrato = $resultado_contrato->fetch(PDO::FETCH_ASSOC)) {

                            echo '<option selected="selected"  value="' . $row_contrato['id_contrato'] . '">' . $row_contrato['num_contrato'] . '</option>';
                        }
                        echo '</select>';

                        ?>
                    </div>
                    <!-- Select Item -->
                    <div class="col-md-3">
                        <?php
                        $result_item = "SELECT id_item, descricao
                                        FROM tbl_item
                                        WHERE tbl_item.status_item LIKE 'ativo'
                                        ORDER BY id_item";

                        $resultado_item = $conn->prepare($result_item);
                        $resultado_item->execute();

                        echo
                            '<label id="date-side" for="id_item">Tipo</label>
                                        <select class="custom-select" name="id_item" id="id_item">
                                        <option selected="selected" disabled>Selecionar</option>';
                        while ($row_item = $resultado_item->fetch(PDO::FETCH_ASSOC)) {

                            echo '<option value="' . $row_item['id_item'] . '">' . $row_item['descricao'] . '</option>';
                        }
                        echo '</select>';

                        ?>
                    </div>
                    <div class="col-md-3">
                        <label id="date-side" for="classe">Classe</label>
                        <select class="custom-select" name="classe" id="classe">
                            <option value="normal" selected enabled>Normal</option>
                            <option value="cúpula">Cúpula</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <!-- Select Origem -->
                    <div class="col-md-3">
                        <?php
                        $result_cidade = "SELECT origem, destino
                                        FROM tbl_cidade
                                        ORDER BY origem ASC";

                        $resultado_cidade = $conn->prepare($result_cidade);
                        $resultado_cidade->execute();

                        echo
                            '<label id="date-side" for="origem">Origem</label>
                                        <select class="custom-select" name="origem" id="origem" required="required">
                                        <option selected="selected" disabled>Pesquisar</option>';
                        while ($row_origem = $resultado_cidade->fetch(PDO::FETCH_ASSOC)) {

                            echo '<option name="origem" value="' . $row_origem['origem'] . '">' . $row_origem['origem'] . '</option>';
                        }
                        echo '</select>';

                        ?>
                    </div>
                    <div class="col-md-3">
                        <label id="date-side" for="data_ida">Data de Ida</label>
                        <input type="date" class="form-control" name="data_ida" id="data_ida" required="required">
                    </div>
                    <div class="col-md-3">
                        <?php
                        $resultado_cidade = $conn->prepare($result_cidade);
                        $resultado_cidade->execute();
                        echo
                            '<label id="date-side" for="destino">Destino</label>
                                        <select class="custom-select" name="destino" id="destino" required="required">
                                        <option selected="selected">Pesquisar</option>';
                        while ($row_destino = $resultado_cidade->fetch(PDO::FETCH_ASSOC)) {

                            echo '<option value="' . $row_destino['destino'] . '">' . $row_destino['destino'] . '</option>';
                        }
                        echo '</select>';

                        ?>
                    </div>
                    <div class="col-md-3">
                        <label id="date-side" for="data_retorno">Data de Retorno</label>
                        <input type="date" class="form-control" name="data_retorno" id="data_retorno">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 ">
                        <label id="date-side" for="tarifa_voucher">Passagem / Seguro R$</label>
                        <input type="number" min="0.01" step="0.01" class="form-control" name="tarifa_voucher"
                            id="tarifa_voucher" required="required">
                    </div>
                    <div class="col-md-3 ">
                        <label id="date-side" for="taxas_voucher">Taxas R$</label>
                        <input type="number" min="0.00" step="0.00" class="form-control" name="taxas_voucher"
                            id="taxas_voucher" required="required">
                    </div>
                    <div class="col-md-3">
                        <label id="date-side" for="companhia">Companhia / Seguradora</label>
                        <input type="text" class="form-control" name="companhia" id="companhia" maxlength="48"
                            required="required">
                    </div>
                    <div class="col-md-3">
                        <label id="date-side" for="localizador">Localizador / Apólice</label>
                        <input type="text" class="form-control" name="localizador" id="localizador" maxlength="15"
                            required="required">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="submit" onclick="return checkSubmission()" id="btnCadPassagem" value="Salvar"
                            name="btnCadPassagem"></input>
                    </div>
                    <div class="col-md-4">
                        <input type="submit" id="btnCadpessoa" value="Cadastrar Passageiro"></input>
                    </div>
                    <div class="col-md-4">
                        <input type="submit" id="btnConcluir" href="menu.php" value="Concluir"></input>
                    </div>
                    <input type="hidden" class="form-control" name="status_passagem" id="status_passagem" value="ativo">
                    <!-- Fim Campos -->
            </form>
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
    <script>
    $(document).ready(function() {
        $('#id_pessoa').select2();
        $('#id_viagem').select2();
        $('#origem').select2();
        $('#destino').select2();
    });
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