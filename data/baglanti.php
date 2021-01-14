<?php
include_once(SINIF."class.upload.php");
include_once(SINIF."VT.php");//vt.php dosyasımızı include etmek.
$VT=new VT();//Sınıf çağırma işlemi.
//Fonksiyona ulaşıp veri getirme işlemi.
$ayarlar=$VT->VeriGetir("ayarlar","WHERE ID=?",array(1),"ORDER BY ID ASC",1);
//Ayarlar boş değilse 
if($ayarlar!=false)
{
	//Tüm değişkenleri veritabanından çekme işlemi.
	$sitebaslik=$ayarlar[0]["baslik"];
	$siteanahtar=$ayarlar[0]["anahtar"];
	$siteaciklama=$ayarlar[0]["aciklama"];
	$sitetelefon=$ayarlar[0]["telefon"];
	$sitemail=$ayarlar[0]["mail"];
	$siteadres=$ayarlar[0]["adres"];
	$sitefax=$ayarlar[0]["fax"];
	$siteURL=$ayarlar[0]["url"];
}
?>