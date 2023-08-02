	<main id="main" class="main">

		<section class="section dashboard">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Daftar Barang</div>
					<!-- Bordered Tabs Justified -->
					<ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
						<?php for ($i = 0; $i < count($tool_datas); $i++) : ?>
							<li class="nav-item flex-fill" role="presentation">
								<button class="nav-link w-100 <?php if ($i == 0) echo 'active'; ?>" id="tab<?= $i ?>" data-bs-toggle="tab" data-bs-target="#bordered-justified-<?= $i ?>" type="button" role="tab" aria-selected="<?php if ($i == 0) {echo 'true';} else {echo 'false';} ?>"><?= $all_major[$i]['abbv_major'] ?></button>
							</li>
						<?php endfor; ?>
					</ul>
					<div class="tab-content pt-2" id="borderedTabJustifiedContent">
						<?php for ($i = 0; $i < count($tool_datas); $i++) : ?>
							<div class="tab-pane fade show <?php if ($i == 0) echo 'active'; ?>" id="bordered-justified-<?= $i ?>" role="tabpanel" aria-labelledby="tab<?= $i ?>">
								<h5 class="my-3 py-3 text-center bg-body-secondary"><?=$all_major[$i]['full_major']?></h5>
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
											<?php $no = 1;
											foreach ($tool_datas[$i] as $dt) : ?>
												<tr>
													<td><?= $no ?></td>
													<td><?= $dt['tool_code'] ?></td>
													<td><?= $dt['tool_name'] ?></td>
													<td><?= $dt['quantity'] ?></td>
													<td><?= $dt['available'] ?></td>
													<td><?= $dt['broken'] ?></td>
													<td>
														<a href="<?= base_url() ?>headdiv/detailItem/<?= $dt['id'] ?>">
															<div class='d-grid'>
																<button id="edit-<?= $dt['id'] ?>" class="btn btn-success" onclick=""> Detail Barang </button>
															</div>
														</a>
													</td>
												</tr>
											<?php $no++;
											endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						<?php endfor; ?>
					</div><!-- End Bordered Tabs Justified -->
				</div>
			</div>
		</section>

	</main><!-- End #main -->


	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
