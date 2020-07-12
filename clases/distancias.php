<?php
//por defecto
$lat=-3.8278641999999996;
$lng=-78.7598112;
$lista=getBoundaries($lat, $lng);
//la del sistema
$latreal=$_GET['latitud'];
$lngreal=$_GET['longitud'];
if($latreal>=$lista['min_lat'] && $lista['max_lat']<=$latreal && $lngreal>=$lista['min_lng'] && $lngreal<=$lista['max_lng']){
    $resp= "permitido";
}else{
    //0 es fuera de rango
    $resp= "permitido";
    //$resp= "0";
}
echo $resp;
function getBoundaries($lat, $lng, $distance = 0.4, $earthRadius = 6371)
{
    $return = array();
     
    // Los angulos para cada dirección
    $cardinalCoords = array('north' => '0',
                            'south' => '180',
                            'east' => '90',
                            'west' => '270');
    $rLat = deg2rad($lat);
    $rLng = deg2rad($lng);
    $rAngDist = $distance/$earthRadius;
    foreach ($cardinalCoords as $name => $angle)
    {
        $rAngle = deg2rad($angle);
        $rLatB = asin(sin($rLat) * cos($rAngDist) + cos($rLat) * sin($rAngDist) * cos($rAngle));
        $rLonB = $rLng + atan2(sin($rAngle) * sin($rAngDist) * cos($rLat), cos($rAngDist) - sin($rLat) * sin($rLatB));
         $return[$name] = array('lat' => (float) rad2deg($rLatB), 
                                'lng' => (float) rad2deg($rLonB));
    }
    return array('min_lat'  => $return['south']['lat'],
                 'max_lat' => $return['north']['lat'],
                 'min_lng' => $return['west']['lng'],
                 'max_lng' => $return['east']['lng']);
}
?>