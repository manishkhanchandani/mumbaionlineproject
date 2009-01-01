<!-- menu system -->
<div id="sidetree">
	<?php if(!$_COOKIE['user_id']) { ?>
	<div id="login" style="margin-top:5px; border:solid thin green; padding:10px;">
		<h3 align="center">Login/Register</h3>
		<form id="form1" name="form1" method="post" action="<?php echo HTTPROOT; ?>/modules/users/login_process.php">
		  <p><strong>Email:</strong><br /> 
			<input name="email" type="text" id="email" value="<?php echo $_GET['email']; ?>" size="20" />
		</p>
		  <p><strong>Password:</strong><br /> 
			<input name="password" type="password" id="password" size="20" />
		</p>
		  <p>
			<input name="remember" type="checkbox" id="remember" value="1" />
		  Remember Me <br />
		  <a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/users/forgot.php','GET','', '', 'center', 'yes', '<?php echo md5("modules/users/forgot.php"); ?>', '1');">Forgot Password</a> </p>
		  <p>
			<input type="submit" name="Submit" value="Login/Register" />
		  </p>
		</form>
	</div>
	<?php } ?>
	<div class="treeheader">&nbsp;</div>
	<div id="sidetreecontrol"><a href="">Collapse All</a> | <a href="">Expand All</a></div>
	<ul id="tree">
		<li><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/home.php','GET','', '', 'center', 'yes', '<?php echo md5("home.php"); ?>', '1');"><strong>Home</strong></a></li>
		<li><a href="javascript:;"><strong>Users</strong></a>
			<ul>
				<?php if(!$_COOKIE['user_id']) { ?>
				<li><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/users/login.php','GET','', '', 'center', 'yes', '<?php echo md5("modules/users/login.php"); ?>', '1');">Login/Register</a></li>
				<li><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/users/forgot.php','GET','', '', 'center', 'yes', '<?php echo md5("modules/users/forgot.php"); ?>', '1');">Forgot Password</a></li>
				<?php } ?>
				<?php if($_COOKIE['user_id']) { ?>
				<!--<li><a href="<?php echo $base; ?>index.php/users/change">Change Password</a></li>-->
				<li><a href="<?php echo HTTPROOT; ?>/modules/users/logout.php">Logout</a></li>
				<?php } ?>
			</ul>
		</li>
		<?php if($_COOKIE['user_id']) { ?>
		<li><a href="javascript:;"><strong>Rate My Qualities</strong></a>
			<ul>
				<li><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/ratemyquality/manage_qualities.php','GET','', '', 'center', 'yes', '<?php echo md5("modules/ratemyquality/manage_qualities.php"); ?>', '1');">Manage Qualities</a></li>
				<li><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/ratemyquality/manage_profile.php','GET','', '', 'center', 'yes', '<?php echo md5("modules/ratemyquality/manage_profile.php"); ?>', '1');">Manage Profile</a></li>
			</ul>
		</li>
		<?php } ?>
		<li><a href="javascript:;"><strong>Utilities</strong></a>
			<ul>
				<li><a href="javascript:;"><strong>History</strong></a>
					<ul>
						<li><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/history/view.php','GET','', '', 'center', 'yes', '<?php echo md5("modules/history/view.php"); ?>', '1');">View History</a></li>
						<?php if($_COOKIE['user_id']) { ?>
						<li><a href="#" onclick="newHistory('<?php echo md5("modules/history/new.php"); ?>', 'GET', '', '1');">Add New History</a></li>
						<li><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/history/myhistory.php','GET','', '', 'center', 'yes', '<?php echo md5("modules/history/myhistory.php"); ?>', '1');">My History</a></li>
						<?php } ?>
					</ul>
				</li>
				<li><a href="javascript:;"><strong>Phone Book</strong></a>
					<ul>
						<li><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/phonebook/index.php','GET','', '', 'center', 'yes', '<?php echo md5("modules/phonebook/index.php"); ?>', '1');">Public Contacts</a></li>
						<?php if($_COOKIE['user_id']) { ?>
							<li><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/phonebook/view.php','GET','', '', 'center', 'yes', '<?php echo md5("modules/phonebook/view.php"); ?>', '1');">My Contacts</a></li>
							<li><a href="#" onclick="doAjaxLoadingText('<?php echo HTTPROOT; ?>/modules/phonebook/new.php','GET','initialUrl=<?php echo HTTPROOT; ?>/modules/phonebook/view.php', '', 'center', 'yes', '<?php echo md5("modules/phonebook/new.php"); ?>', '1');">Add New Contact</a></li>
						<?php } ?>
					</ul>
				</li>
			</ul>
		</li>
		<li><a href="<?php echo HTTPROOT; ?>/keywords.php"><strong>Minisite</strong></a>
			<?php 
			$newsMenu = $common->getRandomKeywords();
			echo $newsMenu;
			/*
			$tmp = "menu_Minisite";
			$newsMenu = checkcache($tmp, -300);
			if($newsMenu) {
				echo $newsMenu;
			} else {
				$newsMenu = $common->getRandomKeywords();
				cachefunction($tmp, $newsMenu);
				echo $newsMenu;
			}
			*/
			?>
		</li>
		<!--
		<li><a href="javascript:;"><strong>Business Directory</strong></a>
			<ul>
				<li><a href="javascript:alert('Under Construction');">Search</a></li>
				<li><a href="javascript:alert('Under Construction');">Browse</a></li>
				<li><a href="javascript:alert('Under Construction');">Add Listing</a></li>
				<li><a href="javascript:alert('Under Construction');">Manage Listing</a></li>
				<li><a href="javascript:alert('Under Construction');">Inbox</a></li>
				<li><a href="javascript:alert('Under Construction');">Sent Messages</a></li>
			</ul>
		</li>
		<li><a href="javascript:;"><strong>Products</strong></a>
			<ul>
				<li><a href="javascript:alert('Under Construction');">Search</a></li>
				<li><a href="javascript:alert('Under Construction');">Browse</a></li>
				<li><a href="javascript:alert('Under Construction');">My Wishlist</a></li>
				<li><a href="javascript:alert('Under Construction');">Add Product</a></li>
				<li><a href="javascript:alert('Under Construction');">Manage Product</a></li>
				<li><a href="javascript:alert('Under Construction');">Manage Price</a></li>
				<li><a href="javascript:alert('Under Construction');">Inbox</a></li>
				<li><a href="javascript:alert('Under Construction');">Sent Messages</a></li>
			</ul>
		</li>
		<li><a href="javascript:scroll(0,0);"><strong>Categories</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Restaurants</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Hotels</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Real Estate</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Automobiles</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Jobs</strong></a></li>
		<li><a href="javascript:scroll(0,0)scroll(0,0);"><strong>Matrimonial</strong></a></li>
		<li><a href="javascript:;"><strong>Frienship</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Video Tutorials</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Appointments</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Doctors</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Hospitals</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Schools</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Colleges</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Accounts</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Home Management</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Income/Expenses</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Email/Sms Reminder</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Birthdate Reminder</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Events</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Polls</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Email Management</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>FTP Management</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Downtimealert</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Rate My Pic</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Rate Me</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Classifieds</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Advertisements</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>News</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Forums</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Guest Book</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Blogs</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Family Tree</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Currency Convertor</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Weather Report</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Notes</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Address Book</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Link Bookmarks</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Share Documents</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Upload Document</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Upload Images</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Music Mania</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Videos</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Online Chess</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Auctions</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Minimum Bid Auctions</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Maximum Bid Auctions</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Freelancers</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Work For Me</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Barter Transactions</strong></a></li>
		<li><a href="javascript:scroll(0,0);"><strong>Legal Advisor</strong></a></li>
		-->
	</ul>
</div>
<!-- menu system ends -->