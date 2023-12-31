<main class="main" id="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Detail Pengajuan Barang</div>
				<form action="<?= base_url() ?>toolman/submitSubmission" method="POST">
					<div class="col-12 mb-3">
						<label for="" class="form-label">Judul Pengajuan</label>
						<div class="col-lg-12">
							<input class="form-control" name="titlesubmission" type="text" value="<?= $submission_data['submission_title'] ?>" disabled>
						</div>
					</div>
					<div class="col-12 mb-3">
						<label for="" class="form-label">Tipe Pengajuan</label>
						<div class="col-lg-12">
							<select name="typesubmission" id="typesubmission" class="form-select" disabled>
								<option disabled>Pilih Tipe Pengajuan</option>
								<option <?php if ($submission_data['submission_type'] == '1') echo 'selected'; ?> value="1">Bulanan</option>
								<option <?php if ($submission_data['submission_type'] == '2') echo 'selected'; ?> value="2">Random</option>
							</select>
						</div>
					</div>
					<?php if ($submission_data['submission_type'] == "1") : ?>
						<div class="col-12 mb-3" id="parentmonthsubmission">
							<label for="" class="form-label">Pengajuan Bulan</label>
							<div class="col-lg-12">
								<select name="monthsubmission" id="monthsubmission" class="form-select" disabled>
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
					<?php endif; ?>
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
								<div class="col-lg-11 mb-2">
									<?php $text = "Menambah Stok Barang";
									if ($submission_item_data[$i]['existingItem'] == "0") {
										$text = "Barang Baru";
									} ?>
									Status : <?= $text ?>
								</div>
								<div class="offset-1 col-lg-5">
									<input class="form-control" name="itemname<?= $i ?>" id="itemname<?= $i ?>" type="text" placeholder="Nama Barang" value="<?= $submission_item_data[$i]['title'] ?>" disabled>
								</div>
								<div class="col-lg-1">
									<input class="form-control" name="itemqty<?= $i ?>" id="itemqty<?= $i ?>" type="number" placeholder="Qty" onchange="generateTotal(<?= $i ?>)" value="<?= $submission_item_data[$i]['qty'] ?>" disabled>
								</div>
								<div class="col-lg-2">
									<input class="form-control" name="itemsatuan<?= $i ?>" id="itemsatuan<?= $i ?>" type="number" placeholder="Harga Satuan" onchange="generateTotal(<?= $i ?>)" value="<?= $submission_item_data[$i]['piece'] ?>" disabled>
								</div>
								<div class="col-lg-2">
									<input class="form-control bg-body-secondary" name="itemtotal<?= $i ?>" id="itemtotal<?= $i ?>" type="number" placeholder="Total Harga" value="<?= $submission_item_data[$i]['total'] ?>" disabled>
								</div>
								<label class="offset-1 mt-3 mb-1" for="">Foto Barang</label>
								<div class="col-lg-10 offset-1">
									<img src="<?= base_url() ?>assets/uploads/<?= $submission_item_data[$i]['image'] ?>" alt="" srcset="" height="80">
								</div>
								<div class="col-lg-10 offset-1 mt-3 mb-3">
									<textarea name="itemspecification<?= $i ?>" id="itemspecification<?= $i ?>" cols="30" rows="3" class="form-control" placeholder="Spesifikasi" disabled><?= $submission_item_data[$i]['specification'] ?></textarea>
								</div>
							</div>
						<?php endfor; ?>
					</div>
					<div class="row mt-3">
						<div class="col-lg-6">
							<h4 style="font-weight: bolder;">Total Harga Pengajuan</h4>
						</div>
						<div class="col-lg-6">
							<h4 style="font-weight: bolder;" id="totalpricesubmission">Rp. <?= $submission_data['price'] ?></h4>
						</div>
					</div>
					<?php if ($submission_history_data['status'] >= 2 && $submission_history_data['status'] < 4) : ?>
						<div class="col-12 mt-3 p-3 bg-body-secondary ">
							<h5 for="" class="form-label text-center">Konfirmasi Pengajuan</h5>
							<div class="row col-lg-12">
								<div class="col-lg-6">
									<a href="<?= base_url() ?>headdiv/rejectSubmission/<?= $submission_history_data['id'] ?>_<?= $submission_history_data['submission_id'] ?>">
										<div class="d-grid">
											<button type="button" class="btn btn-danger">Tolak</button>
										</div>
									</a>
								</div>
								<div class="col-lg-6">
									<a href="<?= base_url() ?>headdiv/acceptSubmission/<?= $submission_history_data['id'] ?>_<?= $submission_history_data['submission_id'] ?>">
										<div class="d-grid">
											<button type="button" class="btn btn-success">Setujui</button>
										</div>
									</a>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</form>
			</div>
		</div>
	</section>
</main>
