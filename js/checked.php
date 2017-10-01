<html>
<head>
<title>checkbox form</title>
</head>
<body>
<div id="container">
	<p>
		<label for="state">State</label>
		<select name="state" id="state" tabindex="20">
			<option value="Al">Alabama</option>
			<option value="AK">Alaska</option>
			<option value="AZ">Arizona</option>
			<option value="AR">Arkansas</option>
			<option value="CA">California</option>
			<option value="CO">Connecticut</option>
			<option value="NE">Nevada</option>
		</select>

	</p>
</div>

<fieldset>
<p>Check Here to receive brochures on tours: <input type="checkbox" name="brochures" id="brochures" /></p>
	<div id="tourSelection">
		<p>
		<input type="checkbox" name="backpack" id="backpack" tabindex="170" />
		<label>Backpack Cal</label>
		</p>
		<p>
		<input type="checkbox" name="calm" id="calm" tabindex="180" />
		<label>California Calm</label>
		</p>
		<p>
		<input type="checkbox" name="hotsprings" id="hotsprings" tabindex="190" />
		<label>California Hotsprings</label>
		</p>
		<p>
		<input type="checkbox" name="cycle" id="cycle" tabindex="210" />
		<label>California Cycle</label>
		</p>
	</div>
</fieldset>
</body>
<script type="text/javascript" src="checked.js"></script>
</html>