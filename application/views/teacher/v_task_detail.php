<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body table-border-style">
				<div class="card-title">Detail Tugas Siswa</div>
				<form action="<?= base_url() ?>teacher/submitTask" method="post">
					<div class="row mb-3">
						<label for="" class="col-lg-2 col-form-label">Judul Tugas</label>
						<div class="col-lg-10">
							<input class="form-control" name="titletask" type="text" value="<?= $taskDetail['title'] ?>" disabled>
						</div>
					</div>
					<div class="row mb-3">
						<label for="" class="col-lg-2 col-form-label">Pilih Siswa</label>
						<div class="col-lg-10">
							<select name="selectstudent" id="selectstudent" class="form-select" disabled>
								<?php foreach ($allStudent as $dt) : ?>
									<option value="<?= $dt['nisn'] ?>" <?php if ($taskDetail['student_nisn'] == $dt['nisn']) echo "selected"; ?>><?= $dt['first_name'] ?> <?= $dt['last_name'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<label for="" class="col-lg-2 col-form-label">Deskripsi Tugas</label>
						<div class="col-lg-10">
							<textarea class="form-control" name="desctask" id="" cols="30" rows="6" disabled><?= $taskDetail['description'] ?></textarea>
						</div>
					</div>
					<div class="row mb-3">
						<label for="" class="col-lg-2 col-form-label">Status</label>
						<div class="col-lg-10">
							<input class="form-control" name="titletask" type="text" value="<?php if($taskDetail['status'] == 1) {echo 'Menunggu Diambil Siswa';} else {echo 'Sudah Diambil Siswa';} ?>" disabled>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
</main>
