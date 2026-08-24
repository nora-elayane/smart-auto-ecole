<?php
require_once '../config/database.php' ;
$db = new Database() ; 
$connection = $db->getConnection() ; 
if($connection){
    echo "heeere we goooo " ;
}else{
    echo "not yet" ; 
}
?>