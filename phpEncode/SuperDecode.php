<?php

//文件数组
$filearray=array();
//遍历文件
function tree($directory) {
	global $filearray;
	$mydir=dir($directory); 
	while($file=$mydir->read()){ 
	    if((is_dir("$directory/$file")) AND ($file!=".") AND ($file!="..")) 
		{
			tree("$directory/$file"); 
		}else if (($file!=".") AND ($file!="..")){
			$filearray[]=$directory.'/'.$file;
		}
	} 
	$mydir->close(); 
} 
//取得文件后缀
 function fileext($filename) { 
     return trim(substr(strrchr($filename, '.'), 1, 10)); 
 } 
//创建文件夹
function createFolder($path)
{
   if (!file_exists($path)){
    createFolder(dirname($path));
    mkdir($path, 0777);
   }
}

//要混淆的文件位置
$mwww='./encode'; 
//混淆后的文件存放位置
$mdir='./decode';
//不混淆的php文件
$notfile=array('','');

tree($mwww);

foreach($filearray as $t){
	$mfiledata='';
	$filedir=str_replace(basename($t), "", $t);
	$filedir=str_replace($mwww, $mdir, $filedir);
	//创建文件夹
	createFolder($filedir);
	$filename=str_replace($mwww, $mdir, $t);
	$nowfilename = basename($filename); 
	//如果是php文件并不在//不混淆的php文件数组中
	if (fileext(basename($t))=='php'&&!in_array($nowfilename,$notfile)){
		$c = file_get_contents($t);
		$r='';
		preg_match_all('/(?<=\(").*(?<="\)\);)/',$c,$r);
		if(!empty($r[0][0])){
			preg_match_all('/(?<=\(").*(?="\)\);)/',$r[0][0],$r);
			if(!empty($r[0][0])){
				$r=$r[0][0];
				$r = base64_decode($r);
				preg_match_all('/(?<=\=").*(?=";)/',$r,$r);
				$r=$r[0][0];
				$r = base64_decode(strtr(substr($r,124),substr($r,62,62),substr($r,0,62)));
				$ofp=fopen($filename,"w");
				fwrite($ofp,$r);// or echo('文件写入错误');
				fclose($ofp);
				echo "完成文件".$filename.'<br>\n';
			}else{
				if (fileext(basename($t))!='db'){
					copy($t,$filename);	
					echo '<span style="color:red">跳过文件'.$filename."</span><br>";
				}
			}
		}else{
			if (fileext(basename($t))!='db'){
				copy($t,$filename);	
				echo '<span style="color:red">跳过文件'.$filename."</span><br>";
			}
		}
	}
}