@php
$logoPath = public_path($websiteLogo);
$logoData = base64_encode(file_get_contents($logoPath));
$logoSrc = 'data:image/png;base64,' . $logoData;
@endphp
<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border: 1px solid #ddd; margin: 20px auto;">
	<tr>
		<td align="center" style="padding: 20px;">
			<!-- Logo -->
			<img src="{{ $logoSrc }}" alt="Gaam Raam" width="100" height="100" />
		</td>
	</tr>
	<tr>
		<td align="center" style="color: #2fbfa7; font-size: 22px; font-weight: bold; padding-bottom: 10px;">
			Gaam Raam Trust
		</td>
	</tr>
	<tr>
		<td align="center" style="padding: 10px;">
			<hr style="border: none; height: 2px; background-color: #2fbfa7; width: 90%;" />
		</td>
	</tr>
	<tr>
		<td align="center" style="padding: 10px 0;">
			<span style="background-color: #2fbfa7; color: #fff; padding: 10px 20px; font-size: 18px; font-weight: bold; border-radius: 4px;">
			Congratulations!
			</span>
		</td>
	</tr>
	<tr>
		<td style="padding: 20px 40px; font-size: 14px; color: #333;">
            <p>Dear <strong>{{ $task->member->name ?? '---' }}</strong>,</p>
            <p>We are thrilled to inform you that you have been selected as the <strong>Member of the Month – {{ date('M') }} {{ date('Y') }}</strong>.</p>
            <p>Your dedication, hard work, and positive attitude have made a significant impact on the team, and we truly appreciate your outstanding contributions.</p>
            <p>Keep up the excellent work! Your efforts continue to inspire those around you.</p>
            <p>Congratulations once again on this well-deserved recognition!</p>
            <p>On behalf of the <strong>Gaam Raam Achiever’s Club</strong>,</p>
            <br />
            <p><strong>Warm Regards,</strong><br />
            Team Gaam Raam</p>
        </td>

	</tr>
	<tr>
		<td align="center" style="padding-top: 10px;">
			<hr style="border: none; height: 2px; background-color: #2fbfa7; width: 90%;" />
			
		</td>
	</tr>
	<tr>
		<td style="padding: 0 40px 20px; font-size: 11px; color: #666;">
			<p>
				<strong>Note</strong> – This announcement is completely based on the achievement of the assigned major KPI/KRA/BSC’s targets for the respective month.
				Here, the HR Department is the only and concerned authority of Gaam Raam Achiever’s Club.
			</p>
		</td>
	</tr>
</table>