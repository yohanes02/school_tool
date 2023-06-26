<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body table-border-style">
				<div class="card-title">Histori Peminjaman Barang</div>
				<!-- <form action="" method="post">
					<div class="row">
						<div class="col-lg-4">
							<div class="form-floating mb-2">
								<select name="toolcodeborrow" id="" class="form-select">
									<option value=""></option>
								</select>
							</div>
						</div>
					</div>
				</form> -->
				<div class="table-responsive">
					<table class="table datatable table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Peminjam</th>
								<th>Tipe Peminjam</th>
								<th>Tanggal Peminjaman</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1; foreach ($borrowingData as $dt) : ?>
								<tr style="vertical-align: middle;">
									<td><?= $no ?></td>
									<td><?=$dt['first_name']?> <?=$dt['last_name']?></td>
									<td>
										<?php
											if($dt['borrower_type'] == 1) echo 'Individual';
											if($dt['borrower_type'] == 2) echo 'Kelompok';
											if($dt['borrower_type'] == 3) echo 'Kelas';
										?>
									</td>
									<td><?= $dt['time_borrow'] ?></td>
									<td>
										<?php
											if($dt['status'] == 1) echo 'Sedang Dipinjam';
											if($dt['status'] == 2) echo 'Selesai Dipinjam';
										?>
									</td>
									<td>
										<div>
											<a href="<?=base_url()?>student/detailBorrow/<?=$dt['id']?>">
												<div class="d-grid">
													<button id="edit-<?=$dt['id']?>" class="btn btn-success" onclick=""> Detail Peminjaman </button>
												</div>
											</a>
										</div>
									</td>
								</tr>
							<?php $no++; endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</main>
