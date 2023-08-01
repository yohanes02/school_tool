<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Detail Item</div>
				<form action="<?= base_url() ?>toolman/editItem/<?=$toolDetail['id']?>" method="post">
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
								<label for="universalSelect">Barang Universal</label>
								<select name="toolUniversal" id="universalSelect" class="form-select form-select-lg" required>
									<option value="0" <?php if($toolDetail['is_universal'] == 0) echo 'selected'; ?>>Tidak</option>
									<option value="1" <?php if($toolDetail['is_universal'] == 1) echo 'selected'; ?>>Ya</option>
								</select>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="mb-2">
								<label for="borrowableSelect">Bisa Dipinjam</label>
								<select name="toolBorrowable" id="borrowableSelect" class="form-select form-select-lg" required>
									<option value="0" <?php if($toolDetail['is_borrowable'] == 0) echo 'selected'; ?>>Tidak</option>
									<option value="1" <?php if($toolDetail['is_borrowable'] == 1) echo 'selected'; ?>>Ya</option>
								</select>
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
			</div>
		</div>
	</section>
</main>
