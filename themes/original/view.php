<?php
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
  }
  else {
    header("Location: search.php?c=_");
    exit;
  }

  function FSconv($size,$unit="") {
    if( (!$unit && $size >= 1<<30) || $unit == "GB")
      return number_format($size/(1<<30),1)." GB";
    if( (!$unit && $size >= 1<<20) || $unit == "MB")
      return number_format($size/(1<<20),1)." MB";
    if( (!$unit && $size >= 1<<10) || $unit == "KB")
      return number_format($size/(1<<10),1)." KB";
    return number_format($size)." bytes";
  }

  $db = new SQLite3('../../nyaa.db');

  $results = $db->query("SELECT website_link,downloads,stardom,category_id,torrent_hash,torrent_id,sub_category_id,torrent_name,date,filesize,description,comments FROM torrents WHERE (torrent_hash is not null AND torrent_id = ".$id.")");
  $row = $results->fetchArray(SQLITE3_ASSOC);

  $epoch = $row['date'];
  if($epoch == '') {
    $epoch = 0;
  }
  $date = new DateTime("@$epoch");

  $unit = "";
  $size = FSconv($row['filesize'],$unit);

  $link = 'magnet:?xt=urn:btih:'.$row['torrent_hash'].'&dn='.str_replace(' ', '%20', $row['torrent_name']).'&tr=udp://tracker.coppersurfer.tk:6969&tr=udp://zer0day.to:1337/announce&tr=udp://tracker.leechers-paradise.org:6969&tr=udp://explodie.org:6969&tr=udp://tracker.opentrackr.org:1337&tr=udp://tracker.internetwarriors.net:1337/announce&tr=udp://eddie4.nl:6969/announce&tr=http://mgtracker.org:6969/announce&tr=http://tracker.baka-sub.cf/announce';

  switch ($row['sub_category_id']) {
    case 1:
          $sub_cat = 'Applications';
          break;
    case 2:
          $sub_cat = 'Games';
          break;
    case 3:
          $sub_cat = 'Loseless';
          break;
    case 4:
          $sub_cat = 'Lossy';
          break;
    case 5:
          $sub_cat = 'English-translated';
          break;
    case 6:
          $sub_cat = 'Raw';
          break;
    case 7:
          $sub_cat = 'English-translated';
          break;
    case 8:
          $sub_cat = 'Raw';
          break;
    case 9:
          $sub_cat = 'English-translated';
          break;
    case 10:
          $sub_cat = 'Idol/Promotion Video';
          break;
    case 11:
          $sub_cat = 'Raw';
          break;
    case 12:
          $sub_cat = 'Non-English-translated';
          break;
    case 13:
          $sub_cat = 'Anime Music Video';
          break;
    case 14:
          $sub_cat = 'Non-English-translated';
          break;
    case 15:
          $sub_cat = 'Graphics';
          break;
    case 16:
          $sub_cat = 'Photos';
          break;
    case 18:
          $sub_cat = 'Non-English-translated';
          break;
  }
  switch ($row['category_id']) {
    case 1:
          $cat = 'Software';
          break;
    case 2:
          $cat = 'Audio';
          break;
    case 3:
          $cat = 'Anime';
          break;
    case 4:
          $cat = 'Literature';
          break;
    case 5:
          $cat = 'Live Action';
          break;
    case 6:
          $cat = 'Pictures';
          break;
  };
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="./www.css">
  <title>View - Re:Nyaa</title>
<body>
  <div id="topbar">
  <div id="navbar">
    <ul id="tabnav">
      <li><a href="./search">Browse</a></li>
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
      <input type="text" name="q" value="" accesskey="f" placeholder="Search..." class="inputsearchterm">
      <input type="submit" value="Search" class="inputsearchsubmit">
    </div>
  </form>
</div>

<div id="main">
  <br>

  <div class="content">
    <div class="container">
      <table class="viewtop">
        <tr>
          <td class="viewcategory">
            <a href="search.php?c=<?php echo $row['category_id']?>_"><?php echo $cat?></a> &gt;&gt;
            <a href="search.php?c=<?php echo $row['category_id']?>_<?php echo $row['sub_category_id']?>"><?php echo $sub_cat?></a>
          </td>
          <td class="viewflagtorrent">
            <a href="report.php?id=<?php echo $row["torrent_id"]; ?>">
              <abbr title="Notify moderators of certain content">Report torrent</abbr>
            </a>
          </td>
        </tr>
      </table>

      <table class="viewtable">
        <tr>
          <th class="tname"></th>
          <th class="viewthtwo"></th>
          <th class="tname"></th>
          <th class="viewthfour"></th>
        </tr>

        <tr>
          <td class="tname">Name:</td>
          <td class="viewtorrentname"><?php echo $row['torrent_name'] ?></td>
          <td class="tname">Date:</td>
          <td class="vtop"><?php echo $date->format('Y-m-d H:i') ?></td>
        </tr>

        <tr>
          <td class="tname">Submitter:</td>
          <td>
            <a href="users.php?id=0">
              <span style="color:black;font-weight:bold;">Unknown</span>
            </a>
            [<a href="subscribe.php?id=0" class="viewilink">Subscribe</a>]
          </td>
        </tr>

        <tr>
          <td class="tname">Tracker:</td>
          <td>No tracker at the moment</td>
        </tr>

        <tr>
          <td class="tname">Information:</td>
          <td><a href="<?php
          if($row['website_link'] == ''){echo '#';}else{echo $row['website_link'];}?>" rel="nofollow"><?php if($row['website_link'] == '') {echo 'None';}else echo $row['website_link'] ?></a></td>
          <td class="tname">Downloads:</td>
          <td class="vtop"><span class="viewdn"><?php if($row['downloads'] == '') {echo '0';}else echo $row['downloads'] ?></span></td>
        </tr>
        <tr>
          <td class="tname">Stardom:</td>
          <td><b>
            <?php
              if ($row['stardom'] < 0 || $row['stardom'] == '') {
                $row['stardom'] = 0;
              }
              echo $row['stardom'];
            ?>
            </b> fan(s).</td>
          <td class="tname">File size:</td>
          <td class="vtop"><?php echo $size ?></td>
        </tr>
      </table>

      <div class="viewdownloadbutton">
        <a href="<?php echo $link ?>" rel="nofollow">
          <img src="./www-8.png" alt="Download">
        </a>
      </div>

      <div style="float:right;clear:right;">
        <b><a href="https://www.vuze.com/" target="_blank" rel="nofollow">Vuze</a></b>
         with the Mainline DHT plugin is the recommended client.
       </div>

       <div style="float:right;clear:right;">
         <a href="#" class="eyecatch" target="_blank" rel="nofollow">Playback help is NOT here.</a>
       </div>

       <h3 style="clear:both;padding-top:10px;">Torrent description:</h3>
       <?php
        if($row['description'] == '') {
          $row['description'] = '<div class="viewdescription">None</div>';
        }
        echo $row['description'];
      ?>
       <h3>Files in torrent:</h3>
       [<a href="showfiles.php?id=<?php echo $row['torrent_id'] ?>" class="viewilink" rel="nofollow">Show files</a>]
       <br>

       <h3>User comments:</h3>
       [<a href="subscribe.php?id=<?php echo $row['torrent_id'] ?>" class="viewilink">Subscribe</a>]
       <br><br>
       No user comments have been posted.<br>
       <h3>Post a comment:</h3>
       W.I.P<br>
       </div>

   </div>

 </div>
 <div style="color:#ffffff;float:left;margin-bottom:6px;padding-left:10%;background:url('topbar.png') repeat-x black;width:100%;">
   <h4><a id="nostyle" href="./index.php">Re:Nyaa</a> - 2017 Re:Nyaa Team - Source available on
   <a href="https://github.com/renyaa/renyaa">GitHub</a></h4>
 </div>

</body>
</html>
