<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findWishes();

        dump($wishes);

        return $this->render('wish/list.html.twig', [
            'wishes' =>$wishes
        ]);
    }
    #[Route('/detail/{id}', name: 'detail')]
    public function detail(int $id, WishRepository $wishRepository): Response{

        $wish = $wishRepository->find($id);

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish
        ]);
    }
    #[Route('/demo', name: 'demo')]
    public function demo(EntityManagerInterface $entityManager): Response{
        $wish = new Wish();
        $wish->setTitle('Planter un potager');
        $wish->setAuthor('Moi');
        $wish->setDescription('planter des légumes et des herbes aromatiques selon les saisons');
        $wish->setDateCreated(new \DateTime());
        $wish->setIsPublished(true);

        $entityManager->persist($wish);
        $entityManager->flush();

        dump($wish);

        return $this->render('main/home.html.twig');
    }
}
