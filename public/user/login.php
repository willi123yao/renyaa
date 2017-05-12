<?php
  session_start();
  if(isset($_SESSION['usrname'])) {
    header("Location ../index.php");
    die;
  }
?>

<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="../css/materialize.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
  <script type="text/javascript" src="../js/materialize.min.js"></script>
  <title>Login - Re:Nyaa</title>
  <script>
  //<![CDATA[
  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
   // some code..
  } else {

    function showmenu() {
      $('.button-collapse').sideNav('show');
    }

    window.onload = function(){
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
          $('#login-btn').fadeIn(100);
          $('#catagories-btn').fadeIn(100);
        });
      });
    }

    function clicksearch(){
      document.getElementById("searchbar")
        .addEventListener("keydown", function(e) {
          console.log('keydown');
          if (!e) { var e = window.event; }
          e.preventDefault(); // sometimes useful

          // Enter is pressed
          if (e.keyCode == 13) { submitFunction(); }
        }, false);

      $('#showall-btn').fadeOut(100);
      $('#login-btn').fadeOut(100);
      $('#catagories-btn').fadeOut(100 , function() {
        $('#search-container').animate({ "width": "250px" }, 500, function(){
          $('#searchbar').show();
          $('#searchbar').focus();
        });
      });
    }


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
        <a href="../index.php" class="brand-logo">Re:Nyaa</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a id="login-btn" href="#">Login</a></li>
        <li><a id="showall-btn" href="../search.php?c=_">View All</a></li>
        <li><a href="#" data-activates="slide-out" class="btn button-collapse"></a></li>
        <li><a id="catagories-btn" href="#" onclick="showmenu()">Categories</a></li>
        <li><a href="#" onclick="clicksearch()"><i class="material-icons prefix">search</i></a></li>
          <div id="search-container">
            <form action="../search.php" method="GET">
              <input id="searchbar" type="text" name="q" placeholder="Search..." style="display:none">
            </form>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <div class="section"></div>
  <main>
    <center>

      <div class="section"></div>
      <div class="section"></div>

      <div class="container">
        <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

          <h4 class="amber-text accent-4">Login</h4>

          <form action="./auth.php" class="col s12" method="post">

            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type='email' name='email' id='email' required/>
                <label for='email'>Email</label>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type='password' name='password' id='password' required/>
                <label for='password'>Password</label>
              </div>
              <label style='float: right;'>
								<a class='red-text' href='#!'><b>Forgot Password?</b></a>
							</label>
            </div>

            <br />
            <center>
              <div class='row'>
                <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect amber accent-4'>Login</button>
              </div>
            </center>
          </form>
        </div>
      </div>
      <a href="./register.php">Create account</a>
    </center>

    <div class="section"></div>
    <div class="section"></div>
	  <div class="section"></div>
  </main>
	
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
			<a class="grey-text text-lighten-4 right" href="../index.php">Home</a>
		</div>
	</div>
  </footer>

</body>
</html>
