<?php
$Time1 = microtime(true);
for ($x = 0; $x <= 49; $x++) {
    for ($y = 0; $y <= 59; $y++) {
        $map[$x][$y] = 0;
    }
}
#跑亂數
$Rand = Array();
for ($i=1; $i<=1200; $i++){

    $randvalX=rand(0,49);
    $randvalY=rand(0,59);
    $randval = $randvalX.','.$randvalY;
     if (in_array($randval, $Rand)) { //如果已產生過迴圈重跑
        $i--;
    }else{
        $Rand[] = $randvalX.','.$randvalY; //若無重復則 將亂數塞入陣列
    }
}
#將不重複的亂數放入
foreach($Rand as $v){
    $temp = explode(",",$v);
    $map[$temp[0]][$temp[1]] = "M";
}
#計算炸彈數量
foreach ($map as $key_1 => $val_1) {
    foreach($val_1 as $key_2 => $val_2){
        if($map[$key_1][$key_2] == '0'){
            $map[$key_1][$key_2] = Score($map,$key_1,$key_2);
        }
    }
}


$echostr = '';
foreach ($map as  $val_1){
    foreach($val_1 as $key_2 => $val_1){
        $echostr .= $val_1;
    }
    $echostr .= 'N';
}


echo substr($echostr,0,-1);
$Time2 = microtime(true);
echo "<hr>";
echo $Time2 - $Time1;
echo "<hr>";

echo '<table>';
foreach($map as $v1){
    echo '<tr>';
    foreach($v1 as $v2){
        echo '<td>'.$v2.'<td>';
    }
    echo '<tr>';
}
echo '</table>';

echo '<hr>';


function Score($origin,$x,$y){
    $temp = 0;

    if($origin[$x-1][$y-1]==="M"){#左上
        $temp += 1;
    }
    if($origin[$x-1][$y]==="M"){#上
        $temp += 1;
    }
    if($origin[$x-1][$y+1]==="M"){#右上
        $temp += 1;
    }
    if($origin[$x][$y+1]==="M"){#右
        $temp += 1;
    }
    if($origin[$x][$y-1]==="M"){#左
         $temp += 1;
    }
    if($origin[$x+1][$y+1]==="M"){#右下
        $temp += 1;
    }
    if($origin[$x+1][$y]==="M"){#下
        $temp += 1;
    }
    if($origin[$x+1][$y-1]==="M"){#左下
        $temp += 1;
    }

    return  $temp;
}