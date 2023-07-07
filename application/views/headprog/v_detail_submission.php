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
							<?php if ($submission_data['status'] == "4") echo "Pengajuan Terakhir Ditolak"; ?>
							<?php if ($submission_data['status'] == "5") echo "Barang Sudah Sampai"; ?>
						</div>
					</div>
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
									<a href="<?= base_url() ?>headprog/detailHistorySubmission/<?= $dt['id'] ?>">
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
			</div>
		</div>
	</section>
</main>
