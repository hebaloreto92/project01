<?php

  $obj = new main();
  $text = "my text";
  $cars = array("Volvo", "BMW", "Toyota");
  $obj->printthis($cars);
  
  $array = array(1,2,3,4,5,6,7);
  $obj->printArray($array);

  class main {

    public function __construct() {

      echo 'String and Array Function</br>';

    }

    public function printthis($car) {
      echo '<h1>indexed array</h1>';
            $cars = array("Volvo", "BMW", "Toyota");
      echo "I like " . $cars[0] . ", " . $cars[1] . " and " . $cars[2] . ".";
      echo '<hr>'
    }

    public function printArray($array) {
      echo '<h1>array print function</h1>';
      print_r($array);
      echo '<hr>';
    }
    
    public function __destruct() {

      echo '</br> I\'m Done';

    }


  }



?>