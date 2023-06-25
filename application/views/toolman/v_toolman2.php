<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Dashboard - NiceAdmin Bootstrap Template</title>
	<meta content="" name="description">
	<meta content="" name="keywords">

	<!-- Favicons -->
	<link href="<?= base_url() ?>assets/img/favicon.png" rel="icon">
	<link href="<?= base_url() ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

	<!-- Google Fonts -->
	<link href="https://fonts.gstatic.com" rel="preconnect">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

	<!-- Vendor CSS Files -->
	<link href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/vendor/simple-datatables/style.css" rel="stylesheet">

	<!-- Template Main CSS File -->
	<link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">

	<!-- =======================================================
* Template Name: NiceAdmin
* Updated: May 30 2023 with Bootstrap v5.3.0
* Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
======================================================== -->
</head>

<body>

	<!-- ======= Header ======= -->
	<header id="header" class="header fixed-top d-flex align-items-center">

		<div class="d-flex align-items-center justify-content-between">
			<a href="index.html" class="logo d-flex align-items-center">
				<img src="<?= base_url() ?>assets/img/logo.png" alt="">
				<span class="d-none d-lg-block">NiceAdmin</span>
			</a>
			<i class="bi bi-list toggle-sidebar-btn"></i>
		</div><!-- End Logo -->

		<nav class="header-nav ms-auto">
			<ul class="d-flex align-items-center">

				<li class="nav-item dropdown pe-3">

					<a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
						<span class="d-none d-md-block dropdown-toggle ps-2"><?= $user['first_name'] ?> <?= $user['last_name'] ?> - <?= $user['user_type_name'] ?></span>
					</a><!-- End Profile Iamge Icon -->

					<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
						<li class="dropdown-header">
							<h6><?= $user['first_name'] ?> <?= $user['last_name'] ?></h6>
							<span><?= $user['user_type_name'] ?></span>
						</li>
						<li>
							<hr class="dropdown-divider">
						</li>

						<!-- <li>
							<a class="dropdown-item d-flex align-items-center" href="users-profile.html">
								<i class="bi bi-person"></i>
								<span>My Profile</span>
							</a>
						</li>
						<li>
							<hr class="dropdown-divider">
						</li>

						<li>
							<a class="dropdown-item d-flex align-items-center" href="users-profile.html">
								<i class="bi bi-gear"></i>
								<span>Account Settings</span>
							</a>
						</li>
						<li>
							<hr class="dropdown-divider">
						</li>

						<li>
							<a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
								<i class="bi bi-question-circle"></i>
								<span>Need Help?</span>
							</a>
						</li>
						<li>
							<hr class="dropdown-divider">
						</li> -->

						<li>
							<a class="dropdown-item d-flex align-items-center" href="#">
								<i class="bi bi-box-arrow-right"></i>
								<span>Sign Out</span>
							</a>
						</li>

					</ul><!-- End Profile Dropdown Items -->
				</li><!-- End Profile Nav -->

			</ul>
		</nav><!-- End Icons Navigation -->

	</header><!-- End Header -->

	<!-- ======= Sidebar ======= -->
	<aside id="sidebar" class="sidebar">

		<ul class="sidebar-nav" id="sidebar-nav">

			<li class="nav-item">
				<a class="nav-link " href="toolman">
					<i class="bi bi-grid"></i>
					<span>Group Item</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="<?=base_url()?>toolman/itemsPage">
					<i class="bi bi-grid"></i>
					<span>Item List</span>
				</a>
			</li>

		</ul>

	</aside><!-- End Sidebar-->

	<main id="main" class="main">

		<section class="section dashboard">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Input Group Item</div>
					<form action="<?= base_url() ?>toolman/insertGroup" method="post">
						<div class="row">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-5">
										<div class="form-floating mb-3">
											<input type="text" class="form-control" id="floatingInput" placeholder="groupcode" name="groupcode">
											<label for="floatingInput">Group Code</label>
										</div>
									</div>
									<div class="col-lg-7">
										<div class="form-floating mb-3">
											<input type="text" class="form-control" id="floatingInput" placeholder="groupname" name="groupname">
											<label for="floatingInput">Group Name</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-9"></div>
							<div class="col-lg-3">
								<div class="d-grid">
									<button class="btn btn-lg btn-primary" type="submit">Save Group</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="card">
				<div class="card-body table-border-style">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>No</th>
									<th>Group Code</th>
									<th>Group Name</th>
									<th>Quantity Item</th>
								</tr>
							</thead>
							<tbody>
							<?php $no = 1; foreach ($group_data as $dt) : ?>
								<tr>
									<td><?=$no?></td>
									<td><?=$dt['tool_code']?></td>
									<td><?=$dt['tool_group']?></td>
									<td> - </td>
								</tr>
							<?php $no++; endforeach;
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>

	</main><!-- End #main -->


	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

	<!-- Vendor JS Files -->
	<script src="<?= base_url() ?>assets/vendor/apexcharts/apexcharts.min.js"></script>
	<script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() ?>assets/vendor/chart.js/chart.umd.js"></script>
	<script src="<?= base_url() ?>assets/vendor/echarts/echarts.min.js"></script>
	<script src="<?= base_url() ?>assets/vendor/quill/quill.min.js"></script>
	<script src="<?= base_url() ?>assets/vendor/simple-datatables/simple-datatables.js"></script>
	<script src="<?= base_url() ?>assets/vendor/tinymce/tinymce.min.js"></script>
	<script src="<?= base_url() ?>assets/vendor/php-email-form/validate.js"></script>

	<!-- Template Main JS File -->
	<script src="<?= base_url() ?>assets/js/main.js"></script>

</body>

</html>
