
<?php 

session_start();

include('includes/connection.php');
include('includes/header.php');

//Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina 
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;
if(!isset($_GET['cidade'])){
	header("Location: index.php");
}else{
    
    $valor_cidade = $_GET['cidade'];
    $valor_bairro = $_GET['bairro'];
    $valor_tipo = $_GET['tipo'];
    
    if ($valor_tipo == "Todos"){
        $valor_tipo = "";
    }
        
}

if ($valor_cidade == "" and $valor_bairro != "" and $valor_tipo == ""){
//Selecionar todos os anúncio da tabela
$query = "SELECT * FROM lista WHERE bairro LIKE '%$valor_bairro%'";    
$result = mysqli_query($conn, $query);

//Contar o total de anúncios
$total = mysqli_num_rows($result);

//Seta a quantidade de anúncios por pagina
$quantidade_pg = 6;

//calcular o número de pagina necessárias para apresentar os anúncio
$num_pagina = ceil($total/$quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

//Selecionar os anúncios a serem apresentado na página
$query = "SELECT * FROM lista WHERE bairro LIKE '%$valor_bairro%' ORDER BY id DESC limit $incio, $quantidade_pg";
$result= mysqli_query($conn, $query);
$total = mysqli_num_rows($result);
    
} elseif   ($valor_bairro == "" and $valor_cidade != "" and $valor_tipo == ""){
    
$query = "SELECT * FROM lista WHERE cidade LIKE '%$valor_cidade%'";
$result = mysqli_query($conn, $query);

$total = mysqli_num_rows($result);

$quantidade_pg = 6;

$num_pagina = ceil($total/$quantidade_pg);

$incio = ($quantidade_pg*$pagina)-$quantidade_pg;
    
$query = "SELECT * FROM lista WHERE cidade LIKE '%$valor_cidade%' ORDER BY id DESC limit $incio, $quantidade_pg";

$result= mysqli_query($conn, $query);
$total = mysqli_num_rows($result);
    
} elseif ($valor_bairro != "" and $valor_cidade != "" and $valor_tipo == ""){

$query = "SELECT * FROM lista WHERE cidade LIKE '%$valor_cidade%' and bairro LIKE '%$valor_bairro%'";
$result = mysqli_query($conn, $query);

$total = mysqli_num_rows($result);

$quantidade_pg = 6;

$num_pagina = ceil($total/$quantidade_pg);

$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

$query = "SELECT * FROM lista WHERE cidade LIKE '%$valor_cidade%' and bairro LIKE '%$valor_bairro%' ORDER BY id DESC limit $incio, $quantidade_pg";

$result= mysqli_query($conn, $query);
$total = mysqli_num_rows($result);
    
} elseif ($valor_bairro == "" and $valor_cidade == "" and $valor_tipo != ""){

$query = "SELECT * FROM lista WHERE anuncio LIKE '%$valor_tipo%'";
$result = mysqli_query($conn, $query);

$total = mysqli_num_rows($result);

$quantidade_pg = 6;

$num_pagina = ceil($total/$quantidade_pg);

$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

$query = "SELECT * FROM lista WHERE anuncio LIKE '%$valor_tipo%' ORDER BY id DESC limit $incio, $quantidade_pg";

$result= mysqli_query($conn, $query);
$total = mysqli_num_rows($result);
    
} elseif ($valor_bairro == "" and $valor_cidade != "" and $valor_tipo != ""){

$query = "SELECT * FROM lista WHERE anuncio LIKE '%$valor_tipo%' and cidade LIKE '%$valor_cidade%'";
$result = mysqli_query($conn, $query);

$total = mysqli_num_rows($result);

$quantidade_pg = 6;

$num_pagina = ceil($total/$quantidade_pg);

$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

$query = "SELECT * FROM lista WHERE anuncio LIKE '%$valor_tipo%' and cidade LIKE '%$valor_cidade%' ORDER BY id DESC limit $incio, $quantidade_pg";

$result= mysqli_query($conn, $query);
$total = mysqli_num_rows($result);
    
} elseif ($valor_bairro != "" and $valor_cidade == "" and $valor_tipo != ""){

$query = "SELECT * FROM lista WHERE anuncio LIKE '%$valor_tipo%' and bairro LIKE '%$valor_bairro%'";
$result = mysqli_query($conn, $query);

$total = mysqli_num_rows($result);

$quantidade_pg = 6;

$num_pagina = ceil($total/$quantidade_pg);

$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

$query = "SELECT * FROM lista WHERE anuncio LIKE '%$valor_tipo%' and bairro LIKE '%$valor_bairro%' ORDER BY id DESC limit $incio, $quantidade_pg";

$result= mysqli_query($conn, $query);
$total = mysqli_num_rows($result);
    
} elseif ($valor_bairro != "" and $valor_cidade != "" and $valor_tipo != ""){

$query = "SELECT * FROM lista WHERE anuncio LIKE '%$valor_tipo%' and bairro LIKE '%$valor_bairro%' and cidade LIKE '%$valor_cidade%'";
$result = mysqli_query($conn, $query);

$total = mysqli_num_rows($result);

$quantidade_pg = 6;

$num_pagina = ceil($total/$quantidade_pg);

$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

$query = "SELECT * FROM lista WHERE anuncio LIKE '%$valor_tipo%' and bairro LIKE '%$valor_bairro%' and cidade LIKE '%$valor_cidade%' ORDER BY id DESC limit $incio, $quantidade_pg";

$result= mysqli_query($conn, $query);
$total = mysqli_num_rows($result);
    
} else {
    
$query = "SELECT * FROM lista ";

$result = mysqli_query($conn, $query);

$total = mysqli_num_rows($result);

$quantidade_pg = 6;

$num_pagina = ceil($total/$quantidade_pg);

$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

$query = "SELECT * FROM lista ORDER BY id DESC limit $incio, $quantidade_pg";

$result= mysqli_query($conn, $query);
$total = mysqli_num_rows($result);

}

mysqli_close($conn);

?>

<!--Página que mostra anúncios de animais, pets perdidos ou para adoção -->

        <h1 class="det">Anúncios</h1>
        <div class="container theme-showcase" role="main">
			<div class="page-header">
				<div class="row">
					<div class="col-sm-6 col-md-12">
						<form class="form-inline text-center" method="GET" action="pesquisar-anuncios-animais.php">
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
                            <button type="submit" class="btn btn-primary">Pesquisar</button>
						</form>
					</div>
				</div>
			</div>
        </div>
			<div class="row">
				<?php while($rows_anuncios = mysqli_fetch_assoc($result)){ ?>
					<div class="col-sm-6 col-md-4">
						<div class="thumbnail">
                            <h3><?php echo $rows_anuncios['anuncio'] ?></h3>
                            <h5><?php echo $rows_anuncios['optradio1'] ?></h5>
                            <a href="detalhes-anuncio-animais.php?id_anuncio=<?php echo $rows_anuncios['id']; ?>"><img src="data:image;base64,<?php echo $rows_anuncios['image'] ?> "alt="foto do animal, pet perdido ou para adoção"></a>
							<div class="caption text-center">
								 <h3><?php echo $rows_anuncios['cidade']; ?></h3>
			                     <h5> <?php echo $rows_anuncios['bairro'];?></h5>					
                                
                                <h5>Data do anúncio : <?php echo $rows_anuncios['date_added'] ?></h5>
                                
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<?php
				//Verificar a pagina anterior e posterior
				$pagina_anterior = $pagina - 1;
				$pagina_posterior = $pagina + 1;
			?>
			<nav class="text-center">
				<ul class="pagination">
					<li>
						<?php
						if($pagina_anterior != 0){ ?>
							<a href="pesquisar-anuncios-animais.php?pagina=<?php echo $pagina_anterior; ?>&cidade=<?php echo $valor_cidade; ?>&bairro=<?php echo $valor_bairro; ?>&tipo=<?php echo $valor_tipo; ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						<?php }else{ ?>
							<span aria-hidden="true">&laquo;</span>
					<?php }  ?>
					</li>
					<?php 
					//Apresentar a paginacao
					for($i = 1; $i < $num_pagina + 1; $i++){ ?>
						<li><a href="pesquisar-anuncios-animais.php?pagina=<?php echo $i; ?>&cidade=<?php echo $valor_cidade; ?>&bairro=<?php echo $valor_bairro; ?>&tipo=<?php echo $valor_tipo; ?>"><?php echo $i; ?></a></li>
					<?php } ?>
					<li>
						<?php
						if($pagina_posterior <= $num_pagina){ ?>
							<a href="pesquisar-anuncios-animais.php?pagina=<?php echo $pagina_posterior; ?>&cidade=<?php echo $valor_cidade; ?>&bairro=<?php echo $valor_bairro; ?>&tipo=<?php echo $valor_tipo; ?>" aria-label="Previous">
								<span aria-hidden="true">&raquo;</span>
							</a>
						<?php }else{ ?>
							<span aria-hidden="true">&raquo;</span>
					<?php }  ?>
					</li>
				</ul>
			</nav>
		</div>
<?php
include('includes/footer.php');
?>
		