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

  $db = new SQLite3('nyaa.db');

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

  $path = 'search.php?c='.$c.'&s='.$s.'&sort='.$sort.'&order='.$order.'&max='.$max.'&q='.$q;

  $pages = round($rownum['count'] / $max);

  if ($p > $pages) {
    $p = $pages;
  }
?>

<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/materialize.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <title>Search - Re:Nyaa</title>
  <script>
  //<![CDATA[
  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
   // some code..
  } else
  {
  //Now include js files

  function showmenu() {
    $('.button-collapse').sideNav('show');
  }

  window.onload=function(){
    $('.button-collapse').sideNav({
      menuWidth: 300, // Default is 240
      closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
      }
    );
    $('.collapsible').collapsible();
    $('#searchbar').blur(function() {
      $('#searchbar').hide();
      $('#search-container').animate({ "width": "0px" }, 500, function(){
        $('#showall-btn').fadeIn(100);
        $('#catagories-btn').fadeIn(100);
        $('#login-btn').fadeIn(100);
      });
    });
    $('select').material_select();
  }

  function clicksearch(){
    $('#showall-btn').fadeOut(100);
    $('#login-btn').fadeOut(100);
    $('#catagories-btn').fadeOut(100 , function() {
      $('#search-container').animate({ "width": "250px" }, 500, function(){
        $('#searchbar').show();
        $('#searchbar').focus();
      });
    });
    }

  document.getElementById("searchbar").addEventListener("keydown", function(e) {
    if (!e) { var e = window.event; }
    e.preventDefault(); // sometimes useful

    // Enter is pressed
    if (e.keyCode == 13) { submitFunction(); }
  }, false);
}
  //]]>
  </script>

  <style>
  #searchbar {
    width: 170px;
  }
  </style>
</head>

<body>
  <nav>
    <ul id="slide-out" class="side-nav">
      <li><div class="userView">
        <div class="background">
          <img src="http://materializecss.com/images/office.jpg">
        </div>
        <h4>Categories</h4>
        <hr style="height:10px; visibility:hidden;" />
      </div></li>
      <li><a href="search.php?c=_">All Categories</a></li>
      <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Anime<i class="material-icons">arrow_drop_down</i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="search.php?c=3_">All Anime</a></li>
                <li><a href="search.php?c=3_12">Anime Music Videos</a></li>
                <li><a href="search.php?c=3_5">English-translated</a></li>
                <li><a href="search.php?c=3_13">Non-English-translated</a></li>
                <li><a href="search.php?c=3_6">Raw</a></li>
              </ul>
            </div>
          </li>

          <li>
            <a class="collapsible-header">Audio<i class="material-icons">arrow_drop_down</i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="search.php?c=2_">All Audio</a></li>
                <li><a href="search.php?c=2_3">Lossless</a></li>
                <li><a href="search.php?c=2_4">Lossy</a></li>
              </ul>
            </div>
          </li>

          <li>
            <a class="collapsible-header">Literature<i class="material-icons">arrow_drop_down</i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="search.php?c=4_">All Literature</a></li>
                <li><a href="search.php?c=4_7">English-translated</a></li>
                <li><a href="search.php?c=4_8">Raw</a></li>
                <li><a href="search.php?c=4_14">Non-English-translated</a></li>
              </ul>
            </div>
          </li>

          <li>
            <a class="collapsible-header">Live Action<i class="material-icons">arrow_drop_down</i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="search.php?c=5_">All Live Action</a></li>
                <li><a href="search.php?c=5_9">English-translated</a></li>
                <li><a href="search.php?c=5_10">Idol/Promotion Video</a></li>
                <li><a href="search.php?c=5_18">Non-English-translated</a></li>
                <li><a href="search.php?c=5_11">Raw</a></li>
              </ul>
            </div>
          </li>

          <li>
            <a class="collapsible-header">Pictures<i class="material-icons">arrow_drop_down</i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="search.php?c=6_">All Pictures</a></li>
                <li><a href="search.php?c=6_15">Graphics</a></li>
                <li><a href="search.php?c=6_16">Photos</a></li>
              </ul>
            </div>
          </li>

          <li>
            <a class="collapsible-header">Software<i class="material-icons">arrow_drop_down</i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="search.php?c=1_">All Software</a></li>
                <li><a href="search.php?c=1_1">Applications</a></li>
                <li><a href="search.php?c=1_2">Games</a></li>
              </ul>
            </div>
          </li>

        </ul>
      </li>
    </ul>

    <div class="nav-wrapper">
      <ul class="hide-on-med-and-down">
        <li><a onclick="showmenu()"><i class="material-icons">menu</i></a></li>
      </ul>
        <a href="index.php" class="brand-logo">Re:Nyaa</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a id="login-btn" href="user/login.php">Login</a></li>
        <li><a id="showall-btn" href="search.php?c=_">View All</a></li>
        <li><a href="#" data-activates="slide-out" class="btn button-collapse"></a></li>
        <li><a id="catagories-btn" href="#" onclick="showmenu()">Categories</a></li>
        <li><a href="#" onclick="clicksearch()"><i class="material-icons prefix">search</i></a></li>
          <div id="search-container">
            <form action="search.php" method="GET">
              <input id="searchbar" type="text" name="q" placeholder="Search..." style="display:none">
            </form>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container">
      <h5>Advanced Search</h5>
    <div class="divider"></div>
    <form action="search.php" method="get" id="advsearch" name="advsearch">

      <div class="row">

        <div class="input-field col s12 m3 xl3">
          <select form="advsearch" name="c" class="browser-default">
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
        </div>

        <div class="input-field col s6 m2 xl2">
          <select class="browser-default" form="advsearch" name="s">
            <option value="" selected>Show all</option>
            <option value="2">Filter Remakes</option>
            <option value="3">Trusted</option>
            <option value="4">A+</option>
          </select>
        </div>

        <div class="input-field col s6 m1 xl1">
          <select class="browser-default" form="advsearch" name="sort">
            <option value="torrent_id" selected>ID</option>
            <option value="torrent_name">Name</option>
            <option value="date">Date</option>
            <option value="downloads">Downloads</option>
            <option value="filesize">Size</option>
          </select>
        </div>

        <div class="input-field col s6 m2 xl2">
          <select class="browser-default" form="advsearch" name="order">
            <option value="desc" selected>Descending</option>
            <option value="asc">Ascending</option>
          </select>
        </div>

        <div class="input-field col s6 m1 xl1">
          <select class="browser-default" form="advsearch" name="max">
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
        </div>

        <div class="input-field col s6 m3 xl3">
          <input id="advsearchbar" type="text" name="q" style="width: 70%"></input>
          <label for="advsearchbar">Search...</label>
          <button type="submit" class="btn-floating"><i class="material-icons">search</i></button>
      </div>

    </form>
  </div>
</div>

<div class="container">
  <div class="row">
  <?php

    if($p >= 9) {
      echo '<div class="col s1"><a class="btn green" style="width: 8%" href="'.$path.'&p='.($p-9).'">&#60;</a></div>';
    }

    for($i = 1;$i < 10; $i++) {
      if ((floor(($p-1)/9)*9+$i) > $pages) {
        break;
      }
      if($p%9 == $i | $p%9 + 9 == $i) {
        $color = 'red';
      }
      else {
        $color = ' ';
      }
      echo '<div class="col s1"><a class="btn '.$color.'" style="width: 8%" href="'.$path.'&p='.(floor(($p-1)/9)*9+$i).'">'.(floor(($p-1)/9)*9+$i).'</a></div>';
    }

    if((floor(($p-1)/9)*9+8) < $pages - $pages%9) {
      echo '<div class="col s1"><a class="btn green" style="width: 8%" href="'.$path.'&p='.($p+9).'">&#62;</a></div>';
    }
   ?>
      </div>
    </div>

<div style="width: 90%; margin-left: 5%">
  <table class="bordered responsive-table">
        <thead>
          <tr>
              <th>Category</th>
              <th style="width: 60%">Name</th>
              <th style="width: 15%">Date</th>
              <th>Size</th>
              <th>Links</th>
          </tr>
        </thead>
        <tbody>

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

  if($c == "_" | $c == "") {
    $results = $db->query("SELECT torrent_hash,torrent_id,category_id,sub_category_id,status_id,torrent_name,date,filesize FROM torrents WHERE (torrent_hash is not null AND torrent_name LIKE '%".$q."%') ORDER BY torrent_id ".$order." LIMIT ".$max." OFFSET ".($max * $p));
  }
  else if (substr($c,2) == ""){
    $results = $db->query("SELECT torrent_hash,torrent_id,category_id,sub_category_id,status_id,torrent_name,date,filesize FROM torrents WHERE (torrent_hash is not null AND category_id = ".substr($c,0,1)." AND torrent_name LIKE '%".$q."%') ORDER BY torrent_id ".$order." LIMIT ".$max." OFFSET ".($max * $p-1));
  }
  else {
    $results = $db->query("SELECT torrent_hash,torrent_id,category_id,sub_category_id,status_id,torrent_name,date,filesize FROM torrents WHERE (torrent_hash is not null AND category_id = ".substr($c,0,1)." AND sub_category_id = ".substr($c,2,2)." AND torrent_name LIKE '%".$q."%') ORDER BY torrent_id ".$order." LIMIT ".$max." OFFSET ".($max * $p));
  }

  while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    //TODO: Add links
    $link = '<a href="magnet:?xt=urn:btih:'.$row['torrent_hash'].'&dn='.str_replace(' ', '%20', $row['torrent_name']).'&tr=udp://tracker.coppersurfer.tk:6969&tr=udp://zer0day.to:1337/announce&tr=udp://tracker.leechers-paradise.org:6969&tr=udp://explodie.org:6969&tr=udp://tracker.opentrackr.org:1337&tr=udp://tracker.internetwarriors.net:1337/announce&tr=udp://eddie4.nl:6969/announce&tr=http://mgtracker.org:6969/announce&tr=http://tracker.baka-sub.cf/announce"><img src="img/magnet.png"></a>';
    $img = '<img src="img/torrents/'.$row['sub_category_id'].'.png">';

    $epoch = $row['date'];
    $date = new DateTime("@$epoch");

    $unit = "";
    $size = FSconv($row['filesize'],$unit);

    $name = '<a href="view.php?id='.$row['torrent_id'].'">'.$row['torrent_name'].'</a>';

    echo '<tr><td>'.$img.'</td><td>'.$name.'</td><td>'.$date->format('Y-m-d H:i').'</td><td>'.$size.'</td><td>'.$link.'</td></tr>';
  }
?>

  </tbody>
</table><br><br>

  <div class="container">
    <div class="row">
      <?php

        if($p >= 9) {
          echo '<div class="col s1"><a class="btn green" style="width: 8%" href="'.$path.'&p='.($p-9).'">&#60;</a></div>';
        }

        for($i = 1;$i < 10; $i++) {
          if ((floor(($p-1)/9)*9+$i) > $pages) {
            break;
          }
          if($p%9 == $i | $p%9 + 9 == $i) {
            $color = 'red';
          }
          else {
            $color = ' ';
          }
          echo '<div class="col s1"><a class="btn '.$color.'" style="width: 8%" href="'.$path.'&p='.(floor(($p-1)/9)*9+$i).'">'.(floor(($p-1)/9)*9+$i).'</a></div>';
        }

        if((floor(($p-1)/9)*9+8) < $pages - $pages%9) {
          echo '<div class="col s1"><a class="btn green" style="width: 8%" href="'.$path.'&p='.($p+9).'">&#62;</a></div>';
        }
       ?>
    </div>
  </div>

</div>
<div class="section"></div>

<footer class="page-footer">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <h5 class="white-text">Re:Nyaa</h5>
                <p class="grey-text text-lighten-4">A public library of anime-related media, from one generation to the next.</p>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2017 Re:Nyaa Team - Source available on
            <a href="https://github.com/renyaa/renyaa">GitHub</a>
            <a class="grey-text text-lighten-4 right" href="./index.php">Home</a>
            </div>
          </div>
        </footer>

</body>
</html>
