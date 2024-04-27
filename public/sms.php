<?php
function curl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response  = curl_exec($ch);
    curl_close($ch);
    return $response ;
}
$username = "GOT"; //your username
$password = "got@india"; //your password
$sender = "GOTIND"; //Your senderid
$mobile = "9745451448"; //enter Mobile numbers comma seperated
$username = urlencode($username);
$password = urlencode($password);
$messagecontent = "1234 is your OTP for login to GOT. Do not share this OTP with anyone. "; //Type Of Your Message
$message = urlencode($messagecontent);
$route = "T"; //your route id
$peid = "1701171393351682337"; //your 19-digit Entity ID
$tempid = "1707171395450447948"; //your 19-digit Template ID
$url = "http://textsms.cloudveinstechnologies.com/sendsms?uname=$username&pwd=$password&senderid=$sender&to=$mobile&msg=$message&route=$route&peid=$peid&tempid=$tempid";
$response = curl($url);
echo $response;