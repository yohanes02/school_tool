	<main id="main" class="main">

		<section class="section dashboard">
			<div class="card">
				<div class="card-body table-border-style">
					<div class="card-title">Daftar Barang</div>
					<div class="table-responsive">
						<table class="table datatable table-striped">
							<thead>
								<tr>
									<th>No</th>
									<th>Tool Code</th>
									<th>Tool Name</th>
									<th>Qty</th>
									<th>Available</th>
									<th>Broken</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; foreach ($tool_data as $dt) : ?>
									<tr>
										<td><?= $no ?></td>
										<td><?= $dt['tool_code'] ?></td>
										<td><?= $dt['tool_name'] ?></td>
										<td><?= $dt['quantity'] ?></td>
										<td><?= $dt['available'] ?></td>
										<td><?= $dt['broken'] ?></td>
										<td>
												<a href="<?=base_url()?>teacher/detailItem/<?=$dt['id']?>">
												<div class='d-grid'>
													<button id="edit-<?=$dt['id']?>" class="btn btn-success" onclick=""> Detail Barang </button>
												</div>
											</a>
										</td>
									</tr>
								<?php $no++; endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>

	</main><!-- End #main -->


	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
