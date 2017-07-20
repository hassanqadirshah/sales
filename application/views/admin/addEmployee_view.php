<?php include 'header.php';?>
	<!-- Columns -->
	<div id="cols" class="box" style="min-height: 550px;">

		<!-- Aside (Left Column) -->
		<div id="aside" class="box">

			<div class="padding box">

				<!-- Logo (Max. width = 200px) -->
				<p id="logo"><?php foreach ($user_record as $row){ echo $row->company; }?></p>

			</div> <!-- /padding -->

			<ul class="box">
				<li><a href="#">Lorem ipsum</a></li>
				<li><a href="#">Lorem ipsum</a></li>
				<li><a href="#">Lorem ipsum</a></li>
				<li id="submenu-active"><a href="#">Active Page</a> <!-- Active -->
					<ul>
						<li><a href="#">Lorem ipsum</a></li>
						<li><a href="#">Lorem ipsum</a></li>
						<li><a href="#">Lorem ipsum</a></li>
						<li><a href="#">Lorem ipsum</a></li>
						<li><a href="#">Lorem ipsum</a></li>
					</ul>
				</li>
			</ul>

		</div> <!-- /aside -->

		<hr class="noscreen" />

		<!-- Content (Right Column) -->
		<div id="content" class="box">

			<h1>Add Emplyee</h1>

			<!-- Form -->
			<h3 class="tit">Form</h3>
			<fieldset>
				<legend>Account Information</legend>
                                <form action="<?php echo site_url() ?>/admin/add_employee_validation" method="post">
				<table class="nostyle">
<!--					<tr>
						<td style="width:70px;">Name:</td>
						<td><input type="text" size="40" name="name" class="input-text" /></td>
					</tr>-->
					<tr>
						<td>Email:</td>
						<td><input type="text" size="40" name="email" class="input-text" /></td>
					</tr>
<!--					<tr>
						<td class="va-top">Password:</td>
						<td><input type="password" size="40" name="password" class="input-text" /></td>
					</tr>
					<tr>
						<td>Gender:</td>
						<td>
							<label><input type="radio" name="gender" value="male" checked /> Male</label> &nbsp;
							<label><input type="radio" name="gender" value="female" /> Femail</label>
						</td>
					</tr>-->
					<tr>
                                            <input type="hidden" name="company" value="<?php foreach ($user_record as $row){ echo $row->company; }?>">
						<td colspan="2" class="t-right"><input type="submit" class="input-submit" value="Submit" /></td>
					</tr>
				</table>
                                </form>
			</fieldset>

		</div> <!-- /content -->

	</div> <!-- /cols -->

	<hr class="noscreen" />

	<!-- Footer -->
	<div id="footer" class="box">

		<p class="f-left">&copy; 2014 <a href="#"><?php foreach ($user_record as $row){ echo $row->company; }?></a>, All Rights Reserved &reg;</p>

		<p class="f-right">Templates by <a href="http://www.purelogics.com/">Purelogics</a></p>

	</div> <!-- /footer -->

</div> <!-- /main -->

</body>
</html>