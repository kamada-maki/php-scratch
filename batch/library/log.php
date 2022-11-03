<?

/**
 * ログを出力
 * @param string $fileName ログを出力するファイル名
 * @param string $message 出力するメッセージ
 * @return void
 */
function writeLog($filename, $message)
{
  $now = date("y/m/d h:i:s");
  $log = "{$now} {$message}\n";

  $fp = fopen($filename, "a");
  fwrite($fp, $log);
  fclose($fp);
}
