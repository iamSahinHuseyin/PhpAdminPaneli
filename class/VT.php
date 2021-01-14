<?php
class VT{//Sınıf oluşturma işlemi
	
	var $sunucu="localhost";//sunucu ismini bewlirttik.
	var $user="root";//kullanıcı adını belirttik.
	var $password="";//Xampp ile yaptığım için şifreye gerek duymadım.
	var $dbname="yonetimpaneli";//veritabanı ismini belirttik.
	var $baglanti;//Bağlantıyı kontrol etmek için boş bir değişken oluşturduk.
	
	function __construct()//Sınıf çağırılınca hemen ardından bu fonksiyonumuz otomatik olarak çalışacaktır.
	{
		try{//Hata yakalamk için
			
		$this->baglanti=new PDO("mysql:host=".$this->sunucu.";dbname=".$this->dbname.";charset=utf8;",$this->user,$this->password);
		//Bağlantı olup olmadığını kontrol etme işlemi
		
		}catch(PDOException $error){//Bir hata verirse hatamızın ne olduğunu söylesin
			
			echo $error->getMessage();//Erroru ekrana bastırma.
			exit();//Programı sonlandırma işlemi.
		}
	}
	
	public function VeriGetir($tablo,$wherealanlar="",$wherearraydeger="",$ordeby="ORDER BY ID ASC",$limit="")
	//Veri getirme fonksiyonumuz.
	{
		//Utf-8 modulunu çalıştırma işlemi.
		$this->baglanti->query("SET CHARACTER SET utf8");
		//Sql sorgumuzu çekme işlemi.
		$sql="SELECT * FROM ".$tablo; /*SELECT * FROM ayarlar*/
		//Alanlar ve değerleri boş değilse sql cumlemizin içine entegre edeceğiz.
		if(!empty($wherealanlar) && !empty($wherearraydeger))
		{

			$sql.=" ".$wherealanlar; /*SELECT * FROM ayarlar WHERE */
			//ordeby özelliklerini belirtmek.
			if(!empty($ordeby)){$sql.=" ".$ordeby;}
			//Limit özellikleri belirtmek.
			if(!empty($limit)){$sql.=" LIMIT ".$limit;}
			//sql sorgumuzu atama işlemi işlemi
			$calistir=$this->baglanti->prepare($sql);
			//sql sorgumuzu çalıştırma işlemi
			$sonuc=$calistir->execute($wherearraydeger);
			//Veritabanından dönen verileri getirme işlemi.
			$veri=$calistir->fetchAll(PDO::FETCH_ASSOC);
		}
		else//Veritbanından herhangi bir şart göndermezsek burası çalışacak.
		{
			//ordeby özelliklerini belirtmek.
			if(!empty($ordeby)){$sql.=" ".$ordeby;}
			//limit özelliklerini belirtmek.
			if(!empty($limit)){$sql.=" LIMIT ".$limit;}
			//Sql sorugumuzu çalıştırma işlemi
			$veri=$this->baglanti->query($sql,PDO::FETCH_ASSOC);
		}
		//Veri değişkenini boş değilse ;
		if($veri!=false && !empty($veri))
		{
			//oluşturulan her kaydı dizi üzerinden gönderme işlemi
			$datalar=array();
			foreach($veri as $bilgiler)
			{
				//Bilgileri oluşturduğumuz dizinin içerisine gönderiyoruz.
				$datalar[]=$bilgiler; 
			}
			//Diziyi geri döndürme işlemi.
			return $datalar;
		}
		else
		{
			//Return yardımıyla veri gönderme
			return false;
		}
		
	}
	



	//Sorgu çalıştırma fonksiyonumuz
	//Bu fonksiyon ile ekleme/silme/değiştirme işlemlerini yapmamız için.
	public function SorguCalistir($tablo,$alanlar="",$degerlerarray="",$limit="")
	{
		//Karakter setimizi belirttik. utf8.
		$this->baglanti->query("SET CHARACTER SET utf8");
		//Alan ve değerlerini kontrol etmek
		if(!empty($alanlar) && !empty($degerlerarray))
		{
            //Sql işlemini gerçekleştirme.
            //Sql sorguyu belirtmek için.
			$sql=$tablo." ".$alanlar;
			//Limit değeri tanımlamak.(Limit değerimiz boş değilse)
			if(!empty($limit)){$sql.=" LIMIT ".$limit;}
            //Sorgumuzu çalıştırma işlemi
			$calistir=$this->baglanti->prepare($sql);
			//Çalıştır değerlerimizi alarak execute ettik.
			$sonuc=$calistir->execute($degerlerarray);
		}
		else
		{
			//tablo değerini sql'e atama işlemi.
			$sql=$tablo;
			//Limit değeri tanımlamak.(Limit değerimiz boş değilse)
			if(!empty($limit)){$sql.=" LIMIT ".$limit;}
			//exec komutu yardımıyla sql çalıştırma işlemi.
			$sonuc=$this->baglanti->exec($sql);
		}
		//Sonuç değişkenimiz boş değilse return ile döndürme işlemi
		if($sonuc!=false)
		{
			return true;
		}
		//Hatalı bir yapı ise false değerini geriye döndürüyoruz.
		else
		{
			return false;
		}
		//Karakter seti ile ilgili bir problem olmaması için tekrar karakter setimizi belirttik.
		$this->baglanti->query("SET CHARACTER SET utf8");
	}
	//Türkçe karakter girilirse modul oluşturmak için onları eleyecektir.Bu fonksiyonumuzu o yüzden yazdık.
	public function seflink($val)
	{
		$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#','?','*','!','.','(',')');
		$replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp','','','','','','');
		$string = strtolower(str_replace($find, $replace, $val));
		$string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
		$string = trim(preg_replace('/\s+/', ' ', $string));
		$string = str_replace(' ', '-', $string);
		return $string;
	}
	//Modul ekle isminde fonksiyon oluşturma işlemi
	public function ModulEkle()
	{
		//Post metodumuz ile alanın boş olup olmadığını kontrol etmek.(bosluk)
		if(!empty($_POST["baslik"]))
		{
			//Başlık bölümünü almak için.
			$baslik=$_POST["baslik"];
			//Post metodumuz ile alanın boş olup olmadığını kontrol etmek. (durum)
			if(!empty($_POST["durum"])){$durum=1;}
			else{$durum=2;}
			//Veritabanında oluşturlacak isim
			$tablo=str_replace("-","",$this->seflink($baslik));//Seflink fonsiyonunu çağırma işlemi.
			//veri getirmek işlemi
			$kontrol=$this->VeriGetir("moduller","WHERE tablo=?",array($tablo),"ORDER BY ID ASC",1);
			//Kayıt var ise false değerni gönderecektir.
			if($kontrol!=false)
			{
				return false;
			}
			else//Tablo var ise 
			{
				//Yeni bir tablo oluşturma işlemi, eğer o tablo yoksa sorgumuz ile.
				$tabloOlustur=$this->SorguCalistir('CREATE TABLE IF NOT EXISTS `'.$tablo.'` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `seflink` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `kategori` int(11) DEFAULT NULL,
  `metin` text COLLATE utf8_turkish_ci,
  `resim` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `anahtar` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `durum` int(5) DEFAULT NULL,
  `sirano` int(11) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;');
				//Modul eklemek için veritbanımıza göndereceğimiz sorgu.
				$modulekle=$this->SorguCalistir("INSERT INTO moduller","SET baslik=?, tablo=?, durum=?, tarih=?",array($baslik,$tablo,$durum,date("Y-m-d")));
				//Katagoriler için veritabanı sorgumuz.
				$kategoriekle=$this->SorguCalistir("INSERT INTO kategoriler","SET baslik=?, seflink=?, tablo=?, durum=?, tarih=?",array($baslik,$tablo,'modul',1,date("Y-m-d")));
				//Modul ekle false değil ise.
				if($modulekle!=false)
				{
					//True değerini döndür
					return true;
				}
				else//Modul ekle false ise
				{
					//False değerinin döndür.
					return false;
				}
			}
			
		}
		else//Eğer gelen değer yok ise false değerinin döndür.
		{
			return false;
		}
	}
	//Filtreleme fonksiyonumuz.
	public function filter($val,$tf=false)
	{
		//Html tagları var ise temizliyoruz.(strip_tags)
		if($tf==false){$val=strip_tags($val);}
		//Boşlukları temizleme(trim) ve sql sorgumuzu güvence altına alma
		$val=addslashes(trim($val));
		return $val;
	}
	//Dosya uzantısını almak için fonksiyon.
	public function uzanti($dosyaadi)
	{
		//Dosya parçalama işlemi (explode)
		$parca=explode(".",$dosyaadi);
		//En sondaki nesneyi alma.
		$uzanti=end($parca);
		//uzantıyı küçük harfa dönüştürüp geri döndürme işlemi
		$donustur=strtolower($uzanti);
		return $donustur;
	}
	
	public function upload($nesnename,$yuklenecekyer='images/',$tur='img',$w='',$h='',$resimyazisi='')
	{
		if($tur=="img")
		{
			if(!empty($_FILES[$nesnename]["name"]))
			{
				$dosyanizinadi=$_FILES[$nesnename]["name"];
				$tmp_name=$_FILES[$nesnename]["tmp_name"];
				$uzanti=$this->uzanti($dosyanizinadi);
				if($uzanti=="png" || $uzanti=="jpg" || $uzanti=="jpeg" || $uzanti=="gif")
				{
					$classIMG=new upload($_FILES[$nesnename]);
					if($classIMG->uploaded)
					{
						if(!empty($w))
						{
							if(!empty($h))
							{
								$classIMG->image_resize=true;
								$classIMG->image_x=$w;
								$classIMG->image_y=$h;
							}
							else
							{
								if($classIMG->image_src_x>$w)
								{
									$classIMG->image_resize=true;
									$classIMG->image_ratio_y=true;
									$classIMG->image_x=$w;
								}
							}
						}
						else if(!empty($h))
						{
								if($classIMG->image_src_h>$h)
								{
									$classIMG->image_resize=true;
									$classIMG->image_ratio_x=true;
									$classIMG->image_y=$h;
								}
						}
						
						if(!empty($resimyazisi))
						{
							$classIMG->image_text = $resimyazisi;

						$classIMG->image_text_direction = 'v';
						
						$classIMG->image_text_color = '#FFFFFF';
						
						$classIMG->image_text_position = 'BL';
						}
						$rand=uniqid(true);
						$classIMG->file_new_name_body=$rand;
						$classIMG->Process($yuklenecekyer);
						if($classIMG->processed)
						{
							$resimadi=$rand.".".$classIMG->image_src_type;
							return $resimadi;
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else if($tur=="ds")
		{
			
			if(!empty($_FILES[$nesnename]["name"]))
			{
				
				$dosyanizinadi=$_FILES[$nesnename]["name"];
				$tmp_name=$_FILES[$nesnename]["tmp_name"];
				$uzanti=$this->uzanti($dosyanizinadi);
				if($uzanti=="doc" || $uzanti=="docx" || $uzanti=="pdf" || $uzanti=="xlsx" || $uzanti=="xls" || $uzanti=="ppt" || $uzanti=="xml" || $uzanti=="mp4" || $uzanti=="avi" || $uzanti=="mov")
				{
					
					$classIMG=new upload($_FILES[$nesnename]);
					if($classIMG->uploaded)
					{
						$rand=uniqid(true);
						$classIMG->file_new_name_body=$rand;
						$classIMG->Process($yuklenecekyer);
						if($classIMG->processed)
						{
							$dokuman=$rand.".".$uzanti;
							return $dokuman;
						}
						else
						{
							return false;
						}
					}
				}
			}
		}
		else
		{
			return false;
		}
	}
	
	//Katagori getirmek için fonksiyonumuz.
	//Tablo, seçilen id ve uzunluk paramerelerini gönderiyoruz.
	public function kategoriGetir($tablo,$secID="",$uz=-1)
	{
		//Uzunluk değerinin 0'a eşitlemek.
		$uz++;
		//Katagori tablosundan veri getirmek için.
		$kategori=$this->VeriGetir("kategoriler","WHERE tablo=?",array($tablo),"ORDER BY ID ASC");
		//Katagori değerimiz' de başarılı bir sonuç varsa
		if($kategori!=false)
		{

			for($q=0;$q<count($kategori);$q++)
			{
				//seflink yapısını alma işlemi.
				$kategoriseflink=$kategori[$q]["seflink"];
				//katagori id değerini atamak
				$kategoriID=$kategori[$q]["ID"];
				//Seçilen id ve katagori id aynı ise
				if($secID==$kategoriID)
				{
					//Seçilen boxta veirlen değerleri ekrananda göstermek için.
					echo '<option value="'.$kategoriID.'" selected="selected">'.str_repeat("&nbsp;&nbsp;&nbsp;",$uz).stripslashes($kategori[$q]["baslik"]).'</option>';
				}
				//Seçilen boxta veirlen değerleri ekrananda göstermek için.
				else
				{
					echo '<option value="'.$kategoriID.'">'.str_repeat("&nbsp;&nbsp;&nbsp;",$uz).stripslashes($kategori[$q]["baslik"]).'</option>';
					//stripslashes metodu ile sql sorgu tırnaklarını kaldırmak için.
				}
				//Katagori seflink değeri tablomuz ismine eşit ise programı break komutuyla sonlandır.
				if($kategoriseflink==$tablo){break;}
				//Katagorigetir fonksiyonu çağırma işlemi.
				$this->kategoriGetir($kategoriseflink,$secID,$uz);
			}
		}
		//Katagori değeri yoksa false değerini döndürüyoruz.
		else
		{
			return false;
		}
	}
	//Katagori getir fonksiyonumuz tekrar yazıyoruz ama bu fonksiyon sadece tek bir katagori döndürüyor.
	public function tekKategori($tablo,$secID="",$uz=-1)
	{
		$uz++;
		//Tek farkı modul olarak aratıyor.
		$kategori=$this->VeriGetir("kategoriler","WHERE seflink=? AND tablo=?",array($tablo,"modul"),"ORDER BY ID ASC");
		if($kategori!=false)
		{
			for($q=0;$q<count($kategori);$q++)
			{
				$kategoriseflink=$kategori[$q]["seflink"];
				$kategoriID=$kategori[$q]["ID"];
				if($secID==$kategoriID)
				{
					echo '<option value="'.$kategoriID.'" selected="selected">'.str_repeat("&nbsp;&nbsp;&nbsp;",$uz).stripslashes($kategori[$q]["baslik"]).'</option>';
				}
				else
				{
					echo '<option value="'.$kategoriID.'">'.str_repeat("&nbsp;&nbsp;&nbsp;",$uz).stripslashes($kategori[$q]["baslik"]).'</option>';
				}
				
			}
		}
		else
		{
			return false;
		}
	}
	
	/*Ektra Bonus Fonksiyonlar*/
	/*
	* Sitenize gelen ziyaretçilerin rapoarlarını kaydedebilir ve hangi tarayıcıdan kaç ziyaretçinin sitenizi ziyaret ettiğini görebilirsiniz. 
	*/
	public function TekilCogul()
	{
		date_default_timezone_set('Europe/Istanbul');
		$tarih=date("Y-m-d");
		$IP=$this->ipGetir();
		$TARAYICI=$this->tarayiciGetir();
		$tarayicistatistic=$this->VeriGetir("ziyarettarayici","","","ORDER BY ID ASC");
		
		$konts=$this->VeriGetir("ziyaretciler","WHERE tarih=? AND IP=?",array($tarih,$IP),"ORDER BY ID ASC",1);
		if(count($konts)>0 && $konts!=false)
		{
			$c=($konts[0]["cogul"]+1);
			$ID=$konts[0]["ID"];
			$gunc=$this->SorguCalistir("UPDATE ziyaretciler","SET cogul=? WHERE ID=?",array($c,$ID),1);
		}
		else
		{
			if(!empty($_COOKIE["siteSettingsUse"]))
			{
			}
			else
			{
				$eks=$this->SorguCalistir("INSERT INTO ziyaretciler","SET IP=?, tarayici=?, tekil=?, cogul=?, xr=?, tarih=?",array($IP,$TARAYICI,1,1,1,$tarih));
				@setcookie("siteSettingsUse", md5(rand(1,99999)), time() + (60*60*8));
				if($TARAYICI=="Google Chrome"){
					$tbl=($tarayicistatistic[0]["ziyaret"]+1);
					$tiid=$tarayicistatistic[0]["ID"];
					$ersa=$this->SorguCalistir("UPDATE ziyarettarayici","SET ziyaret=? WHERE ID=?",array($tbl,$tiid),1);
				}else if($TARAYICI=="İnternet Explorer"){
					$tbl=($tarayicistatistic[1]["ziyaret"]+1);
					$tiid=$tarayicistatistic[1]["ID"];
					$ersa=$this->SorguCalistir("UPDATE ziyarettarayici","SET ziyaret=? WHERE ID=?",array($tbl,$tiid),1);
				}else if($TARAYICI=="Firefox"){
					$tbl=($tarayicistatistic[2]["ziyaret"]+1);
					$tiid=$tarayicistatistic[2]["ID"];
					$ersa=$this->SorguCalistir("UPDATE ziyarettarayici","SET ziyaret=? WHERE ID=?",array($tbl,$tiid),1);
				}else{
					$tbl=($tarayicistatistic[3]["ziyaret"]+1);
					$tiid=$tarayicistatistic[3]["ID"];
					$ersa=$this->SorguCalistir("UPDATE ziyarettarayici","SET ziyaret=? WHERE ID=?",array($tbl,$tiid),1);
				}
			}
		}
		
		/*sayfa hızı hesaplama*/
		$start = microtime(true);
		$end = microtime(true);
		$time = mb_substr(($end - $start),0,4);
		$tarah=$this->SorguCalistir("UPDATE ziyarettarayici","SET hiz=? WHERE ID=?",array($time,5),1);
	}
	public function tarayiciGetir()
	{
		$tarayiciBul=$_SERVER["HTTP_USER_AGENT"];
		$msie=strpos($tarayiciBul,'MSIE') ? true: false;
		$firefox=strpos($tarayiciBul,'Firefox') ? true : false;
		$chrome=strpos($tarayiciBul,'Chrome') ? true : false;
		if(!empty($msie) && $msie!=false)
		{
			$tarayici="İnternet Explorer";
		}
		else if(!empty($firefox) && $firefox!=false)
		{
			$tarayici="Firefox";
		}
		else if(!empty($chrome) && $chrome!=false)
		{
			$tarayici="Google Chrome";
		}
		else
		{
			$tarayici="Diğer";
		}
		return $tarayici;
	}
	public function ipGetir(){
		if(getenv("HTTP_CLIENT_IP")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} elseif(getenv("HTTP_X_FORWARDED_FOR")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
			if (strstr($ip, ',')) {
				$tmp = explode (',', $ip);
				$ip = trim($tmp[0]);
			}
		} else {
		$ip = getenv("REMOTE_ADDR");
		}
		return $ip;
	} 
}

?>