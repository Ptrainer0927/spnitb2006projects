<?php

require_once('mysql_connect.php');
$pdo = connectDB();

$right_ans_num = (integer)$_POST["right_ans_num"];

(integer)$rank = 0; #ランキングデータを保持
const DATA_LIMIT = 1000; #登録データ数の上限
try{
  $table_name = "ranking_table_" . $_POST["selected_kyuu"];

  #テスト
  #echo $table_name;
  #echo "SELECT COUNT(*) FROM `$table_name` WHERE `right_ans_num`>$right_ans_num";

  #正解数が$right_ans_numよりも多いデータ数をとる
  $ranking_count_stmt = $pdo->query("SELECT COUNT(*) FROM `$table_name` WHERE `right_ans_num`>$right_ans_num");

  #テスト用
  #echo("$rankingの表示:");
  #echo var_dump($ranking);
  #echo var_dump($ranking_count_stmt);

  foreach($ranking_count_stmt as $ranking_count){
    $rank = (integer)$ranking_count['COUNT(*)'] + 1; #順位
    if($rank <= DATA_LIMIT){
      #ranking_tableへ新たな正解数を記録
      $pdo->query("INSERT INTO `$table_name` (`right_ans_num`) VALUES ($right_ans_num)");

      #データ数が上限数を超えているかチェック
      $row_num_stm = $pdo->query("SELECT COUNT(*) FROM `$table_name`");

      #テスト用
      #echo("$row_numの表示:");
      #echo var_dump($row_num);

      foreach($row_num_stm as $row_num){
        if($row_num['COUNT(*)'] > DATA_LIMIT){
          #最も正解数の低いデータを削除
          $pdo->query("DELETE FROM `$table_name` ORDER BY `right_ans_num` ASC LIMIT 1");
        }
      }
    }
  }

}catch(PDOException $e){
  //var_dump($e->getMessage()); //不正にアクセスされた場合、余計な情報を表示しないように消す
}
$pdo = null;

echo $rank;

 ?>
