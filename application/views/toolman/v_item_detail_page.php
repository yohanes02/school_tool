<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Detail Item</div>
				<form action="<?= base_url() ?>toolman/editData" method="post">
					<div class="row">
						<div class="col-lg-3">
							<div class="mb-3">
								<label for="floatingInput">Kode Barang</label>
								<input type="text" class="form-control form-control-lg" id="floatingInput" placeholder="toolcode" name="toolcode" value="<?= $toolDetail['tool_code'] ?>" disabled>
							</div>
						</div>
						<div class="col-lg-9">
							<div class="mb-3">
								<label for="floatingInput">Nama Barang</label>
								<input type="text" class="form-control form-control-lg" id="floatingInput" placeholder="toolname" name="toolname" value="<?= $toolDetail['tool_name'] ?>">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="mb-3">
								<label for="floatingInput">Jumlah Barang</label>
								<input type="number" class="form-control form-control-lg" id="floatingInput" placeholder="quantityitem" name="quantityitem" value="<?= $toolDetail['quantity'] ?>">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="mb-3">
								<label for="floatingInput">Barang Available</label>
								<input type="number" class="form-control form-control-lg" id="floatingInput" placeholder="availableitem" name="availableitem" value="<?= $toolDetail['available'] ?>">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="mb-3">
								<label for="floatingInput">Barang Rusak</label>
								<input type="number" class="form-control form-control-lg" id="floatingInput" placeholder="brokenitem" name="brokenitem" value="<?= $toolDetail['broken'] ?>">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="mb-3">
								<label for="">Keterangan</label>
								<textarea type="text" class="form-control" placeholder="" name="information" style="height: 100px;"><?php echo $toolDetail['information'] ?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-9"></div>
						<div class="col-lg-3">
							<div class="d-grid">
								<button type="submit" class="btn btn-success btn-lg">Simpan Data</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="mb-4">
			<div class="row">
				<div class="col-lg-8"></div>
				<div class="col-lg-4">
					<div class="d-grid">
						<button id="button-new-borrower" type="button" class="btn btn-info text-white">
							<i class="bi bi-plus-circle-dotted"></i> Buat Peminjaman Baru
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<div class="card-title">Form Peminjaman Barang</div>
				<div>
					<form action="<?=base_url()?>toolman/insertBorrow/<?=$toolDetail['id']?>" method="post">
						<input type="number" name="itemleftavailable" value="<?=$toolDetail['available']?>" style="display: none;">
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Kode Barang</label>
							<div class="col-lg-10">
								<input class="form-control" name="toolcodeborrow" type="text" value="<?= $toolDetail['tool_code'] ?>" style="background-color: #e9ecef;" readonly>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Nama Barang</label>
							<div class="col-lg-10">
								<input class="form-control" name="toolnameborrow" type="text" value="<?= $toolDetail['tool_name'] ?>" style="background-color: #e9ecef;" readonly>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Nama Peminjam</label>
							<div class="col-lg-10">
								<!-- <input class="form-control" name="nameborrower" type="text"> -->
								<select id="borrower-name-select" name="idborrower" class="operator form-control">
									<option value="">Select Student...</option>
									<?php foreach ($studentData as $dt) : ?>
										<option value="<?=$dt['nisn']?>"><?=$dt['first_name']?> <?=$dt['last_name']?> - <?=$dt['grade']?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Tipe Peminjam</label>
							<div class="col-lg-10">
								<select name="typeborrower" id="borrower-type-select" class="form-select">
									<option value="1">Individual</option>
									<option value="2">Kelompok</option>
									<option value="3">Kelas</option>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Jumlah Barang</label>
							<div class="col-lg-10">
								<input class="form-control" name="qtyborrow" type="number">
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Status</label>
							<div class="col-lg-10">
								<select name="statusborrow" id="statusborrow" class="form-select">
									<option value="1">Sedang Dipinjam</option>
									<option value="2">Selesai Dipinjam</option>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Keterangan</label>
							<div class="col-lg-10">
								<textarea class="form-control" name="infoborrow" id="" cols="30" rows="6"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-8"></div>
							<div class="col-lg-2">
								<div class="d-grid">
									<button class="btn btn-lg btn-outline-dark" type="submit">Cancel</button>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="d-grid">
									<button class="btn btn-lg btn-primary" type="submit">Submit</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<div class="card-title text-center">5 Histori Terakhir Peminjaman Barang</div>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Peminjam</th>
								<th>Tipe Peminjam</th>
								<th>Qty</th>
								<th>Waktu Peminjaman</th>
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
									<td><?= $dt['quantity'] ?></td>
									<td><?= $dt['time_borrow'] ?></td>
									<td>
										<?php
											if($dt['status'] == 1) echo 'Sedang Dipinjam';
											if($dt['status'] == 2) echo 'Selesai Dipinjam';
										?>
									</td>
									<td>
										<div>
											<a href="<?=base_url()?>toolman/detailBorrow/<?=$dt['id']?>">
												<button id="edit-<?=$dt['id']?>" class="btn btn-success" onclick=""> Detail Peminjaman </button>
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
