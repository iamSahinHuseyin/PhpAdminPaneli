<?php
@session_start();//Oturum yapımı başlatma.
@ob_start();//Yönlendirme işlemlerini kullanmak için.
define("DATA","data/");//Sabit data değişken oluşturma(Data klasör yolu belirleme)
define("SAYFA","include/");//Sabit data değişken oluşturma(include klasör yolu belirleme)
define("SINIF","class/");//Class klasörünün yolunu belirtmek.
include_once(DATA."baglanti.php");//Baglanti.php sayfasını include etmek.
define("SITE",$siteURL);//Sitenin url adresini belirttik.
if(!empty($_SESSION["ID"]) && !empty($_SESSION["adsoyad"]) && !empty($_SESSION["mail"]))
{
}
else
{
	?>
    <meta http-equiv="refresh" content="0;url=<?=SITE?>giris-yap">
    <?php
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Site başlığını veritabanından çekme işlemi. -->
  <title><?=$sitebaslik?></title>
  <!-- Site anahtar sözcüğünü çekme. -->
  <meta http-equiv="keywords" content="<?=$siteanahtar?>">
  <!-- Site açıklamasını çekme işlemi. -->
  <meta http-equiv="description" content="<?=$siteaciklama?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=SITE?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- SITE değişkenimiz ile kütüohanelere eklemk. -->
  <link rel="stylesheet" href="<?=SITE?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- SITE değişkenimiz ile kütüohanelere eklemk. -->
  <link rel="stylesheet" href="<?=SITE?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- SITE değişkenimiz ile kütüohanelere eklemk. -->
  <link rel="stylesheet" href="<?=SITE?>plugins/jqvmap/jqvmap.min.css">
  <!-- SITE değişkenimiz ile kütüohanelere eklemk. -->
  <link rel="stylesheet" href="<?=SITE?>dist/css/adminlte.min.css">
  <!-- SITE değişkenimiz ile kütüohanelere eklemk. -->
  <link rel="stylesheet" href="<?=SITE?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- SITE değişkenimiz ile kütüohanelere eklemk. -->
  <link rel="stylesheet" href="<?=SITE?>plugins/daterangepicker/daterangepicker.css">
  <!-- SITE değişkenimiz ile kütüohanelere eklemk. -->
  <link rel="stylesheet" href="<?=SITE?>plugins/summernote/summernote-bs4.css">
  <!-- SITE değişkenimiz ile kütüohanelere eklemk. -->
  <link rel="stylesheet" href="<?=SITE?>plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!--SITE değişkenimiz ile kütüohanelere eklemk. -->
  <link rel="stylesheet" href="<?=SITE?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?=SITE?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- SITE değişkenimiz ile kütüohanelere eklemk. -->
  <link rel="stylesheet" href="<?=SITE?>plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

 <?php
 include_once(DATA."ust.php");//İnclude edilecek dosya
 include_once(DATA."menu.php");//İnclude edilecek dosya
 
 //Açmak istediğimiz sayfayı parametre olarak göndermek
 //get ile parametre gelip gelmediğini kontrol etmek.
 if($_GET && !empty($_GET["sayfa"]))
 {
   //.php dosyası yapma işlemi
	 $sayfa=$_GET["sayfa"].".php";
   //Böyle bir dosya olup olmadığını kontrol etmek.
	 if(file_exists(SAYFA.$sayfa))
	 {
     //include klasöründeki sayfa isimli dosyayı include etmek.
		 include_once(SAYFA.$sayfa);
	 }
   //get metoduyla herhangi bir değer gelmediyse home sayfası include et (Direk anasayfaya yönlerdinme işlemi)
	 else
	 {
		 include_once(SAYFA."home.php");
	 }
	 
 }
 else
 {
	 include_once(SAYFA."home.php");//home.php dosyasını çağırmak.
 }
 
 
 include_once(DATA."footer.php");//Footer kısmını çağırmak.
 ?>
 
 
 
 
 
 
 
  
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?=SITE?>plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=SITE?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?=SITE?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?=SITE?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?=SITE?>plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?=SITE?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?=SITE?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?=SITE?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?=SITE?>plugins/moment/moment.min.js"></script>
<script src="<?=SITE?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=SITE?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?=SITE?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=SITE?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=SITE?>dist/js/adminlte.js"></script>
<!-- DataTables -->
<script src="<?=SITE?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?=SITE?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Select2 -->
<script src="<?=SITE?>plugins/select2/js/select2.full.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=SITE?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=SITE?>dist/js/demo.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })


  })
</script>
<script src="<?=SITE?>plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
  //Aktif pasif fonksiyonumuz.(durum için.)
  function aktifpasif(ID,tablo)
  {
	  var durum=0;
    //Gelecek olan kısmın checked özelliğini kontrol etmek.
	 if($(".aktifpasif"+ID).is(':checked'))
	 {
    //Durum değişkenini 1 yap.
		 durum=1;
	 }
	 else//Checked değişkeni seçili gelmediyse
	 {
    //Durum değikenini 2 olarak atamak.
		 durum=2;
	 }
	 //ilgili değeri gönderme
	 $.ajax({
    //Hangi metod ,//Hangi url,//Hangi tablo ve o tablodaki id ve durum,//Dönen sonuç doğru ise (success)
		 method:"POST",
		 url:"<?=SITE?>ajax.php",
		 data:{"tablo":tablo,"ID":ID,"durum":durum},
		 success: function(sonuc)
		 {
      //Sonuc değişkeninde işlem başarılı ise
			 if(sonuc=="TAMAM")
			 {
			 }
			 else//Başarısız ise kullanıcıya mesaj verme.
			 {
				 alert("İşleminiz şuan geçersizdir. Lütfen daha sonra tekrar deneyiniz.");
			 }
		 }
	 });
  }
</script>
</body>
</html>
