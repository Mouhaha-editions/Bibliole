<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Service\GoogleBookService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(Request $request, GoogleBookService $googleBookService, BookRepository $bookRepository): Response
    {
        $form = $this
            ->createFormBuilder()
            ->add('isbn', IntegerType::class)
            ->add('ajouter', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $isbn = (int)$form->get('isbn')->getNormData();
            $book = $bookRepository->findOneBy(['barcode' => $isbn]);

            if (!$book) {
                $book = $googleBookService->getByISBN($isbn, $this->getParameter('google_book_api_key'));

                if ($book){
                    try {
                        $bookRepository->save($book, true);
                        $this->addFlash('success', 'Livre ajouté');
                    } catch (Exception $e) {
                        $this->addFlash('danger', 'Probleme avec l\'insertion du livre');
                    }
                }else{
                    $this->addFlash('danger', 'Livre introuvable chez Google');
                }
            } else {
                $this->addFlash('warning', 'Livre déjà ajouté');
            }
        }

        return $this->render('home_page/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
