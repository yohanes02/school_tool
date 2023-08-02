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
								<input type="text" class="form-control form-control-lg" id="floatingInput" placeholder="toolname" name="toolname" value="<?= $toolDetail['tool_name'] ?>" disabled>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="mb-2">
								<label for="universalSelect">Barang Universal</label>
								<input type="text" class="form-control form-control-lg" id="floatingInput" placeholder="" name="" value="<?php if($toolDetail['is_universal']) { echo "Ya"; } else {echo "Tidak";} ?>" disabled>

							</div>
						</div>
						<div class="col-lg-2">
							<div class="mb-2">
								<label for="borrowableSelect">Bisa Dipinjam</label>
								<input type="text" class="form-control form-control-lg" id="floatingInput" placeholder="" name="" value="<?php if($toolDetail['is_borrowable']) { echo "Ya"; } else {echo "Tidak";} ?>" disabled>

							</div>
						</div>
						<div class="col-lg-4">
							<div class="mb-3">
								<label for="floatingInput">Jumlah Barang</label>
								<input type="number" class="form-control form-control-lg" id="floatingInput" placeholder="quantityitem" name="quantity" value="<?= $toolDetail['quantity'] ?>" disabled>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="mb-3">
								<label for="floatingInput">Barang Available</label>
								<input type="number" class="form-control form-control-lg" id="floatingInput" placeholder="availableitem" name="available" value="<?= $toolDetail['available'] ?>" disabled>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="mb-3">
								<label for="floatingInput">Barang Rusak</label>
								<input type="number" class="form-control form-control-lg" id="floatingInput" placeholder="brokenitem" name="broken" value="<?= $toolDetail['broken'] ?>" disabled>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="mb-3">
								<label for="">Keterangan</label>
								<textarea type="text" class="form-control" placeholder="" name="information" style="height: 100px;" disabled><?php echo $toolDetail['information'] ?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-9"></div>
						<div class="col-lg-3">
							<div class="d-grid">
								<a href="<?=base_url()?>/headprog"></a>
								<button type="submit" class="btn btn-secondary btn-lg">Kembali</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
</main>
