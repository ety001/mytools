#!/usr/bin/php
<?php
$sms_path = '/tmp/sms.txt';
$sms_hash_path = '/tmp/sms_hash.txt';
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
        system('/usr/sbin/sendmail -t < /tmp/sms.txt');
        file_put_contents($sms_hash_path, $hash);
    }
    sleep(10);
}
