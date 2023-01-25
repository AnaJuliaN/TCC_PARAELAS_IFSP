<?php

include('conexao2.php');

    $hidden=$_POST['hidden'];
    
    if($hidden==1){
        $nome=$_POST['nome'];
        $senha=$_POST['senha'];
        $conf_senha=$_POST['conf_senha'];
        $email=$_POST['email'];
        
        $stmt=$pdo->query("SELECT email FROM usuario WHERE email='$email'");
        $qtd=$stmt->rowCount();

        if($qtd>0){
            header('Location: erro_cadastro.php');
        }else{
            $sql=$pdo->query("INSERT INTO usuario (nome, senha, conf_senha, email) VALUE ('$nome', '$senha', '$conf_senha', '$email')");
            $sql->execute();

            if($sql){
                header("Location:inicio.php");
            }else{
                header('Location:erro.php');
            }

        }


    }else{
        $email=$_POST['email'];
        $senha=$_POST['senha'];

        $sql="SELECT * FROM usuario";

        $query=mysqli_query($conexao, $sql);

        if(mysqli_num_rows($query)>0){
            while(($usuario=mysqli_fetch_assoc($query))!=NULL){
                if((($email==$usuario['email']) && ($email=="admin@admin.com")) && (($senha==$usuario['senha']) && ($senha=="123456789"))){
                    setcookie('ADM', 1, time()+600);
                    header("Location:area_admin.php");
                }else if(($email==$usuario['email']) && ($senha==$usuario['senha'])){
                    setcookie('USER', $usuario['cod_usuario'], time()+600);
                    header("Location:inicio.php");
                    echo "Bom dia!";
                }
            }
        }
    }
