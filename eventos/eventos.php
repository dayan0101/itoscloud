<?php
$fechaFin = date('Y-m-d');
$mod_date = strtotime($fechaFin."- 5 days");
$fechaIni =  date("Y-m-d",$mod_date);
$urlws_busqueda = "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/".$fechaIni.'/'.$fechaFin;
$ch = curl_init($urlws_busqueda);                          
curl_setopt($ch, CURLOPT_HEADER, false);
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
$data = curl_exec($ch);
$curl_errno = curl_errno($ch);
$headerResponse = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
$arrayData = array();
if (!$curl_errno) {
    $arrayData['json'] = json_decode($data, true);
    $arrayData['headerCode'] = $headerResponse;
} else {
    $arrayData['json'] = $curl_errno;
    $arrayData['headerCode'] = 500;
    $arrayData['error'] = $headerResponse;
}
if ($arrayData['headerCode'] == 200) {
       
    foreach ($arrayData['json']['bmx']['series'] as $data) {
       $serie = $data['idSerie'];
       $titulo = $data['titulo'];
       $html  = '<p>La Serie'.$serie.' de'. $titulo .' contiene los siguientes datos: <br> </p>';
        $html  .= '<table style="border: 1px solid black;"><tr><td style="border: 1px solid black;">Fecha</td><td style="border: 1px solid black;">Tipo de cambio</td>';
       foreach ($data['datos'] as $val) {          
           $html .= '<tr><td style="border: 1px solid black;">'.$val['fecha'].'</td><td style="border: 1px solid black;">'.$val['dato'].'</td></tr>';
       }
    }
} else {
    $html = '<p>La serie no contiene información</p>';
}
echo $html;
