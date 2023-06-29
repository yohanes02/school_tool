<main class="main" id="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Detail Pengajuan Barang</div>
				<div class="row">
					<div class="row mb-3">
						<label for="" class="col-lg-2 col-form-label">Tanggal Pengajuan</label>
						<div class="col-lg-10">
							<?= $submission_data['submission_date'] ?>
						</div>
					</div>
					<div class="row mb-3">
						<label for="" class="col-lg-2 col-form-label">Tanggal Update</label>
						<div class="col-lg-10">
							<?= $submission_data['last_update'] ?>
						</div>
					</div>
					<div class="row mb-3">
						<label for="" class="col-lg-2 col-form-label">Tipe Pengajuan</label>
						<div class="col-lg-10">
							<?php if ($submission_data['submission_type'] == "1") : ?>
								Bulanan
							<?php else : ?>
								Random
							<?php endif; ?>
						</div>
					</div>
					<div class="row mb-3">
						<label for="" class="col-lg-2 col-form-label">Pengajuan Bulan</label>
						<div class="col-lg-10">
							<?php if ($submission_data['month'] == "1") echo "Januari"; ?>
							<?php if ($submission_data['month'] == "2") echo "Februari"; ?>
							<?php if ($submission_data['month'] == "3") echo "Maret"; ?>
							<?php if ($submission_data['month'] == "4") echo "April"; ?>
							<?php if ($submission_data['month'] == "5") echo "Mei"; ?>
							<?php if ($submission_data['month'] == "6") echo "Juni"; ?>
							<?php if ($submission_data['month'] == "7") echo "Juli"; ?>
							<?php if ($submission_data['month'] == "8") echo "Agustus"; ?>
							<?php if ($submission_data['month'] == "9") echo "September"; ?>
							<?php if ($submission_data['month'] == "10") echo "Oktober"; ?>
							<?php if ($submission_data['month'] == "11") echo "Novemeber"; ?>
							<?php if ($submission_data['month'] == "12") echo "Desember"; ?>
						</div>
					</div>
					<div class="row mb-3">
						<label for="" class="col-lg-2 col-form-label">Status</label>
						<div class="col-lg-10">
							<?php if ($submission_data['status'] == "0") echo "Menunggu Persetujuan KAPROG"; ?>
							<?php if ($submission_data['status'] == "1") echo "Menunggu Persetujuan KABID"; ?>
							<?php if ($submission_data['status'] == "2") echo "Menunggu Persetujuan KEPSEK"; ?>
							<?php if ($submission_data['status'] == "3") echo "Disetujui"; ?>
							<?php if ($submission_data['status'] == "4") echo "Pengajuan Ditolak (Input Kembali)"; ?>
							<?php if ($submission_data['status'] == "5") echo "Barang Sudah Sampai"; ?>
						</div>
					</div>
					<?php if ($submission_data['status'] == "3") : ?>
						<div class="col-12 mb-3 p-3 bg-body-secondary">
							<h5 for="" class="form-label text-center">Barang Sudah Sampai ?</h5>
							<a href="<?= base_url() ?>toolman/submissionItemArrived/<?= $submission_data['id'] ?>">
								<div class="d-grid">
									<button type="button" class="btn btn-success">Sudah Sampai</button>
								</div>
							</a>
						</div>
					<?php endif; ?>
				</div>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr class="table-secondary">
								<td class="text-center">Pengajuan Ke</td>
								<td class="text-center">Total Harga</td>
								<td class="text-center">Status</td>
								<td class="text-center">Aksi</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php $no = count($submission_history);
								foreach ($submission_history as $dt) : ?>
							<tr>
								<td class="text-center"><?= $no ?></td>
								<td class="text-center"><?= $dt['price'] ?></td>
								<td class="text-center">
									<?php if ($dt['status'] == "0") echo "Menunggu Validasi"; ?>
									<?php if ($dt['status'] == "1") echo "Ditolak KAPROG"; ?>
									<?php if ($dt['status'] == "2") echo "Disetujui KAPROG"; ?>
									<?php if ($dt['status'] == "3") echo "Ditolak KABID"; ?>
									<?php if ($dt['status'] == "4") echo "Disetujui KABID"; ?>
									<?php if ($dt['status'] == "5") echo "Ditolak KEPSEK"; ?>
									<?php if ($dt['status'] == "6") echo "Disetujui KEPSEK"; ?>
									<?php if ($dt['status'] == "7") echo "Selesai"; ?>
								</td>
								<td>
									<a href="<?= base_url() ?>toolman/detailHistorySubmission/<?= $dt['id'] ?>" target="_blank">
										<div class='d-grid'>
											<button id="" class="btn btn-success"> Lihat Detail </button>
										</div>
									</a>
								</td>
							</tr>
						<?php $no--;
								endforeach; ?>
						</tr>
						</tbody>
					</table>
				</div>
				<?php if ($submission_data['status'] == "4") : ?>
					<div class="bg-dark-subtle p-3">
						<div class="row mb-3">
							<div class="col-lg-12">
								<div class="d-grid">
									<button class="btn btn-info" disabled>Revisi Pengajuan</button>
								</div>
							</div>
						</div>
						<form action="<?= base_url() ?>toolman/submitSubmission" method="POST">
							<input type="hidden" value="<?= $submission_data['id'] ?>" name="submissionid" id="submissionid">
							<input type="hidden" value="<?= $submission_data['submission_revision'] ?>" name="submissionrev" id="submissionrev">
							<div class="col-12 mb-3">
								<label for="" class="form-label">Judul Pengajuan</label>
								<div class="col-lg-12">
									<input class="form-control" name="titlesubmission" type="text" value="<?= $submission_data['submission_title'] ?>">
								</div>
							</div>
							<div class="col-12 mb-3">
								<label for="" class="form-label">Tipe Pengajuan</label>
								<div class="col-lg-12">
									<select name="typesubmission" id="typesubmission" class="form-select">
										<option disabled>Pilih Tipe Pengajuan</option>
										<option <?php if ($submission_data['submission_type'] == '1') echo 'selected'; ?> value="1">Bulanan</option>
										<option <?php if ($submission_data['submission_type'] == '2') echo 'selected'; ?> value="2">Random</option>
									</select>
								</div>
							</div>
							<div class="col-12 mb-3" id="parentmonthsubmission" style="display: <?php if ($submission_data['submission_type'] == '1') {
																															echo "block";
																														} else {
																															echo "none";
																														} ?>">
								<label for="" class="form-label">Pengajuan Bulan</label>
								<div class="col-lg-12">
									<select name="monthsubmission" id="monthsubmission" class="form-select">
										<option <?php if ($submission_data['month'] == '1') echo 'selected'; ?> value="1">Januari</option>
										<option <?php if ($submission_data['month'] == '2') echo 'selected'; ?> value="2">Februari</option>
										<option <?php if ($submission_data['month'] == '3') echo 'selected'; ?> value="3">Maret</option>
										<option <?php if ($submission_data['month'] == '4') echo 'selected'; ?> value="4">April</option>
										<option <?php if ($submission_data['month'] == '5') echo 'selected'; ?> value="5">Mei</option>
										<option <?php if ($submission_data['month'] == '6') echo 'selected'; ?> value="6">Juni</option>
										<option <?php if ($submission_data['month'] == '7') echo 'selected'; ?> value="7">Juli</option>
										<option <?php if ($submission_data['month'] == '8') echo 'selected'; ?> value="8">Agustus</option>
										<option <?php if ($submission_data['month'] == '9') echo 'selected'; ?> value="9">September</option>
										<option <?php if ($submission_data['month'] == '10') echo 'selected'; ?> value="10">Oktober</option>
										<option <?php if ($submission_data['month'] == '11') echo 'selected'; ?> value="11">November</option>
										<option <?php if ($submission_data['month'] == '12') echo 'selected'; ?> value="12">Desember</option>
									</select>
								</div>
							</div>
							<div class="col-12" id="parent-list-item">
								<label for="" class="form-label">Daftar Barang</label>
								<div class="col-lg-1">
									<input type="hidden" class="form-control" value="<?= count($submission_item_data) ?>" name="itemnewcount" id="itemnewcount">
								</div>
								<?php for ($i = 0; $i < count($submission_item_data); $i++) : ?>
									<div class="row" id="itemnew<?= $i ?>">
										<div class="col-lg-1">
											<input class="form-control text-center" id="itemnumber<?= $i ?>" type="text" value="<?= $i + 1 ?>" disabled>
										</div>
										<div class="col-lg-11">
											<div class="form-check form-switch">
												<input class="form-check-input" type="checkbox" id="itemexist<?= $i ?>" name="itemexist<?= $i ?>" onchange="checkItemIsExist('itemexist<?= $i ?>', <?= $i ?>)" <?php if ($submission_item_data[$i]['existingItem'] == "1") echo "checked"; ?>>
												<label class="form-check-label" for="itemexist<?= $i ?>">Barang yang sudah ada ?</label>
											</div>
										</div>
										<?php
										$showToolGroup = "none";
										$showToolItem = "none";
										if ($submission_item_data[$i]['existingItem'] == "1") {
											$showToolItem = "block";
											$showToolGroup = "none";
										} else {
											$showToolItem = "none";
											$showToolGroup = "block";
										}
										?>
										<div class="offset-1 col-lg-10" id="itemgroup<?= $i ?>" style="display: <?= $showToolGroup ?>;">
											<div class="form-floating mb-2">
												<select name="itemgroup<?= $i ?>" class="form-select">
													<?php foreach ($item_master as $dt) : ?>
														<option value="<?= $dt['id'] ?>" <?php if ($submission_item_data[$i]['groupItemId'] == $dt['id']) echo "selected"; ?>><?= $dt['tool_group'] ?></option>
													<?php endforeach; ?>
												</select>
												<label for="itemSelect">Tool Group</label>
											</div>
										</div>
										<div class="offset-1 col-lg-10" id="itemexisting<?= $i ?>" style="display: <?= $showToolItem ?>;">
											<div class="form-floating mb-2">
												<select name="itemexisting<?= $i ?>" class="form-select" onchange="getSelectedItemExisting(<?= $i ?>)">
													<?php $j = 0;
													foreach ($tool_data as $dt) : ?>
														<option value="<?= $dt['id'] ?>" <?php if ($submission_item_data[$i]['itemId'] == $dt['id']) echo "selected"; ?>><?= $dt['tool_name'] ?></option>
													<?php $j++;
													endforeach; ?>
												</select>
												<label for="itemSelect">Tool Item</label>
											</div>
										</div>
										<div class="offset-1 col-lg-5">
											<input class="form-control" name="itemname<?= $i ?>" id="itemname<?= $i ?>" type="text" placeholder="Nama Barang" value="<?= $submission_item_data[$i]['title'] ?>">
										</div>
										<div class="col-lg-1">
											<input class="form-control" name="itemqty<?= $i ?>" id="itemqty<?= $i ?>" type="number" placeholder="Qty" onchange="generateTotal(<?= $i ?>)" value="<?= $submission_item_data[$i]['qty'] ?>">
										</div>
										<div class="col-lg-2">
											<input class="form-control" name="itemsatuan<?= $i ?>" id="itemsatuan<?= $i ?>" type="number" placeholder="Harga Satuan" onchange="generateTotal(<?= $i ?>)" value="<?= $submission_item_data[$i]['piece'] ?>">
										</div>
										<div class="col-lg-2">
											<input class="form-control bg-body-secondary" name="itemtotal<?= $i ?>" id="itemtotal<?= $i ?>" type="number" placeholder="Total Harga" value="<?= $submission_item_data[$i]['total'] ?>" readonly>
										</div>
										<div class="col-lg-1">
											<button class="btn btn-danger" onclick="deleteElement('itemnew<?= $i ?>')">Hapus</button>
										</div>
										<label class="offset-1 mt-3 mb-1" for="">Foto Barang</label>
										<div class="col-lg-10 offset-1">
											<img src="<?= base_url() ?>assets/uploads/<?= $submission_item_data[$i]['image'] ?>" alt="" srcset="" height="80">
										</div>
										<div class="col-lg-10 offset-1 mt-3 mb-3">
											<textarea name="itemspecification<?= $i ?>" id="itemspecification<?= $i ?>" cols="30" rows="3" class="form-control" placeholder="Spesifikasi"><?= $submission_item_data[$i]['specification'] ?></textarea>
										</div>
									</div>
								<?php endfor; ?>
							</div>
							<div class="col-lg-3 mt-3 mb-5">
								<button class="btn btn-info" type="button" onclick="generateInputItem()">
									<i class="bi bi-plus-circle-dotted"></i>
									Tambah Barang
								</button>
							</div>
							<div class="row mt-3 mb-3">
								<div class="col-lg-6">
									<h4 style="font-weight: bolder;">Total Harga Pengajuan</h4>
								</div>
								<div class="col-lg-6">
									<h4 style="font-weight: bolder;" id="totalpricesubmission">Rp. <?= $submission_data['price'] ?></h4>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6"></div>
								<div class="col-lg-3">
									<a href="<?= base_url() ?>toolman/submission">
										<div class="d-grid">
											<button type="button" class="btn btn-dark">Kembali</button>
										</div>
									</a>
								</div>
								<div class="col-lg-3">
									<div class="d-grid">
										<button type="submit" class="btn btn-success">Submit Pengajuan</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>
