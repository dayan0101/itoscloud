<?php
$fechaIni = date('Y-m-d');
$mod_date = strtotime($fechaIni."- 5 days");
$fechaFin =  date("Y-m-d",$mod_date);
echo $urlws_busqueda = "https://www.banxico.org.mx/SieAPIRest/service/v1/seriesSF43718/datos/".$fechaIni.'/'.$fechaFin;
$ch = curl_init($urlws_busqueda);                          
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch,  CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch,  CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
    'Accept: application/json', 
    'Access-Control-Allow-Origin: http://localhost',
    'Bmx-Token: a441355af61c510d2ba5076729a15d8756783e6c2fdbc88a21f3c5d64c956027'));
$result = curl_exec($ch);
$redirectURL = curl_getinfo($ch,CURLINFO_REDIRECT_URL);
print_r($result);

