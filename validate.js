function validateRegistration() {
	var fname = document.forms["register"]["firstName"].value;
    var lname = document.forms["register"]["lastName"].value;
    if (fname == "" || lname == "" || fname == null || lname == null) {
        alert("Please enter your full name.");
        return false;
    }
	var email=document.forms["register"]["email"].value;
	var atpos=email.indexOf("@");
	var dotpos=email.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
	{
		alert("Not a valid e-mail address");
		document.forms["register"]["email"].focus();
		return false;
	}
	var pw1=document.forms["register"]["password"].value;
	if (pw1.length<6) {
		alert("Password does not meet our requirements.\nMust be at least 6 characters in length.");
		document.forms["register"]["password"].value="";
		document.forms["register"]["verifypw"].value="";
		document.forms["register"]["password"].focus();
		return false;
	}
	var pw2=document.forms["register"]["verifypw"].value;
	if (pw1 != pw2) {
		alert("Your given passwords do not match.\nPlease enter again.");
		document.forms["register"]["password"].value="";
		document.forms["register"]["verifypw"].value="";
		document.forms["register"]["password"].focus();
		return false;
	}
	return true;
}

function validateAddTrain() {
	var name=document.forms["addTrain"]["train_name"].value;
	var meeting=document.forms["addTrain"]["meeting_place"].value;
	var spots=document.forms["addTrain"]["seat_available"].value;
	var date=document.forms["addTrain"]["meeting_date"].value.split("-");
	var hour=document.forms["addTrain"]["meeting_time_hr"].value;
	var min=document.forms["addTrain"]["meeting_time_min"].value;

	if (name == "" || name == null) {
		alert("Please enter a name for your train. \nCan be a destination.");
		document.forms["addTrain"]["train_name"].focus();
		return false;
	}
	
	if (meeting == "" || meeting == null) {
		alert("Please enter where your train is meeting.\nCan be a departure point, or just meet at your destination.");
		document.forms["addTrain"]["meeting_place"].focus();
		return false;
	}
	

	if (spots == "" || spots == null || isNaN(spots) || spots <= 0) {
		alert("Please enter the maximum number of people that can currently come.\nFor instance, if you are a driver, how many can your car hold in addition to you?");
		document.forms["addTrain"]["seat_available"].value = "";
		document.forms["addTrain"]["seat_available"].focus();
		return false;
	}
	
	if (hour == "" || hour == null || min == "" || min == null || isNaN(hour) || isNaN(min) || hour < 1 || hour > 12 || min < 0 || min > 59) {
		alert("Invalid time.");
		document.forms["addTrain"]["meeting_time_hr"].value="";
		document.forms["addTrain"]["meeting_time_min"].value="";
		document.forms["addTrain"]["meeting_time_hr"].focus();
		return false;
	}
	if (document.forms["addTrain"]["meeting_time_min"].value == "pm") {
		if (hour != 12) {
			hour += 12;
		}
	} else if (hour == 12) {
		hour = 0;
	}
	var today = new Date();
	var chosen_date = new Date(date[0], date[1], date[2], hour, min);
	if (chosen_date < today) {
		alert("Selected time has already passed.");
		return false;cc
		
	}
	
	return true;
}
