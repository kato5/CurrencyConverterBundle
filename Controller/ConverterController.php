<?php

namespace Kato\CurrencyConverterBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Kato\CurrencyConverterBundle\Utils\CurrencyConverter;


class ConverterController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('homepage/index.html.twig');
    }
    
    /**
     * @Route("/converter/ajax", name="converter_ajax")
     */
    public function ajax(Request $request, CurrencyConverter $currencyConverter)
    {

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            
            $amount = floatval($request->request->get('amount'));
                      
//            $convertedValue = $currencyConverter->convert('asdad', CurrencyConverter::CURRENCY_PLN, $request->request->get('amount', 1));
            $convertedValue = $currencyConverter->convert(CurrencyConverter::CURRENCY_RUB, CurrencyConverter::CURRENCY_PLN, $amount);

            $jsonData = ['value' => $convertedValue];

           return new JsonResponse($jsonData); 
        } else { 
           return $this->render('homepage/ajax.html.twig'); 
        } 

    }
    
    /**
     * @Route("/test", name="test")
     */
    public function test()
    {
        echo 'TEST';
        return $this->render('homepage/index.html.twig');
    }    
    
}
