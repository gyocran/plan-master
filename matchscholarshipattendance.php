<html>
	<head>
	<script type="text/javascript" src="ext/jquery-1.11.0.js"></script>
	<link href="ext/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="ext/gen.js"></script>
	<script> 
		function checkComplete(xhr,status){
			if(status!="success"){
				divStatus.innerHTML="Failed to retrieve student data";
				return;
			}
			divStatus.innerHTML="Result: Student data retrieved";
			var obj=$.parseJSON(xhr.responseText);
			console.log(obj);
			$("#firstname").text(obj.student.student_firstname);
			$("#middlename").text(obj.student.student_middlename);
			$("#lastname").text(obj.student.student_lastname);
			$("#schoolstart").text(obj.student.school_startdate);
			$("#schoolend").text(obj.student.school_enddate);
			$("#scholarshipstart").text(obj.student.scholarship_startdate);
			$("#scholarshipend").text(obj.student.scholarship_enddate);
			validate();
		}
	
		function check(studentid){
			//write a code to send request to AJAX page
				studentid=1;
				var theUrl="ext/ajaxscholarshipattendancematch.php?cmd=1&student_id=" + studentid;
				$.ajax(theUrl,
					{async:true,complete:checkComplete}
					);
			
		}
		
		// function check(studentid){
			////write a code to send request to AJAX page
				// studentid=1;
				// u = "ext/ajaxscholarshipattendancematch.php?cmd=1&student_id=" + studentid;
				// objRes=synchAjax(u);
				// if(objRes.result==0){
					// showError(objRes.message);
					// console.log(objRes.message);
				// return;
				// }
				// divStatus.innerHTML="Result: Student data retrieved";
				////var obj=$.parseJSON(xhr.responseText);
				// console.log(objRes);
				// $("#firstname").text(objRes.student.student_firstname);
				// $("#middlename").text(objRes.student.student_middlename);
				// $("#lastname").text(objRes.student.student_lastname);
				// $("#schoolstart").text(objRes.student.school_startdate);
				// $("#schoolend").text(objRes.student.school_enddate);
				// $("#scholarshipstart").text(objRes.student.scholarship_startdate);
				// $("#scholarshipend").text(objRes.student.scholarship_enddate);
				// validate();
		// }
		
		function validate(){
			var schoolstart = $("#schoolstart").text();
			var schoolend = $("#schoolend").text();
			var scholarshipstart = $("#scholarshipstart").text();
			var scholarshipend = $("#scholarshipend").text();
			
			if(schoolstart.valueOf() === scholarshipstart.valueOf() && schoolend.valueOf() === scholarshipend.valueOf()){
				$("#validateStatus").text("scholarship and attendance match");
				$("#validateStatus").text("Attendance and scholarship match");
			}
			else
				$("#validateStatus").text("Attendance and scholarship DO NOT match");
		console.log(schoolstart);
		}
	</script>
	</head>
	<body>
		<div style="margin: auto; width: 50%">
		<p id="divStatus"></p>
		<p>Firstname is <b><span id="firstname"><span></b></p>
		<p>Middlename is <b><span id="middlename"><span></b></p>
		<p>Lastname is <b><span id="lastname"><span></b></p>
		<p>School start date <b><span id="schoolstart"><span></b></p>
		<p>School end date <b><span id="schoolend"><span></b></p>
		<p>Scholarship start date <b><span id="scholarshipstart"><span></b></p>
		<p>Scholarship end date <b><span id="scholarshipend"><span></b></p>
		<button onclick="check()">Get Data</button>
		<p id="validateStatus"></p>
		</div>
	</body>
</html>