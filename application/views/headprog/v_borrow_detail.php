<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Form Peminjaman / Pengembalian Barang</div>
				<div>
					<form action="<?= base_url() ?>toolman/updateReturn/<?= $borrowData['id'] ?>" method="post">
						<input type="number" name="itemleftavailable" value="<?= $borrowData['available'] ?>" style="display: none;">
						<input type="number" name="itemid" value="<?= $borrowData['tool_id'] ?>" style="display: none;">
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Kode</label>
							<div class="col-lg-10">
									<input class="form-control" type="text" value="<?=$borrowData['code_borrow']?>" disabled>
							</div>
						</div>
						<?php if (empty($borrowData['student_nisn'])) : ?>
							<div class="row mb-3">
								<label for="" class="col-lg-2 col-form-label">Nama Guru</label>
								<div class="col-lg-10">
									<input class="form-control" type="text" value="<?= $borrowData['t_first_name'] ?> <?= $borrowData['t_last_name'] ?>" disabled>
								</div>
							</div>
						<?php else : ?>
							<div class="row mb-3">
								<label for="" class="col-lg-2 col-form-label">Nama Tugas</label>
								<div class="col-lg-10">
									<input class="form-control" type="text" value="<?= $borrowData['title'] ?> - <?= $borrowData['t_first_name'] ?> <?= $borrowData['t_last_name'] ?>" disabled>
								</div>
							</div>
							<div class="row mb-3">
								<label for="" class="col-lg-2 col-form-label">Tipe Peminjam</label>
								<div class="col-lg-10">
									<?php if ($borrowData['borrower_type'] == "1") : ?>
										<input class="form-control" type="text" value="Individual" disabled>
									<?php elseif ($borrowData['borrow_accepted'] == "2") : ?>
										<input class="form-control" type="text" value="Kelompok" disabled>
									<?php elseif ($borrowData['borrow_accepted'] == "3") : ?>
										<input class="form-control" type="text" value="Kelas" disabled>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
						<div class="col-12 mb-3">
							<label for="" class="form-label">Barang Dipinjam</label>
							<div class="row">
								<div class="col-lg-1">No</div>
								<div class="col-lg-9">Nama Barang</div>
								<div class="col-lg-2">Jumlah Barang</div>
							</div>
							<?php $quantity = explode(",", $borrowData['quantity']) ?>
							<?php for ($i = 0; $i < count($borrowData['toolDatas']); $i++) : ?>
								<div class="mb-3">
									<div class="row">
										<div class="col-lg-1">
											<input class="form-control text-center" type="text" value="<?= $i + 1 ?>" disabled>
										</div>
										<div class="col-lg-9">
											<input class="form-control" type="text" value="<?= $borrowData['toolDatas'][$i]['tool_name'] ?>" disabled>
										</div>
										<div class="col-lg-2">
											<input class="form-control" type="number" value="<?= $quantity[$i] ?>" disabled>
										</div>
									</div>
								</div>
							<?php endfor; ?>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Estimasi Pengembalian</label>
							<div class="col-lg-10">
								<input class="form-control" type="text" value="<?= $borrowData['est_time_return'] ?>" disabled>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Status</label>
							<div class="col-lg-10">
								<?php if ($borrowData['borrow_accepted'] == "0" && $borrowData['status'] == "0") : ?>
									<input class="form-control" type="text" value="Menunggu Konfirmasi Guru" disabled>
								<?php elseif ($borrowData['borrow_accepted'] == "1" && $borrowData['status'] == "0") : ?>
									<input class="form-control" type="text" value="Peminjaman Disetujui" disabled>
								<?php elseif ($borrowData['borrow_accepted'] == "2" && $borrowData['status'] == "0") : ?>
									<input class="form-control" type="text" value="Peminjaman Ditolak" disabled>
								<?php elseif ($borrowData['status'] == "1") : ?>
									<input class="form-control" type="text" value="Sedang Dipinjam" disabled>
								<?php elseif ($borrowData['status'] == "2") : ?>
									<input class="form-control" type="text" value="Selesai Dipinjam" disabled>
								<?php endif; ?>

							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Keterangan</label>
							<div class="col-lg-10">
								<textarea class="form-control" name="infoborrow" id="" cols="30" rows="6" disabled><?= $borrowData['information_student'] ?></textarea>
							</div>
						</div>
						<div class="row mb-3">
							<label for="" class="col-lg-2 col-form-label">Keterangan Toolman</label>
							<div class="col-lg-10">
								<textarea class="form-control" name="infoborrow" id="" cols="30" rows="6" disabled><?= $borrowData['information_toolman'] ?></textarea>
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
					</form>
				</div>
			</div>
		</div>
	</section>
</main>
