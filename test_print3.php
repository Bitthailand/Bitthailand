<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<style type="text/css">
			@media print{
				#hid{
					display: none; /* ซ่อน  */
				}
			}
		</style>

	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-5">
					
					
					<h4> List 
						<!-- 
						id hid คือ CSS บรรทัด 9 - 15 ที่ใช้ media print และสร้างไอดี display:none; เพื่อซ่อน Tag ที่ใส่ไอดี hid 

						**อยากซ่อน Tag ไหนตอนพิมพ์ ก็เอา id="hid" ไปใส่ใน tag ครับ

						-->
					<button id="hid" onclick="window.print();" class="btn btn-primary"> print </button>
				</h4>
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th>header</th>
								<th>header</th>
								<th>header</th>
								<th>header</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>data</td>
								<td>data</td>
								<td>data</td>
								<td>data</td>
							</tr>
							<tr>
								<td>data</td>
								<td>data</td>
								<td>data</td>
								<td>data</td>
							</tr>
							<tr>
								<td>data</td>
								<td>data</td>
								<td>data</td>
								<td>data</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		
		</body>
	</html>
<!-- devbanban.com -->