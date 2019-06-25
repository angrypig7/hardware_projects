<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Seoul');

include_once('./dbconnect.php');

function elapsed_time($timestamp, $precision = 2) {
    $time = time() - $timestamp;
    $a = array('decade' => 315576000, 'year' => 31557600, 'month' => 2629800, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'min' => 60, 'sec' => 1);
    $i = 0;
    $result = "";
    foreach($a as $k => $v) {
        $$k = floor($time/$v);
        if ($$k) $i++;
        $time = $i >= $precision ? 0 : $time - $$k * $v;
        $s = $$k > 1 ? 's' : '';
        $$k = $$k ? $$k.' '.$k.$s.' ' : '';
        $result .= $$k;
    }
    return $result ? $result : '0 sec ';
}

function logCon($logString){
    $logString = htmlspecialchars($logString);
    echo "<script>console.log('$logString')</script>";
}

$curtime = (new DateTime())->format("Y-m-d H:i:s");

$devnum = "";
$control = "";
$res = "";
$rep = "";
$onoff = "";
$day = "";

logCon(" ");
logCon("Post Data: {");
foreach($_POST as $key => $value){
    logCon("    $key: $value");
}

if(!empty($_POST['day'])){
    foreach($_POST['day'] as $day_post){
        $day .= $day_post;
    }
}
if(isset($_POST['devnum'])){
    logCon("    day[]: $day");
}
logCon("}");


if(isset($_POST['devnum'])) {
    $devnum = $_POST['devnum'];
    $control = $_POST['control'];
    $res = $_POST['reservation'];
    $rep = $_POST['repeat'];
//    $day_post = $_POST['day'];
    $onoff = $_POST['onoff'];

    if($res != ""){
        logCon("Control: Set Reservation");

        $SQL = "INSERT INTO reserve (`dev_num`, `control`, `timestamp`) VALUES('$devnum', '$control', '$res')";
        mysqli_query($conn, $SQL);
    }

    if($rep != ""){
        logCon("Control: Set Repeat");

        $SQL = "INSERT INTO reserve (`dev_num`, `control`, `time`, `day`) VALUES('$devnum', '$control', '$rep', '$day')";
        mysqli_query($conn, $SQL);
    }

}

if(isset($_POST['remove'])){
    $remove_post = $_POST['remove'];
    if($remove_post != ""){
        logCon("Control: Delete Reservation");

        $remove_post = addslashes($remove_post);

        $SQL = "DELETE FROM devices WHERE dev_num='$remove_post'";
        mysqli_query($conn, $SQL);
    }

    echo "<script>window.location.href='./'</script>";
}

$SQL = "SELECT * FROM devices ORDER BY dev_num";
$result = mysqli_query($conn, $SQL);

$num_rows = mysqli_num_rows($result);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<title>IOTSV</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="styles/layout.css" type="text/css">
<!--[if lt IE 9]><script src="scripts/html5shiv.js"></script><![endif]-->
</head>
<body>
<div class="wrapper row1">
  <header id="header" class="clear">
    <div id="hgroup">
      <h1><a href="/">IOTSV</a></h1>
      <h2>Control Interface</h2>
    </div>
    <form action="#" method="post" onsubmit="return confirm('정말로 삭제하시겠습니까?')">
      <fieldset>
        <legend>Search:</legend>
        <input type="text" placeholder="Remove Device" name="remove">
        <input type="submit" id="sf_submit" value="remove">
      </fieldset>
    </form>
<!--    <nav>-->
<!--      <ul>-->
<!--        <li><a href="#">Text Link</a></li>-->
<!--        <li><a href="#">Text Link</a></li>-->
<!--        <li><a href="#">Text Link</a></li>-->
<!--        <li><a href="#">Text Link</a></li>-->
<!--        <li class="last"><a href="#">Text Link</a></li>-->
<!--      </ul>-->
<!--    </nav>-->
  </header>
</div>
<!-- content -->
<div class="wrapper row2">
  <div id="container" class="clear">
<!--     content body -->
<!--    <section id="slider"><a href="#"><img src="images/demo/960x360.gif" alt=""></a></section>-->
    <section id="shout">
      <p>
          <?php echo "number of devices: $num_rows"; ?>
      </p>
    </section>
    <!-- main content -->
    <div id="homepage">
      <!-- services area -->
      <h1>Controls</h1>
      <section id="services" class="clear">

          <?php
          include_once ('devices.php');
          for($i=1; $i<=$num_rows; $i++){
//              if($i / )
              $html = show_devices($i);
              echo $html;
          }
          ?>

<!--        <article>-->
<!--          <figure><img src="images/con0.png" width="32" height="32" alt=""></figure>-->
<!--          <strong>Lorum ipsum dolor</strong>-->
<!--          <p>You can use and modify the template for both personal and commercial use. You must keep all copyright information and credit links in the template and associated files.</p>-->
<!--          <p class="more"><a href="#">Read More &raquo;</a></p>-->
<!--        </article>-->
<!---->
<!--        <article class="last">-->
<!--          <figure><img src="images/con0.png" width="32" height="32" alt=""></figure>-->
<!--          <strong>Lorum ipsum dolor</strong>-->
<!--          <p>For more HTML5 templates visit <a href="https://www.os-templates.com/">free website templates</a>. Orciinterdum condimenterdum nullamcorper elit nam curabitur laoreet met praesenean et iaculum.</p>-->
<!--          <p class="more"><a href="#">Read More &raquo;</a></p>-->
<!--        </article>-->
      </section>
      <!-- / services area -->
      <!-- ########################################################################################## -->
      <!-- ########################################################################################## -->
      <!-- ########################################################################################## -->
      <!-- ########################################################################################## -->
      <!-- One Quarter -->
      <br><br><br><br><br><br><br>
      <!-- / One Quarter -->
    </div>
    <!-- / content body -->
  </div>
</div>
<!-- Footer -->
<div class="wrapper row3">
  <footer id="footer" class="clear">
    <p class="fl_left">Copyright &copy; 2019 - All Rights Reserved - <a href="#">IOTSV</a></p>
    <p class="fl_right">Template by <a target="_blank" href="https://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
  </footer>
</div>
</body>
</html>
