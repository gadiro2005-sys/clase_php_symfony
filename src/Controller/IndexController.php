<?php

namespace App\Controller;

use App\Entity\Coche;
use App\Form\AltaCocheType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class IndexController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        //Consultamos los coches de la BD
        $coches = $this->entityManager
            ->getRepository(Coche::class)->findAll();

        return $this->render('index/index.html.twig', [
            'coches' => $coches
        ]);
    }

    #[Route('/alta-coche', name: 'app_alta_coche')]
    public function altaCoche(Request                                                   $request, SluggerInterface $slugger,
                              #[Autowire('%kernel.project_dir%/public/uploads')] string $imagesDirectory): Response
    {
        //Creamos el objeto coche
        $coche = new Coche();
        $form = $this->createForm(AltaCocheType::class, $coche, [
            'action' => $this->generateUrl('app_alta_coche'),
            'method' => 'POST'
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $coche = $form->getData();
            $imagenFile = $form->get('imagen')->getData();
            if ($imagenFile) {
                if (!file_exists($imagesDirectory)) {
                    mkdir($imagesDirectory);
                }
                $originalFilename = pathinfo($imagenFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imagenFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imagenFile->move($imagesDirectory, $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }

            $coche->setImagen($newFilename);
            $this->entityManager->persist($coche);
            $this->entityManager->flush();

            $this->addFlash('notice', 'Coche creado');
            return $this->redirectToRoute('app_alta_coche');
        }

        return $this->render('alta/alta.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
