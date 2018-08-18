<?php

namespace Kato\CurrencyConverterBundle\Utils;

/**
 * CurrencyConverter converts currency amount from one to another
 * using public api to calculate by current currency rate
 * 
 * @author	Krzysztof frydrych<k1frydrych@gmail.com>
 * @copyright	2018 Krzysztof Frydrych, kfrydrych
 * @link	http://www.kfrydrych.pl
 * @version 	1.0 2011-12-18
 */

class CurrencyConverter
{
    const API_URL = 'https://free.currencyconverterapi.com/api/v6/convert';
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_PLN = 'PLN';
    
}
