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
    
    /*
     * @var string $currencyFrom
     */
    private $currencyFrom;
    
    /*
     * @var string $currencyTo
     */
    
    private $currencyTo;
    
    /*
     * $var float $amount
     */
    private $amount;
    
    /*
     * $var float $rate
     */
    private $rate;
    
    /*
     * $var float $conversionValue
     */
    private $convertedValue;
         
    /*
     * Convert currency from to
     * 
     * @param string $currencyFrom
     * @param string $currencyTo
     * @param float $amount
     * @param float|null $rate
     * @return float|null $convertedValue
     */
    public function convert($currencyFrom = self::CURRENCY_RUB, $currencyTo = self::CURRENCY_PLN, float $amount, $rate = NULL)
    {
         
        $this->currencyFrom = $currencyFrom;
        $this->currencyTo = $currencyTo;
        $this->amount = $amount;        
        $this->rate = $this->getRate();        
        $this->convertedValue = round($this->rate * $this->amount, 2);
        
        return $this->convertedValue;
    }
    
    /*
     * Return current currency rate
     * using public api
     */
    public function getRate($currencyFrom = null, $currencyTo = null)
    {
        $currencyFrom = $currencyFrom ?? $this->currencyFrom;
        $currencyTo = $currencyTo ?? $this->currencyTo;        
        
        $apiUrl = CurrencyConverter::API_URL . '?q=' . $currencyFrom . '_' . $currencyTo . '&compact=y';
     
        try {
            
            if (empty($this->amount)) {
                throw new \Exception('Wrong Rub currency amount type value!');
            }  
            
            if (!in_array($currencyFrom, self::getCurrencies())) {
                throw new \Exception('Wrong currencyFrom value!');
            }
            
            if (!in_array($currencyTo, self::getCurrencies())) {
                throw new \Exception('Wrong currencyTo value!');
            }
            
            if ($currencyFrom == $currencyTo) {
                throw new \Exception('Currencies must be diffrent!');
            }            
            
            $apiResult = json_decode(file_get_contents($apiUrl), true);
            
            if (empty($apiResult) || !isset($apiResult[$currencyFrom . '_' . $currencyTo]['val'])) {
                throw new \Exception('Api didn`t return rate value. Used url: ' . $apiUrl);
            }
            
        } catch(\Exception $exception) {
            echo 'Exception: ' . $exception->getMessage() . '<br/>';
        }

        $rate = $apiResult[$currencyFrom . '_' . $currencyTo]['val'] ?? 0;

        return $rate;        
    }
    
    public function setCurrencyFrom($currencyFrom)
    {
        $this->currencyFrom = $currencyFrom;
    }
    
    public function getCurrencyFrom()
    {
        return $this->currencyFrom;
    }
    
    public function setCurrencyTo($currencyTo)
    {
        $this->currencyTo = $currencyTo;
    }
    
    public function getCurrencyTo()
    {
        $this->currencyTo;
    }
    
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    
    public function getAmount()
    {
        return $this->amount;
    }
    
    public static function getCurrencies() 
    {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();

        $currencies = array();

        foreach ($constants as $constant => $value) {
            $pos = strpos($constant, 'CURRENCY');

            if ($pos !== false) {
                $currencies[$value] = $value;
            }
        }
    
        return $currencies;
    }

}
