<?php

class HomeController
{
    public function index()
    {
        $view = "views/home.php";
        include_once("views/main.php");
    }
}