<?php

//データベース接続
$username = "root";
$password = "root";
$hostname = "db";
$db = "users_db";
$pdo = new PDO("mysql:host={$hostname};dbname={$db};charset=utf8;", $username, $password);

//SQLの実行
$sql = "SELECT *  FROM users ORDER BY ID";
$stmt = $pdo->prepare($sql);
$stmt->execute();

//出力結果を1行ずつ読み込み、最終行まで繰り返す
$outputData = [];
$dataCount = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  //出力データの作成
  $outputData[$dataCount]["id"] = $row["id"];
  $outputData[$dataCount]["name"] = $row["name"];
  $outputData[$dataCount]["name_kana"] = $row["name_kana"];
  $outputData[$dataCount]["birthday"] = $row["birthday"];
  $outputData[$dataCount]["gender"] = $row["gender"];
  $outputData[$dataCount]["organization"] = $row["organization"];
  $outputData[$dataCount]["post"] = $row["post"];
  $outputData[$dataCount]["start_date"] = $row["start_date"];
  $outputData[$dataCount]["tel"] = $row["tel"];
  $outputData[$dataCount]["mail_address"] = $row["mail_address"];
  $outputData[$dataCount]["created"] = $row["created"];
  $outputData[$dataCount]["updated"] = $row["updated"];
  $dataCount++;
}

// 出力ファイルオープン
$fpOutput = fopen(__DIR__ . "/export_users.csv", "w");

// ヘッダー行読み込み
$header = [
  "社員ID", "社員名", "社員名かな", "誕生日", "性別", "所属", "役職", "入社年月日", "電話番号", "メールアドレス", "作成日時", "更新日時"
];
fputcsv($fpOutput, $header);
// 出力データ行分　繰り返し
foreach ($outputData as $data) {
  // 出力データ書き込み
  fputcsv($fpOutput, $data);
}
fclose($fpOutput);
