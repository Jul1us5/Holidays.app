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

        
        
        

        // function getName(Request $request) {
        //     $getCountry = $request->query->get('country');

        //     $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getSupportedCountries');
        //     $json = json_decode($str, true);

        //     $name = [];
        //     for ($i = 0; $i < count($json); $i++) {
        //         if($json[$i]['countryCode'] == $getCountry) {
        //             array_push($name, $json[$i]['fullName']);
        //         }
        //     }
        //     return $name;
        // }



        // function getAllSuppCountrys()
        // {
        //     $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getSupportedCountries');
        //     $json = json_decode($str, true);

        //     $countrys = [];
        //     for ($i = 0; $i < count($json); $i++) {
        //         array_push($countrys, [$json[$i]['countryCode'],$json[$i]['fullName']]);
        //     }
        //     return $countrys;
        // }

        // function getRegionHolidays(Request $request) {
            
        //     $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getSupportedCountries');
        //     $json = json_decode($str, true);


        //     $regions = [];

        //     for ($i = 0; $i < count($json); $i++) {

        //         if(empty($json[$i]['regions'])) {

        //             array_push($regions, []);
                    
        //         } else {
        //             array_push($regions, $json[$i]['regions']);
        //         }


        //     }    

            
        // }
        

        function getAllHolidays(Request $request) {
            $getCountry = $request->query->get('country');
            $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getHolidaysForYear&year=2022&country='. $getCountry .'&holidayType=public_holiday');
            $json = json_decode($str, true);
           
            $HolidaysCount = 0;
            $holidays = [];
            for ($i = 0; $i < count($json); $i++) {
                
                $HolidaysCount = $json[$i]['name'][1]['text'];

                if(empty($HolidaysCount)) {
                    array_push($holidays, $HolidaysCount);
                } else {
                    array_push($holidays, [1]);
                }


                
                array_push($holidays, $HolidaysCount); 
            }

            // dd(empty($holidays));
           
            // dd($holidays);
            // return $holidays;
        }
    


        // dd(getRegionHolidays($request));

        return $this->render('holidays/index.html.twig', 
        array(
            // 'allCountrys' => getAllSuppCountrys(), 
            'num1' => getAllHolidays($request), 
            // 'num' => getRegionHolidays($request),
            // 'regions' => getRegionHolidays($request),
            // 'name' => implode(getName($request)))
        );
    }
}
