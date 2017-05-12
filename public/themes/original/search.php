<?php
  $p = '1';
  $c = '_';
  $s = '';
  $sort = 'torrent_id';
  $order = 'desc';
  $max = 50;
  $q = '';

  if(isset($_GET['c'])) {
    $c = $_GET['c'];
  }

  if(isset($_GET['s'])) {
    $s = $_GET['s'];
  }

  if(isset($_GET['sort'])) {
    $sort = $_GET['sort'];
  }

  if(isset($_GET['order'])) {
    $order = $_GET['order'];
  }

  if(isset($_GET['max'])) {
    $max = $_GET['max'];
  }

  if(isset($_GET['q'])) {
    $q = $_GET['q'];
  }

  if(isset($_GET['p'])) {
    $p = $_GET['p'];
  }

  $db = new SQLite3('../../nyaa.db');

  if($c == "_" | $c == "") {
    $count = $db->query("SELECT COUNT(*) AS count FROM torrents WHERE (torrent_hash is not null AND torrent_name LIKE '%".$q."%')");
  }
  else if (substr($c,2) == ""){
    $count = $db->query("SELECT COUNT(*) AS count FROM torrents WHERE (torrent_hash is not null AND category_id = ".substr($c,0,1)." AND torrent_name LIKE '%".$q."%')");
  }
  else {
    $count = $db->query("SELECT COUNT(*) AS count FROM torrents WHERE (torrent_hash is not null AND category_id = ".substr($c,0,1)." AND sub_category_id = ".substr($c,2,2)." AND torrent_name LIKE '%".$q."%')");
  }

  $rownum = $count->fetchArray(SQLITE3_ASSOC);

  $path = './search.php?c='.$c.'&s='.$s.'&sort='.$sort.'&order='.$order.'&max='.$max.'&q='.$q;

  $pages = round($rownum['count'] / $max);

  if ($p > $pages) {
    $p = $pages;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="./www.css">
  <title>Search - Re:Nyaa</title>
  <script>
  //<![CDATA[
  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
   // some code..
  } else {
  document.getElementById("searchbar").addEventListener("keydown", function(e) {
    if (!e) { var e = window.event; }
    e.preventDefault(); // sometimes useful

    // Enter is pressed
    if (e.keyCode == 13) { submitFunction(); }
  }, false);
}
  //]]>
  </script>
</head>

<body>
  <div id="topbar">
  <div id="navbar">
    <ul id="tabnav">
      <li><a href="#">Browse</a></li>
      <li><a href="./upload.php">Upload</a></li>
      <li><a href="./login.php">Login</a></li>
      <li><a href="./register.php">Register</a></li>
      <li><a href="./index.php">Rules/Help</a></li>
      <li><a href="https://github.com/renyaa/renyaa">Github</a></li>
      <li><a href="./rss.php" title="This link adapts to the current view.">RSS</a></li>
    </ul>
  </div>
  <form method="get" action="./search.php" accept-charset="utf-8">
    <div id="searchcontainer">
      <select name="c" class="inputsearchcategory">
        <option value="_">All categories</option>
        <option value="3_0">Anime</option>
        <option value="3_12">Anime - Anime Music Video</option>
        <option value="3_5">Anime - English-translated</option>
        <option value="3_13">Anime - Non-English-translated</option>
        <option value="3_6">Anime - Raw</option>
        <option value="2_">Audio</option>
        <option value="2_3">Audio - Lossless</option>
        <option value="2_4">Audio - Lossy</option>
        <option value="4_">Literature</option>
        <option value="4_7">Literature - English-translated</option>
        <option value="4_8">Literature - Non-English-translated</option>
        <option value="4_14">Literature - Raw</option>
        <option value="5_">Live Action</option>
        <option value="5_9">Live Action - English-translated</option>
        <option value="5_10">Live Action - Idol/Promotional Video</option>
        <option value="5_18">Live Action - Non-English-translated</option>
        <option value="5_11">Live Action - Raw</option>
        <option value="6_">Pictures</option>
        <option value="6_15">Pictures - Graphics</option>
        <option value="6_16">Pictures - Photos</option>
        <option value="1_">Software</option>
        <option value="1_1">Software - Applications</option>
        <option value="1_2">Software - Games</option>
      </select>

      <select name="s">
        <option value="">Show all</option>
        <option value="2">Filter remakes</option>
        <option value="3">Trusted only</option>
        <option value="4">A+ only</option>
      </select>
      <input id="searchbar" type="text" name="q" value="" accesskey="f" placeholder="Search..." class="inputsearchterm">
      <input type="submit" value="Search" class="inputsearchsubmit">
    </div>
  </form>
</div>

<div id="main">
  <div class="content">
    <div style="text-align:center">
      <h5>Advanced Search</h5>
      <form action="./search.php" method="get" id="advsearch" name="advsearch">
      <div>
          <select form="advsearch" name="c" class="inputsearchcategory">
            <option value="_" selected>All categories</option>
            <option value="3_">Anime</option>
            <option value="3_12">Anime - Anime Music Video</option>
            <option value="3_5">Anime - English-translated</option>
            <option value="3_13">Anime - Non-English-translated</option>
            <option value="3_6">Anime - Raw</option>
            <option value="2_">Audio</option>
            <option value="2_3">Audio - Loseless</option>
            <option value="2_4">Audio - Lossy</option>
            <option value="4_">Literature</option>
            <option value="4_7">Literature - English-translated</option>
            <option value="4_8">Literature - Raw</option>
            <option value="4_14">Literature - Non-English-translated</option>
            <option value="5_">Live Action</option>
            <option value="5_9">Live Action - English-translated</option>
            <option value="5_10">Live Action - Idol/Promotion Video</option>
            <option value="5_18">Live Action - Non-English-translated</option>
            <option value="5_11">Live Action - Raw</option>
            <option value="6_">Pictures</option>
            <option value="6_15">Pictures - Graphics</option>
            <option value="6_16">Pictures - Photos</option>
            <option value="1_">Software</option>
            <option value="1_1">Software - Applications</option>
            <option value="1_2">Software - Games</option>
          </select>

          <select form="advsearch" name="s">
            <option value="" selected>Show all</option>
            <option value="2">Filter Remakes</option>
            <option value="3">Trusted</option>
            <option value="4">A+</option>
          </select>

          <select form="advsearch" name="sort">
            <option value="torrent_id" selected>ID</option>
            <option value="torrent_name">Name</option>
            <option value="date">Date</option>
            <option value="downloads">Downloads</option>
            <option value="filesize">Size</option>
          </select>

          <select form="advsearch" name="order">
            <option value="desc" selected>Descending</option>
            <option value="asc">Ascending</option>
          </select>

          <select form="advsearch" name="max">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
            <option value="25">25</option>
            <option value="30">30</option>
            <option value="35">35</option>
            <option value="30">40</option>
            <option value="45">45</option>
            <option value="50" selected>50</option>
            <option value="70">70</option>
            <option value="100">100</option>
            <option value="150">150</option>
            <option value="200">200</option>
            <option value="300">300</option>
          </select>

          <input id="advsearchbar" type="text" name="q" style="width: 20%"></input>
          <button type="submit" class="inputsearchsubmit">Search</button>
      </div>
    </div>
    </form>
    <br><br>

  <div class="pages">
  <?php

    if($p >= 9) {
      echo '<a class="page pagelink" href="'.$path.'&p='.($p-9).'">&#60;</a>';
    }

    for($i = 1;$i < 10; $i++) {
      if ((floor(($p-1)/9)*9+$i) > $pages) {
        break;
      }
      if($p%9 == $i | $p%9 + 9 == $i) {
        echo " ".(floor(($p-1)/9)*9+$i)." ";
        continue;
      }
      echo '<a class="page pagelink" style="width: 8%" href="'.$path.'&p='.(floor(($p-1)/9)*9+$i).'">'.(floor(($p-1)/9)*9+$i).'</a>';
    }

    if((floor(($p-1)/9)*9+8) < $pages - $pages%9) {
      echo '<a class="page pagelink" style="width: 8%" href="'.$path.'&p='.($p+9).'">&#62;</a>';
    }
   ?>
      </div>

  <table id="results" class="tlist">
    <tr class="tlisthead">
      <th class="tlistthone">Category</th>
      <th class="tlistthtwo"></th>
      <th class="tlistththree">Mag</th>
      <th class="tlistsizehead">Size</th>
      <th class="tlistdate">Date</th>
    </tr>

<?php
  function FSconv($size,$unit="") {
    if( (!$unit && $size >= 1<<30) || $unit == "GB")
      return number_format($size/(1<<30),1)." GB";
    if( (!$unit && $size >= 1<<20) || $unit == "MB")
      return number_format($size/(1<<20),1)." MB";
    if( (!$unit && $size >= 1<<10) || $unit == "KB")
      return number_format($size/(1<<10),1)." KB";
    return number_format($size)." bytes";
  }

  if($c == "_" || $c == "") {
    $category_id = '';
  }
  else if (substr($c,2) == "") {
    $category_id = ' AND category_id = '.substr($c,0,1);
  }
  else {
    $category_id = ' AND sub_category_id = '.substr($c,2,2);
  }

  if($s != "" && $s != 2) {
    $status_id = ' AND status_id = '.$s;
  }
  else if ($s == 2){
    $status_id = ' AND status_id != '.$s;
  }
  @$results = $db->query("SELECT torrent_hash,torrent_id,category_id,sub_category_id,status_id,torrent_name,date,filesize FROM torrents WHERE (torrent_hash is not null".$category_id.$status_id." AND torrent_name LIKE '%".$q."%') ORDER BY torrent_id ".$order." LIMIT ".$max." OFFSET ".($max * ($p-1)));

  while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    //TODO: Add links
    $link = '<a href="magnet:?xt=urn:btih:'.$row['torrent_hash'].'&dn='.str_replace(' ', '%20', $row['torrent_name']).'&tr=udp://tracker.coppersurfer.tk:6969&tr=udp://zer0day.to:1337/announce&tr=udp://tracker.leechers-paradise.org:6969&tr=udp://explodie.org:6969&tr=udp://tracker.opentrackr.org:1337&tr=udp://tracker.internetwarriors.net:1337/announce&tr=udp://eddie4.nl:6969/announce&tr=http://mgtracker.org:6969/announce&tr=http://tracker.baka-sub.cf/announce"><img src="./www-7.png"></a>';
    $img = '<img src="img/torrents/'.$row['sub_category_id'].'.png">';

    $epoch = $row['date'];
    if($epoch == '') {
      $epoch = 0;
    }
    $date = new DateTime("@$epoch");

    $unit = "";
    $size = FSconv($row['filesize'],$unit);

    $name = '<a href="./view.php?id='.$row['torrent_id'].'">'.$row['torrent_name'].'</a>';

    switch ($row['sub_category_id']) {
      case 1:
            $txtcat = 'Software >> Applications';
            break;
      case 2:
            $txtcat = 'Software >> Games';
            break;
      case 3:
            $txtcat = 'Audio >> Loseless';
            break;
      case 4:
            $txtcat = 'Audio >> Lossy';
            break;
      case 5:
            $txtcat = 'Anime >> English-translated';
            break;
      case 6:
            $txtcat = 'Anime >> Raw';
            break;
      case 7:
            $txtcat = 'Literature >> English-translated';
            break;
      case 8:
            $txtcat = 'Literature >> Raw';
            break;
      case 9:
            $txtcat = 'Live Action >> English-translated';
            break;
      case 10:
            $txtcat = 'Live Action >> Idol/Promotion Video';
            break;
      case 11:
            $txtcat = 'Live Action >> Raw';
            break;
      case 12:
            $txtcat = 'Anime >> Non-English-translated';
            break;
      case 13:
            $txtcat = 'Anime >> Anime Music Video';
            break;
      case 14:
            $txtcat = 'Literature >> Non-English-translated';
            break;
      case 15:
            $txtcat = 'Pictures >> Graphics';
            break;
      case 16:
            $txtcat = 'Pictures >> Photos';
            break;
      case 18:
            $txtcat = 'Live Action >> Non-English-translated';
            break;
    }
    if ($row['status_id'] == 3) {
      $status = " trusted";
    }
    else if ($row['status_id'] == 4) {
      $status = " aplus";
    }
    else if ($row['status_id'] == 2) {
      $status = " remake";
    }
    else {
      $status = "";
    }
    echo '<tr class="tlistrow'.$status.'"><td class="tlisticon"><a href="./search.php?c='.$row['category_id'].'_'.$row['sub_category_id'].'" title="'.$txtcat.'">';
    echo '<img src="../../img/torrents/'.$row['sub_category_id'].'.png"></a></td>';

    echo '<td class="tlistname">'.$name.'</td>';
    echo '<td class="tlistdownload">'.$link.'</td>';
    echo '<td class="tlistsize">'.$size.'</td>';
    echo '<td class="tlistdn">'.$date->format('Y-m-d H:i').'</td></tr>';
  }
?>

</table><br><br>

  <div class="pages">
      <?php

        if($p >= 9) {
          echo '<a class="page pagelink" style="width: 8%" href="'.$path.'&p='.($p-9).'">&#60;</a>';
        }

        for($i = 1;$i < 10; $i++) {
          if ((floor(($p-1)/9)*9+$i) > $pages) {
            break;
          }
          if($p%9 == $i | $p%9 + 9 == $i) {
            echo " ".(floor(($p-1)/9)*9+$i)." ";
            continue;
          }
          echo '<a class="page pagelink" style="width: 8%" href="'.$path.'&p='.(floor(($p-1)/9)*9+$i).'">'.(floor(($p-1)/9)*9+$i).'</a>';
        }

        if((floor(($p-1)/9)*9+8) < $pages - $pages%9) {
          echo '<a class="page pagelink" style="width: 8%" href="'.$path.'&p='.($p+9).'">&#62;</a>';
        }
       ?>
  </div>

</div>
</div>
<div style="color:#ffffff;float:left;margin-bottom:6px;padding-left:10%;background:url('topbar.png') repeat-x black;width:100%;">
  <h4><a id="nostyle" href="./index.php">Re:Nyaa</a> - 2017 Re:Nyaa Team - Source available on
  <a href="https://github.com/renyaa/renyaa">GitHub</a></h4>
</div>

</body>
</html>
