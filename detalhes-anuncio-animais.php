<?php 

session_start();

include('includes/connection.php');
include('includes/header.php');

$id_anuncio = $_GET['id_anuncio'];
$query = "SELECT * FROM lista WHERE id='$id_anuncio'";
$result = mysqli_query($conn, $query);
$row_anuncio = mysqli_fetch_assoc($result);
/*$time = strtotime($row_anuncio['date_added']);
$mydate = date("d/m/y H:i ", $time);*/
mysqli_close($conn);

?>
    <!--Página para detalhes de anúncios de animais, pets perdidos ou para adoção -->
    <h1 class="det">Detalhes</h1>
    <div class="container theme-showcase" role="main">
			
                  <div class="row">
					<div class="col-sm-6 col-md-6">
						<div class="thumbnail" >
                            <h2><?php echo $row_anuncio['anuncio'] ?></h2>
                            <h4><?php echo $row_anuncio['optradio1'] ?></h4>
                             <img src="data:image;base64,<?php echo $row_anuncio['image'] ?>" alt="foto do animal, pet perdido ou para adoção">
							<div class="caption text-center">
                                <h3><?php echo $row_anuncio['cidade']; ?></h3>
			                    <h5><?php echo $row_anuncio['bairro'];?></h5>				
							</div>
						</div>
					</div>
                                
                        <div class="col-sm-6 col-md-6">
                              <h2>Descrição</h2>
                              <p><?php echo $row_anuncio['notes']; ?></p>
                              <hr>
                              <h4 class="det">Sexo</h4>
                              <p><?php echo $row_anuncio['optradio'] ?></p>
                              <h4 class="det">Porte</h4>
                              <p><?php echo $row_anuncio['porte'] ?></p>
                              <h4 class="det">Telefone</h4>
                              <p><?php echo $row_anuncio['phone'] ?></p>
                              <h4 class="det">Data do anúncio</h4>
                              <p><?php echo $row_anuncio['date_added']  ?></p>
                        <div class="text-center">    <FORM><INPUT type="button" VALUE="Voltar" class="btn btn-lg btn-primary" onClick="history.go(-1);return true;"></FORM></div>
                      </div>
                  </div>
              </div>
        
		
		<?php
include('includes/footer.php');
?>
