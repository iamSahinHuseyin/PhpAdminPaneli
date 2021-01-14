<?php
//Session işlemleri
@session_destroy();
@ob_end_flush();
//Login sayfasına yönlendirme işlemi
?>
<meta http-equiv="refresh" content="0;url=<?=SITE?>giris-yap" />
<?php
//Session sonlandırma işlemi
exit();
?>