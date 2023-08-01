<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body table-border-style">
				<div class="card-title">Konfirmasi Peminjaman Barang Siswa</div>
				<div class="table-responsive">
					<table class="table datatable table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Tipe Peminjam</th>
								<th>Tipe Barang</th>
								<th>Tgl Peminjaman</th>
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
									<td>
										<?php
										if ($dt['borrower_type'] == 1) echo 'Individual';
										if ($dt['borrower_type'] == 2) echo 'Kelompok';
										if ($dt['borrower_type'] == 3) echo 'Kelas';
										?>
									</td>
									<td><?= count(explode(",", $dt['tool_id'])) ?> Tipe</td>
									<td><?php if ($dt['time_borrow'] == null) {
												echo "-";
											} else {
												echo $dt['time_borrow'];
											} ?></td>
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
											<a href="<?= base_url() ?>teacher/detailBorrow/<?= $dt['id'] ?>">
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
