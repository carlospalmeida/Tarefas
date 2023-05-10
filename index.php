<?php
session_start();
include('conn.php');
// echo "<script>alert('ok')</script>";
//inclusão das funções
include('funcoes.php');
//iniciar secão
if(!isset($_SESSION["usuario"])){
  header('location:login.php?msg=userna');
}


//Atualizar tarefa
if (isset($_GET["btnAlterar"])) {
  if (
    !empty($_GET["nometarefa"])
    && !empty($_GET["descricao"])
    && !empty($_GET["datatarefa"])
    && !empty($_GET["prioridade"])
  ) {

    $nomeT = testar_valor($_GET["nometarefa"]);
    $descT = testar_valor($_GET["descricao"]);
    $dataT = testar_valor($_GET["datatarefa"]);
    $priorT = testar_valor($_GET["prioridade"]);
    $idT =  testar_valor($_GET["idtarefa"]);

    $sqlUpdate = "UPDATE tab_tarefas SET 
  nomeTarefa='$nomeT', descTarefa='$descT',
  prazoTarefa='$dataT',priorTarefa='$priorT'
  WHERE id='$idT'";

    if (mysqli_query($conn, $sqlUpdate)) {
      header('location:index.php?msg=upok');
    } else {
      header('location:index.php?msg=uperro2');
    }
  } else {
    header('location:index.php?msg=uperro1');
  }
}

//Deletar tarefa
if (isset($_GET["idtarefaexc"])) {


  $idT = $_GET["idtarefaexc"];


  $sqlDelete = "DELETE FROM tab_tarefas WHERE id='$idT'";

  if (mysqli_query($conn, $sqlDelete)) {
    header('location:index.php?msg=deok');
  } else {
    header('location:index.php?msg=deerro');
  }
}

//Buscar Tarefa pela data
if (isset($_GET["btnBuscar"])) {
  $dataT = $_GET["dataBuscar"];
  $sqlBuscar = "SELECT * FROM tab_tarefas 
  WHERE prazoTarefa LIKE '$dataT%'";
  $result = mysqli_query($conn, $sqlBuscar);
} else {
  //Selecionar tarefas do banco - php
  $sqlSelect = "SELECT * FROM tab_tarefas";
  $result = mysqli_query($conn, $sqlSelect);
}

//paginação
$pag = (isset($_GET["pagina"]) ? $_GET["pagina"] : 1);
$quantReg = mysqli_num_rows($result);
$quant_p_pag = 7;
$quant_pag = ceil($quantReg / $quant_p_pag);
$incio = ($quant_p_pag * $pag) - $quant_p_pag;
$sqlPag = "SELECT * FROM tab_tarefas LIMIT $incio, $quant_p_pag";
$result = mysqli_query($conn, $sqlPag);


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Tarefas - Senac</title>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
  <?php include("estrutura/menu_superior.php") ?>

  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading">Menu</div>
            <a class="nav-link" href="index.php">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Home
            </a>
            <div class="sb-sidenav-menu-heading"></div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
              <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
              Sistema
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="">Cadastro de Tarefas</a>
                <a class="nav-link" href="">Tarefas concluídas</a>
              </nav>
            </div>
          </div>
        </div>
      </nav>
    </div>


    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Gerenciador de tarefas</h1>

          <?php if (isset($_GET["msg"]) && $_GET["msg"] == "cadok") { ?>
            <div class="alert alert-success" role="alert">
              Cadastro Realizado com sucesso!!!
            </div>
          <?php } ?>

          <?php if (isset($_GET["msg"]) && $_GET["msg"] == "upok") { ?>
            <div class="alert alert-success" role="alert">
              Atualização realizada com sucesso!!!
            </div>
          <?php } ?>


          <?php if (isset($_GET["msg"]) && $_GET["msg"] == "uperro1") { ?>
            <div class="alert alert-danger" role="alert">
              Preencha todos os campos!!!
            </div>
          <?php } ?>
          <?php if (isset($_GET["msg"]) && $_GET["msg"] == "uperro2") { ?>
            <div class="alert alert-danger" role="alert">
              Erro ao tentar atualizar informações no banco de dados!!!
            </div>
          <?php } ?>

          <?php if (isset($_GET["msg"]) && $_GET["msg"] == "deok") { ?>
            <div class="alert alert-success" role="alert">
              Deletado com sucesso!!!
            </div>
          <?php } ?>

          <?php if (isset($_GET["msg"]) && $_GET["msg"] == "deerro") { ?>
            <div class="alert alert-danger" role="alert">
              Erro ao deletar tarefa!!!
            </div>
          <?php } ?>

          <ol class="breadcrumb mb-4">
          </ol>

          <div class="row">
            <div class="col-xl-2 col-md-3">
              <div class="card bg-primary text-white mb-4">
                <button type="button" class="btn btn-success" id="btn_entrada" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Incluir <i class="fa fa-plus"></i></button>
              </div>
            </div>
          </div>
          <table class="table table-hover">
            <thead>
              <tr class="col-12">
                <th scope="col-2">Editar</th>
                <th scope="col-2">Excluir</th>
                <th scope="col-2">Nome</th>
                <th scope="col-4">Descrição</th>
                <th scope="col-4">Prazo</th>
                <th scope="col-4">Prioridade</th>
                <th scope="col-2">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($linha = mysqli_fetch_assoc($result)) {
                $modalAtualizar = "modalAtualizar" . $linha["id"];
                $modalDeletar = "modalDeletar" . $linha["id"];
              ?>
                <tr>
                  <th style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#<?php echo $modalAtualizar ?>">
                    <i class="fa-solid fa-pen" style="color: #236c1e;"></i>
                  </th>
                  <th style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#<?php echo $modalDeletar ?>">
                    <i class="fa-solid fa-trash" style="color: #f01414;"></i>
                  </th>
                  <td><?php echo $linha["nomeTarefa"] ?></td>
                  <td><?php echo $linha["descTarefa"] ?></td>
                  <td><?php echo $linha["prazoTarefa"] ?></td>
                  <td><?php
                      if ($linha["priorTarefa"] == 1) {
                        echo "Baixa";
                      } else if ($linha["priorTarefa"] == 2) {
                        echo "Média";
                      } else {
                        echo "Alta";
                      }
                      ?></td>
                  <td>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" data-bs-toggle="modal" data-bs-target="#exampleModa2" role="switch" id="flexSwitchCheckChecked">
                      <label class="form-check-label" for="flexSwitchCheckChecked">Finalizar</label>
                    </div>
                  </td>
                </tr>

                <div class="modal fade text-dark" id="<?php echo $modalAtualizar ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog text-dark">
                    <div class="modal-content text-dark">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Alteração de Tarefa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-dark">
                        <form class="form-group text-white">
                          <div class="mb-3">
                            <label class="form-label text-dark">Id da Tarefa</label>
                            <input type="text" class="form-control" name="idtarefa" readonly value="<?php echo $linha["id"] ?>">
                          </div>
                          <div class="mb-3">
                            <label class="form-label text-dark">Nome da Tarefa</label>
                            <input type="text" class="form-control" name="nometarefa" value="<?php echo $linha["nomeTarefa"] ?>">
                          </div>
                          <div class="mb-3">
                            <label class="form-label text-dark">Descrição da tarefa</label> <textarea class="form-control" name="descricao" rows="3"> <?php echo $linha["descTarefa"] ?></textarea>
                          </div>
                          <div class="row">
                            <div class="mb-3 col-6">
                              <label class="form-label text-dark">Data / Prazo</label>
                              <input type="datetime-local" value="<?php echo $linha["prazoTarefa"] ?>" class="form-control" name="datatarefa">
                            </div>
                            <div class="mb-3 col-6">
                              <label class="form-label text-dark">Prioridade</label>
                              <select name="prioridade" class="form-select">
                                <option value="1" <?php if ($linha["priorTarefa"] == 1) {
                                                    echo "selected";
                                                  } ?>>baixa</option>
                                <option value="2" <?php if ($linha["priorTarefa"] == 2) {
                                                    echo "selected";
                                                  } ?>>média</option>
                                <option value="3" <?php if ($linha["priorTarefa"] == 3) {
                                                    echo "selected";
                                                  } ?>>alta</option>
                              </select>
                            </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" name="btnAlterar" value="Atualizar Tarefa" class="btn btn-primary">Atualizar</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>

                <div class="modal fade text-dark" id="<?= $modalDeletar ?>" tabindex="-1">
                  <div class="modal-dialog text-dark">
                    <div class="modal-content text-dark">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Deletar Tarefa?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-dark">
                        <p>Deseja realmente excluir a tarefa??</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                        <a href="index.php?idtarefaexc=<?php echo $linha["id"] ?>">
                          <button type="submit" class="btn btn-danger">Sim</button>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>


              <?php } ?>
            </tbody>
          </table>

          <!-- paginação -->
          <div class="container mt-5">
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center">
                <!-- voltar pagina  -->
                <?php
                $pagAnt = $pag - 1;
                
                if ($pagAnt != 0) {

                ?>

                  <li class="page-item">
                    <a class="page-link" href="index.php?pagina=<?= $pagAnt;?>"">
                    <span aria-hidden=" true">&laquo;</span>
                    </a>
                  </li>

                <?php } else { ?>

                  <li class="page-item">
                    <a class="page-link">
                      <span aria-hidden=" true">&laquo;</span>
                    </a>
                  </li>


                <?php } ?>
                <!--  -->

                <!-- paginas -->
                <?php for ($i = 1; $i <= $quant_pag; $i++) { ?>
                  <li class="page-item <?php if($pag == $i) echo "active"?>">
                    <a class="page-link" href="index.php?pagina=<?= $i ?>">
                      <?= $i ?>
                    </a>
                  </li>

                <?php }
                // avançar pagina 
                $pagPost = $pag + 1;

                if ($pagPost <= $quant_pag) {

                ?>

                  <li class="page-item">
                    <a class="page-link" href="index.php?pagina=<?= $pagPost?>">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>

                <?php } else { ?>

                  <li class="page-item">
                    <a class="page-link" href="#">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>

                <?php } ?>

              </ul>
            </nav>
          </div>

          <!-- Fim de paginação -->


          <div class="modal fade" id="exampleModa2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Finalizar Tarefa</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Deseja finalizar esta tarefa?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  <button type="button" class="btn btn-primary">Sim</button>
                </div>
              </div>
            </div>
          </div>



      </main>
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Website 2023</div>

          </div>
        </div>
      </footer>



      <div class="modal fade text-dark" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog text-dark">
          <div class="modal-content text-dark">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Nova Tarefa</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-dark">
              <form class="form-group text-white" action="model.php">
                <div class="mb-3">
                  <label class="form-label text-dark">Nome da Tarefa</label>
                  <input type="text" class="form-control" name="nometarefa">
                </div>
                <div class="mb-3">
                  <label class="form-label text-dark">Descrição da tarefa</label> <textarea class="form-control" name="descricao" rows="3"></textarea>
                </div>
                <div class="row">
                  <div class="mb-3 col-6">
                    <label class="form-label text-dark">Data / Prazo</label>
                    <input type="datetime-local" value="<?= date("Y-m-d\TH:i:s") ?>" class="form-control" name="datatarefa">
                  </div>
                  <div class="mb-3 col-6">
                    <label class="form-label text-dark">Prioridade</label>
                    <select name="prioridade" class="form-select">
                      <option value="1">baixa</option>
                      <option value="2">média</option>
                      <option value="3">alta</option>
                    </select>
                  </div>

                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" name="btncadastrar" value="Cadastrar Tarefa" class="btn btn-primary">Cadastrar</button>
            </div>
            </form>
          </div>
        </div>
      </div>


    </div>
  </div>

  <script>
    var myModalEl = document.getElementById('exampleModa2')
    let checkFinalizar = document.getElementsByClassName('form-check-input')
    myModalEl.addEventListener('hidden.bs.modal', function(event) {
      for (let i = 0; i < checkFinalizar.length; i++) {
        checkFinalizar[i].checked = false
      }

    })
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>
</body>

</html>