<?php 
if(empty($_POST)){
  header("Location: index.html");
  exit;
}
require_once('class/social-generator.class.php');$social = new Socio(@$_POST['input']); $social->generate();?>