<?php
function T_rndstr($length=false){//返回随机字符串 
	$str="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; 
	if(!$length){ 
		return str_shuffle($str); 
	}else{ 
		while(1){
			$rdstr = substr(str_shuffle($str),0,$length);
			if(preg_match("/^\d.*/",$rdstr) == 0)
				return $rdstr;
		}
	} 
} 
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
$mwww='./source'; 
//混淆后的文件存放位置
$mdir='./encode';
//不混淆的php文件
$notfile=array('pinyin.php','pinyin_table.php');
//版权信息
$copyinfo='
/**********************************************************/

/**********请勿修改本文件，否则可能导致程序无法运行*****************/

';
tree($mwww);

//文件长度
$length='00015243';

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
		$ofp=fopen($filename,'w');
		fclose($ofp);
		$temp_content=file_get_contents($filename);
		$temp_length=strlen($temp_content);
		$temp_length=str_pad($temp_length,8,'0',STR_PAD_LEFT);
		if($length === '00000000')
			$length='11111111';
		while($length !== $temp_length){
			$length=$temp_length;
			$T_k1=T_rndstr();//随机密匙1 
			$T_k2=T_rndstr();//随机密匙2 
			$vstr=file_get_contents($t);//要加密的文件  
			
			//$vstr = preg_replace('/\s(?=\s)/', '', $vstr);// 接着去掉两个空格以上的
			//$vstr=preg_replace("/\s+/", " ", $vstr); //过滤多余回车
			
			$v1=base64_encode($vstr); 
			$m_data=strtr($v1,$T_k1,$T_k2);//根据密匙替换对应字符。 
			$m_data=$T_k1.$T_k2.$m_data; 
			
			$base64_decode=T_rndstr(32); 
			$temp=T_rndstr(32); 
			$strtr=T_rndstr(32); 
			$substr=T_rndstr(32); 
			$num_62=T_rndstr(32); 
			$all=T_rndstr(32); 
			$file_path=T_rndstr(32);
			$file_get_contents=T_rndstr(32);
			$m_strtr=T_rndstr(32);
			$content=T_rndstr(32);
			$m_length=T_rndstr(32);
			
			$keystr=urldecode("%6E1%7A%62%2F%6D%615%5C%76%740%6928%2D%70%78%75%71%79%2A6%6C%72%6B%64%679%5F%65%68%63%73%77%6F4%2B%6637%6A"); 
			
			$ust='foreach($GLOBALS as $UN_GKEY => $UN_GNAME) if (is_string($UN_GNAME)) unset($GLOBALS[$UN_GKEY]);';
			/* 全字符串 
			n1zb/m
			a5\vt
			0i28-
			pxuqy
			*6lrk
			dg9_e
			hcswo
			4+f37j 
			base64_decode //$base64_decode 
			strtr //$temp 
			substr 
			*/ 
			
			$s='<?php'.$copyinfo.'$'.$all.'=urldecode("%6E%31%7A%62%2F%6D%61%35%5C%76%74%30%69%32%38%2D%70%78%75%71%79%2A%36%6C%72%6B%64%67%39%5F%65%68%63%73%77%6F%34%2B%66%33%37%6A");$'.$base64_decode.'=$'.$all.'{3}.$'.$all.'{6}.$'.$all.'{33}.$'.$all.'{30};$'.$strtr.'=$'.$all.'{33}.$'.$all.'{10}.$'.$all.'{24}.$'.$all.'{10}.$'.$all.'{24};$'.$substr.'=$'.$strtr.'{0}.$'.$all.'{18}.$'.$all.'{3}.$'.$strtr.'{0}.$'.$strtr.'{1}.$'.$all.'{24};$'.$num_62.'=$'.$all.'{22}.$'.$all.'{13};$'.$file_get_contents.'=$'.$all.'{38}.$'.$all.'{12}.$'.$all.'{23}.$'.$all.'{30}.$'.$all.'{29}.$'.$all.'{27}.$'.$all.'{30}.$'.$all.'{10}.$'.$all.'{29}.$'.$all.'{32}.$'.$all.'{35}.$'.$all.'{0}.$'.$all.'{10}.$'.$all.'{30}.$'.$all.'{0}.$'.$all.'{10}.$'.$all.'{33};$'.$file_path.'=__FILE__;$'.$base64_decode.'.=$'.$all.'{22}.$'.$all.'{36}.$'.$all.'{29}.$'.$all.'{26}.$'.$all.'{30}.$'.$all.'{32}.$'.$all.'{35}.$'.$all.'{26}.$'.$all.'{30};eval($'.$base64_decode.'("'.base64_encode('$'.$temp.'="'.$m_data.'";$'.$content.'=$'.$file_get_contents.'($'.$file_path.');$'.$m_length.'=\''.$length.'\';$'.$m_strtr.'=$'.$substr.'($'.$content.',$'.$m_length.'-9,1).$'.$substr.'($'.$content.',$'.$m_length.'-32,1).$'.$substr.'($'.$content.',$'.$m_length.'-18,1).$'.$substr.'($'.$content.',$'.$m_length.'-32,1).$'.$substr.'($'.$content.',$'.$m_length.'-18,1);eval(\'?>\'.$'.$base64_decode.'($'.$m_strtr.'($'.$substr.'($'.$temp.',$'.$num_62.'*2),$'.$substr.'($'.$temp.',$'.$num_62.',$'.$num_62.'),$'.$substr.'($'.$temp.',0,$'.$num_62.'))));').'"));'.$ust.'return(true);?>n1zb/ma5\vt0i28-pxuqy*6lrkdg9_ehcswo4+f37j';
			$ofp=fopen($filename,"w");
			fwrite($ofp,$s) or die('文件写入错误');
			fclose($ofp);
			$temp_content=file_get_contents($filename);
			$temp_length=strlen($temp_content);
			$temp_length=str_pad($temp_length,8,'0',STR_PAD_LEFT);
		}
		echo '完成'.$filename."\t 长度：".$temp_length.'<br>';
	}else{
		//复制非PHP文件
		if (fileext(basename($t))!='db'){
			copy($t,$filename);	
			echo '复制非PHP文件'.$filename.'<br>';
		}
	}
	//echo $s;
	
			//echo str_pad($as,8,'0',STR_PAD_LEFT);
}
