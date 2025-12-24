<!DOCTYPE html>
<html lang="en">

<head>
	<title>Students List</title>
	<style type="text/css">
		.attendance tr th,
		.attendance tr td {
			border: 1px solid black;
			padding: 4px;
			font-size: 12px;
		}

		.underline {
			text-decoration: underline;
			margin-top: 10px !important;
			margin-bottom: 10px !important;
		}

		body {
			margin: 0;
			padding: 0;
		}

		.container {
			padding: 0;
		}
	</style>
</head>

<body class="container">
	<?php
date_default_timezone_set("Asia/Karachi");

$total_records = count($students);
$number = ceil($total_records / 20);
?>
	<?php for ($i = 0; $i < $total_records; $i += 20): ?>
	<div style="text-align: center;">
		<h2 class="underline" style="font-size: xx-large">Taleem Dost Forum</h2>
		<h3 class="underline" style="font-size: x-large">Talent Test - 2025 - Students List</h3>
	</div>

	<div style="margin-top: 10px;">
		<table class="attendance" border="1" width="100%" style="border-collapse: collapse;">
			<thead>
				<tr style="text-align:center; font-weight:bold;">
					<th width="5%">#</th>
					<th width="15%">Roll No</th>
					<th width="25%">Name</th>
					<th width="20%">School</th>
					<th width="10%">Grade</th>
					<th width="10%">Gender</th>
					<th width="15%">Signature</th>
				</tr>
			</thead>
			<tbody>
				<?php for ($j = $i; $j < $i + 25; $j++):
		if (!empty($students[$j])): ?>
				<tr>
					<!-- 1️⃣ # Column -->
					<td align="center"><?php echo $j + 1; ?></td>

					<!-- 2️⃣ Roll Number -->
					<td align="center"><?php echo $students[$j]['roll_number'] ?? '-'; ?></td>

					<!-- 3️⃣ Name -->
					<td align="left"><?php echo $students[$j]['display_name'] ?? $students[$j]['name'] ?? '-'; ?></td>

					<!-- 4️⃣ School -->
					<td align="left"><?php echo ($students[$j]['participate_with'] === 'school' ? ($students[$j]['school']['school_name'] ?? '-') : ($students[$j]['school_name'] ?? '-')); ?></td>

					<!-- 5️⃣ Grade -->
					<td align="center"><?php echo ($students[$j]['grade'] ?? '-') . 'th'; ?></td>

					<!-- 6️⃣ Gender -->
					<td align="center"><?php echo ucfirst($students[$j]['gender'] ?? '-'); ?></td>

					<!-- 7️⃣ Signature -->
					<td align="center"></td>
				</tr>
				<?php endif;
	endfor; ?>
			</tbody>
		</table>
	</div>

	<?php if ($i + 20 < $total_records): ?>
	<div style="page-break-before: always;"></div>
	<?php endif; ?>

	<?php endfor; ?>
</body>

</html>