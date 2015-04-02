#!/usr/bin/python2
#-*-coding:utf-8-*-
import os
import httplib

apikey = '29261f9ba070db44eaf66ec11887189b'
device_id = '19279'
sensor_id = '33812'
url_path = '/v1.0/device/' + device_id + '/sensor/' + sensor_id +'/datapoints'
host_path = 'api.yeelink.net'

def get_temp():
    out = os.popen('cat /sys/class/thermal/thermal_zone0/temp')
    r = int( out.read() )
    return r/1000.0

def post_info(info):
    data = '{ "timestamp":"", "value":'+ str(info)  +' }'
    header = {'U-ApiKey': apikey}
    conn = httplib.HTTPConnection(host_path);
    conn.request(method="POST", url=url_path, body=data, headers=header);
    response = conn.getresponse();
    if response.status == 200:
        print "success";
    else:
        print "failed";
    conn.close();
    
temp = get_temp()
post_info(temp)
