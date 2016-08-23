<?php

if(!isset($_GET['map']) || empty($_GET['map'])){
    echo "不符合，因為無參數，或參數為空";
    exit;
}

#檢查長度
$len = strlen($_GET['map']);
if($len != 109){
    echo "不符合，總字數為$len";
    exit;
}

#格式檢查
if(!preg_match('/^[0-8MN]{109}$/',$_GET['map'])){
    echo '不符合，格式有誤';
    exit;
}

#檢查m小寫
$m = substr_count($_GET['map'], "m");
if($m > 0){
    echo "不符合，請用大寫M";
    exit;
}

#檢查炸彈數量
$M = substr_count($_GET['map'], "M");
if($M != 40){
    echo "不符合，炸彈數量為$M";
    exit;
}

#檢查n小寫
$n = substr_count($_GET['map'], "n");
if($n > 0){
    echo "不符合，請用大寫N";
    exit;
}

#檢查N數量
$N = substr_count($_GET['map'], "N");
if($N != 9){
    echo "不符合，N數為$N";
    exit;
}


$strmap = $_GET['map'];
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
        echo "不符合，N位置有誤";
        exit;
    }
}

$str_result = "";
foreach ($GET_map as $key_1 => $val_1) {
    foreach($val_1 as $key_2 => $val_2){
        if($GET_map[$key_1][$key_2] != 'M'){
            $ANS = Score($GET_map,$key_1,$key_2);
            if($GET_map[$key_1][$key_2] != $ANS){
                $str_result .=  '('.$key_1.','.$key_2.')';
                // $str_result .=  '('.$key_1.','.$key_2.')應為='.$ANS.'<br>';
            }
        }
    }
}

if(!empty($str_result)){
    echo '不符合，數字有誤座標 : '.$str_result;
    exit;
}

echo '符合';
exit;

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