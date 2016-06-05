<form id="contacts-form" class="row p-b-2" action="#" method="post" enctype="multipart/form-data">

	<hr />

	<div class="col-sm-6">
		<fieldset class="form-group">
			<label for="first_name">First Name</label>
			<input type="text" class="form-control" id="first_name">
		</fieldset>

		<fieldset class="form-group">
			<label for="last_name">Last Name</label>
			<input type="text" class="form-control" id="last_name">
		</fieldset>

		<fieldset class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" id="email">
		</fieldset>
	</div>

	<div class="col-sm-6">
		<fieldset class="form-group">
			<label for="message">Message</label>
			<textarea class="form-control" id="message" rows="8"></textarea>
		</fieldset>
	</div>

	<div class="col-xs-12 text-xs-right">
		<button type="submit" class="btn btn-primary">Send</button>
	</div>

</form>
