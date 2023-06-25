<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Form Peminjaman / Pengembalian Barang</div>
				<div>
					<form action="<?=base_url()?>toolman/updateReturn/<?=$borrowData['id']?>" method="post">
						<input type="number" name="itemleftavailable" value="<?=$borrowData['available']?>" style="display: none;">
						<input type="number" name="itemid" value="<?=$borrowData['tool_id']?>" style="display: none;">
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Kode Barang</label>
							<div class="col-lg-10">
								<input class="form-control" name="toolcodeborrow" type="text" value="<?= $borrowData['tool_code'] ?>" disabled>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Nama Barang</label>
							<div class="col-lg-10">
								<input class="form-control" name="toolnameborrow" type="text" value="<?= $borrowData['tool_name'] ?>" disabled>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Nama Peminjam</label>
							<div class="col-lg-10">
								<input class="form-control" name="nameborrower" type="text" value="<?=$borrowData['first_name']?> <?=$borrowData['last_name']?> - <?=$borrowData['grade']?>" disabled>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Tipe Peminjam</label>
							<div class="col-lg-10">
								<select name="typeborrower" id="borrower-type-select" class="form-select" style="background-color: #e9ecef;" disabled>
									<option value="1" <?php if($borrowData['borrower_type'] == '1') echo 'selected' ?>>Individual</option>
									<option value="2" <?php if($borrowData['borrower_type'] == '2') echo 'selected' ?>>Kelompok</option>
									<option value="3" <?php if($borrowData['borrower_type'] == '3') echo 'selected' ?>>Kelas</option>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Jumlah Barang</label>
							<div class="col-lg-10">
								<input class="form-control" name="qtyborrow" type="number" value="<?=$borrowData['quantity']?>" style="background-color: #e9ecef;" readonly>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Status</label>
							<div class="col-lg-10">
								<select name="statusborrow" id="statusborrow" class="form-select" <?php if($borrowData['status'] == '2') echo 'disabled' ?>>
									<option value="1" <?php if($borrowData['status'] == '1') echo 'selected' ?>>Sedang Dipinjam</option>
									<option value="2" <?php if($borrowData['status'] == '2') echo 'selected' ?>>Selesai Dipinjam</option>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Keterangan</label>
							<div class="col-lg-10">
								<textarea class="form-control" name="infoborrow" id="" cols="30" rows="6" <?php if($borrowData['status'] == '2') echo 'disabled' ?>><?=$borrowData['information']?></textarea>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Waktu Peminjaman</label>
							<div class="col-lg-10">
								<input class="form-control" name="qtyborrow" type="text" value="<?=$borrowData['time_borrow']?>" disabled>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Waktu Pengembalian</label>
							<div class="col-lg-10">
								<input class="form-control" name="qtyborrow" type="text" value="<?=$borrowData['time_return']?>" disabled>
							</div>
						</div>
						<div class="row" style="display: <?php if($borrowData['status'] == '2') echo 'none' ?>">
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
	</section>
</main>
