<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Form Peminjaman / Pengembalian Barang</div>
				<div>
					<form action="<?= base_url() ?>toolman/updateBorrowStatus/<?= $borrowData['id'] ?>" method="post">
						<input type="number" name="itemleftavailable" value="<?= $borrowData['available'] ?>" style="display: none;">
						<input type="number" name="itemid" value="<?= $borrowData['tool_id'] ?>" style="display: none;">
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Kode</label>
							<div class="col-lg-10">
								<input class="form-control" name="codeborrow" type="text" value="<?= $borrowData['code_borrow'] ?>" disabled>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Nama Guru</label>
							<div class="col-lg-10">
								<input class="form-control" type="text" value="<?= $borrowData['t_first_name'] ?> <?= $borrowData['t_last_name'] ?> - <?= $borrowData['major_name'] ?>" disabled>
							</div>
						</div>
						<?php if (empty($borrowData['student_nisn']) == false) : ?>
							<div class="row mb-3">
								<label for="" class="col-lg-2 col-form-label">Nama Peminjam</label>
								<div class="col-lg-10">
									<input class="form-control" name="nameborrower" type="text" value="<?= $borrowData['first_name'] ?> <?= $borrowData['last_name'] ?> - <?= $borrowData['grade'] ?>" disabled>
								</div>
							</div>
						<?php endif; ?>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Tipe Peminjam</label>
							<div class="col-lg-10">
								<select name="typeborrower" id="borrower-type-select" class="form-select" style="background-color: #e9ecef;" disabled>
									<option value="1" <?php if ($borrowData['borrower_type'] == '1') echo 'selected' ?>>Individual</option>
									<option value="2" <?php if ($borrowData['borrower_type'] == '2') echo 'selected' ?>>Kelompok</option>
									<option value="3" <?php if ($borrowData['borrower_type'] == '3') echo 'selected' ?>>Kelas</option>
									<option value="4" <?php if ($borrowData['borrower_type'] == '4') echo 'selected' ?>>Guru</option>
								</select>
							</div>
						</div>
						<div class="col-12 mb-3">
							<label for="" class="form-label">Barang Dipinjam</label>
							<div class="row">
								<div class="col-lg-1">No</div>
								<div class="col-lg-9">Nama Barang</div>
								<div class="col-lg-2">Jumlah Barang</div>
							</div>
							<?php $quantity = explode(",", $borrowData['quantity']) ?>
							<input type="hidden" class="form-control" value="<?= count($borrowData['toolDatas']) ?>" name="itemnewborrowcount" id="itemnewborrowcount">
							<?php for ($i = 0; $i < count($borrowData['toolDatas']); $i++) : ?>
								<div class="mb-3">
									<div class="row">
										<div class="col-lg-1">
											<input class="form-control text-center" type="text" value="<?= $i + 1 ?>" disabled>
										</div>
										<div class="col-lg-9">
											<input type="hidden" name="itemborrowname<?= $i ?>" value="<?= $borrowData['toolDatas'][$i]['id'] ?>">
											<input class="form-control" type="text" value="<?= $borrowData['toolDatas'][$i]['tool_name'] ?>" readonly>
										</div>
										<div class="col-lg-2">
											<input class="form-control" type="number" name="itemborrowcount<?= $i ?>" value="<?= $quantity[$i] ?>" readonly>
										</div>
									</div>
								</div>
							<?php endfor; ?>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Keterangan</label>
							<div class="col-lg-10">
								<textarea class="form-control" name="infoborrow" id="" cols="30" rows="6" disabled><?= $borrowData['information_student'] ?></textarea>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Konfirmasi Status</label>
							<div class="col-lg-10">
								<?php if ($borrowData['borrow_accepted'] == "0") : ?>
									<input class="form-control" type="text" value="Menunggu Konfirmasi" disabled>
								<?php elseif ($borrowData['borrow_accepted'] == "1") : ?>
									<input class="form-control" type="text" value="Peminjaman Disetujui" disabled>
								<?php elseif ($borrowData['borrow_accepted'] == "2") : ?>
									<input class="form-control" type="text" value="Peminjaman Ditolak" disabled>
								<?php endif; ?>
							</div>
						</div>
						<?php if ($borrowData['borrow_accepted'] == "0" && $borrowData['student_nisn'] == null) : ?>
							<div class="col-12 mt-3 p-3 bg-body-secondary">
								<h5 for="" class="form-label text-center">Konfirmasi Peminjaman</h5>
								<div class="row col-lg-12">
									<div class="col-lg-6">
										<a href="<?= base_url() ?>toolman/rejectBorrow/<?= $borrowData['id'] ?>">
											<div class="d-grid">
												<button type="button" class="btn btn-danger">Tolak</button>
											</div>
										</a>
									</div>
									<div class="col-lg-6">
										<a href="<?= base_url() ?>toolman/acceptBorrow/<?= $borrowData['id'] ?>">
											<div class="d-grid">
												<button type="button" class="btn btn-success">Setujui</button>
											</div>
										</a>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($borrowData['borrow_accepted'] == "1") : ?>
							<div class="row mb-3">
								<label for="" class="col-lg-2 col-form-label">Status</label>
								<div class="col-lg-10">
									<select name="statusborrow" id="statusborrow" class="form-select" <?php if ($borrowData['status'] == '2') echo 'disabled' ?>>
										<option value="1" <?php if ($borrowData['status'] == '1') echo 'selected' ?>>Sedang Dipinjam</option>
										<option value="2" <?php if ($borrowData['status'] == '2') echo 'selected' ?>>Selesai Dipinjam</option>
									</select>
								</div>
							</div>
							<div class="row mb-3">
								<label for="" class="col-lg-2 col-form-label">Keterangan Toolman</label>
								<div class="col-lg-10">
									<textarea class="form-control" name="infoborrowtoolman" id="" cols="30" rows="6" <?php if ($borrowData['status'] == '2') echo 'disabled' ?>><?= $borrowData['information_toolman'] ?></textarea>
								</div>
							</div>
							<div class="row mb-3">
								<label for="" class="col-lg-2 col-form-label">Waktu Peminjaman</label>
								<div class="col-lg-10">
									<input class="form-control" name="qtyborrow" type="text" value="<?= $borrowData['time_borrow'] ?>" disabled>
								</div>
							</div>
							<div class="row mb-3">
								<label for="" class="col-lg-2 col-form-label">Waktu Pengembalian</label>
								<div class="col-lg-10">
									<input class="form-control" name="qtyborrow" type="text" value="<?= $borrowData['time_return'] ?>" disabled>
								</div>
							</div>
							<div class="row" style="display: <?php if ($borrowData['status'] == '2') echo 'none' ?>">
								<div class="col-lg-8"></div>
								<div class="col-lg-2">
									<a href="<?= base_url() ?>toolman/inOutPage">
										<div class="d-grid">
											<button class="btn btn-lg btn-outline-dark" type="button">Cancel</button>
										</div>
									</a>
								</div>
								<div class="col-lg-2">
									<div class="d-grid">
										<button class="btn btn-lg btn-primary" type="submit">Submit</button>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</form>
				</div>
			</div>
		</div>
	</section>
</main>
