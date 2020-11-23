<?php

namespace App\Controller;

use App\Entity\Task;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpClient\HttpClient;
use App\Form\Type\TaskType;

class MainController extends AbstractController
{
    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function index(Request $request)
    {
        function getAllSuppCountrys()
        {
            $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getSupportedCountries');
            $json = json_decode($str, true);

            $countrys = [];
            for ($i = 0; $i < count($json); $i++) {
                array_push($countrys, [$json[$i]['countryCode'],$json[$i]['fullName']]);
            }
            return $countrys;
        }

        // $getCountry = $request->query->get('country');
        // $getRegion = $request->query->get('region');
        // $getYear = $request->query->get('year');

        // $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getHolidaysForYear&year=2022&region=act&country=aus&holidayType=public_holiday');
        // $json = json_decode($str, true);


        
        // dd($getCountry);

        return $this->render('holidays/index.html.twig', array('country' => getAllSuppCountrys()));
    }
}
