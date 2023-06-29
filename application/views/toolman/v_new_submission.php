<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Pengajuan Pembelian Barang</div>
				<form action="<?= base_url() ?>toolman/submitSubmission" method="POST" enctype="multipart/form-data">
					<div class="col-12 mb-3">
						<label for="" class="form-label">Judul Pengajuan</label>
						<div class="col-lg-11">
							<input class="form-control" name="titlesubmission" type="text">
						</div>
					</div>
					<div class="col-12 mb-3">
						<label for="" class="form-label">Tipe Pengajuan</label>
						<div class="col-lg-11">
							<select name="typesubmission" id="typesubmission" class="form-select">
								<option selected disabled>Pilih Tipe Pengajuan</option>
								<option value="1">Bulanan</option>
								<option value="2">Random</option>
							</select>
						</div>
					</div>
					<div class="col-12 mb-3" id="parentmonthsubmission" style="display: none;">
						<label for="" class="form-label">Pengajuan Bulan</label>
						<div class="col-lg-11">
							<select name="monthsubmission" id="monthsubmission" class="form-select">
								<option value="1">Januari</option>
								<option value="2">Februari</option>
								<option value="3">Maret</option>
								<option value="4">April</option>
								<option value="5">Mei</option>
								<option value="6">Juni</option>
								<option value="7">Juli</option>
								<option value="8">Agustus</option>
								<option value="9">September</option>
								<option value="10">Oktober</option>
								<option value="11">November</option>
								<option value="12">Desember</option>
							</select>
						</div>
					</div>
					<div class="col-12" id="parent-list-item">
						<label for="" class="form-label">Daftar Barang</label>
						<div class="col-lg-1">
							<input type="hidden" class="form-control" value="0" name="itemnewcount" id="itemnewcount">
						</div>
						<div class="row" id="itemnew0">
							<div class="col-lg-1">
								<input class="form-control text-center" id="itemnumber0" type="text" value="1" disabled>
							</div>
							<div class="col-lg-11">
								<div class="form-check form-switch">
									<input class="form-check-input" type="checkbox" id="itemexist0" onchange="checkItemIsExist('itemexist0', 0)">
									<label class="form-check-label" for="itemexist0">Barang yang sudah ada ?</label>
								</div>
							</div>
							<div class="offset-1 col-lg-10" id="itemgroup0">
								<div class="form-floating mb-2">
									<select name="itemgroup0" class="form-select">
										<?php foreach ($item_master as $dt) : ?>
											<option value="<?=$dt['tool_code']?>"><?=$dt['tool_group']?></option>
										<?php endforeach; ?>
									</select>
									<label for="itemSelect">Tool Group</label>
								</div>
							</div>
							<div class="offset-1 col-lg-10" id="itemexisting0" style="display: none;">
								<div class="form-floating mb-2">
									<select name="itemexisting0" class="form-select" onchange="getSelectedItemExisting(0)">
										<?php $i = 0; foreach ($tool_data as $dt) : ?>
											<option value="<?=$dt['id']?>" <?php if($i == 0) echo "selected"; ?>><?=$dt['tool_name']?></option>
										<?php $i++; endforeach; ?>
									</select>
									<label for="itemSelect">Tool Item</label>
								</div>
							</div>
							<div class="offset-1 col-lg-5">
								<input class="form-control" name="itemname0" id="itemname0" type="text" placeholder="Nama Barang">
							</div>
							<div class="col-lg-1">
								<input class="form-control" name="itemqty0" id="itemqty0" type="number" placeholder="Qty" onchange="generateTotal(0)">
							</div>
							<div class="col-lg-2">
								<input class="form-control" name="itemsatuan0" id="itemsatuan0" type="number" placeholder="Harga Satuan" onchange="generateTotal(0)">
							</div>
							<div class="col-lg-2">
								<input class="form-control bg-body-secondary" name="itemtotal0" id="itemtotal0" type="number" placeholder="Total Harga" readonly>
							</div>
							<div class="col-lg-1">
								<button class="btn btn-danger" onclick="deleteElement('itemnew0')">Hapus</button>
							</div>
							<label class="offset-1 mt-3 mb-1" for="">Foto Barang</label>
							<div class="col-lg-10 offset-1">
								<input type="file" class="form-control" accept="image/*" name="itemimage0">
							</div>
							<div class="col-lg-10 offset-1 mt-3 mb-3">
								<textarea name="itemspecification0" id="itemspecification0" cols="30" rows="3" class="form-control" placeholder="Spesifikasi"></textarea>
							</div>
						</div>
					</div>
					<div class="col-lg-3 mt-3 mb-5">
						<button class="btn btn-info" type="button" onclick="generateInputItem()">
							<i class="bi bi-plus-circle-dotted"></i>
							Tambah Barang
						</button>
					</div>
					<div class="row mt3">
						<div class="col-lg-6">
							<h4 style="font-weight: bolder;">Total Harga Pengajuan</h4>
						</div>
						<div class="col-lg-6">
							<h4 style="font-weight: bolder;" id="totalpricesubmission"></h4>
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
		</div>
	</section>
</main>
