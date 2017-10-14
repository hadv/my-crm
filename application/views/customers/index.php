<div class="container">
<br />
<button class="btn btn-success" onclick="add_customer()"><i class="glyphicon glyphicon-plus"></i> Add Customer</button>
<br />
<br />
<table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th>Customer ID</th>
		<th>Customer Name</th>
		<th>Customer Email</th>
		<th>Created At</th>

		<th style="width:80px;">Action</th>
	</tr>
	</thead>
	<tbody>
		<?php foreach ($customers as $customers_item): ?>
			<tr>
				<td><?php echo $customers_item['id']; ?></td>
				<td><?php echo $customers_item['name']; ?></td>
				<td><?php echo $customers_item['email']; ?></td>
				<td><?php echo $customers_item['created_at']; ?></td>
				<td>
					<button class="btn btn-warning" onclick="edit_customer(<?php echo $customers_item['id'];?>)"><i class="glyphicon glyphicon-pencil"></i></button>
					<button class="btn btn-danger" onclick="delete_customer(<?php echo $customers_item['id'];?>)"><i class="glyphicon glyphicon-remove"></i></button>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('assests/bootstrap/js/bootstrap.min.js')?>"></script>

<script type="text/javascript">
	$(document).ready(
		function () {
			$('#table_id').DataTable();
		}
	);

	var save_method; //for save method string

	function add_customer()
	{
		save_method = 'add';
		$('#form')[0].reset(); // reset form on modals
		$('#error').empty();
		$('.modal-title').text('Create Customer'); // Set title to Bootstrap modal title
		$('#modal_form').modal('show'); // show bootstrap modal
	}

	function save()
	{
		var url;
		if(save_method == 'add')
		{
			url = "<?php echo site_url('customers/create')?>";
		}
		else
		{
			url = "<?php echo site_url('customers/update')?>";
		}

		// ajax adding data to database
		$.ajax({
			url : url,
			type: "POST",
			data: $('#form').serialize(),
			dataType: "JSON",
			success: function(data)
			{
				$('#error').empty();
				if (data.status) {
					//if success close modal and reload ajax table
					$('#modal_form').modal('hide');
					location.reload();// for reload a page
				} else {
					$('#error').append(data);
				}
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error adding / update data');
			}
		});
	}

	function edit_customer(id)
	{
		save_method = 'update';
		$('#error').empty();
		$('#form')[0].reset(); // reset form on modals

		//Ajax Load data from ajax
		$.ajax({
			url : "<?php echo site_url('customers/show/')?>/" + id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{

				$('[name="id"]').val(data.id);
				$('[name="name"]').val(data.name);
				$('[name="email"]').val(data.email);
				$('[name="created_at"]').val(data.created_at);


				$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
				$('.modal-title').text('Edit Customer'); // Set title to Bootstrap modal title

			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error get data from ajax');
			}
		});
	}

	function delete_customer(id)
	{
		if(confirm('Are you sure delete this data?'))
		{
			// ajax delete data from database
			$.ajax({
				url : "<?php echo site_url('customers/delete')?>/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					location.reload();
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error deleting data');
				}
			});

		}
	}

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Customer Form</h3>
			</div>
			<p id="error" class="text-danger"></p>
			<div class="modal-body form">
				<form action="#" id="form" class="form-horizontal">
					<input type="hidden" value="" name="id"/>
					<div class="form-body">
						<div class="form-group">
							<?php echo form_error('name')?>
							<label class="control-label col-md-3">Customer Name</label>
							<div class="col-md-9">
								<input name="name" placeholder="Customer Name" class="form-control" type="text">
							</div>
						</div>
						<div class="form-group">
							<?php echo form_error('email')?>
							<label class="control-label col-md-3">Customer Email</label>
							<div class="col-md-9">
								<input name="email" placeholder="Customer Email address" class="form-control" type="text">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
