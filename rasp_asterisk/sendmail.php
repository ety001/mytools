#!/usr/bin/php
<?php
$sms_path = '/tmp/wx.txt';
$sms_hash_path = '/tmp/wx_hash.txt';
while(1){
    $tmp_file = file_get_contents($sms_path);
    $hash = md5($tmp_file);
    
    if(file_exists($sms_hash_path)){
        $hash_last = file_get_contents($sms_hash_path);
    } else {
        $hash_last = '';
        file_put_contents($sms_hash_path, $hash_last);
    }
    
    if($hash != $hash_last){
        echo 'send'."\n";
        system('/usr/local/bin/wx_msg "'.$tmp_file.'"');
        file_put_contents($sms_hash_path, $hash);
    } else {
        echo 'not send|'.$hash.'|'.$hash_last;
    }
    sleep(10);
}
