<?
  //Скрипт для проверки своих таймингов при решении пробников ЕГЭ  и сравнивания их с рекомендуемыми таймингами. Поддерживается работа с пробниками по математике (профильного уровня) и информатике.
  
  //Поддерживается как решение только задач первой части (1-23 задания), так и полное решение пробника (1-27).
  //Все данные отправляются на свой сервер и записываются в БД.
  
  $type = '';
  
  if(isset($_GET['type'])) {
    $type = $_GET['type'];
    if($type !== 'inf' && $type !== 'math') exit();
  }
  else exit();
  
  $need_part_2 = TRUE;
  
  if(isset($_GET['need_part_2'])) {
    $need_part = $_GET['need_part_2'];
    if(is_numeric($need_part)) {
      if(!$need_part) $need_part_2 = FALSE;
    }
    else exit();
  }
  
  $sess = time();
  
  $size   = 1;
  $part_2 = 1;
  $part_2_diff = 1;
  
  if     ($type === 'inf') {
    $size = 28;
    $part_2 = 23;
    $part_2_diff = 90.0;
  }
  else if($type === 'math') {
    $size = 20;
    $part_2 = 12;
    $part_2_diff = 55.0;
  }
  
  $query_create_inf_part2 = '';
  
  $query_2_inf_part2 = '';
  $query_3_inf_part2 = '';
  
  $query_create_math_part2 = '';
  
  $query_2_math_part2 = '';
  $query_3_math_part2 = '';
  
  if(!$need_part_2) $size = $part_2 + 1; 
  else {
    $query_create_inf_part2 = '
    `24` float NOT NULL,
    `25` float NOT NULL,
    `26` float NOT NULL,
    `27` float NOT NULL,';
    
    $query_2_inf_part2 = '`24`, `25`, `26`, `27`, ';
    $query_3_inf_part2 = '`24`, `25`, `26`, `27`, ';
    
    $query_create_math_part2 = ' 
  `13` float NOT NULL,
  `14` float NOT NULL,
  `15` float NOT NULL,
  `16` float NOT NULL,
  `17` float NOT NULL,
  `18` float NOT NULL,
  `19` float NOT NULL,';
    
    $query_2_math_part2 = '`13`, `14`, `15`, `16`, `17`, `18`, `19`, ';
    $query_3_math_part2 = '`13`, `14`, `15`, `16`, `17`, `18`, `19`, ';
  }
  
  $timing_eth_inf = [
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
  
  $query_create_inf = "CREATE TABLE `session_$sess` (
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
  $query_create_inf_part2
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

  $query_2_inf = "INSERT INTO `session_$sess` (`type`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, $query_2_inf_part2 `total`) VALUES ('raw_timing'";
  
  $query_3_inf = "INSERT INTO `session_$sess` (`type`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, $query_3_inf_part2 `total`) VALUES ('difference'";
  
  $timing_eth_math = [
  '1'  =>  2.0,
  '2'  =>  2.0,
  '3'  =>  2.0,
  '4'  =>  3.0,
  '5'  =>  3.0,
  '6'  =>  3.0,
  '7'  =>  5.0,
  '8'  =>  5.0,
  '9'  =>  5.0,
  '10' =>  5.0,
  '11' =>  10.0,
  '12' =>  10.0,
  '13' =>  10.0,
  '14' =>  20.0,
  '15' =>  15.0,
  '16' =>  25.0,
  '17' =>  35.0,
  '18' =>  35.0,
  '19' =>  40.0
  ];
  
  $query_create_math = "CREATE TABLE `session_$sess` (
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
  $query_create_math_part2
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

  $query_2_math = "INSERT INTO `session_$sess` (`type`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, $query_2_math_part2 `total`) VALUES ('raw_timing'";
  
  $query_3_math = "INSERT INTO `session_$sess` (`type`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, $query_3_math_part2 `total`) VALUES ('difference'";
  
  $query_create = '';
  $query_2 = '';
  $query_3 = '';
  
  $timing_eth = [];
  
  if     ($type === 'inf') {
    $query_create = $query_create_inf;
    $query_2      = $query_2_inf;
    $query_3      = $query_3_inf;
    $timing_eth   = $timing_eth_inf;
  }
  else if($type === 'math') {
    $query_create = $query_create_math;
    $query_2      = $query_2_math;
    $query_3      = $query_3_math;
    $timing_eth   = $timing_eth_math;
  }
  
  for($i = 1; $i < $size; $i++) {
    if(isset($_GET["$i"])) {
      $timing_i = $_GET["$i"];
      if(is_numeric($timing_i)) {
        $diff_i = round($timing_i - $timing_eth["$i"],  2);
        if($i > $part_2 && !$need_part_2) $diff_i = 0.0;
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
      if(!$need_part_2) $total_diff = $total - $part_2_diff;
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
  $mysqli->query("INSERT INTO `ege` (`ID_session`, `DBName`, `type`, `time`) VALUES (NULL, 'session_$sess', '$type', CURRENT_TIMESTAMP);");
  
  $mysqli->close();
?>