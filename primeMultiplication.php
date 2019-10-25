<?php

class Prime{

     /* @var <number> $length and height of multiplication table */
     private $length = 0;

     /* @var <array> $primes collection of N primes */
     private $primes = array();

     public function __construct() 
     {
        $opt = 10;
        if (!empty($_SERVER['argv']) && count($_SERVER['argv']) > 1) {
            $opt = $_SERVER['argv'][1];
        }
        if (is_numeric($opt)) {
           
            $this->process($opt);
           
        }
     }

    public function process($n){

       
         /* increment for display of primes */
         $this->length = $n;
         $this->primes = $this->get_primes($n);
         echo "\t";
         for($i = 0; $i < $this->length; $i++){
            echo $this->primes[$i]."\t";
         }
         echo "\n";
         $this->multiplyPrimes();
    }

    public function multiplyPrimes(){
        for($i = 0; $i < $this->length; $i++) {
            echo "\n".$this->primes[$i]."\t";
            for($j = 0; $j < $this->length; $j++) {
                echo $this->primes[$i] * $this->primes[$j] ."\t";
            }
        }
    }

    public function get_primes($n) 
    {
        if ($n == 0) {
            return 0;
        }
        $result = Array();
        $i = 2;
        do {
            if ($this->is_prime($i)) {
                $result[] = $i;
                $n--;
            }
            $i++;
        } while ($n > 0);
        return $result;
    }

    public function is_prime($number) 
    {
        /* cast to ensure we are working with numbers */
        $number = (int) $number;
        /* base cases - order matters - working with numbers greater than 3 */
        if ($number < 2) return false;
        if ($number === 2 || $number === 3) return true;
        if ($number % 2 === 0) return false;
        for ($i = 2; $i <= sqrt($number); $i++){ 
            if ($number % $i == 0) 
                return 0; 
        } 
        return 1; 
    }
}
new Prime();
?>