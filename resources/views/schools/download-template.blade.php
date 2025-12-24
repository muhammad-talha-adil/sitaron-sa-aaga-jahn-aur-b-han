<!DOCTYPE html>
<html lang="en">

<head>
	<title>Schools List</title>
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

		img.receipt-thumb {
			width: 60px;
			height: 60px;
			object-fit: cover;
			border-radius: 6px;
		}
	</style>
</head>

<body class="container">
	<?php
date_default_timezone_set("Asia/Karachi");

$total_records = count($schools);
$number = ceil($total_records / 14);
?>
	<?php for ($i = 0; $i < $total_records; $i += 14): ?>
	<div style="text-align: center;">
		<img src="{{ $jpg_logo_url }}" alt="Logo" style="height: 80px !important;">
		<h2 class="underline" style="font-size: xx-large">Taleem Dost Forum</h2>
		<h3 class="underline" style="font-size: x-large">Talent Test - 2025</h3>
	</div>

	<div style="margin-top: 10px;">
		<table class="attendance" border="1" width="100%" style="border-collapse: collapse;">
			<thead>
				<tr style="text-align:center; font-weight:bold;">
					<th width="5%">#</th>
					<th width="25%">School<br><small>(Name & Address)</small></th>
					<th width="20%">Owner<br><small>(Name & Phone)</small></th>
					<th width="15%">Purpose<br><small>& Visitors</small></th>
					<th width="15%">Incharge<br><small>(Name & Phone)</small></th>
					<th width="10%">Modals<br><small>(G / B)</small></th>
					<th width="10%">Receipt</th>
				</tr>
			</thead>
			<tbody>
				<?php for ($j = $i; $j < $i + 14; $j++):
		if (!empty($schools[$j])): ?>
				<tr>
					<!-- 1️⃣ # Column -->
					<td align="center"><?php echo $j + 1; ?></td>

					<!-- 2️⃣ School (Name + Address) -->
					<td align="left">
						<strong><?php echo $schools[$j]['school_name'] ?? '-'; ?></strong><br>
						<?php echo $schools[$j]['address'] ?? '-'; ?>
					</td>

					<!-- 3️⃣ Owner (Name + Phone) -->
					<td align="left">
						<strong><?php echo $schools[$j]['owner_name'] ?? '-'; ?></strong><br>
						<?php echo $schools[$j]['phone'] ?? '-'; ?>
					</td>

					<!-- 4️⃣ Purpose (Purpose + Visitors) -->
					<td align="left">
						<strong><?php echo $schools[$j]['purpose_of_visit'] ?? '-'; ?></strong><br>
						Visitors: <?php echo $schools[$j]['total_visitors'] ?? 0; ?>
					</td>

					<!-- 5️⃣ Incharge (Name + Phone) -->
					<td align="left">
						<?php 
                            $incharge = $schools[$j]['incharge_name'] ?? '-';
			$incharge_phone = $schools[$j]['incharge_phone'] ?? '-';
			echo "<strong>{$incharge}</strong><br>{$incharge_phone}";
                        ?>
					</td>

					<!-- 6️⃣ Modals (Girls / Boys, short as G / B) -->
					<td align="center">
						<?php 
                            if (($schools[$j]['purpose_of_visit'] ?? '') == 'Visit Only') {
				echo '0';
			} else {
				$girls = $schools[$j]['modal_girls'] ?? 0;
				$boys = $schools[$j]['modal_boys'] ?? 0;
				echo "G: {$girls}" .  '<br>' ."B: {$boys}";
			}
                        ?>
					</td>

					<!-- 7️⃣ Receipt -->
					<td align="center">
						<?php if (!empty($schools[$j]['payment_receipt'])): ?>
						<img src="{{ asset($schools[$j]['payment_receipt']) }}" alt="Receipt"
							class="receipt-thumb">
						<?php else: ?>
						<span>-</span>
						<?php endif; ?>
					</td>
				</tr>
				<?php endif;
	endfor; ?>
			</tbody>
		</table>
	</div>

	<?php if ($i + 14 < $total_records): ?>
	<div style="page-break-before: always;"></div>
	<?php endif; ?>

	<?php endfor; ?>
</body>

</html>