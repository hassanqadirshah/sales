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

			<h1>Employee Information</h1>

			<!-- Table (TABLE) -->
			<h3 class="tit">Table</h3>
			<table>
				<tr>
				    <th>Name</th>
				    <th>Email</th>
				    <th>Company</th>
				    <th>Gender</th>
                                    <th>Position</th>
                                    <th>Action</th>
				</tr>
                            <?php foreach ($employee_record as $row){ ?>
				<tr>
				    <td><?php echo $row->name; ?></td>
				    <td><?php echo $row->email; ?></td>
				    <td><?php echo $row->company; ?></td>
				    <td><?php echo $row->gender; ?></td>
                                    <td><?php echo $row->position; ?></td>
                                    <td class="action">
                                        <div style="margin-left: 5px;">
                                        <div style="float: left;">
                                        <form action="<?php echo site_url() ?>/admin/edit_employee" method="post">
                                        <input type="hidden" name="id" value="<?php echo $row->id ?>">
                                        <input type="submit" name="employee" value="Edit">
                                        </form>
                                        </div>
                                        <div style="float: left;">
                                        <form action="<?php echo site_url() ?>/admin/delete_employee" method="post">
                                        <input type="hidden" name="id" value="<?php echo $row->id ?>">
                                        <input type="submit" name="employee" value="Delete">
                                        </form>
                                        </div>
                                        </div>
                                    </td>
				</tr>
                            <?php } ?>
			</table>

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