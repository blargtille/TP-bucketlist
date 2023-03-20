<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $wish = new Wish();

        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()){
            $wish->setDateCreated(new \DateTime('now'));
            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success', 'New wish added!');
            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        }
        return $this->render('/wish/create.html.twig', [
            'wishForm'=>$wishForm
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
