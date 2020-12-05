<!-- Header -->
    <div class="header">
		<div class="logodiv">
			<a href="main.php"><img class="logo" src="bilder/logo.png" alt="Logo"></a>
		</div>
		<div class="right">
		<?php if (!isset($_SESSION['usr_name'])) { ?>
			<a href="login.php" ><button class="logout" type="button">Login</button></a>
		<?php }elseif (isset($_SESSION['usr_name'])) { ?>
			<a href="logout.php" ><button class="logout" type="button">Logout</button></a>
		<?php }; ?>
		<div id="div3" class="popup" style="display:none;"><span class="popuptext">Zum Warenkorb hinzugefügt</span></div>
<?php
		if (isset($_SESSION['usr_name'])) {
			echo "<a href='profil.php'><button class='profil' type='button'>";
				echo "<img height='25px;' src='bilder/profil.png' alt='Profil'>";
			echo "</button></a>";
		}
		
		echo "<a ";
			if (isset($_SESSION['usr_name'])) {
				echo "href='warenkorb.php'";
			} else {
				echo "href='login.php?location=ware'";
			};
		echo ">";
?>
			 

			<button <?php if (isset($_SESSION['usr_name'])) { echo "style='margin-right: 20px;'"; }else { echo "style='margin-right: 50px;'"; }; ?> class="ware" type="button">
				<img style="margin-top: -2px;" height="25px;" src="bilder/ware.png" alt="Ware">
			</button></a>
		</div>
		<div class="gopsearch">
			<img class="lupe" src="bilder/lupe.png" alt="Lupe">
<?php 
			 if (isset($_GET['suche'])) {
				  echo "<a href='main.php'><img class='reset' title='Reset' src='bilder/test.png' alt='delete'></a>";
			 };
?>
			<form name="search" method="get" action="main.php">
<?php
			 echo "<input autocomplete='off' onKeyPress='KeyCode;' class='bar' type='text' id='inputS' name='suche' placeholder='Suche...' value='";
			  if (isset($_GET['suche'])) { 
				echo "$_GET[suche]";
			  };
			  echo "' />";
			  
?>
			</form>
		</div>
	</div>