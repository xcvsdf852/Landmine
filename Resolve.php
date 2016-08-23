<?php
$str_result = "";
if(!isset($_GET['map']) || empty($_GET['map'])){
    $str_result .= " 因為無參數，或參數為空";
}

$strmap = substr($_SERVER['QUERY_STRING'],4);


#檢查m小寫
$m = substr_count($strmap, "m");
if($m > 0){
    $str_result .= " 地雷大小寫有錯，請用大寫M";
}

#檢查炸彈數量
$M = substr_count($strmap, "M");

$Mm = $M + $m;
if($Mm  != 40){
    $str_result .= " 地雷數量有錯，只有$Mm 顆地雷";
}

#檢查n小寫
$n = substr_count($strmap, "n");
if($n > 0){
    $str_result .= " 請用大寫N";
}

#檢查N數量
$N = substr_count($strmap, "N");
if($N != 9){
    $str_result .= " 斷行次數錯誤，N數為$N";
    #判斷最後一個是否有N
    if(substr($strmap, -1) == "N"){
        echo '不符合，斷行次數錯誤，最後一個有N';
        exit;
    }
}

// if(!empty($str_result)){
//     echo '不符合，原因 : '.$str_result;
//     exit;
// }
#檢查長度
// $len = strlen($strmap);
// if($len != 109){
//     $str_result .= " 總字數為$len";
// }

#格式檢查
if(!preg_match('/^[0-8MNmn]{1,}$/',$strmap)){
    $str_result .= ' 出現格式意外的字元';
}

// $strmap = $_GET['map'];
#根據N切割成10個陣列
$arr_map = explode('N',$strmap);

#十個陣列再切割成二維陣列
$GET_map = array();
foreach($arr_map as $k => $v){
   $GET_map[] =  str_split($v); #使用者輸入，轉成二維陣列
}

#根據陣列大小，判斷N位置是否有誤
for($i=0; $i<=9; $i++){
    if(count($GET_map[$i]) != 10){
        $str_result .=  "不符合，N位置有誤";
    }
}

#判斷第一維是否切割成10個
if(count($arr_map) != 10){
    echo '不符合，輸入地圖大小是'.count($GET_map['0']).'*'.count($arr_map).'應該為10 * 10';
    exit;
}


foreach ($GET_map as $key_1 => $val_1) {
    foreach($val_1 as $key_2 => $val_2){
        if($GET_map[$key_1][$key_2] != 'M' && $GET_map[$key_1][$key_2] != 'm'){
            $ANS = Score($GET_map,$key_1,$key_2);
            if($GET_map[$key_1][$key_2] != $ANS){
                // $str_result .=  '('.$key_1.','.$key_2.')';
                $str_result .=  '('.$key_1.','.$key_2.')數值為'.$GET_map[$key_1][$key_2].'，正確應為'.$ANS.'。';
            }
        }
    }
}

if(!empty($str_result)){
    echo '不符合，原因 : '.$str_result;
    exit;
}

echo '符合';
exit;

function Score($origin,$x,$y){
    $temp = 0;

    if($origin[$x-1][$y-1]==="M" || $origin[$x-1][$y-1]==="m"){#左上
        $temp += 1;
    }
    if($origin[$x-1][$y]==="M" || $origin[$x-1][$y]==="m"){#上
        $temp += 1;
    }
    if($origin[$x-1][$y+1]==="M" || $origin[$x-1][$y+1]==="m"){#右上
        $temp += 1;
    }
    if($origin[$x][$y+1]==="M" || $origin[$x][$y+1]==="m"){#右
        $temp += 1;
    }
    if($origin[$x][$y-1]==="M" || $origin[$x][$y-1]==="m"){#左
         $temp += 1;
    }
    if($origin[$x+1][$y+1]==="M" || $origin[$x+1][$y+1]==="m"){#右下
        $temp += 1;
    }
    if($origin[$x+1][$y]==="M" || $origin[$x+1][$y]==="m"){#下
        $temp += 1;
    }
    if($origin[$x+1][$y-1]==="M" || $origin[$x+1][$y-1]==="m"){#左下
        $temp += 1;
    }

    return  $temp;
}