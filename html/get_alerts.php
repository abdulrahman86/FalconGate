<?php
session_start();

include_once 'includes/functions.php';
require 'templates/header.html';

?>

<?php
if (login_check() != true){
    echo ("<p><span class=error>You are not authorized to access this page.</span> Please <a href=index.php>login</a>.</p>");
    exit(0);
}
?>

	<header id="header"><h1>FalconGate</h1></header>

	<div id="container">

		<main id="center" class="column">
			<article>

<?php
$data = array("target" => "alerts");
$result = CallAPI('POST', 'http://127.0.0.1:5000/api/v1.0/falcongate/status', json_encode($data));
if (!$result){
    echo ("<h3>Eggshell API process seems to be down!</h3>");
    echo ("<h3>Check your device's configuration and reboot if necessary.</h3>");
}else{
    $obj = json_decode($result, true);
    echo ("<h3>Alerts detected in the previous week</h3>");
    echo ("<p align=right><a href=save-alerts-csv.php target=_blank>download csv</a></p>");
    echo ('<table class=TFtable width=100% halign=left>
        <tr><td nowrap><b>First seen</b></td><td nowrap><b>Last seen</b></td><td nowrap><b>Host</b></td><td nowrap><b>Threat</b></td><td nowrap><b>Indicators</b></td></tr>');
    if ($obj[0] != 'none'){
        foreach ($obj as $alert){    
            echo ('<tr><td nowrap>'.date('Y/m/d H:i:s', $alert[2]).'</td>'.'<td nowrap>'.date('Y/m/d H:i:s', $alert[3]).'</td>'.'<td nowrap>'.$alert[7].'</td>'.'<td nowrap>'.$alert[6].'</td>'.'<td>'.str_replace('|','| ',$alert[8]).'</td></tr>');
        }
    }
    echo ('</table>');
    
}

?>

<?php
require 'templates/footer.html';
?>