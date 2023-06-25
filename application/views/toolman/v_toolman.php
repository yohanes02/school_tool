	<main id="main" class="main">

		<section class="section dashboard">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Input Group Item</div>
					<form action="<?= base_url() ?>toolman/insertGroup" method="post">
						<div class="row">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-5">
										<div class="form-floating mb-3">
											<input type="text" class="form-control" id="floatingInput" placeholder="groupcode" name="groupcode">
											<label for="floatingInput">Group Code</label>
										</div>
									</div>
									<div class="col-lg-7">
										<div class="form-floating mb-3">
											<input type="text" class="form-control" id="floatingInput" placeholder="groupname" name="groupname">
											<label for="floatingInput">Group Name</label>
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
					<div class="table-responsive">
						<table class="table datatable table-striped">
							<thead>
								<tr>
									<th>No</th>
									<th>Group Code</th>
									<th>Group Name</th>
									<th>Quantity Item</th>
								</tr>
							</thead>
							<tbody>
							<?php $no = 1; foreach ($group_data as $dt) : ?>
								<tr>
									<td><?=$no?></td>
									<td><?=$dt['tool_code']?></td>
									<td><?=$dt['tool_group']?></td>
									<td><?=$dt['quantity']?></td>
								</tr>
							<?php $no++; endforeach;
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>

	</main><!-- End #main -->


	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
