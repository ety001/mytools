<?php
$name       = 'Bu';

$php_tpl    = file_get_contents('php.tpl.php');
$php_c      = file_get_contents('php_c.tpl.php');
$php_d      = file_get_contents('php_d.tpl.php');

$path       = 'xml/';
$filename   = $path.'Data.Dao.'.$name.'.dcm.xml';

$xml_data   = file_get_contents($filename);

$data   = json_decode(json_encode( simplexml_load_string($xml_data, null, LIBXML_NOCDATA) ), true);

$class_namespace = $data['entity']['@attributes']['name'];
$table_name         = $data['entity']['@attributes']['table'];
$tmp = array();
$table_name_arr = explode('_', $table_name);
foreach ($table_name_arr as $k => $v) {
    array_push($tmp, ucfirst($v));
}
$class_name = implode('', $tmp);

$field_arr = $data['entity']['field'];
$field_str  = '';
$func_str = '';
foreach($field_arr as $k=>$v){
    $t    = $v['@attributes'];
    $field_str .= sprintf($php_c, $t['type'], $t['name']);
    $func_str .= sprintf($php_d, $t['name'], $t['type'], $t['name'], $t['name'], $t['name'], $t['name'], $t['name'], $t['name'], $t['type'], $t['name'], $t['name']);
}

$php_content = sprintf($php_tpl, $class_namespace, $class_name, $class_name, $field_str, $func_str);


file_put_contents('php/'.strtolower($class_name).'.php', $php_content);