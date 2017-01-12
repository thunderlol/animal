<?php 
session_start();

$clientID = $_GET['id'];

include('includes/connection.php');
include('includes/header.php');

//Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina 
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//Selecionar todos os cursos da tabela
$query = "SELECT * FROM lista";
$result = mysqli_query($conn, $query);

//Contar o total de cursos
$total = mysqli_num_rows($result);

//Seta a quantidade de cursos por pagina
$quantidade_pg = 6;

//calcular o número de pagina necessárias para apresentar os cursos
$num_pagina = ceil($total/$quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

//Selecionar os cursos a serem apresentado na página
$query = "SELECT * FROM lista ORDER BY id DESC limit $incio, $quantidade_pg";
$result = mysqli_query($conn, $query);
$total = mysqli_num_rows($result);
mysqli_close($conn);
?>

<div class="row">
                        

        <div class="container theme-showcase" role="main" id="mainT">
			<div class="page-header">
				<div class="row">
					<div class="col-sm-6 col-md-12">
						<form class="form-inline text-center" method="GET" action="pesquisar-anuncios-animais.php">
                            
                            <div class="text-center"><h1>Encontre seu <b>AMIGO</b> perdido ou para adoção aqui.</h1><br></div>
							<div class="form-group">
								<label for="exampleInputName2">CIDADE</label>
								<input type="text" name="cidade" class="form-control" id="exampleInputName1" style='text-transform:uppercase' placeholder="Digitar...">
							</div>
                            <div class="form-group">
								<label for="exampleInputName2">BAIRRO</label>
								<input type="text" name="bairro" class="form-control" id="exampleInputName2"  style='text-transform:uppercase'placeholder="Digitar...">
							</div>
                            <div class="form-group">
                                <label for="sel">ANÚNCIO</label>
                                <select class="form-control" name="tipo" id="sel">
                                    <option>Todos</option>
                                    <option>Encontrado</option>
                                    <option>Perdido</option>
                                    <option>Adoção</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary ">Encontrar meu amigo</button>
						</form>
					</div>
				</div>
			</div>
        </div>
    <div class="text-center det" ><h1>Últimas atualizações</h1></div>
			
    <!--Página com últimos anúncios de animais perdido ou para adoção -->
    <div class="row">
                
				<?php while($rows_anuncios = mysqli_fetch_assoc($result)){ ?>
                	<div class="col-sm-6 col-md-4">
						<div class="thumbnail">
                            <h3><?php echo $rows_anuncios['anuncio'] ?></h3>
                            <h5><?php echo $rows_anuncios['optradio1'] ?></h5>
                             <a href="detalhes-anuncio-animais.php?id_anuncio=<?php echo $rows_anuncios['id']; ?>"><img src="data:image;base64,<?php echo $rows_anuncios['image'] ?>"></a>
							<div class="caption text-center">
								<h3><?php echo $rows_anuncios['cidade']; ?></h3>
                                <h5><?php echo $rows_anuncios['bairro'] ?></h5>
                                
                                <h5>Data do anúncio : <?php echo $rows_anuncios['date_added'] ?></h5>
								
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<!--<?php
				//Verificar a pagina anterior e posterior
				$pagina_anterior = $pagina - 1;
				$pagina_posterior = $pagina + 1;
			?>
			<nav class="text-center">
				<ul class="pagination">
					<li>
						<?php
						if($pagina_anterior != 0){ ?>
							<a href="index.php?pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						<?php }else{ ?>
							<span aria-hidden="true">&laquo;</span>
					<?php }  ?>
					</li>
					<?php 
					//Apresentar a paginacao
					for($i = 1; $i < $num_pagina + 1; $i++){ ?>
						<li><a href="index.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
					<?php } ?>
					<li>
						<?php
						if($pagina_posterior <= $num_pagina){ ?>
							<a href="index.php?pagina=<?php echo $pagina_posterior; ?>" aria-label="Previous">
								<span aria-hidden="true">&raquo;</span>
							</a>
						<?php }else{ ?>
							<span aria-hidden="true">&raquo;</span>
					<?php }  ?>
					</li>
				</ul>
			</nav>-->
		</div>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- encopet1 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6240799849998513"
     data-ad-slot="4227547186"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

<?php
include('includes/footer.php');
?>