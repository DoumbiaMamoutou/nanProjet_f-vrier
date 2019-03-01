<!DOCTYPE html>
	<html>
	<head>
		<title>eco-TRANSACTION</title>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
	</head>
	<body>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    <form id="achat" action="" method="post">
                        <p style="font-size:20px; font-weight:bold; margin-bottom:20px;">Achat de crédit</p>
                        <label>CHOISSISSEZ</label>
                        <select>
                            <option value="1">Mon Numéro</option>
                            <option value="é">Autre Numéro</option>
                        </select><br><br>
                        <label>Entrez le montant de la recharge (de 100 F à 100 000 F)</label>
                        <input type="number" name="montant" id="montant"><br><br><br><br>
                        <button class="button1" type="submit" data-disable-on-click="" onclick="focusErrors();">CONFIRMER</button>
                    </form>
                </div>
            </div>
        </div>
    </body>