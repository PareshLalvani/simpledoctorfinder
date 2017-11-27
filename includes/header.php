<?php
//	session_start();
?>

<body>
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="index.html">Side Bar Menu</a></h1>
<!--            <h2 class="section_title">Dashboard</h2><div class="btn_view_site"><a href="http://www.medialoot.com">View Site</a></div> -->
			<h2 class="section_title">DoctorFinder</h2><div class="btn_view_site"><a href="logout.php">Sign Out</a></div>
		</hgroup>
	</header> <!-- end of header bar -->
    	<section id="secondary_bar">
<div class="<?php if (($_SESSION['logintype'] == "User") && ($_SESSION['prefix_cd'] == 1)){echo "userum";} else if (($_SESSION['logintype'] == "User") && ($_SESSION['prefix_cd'] !== 1)){echo"useruf";}else if (($_SESSION['logintype'] == "Admin") && ($_SESSION['prefix_cd'] == 1)){echo"userum";}else if (($_SESSION['logintype'] == "Admin") && ($_SESSION['prefix_cd'] !== 1)){echo"useruf";}else if (($_SESSION['logintype'] == "Dr. ") && ($_SESSION['prefix_cd'] == 1)){echo"userdm";}else if (($_SESSION['logintype'] == "Dr. ") && ($_SESSION['prefix_cd'] !== 1)){echo"userdf";}else {echo"user";}?>">

<?php if(isset($_SESSION['loggedkey']) && $_SESSION['loggedkey'] == 'yes'){echo '<p><a href="#"> Welcome ('.$_SESSION['logintype'].' '.$_SESSION['username'].')</a></p>';}else {echo '<p><a href="#"> Welcome (Guest)'.'</a></p>';}?>
			<!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
		</div>

		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><a href="index.html">Website Admin</a> <div class="breadcrumb_divider"></div> <a class="current">Dashboard</a></article>
		</div>
	</section><!-- end of secondary bar -->
</body>
</html>