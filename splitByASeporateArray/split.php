<?php
$str = 'basd,dfas;dasdfa;sdfasdfasdf,dfs.adfa,dfa;dafsdf.asdfa;asdfa';
$arr = array(',' , ';' , '.');
echo $str."\n";

function my_exp($arr,$str){
  $a[0] = $str;
  foreach($arr as $k => $v){
    $ttt = array();
    foreach($a as $kk => $vv){
      $b = explode($v,$vv);
      $ttt = array_merge($ttt , $b);
    }
    $a = $ttt;
  }
  return $a;
}
var_dump(my_exp($arr,$str));
