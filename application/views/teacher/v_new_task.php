<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body table-border-style">
				<div class="card-title">Form Tugas Siswa</div>
				<form action="<?= base_url() ?>teacher/submitTask" method="post">
					<div class="row mb-3">
						<label for="" class="col-lg-2 col-form-label">Judul Tugas</label>
						<div class="col-lg-10">
							<input class="form-control" name="titletask" type="text">
						</div>
					</div>
					<div class="row mb-3">
						<label for="" class="col-lg-2 col-form-label">Pilih Siswa</label>
						<div class="col-lg-10">
							<select name="selectstudent" id="selectstudent" class="form-select">
								<?php foreach ($allStudent as $dt) : ?>
									<option value="<?= $dt['nisn'] ?>"><?= $dt['first_name'] ?> <?= $dt['last_name'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<label for="" class="col-lg-2 col-form-label">Deskripsi Tugas</label>
						<div class="col-lg-10">
							<textarea class="form-control" name="desctask" id="" cols="30" rows="6"></textarea>
						</div>
					</div>
					<div class="row">
							<div class="col-lg-7"></div>
							<div class="col-lg-2">
								<a href="<?= base_url() ?>teacher/inOutPage">
									<div class="d-grid">
										<button class="btn btn-lg btn-outline-dark" type="button">Cancel</button>
									</div>
								</a>
							</div>
							<div class="col-lg-3">
								<div class="d-grid">
									<button class="btn btn-lg btn-primary" type="submit">Submit Task</button>
								</div>
							</div>
						</div>
				</form>
			</div>
		</div>
	</section>
</main>
