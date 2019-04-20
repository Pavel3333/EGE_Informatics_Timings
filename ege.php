<?
  //Скрипт для проверки  своих таймингов при решении пробников ЕГЭ по информатике и сравнивания их с рекомендуемыми таймингами
  
  //Поддерживается как решение только задач первой части (1-23 задания), так и полное решение пробника (1-27)
  
  //Автор - Павел Ушаев aka Pavel3333
  
  $timing_eth = [
  '1'  =>  1.0,
  '2'  =>  3.0,
  '3'  =>  3.0,
  '4'  =>  3.0,
  '5'  =>  2.0,
  '6'  =>  4.0,
  '7'  =>  3.0,
  '8'  =>  3.0,
  '9'  =>  5.0,
  '10' =>  4.0,
  '11' =>  5.0,
  '12' =>  2.0,
  '13' =>  3.0,
  '14' =>  6.0,
  '15' =>  3.0,
  '16' =>  2.0,
  '17' =>  2.0,
  '18' =>  3.0,
  '19' =>  5.0,
  '20' =>  5.0,
  '21' =>  6.0,
  '22' =>  7.0,
  '23' =>  10.0,
  '24' =>  30.0,
  '25' =>  30.0,
  '26' =>  30.0,
  '27' =>  55.0
  ];

  $sess = time();
  $query_create = "CREATE TABLE `session_$sess` (
  `type` varchar(10) NOT NULL,
  `1` float NOT NULL,
  `2` float NOT NULL,
  `3` float NOT NULL,
  `4` float NOT NULL,
  `5` float NOT NULL,
  `6` float NOT NULL,
  `7` float NOT NULL,
  `8` float NOT NULL,
  `9` float NOT NULL,
  `10` float NOT NULL,
  `11` float NOT NULL,
  `12` float NOT NULL,
  `13` float NOT NULL,
  `14` float NOT NULL,
  `15` float NOT NULL,
  `16` float NOT NULL,
  `17` float NOT NULL,
  `18` float NOT NULL,
  `19` float NOT NULL,
  `20` float NOT NULL,
  `21` float NOT NULL,
  `22` float NOT NULL,
  `23` float NOT NULL,
  `24` float NOT NULL,
  `25` float NOT NULL,
  `26` float NOT NULL,
  `27` float NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
  
  $query_2 = "INSERT INTO `session_$sess` (`type`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `total`) VALUES ('raw_timing'";
  $query_3 = "INSERT INTO `session_$sess` (`type`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `total`) VALUES ('difference'";
  
  $need_part_2 = TRUE;
  
  if(isset($_GET['need_part_2'])) {
    $need_part = $_GET['need_part_2'];
    if(is_numeric($need_part) && !$need_part) $need_part_2 = FALSE;
    else exit();
  }
  
  for($i = 1; $i < 28; $i++) {
    if(isset($_GET["$i"])) {
      $timing_i = $_GET["$i"];
      if(is_numeric($timing_i)) {
        $diff_i = round($timing_i - $timing_eth["$i"], 2);
        if($i > 23 && !$need_part_2) $diff_i = 0.0;
        $query_2 .= ", '$timing_i'";
        $query_3 .= ", '$diff_i'";
      }
      else exit();
    }
    else exit();
  }
  if(isset($_GET['total'])) {
    $total      = $_GET['total'];
    if(is_numeric($timing_i)) {
      $total_diff = $total - 235.0;
      if(!$need_part_2) $total_diff = $total - 90.0;
      $query_2 .= ", '$total'";
      $query_3 .= ", '$total_diff'";
    }
    else exit();
  }
  else exit();
  
  $query_2 .= ");";
  $query_3 .= ");";
  
  //Нужно вставить сюда название своей БД
  $mysqli = new mysqli("localhost", "ege_DB", "password", "ege_DB");
  
  $mysqli->query($query_create);
  $mysqli->query($query_2);
  $mysqli->query($query_3);
  $mysqli->query("ALTER TABLE `session_$sess` ADD PRIMARY KEY (`type`);");
  $mysqli->query("INSERT INTO `ege_inf` (`ID_session`, `DBName`, `time`) VALUES (NULL, 'session_$sess', CURRENT_TIMESTAMP);");
  
  $mysqli->close();
?>