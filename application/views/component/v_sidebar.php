<aside id="sidebar" class="sidebar">

	<ul class="sidebar-nav" id="sidebar-nav">

		<?php if ($this->session->userdata('utype') == 1) : ?>

			<li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>toolman">
					<i class="bi bi-grid"></i>
					<span>Daftar Grup Barang</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>toolman/itemsPage">
					<i class="bi bi-grid"></i>
					<span>Daftar Barang</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>toolman">
					<i class="bi bi-grid"></i>
					<span>Daftar Barang Rusak</span>
				</a>
			</li>
			<!-- <li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>toolman/submission">
					<i class="bi bi-grid"></i>
					<span>Daftar Pengajuan Barang</span>
				</a>
			</li> -->
			<li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>toolman/inOutPage">
					<i class="bi bi-grid"></i>
					<span>Peminjaman Barang</span>
				</a>
			</li>

		<?php elseif ($this->session->userdata('utype') == 2) : ?>

			<li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>headprog">
					<i class="bi bi-grid"></i>
					<span>Daftar Barang</span>
				</a>
			</li>
			<!-- <li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>headprog/submission">
					<i class="bi bi-grid"></i>
					<span>Daftar Pengajuan Barang</span>
				</a>
			</li> -->

		<?php elseif ($this->session->userdata('utype') == 3) : ?>

			<li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>headdiv">
					<i class="bi bi-grid"></i>
					<span>Daftar Barang</span>
				</a>
			</li>
			<!-- <li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>headdiv/submission">
					<i class="bi bi-grid"></i>
					<span>Daftar Pengajuan Barang</span>
				</a>
			</li> -->

		<?php elseif ($this->session->userdata('utype') == 4) : ?>

			<li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>headschool">
					<i class="bi bi-grid"></i>
					<span>Daftar Barang</span>
				</a>
			</li>
			<!-- <li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>headschool/submission">
					<i class="bi bi-grid"></i>
					<span>Daftar Pengajuan Barang</span>
				</a>
			</li> -->

		<?php elseif ($this->session->userdata('utype') == 5) : ?>
			
			<li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>teacher">
					<i class="bi bi-grid"></i>
					<span>Daftar Barang</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>teacher/confirmation">
					<i class="bi bi-grid"></i>
					<span>Peminjaman Siswa</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>teacher/inOutPage">
					<i class="bi bi-grid"></i>
					<span>Peminjaman Sendiri</span>
				</a>
			</li>

		<?php elseif ($this->session->userdata('utype') == 6) : ?>

			<li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>student">
					<i class="bi bi-grid"></i>
					<span>Daftar Barang</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="<?= base_url() ?>student/inOutPage">
					<i class="bi bi-grid"></i>
					<span>Histori Peminjaman Barang</span>
				</a>
			</li>

		<?php endif; ?>
	</ul>

</aside><!-- End Sidebar-->
