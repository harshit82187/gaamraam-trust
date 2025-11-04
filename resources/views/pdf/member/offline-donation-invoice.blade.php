<table width="100%" cellpadding="0" cellspacing="0" style="font-family: Arial, sans-serif; font-size: 14px; color: #333; line-height: 1.6;">
	<tr>
		<td align="center" style="padding: 20px; background-color: #f4f4f4;">
			<table width="100%" cellpadding="0" cellspacing="0" style="background: #ffffff; border: 1px solid #ddd; border-radius: 8px;">
				<tr>
					<td style="padding: 5px 20px; text-align: center; border-bottom: 1px solid #ddd; background-color: #ff7029;">
						@php
						$logoPath = public_path('front/images/Gaam_Raam_logo.png');
						$logoData = base64_encode(file_get_contents($logoPath));
						$logoSrc = 'data:image/png;base64,' . $logoData;
						@endphp
						<img src="{{$logoSrc}}" height="80px" width="300px" alt="logo">
						<h2 style="margin: 0; font-size: 20px; color: #fff;">Gaam Raam Trust Donation Invoice</h2>
					</td>
				</tr>
				<tr>
					<td style="padding: 20px;">
						<table style="width: 100%; border-collapse: collapse;">
							<tbody>
								<tr>
									<td style="width: 50%; vertical-align: top;">
										<table width="100%">
											<tr>
												<td style="padding: 5px; font-weight: bold; white-space: nowrap;">Invoice ID:</td>
												<td style="padding: 5px; color: #555;">{{ $invoiceNumber ?? '---' }}</td>
												
											</tr>
											<tr>
												<td style="padding: 5px; font-weight: bold; white-space: nowrap;">Donate Date:</td>
												<td style="padding: 5px; color: #555;">{{ $today ?? '---' }}</td>
											</tr>											
										</table>
									</td>
									<td style="width: 50%; vertical-align: top; text-align: right;">
                                        @if($qrScannerPath)
										@php
										$imagePath = public_path($qrScannerPath);
										$imageData = base64_encode(file_get_contents($imagePath));
										$src = 'data:image/png;base64,' . $imageData;
										@endphp
										<img src="{{ $src }}" alt="QR Code" style="max-width: 100px; max-height: 100px;">
										@endif
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<!-- Doner Details Section -->
				<tr>
					<td style="padding: 20px;">
						<p style="margin: 0; font-weight: bold;">Doner Details</p>					
						<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin: 10px 0;">
							<tr>
								<td style="padding: 8px; border: 1px solid #ddd;">Name</td>
								<td style="padding: 8px; border: 1px solid #ddd; text-align: right;">{{ $insertData['user_name'] ?? 'N/A' }}</td>
							</tr>
							<tr>
								<td style="padding: 8px; border: 1px solid #ddd;">Contact</td>
								<td style="padding: 8px; border: 1px solid #ddd; text-align: right;">+91 {{ $insertData['user_mobile'] ?? '' }}</td>
							</tr>
							<tr>
								<td style="padding: 8px; border: 1px solid #ddd;">Email</td>
								<td style="padding: 8px; border: 1px solid #ddd; text-align: right;">
									<a href="mailto:{{ $insertData['user_email'] ?? '' }}" style="color: #007bff; text-decoration: none;">{{ $insertData['user_email'] ?? '' }}</a>
								</td>
							</tr>
							
						</table>
						
					</td>
				</tr>
				
				<!-- Payment Details Section -->
				<tr>
					<td style="padding: 20px;">
						<p style="margin: 0; font-weight: bold;">Payment Details</p>
						<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin: 10px 0;">						
							<tr>
								<td style="padding: 8px; border: 1px solid #ddd;">Payment Method</td>
								<td style="padding: 8px; border: 1px solid #ddd; text-align: right;">QR Code</td>
							</tr>												
							<tr style="font-weight: bold; background-color: #f8f8f8;">
								<td style="padding: 8px; border: 1px solid #ddd;">Donate Amount</td>
								<td style="padding: 8px; border: 1px solid #ddd; text-align: right;">{{ number_format($insertData['amount'] ?? 0, 2) }}</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- Footer Section -->
				<tr>
					<td style="padding: 20px; border-top: 1px solid #ddd;">
						<p style="margin: 0;">We sincerely appreciate your donation to <strong>Gaam Raam Trust</strong></p>
                        <p>Thank you for your generous contribution!</p>
						<p style="margin: 10px 0;">For any queries, contact our support team at:
							<a href="mailto:{{ $adminEmail ?? '' }}" style="color: #007bff; text-decoration: none;">{{ $adminEmail ?? '' }}</a>
						</p>
					</td>
				</tr>
				<tr>
					<td style="padding: 10px; text-align: center; background-color: #f4f4f4; border-top: 1px solid #ddd;">
						<p>{{ date('Y') }} © All Rights Reserved <i class="fa fa-heart heart text-danger"></i> By
                            <a href="{{ url('/') }}" target="_blank" style="color:#ff7029 !important;" >Gaam Raam Trust</a> And Powered By <a href="{{ url('https://www.pearlorganisation.com/') }}" target="_blank" style="color:#ff7029 !important;">Pearl Organisation</a></p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
