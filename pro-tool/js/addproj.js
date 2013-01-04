$(document).ready(function() {
	if ($('#hourly-check').is(':checked')) {
		$(".task-days").hide();
		$(".task-hours").show();
		$("input#task-hours").focus();
	} else {
		$(".task-days").show();
		$(".task-hours").hide();
	}
	$("input#hourly-check").click(function(e){
		if ($('#hourly-check').is(':checked')) {
			$(".task-days").hide();
			$(".task-hours").show();
			$("input#task-hours").focus();
		} else {
			$(".task-days").show();
			$(".task-hours").hide();
		}
	});
	
	// Validation Part
	//global vars
	var form = $("#add-proj");
	var proTitle = $("#project-title");
	var nameInfo = $("#nameInfo");
	var cliName = $("#cli-name");
	var clinameInfo = $("#clinameInfo");
	var hourlyCheck = $("#hourly-check");
	var taskHours = $("#task-hours");
	var taskHourInfo = $("#taskHourInfo");
	var remind = $("#remind");
	var remindInfo = $("#remindInfo");
	var refUrl = $("#ref-url");
	var refUrlInfo = $("#refUrlInfo");
	var startDate = $("#start_date");
	var endDate = $("#end_date");
	var dayInfo = $("#dayInfo");
	
	//On blur
	proTitle.blur(validateProTitle);
	taskHours.blur(validateTaskHours);
	//refUrl.blur(validateRefUrl);
	remind.blur(validateRemind);
	
	//On key press
	taskHours.keyup(validateTaskHours);
	//refUrl.keyup(validateRefUrl);
	remind.keyup(validateRemind);
	//On Submitting
	form.submit(function(){
		if(validateProTitle() & validateTaskHours() & validateRemind() & validateDate() && CompareDates())
			return true
		else
			return false;
	});
	
	//validation functions
	function validateDate() {
		if ($('#hourly-check').is(':checked')) {
			dayInfo.text("");
			dayInfo.removeClass("error");
			return true;
		} else {
			if(startDate.val() == endDate.val()) {
				dayInfo.text("You can save this as hourly task as both the dates are equal.");
				dayInfo.addClass("error");
				return false;
			} else {
				dayInfo.text("");
				dayInfo.removeClass("error");
				return true;
			}
		}
	}
	
	function CompareDates() { 
		var str1 = startDate.val();
		var str2 = endDate.val();
		var dt1  = parseInt(str1.substring(0,2),10); 
		var month1 = str1.substring(3,6); 
		switch (month1) {
		case 'JAN':
			var mon1 = '01';
			break;
		case 'FEB':
			var mon1 = '02';
			break;
		case 'MAR':
			var mon1 = '03';
			break;
		case 'APR':
			var mon1 = '04';
			break;
		case 'MAY':
			var mon1 = '05';
			break;
		case 'JUN':
			var mon1 = '06';
			break;
		case 'JUL':
			var mon1 = '07';
			break;
		case 'AUG':
			var mon1 = '08';
			break;
		case 'SEP':
			var mon1 = '09';
			break;
		case 'OCT':
			var mon1 = '10';
			break;
		case 'NOV':
			var mon1 = '11';
			break;
		case 'DEC':
			var mon1 = '12';
			break;
		}
		var yr1  = parseInt(str1.substring(7,11),10); 
		
		var dt2  = parseInt(str2.substring(0,2),10); 
		var month2 = str2.substring(3,6); 
		switch(month2) {
		case 'JAN':
			var mon2 = '01';
			break;
		case 'FEB':
			var mon2 = '02';
			break;
		case 'MAR':
			var mon2 = '03';
			break;
		case 'APR':
			var mon2 = '04';
			break;
		case 'MAY':
			var mon2 = '05';
			break;
		case 'JUN':
			var mon2 = '06';
			break;
		case 'JUL':
			var mon2 = '07';
			break;
		case 'AUG':
			var mon2 = '08';
			break;
		case 'SEP':
			var mon2 = '09';
			break;
		case 'OCT':
			var mon2 = '10';
			break;
		case 'NOV':
			var mon2 = '11';
			break;
		case 'DEC':
			var mon2 = '12';
			break;
		}
		var yr2  = parseInt(str2.substring(7,11),10);
		
		var date1 = new Date(yr1, mon1, dt1); 
		var date2 = new Date(yr2, mon2, dt2); 
		if(date2 < date1) {
			dayInfo.text("Check your project End Date");
			dayInfo.addClass("error");
			return false;
		} else {
			dayInfo.text("");
			dayInfo.removeClass("error");
			return true;
		}
	} 
	
	function validateRefUrl(){
		//testing regular expression
		var a = $("#ref-url").val();	
		if(a.length > 0) {
			var pattern = /^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([\w]+)(.[\w]+){1,2}$/;
			if(pattern.test(a)) {
				refUrl.removeClass("error");
				refUrlInfo.text("Link to know more about this project...");
				refUrlInfo.removeClass("error");
				return true;
			} else {
				refUrl.addClass("error");
				refUrlInfo.text("Kindly check your URL... (Use http://)");
				refUrlInfo.addClass("error");
				return false;
			}
		} else {
			refUrl.removeClass("error");
			refUrlInfo.text("Link to know more about this project...");
			refUrlInfo.removeClass("error");
			return true;
		}
	}
	
	function validateProTitle(){
		//if it's NOT valid
		if(proTitle.val().length < 4){
			proTitle.addClass("error");
			nameInfo.text("We want names with more than 3 letters!");
			nameInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			proTitle.removeClass("error");
			nameInfo.text("What's the Project name?");
			nameInfo.removeClass("error");
			return true;
		}
	}
	
	function validateTaskHours(){
		if ($('#hourly-check').is(':checked')) {
			if(taskHours.val().length < 1) {
				taskHours.addClass("error");
				taskHourInfo.text("Ey! Remember: Is this a hourly task?");
				taskHourInfo.addClass("error");
				return false;
			} else if(isNaN(taskHours.val())){
				taskHours.addClass("error");
				taskHourInfo.text("Hours will be in numbers?");
				taskHourInfo.addClass("error");
				return false;
			} else {
				taskHours.removeClass("error");
				taskHourInfo.text("How long will be needed to completed..? Specify in hours.");
				taskHourInfo.removeClass("error");
				return true;
			}
		} else {
			taskHours.removeClass("error");
			taskHourInfo.text("How long will be needed to completed..? Specify in hours.");
			taskHourInfo.removeClass("error");
			return true;
		}
	}
	
	function validateRemind(){
		if(remind.val() == ''){
			remind.addClass("error");
			remindInfo.text("You need to remind yourself");
			remindInfo.addClass("error");
			return false;
		} else if( (remind.val() != '') && isNaN(remind.val()) ){
			remind.addClass("error");
			remindInfo.text("Only numbers accepted");
			remindInfo.addClass("error");
			return false;
		}
		//are valid
		else{
			remind.removeClass("error");
			remindInfo.text("You will be highlighted in x days.");
			remindInfo.removeClass("error");
			return true;
		}
	}
});