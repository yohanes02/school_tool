<main id="main" class="main">
	<section class="section dashboard">
		<div class="card">
			<div class="card-body table-border-style">
				<div class="card-title">Daftar Tugas Siswa</div>
				<div class="row">
					<div class="col-lg-3 mb-3">
						<a href="<?= base_url() ?>teacher/newTask">
							<button class="btn btn-info">
								<i class="bi bi-plus-circle-dotted"></i>
								Tambah Tugas
							</button>
						</a>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table datatable table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Murid</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($taskData as $dt) : ?>
								<tr style="vertical-align: middle;">
									<td><?= $no ?></td>
									<td><?= $dt['first_name'] ?> <?= $dt['last_name'] ?></td>
									<td>
										<?php if($dt['status'] == 1) : ?>
											Menunggu Diambil Siswa
										<?php else : ?>
											Sudah Diambil Siswa
										<?php endif; ?>
									</td>
									<td>
										<div>
											<a href="<?= base_url() ?>teacher/taskDetail/<?= $dt['id'] ?>">
												<div class="d-grid">
													<button id="edit-<?= $dt['id'] ?>" class="btn btn-success" onclick=""> Detail Tugas </button>
												</div>
											</a>
										</div>
									</td>
								</tr>
							<?php $no++;
							endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</main>
