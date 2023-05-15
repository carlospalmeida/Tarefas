<?php
session_start();
include('conn.php');
include('funcoes.php');

if (isset($_POST["btnacessar"])) {
    $usuario = testar_valor($_POST["usuario"]);
    $senha = testar_valor($_POST["senha"]);

    $sqlLogin = "SELECT * FROM tab_usuarios 
    WHERE usuario='$usuario' and senha='$senha'";
    $result = mysqli_query($conn, $sqlLogin);
    $quantReg = mysqli_num_rows($result);
    if ($quantReg > 0) {
        $_SESSION["usuario"] = "$usuario";
        while ($linha = mysqli_fetch_assoc($result)) {
            $_SESSION["idUsuario"] = $linha["idUser"];
        }

        header('location:index.php');
    } else {
        header('location:login.php?msg=logierro');
    }
}

if (isset($_POST["btncadastrar"])) {
    $Nusuario = testar_valor($_POST["Nusuario"]);
    $Nsenha = testar_valor($_POST["Nsenha"]);
    $Csenha = testar_valor($_POST["Csenha"]);

    if(!empty($Nusuario) && !empty($Nsenha) && !empty($Csenha)){
        if ($Nsenha == $Csenha) {
            $sqlUser = "SELECT * FROM tab_usuarios WHERE usuario='$Nusuario'";
            $result = mysqli_query($conn, $sqlUser);
    
            if (mysqli_num_rows($result) == 0) {
                $sqlCadastrar = "INSERT INTO tab_usuarios (usuario,senha) VALUES ('$Nusuario','$Nsenha')";
                if (mysqli_query($conn, $sqlCadastrar)) {
                    header('location:login.php?msg=Cadok');
                } else {
                    header('location:login.php?msg=erro3');
                }
            } else {
                header('location:login.php?msg=erro2');
            }
        } else {
            header('location:login.php?msg=erro1');
        }
    }else{
        header('location:login.php?msg=erro0');
    }


}


?>


<!DOCTYPE html>
<html>

<head>
    <title>Slide Navbar</title>
    <link rel="stylesheet" type="text/css" href="slide navbar style.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Jost', sans-serif;
            background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
        }

        .main {
            width: 350px;
            height: 500px;
            background: red;
            overflow: hidden;
            background: url("https://doc-08-2c-docs.googleusercontent.com/docs/securesc/68c90smiglihng9534mvqmq1946dmis5/fo0picsp1nhiucmc0l25s29respgpr4j/1631524275000/03522360960922298374/03522360960922298374/1Sx0jhdpEpnNIydS4rnN4kHSJtU1EyWka?e=view&authuser=0&nonce=gcrocepgbb17m&user=03522360960922298374&hash=tfhgbs86ka6divo3llbvp93mg4csvb38") no-repeat center/ cover;
            border-radius: 10px;
            box-shadow: 5px 20px 50px #000;
        }

        #chk {
            display: none;
        }

        .signup {
            position: relative;
            width: 100%;
            height: 100%;
        }

        label {
            color: #fff;
            font-size: 2.3em;
            justify-content: center;
            display: flex;
            margin: 60px;
            font-weight: bold;
            cursor: pointer;
            transition: .5s ease-in-out;
        }

        input {
            width: 60%;
            height: 20px;
            background: #e0dede;
            justify-content: center;
            display: flex;
            margin: 20px auto;
            padding: 10px;
            border: none;
            outline: none;
            border-radius: 5px;
        }

        button {
            width: 60%;
            height: 40px;
            margin: 10px auto;
            justify-content: center;
            display: block;
            color: #fff;
            background: #573b8a;
            font-size: 1em;
            font-weight: bold;
            margin-top: 20px;
            outline: none;
            border: none;
            border-radius: 5px;
            transition: .2s ease-in;
            cursor: pointer;
        }

        button:hover {
            background: #6d44b8;
        }

        .login {
            height: 460px;
            background: #eee;
            border-radius: 60% / 10%;
            transform: translateY(-180px);
            transition: .8s ease-in-out;
        }

        .login label {
            color: #573b8a;
            transform: scale(.6);
        }

        #chk:checked~.login {
            transform: translateY(-500px);
        }

        #chk:checked~.login label {
            transform: scale(1);
        }

        #chk:checked~.signup label {
            transform: scale(.6);
        }
    </style>
</head>

<body>

    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <!-- Erros e msgs -->

        <?php if (isset($_GET["msg"]) && $_GET["msg"] == "logierro") { ?>
            <p style="color: red; text-align: center;">Usuario ou senha incorreta</p>
        <?php } ?>

        <?php if (isset($_GET["msg"]) && $_GET["msg"] == "userna") { ?>
            <p style="color: red; text-align: center;">Faz isso não fi,ta achando que comecei ontem né?</p>
        <?php } ?>

        <?php if (isset($_GET["msg"]) && $_GET["msg"] == "erro0") { ?>
            <p style="color: red; text-align: center;">Preencha todos os campos!!</p>
        <?php } ?>

        <?php if (isset($_GET["msg"]) && $_GET["msg"] == "erro1") { ?>
            <p style="color: red; text-align: center;">Senha não é igual!!</p>
        <?php } ?>

        <?php if (isset($_GET["msg"]) && $_GET["msg"] == "erro2") { ?>
            <p style="color: red; text-align: center;">Usuario já existe!!</p>
        <?php } ?>

        <?php if (isset($_GET["msg"]) && $_GET["msg"] == "erro3") { ?>
            <p style="color: red; text-align: center;">Erro no Banco!!</p>
        <?php } ?>

        <?php if (isset($_GET["msg"]) && $_GET["msg"] == "Cadok") { ?>
            <p style="color: green; text-align: center;">Sucesso no cadastro!!</p>
        <?php } ?>

        <!-- X -->

        <div class="signup">
            <form method="post">
                <label for="chk" aria-hidden="true">Cadastrar</label>
                <input type="text" name="Nusuario" placeholder="Nome de usuario" id="usuarioc">
                <input type="password" name="Nsenha" placeholder="Senha" id="senhac">
                <input type="password" name="Csenha" placeholder="Confirmar Senha" id="senhaconfir">
                <button type="submit" name="btncadastrar">Cadastro</button>
            </form>
        </div>

        <div class="login">
            <form method="post">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="usuario" placeholder="Nome de usuario" id="usuariol">
                <input type="password" name="senha" placeholder="Senha" id="senhal">
                <button type="submit" name="btnacessar">Login</button>
            </form>
        </div>
    </div>
</body>

</html>