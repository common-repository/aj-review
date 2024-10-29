<?php
class AJRVPlugin
{
    public function __construct(){

    }

    public function activate(){
        echo 'The plugin was activation';
    }

    public function deactivate(){

    }

    public function uninstall(){

    }

    public function ajrv_options_page(){
        
    }
    public static function init(){
        echo "<h1>Test</h1>";
    }
}
?>