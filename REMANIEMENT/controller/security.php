<?php 

if(!isset($_SESSION['auth']))
{
    header('Location: ' . buildUrl('accesrefuse'));
}