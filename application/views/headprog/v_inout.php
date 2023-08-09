<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Peminjaman Barang</div>
				<ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
					<li class="nav-item flex-fill" role="presentation">
						<button class="nav-link w-100 active" id="tab0" data-bs-toggle="tab" data-bs-target="#bordered-justified-0" type="button" role="tab" aria-selected="true">Student</button>
					</li>
					<li class="nav-item flex-fill" role="presentation">
						<button class="nav-link w-100" id="tab1" data-bs-toggle="tab" data-bs-target="#bordered-justified-1" type="button" role="tab" aria-selected="false">Teacher</button>
					</li>
				</ul>
				<div class="tab-content pt-2" id="borderedTabJustifiedContent">
					<div class="tab-pane fade show active" id="bordered-justified-0" role="tabpanel" aria-labelledby="tab0">
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
									foreach ($borrowingData['student'] as $dt) : ?>
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
													<a href="<?= base_url() ?>headprog/detailBorrow/<?= $dt['id'] ?>">
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
					<div class="tab-pane fade show" id="bordered-justified-1" role="tabpanel" aria-labelledby="tab1">
						<div class="table-responsive">
							<table class="table datatable table-striped">
								<thead>
									<tr>
										<th>No</th>
										<th>Kode</th>
										<th>Nama Peminjam</th>
										<th>Jurusan</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 1;
									foreach ($borrowingData['teacher'] as $dt) : ?>
										<tr style="vertical-align: middle;">
											<td><?= $no ?></td>
											<td><?= $dt['code_borrow'] ?></td>
											<td><?= $dt['first_name'] ?> <?= $dt['last_name'] ?></td>
											<td><?= $dt['major_name'] ?></td>
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
													<a href="<?= base_url() ?>headprog/detailBorrow/<?= $dt['id'] ?>">
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
			</div>
		</div>
	</section>
</main>
