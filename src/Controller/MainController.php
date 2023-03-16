<?php

namespace App\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/", name: "main_")]
class MainController extends AbstractController
{
    #[Route("", name: "home")]
    public function home(){
        return $this->render('main/home.html.twig');
    }
    #[Route("/aboutus", name: "aboutus")]
    public function aboutUs(){
        $lorem = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda autem, dolorem doloribus 
        eius fugiat id ipsum itaque laboriosam, minus, nemo nostrum odio quae quo rem repellat reprehenderit 
        sint tempore voluptatum.";
        return $this->render('main/aboutUs.html.twig',['lorem' => $lorem]);
    }
}