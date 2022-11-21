<?php

if(isset($_GET['nasip']) && isset($_GET['snmpcomstring']) && isset($_GET['snmpid']) && isset($_GET['direction'])){
    if($_GET['direction'] == 'tx') $shellScriptLocation = __DIR__.'/mikrotiktx.sh';
    if($_GET['direction'] == 'rx') $shellScriptLocation = __DIR__.'/mikrotikrx.sh';
    
    $nasip = $_GET['nasip'];
    $snmpstr = $_GET['snmpcomstring'];
    $id = $_GET['snmpid'];
    
    $shellInstruction = $shellScriptLocation.' '.$nasip.' '.$snmpstr.' '.$id;
    $shellOutput = shell_exec($shellInstruction);
    
    echo trim($shellOutput);
}

else echo trim("NA");


?>