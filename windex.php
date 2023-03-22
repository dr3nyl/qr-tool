 <?php
$dir = getcwd();
$myfile = fopen($dir."/newfile.txt", "a") or die("Unable to open file!");
$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = date('Ymdhis')."Jane Doe\n";
fwrite($myfile, $txt);
fclose($myfile);
?> 