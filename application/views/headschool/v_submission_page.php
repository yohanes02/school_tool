<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Daftar Pengajuan Barang</div>
				<ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
					<?php for ($i = 0; $i < count($submission_datas); $i++) : ?>
						<li class="nav-item flex-fill" role="presentation">
							<button class="nav-link w-100 <?php if ($i == 0) echo 'active'; ?>" id="tab<?= $i ?>" data-bs-toggle="tab" data-bs-target="#bordered-justified-<?= $i ?>" type="button" role="tab" aria-selected="<?php if ($i == 0) {
																																																																									echo 'true';
																																																																								} else {
																																																																									echo 'false';
																																																																								} ?>"><?= $all_major[$i]['abbv_major'] ?></button>
						</li>
					<?php endfor; ?>
				</ul>
				<div class="tab-content pt-2" id="borderedTabJustifiedContent">
					<?php for ($i = 0; $i < count($submission_datas); $i++) : ?>
						<div class="tab-pane fade show <?php if ($i == 0) echo 'active'; ?>" id="bordered-justified-<?= $i ?>" role="tabpanel" aria-labelledby="tab<?= $i ?>">
							<h5 class="my-3"><?= $all_major[$i]['full_major'] ?></h5>
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
										foreach ($submission_datas[$i] as $dt) : ?>
											<tr>
												<td><?= $no ?></td>
												<td><?= $dt['submission_title'] ?></td>
												<td><?= $dt['price'] ?></td>
												<td><?= $dt['submission_revision'] ?></td>
												<td>
													<?php if ($dt['status'] == "0") echo "Menunggu Persetujuan KAPROG"; ?>
													<?php if ($dt['status'] == "1") echo "Menunggu Persetujuan KABID"; ?>
													<?php if ($dt['status'] == "2") echo "Menunggu Persetujuan KEPSEK"; ?>
													<?php if ($dt['status'] == "3") echo "Disetujui"; ?>
												</td>
												<td>
													<a href="<?= base_url() ?>headschool/detailSubmission/<?= $dt['id'] ?>">
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
					<?php endfor; ?>
				</div><!-- End Bordered Tabs Justified -->
			</div>
		</div>
	</section>
</main>
