<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController
{
    /**
     * @Route("/hello")
     */
    public function HelloWorldController() {

        echo 'Hello World!';
        exit();
    }
}