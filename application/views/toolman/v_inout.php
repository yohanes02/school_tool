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
								<th>Kode Barang</th>
								<th>Nama Barang</th>
								<th>Nama Peminjam</th>
								<th>Tipe Peminjam</th>
								<th>Qty</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($borrowingData as $dt) : ?>
								<tr style="vertical-align: middle;">
									<td><?= $no ?></td>
									<td><?= $dt['tool_code'] ?></td>
									<td><?= $dt['tool_name'] ?></td>
									<td><?= $dt['first_name'] ?> <?= $dt['last_name'] ?></td>
									<td>
										<?php
										if ($dt['borrower_type'] == 1) echo 'Individual';
										if ($dt['borrower_type'] == 2) echo 'Kelompok';
										if ($dt['borrower_type'] == 3) echo 'Kelas';
										?>
									</td>
									<td><?= $dt['quantity'] ?></td>
									<td>
										<?php
										if ($dt['status'] == 1) echo 'Sedang Dipinjam';
										if ($dt['status'] == 2) echo 'Selesai Dipinjam';
										?>
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
