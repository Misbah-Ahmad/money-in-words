# money-in-words
This package converts Money or Number into Words according to Bangladeshi Convention


## Installation

use _**composer require misbah/money-in-words**_ to install
   
   
## Usage
### Convert a number & get the result as an array
#### The 0th index will contain the word representation of the integer part & the 1st index will contain the word representing the fraction part

```

<?php
  
  require './vendor/autoload.php';

  $converter = new \MoneyInwords\MoneyInWords();

  $number = 1.03;

  print_r($converter->numberToWords($number));
  echo "<br>";

  $number = 0.1;
  print_r($converter->numberToWords($number));
  echo "<br>";

  $number = 3125639562;
  var_dump($converter->numberToWords($number));

/* Outputs
Array ( [0] => one [1] => three ) 
Array ( [0] => twelve crore sixty five lac forty three thousand nine hundred and eighty one [1] => ten ) 
array(2) { [0]=> string(12) "ten thousand" [1]=> string(0) "" }
*/

```




### Convert a number into words as Bangladeshi Money 
#### This function will return a string containing the Words in Money

```

<?php
  
  require './vendor/autoload.php';

  $converter = new \MoneyInwords\MoneyInWords();

  $number = 1.03;
  print_r(ucwords($converter->moneyToWords($number)));
  echo "<br>";

  $number = 0.1;
  print_r(ucwords($converter->moneyToWords($number)));
  echo "<br>";

  $number = 3125639562;
  print_r(ucwords($converter->moneyToWords($number)));


/* Outputs
One Taka And Three Paisa
Zero Taka And Ten Paisa
Three Hundred And Twelve Crore Fifty Six Lac Thirty Nine Thousand Five Hundred And Sixty Two Taka
*/

```
