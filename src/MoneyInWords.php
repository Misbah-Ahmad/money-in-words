<?php 

namespace MoneyInWords;
class MoneyInWords{

	private $digitMap;
	private $nameMap;

	public function __construct()
	{
		
		$this->digitMap = [
			0 => "zero",
			1=>"one",
			2 => "two",
			3 => "three",
			4 => "four",
			5 => "five",
			6 => "six",
			7 => "seven",
			8 => "eight",
			9 => "nine",
			10 => "ten",
			11 => "eleven",
			12 => "twelve",
			13 => "thirteen",
			14 => "fourteen",
			15 => "fifteen",
			16 => "sixteen",
			17 => "seventeen",
			18 => "eighteen",
			19 => "nineteen",
			20 => "twenty",
			30 => "thirty",
			40 => "forty",
			50 => "fifty",
			60 => "sixty",
			70 => "seventy",
			80 => "eighty",
			90 => "ninety"
		];


		$this->nameMap = [
			0 => "",
			1 => "hundred",
			2 => "thousand",
			3 => "lac"
		];



	}


	public function moneyToWords($number)
	{
		$words = $this->numberToWords($number);

		if(sizeof($words) > 1 && $words[1] != 'zero' && strlen($words[1]) > 0)
		{
			$words[0] = str_replace(' and', '', $words[0]);

			if($words[0] == 'zero' || strlen($words[0]) < 1)
			{
				return $words[1]. ' paisa';				
			}

			return $words[0] .' taka and '. $words[1]. ' paisa'; 
		}

		return $words[0] .' taka';

	}



	public function numberToWords($number)
	{

		$number = abs($number);

		$numStr = strval($number);

		$integerPart = intval($number);
		$integerStr = strval($integerPart);

		$decimalPart = false;

		if(gettype($number) != "integer" && preg_match("/\./", $numStr))
		{
			$decimalPart = substr(preg_replace('/.*\./', '', $numStr), 0, 2);
			$decimalPartInt = intval($decimalPart);

			if(strlen($decimalPart) == 1 && $decimalPart[0] != '0')
			{
				$decimalPart = $decimalPart[0] . '0';
			}

		}


		
		$len = strlen($integerStr);
		$integerStr = strrev($integerStr);

		$part = substr($integerStr, 0, 7);
		$partLen = strlen($part);

		$level = $this->calculateLevel($partLen);

		$odd = ($partLen == 4 || $partLen == 6);

		$inWords = $this->solve(strrev($part), $level, 0, $odd);

		if($len > 7)
		{
			$part = substr($integerStr, 7, 7);
			$partLen = strlen($part);
			$level = $this->calculateLevel($partLen);
			$odd = ($partLen == 4 || $partLen == 6);

			$temp = $this->solve(strrev($part), $level, 0, $odd);
			$temp = str_replace(' and', '', $temp);			
			$inWords = $temp .' crore '. $inWords;
		}


		if($len > 14)
		{
			$part = substr($integerStr, 14);
			$partLen = strlen($part);
			$level = $this->calculateLevel($partLen);
			$odd = ($partLen == 4 || $partLen == 6);

			$temp = $this->solve(strrev($part), $level, 0, $odd);

			$temp = str_replace(' and', '', $temp);

			$inWords = $temp .' crore '. $inWords;
		}

		
		$inWords = trim($inWords);

		if($integerPart == 0) $inWords = 'zero';


		if($decimalPart != false && intval($decimalPart) > 0)
		{
			$decimalPart = $this->evaluateNumber($decimalPart);


			return [

				$inWords,
				trim($decimalPart)
			];
		}


		return [
			$inWords,
			''
		];

	}




	private function solve($sevenDigit, $level, $index, $odd) // $odd == true if strlen($sevendigit) == 5 || 6
	{

		$str = substr($sevenDigit, $index, 2);
		$increment = 2; 

		if($level == 1 || $odd)
		{
			$str = substr($sevenDigit, $index, 1);
			$increment = 1;
			$odd = false;
		}

		$eval = $this->evaluateNumber($str);
		
		if($level > 0)
		{
			if(intval($str) > 0) 
			{
				$eval .= ' '. $this->nameMap[$level] . ' ';
			}


			return $eval . $this->solve($sevenDigit, $level-1, $index + $increment, $odd);

		}

		if(intval($str) > 0 && strlen($sevenDigit) > 2) return 'and '.$eval;
		else return ' '.$eval;



	}




	private function evaluateNumber($numStr)
	{


		$integer = intval($numStr);

		if($integer == 0) return '';

		if(array_key_exists($integer, $this->digitMap))
		{
			return $this->digitMap[$integer];
		}

		$multi = intval(($integer/10)) * 10;


		$rest = $integer - $multi;


		return $this->digitMap[$multi].' '.$this->digitMap[$rest];

	}

	private function calculateLevel($len)
	{
		if($len <= 2) return 0;
		else if($len <= 3) return 1;
		else if($len <= 5) return 2;
		else if($len <= 7) return 3;
	}


}

