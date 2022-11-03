<?php
//csvファイルオープン
$fp = fopen(__DIR__ . "/input.csv", "r");
$lineCOunt = 0;
$manCount = 0;
$womanCount = 0;
//ファイルを1行ずつ読み込む
while ($data = fgetcsv($fp)) {
  $fileCount++;
  //１行目かどうか
  if ($fileCount === 1) {
    continue;
  }
  if ($data[4] === "男性") {
    $manCount++;
  } else {
    $womanCount++;
  }
}
fclose($fp);
//出力ファイルをopen
$fpOut = fopen(__DIR__ . "/output.csv", "w");
//ヘッダーcsvの書き込み
$header = ["男性", "女性"];
fputcsv($fpOut, $header);
//男性、女性の人数の書き込み
$outputData = [$manCount, $womanCount];
fputcsv($fpOut, $outputData);
//出力ファイルをclose
fclose($fpOut);
