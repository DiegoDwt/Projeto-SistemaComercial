<?php

require 'banco.php';

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: fornecedores.php");
}

if (!empty($_POST)) {

    $nomeErro = null;
    $cnpjErro = null;
    $descricaoErro = null;
    $enderecoErro = null;
    $telefoneErro = null;
    $emailErro = null;


    $nome = $_POST['nome'];
    $cnpj = $_POST['cnpj'];
    $descricao = $_POST['descricao'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    //Validação
    $validacao = true;
    if (empty($nome)) {
        $nomeErro = 'Por favor digite o nome!';
        $validacao = false;
    }

    if (empty($cnpj)) {
        $cnpjErro = 'Por favor digite o Cnpj!';
        $validacao = false;
    }

    if (empty($descricao)) {
        $descricaoErro = 'Por favor digite a descrição!';
        $validacao = false;
    }

    if (empty($email)) {
        $emailErro = 'Por favor digite o email!';
        $validacao = false;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErro = 'Por favor digite um email válido!';
        $validacao = false;
    }

    if (empty($endereco)) {
        $enderecoErro = 'Por favor digite o endereço!';
        $validacao = false;
    }

    if (empty($telefone)) {
        $telefoneErro = 'Por favor digite o telefone!';
        $validacao = false;
    }

    // update data
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE fornecedor set nome = ?, cnpj = ?, descricao = ?, endereco = ?, telefone = ?, email = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($nome, $cnpj, $descricao, $endereco, $telefone, $email, $id));
        Banco::desconectar();
        header("Location: fornecedores.php");
    }
} else {
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM fornecedor where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $nome = $data['nome'];
    $cnpj = $data['cnpj'];
    $descricao = $data['descricao'];
    $endereco = $data['endereco'];
    $telefone = $data['telefone'];
    $email = $data['email'];
    Banco::desconectar();
}
?>

<!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <title>Atualizar Fornecedor</title>
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
                        <h2 class="font-weight-bold bg-primary text-white"> Atualizar dados </h2>
                        <div class="card-header">
                            <div class="wrapper text-center">
                                <form class="form-horizontal" action="update_fornecedor.php?id=<?php echo $id ?>" method="post">
                                    <div class="control-group <?php echo !empty($nomeErro) ? 'error' : ''; ?>">
                                        <label class="control-label font-weight-bold">Nome</label>
                                        <div class="controls">
                                            <input size="50" name="nome" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center"  type="text" placeholder="Nome"
                                                value="<?php echo !empty($nome) ? $nome : ''; ?>">
                                            <?php if (!empty($nomeErro)): ?>
                                                <span class="text-danger"><?php echo $nomeErro; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="control-group <?php echo !empty($cnpjErro) ? 'error' : ''; ?>">
                                        <label class="control-label font-weight-bold">Cnpj</label>
                                        <div class="controls">
                                            <input name="cnpj" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center" size="80" type="text" placeholder="Cnpj"
                                                value="<?php echo !empty($cnpj) ? $cnpj : ''; ?>">
                                            <?php if (!empty($cnpjErro)): ?>
                                                <span class="text-danger"><?php echo $cnpjErro; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="control-group <?php echo !empty($descricaoErro) ? 'error' : ''; ?>">
                                        <label class="control-label font-weight-bold">Descrição</label>
                                        <div class="controls">
                                            <input name="descricao" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center" size="80" type="text" placeholder="descricao"
                                                value="<?php echo !empty($descricao) ? $descricao : ''; ?>">
                                            <?php if (!empty($descricaoErro)): ?>
                                                <span class="text-danger"><?php echo $descricaoErro; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="control-group <?php echo !empty($enderecoErro) ? 'error' : ''; ?>">
                                        <label class="control-label font-weight-bold">Endereço</label>
                                        <div class="controls">
                                            <input name="endereco" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center" size="80" type="text" placeholder="Endereço"
                                                value="<?php echo !empty($endereco) ? $endereco : ''; ?>">
                                            <?php if (!empty($enderecoErro)): ?>
                                                <span class="text-danger"><?php echo $enderecoErro; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="control-group <?php echo !empty($telefoneErro) ? 'error' : ''; ?>">
                                        <label class="control-label font-weight-bold">Telefone</label>
                                        <div class="controls">
                                            <input name="telefone" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center" size="30" type="text" placeholder="Telefone"
                                                value="<?php echo !empty($telefone) ? $telefone : ''; ?>">
                                            <?php if (!empty($telefoneErro)): ?>
                                                <span class="text-danger"><?php echo $telefoneErro; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="control-group <?php echo !empty($emailErro) ? 'error' : ''; ?>">
                                        <label class="control-label font-weight-bold">Email</label>
                                        <div class="controls">
                                            <input name="email" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center" size="40" type="text" placeholder="Email"
                                                value="<?php echo !empty($email) ? $email : ''; ?>">
                                            <?php if (!empty($emailErro)): ?>
                                                <span class="text-danger"><?php echo $emailErro; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">Atualizar</button>
                                        <a href="fornecedores.php" type="btn" class="btn btn-default">Voltar</a>
                                    </div>
                            </form>
                        </div>   
                    </div>
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
