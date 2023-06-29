<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body table-border-style">
				<div class="card-title">Peminjaman Barang</div>
				<div class="row">
					<div class="col-lg-3 mb-3">
						<a href="<?= base_url() ?>toolman/newBorrow">
							<button class="btn btn-info">
								<i class="bi bi-plus-circle-dotted"></i>
								Tambah Peminjaman Barang
							</button>
						</a>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table datatable table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Nama Peminjam</th>
								<th>Tingkat</th>
								<!-- <th>Tipe Peminjam</th> -->
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($borrowingData as $dt) : ?>
								<tr style="vertical-align: middle;">
									<td><?= $no ?></td>
									<td><?= $dt['code_borrow'] ?></td>
									<td><?= $dt['first_name'] ?> <?= $dt['last_name'] ?></td>
									<td><?= $dt['grade'] ?></td>
									<td>
										<?php if ($dt['borrow_accepted'] == "0" && $dt['status'] == "0") : ?>
											Menunggu Konfirmasi
										<?php elseif ($dt['borrow_accepted'] == "1" && $dt['status'] == "0") : ?>
											Peminjaman Disetujui
										<?php elseif ($dt['borrow_accepted'] == "2" && $dt['status'] == "0") : ?>
											Peminjaman Ditolak
										<?php elseif ($dt['status'] == "1") : ?>
											Sedang Dipinjam
										<?php elseif ($dt['status'] == "2") : ?>
											Selesai Dipinjam
										<?php endif; ?>
									</td>
									<td>
										<div>
											<a href="<?= base_url() ?>toolman/detailBorrow/<?= $dt['id'] ?>">
												<div class="d-grid">
													<button id="edit-<?= $dt['id'] ?>" class="btn btn-success" onclick=""> Detail Peminjaman </button>
												</div>
											</a>
										</div>
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
