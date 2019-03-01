<?php
    require 'database.php';

    $inputmontant1Error = $inputmontant2Error = $montantDetailsError = $beneficiaireDetailsError = $inputmontant1 = $inputmontant2 = $montantDetails = $beneficiaireDetails = "";
        
    if (!empty($_POST))
    {
        $inputmontant1 = checkInput($_POST['inputmontant1']);
        $inputmontant2 = checkInput($_POST['inputmontant2']);
        $montantDetails = checkInput($_POST['montantDetails']);
        $beneficiaireDetails = checkInput($_POST['beneficiaireDetails']);
        $isSuccess = true;
        
        if(!isMontant($inputmontant1))
        {
            $inputmontant1Error == "Le montant n'est pas valide !";
            $isSuccess = false;
        }
        if(!isMontant($inputmontant2))
        {
            $inputmontant2Error == "Erreur!";
            $isSuccess = false;
        }  
        if(!isMontant($montantDetails))
        {
            $montantDetailsError == "Attention";
            $isSuccess = false;
        }   
        if (!isMontant($beneficiaireDetails))
        {
            $beneficiaireDetailsError == "Ouf";
            $isSuccess = false;
        }   
        if($isSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO transfert (input-montant1,input-montant2,montantDetails,beneficiaireDetails) values(?, ?, ?, ?)");
            $statement->execute(array($input-montant1,$input-montant2,$montantDetails,$beneficiaireDetails));
            Database::disconnect();
            header("Location: transfert.php");
        }
        
        echo json_encode($array);
    }


    function IsMontant($var)
    {
        return preg_match("/^[0-9 ]*$/", $var);
    }
    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>
<!DOCTYPE>
<html>
    <head>
        <title>TRANSFERT</title>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="js/bootstrap.js"></script>
        <link rel="stylesheet" href="../css/style.css">
    </head>
</html>
    <body style="margin: 70px 20px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    
            <form id="sim" class="" action="" data-parsley-validate method="post"> 
                <h2 align="center">Envoi d’argent</h2>
                <h5 align="center">Envoyer de l’argent sans frais</h5>
                <div class="text-center" align="center" style="color:red;" id="simulateurError">
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="envoi" class="whiteText myLabel">De</label>
                    </div>
                    <p class="inputAccueilSim col-md-6">
                        <select name="pays_envoi" class="form-control" id="vile_envoi">
                            <option value="0">Choisir ville</option>
                            <option value="1">ABIDJAN</option>
                            <option value="2">ADIAKE</option>
                            <option value="3">BOUAKE</option>
                            <option value="4">YAMOUSSOUKRO</option>
                            <option value="5">KORHOGO</option>
                            <option value="6">ODIENNE</option>
                            <option value="7">GAGNOA</option>
                            <option value="8">MAN</option>
                            <option value="9">BOUNA</option>
                            <option value="10">BONDOUKOU</option>
                        </select> 
                    </p>  
                    <div id="DeviseEnvoi"></div>                     
                    <p class="inputAccueilSim col-md-6">
                        <input class="form-control" id="input-montant1" type="number" step="any" data-parsley-type="number" name="montant" required="required" min="1" placeholder="Montant">
                    </p>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="reception" class="whiteText myLabel">
                            À                        </label>
                    </div>
                    <p class="inputAccueilSim col-md-6">
                        <select name="pays_reception" class="form-control" id="pays_recept">
                            <option value="0">Choisir ville</option>
                            <option value="1">ABIDJAN</option>
                            <option value="2">ADIAKE</option>
                            <option value="3">BOUAKE</option>
                            <option value="4">YAMOUSSOUKRO</option>
                            <option value="5">KORHOGO</option>
                            <option value="6">ODIENNE</option>
                            <option value="7">GAGNOA</option>
                            <option value="8">MAN</option>
                            <option value="9">BOUNA</option>
                            <option value="10">BONDOUKOU</option>
                        </select>
                    </p>
                    <div id="DeviseRecept"></div>
                    <p class="inputAccueilSim col-md-6">
                        <input class="form-control" id="input-montant2" type="number" step="any" data-parsley-type="number" name="montant2" required="required"  min="1" placeholder="Montant">
                    </p>
                </div>
                <div class="form-group col-md-12">
                    <div class="detailSimAccueil">
                        <div class="panel panel-info" style="border: 2px solid #dce4ec; margin-bottom:0px;">
                            <div class="panel-body">
                                <dl class="dl-horizontal myfonts">
                                    <dt class="">
                                        Montant à envoyer :                                   </dt>
                                    <dd id="montantDetails" class="txt-droit"></dd>
                                    <dt class="">
                                        Montant à recevoir :                                    </dt>
                                    <dd id="beneficiaireDetails" class="txt-droit"></dd>
                                </dl>
                                <dt class="reductionSIm">
                                    L'argent est envoyé sur : MTN, Moov et ORANGE.                                </dt>
                                <div id="fraisMobile" class=".aNestPasSupprimer">
                                    <p></p>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <br>
                    <input type='hidden' name='taux' id='input-taux'/>
                    <button class="button1" type="submit" data-disable-on-click="" onclick="focusErrors();">ENVOYER</button>
                </div>
            </form>
                <?php
                        Database::disconnect();
                ?>
        </div>
        </div>
        </div>
    </div>
</div>
    </body>