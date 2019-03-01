<?php
    require 'database.php';

    $firstNameError = $lastNameError = $emailError = $passwordError = $phoneNumberError = $firstName = $lastName = $email = $password = $phoneNumber = "";
    /*$array = array("firstName" => "", "lastName" => "", "email" => "", "password" => "", "phoneNumber" => "", "firstNameError" => "", "lastNameError" => "", "emailError" => "", "passwordError" => "", "phoneNumberError" => "", "isSuccess" => false);*/
        
    if (!empty($_POST))
    {
        $firstName = checkInput($_POST['firstName']);
        $lastName = checkInput($_POST['lastName']);
        $email = checkInput($_POST['email']);
        $password = checkInput($_POST['password']);
        $phoneNumber = checkInput($_POST['phoneNumber']);
        $isSuccess  = true;
        /*$array["firstName"] = verifyInput($_POST["firstName"]);
        $array["lastName"] = verifyInput($_POST["lastName"]);
        $array["email"] = verifyInput($_POST["email"]);
        $array["password"] = verifyInput($_POST["password"]);
        $array["phoneNumber"] = verifyInput($_POST["phoneNumber"]);
        $array["isSuccess"] = true;
        $emailText = "";*/
        
        
        
        if(empty($firstName))
        {
            $firstNameError = "Je veux connaitre ton prénom !";
            $isSuccess = false;
        }
        if(empty($lastName))
        {
            $lastNameError = "Et oui je veux tout savoir. Même ton nom !";
            $isSuccess = false;
        }  
        if(empty($password))
        {
            $passwordError = "Le mot de passe doit comprendre au moins 8 cractères";
            $isSuccess = false;
        }   
        if (!IsEmail($email))
        {
            $emailError = "T'essaies de me rouler ? C'est pas un email ça";
            $isSuccess = false;
        }   
        if (!IsPhone($phoneNumber))
        {
            $phoneError = "Que des chiffres et des espaces, stp...";
            $isSuccess = false;
        }
        if($isSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO inscription (firstname,lastname,email,password,phoneNumber) values(?, ?, ?, ?, ?)");
            $statement->execute(array($firstname,$lastname,$email,$password,$phoneNumber));
            Database::disconnect();
            header("Location: inscription.php");
        }
        
        echo json_encode($array);
    }


    function IsPhone($var)
    {
        return preg_match("/^[0-9 ]*$/", $var);
    }
    function IsEmail($var)
    {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>
<!DOCTYPE html>
	<html>
	<head>
		<title>eco-TRANSACTION</title>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
	</head>
	<body style="margin: 70px;  background: gold;">
        <div class="container">
            <div class="divider"></div>
            <div class="heading">
                <h1>INSCRIVEZ-VOUS</h1>
            </div>
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    <?php
                         $db = Database::connect();
                                foreach($db->query('SELECT * FROM inscription') as $row)
                                {
                                    echo '<option value="'. $row['id'] .'">' . $row['firstname'] . '</option>';
                                }
                                Database::disconnect();
                       ?>
                    
                    <form id="contact-form" method="post" action="" role="form">

                    <fieldset>
                        <legend>Adresse e-mail</legend>

                        <div class="input-wrapper">
                            <label>Utilisée pour vous connecter à votre compte.</label>
                            <div class="input-single ">
                                <input type="email" name="email" class="form-control" placeholder="email&#64;example.org" required="" value="" maxlength="100" tabindex="1" id="email" /><br>
                                <p class="comments"></p>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Mot de passe</legend>

                        <div class="input-wrapper">
                            <label>Doit comporter au moins 8 caractères et contenir au moins 1 chiffre et 1 lettre majuscule.</label>

                            <div class="row">
                                <div class="medium-6 columns">
                                    <div class="input-single " id="passDiv">
                                        <input type="password" name="password" class="form-control" value="" placeholder="Créer un mot de passe" required="" maxlength="32" tabindex="2" pattern="[^&#92;s]*[0-9][^&#92;s]*[A-Z][^&#92;s]*|[^&#92;s]*[A-Z][^&#92;s]*[0-9][^&#92;s]*" data-abide-validator="ntPassword" id="password" /><br>
                                        <p class="comments"></p>
                                    </div>
                                </div>

                                <div class="medium-6 columns">
                                    <div class="input-single " id="confirmPassDiv">
                                        <input type="password" name="passwordConfirm" class="form-control" value="" placeholder="Confirmer le mot de passe" required="" maxlength="32" tabindex="3" data-equalto="password" id="passwordConfirm" /><br>
                                        <p class="comments"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="password-strength">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </fieldset>
                        
                    <fieldset>
                        <legend>Informations personnelles</legend>

                        <div class="input-wrapper">
                            <label>famille</label>

                            <div class="row">
                                <div class="medium-6 columns">
                                    <div class="input-single ">
                                        <input type="text" name="firstName" class="form-control" value="" placeholder="Prénom" required="" maxlength="25" tabindex="5" id="firstName" /><br>
                                        <p class="comments"></p>
                                    </div>
                                </div>

                                <div class="medium-6 columns">
                                    <div class="input-single ">
                                        <input type="text" name="lastName" class="form-control" value="" placeholder="Nom de famille" required="" maxlength="25" tabindex="6" id="lastName" /><br>
                                        <p class="comments"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="medium-7 columns">
                                <div class="input-wrapper">
                                    <label>Date de naissance</label>

                                    <div class="row">
                                        <div class="medium-4 columns">
                                            <div class="input-single ">
                                                <select name="birthDateYear" class="placeholder" required="" data-error-message="#error-dob" tabindex="7" id="birthDateYear" >
                                                <option value="">YYYY</option>
                                                    <option value="2019" >2019</option>
                                                    <option value="2018" >2018</option>
                                                    <option value="2017" >2017</option>
                                                    <option value="2016" >2016</option>
                                                    <option value="2015" >2015</option>
                                                    <option value="2014" >2014</option>
                                                    <option value="2013" >2013</option>
                                                    <option value="2012" >2012</option>
                                                    <option value="2011" >2011</option>
                                                    <option value="2010" >2010</option>
                                                    <option value="2009" >2009</option>
                                                    <option value="2008" >2008</option>
                                                    <option value="2007" >2007</option>
                                                    <option value="2006" >2006</option>
                                                    <option value="2005" >2005</option>
                                                    <option value="2004" >2004</option>
                                                    <option value="2003" >2003</option>
                                                    <option value="2002" >2002</option>
                                                    <option value="2001" >2001</option>
                                                    <option value="2000" >2000</option>
                                                    <option value="1999" >1999</option>
                                                    <option value="1998" >1998</option>
                                                    <option value="1997" >1997</option>
                                                    <option value="1996" >1996</option>
                                                    <option value="1995" >1995</option>
                                                    <option value="1994" >1994</option>
                                                    <option value="1993" >1993</option>
                                                    <option value="1992" >1992</option>
                                                    <option value="1991" >1991</option>
                                                    <option value="1990" >1990</option>
                                                    <option value="1989" >1989</option>
                                                    <option value="1988" >1988</option>
                                                    <option value="1987" >1987</option>
                                                    <option value="1986" >1986</option>
                                                    <option value="1985" >1985</option>
                                                    <option value="1984" >1984</option>
                                                    <option value="1983" >1983</option>
                                                    <option value="1982" >1982</option>
                                                    <option value="1981" >1981</option>
                                                    <option value="1980" >1980</option>
                                                    <option value="1979" >1979</option>
                                                    <option value="1978" >1978</option>
                                                    <option value="1977" >1977</option>
                                                    <option value="1976" >1976</option>
                                                    <option value="1975" >1975</option>
                                                    <option value="1974" >1974</option>
                                                    <option value="1973" >1973</option>
                                                    <option value="1972" >1972</option>
                                                    <option value="1971" >1971</option>
                                                    <option value="1970" >1970</option>
                                                    <option value="1969" >1969</option>
                                                    <option value="1968" >1968</option>
                                                    <option value="1967" >1967</option>
                                                    <option value="1966" >1966</option>
                                                    <option value="1965" >1965</option>
                                                    <option value="1964" >1964</option>
                                                    <option value="1963" >1963</option>
                                                    <option value="1962" >1962</option>
                                                    <option value="1961" >1961</option>
                                                    <option value="1960" >1960</option>
                                                    <option value="1959" >1959</option>
                                                    <option value="1958" >1958</option>
                                                    <option value="1957" >1957</option>
                                                    <option value="1956" >1956</option>
                                                    <option value="1955" >1955</option>
                                                    <option value="1954" >1954</option>
                                                    <option value="1953" >1953</option>
                                                    <option value="1952" >1952</option>
                                                    <option value="1951" >1951</option>
                                                    <option value="1950" >1950</option>
                                                    <option value="1949" >1949</option>
                                                    <option value="1948" >1948</option>
                                                    <option value="1947" >1947</option>
                                                    <option value="1946" >1946</option>
                                                    <option value="1945" >1945</option>
                                                    <option value="1944" >1944</option>
                                                    <option value="1943" >1943</option>
                                                    <option value="1942" >1942</option>
                                                    <option value="1941" >1941</option>
                                                    <option value="1940" >1940</option>
                                                    <option value="1939" >1939</option>
                                                    <option value="1938" >1938</option>
                                                    <option value="1937" >1937</option>
                                                    <option value="1936" >1936</option>
                                                    <option value="1935" >1935</option>
                                                    <option value="1934" >1934</option>
                                                    <option value="1933" >1933</option>
                                                    <option value="1932" >1932</option>
                                                    <option value="1931" >1931</option>
                                                    <option value="1930" >1930</option>
                                                    <option value="1929" >1929</option>
                                                    <option value="1928" >1928</option>
                                                    <option value="1927" >1927</option>
                                                    <option value="1926" >1926</option>
                                                    <option value="1925" >1925</option>
                                                    <option value="1924" >1924</option>
                                                    <option value="1923" >1923</option>
                                                    <option value="1922" >1922</option>
                                                    <option value="1921" >1921</option>
                                                    <option value="1920" >1920</option>
                                                    <option value="1919" >1919</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="medium-4 columns">
                                            <div class="input-single ">
                                                <select name="birthDateMonth" class="placeholder" required="" data-error-message="#error-dob" tabindex="8" id="birthDateMonth" >
                                                    <option value="">MM</option>
                                                    <option value="1" >Janv.</option>
                                                    <option value="2" >Fév.</option>
                                                    <option value="3" >Mars</option>
                                                    <option value="4" >Avr.</option>
                                                    <option value="5" >Mai</option>
                                                    <option value="6" >Juin</option>
                                                    <option value="7" >Juil.</option>
                                                    <option value="8" >Août</option>
                                                    <option value="9" >Sept.</option>
                                                    <option value="10" >Oct.</option>
                                                    <option value="11" >Nov.</option>
                                                    <option value="12" >Déc.</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="medium-4 columns">
                                            <div class="input-single ">
                                                <select name="birthDateDay" class="placeholder" required="" data-error-message="#error-dob" tabindex="9" id="birthDateDay" >
                                                    <option value="">DD</option>
                                                    <option value="1" >01</option>
                                                    <option value="2" >02</option>
                                                    <option value="3" >03</option>
                                                    <option value="4" >04</option>
                                                    <option value="5" >05</option>
                                                    <option value="6" >06</option>
                                                    <option value="7" >07</option>
                                                    <option value="8" >08</option>
                                                    <option value="9" >09</option>
                                                    <option value="10" >10</option>
                                                    <option value="11" >11</option>
                                                    <option value="12" >12</option>
                                                    <option value="13" >13</option>
                                                    <option value="14" >14</option>
                                                    <option value="15" >15</option>
                                                    <option value="16" >16</option>
                                                    <option value="17" >17</option>
                                                    <option value="18" >18</option>
                                                    <option value="19" >19</option>
                                                    <option value="20" >20</option>
                                                    <option value="21" >21</option>
                                                    <option value="22" >22</option>
                                                    <option value="23" >23</option>
                                                    <option value="24" >24</option>
                                                    <option value="25" >25</option>
                                                    <option value="26" >26</option>
                                                    <option value="27" >27</option>
                                                    <option value="28" >28</option>
                                                    <option value="29" >29</option>
                                                    <option value="30" >30</option>
                                                    <option value="31" >31</option>
                                                </select><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <p class="comments"></p>
                            </div>

                            <div class="medium-5 columns">
                                <div class="input-wrapper">
                                    <label>Sexe</label>
                                     <div class="input-single">
                                        <select id="gender" name="gender" class="placeholder" required="" data-invalid="" aria-invalid="true" aria-describedby="error-gender" tabindex="10" >
                                            <option value="" >sélectionner...</option>
                                            <option value="M" >Homme</option>
                                            <option value="F" >Femme</option>
                                        </select><br>
                                    </div>
                                </div>
                               <p class="comments"></p>
                            </div>
                        </div>

                        <div class="input-wrapper">
                            <label>Adresse</label>

                            <div class="input-single ">
                                <input type="text" name="address1" value="" required="" placeholder="Adresse Rue" maxlength="35" tabindex="11" id="address1" /><br>
                                <p class="comments"></p>
                            </div>
                            <div class="row">
                                <div class="medium-6 columns">
                                    <div class="input-single ">
                                        <select name="country" sort="name" class="placeholder" required="" tabindex="13" id="country" >
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
                                        </select><br>
                                        <p class="comments"></p>
                            
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="input-wrapper">
                            <label>Numéro de téléphone</label>

                            <div class="row">
                                <div class="medium-6 columns">
                                    <div class="input-single ">
                                        <input type="phone" name="phoneNumber" value="" placeholder="Numéro de téléphone" required="" maxlength="25" tabindex="18" id="phoneNumber" /><br>
                                        <p class="comments"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="personal-number-details" class="row">

                        </div>

                    </fieldset>

                    <p class="form-note text-medium hide" id="termsNoNetPlus">
                        En ouvrant mon compte, j’accepte les <a href="#" target="_blank" name="termsOfUse">Conditions d’utilisation des comptes eco-TRANSACTION</a> et les <a href="#" target="_blank" name="privacyPolicy">Avis de confidentialité eco-TRANSACTION</a>.
                    </p>

                    <div class="input-wrapper">
                        <button class="button1" type="submit" data-disable-on-click="" onclick="focusErrors();">Ouvrir un compte</button>
                    </div>

                    <input type="hidden" name="marketingOpt" value="" id="marketingOpt" />

                    <input type="hidden" name="quickSignUpKey" value="" id="quickSignUpKey" />
                    <input type="hidden" name="linkBackUrl" value="" id="linkBackUrl" />
                        
                    </form>
                    <?php
                        Database::disconnect();
                    ?>
                </div>
            </div>
        </div>
    </body>