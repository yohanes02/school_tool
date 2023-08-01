	<!-- ======= Header ======= -->
	<header id="header" class="header fixed-top d-flex align-items-center">

		<div class="d-flex align-items-center justify-content-between">
			<a href="<?= base_url() ?>" class="logo d-flex align-items-center">
				<img src="<?= base_url() ?>assets/img/logo.png" alt="">
				<span class="d-none d-lg-block">Tool Management</span>
			</a>
			<i class="bi bi-list toggle-sidebar-btn"></i>
		</div><!-- End Logo -->

		<nav class="header-nav ms-auto">
			<ul class="d-flex align-items-center">

				<li class="nav-item dropdown pe-3">

					<a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
						<?php if($this->session->userdata('utype') == 6) : ?>
							<span class="d-none d-md-block dropdown-toggle ps-2"><?= $user['first_name'] ?> <?= $user['last_name'] ?> - <?= $user['user_type_name'] ?> - <?= $user['grade'] ?> <?= $user['abbv_major'] ?></span>
							<?php elseif($this->session->userdata('utype') == 1) : ?>
							<span class="d-none d-md-block dropdown-toggle ps-2"><?= $user['first_name'] ?> <?= $user['last_name'] ?> - <?= $user['user_type_name'] ?> <?= $user['abbv_major'] ?></span>
						<?php else : ?>
							<span class="d-none d-md-block dropdown-toggle ps-2"><?= $user['first_name'] ?> <?= $user['last_name'] ?> - <?= $user['user_type_name'] ?></span>
						<?php endif; ?>
					</a><!-- End Profile Iamge Icon -->

					<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
						<li class="dropdown-header">
							<h6><?= $user['first_name'] ?> <?= $user['last_name'] ?></h6>
						<?php if($this->session->userdata('utype') == 6) : ?>
								<span><?= $user['user_type_name'] ?> - <?= $user['grade'] ?> <?= $user['abbv_major'] ?></span>
							<?php elseif($this->session->userdata('utype') == 1) : ?>
								<span><?= $user['user_type_name'] ?> <?= $user['abbv_major'] ?></span>
						<?php else : ?>
								<span><?= $user['user_type_name'] ?></span>
						<?php endif; ?>
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
							<a class="dropdown-item d-flex align-items-center" href="<?=base_url()?>auth/logout">
								<i class="bi bi-box-arrow-right"></i>
								<span>Sign Out</span>
							</a>
						</li>

					</ul><!-- End Profile Dropdown Items -->
				</li><!-- End Profile Nav -->

			</ul>
		</nav><!-- End Icons Navigation -->

	</header><!-- End Header -->
