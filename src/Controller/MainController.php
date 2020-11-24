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
            $getCountry = $request->query->get('country');
            for ($i = 0; $i < count($json); $i++) {
                
                if($json[$i]['countryCode'] === $getCountry) {

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
        }

        function getName(Request $request) {
            $getCountry = $request->query->get('country');

            $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getSupportedCountries');
            $json = json_decode($str, true);

            $name = [];
            for ($i = 0; $i < count($json); $i++) {
                if($json[$i]['countryCode'] == $getCountry) {
                    
                    array_push($name, $json[$i]['countryCode']);
                    array_push($name, $json[$i]['fullName']);
                }
            }
            if (!empty($name)) {
                return $name;
            } else {
                return [[]];
            }

        }

        function getYearAndRegion(Request $request) {

            $getYear = $request->query->get('year');
            $getRegion = $request->query->get('region');
            $years = ['2020', '2021', '2022', '2023', '2024', '2025', '2026', '2027'];
            $concat = [];

            array_push($concat, $getYear);
            array_push($concat, $years);
            array_push($concat, $getRegion);

            return $concat;
        }
        function getAllHolidays(Request $request) {

 
                $getCountry = $request->query->get('country');
                $getRegion = $request->query->get('region');
                $getYear = $request->query->get('year');
            
                if(!isset($getCountry)) {
                    $getCountry = 'lt';
                }
                if(!isset($getRegion)) {
                    $getRegion = '';
                }
                if(!isset($getYear)) {
                    $getYear = '2020';
                }

            $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getHolidaysForYear&year='. $getYear .'&region='. $getRegion .'&country='. $getCountry .'&holidayType=public_holiday');
            $json = json_decode($str, true);
            
            $holidays = [];

            for ($i = 0; $i < count($json); $i++) {
                
        
                array_push($holidays, [$json[$i]['name'][0]['text'],$json[0]['date']]);
                
            }
            
            return $holidays;

        }


        return $this->render('holidays/index.html.twig', array(
            'country' => getAllSuppCountrys(), 
            'region' => getRegions($request),
            'name' => getName($request),
            'yearRegion' => getYearAndRegion($request),
            'holidays' => getAllHolidays($request),
        
        ));
    }
}
