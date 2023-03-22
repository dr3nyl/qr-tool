 <?php
 echo phpinfo();
$dir = 'C:\laragon\www\qr_tool/';
$myfile = fopen($dir."/newfilew.txt", "w") or die("Unable to open file!");
$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = date('Ymdhis')."Jane Doe\n";
fwrite($myfile, $txt);
fclose($myfile);
?> 