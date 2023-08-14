<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Detail Item</div>
				<form action="<?= base_url() ?>headdiv/editItem/<?= $toolDetail['id'] ?>" method="post">
					<div class="row">
						<div class="col-lg-3">
							<div class="mb-3">
								<label for="floatingInput">Kode Barang</label>
								<input type="text" class="form-control form-control-lg" id="floatingInput" placeholder="toolcode" name="toolcode" value="<?= $toolDetail['tool_code'] ?>" disabled>
							</div>
						</div>
						<div class="col-lg-5">
							<div class="mb-3">
								<label for="floatingInput">Nama Barang</label>
								<input type="text" class="form-control form-control-lg" id="floatingInput" placeholder="toolname" name="toolname" value="<?= $toolDetail['tool_name'] ?>">
							</div>
						</div>
						<div class="col-lg-2">
							<div class="mb-2">
								<label for="borrowableSelect">Bisa Dipinjam</label>
								<select name="toolBorrowable" id="borrowableSelect" class="form-select form-select-lg" required>
									<option value="0" <?php if ($toolDetail['is_borrowable'] == 0) echo 'selected'; ?>>Tidak</option>
									<option value="1" <?php if ($toolDetail['is_borrowable'] == 1) echo 'selected'; ?>>Ya</option>
								</select>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="mb-2">
								<label for="universalSelect">Barang Universal</label>
								<select name="toolUniversal" id="universalSelect" class="form-select form-select-lg" required>
									<option value="0" <?php if ($toolDetail['is_universal'] == 0) echo 'selected'; ?>>Tidak</option>
									<option value="1" <?php if ($toolDetail['is_universal'] == 1) echo 'selected'; ?>>Ya</option>
								</select>
							</div>
						</div>
						<div id="major-row" class="pt-1 pb-1 mb-2" style="border: solid; margin-left: 10px; max-width: 98.4%; border-radius: 10px; border-width: 1px; border-color: #dee2e6; display:<?php if ($toolDetail['is_universal'] == 1) {echo 'block';} else {echo 'none';} ?>">
							<label for="" class="pb-2">Jurusan Diizinkan</label>
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="majorcb[]" id="majorcb1" value="1" <?php if (in_array("1", explode(",", $toolDetail['allowed_major']))) echo 'checked'; ?>>
											<label class="form-check-label" for="majorcb1">
												TKRO
											</label>
										</div>
									</div>
									<div class="col-lg">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="majorcb[]" id="majorcb2" value="2" <?php if (in_array("2", explode(",", $toolDetail['allowed_major']))) echo 'checked'; ?>>
											<label class="form-check-label" for="majorcb2">
												TBSM
											</label>
										</div>
									</div>
									<div class="col-lg">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="majorcb[]" id="majorcb3" value="3" <?php if (in_array("3", explode(",", $toolDetail['allowed_major']))) echo 'checked'; ?>>
											<label class="form-check-label" for="majorcb3">
												TKJ
											</label>
										</div>
									</div>
									<div class="col-lg">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="majorcb[]" id="majorcb4" value="4" <?php if (in_array("4", explode(",", $toolDetail['allowed_major']))) echo 'checked'; ?>>
											<label class="form-check-label" for="majorcb4">
												TELIND
											</label>
										</div>
									</div>
									<div class="col-lg">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="majorcb[]" id="majorcb5" value="5" <?php if (in_array("5", explode(",", $toolDetail['allowed_major']))) echo 'checked'; ?>>
											<label class="form-check-label" for="majorcb5">
												PSPT
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="mb-3">
								<label for="floatingInput">Jumlah Barang</label>
								<input type="number" class="form-control form-control-lg" id="floatingInput" placeholder="quantityitem" name="quantity" value="<?= $toolDetail['quantity'] ?>">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="mb-3">
								<label for="floatingInput">Barang Available</label>
								<input type="number" class="form-control form-control-lg" id="floatingInput" placeholder="availableitem" name="available" value="<?= $toolDetail['available'] ?>">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="mb-3">
								<label for="floatingInput">Barang Rusak</label>
								<input type="number" class="form-control form-control-lg" id="floatingInput" placeholder="brokenitem" name="broken" value="<?= $toolDetail['broken'] ?>">
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
				<div class="card mt-3">
					<div class="card-body table-border-style">
						<div class="card-title">History Peminjaman Barang Ini</div>
						<h5 class="pb-2">Barang ini sudah dipinjam sebanyak <?=count($toolHistory)?> kali</h5>
						<div class="table-responsive">
							<table class="table datatable table-striped">
								<thead>
									<tr>
										<th>No</th>
										<th>Peminjam</th>
										<th>Tipe Peminjam</th>
										<th>Qty</th>
										<th>Tgl Peminjaman</th>
										<th>Tgl Pengembalian</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 1;
									foreach ($toolHistory as $dt) : ?>
										<tr>
											<td><?= $no ?></td>
											<td><?= $dt['borrower_name'] ?></td>
											<td><?= $dt['borrower_user_type'] ?></td>
											<td><?= $dt['qty_exact'] ?></td>
											<td><?= $dt['time_borrow'] ?></td>
											<td><?= $dt['time_return'] ?></td>
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
