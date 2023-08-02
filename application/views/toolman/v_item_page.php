	<main id="main" class="main">

		<section class="section dashboard">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Input Barang</div>
					<form action="<?= base_url() ?>toolman/insertItems" method="post">
						<div class="row">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-floating mb-2">
											<select name="toolcode" id="itemSelect" class="form-select" required>
												<?php foreach ($item_master as $dt) : ?>
													<option value="<?= $dt['tool_code'] ?>"><?= $dt['tool_group'] ?></option>
												<?php endforeach; ?>
											</select>
											<label for="itemSelect">Grup Barang</label>
										</div>
									</div>
									<div class="col-lg-5">
										<div class="form-floating mb-2">
											<input type="text" class="form-control" placeholder="toolname" name="toolname" required>
											<label for="floatingInput">Nama Barang</label>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-floating mb-2">
											<select name="toolUniversal" id="universalSelect" class="form-select" required>
													<option value="0">Tidak</option>
													<option value="1">Ya</option>
											</select>
											<label for="universalSelect">Barang Universal</label>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-floating mb-2">
											<select name="toolBorrowable" id="borrowableSelect" class="form-select" required>
													<option value="0">Tidak</option>
													<option value="1">Ya</option>
											</select>
											<label for="borrowableSelect">Bisa Dipinjam</label>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-floating mb-2">
											<input type="number" class="form-control" placeholder="groupname" name="quantity" required>
											<label for="floatingInput">Quantity</label>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-floating mb-2">
											<input type="number" class="form-control" placeholder="groupname" name="available" required>
											<label for="floatingInput">Available</label>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-floating mb-2">
											<input type="number" class="form-control" placeholder="groupname" name="broken">
											<label for="floatingInput">Broken</label>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="form-floating mb-2">
											<textarea type="text" class="form-control" placeholder="groupname" name="information" style="height: 100px;"></textarea>
											<label for="floatingInput">Keterangan</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-9"></div>
							<div class="col-lg-3">
								<div class="d-grid">
									<button class="btn btn-lg btn-primary" type="submit">Save Group</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>

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
									<th>Universal</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($tool_data as $dt) : ?>
									<tr>
										<td><?= $no ?></td>
										<td><?= $dt['tool_code'] ?></td>
										<td><?= $dt['tool_name'] ?></td>
										<td><?= $dt['quantity'] ?></td>
										<td><?= $dt['available'] ?></td>
										<td><?= $dt['broken'] ?></td>
										<td><?php if($dt['is_universal'] == 0) {echo "Tidak";} else {echo "Ya";} ?></td>
										<td>
											<a href="<?= base_url() ?>toolman/detailItem/<?= $dt['id'] ?>">
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
			</div>
		</section>

	</main><!-- End #main -->


	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
