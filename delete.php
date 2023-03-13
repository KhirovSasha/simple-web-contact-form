<?php
require 'config.php';

$id = $_GET['id'];

if ($id != null) 
{
    $query = "DELETE FROM `comments` WHERE id='$id'";
    $result = $con->query($query);
}

header('Location: /simple-web-contact-form/');