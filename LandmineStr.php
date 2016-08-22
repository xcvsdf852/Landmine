<?php
for ($x = 0; $x <= 9; $x++) {
    for ($y = 0; $y <= 9; $y++) {
        $map[$x][$y] = 0;
    }
}
#跑亂數
$Rand = Array();
for ($i=1; $i<=40; $i++){

    $randvalX=rand(0,9);
    $randvalY=rand(0,9);
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