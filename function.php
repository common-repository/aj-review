<?php
function ajrv_getLatestVer(){
    return "1.0.0";
}
function ajrv_getLicense(){
    return array("lic" => true);
}
function ajrv_getskinbyname($skin)
{
    switch($skin){
        case "box" : return "basic_1";
        case "simple" : return "basic_2";
        case "white" : return "basic_3";
        case "dark" : return "basic_4";
    }
    return $skin;
}
