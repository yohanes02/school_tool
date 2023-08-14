<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Form Peminjaman Barang</div>
				<div>
					<form action="<?= base_url() ?>student/insertBorrow" method="post">
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Nama Tugas</label>
							<div class="col-lg-10">
								<select name="assignmentname" id="assignment-select" class="form-select" required>
									<?php foreach ($assignment_data as $assignment) : ?>
										<option value="<?= $assignment['id'] ?>_<?= $assignment['teacher_id'] ?>"><?= $assignment['title'] ?> - <?= $assignment['first_name'] ?> <?= $assignment['last_name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Tipe Peminjam</label>
							<div class="col-lg-10">
								<select name="typeborrower" id="borrower-type-select" class="form-select" required>
									<option value="1">Individual</option>
									<option value="2">Kelompok</option>
									<option value="3">Kelas</option>
								</select>
							</div>
						</div>
						<div class="col-12 mb-3">
							<label for="" class="form-label">Barang Dipinjam</label>
							<div id="parent-item-borrow">
								<input type="hidden" class="form-control" value="0" name="itemnewborrowcount" id="itemnewborrowcount">
								<div class="row" id="itemborrow0">
									<div class="col-lg-1">
										<input class="form-control text-center" type="text" id="itemborrownumber0" value="1" disabled>
									</div>
									<div class="col-lg-7">
										<select name="itemborrowname0" id="itemborrowname0" class="form-select" required>
											<?php foreach ($tool_data as $dt) : ?>
												<option value="<?= $dt['id'] ?>"><?= $dt['tool_code'] ?> - <?= $dt['tool_name'] ?> | Tersedia: <?= $dt['available'] ?></option>
											<?php endforeach; ?>
										</select>

										<!-- <input class="form-control" name="itemborrowname0" id="itemborrowname0" type="text"> -->
									</div>
									<div class="col-lg-2">
										<input class="form-control" name="itemborrowcount0" id="itemborrowcount0" type="number" required>
									</div>
									<div class="col-lg-2">
										<div class="d-grid">
											<button class="btn btn-danger" type="button" onclick="deleteElementBorrow('itemborrow0')">Hapus</button>
										</div>
									</div>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col-lg-3 mb-3">
									<button class="btn btn-info" type="button" onclick="generateInputBorrow()">
										<i class="bi bi-plus-circle-dotted"></i>
										Tambah Barang
									</button>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<label for="inputDate" class="col-sm-2 col-form-label">Estimasi Pengembalian</label>
							<div class="col-sm-10">
								<input type="datetime-local" class="form-control" name="esttimereturn">
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Keterangan</label>
							<div class="col-lg-10">
								<textarea class="form-control" name="infoborrow" id="" cols="30" rows="6"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-7"></div>
							<div class="col-lg-2">
								<a href="<?= base_url() ?>student/inOutPage">
									<div class="d-grid">
										<button class="btn btn-lg btn-outline-dark" type="button">Cancel</button>
									</div>
								</a>
							</div>
							<div class="col-lg-3">
								<div class="d-grid">
									<button class="btn btn-lg btn-primary" type="submit">Ajukan Peminjaman</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</main>
