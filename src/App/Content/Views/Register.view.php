<?php

include BASE_PATH . "Content/Test/Register.php";



if(!empty($_GET['firstname']) and !empty($_GET['showPasswordButton'])){
   $var1=$_GET['firstname'];
   $var2=$_GET['showPasswordButton'];
   echo $var1 . $var2;

}
?>