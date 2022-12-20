<?php
// Inicialize a sessão
session_start();
 
// Verifique se o usuário já está logado, em caso afirmativo, redirecione-o para a página de boas-vindas
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Incluir arquivo de configuração
require_once "config.php";
 
// Defina variáveis e inicialize com valores vazios
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processando dados do formulário quando o formulário é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Verifique se o nome de usuário está vazio
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor, insira o nome de usuário.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Verifique se a senha está vazia
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, insira sua senha.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validar credenciais
    if(empty($username_err) && empty($password_err)){
        // Prepare uma declaração selecionada
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Definir parâmetros
            $param_username = trim($_POST["username"]);
            
            // Tente executar a declaração preparada
            if($stmt->execute()){
                // Verifique se o nome de usuário existe, se sim, verifique a senha
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            // A senha está correta, então inicie uma nova sessão
                            session_start();
                            
                            // Armazene dados em variáveis de sessão
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirecionar o usuário para a página de boas-vindas
                            header("location: welcome.php");
                        } else{
                            // A senha não é válida, exibe uma mensagem de erro genérica
                            $login_err = "Nome de usuário ou senha inválidos.";
                        }
                    }
                } else{
                    // O nome de usuário não existe, exibe uma mensagem de erro genérica
                    $login_err = "Nome de usuário ou senha inválidos.";
                }
            } else{
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }
    
    // Fechar conexão
    unset($pdo);
}
?>
     <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <title>Página Inicial</title>
    </head>

    <body>
            <div class="container col-md-8 col-sm-8 col-xs-12" >
                <div class="jumbotron bg-primary">
                    <div class="row text-white"  >
                        <h1 class="font-weight-bold">SISTEMA DE CADASTROS</h1><h3><span class="badge bg-primary"> Versão 1.0</span></h3>
                    </div>
                </div>
            </div>
            <div class="container text-center col-md-8 col-sm-8 col-xs-12">
                <div class="card-header">
                    <h2 class="font-weight-bold bg-primary text-white"> Login </h2>
                    <h6>Por favor, preencha os campos para fazer o login.</h6>
                    <?php 
                    if(!empty($login_err)){
                        echo '<div class="alert alert-danger">' . $login_err . '</div>';
                    }        
                    ?>
                    <br>
                    <div class="card-header">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"method="post">
                            <div class="container-fluid">
                                <label class="font-weight-bold">Nome do usuário</label>
                                <input type="text" name="username" placeholder="Nome" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center<?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                            </div>    
                            <div class="form-group">
                                <label class="font-weight-bold">Senha</label>
                                <input type="password" name="password" placeholder="Senha" class="form-control form-control container col-md-6 col-sm-6 col-xs-12 text-center <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Entrar">
                        </div>
                            <p>Não tem uma conta? <a href="register.php">Inscreva-se agora</a>.</p>
                        </form>
                    </div>
                </div>
            </div>
</body>
</html>