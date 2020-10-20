<?php

namespace App\Controller;

use App\Entity\Spot;

use App\Entity\Town;
use App\Form\SpotAddFormType;
use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class SpotController extends AbstractController
{
    /**
     * @Route("/spot", name="spot", methods={"POST"})
     */
    public function index()
    {
        return $this->render('spot/index.html.twig', [
            'controller_name' => 'SpotController',
        ]);
    }

    /**
     * @Route ("/spot/add", name="spot_add")
     */
    public function addSpot(Request $request, EntityManagerInterface $entityManager)
    {
       // $this->denyAccessUnlessGranted("ROLE_USER");

        $townRepository = $entityManager->getRepository(Town::class);
        $towns = $townRepository->findBy(array(), array('name' => 'ASC'));
        $spot = new Spot();
        //valeur par défaut qui va s'afficher dans le form !
        $spotAddForm = $this->createForm(SpotAddFormType::class, $spot);
        $spotAddForm->handleRequest($request);

        //si le formulaire est envoyé, set des valeurs par défaut de published et date
        if($spotAddForm->isSubmitted() && $spotAddForm->isValid())
        {
            //récup de la town sélectionnée
            $selectedTown = $townRepository->find($request->get('town'));
            $spot->setTown($selectedTown);
            //envoi à la base de données
            $entityManager->persist($spot);
            $entityManager->flush();
            // message Flash
            $this->addFlash("green", "New Spot registered !");

            return $this->redirectToRoute("event_add");
        }

        return $this->render('spot/spot-add.html.twig', [
            'spotAddForm' => $spotAddForm->createView(),
            'towns' => $towns,
        ]);

    }



    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     * @Route ("/choucroute", name="choucroute", methods={"GET"})
     */
    public function getAvailableSpotsJson(Request $request, EntityManagerInterface $entityManager)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $spotRepository = $entityManager->getRepository(Spot::class);

        $spots = $spotRepository->spotTest(1);
        $jsonContent = $serializer->serialize($spots, 'json',
            [AbstractNormalizer::IGNORED_ATTRIBUTES => ['events','town']]);
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        return $response;
    }
}
