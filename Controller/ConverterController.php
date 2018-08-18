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
        return $this->render('@KatoCurrencyConverter/converter/index.html.twig');
    }
    
    /**
     * @Route("/converter/ajax", name="converter_ajax")
     */
    public function ajax(Request $request)
    {

        if ($request->isXmlHttpRequest()) {  
                        
            $amount = floatval($request->request->get('amount'));
            $currencyConverter = new CurrencyConverter();          
            $convertedValue = $currencyConverter->convert(CurrencyConverter::CURRENCY_RUB, CurrencyConverter::CURRENCY_PLN, $amount);

            $jsonData = ['value' => $convertedValue];

            return new JsonResponse($jsonData); 
        } else { 
            return $this->render('homepage/ajax.html.twig'); 
        }

    }
       
    
}
