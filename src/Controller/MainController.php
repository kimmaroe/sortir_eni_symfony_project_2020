<?php

namespace App\Controller;

use App\Repository\CampusRepository;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(EventRepository $eventRepository, RegistrationRepository $registrationRepository, CampusRepository $campusRepository)
    {
        $eventList = $eventRepository->findAll();
        $registrationList = $registrationRepository->findAll();
        $campusList = $campusRepository->findAll();
        return $this->render('main/home.html.twig', [
            "eventList" => $eventList,
            "registrationList" => $registrationList,
            "campusList" => $campusList,
        ]);
    }


    /**
     * @Route("/home/search/{idAppUser}", requirements={"idAppUser"="\d+"}, name="eventSearch")
     */
    public function filtresChkbx(EventRepository $eventRepository,$idAppUser) {
       //$eventRepository->

    }





}
