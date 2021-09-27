<?php

if(!isset($_SESSION['administrator']))
{
    header('Location: ' . buildUrl('accesrefuse'));
}