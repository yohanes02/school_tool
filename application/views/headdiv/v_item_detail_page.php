<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Detail Item</div>
				<div class="row mb-3">
					<label class="col-lg-2 col-form-label" for="floatingInput">Kode Barang</label>
					<div class="col-lg-10">
						<input type="text" class="form-control form-control-lg" id="floatingInput" placeholder="toolcode" name="toolcode" value="<?= $toolDetail['tool_code'] ?>" disabled>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-lg-2 col-form-label" for="floatingInput">Nama Barang</label>
					<div class="col-lg-10">
						<input type="text" class="form-control form-control-lg" id="floatingInput" placeholder="toolname" name="toolname" value="<?= $toolDetail['tool_name'] ?>" disabled>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-lg-2 col-form-label" for="floatingInput">Jumlah Barang</label>
					<div class="col-lg-10">
						<input type="number" class="form-control form-control-lg" id="floatingInput" placeholder="quantityitem" name="quantityitem" value="<?= $toolDetail['quantity'] ?>" disabled>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-lg-2 col-form-label" for="floatingInput">Barang Available</label>
					<div class="col-lg-10">
						<input type="number" class="form-control form-control-lg" id="floatingInput" placeholder="availableitem" name="availableitem" value="<?= $toolDetail['available'] ?>" disabled>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-lg-2 col-form-label" for="floatingInput">Barang Rusak</label>
					<div class="col-lg-10">
						<input type="number" class="form-control form-control-lg" id="floatingInput" placeholder="brokenitem" name="brokenitem" value="<?= $toolDetail['broken'] ?>" disabled>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-lg-2 col-form-label" for="">Keterangan</label>
					<div class="col-lg-10">
						<textarea type="text" class="form-control" placeholder="" name="information" style="height: 100px;" disabled><?php echo $toolDetail['information'] ?></textarea>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
