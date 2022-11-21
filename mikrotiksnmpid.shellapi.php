<?php

if(isset($_GET['nasip']) && isset($_GET['snmpcomstring']) && isset($_GET['pppoeid'])){
    $nasip = $_GET['nasip'];
    $snmpstr = $_GET['snmpcomstring'];
    $id = $_GET['pppoeid'];

    $shellScriptLocation = __DIR__.'/mikrotiksnmpid.sh';
    
    $shellInstruction = $shellScriptLocation.' '.$nasip.' '.$snmpstr.' '.$id;
    $shellOutput = shell_exec($shellInstruction);
    
    echo trim($shellOutput);
}
else echo trim("NA");


?>