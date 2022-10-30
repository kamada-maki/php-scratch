<?php
//入力値を受け取る
$value = $argv[1];

//入力値が3と5で割り切れる
if ($value % 3 === 0 && $value % 5 === 0) {
  //FizzBuzzと出力
  echo "FizzBuzz\n";
  //入力値が3で割り切れる
} elseif ($value % 3 === 0) {
  //Fizzと出力
  echo "Fizz\n";
  //入力値が5で割り切れる
} elseif ($value % 5 === 0) {
  //Buzzと出力
  echo "Buzz\n";
} else {
  //入力値を出力
  echo "$value\n";
}
