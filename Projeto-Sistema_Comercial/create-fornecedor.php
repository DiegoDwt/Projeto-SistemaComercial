<?php
require 'banco.php';
//Acompanha os erros de validação

// Processar so quando tenha uma chamada post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeErro = null;
    $cnpjErro = null;
    $descricaoErro = null;
    $enderecoErro = null;
    $telefoneErro = null;
    $emailErro = null;


    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;
        if (!empty($_POST['nome'])) {
            $nome = $_POST['nome'];
        } else {
            $nomeErro = 'Por favor digite o seu nome!';
            $validacao = False;
        }

    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;
        if (!empty($_POST['cnpj'])) {
            $cnpj = $_POST['cnpj'];
        } else {
            $cnpjErro = 'Por favor digite o Cnpj!';
            $validacao = False;
        }

        if (!empty($_POST['descricao'])) {
            $descricao = $_POST['descricao'];
        } else {
            $descricaoErro = 'Por favor digite a descrição do fornecedor!';
            $validacao = False;
        }

        if (!empty($_POST['endereco'])) {
            $endereco = $_POST['endereco'];
        } else {
            $enderecoErro = 'Por favor digite o seu endereço!';
            $validacao = False;
        }


        if (!empty($_POST['telefone'])) {
            $telefone = $_POST['telefone'];
        } else {
            $telefoneErro = 'Por favor digite o número do telefone!';
            $validacao = False;
        }


        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $emailErro = 'Por favor digite um endereço de email válido!';
                $validacao = False;
            }
        } else {
            $emailErro = 'Por favor digite um endereço de email!';
            $validacao = False;
        }


    }
    } 



//Inserindo no Banco:
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO fornecedor (nome, cnpj, descricao, endereco, telefone, email) VALUES(?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($nome, $cnpj, $descricao, $endereco, $telefone, $email));
        Banco::desconectar();
        header("Location: fornecedores.php");
    }

}
?>


<!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <title>Adicionar contato</title>
    </head>
    <body>
            <div class="container col-md-8 col-sm-8 col-xs-12 form-group has-feedback" >
              <div class="jumbotron bg-primary">
                  <div class="row text-white"  >
                      <h1 class="font-weight-bold">SISTEMA DE CADASTROS</h1><h3><span class="badge bg-primary"> Versão 1.0</span></h3>
                  </div>
              </div>
            </div>
            <div class="container text-center col-md-8 col-sm-8 col-xs-12">
                <div class="card-header">
                    <h2 class="font-weight-bold bg-primary text-white"> Cadastro de Fornecedor</h2>
                    <div class="wrapper text-center">
                        <form class="form-horizontal" action="create-fornecedor.php" method="post">
                        <div class="control-group  <?php echo !empty($nomeErro) ? 'error ' : ''; ?>">
                            <label class="control-label font-weight-bold">Nome</label>
                            <div class="controls">
                                <input size="50" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="nome" type="text" placeholder="Nome"
                                    value="<?php echo !empty($nome) ? $nome : ''; ?>">
                                <?php if (!empty($nomeErro)): ?>
                                    <span class="text-danger"><?php echo $nomeErro; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group  <?php echo !empty($cnpjErro) ? 'error ' : ''; ?>">
                            <label class="control-label font-weight-bold">Cnpj</label>
                            <div class="controls">
                                <input size="50" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="cnpj" type="text" placeholder="Cnpj"
                                    value="<?php echo !empty($cnpj) ? $cnpj : ''; ?>">
                                <?php if (!empty($cnpjErro)): ?>
                                    <span class="text-danger"><?php echo $cnpjErro; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group  <?php echo !empty($descricaoErro) ? 'error ' : ''; ?>">
                            <label class="control-label font-weight-bold">Descrição</label>
                            <div class="controls">
                                <input size="50" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="descricao" type="text" placeholder="descricao"
                                    value="<?php echo !empty($descricao) ? $descricao : ''; ?>">
                                <?php if (!empty($descricaoErro)): ?>
                                    <span class="text-danger"><?php echo $descricaoErro; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php echo !empty($enderecoErro) ? 'error ' : ''; ?>">
                            <label class="control-label font-weight-bold">Endereço</label>
                            <div class="controls">
                                <input size="80" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="endereco" type="text" placeholder="Endereço"
                                    value="<?php echo !empty($endereco) ? $endereco : ''; ?>">
                                <?php if (!empty($emailErro)): ?>
                                    <span class="text-danger"><?php echo $enderecoErro; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php echo !empty($telefoneErro) ? 'error ' : ''; ?>">
                            <label class="control-label font-weight-bold">Telefone</label>
                            <div class="controls">
                                <input size="35" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="telefone" type="text" placeholder="Telefone"
                                    value="<?php echo !empty($telefone) ? $telefone : ''; ?>">
                                <?php if (!empty($telefoneErro)): ?>
                                    <span class="text-danger"><?php echo $telefoneErro; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php !empty($emailErro) ? '$emailErro ' : ''; ?>">
                            <label class="control-label font-weight-bold">Email</label>
                            <div class="controls">
                                <input size="40" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="email" type="text" placeholder="Email"
                                    value="<?php echo !empty($email) ? $email : ''; ?>">
                                <?php if (!empty($emailErro)): ?>
                                    <span class="text-danger"><?php echo $emailErro; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-actions">
                            <br/>
                            <button type="submit" class="btn btn-success">Adicionar</button>
                            <a href="fornecedores.php" type="btn" class="btn btn-default">Voltar</a>
                        </div>
                    </div>        
                </form>
            </div>
        </div>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>