<?php
	//header("Cache-Control: no-cache");
	//header("Pragma: no-cache");
	//header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
	//header("Cache-Control: post-check=0, pre-check=0", false);
	//header("Pragma: no-cache"); // HTTP/1.0
	
	session_start(); // Initialize Session data
	if(!isset($_SESSION["grant_id"])){
		$_SESSION['grant_id'] = 5;
    //exit();
	}
	$grant_id = $_SESSION['grant_id']; // id used for test purposes
?>
<html>
	<head>
	<script type="text/javascript" src="ext/gen.js?n=1"></script>
	<!-- <script src="ext/studentlist.js"></script> -->
	<script type="text/javascript" src="ext/jquery-1.11.0.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link href="ext/bootstrap.min.css" rel="stylesheet">
	<style>
		body{
			<!-- background-color:#3366ff; -->
		}
		.main_container{
			background-color:#ccddff;
			position:relative;
			<!-- border-style:solid; -->
			border-color:#262626;
			border-width:3px;
			height:800px;
			padding:10px
		}
		table{
			background-color:white;
		}
		.medium_container{
			<!-- border-style:solid; -->
			font-family:"Arial", Sans-serif;
			border-width:2px;
			border-color:#bfbfbf;
			box-shadow: 5px 5px 5px grey;
			<!-- position:absolute; -->
			<!-- background-color:white; -->
			<!-- width:48%; -->
			<!-- height:250px; -->
		}
		td{
			border-style: dashed;
			background-color:#ccddff;
			padding:10px;
		}
		.large_container{
			<!-- position:absolute; -->
			<!-- border:dashed; -->
			background-color:yellow;
			box-shadow: 5px 5px 5px grey;
			width:95%;
			height:300px;
			margin:auto;
		}
		.small_container{
			background-color:white;
			text-align:center;
			position:absolute; 	
			box-shadow: 5px 5px 5px grey;
			font-family:"Arial", Sans-serif;
			border-width:2px;
			border-color:#bfbfbf;
			width:27%;
			height:150px;
		}
		.graph_right{
			right:10px;
			float:right;
		}
		#academicprogram_graph{
			bottom: 10px;
		}
		#motherAlive{
			width: 20%;
			position: absolute;
			right: 25px;
		}
		#fatherAlive{
			<!-- width: 20%; -->
			<!-- position: absolute; -->
			<!-- right: 26%; -->
		}
		#programsGraph{
			right:10px;
			float:right;
		}
		.small_container_right{
			bottom:10px;
			right:10px;
		}
		#grant_cost{
			font-size:200%;
			color:red;
			width:inherit;
			margin:auto;
		}
		.small_container_middle{
			bottom:10px;
			right:37%;
		}
		#parentGraph{
			right:10px;
			float:right;
		}
		.small_container_left{
			bottom:10px;
		}
		#financial_year_dropdown{
			margin:10px 10px;
		}
		td{
			margin: 10px;
		}
		.parallax {
			/* The image used */
			background-image: url("images/africa-village-smiling-children-02.jpg");

			/* Set a specific height */
			min-height: 700px; 

			/* Create the parallax scrolling effect */
			background-attachment: fixed;
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
		}
	</style>
	<script> 
		$(window).on('load',function(){
			$('#myModal').modal('show');
		});
		$(document).ready(function(){
			google.charts.load("current", {packages:["corechart"]});
			google.charts.setOnLoadCallback(drawGenderChart);
			google.charts.setOnLoadCallback(drawProgramareaChart);
			google.charts.setOnLoadCallback(drawAcademicProgramChart);
			google.charts.setOnLoadCallback(drawYearlyCostChart);
			google.charts.setOnLoadCallback(drawMotherOccupationChart);
			google.charts.setOnLoadCallback(drawFatherOccupationChart);
			google.charts.setOnLoadCallback(drawEnglishGradesChart);
			google.charts.setOnLoadCallback(drawMathGradesChart);
		<!-- google.charts.setOnLoadCallback(drawParentChart); -->
		});
		
		function drawYearlyCostChart(){
			var data = google.visualization.arrayToDataTable([
				['Year', 'Cost'],
				<?php 
				include_once("ext/donors.php");
				$s=new donors();
				$row=$s->get_grant_lifetime_cost_per_year($grant_id);
				while($row){
					echo "['$row[year_name]',$row[total_amount_per_year]],";
					$row=$s->fetch();
				}
				?>
			  ]);
		  
			
			var options = {
			  title: 'Yearly Cost',
			  // legend: 'none',
			  // pieSliceText: 'label',
			  // slices: {  
						// 0: {offset: 0.2},
						// 1: {offset: 0.3},
						// 14: {offset: 0.4},
						// 15: {offset: 0.5},
			  // },
			};
			
			var chart = new google.visualization.LineChart(document.getElementById('yearlycost_graph'));
			chart.draw(data, options);
		}
		
		function drawAcademicProgramChart(){
		 var data = google.visualization.arrayToDataTable([
			['Program Area', 'Cost'],
			<?php 
			include_once("ext/donors.php");
			$s=new donors();
			$row=$s->get_programs_of_sponsored_students($grant_id);
			while($row){
				echo "['$row[program]',$row[num_students]],";
				$row=$s->fetch();
			}
			?>
		  ]);
		  
			
			var options = {
			  title: 'Academic Program',
			  // legend: 'none',
			  // pieSliceText: 'label',
			  // slices: {  
						// 0: {offset: 0.2},
						// 1: {offset: 0.3},
						// 14: {offset: 0.4},
						// 15: {offset: 0.5},
			  // },
			};
			
			var chart = new google.visualization.PieChart(document.getElementById('academicprogram_graph'));
			chart.draw(data, options);
		}
		
		function drawProgramareaChart(){
		 var data = google.visualization.arrayToDataTable([
			['Program Area', 'Cost'],
			<?php 
			include_once("ext/donors.php");
			$s=new donors();
			$row=$s->get_total_amount_for_programarea($grant_id);
			while($row){
				echo "['$row[programarea_name]',$row[programarea_amount]],";
				$row=$s->fetch();
			}
			?>
		  ]);
		  
			
			var options = {
			  title: 'Program Area Statistics',
			  // legend: 'none',
			  // pieSliceText: 'label',
			  // slices: {  
						// 0: {offset: 0.2},
						// 1: {offset: 0.3},
						// 14: {offset: 0.4},
						// 15: {offset: 0.5},
			  // },
			};
			
			var chart = new google.visualization.BarChart(document.getElementById('programarea_graph'));
			chart.draw(data, options);
		}
		
		function drawGenderChart() {
			var data = google.visualization.arrayToDataTable([
				['Gender', 'Number'],
				[gender[0].gender, parseInt(gender[0].count)], 
				[gender[1].gender, parseInt(gender[1].count)]
			  ]);
			  
			var options = {
			  title: 'Gender Statistics',
			  // legend: 'none',
			  // pieSliceText: 'label',
			  // slices: {  
						// 0: {offset: 0.2},
						// 1: {offset: 0.3},
						// 14: {offset: 0.4},
						// 15: {offset: 0.5},
			  // },
			};

			var chart = new google.visualization.PieChart(document.getElementById('genderGraph'));
			chart.draw(data, options);
		}
	  
		function drawParentChart() {
			var data = google.visualization.arrayToDataTable([
				['Parent', 'Number'],
				['Mother', parseInt(mother[0].mother_alive)], 
				['Father', parseInt(father[0].father_alive)]
				// [gender[1].gender, parseInt(gender[1].count)]
			  ]);
			  
			var options = {
			  title: 'Graph showing which parent of the students is alive',
			  // legend: 'none',
			  // pieSliceText: 'label',
			  // slices: {  
						// 0: {offset: 0.2},
						// 1: {offset: 0.3},
						// 14: {offset: 0.4},
						// 15: {offset: 0.5},
			  // },
			};

			var chart = new google.visualization.PieChart(document.getElementById('parentGraph'));
			chart.draw(data, options);
		}
	  
		function drawMotherOccupationChart(){
			var data = google.visualization.arrayToDataTable([
			['Occupation', 'Count'],
				<?php 
				include_once("ext/donors.php");
				$s=new donors();
				$row=$s->get_mother_occupation_count($grant_id);
				while($row){
					echo "['$row[name]',$row[occupation_count]],";
					$row=$s->fetch();
				}
				?>
			  ]);
		  
			
			var options = {
			  title: "Mothers' Occupation",
			  // legend: 'none',
			  // pieSliceText: 'label',
			  // slices: {  
						// 0: {offset: 0.2},
						// 1: {offset: 0.3},
						// 14: {offset: 0.4},
						// 15: {offset: 0.5},
			  // },
			};
			
			var chart = new google.visualization.BarChart(document.getElementById('mother_occupation_graph'));
			chart.draw(data, options);
		}
		
		function drawFatherOccupationChart(){
			var data = google.visualization.arrayToDataTable([
				['Occupation', 'Count'],
				<?php 
				include_once("ext/donors.php");
				$s=new donors();
				$row=$s->get_father_occupation_count($grant_id);
				while($row){
					echo "['$row[name]',$row[occupation_count]],";
					$row=$s->fetch();
				}
				?>
			]);
		  
			
			var options = {
			  title: "Fathers' Occupation",
			  // legend: 'none',
			  // pieSliceText: 'label',
			  // slices: {  
						// 0: {offset: 0.2},
						// 1: {offset: 0.3},
						// 14: {offset: 0.4},
						// 15: {offset: 0.5},
			  // },
			};
			
			var chart = new google.visualization.BarChart(document.getElementById('father_occupation_graph'));
			chart.draw(data, options);
		}
		
		function drawEnglishGradesChart(){
			var data = google.visualization.arrayToDataTable([
				['Grade', 'Count'],
				<?php 
				include_once("ext/donors.php");
				$s=new donors();
				$row=$s->get_english_grades($grant_id);
				while($row){
					echo "['$row[english]',$row[grade_count]],";
					$row=$s->fetch();
				}
				?>
			]);
		  
			
			var options = {
			  title: "English Grades",
			  // legend: 'none',
			  // pieSliceText: 'label',
			  // slices: {  
						// 0: {offset: 0.2},
						// 1: {offset: 0.3},
						// 14: {offset: 0.4},
						// 15: {offset: 0.5},
			  // },
			};
			
			var chart = new google.visualization.BarChart(document.getElementById('english_grades_graph'));
			chart.draw(data, options);
		}
		
		function drawMathGradesChart(){
			var data = google.visualization.arrayToDataTable([
				['Grade', 'Count'],
				<?php 
				include_once("ext/donors.php");
				$s=new donors();
				$row=$s->get_math_grades($grant_id);
				while($row){
					echo "['$row[math]',$row[grade_count]],";
					$row=$s->fetch();
				}
				?>
			]);
		  
			
			var options = {
			  title: "Math Grades",
			  // legend: 'none',
			  // pieSliceText: 'label',
			  // slices: {  
						// 0: {offset: 0.2},
						// 1: {offset: 0.3},
						// 14: {offset: 0.4},
						// 15: {offset: 0.5},
			  // },
			};
			
			var chart = new google.visualization.BarChart(document.getElementById('math_grades_graph'));
			chart.draw(data, options);
		}
	  
		var grantid=5; // for testing purposes
		var grants=null;
		var students=null;
		var currentGrantId=-1;
		var stats = null; // variable for getting stats data without synchajax
		// this gets all data from server
		<?php
			// include_once("ext/rep.php");
			
			include_once("ext/donors.php");
			$s=new donors();
			$row=$s->get_gender_statistics($grant_id);
			$gen=array();
			$row=$s->fetch();
			while($row){
				$gen[] = $row;
				$row=$s->fetch();
			}
			$row=$s->get_sponsored_student_total($grant_id);
				$total_students = $row;
			$row=$s->get_mother_status($grant_id);
			while($row){
				$mother[] = $row;
				$row=$s->fetch();
			}
			$row=$s->get_father_status($grant_id);
			while($row){
				$father[] = $row;
				$row=$s->fetch();
			}
			$row=$s->get_schools_in_towncity();
			while($row){
				$towncity[] = $row;
				$row=$s->fetch();
			}
			//$row=$s->get_yearly_cost_for_grant($grant_id);
			//while($row){
				//$grant_cost = $row;
				//$row=$s->fetch();
			//}
			$row=$s->get_lifetime_cost_for_grant($grant_id);
			while($row){
				$lifetime_cost = $row;
				$row=$s->fetch();
			}

		?>
		var gender = <?php echo json_encode($gen); ?>;
		var mother = <?php echo json_encode($mother); ?>;
		var father = <?php echo json_encode($father); ?>;
		var towncity = <?php echo json_encode($towncity); ?>;
		var total_students = <?php echo json_encode($total_students); ?>;
		
		<!-- console.log(programarea_cost); -->
		<!-- var cost = <?php// echo json_encode($grant_cost); ?>; -->
		<!-- console.log('grant comms: ' + communities_grant['communities_under_grant']); -->
		<!-- console.log('all comms: ' + all_communities['all_communities']); -->
		
		function getGrantDetails(){
            // alert("works");
			gid=$("#grant_package_id").prop("value");
			// alert(gid);
			console.log(gid);
			u="ext/ajaxgrants.php?cmd=1";
    
			objResult=synchAjax(u);
			console.log(objResult);
			if(objResult.result==0){
				showError(objResult.message);
				// showError(objResult.message);
				return;
			}
			grants=objResult.grants;
			console.log(objResult);
			showGrants();
			console.log(grants);
		}
		
		function getStudentDetails(){
            // alert("works");
			<!-- gid=$("#grant_package_id").prop("value"); -->
			// alert(gid);
			<!-- console.log(gid); -->
			u="ext/ajaxgrants.php?cmd=7&grant_id="+grantid;
    
			objResult=synchAjax(u);
			<!-- console.log(objResult); -->
			if(objResult.result==0){
				showError(objResult.message);
				// showError(objResult.message);
				return;
			}
			students=objResult.students;
			<!-- console.log(students); -->
			showStudents();
		}
		
		function showStudents(){
			clearTable(tableStudents,1);
			if(students==null){
				return;
			}
			for(i=0;i<students.length;i++){
			   var r=tableStudents.insertRow(-1);
			   if(i%2==0){
				   r.className="default_report_line1";
			   }else{
				   r.className="default_report_line2";
			   }
			   // var c=r.insertCell(0);
			   // c.innerHTML="<input type='checkbox' id='"+objResult.students[i].sponsored_student_id+"' name='"+objResult.students[i].sponsored_student_id+"' value='"+objResult.students[i].sponsored_student_id+"'>";
			   var c=r.insertCell(0);
			   c.innerHTML=students[i].student_firstname;
			   c=r.insertCell(1);
			   c.innerHTML=students[i].student_middlename;
			   c=r.insertCell(2)
			   c.innerHTML=students[i].student_lastname;
			   c=r.insertCell(3);
			   c.innerHTML=students[i].end_date;
			   c=r.insertCell(4);
			   c.innerHTML=students[i].school_name;
			   c=r.insertCell(5);
			   c.innerHTML=students[i].status;
			   c=r.insertCell(6);
			   <!-- c.innerHTML='<span data-target="#myModal" class="hotspot" >open</span>'; -->
			}
    // showStatus(""+ recCount+ " records found");
    //students=objResult.students;
		}
		
		function showGrants(){
			clearTable(tableGrants,1);
			if(grants==null){
				return;
			}
			for(i=0;i<grants.length;i++){

			   var r=tableGrants.insertRow(-1);
			   if(i%2==0){
				   r.className="default_report_line1";
			   }else{
				   r.className="default_report_line2";
			   }
			   // var c=r.insertCell(0);
			   // c.innerHTML="<input type='checkbox' id='"+objResult.students[i].sponsored_student_id+"' name='"+objResult.students[i].sponsored_student_id+"' value='"+objResult.students[i].sponsored_student_id+"'>";
			   var c=r.insertCell(0);
			   c.innerHTML=grants[i].student_id;
			   c=r.insertCell(1);
			   c.innerHTML=grants[i].grant_package_id;
			   c=r.insertCell(2)
			   c.innerHTML=grants[i].grant_name;
			   c=r.insertCell(3);
			   c.innerHTML=grants[i].grant_code;
			   c=r.insertCell(4);
			   c.innerHTML=grants[i].grant_amount;
			   c=r.insertCell(5);
			   c.innerHTML='<span data-target="#myModal" class="hotspot" >open</span>';
			}
    // showStatus(""+ recCount+ " records found");
    //students=objResult.students;
		}

		function openRecord(obj,index,id){
				// alert("opened");
	
                if(grants==null){
                    return;
                }
       
                // cancel();
                // currentIndex=index;
                currentGrantId=id;
				console.log(currentGrantId);
                // currentTableRow=obj.parentNode.parentNode;
                // currentColor=currentTableRow.style.backgroundColor;
                // currentTableRow.style.backgroundColor="yellow";
                
                // n=currentTableRow.rowIndex+1;
                // objRow=tableStudents.insertRow(n);
                // c=objRow.insertCell(0);
                // c.colSpan=11;
                // c.appendChild(document.getElementById("divLeftPane"));
                
                // if(objDisplayRow!=null){
                    // tableStudents.deleteRow(objDisplayRow.rowIndex);
                // }
                displayIndex=objRow.rowIndex;
                // objDisplayRow=objRow;
                // showStatus("record open");
                // divLeftPane.style.display="block";
                // getStudentPerformance();
                
            }
			
		function getData(){
			var theUrl="ext/ajaxgrants.php?cmd=3";
				$.ajax(theUrl,
					{async:false,complete:getDataComplete} //false because we want data to come else data variable will be false
					);
		}
		
		function getDataComplete(xhr,status){
			if(status!="success"){
				alert("failed");
			}
			objRes = $.parseJSON(xhr.responseText);
			// console.log(objRes);
			stats = objRes;
		}
		
			
	  /* don't delete
	  // var u = "ext/ajaxgrants.php?cmd=3";
	  // var objRes = synchAjax(u);
	  // console.log(objRes);
	   */
	   
      
	</script>
	</head>
	<body>
		<div class="parallax"></div>
		
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Welcome!</h4>
			  </div>
			  <div class="modal-body">
				<img src="images/boy_laughing.jpg" style="object-fit:cover">
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<div class="container">
		<div>
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#students" aria-controls="students" role="tab" data-toggle="tab">Students</a></li>
			<li role="presentation"><a href="#costs" aria-controls="costs" role="tab" data-toggle="tab">Costs</a></li>
			<li role="presentation"><a href="#communities" aria-controls="communities" role="tab" data-toggle="tab">Communities</a></li>
			<!-- <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li> -->
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="students">
				<div class="main_container">
					<table>
						<tr>
							<td>
								<div id="genderGraph" class="medium_container"></div>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<!-- <td> -->
								<!-- <div id="motherAlive"> -->
									<!-- <h4>% with mother alive</h4> -->
									<?php
										//include_once("ext/donors.php");
										//$s=new donors();
										//$row=$s->get_mother_status($grant_id);
										//$mother_alive=$row['mother_alive'];
										//$row=$s->get_sponsored_student_total($grant_id);
										//$total_sponsored_students=$row['total_students'];
										// round function rounds number to 2 decimal places 
										//$mother_percentage = round((($mother_alive/$total_sponsored_students) * 100),2);
										//while($row){
											//$mother[] = $row;
											//$row=$s->fetch();
										//}
										//echo "<h3><b>$mother_percentage</b></h3>";
									?>
								<!-- </div> -->
							<!-- </td> -->
							<!-- <td> -->
								<!-- <div id="fatherAlive"> -->
									<!-- <h4>% with father alive</h4> -->
									<?php
										//include_once("ext/donors.php");
										//$s=new donors();
										//$row=$s->get_father_status($grant_id);
										//$father_alive=$row['father_alive'];
										//$row=$s->get_sponsored_student_total($grant_id);
										//$total_sponsored_students=$row['total_students'];
										// round function rounds number to 2 decimal places 
										//$father_percentage = round((($father_alive/$total_sponsored_students) * 100),2);
										//while($row){
											//$mother[] = $row;
											//$row=$s->fetch();
										//}
										//echo "<b>$father_percentage</b>";
									?>
								<!-- </div> -->
							<!-- </td> -->
							<td>
								<div id="academicprogram_graph" class="medium_container"></div>
							</td>
						</tr>
						<tr>
							<td>
								<div id="mother_occupation_graph" class="medium_container"></div>
							</td>
							<td>
								<div id="father_occupation_graph" class="medium_container"></div>
							</td>
						</tr>
						<tr>
							<td>
								<div id="english_grades_graph" class="medium_container"></div>
							</td>
							<td>
								<div id="math_grades_graph" class="medium_container"></div>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="costs">
				<div class="main_container">
					<div class="large_container" id="programarea_graph"></div>
					<br>
					<div class="large_container" id="yearlycost_graph"></div>
					<div class="small_container small_container_middle" id="">
						<h4>Grant Lifetime Cost</h4>
						<?php
							include_once("ext/donors.php");
							$s=new donors();
							$row=$s->get_lifetime_cost_for_grant($grant_id);
							echo "<h3><b>$row[lifetime_cost]</b></h3>";
						?>
						<h3>GHS</h3>
						<!-- <p id="">4</p> -->
					</div>
					<div class="small_container small_container_left" id="" >
						 <?php
						// include_once("ext/donors.php");
						// if($_SESSION[EW_PROJECT_NAME]["PROGRAM_AREA"]==0){                    
							echo "<p id='financial_year_dropdown'><b>Financial Year: </b><select name='year_id' id='year_id' >";
							echo "<option value='0'>--Select---</option>";
							$p=new donors();
							if($row=$p->get_financial_year_list()){
								while($row){
									$selected="";
									echo "<option value='{$row['financial_year_id']}' $selected >{$row['year_name']}</option>";
									$row=$p->fetch();
								}
							}
						echo "</select></p>";
						// }
						?>
						<h3 id="grant_cost_for_year"><b>0</b></h3>
						<h3>GHS</h3>
					</div>
					<div class="small_container small_container_right" id="">
						<h4>Current cost for the year</h4>
						<?php
							include_once("ext/donors.php");
							$s=new donors();
							$row=$s->get_current_year_cost_for_grant($grant_id);
							echo "<h3><b>$row[amount]</b></h3>";
						?>
						<h3>GHS</h3>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="communities">
				<div class="main_container" >
					<div class="medium_container" id="towncityGraph" ></div>
					<div class="small_container graph_right" id="">
						<h4>Number of communities under grant</h4>
							<?php
							include_once("ext/donors.php");
							$s=new donors();
							$row=$s->get_communities_under_grant($grant_id);
							//while($row){
								//var_dump($row) ;
								//$communities_grant = $row;
								//$row=$s->fetch();
							//}
							echo "<h3>$row[communities_under_grant]";
							$row=$s->get_all_communities($grant_id);
							//while($row){
								//$all_communities = $row;
								//$row=$s->fetch();
							//}
							echo " of ";
							echo "$row[all_communities]</h3>";
							?>
							<h3>Communities</h3>
					</div>
					<div style="position:absolute; right:10px;border:dashed;background-color:green;width:48%;height:44%;bottom:10px;"></div>
					<div style="position:absolute;border:dashed;background-color:blue;width:48%;height:44%;bottom:10px;"></div>
				</div>
			</div>
		  <div role="tabpanel" class="tab-pane" id="settings">...</div>
		</div>

		<br>
		<div class="main_container">
			<form>
				Search:
				<input type="text">
				<input type="submit" name="Search">
			</form>
			<table id="tableStudents" class="table table-striped">
				<tr class="default_report_title">
				<!-- <td></td> //not needed for this table -->
				<th>First Name</th>
				<th>Middle Name</th>
				<th>Last Name</th>
				<th>Scholarship End Date</th>
				<th>School Name</th>
				<th>Status</th>
				<!-- <td></td> //not needed for this table--> 
				</tr>
			</table>
		</div>

		</div>
	</div><!-- /.container -->
	<script>
		$(document).ready(function(){
			$("#year_id").on('change',get_yearly_cost);
		});
		
		function get_yearly_cost(){
			var year_id = $("#year_id").val();
			u="ext/ajaxgrants.php?cmd=2&financial_year_id="+year_id+"&grant_id="+<?php echo $grant_id?>;
			objResult=synchAjax(u);
			if(objResult.result==0){
				showError(objResult.message);
				return;
			}
			$("#grant_cost_for_year").html("<b>"+objResult['cost']+"</b>");
		}
		
		getStudentDetails(); // this is to make table of students appear automatically
	</script>
	</body>
</html>
