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
    public function getter(Request $request)
    {


        // dd($request);
        $num = 1;
        $year = 2022;
        // $country = 'pl';

        $getMonth = $request->query->get('month');
        $getCountry = $request->query->get('country');

        // if ($getMonth === 0) {
        //     $num = 1; 
        // } else {
        //     $num = $getMonth;
        // }


        // $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getHolidaysForMonth&month=' . $num . '&year=' . $year . '&country=' . $country . '&region=bw&holidayType=public_holiday');
        $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getHolidaysForYear&year=2022&country=lt&holidayType=public_holiday');
        $json = json_decode($str, true);
        // $n = $json[0]['name'][1]['text'];

        // echo $json;
        // print implode(", ", $json);

        // echo $n;
        $holidays = [];
        for ($i = 0; $i < count($json); $i++) {
            
            if ($getCountry == '') {
                $holidays = ['...'];
                $getCountry = 'Is empty';
                break;
            } else {
                array_push($holidays, $json[$i]['name'][1]['text']);
            }
        }

        




        function getAllSuppCountrys()
        {
            $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getSupportedCountries');
            $json = json_decode($str, true);

            $countrys = [];
            for ($i = 0; $i < count($json); $i++) {
                // array_push($countrys, $json[$i]['countryCode']);
                array_push($countrys, [$json[$i]['countryCode'],$json[$i]['fullName']]);
            }
            return $countrys;
        }
        

        function getAllHolidays(Request $request) {
            $getCountry = $request->query->get('country');
            $str = file_get_contents('https://kayaposoft.com/enrico/json/v2.0?action=getHolidaysForYear&year=2022&country='. $getCountry .'&holidayType=public_holiday');
            $json = json_decode($str, true);
           
            
            $holidays = [];
            for ($i = 0; $i < count($json); $i++) {
                
                if ($getCountry == '') {
                    $holidays = ['...'];
                    $getCountry = 'Is empty';
                    break;
                } else {
                    array_push($holidays, $json[$i]['name'][1]['text']);
                }
            }

            return $holidays;
        }
    




        return $this->render('holidays/index.html.twig', array('allCountrys' => getAllSuppCountrys(), 'num' => getAllHolidays($request), 'country' => $getCountry));
    }
}
