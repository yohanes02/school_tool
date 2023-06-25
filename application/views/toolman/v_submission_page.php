<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Daftar Pengajuan Barang</div>
				<div class="row">
					<div class="col-lg-3 mb-3">
						<a href="<?= base_url() ?>toolman/newSubmission">
							<button class="btn btn-info">
								<i class="bi bi-plus-circle-dotted"></i>
								Tambah Pengajuan Barang
							</button>
						</a>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table datatable table-striped">
						<thead>
							<tr>
								<td>No</td>
								<td>Judul Pengajuan</td>
								<td>Harga Total</td>
								<td>Revisi</td>
								<td>Status</td>
								<td>Aksi</td>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($submission_data as $dt) : ?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $dt['submission_title'] ?></td>
									<td><?= $dt['price'] ?></td>
									<td><?= $dt['submission_revision'] ?></td>
									<td>
										<?php if ($dt['status'] == "0") echo "Menunggu Persetujuan KAPROG"; ?>
										<?php if ($dt['status'] == "1") echo "Menunggu Persetujuan KABID"; ?>
										<?php if ($dt['status'] == "2") echo "Menunggu Persetujuan KEPSEK"; ?>
										<?php if ($dt['status'] == "3") echo "Pengajuan Disetujui"; ?>
										<?php if ($dt['status'] == "4") echo "Pengajuan Ditolak (Input Kembali)"; ?>
									</td>
									<td>
										<a href="<?= base_url() ?>toolman/detailSubmission/<?=$dt['id']?>">
											<div class='d-grid'>
												<button class="btn btn-success" onclick=""> Lihat Detail </button>
											</div>
										</a>
									</td>
								</tr>
							<?php $no++;
							endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</main>
