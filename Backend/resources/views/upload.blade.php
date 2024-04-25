<form action="{{ route('upload.video') }}" enctype="multipart/form-data" method="post">


	<table>
		<tr>
			<td>Humidity</td>
			<td>
				<input type="text" name="humidity" value="{{ rand(10, 20) }}">
			</td>
		</tr>

		<tr>
			<td>Light Intensity</td>
			<td>
				<input type="text" name="light_intensity" value="{{ rand(1, 10) }}">
			</td>
		</tr>

		<tr>
			<td>Lights</td>
			<td>
				<input type="text" name="lights" value="1">
			</td>
		</tr>
		


		<tr>
			<td>Temperature</td>
			<td>
				<input type="text" name="temperature" value="{{ rand(20, 30) }}">
			</td>
		</tr>

		<tr>
			<td>Fan</td>
			<td>
				<input type="text" name="fan" value="1">
			</td>
		</tr>

		<tr>
			<td>Motion</td>
			<td>
				<input type="text" name="motion" value="{{ rand(1, 10) > 5 ? 1 : 0 }}">
			</td>
		</tr>

		<tr>
			<td>Buzzer</td>
			<td>
				<input type="text" name="buzzer" value="1">
			</td>
		</tr>

		<tr>
			<td>Video</td>
			<td>
				<input type="file" name="video">
			</td>
		</tr>

		<tr>
			<td>
				<button type="submit">Submit</button>
			</td>
			<td>

			</td>
		</tr>
	</table>


	@error('video.')
		<div class="text-danger">{{ $message }}</div>
	@enderror

</form>