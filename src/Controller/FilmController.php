<?php

namespace App\Controller;

use App\Entity\MoviesFull;
use App\Repository\MoviesFullRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    #[Route('/film', name: 'app_film')]
    public function index(MoviesFullRepository $moviesFullRepository): Response
    {
        $posterDirectory = str_replace("\\", "/", $this->getParameter('assets')) . "/img/posters/";
        // dd($_GET['id']);
        if (file_exists($posterDirectory . $_GET['id'] . ".jpg")) {
            $urlImg="/assets/img/posters/".$_GET['id'].".jpg";
            
        } else {
            $urlImg="/assets/img/posters/default.jpg";
        }
        return $this->render('film/index.html.twig', [
            'controller_name' => 'Film',
            'film' => $moviesFullRepository->findOneBy(["id"=>$_GET['id']]),
            'urlImg' =>$urlImg,
        ]);
    }
}
