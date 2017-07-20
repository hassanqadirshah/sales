<?php include 'header.php';?>

	<!-- Columns -->
	<div id="cols" class="box">

		<!-- Aside (Left Column) -->
		<div id="aside" class="box">

			<div class="padding box">

				<!-- Logo (Max. width = 200px) -->
				<p id="logo"><?php foreach ($user_record as $row){ echo $row->company; }?></p>


				<?php foreach ($user_record as $row){ if($row->position == 'Administrator'){ ?>
				<!-- Add new employee -->
				<p id="btn-create" class="box"><a href="<?php echo site_url() ?>/admin/add_employee"><span>Add new Employee</span></a></p>
                                <?php } } ?>

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
		<div style="min-height: 550px;" id="content" class="box">

			<h1>Personal Information</h1>

			<!-- Table (TABLE) -->
			<h3 class="tit">Table</h3>
			<table>
                            <form id="profile_edit" action="<?php echo site_url() ?>/admin/update_employee_validation" method="post">
				<tr>
				    <th>Name</th>
				    <th>Email</th>
				    <th>Company</th>
				    <th>Gender</th>
                                    <th>Position</th>
				</tr>
                            <?php foreach ($user_record as $row){ ?>
				<tr>
                                    <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                                    <td><input type="text" name="name" value="<?php echo $row->name; ?>"></td>
				    <td><input type="text" name="email" value="<?php echo $row->email; ?>"></td>
				    <td><input type="text" name="company" value="<?php echo $row->company; ?>"></td>
				    <td><input type="text" name="gender" value="<?php echo $row->gender; ?>"></td>
                                    <td><input type="text" name="position" value="<?php echo $row->position; ?>"></td>
				</tr>
                            <?php } ?>
                            </form>
			</table>
                        <input form="profile_edit" class="input-submit" type="submit" name="update" value="Update">

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