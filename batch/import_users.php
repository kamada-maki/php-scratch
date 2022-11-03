<?php
require("library/log.php");

$logFile = __DIR__ . "/log/import_users.log";
writeLog($logFile, "インポート処理開始");
$dataCount = 0;

try {
  //データベース接続
  $username = "root";
  $password = "root";
  $hostname = "db";
  $db = "users_db";
  $pdo = new PDO("mysql:host={$hostname};dbname={$db};charset=utf8;", $username, $password);

  //社員情報csvオープン
  $fp = fopen(__DIR__ . "/import_users.csv", "r");
  //トランザクション開始
  $pdo->beginTransaction();
  //ファイルを一行ずつ読み込み
  while ($data = fgetcsv($fp)) {
    $sql = "SELECT COUNT(*) count FROM users  where id = :id";
    $param = [":id" => $data[0]];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($param);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    //社員IDをキーに取り出し


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
    //SQLの実行結果が0件かどうかで分岐させる
    if ($result["count"] == 0) {
      $sql = "INSERT into users ( ";
      $sql .= " id, ";
      $sql .= " name, ";
      $sql .= " name_kana, ";
      $sql .= " birthday, ";
      $sql .= " gender, ";
      $sql .= " organization, ";
      $sql .= " post, ";
      $sql .= " start_date, ";
      $sql .= " tel, ";
      $sql .= " mail_address, ";
      $sql .= " created, ";
      $sql .= " updated ";
      $sql .= ") VALUES ( ";
      $sql .= " :id, ";
      $sql .= " :name, ";
      $sql .= " :name_kana, ";
      $sql .= " :birthday, ";
      $sql .= " :gender, ";
      $sql .= " :organization, ";
      $sql .= " :post, ";
      $sql .= " :start_date, ";
      $sql .= " :tel, ";
      $sql .= " :mail_address, ";
      $sql .= " NOW(), ";
      $sql .= " NOW() ";
      $sql .= ")";
    } else {
      //更新のSQL
      $sql = "UPDATE users ";
      $sql .= "SET name = :name,";
      $sql .= " name_kana = :name_kana, ";
      $sql .= " birthday = :birthday, ";
      $sql .= " gender = :gender, ";
      $sql .= " organization = :organization, ";
      $sql .= " post = :post, ";
      $sql .= " start_date = :start_date, ";
      $sql .= " tel = :tel, ";
      $sql .= " mail_address = :mail_address, ";
      $sql .= " updated = NOW() ";
      $sql .= " where id = :id ";
    }
    $params = array(
      "id" => $data[0],
      "name" => $data[1],
      "name_kana" => $data[2],
      "birthday" => $data[3],
      "gender" => $data[4],
      "organization" => $data[5],
      "post" => $data[6],
      "start_date" => $data[7],
      "tel" => $data[8],
      "mail_address" => $data[9],
    );
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $dataCount++;
  }
  //コミット
  $pdo->commit();
  //csvファイルクローズ
  fclose($fp);
} catch (Exception $e) {
  $pdo->rollBack();
  $dataCount = 0;
  writeLog($logFile, "エラー発生" . $e->getMessage());
}
writeLog($logFile, "インポート処理終了 処理件数：{$dataCount}件");
