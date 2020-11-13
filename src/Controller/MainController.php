<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function getter()
    {
        $file = file_get_contents("https://kayaposoft.com/enrico/json/v2.0?action=getHolidaysForMonth&month=1&year=2022&country=ltu&region=bw&holidayType=public_holiday");
        
        

     

            return $this->render('holidays/index.html.twig', array('name' => $file));
        

        
    }
}