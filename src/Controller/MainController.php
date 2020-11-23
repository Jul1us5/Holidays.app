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

        function getRegions(Request $request) {


            $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getSupportedCountries');
            $json = json_decode($str, true);

            $regions = [];
            $getRegion = $request->query->get('country');

            // dd($json[0]['countryCode']);

            // dd($request);
            for ($i = 0; $i < count($json); $i++) {
                
                if($json[$i]['countryCode'] === $getRegion) {

                    if(isset($json[0]['regions'])) {

                        array_push($regions, $json[$i]['regions']);                       
                    } 
                
                }
            }
            if (!empty($regions[0])) {
                return $regions[0];
            } else {
                return [];
            }
                        // dd($regions[0]);
                        

        }

        // $getCountry = $request->query->get('country');
        // $getRegion = $request->query->get('region');
        // $getYear = $request->query->get('year');

        // $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getHolidaysForYear&year=2022&region=act&country=aus&holidayType=public_holiday');
        // $json = json_decode($str, true);


        
        // dd($getCountry);

        return $this->render('holidays/index.html.twig', array('country' => getAllSuppCountrys(), 'region' => getRegions($request)));
    }
}
