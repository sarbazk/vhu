<?php 

if (isset($_GET['site']) and isset($_GET['mail']) and isset($_GET['dr']) and isset($_GET['pass'])) 
{
	$site = $_GET['site'];
	$mail = $_GET['mail'];
	$dr = $_GET['dr'];
	$pa = $_GET['pass'];

	exec("echo '".$pa."' | sudo -S chmod 777 -R /etc/apache2/sites-available");
	exec("echo '".$pa."' | sudo -S touch /etc/apache2/sites-available/".$site.".conf");
	exec("echo '".$pa."' | sudo -S chmod 777 -R /etc/apache2/sites-available/".$site.".conf");
	$fo = fopen('/etc/apache2/sites-available/'.$site.'.conf', 'w');
	fwrite($fo, "<VirtualHost *:80>\n");
	fwrite($fo, "\tServerAdmin ".$mail."\n");
	fwrite($fo, "\tServerName ".$site."\n");
	fwrite($fo, "\tDocumentRoot ".$dr."\n");
	fwrite($fo, "</VirtualHost>");
	fclose($fo);
	exec("echo '".$pa."' | sudo -S a2ensite ".$site.".conf");
	exec("echo '".$pa."' | sudo -S service apache2 restart");
	exec("echo '".$pa."' | sudo -S chmod 777 -R /etc/hosts");
	$fp = fopen('/etc/hosts', 'a');
	fwrite($fp, "\n127.0.0.2 ".$site);
	fclose($fp);
	echo "OK...";
}
else
{
	echo "Please send required informations...";
}

?>