<?php
$a = array(5,3,6,4,2);
var_dump($a);
function select_sort($arr){
    $count = count($arr);
    for($i=0; $i<$count; $i++){
        for($j=$i+1; $j<$count; $j++){
            if ($arr[$i] > $arr[$j]){
                $tmp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $tmp;
            }
        }
    }
    return $arr;
}
function maopao_fun($array){
    $count = count($array);
    for($i=0;$i<$count;$i++){
        for($j=$count-1;$j>$i;$j--){
            if($array[$j] > $array[$j-1]){
                $tmp = $array[$j];
                $array[$j] = $array[$j-1];
                $array[$j-1] = $tmp;
            }
        }
    }
    return $array;
}
function quickSort($arr){
    $len = count($arr);
    if($len <= 1) {
        return $arr;
    }
    $key = $arr[0];
    $left_arr    = array();
    $right_arr    = array();

    for($i=1; $i<$len; $i++){
        if($arr[$i] <= $key){
            $left_arr[] = $arr[$i];
        } else {
            $right_arr[] = $arr[$i];
        }
    }

    $left_arr    = quickSort($left_arr);
    $right_arr    = quickSort($right_arr);
    return array_merge($left_arr, array($key), $right_arr);
}
function insert_sort($arr){
    $count = count($arr);
    for($i=1; $i<$count; $i++){
        $tmp = $arr[$i];
        $j = $i - 1;
        while($arr[$j] > $tmp){
            $arr[$j+1] = $arr[$j];
            $arr[$j] = $tmp;
            if($j<=0)break;
            $j--;
        }
    }
    return $arr;
}
var_dump(insert_sort($a));