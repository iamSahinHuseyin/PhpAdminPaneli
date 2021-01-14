<?php
//VERİTABANI BAĞLANTISI
@session_start();
@ob_start();
define("DATA","data/");
define("SAYFA","include/");
define("SINIF","class/");
include_once(DATA."baglanti.php");
define("SITE",$siteURL);

//Değer geldiyse
if($_POST)
{
	//Tablo, ıd , durum değerlerimiz boş değilse:
	if(!empty($_POST["tablo"]) && !empty($_POST["ID"]) && !empty($_POST["durum"]))
	{
		//Filtreleme işlemi yapmak.
		$tablo=$VT->filter($_POST["tablo"]);
		$ID=$VT->filter($_POST["ID"]);
		$durum=$VT->filter($_POST["durum"]);
		//Gunclle sql sorgumuz:
		$guncelle=$VT->SorguCalistir("UPDATE ".$tablo,"SET durum=? WHERE ID=?",array($durum,$ID),1);
		//Guncelleme işlemi başarılı ise tamam sonucu gönder
		if($guncelle!=false)
		{
			echo "TAMAM";
		}
		else//Başarılı değilse hata isminde sonuç gönder
		{
			echo "HATA";
		}
	}
	else//Boş değeri döndürmek.
	{
		echo "BOS";
	}
}
?>