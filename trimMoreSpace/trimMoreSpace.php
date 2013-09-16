<?php
//去除多余的空格
function trimMoreSpace($string){
	$string = trim($string);// 首先去掉头尾空格 
	$string = preg_replace('/\s(?=\s)/', '', $string);// 接着去掉两个空格以上的 
	$string = preg_replace('/[\n\r\t]/', ' ', $string);// 最后将非空格替换为一个空格 
	return $string;
}
