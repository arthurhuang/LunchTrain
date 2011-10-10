<html>
<head>
<title>
Schedule New Train
</title>
</head>
<body>
<form action="addtrain.php" method="post">
	<p>
	<label class="desc">Destination: </label> <input type="text", name="to", size="30", maxlength="30" />
	</p>
	
	<p>
	<label class = "desc">Departing From: </label> 
	<input type="text", name="from", size="30", maxlength="30" />
	</p>
	
	<p>
	<label class="desc">Departure Time:</label>
			<input type="text", name="month", value="MM", size="1", maxlength="2"," />
		<label class="desc"> / </label> 
			<input type="text", value="DD", name="day", size="1", maxlength="2" />
			<input type="text", value="HH", name="hr", size="1", maxlength="2" />
		<label class = "desc">:</label> 
			<input type="text", value="MM", name="min", size="1", maxlength="2" />
			<select id="AMPM", name="AMPM", class="field select">
				<option value="AM" selected="selected">AM</option>
				<option value="PM">PM</option>
			</select>
	</p>
	
	<p>
	<select id="transport", name="transport", class="field select">
		<option value="walk" selected="selected">Walking</option>
		<option value="drive">Driving</option>
	</select>
	<label class = "desc">Capacity: </label>
		<input type="text", name="cap", value size="2", maxlength="2" />
	</p>
		
	<p>
	<label class="desc">Additional Info:</label>
	<br>
	<textarea id="info", name="info", rows="8", cols="50"></textarea>
    </p>
	
	<input type="submit" value="Submit" />
	
</form>
</body>
</html>
