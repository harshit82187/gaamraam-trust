  <div style="display: flex; justify-content: center; align-items: flex-start; gap: 20px; margin-top: 20px; padding:40px;">

    <!-- Left Side -->
    <div style="width: 300px;height:380px; border: 2px solid #d6d6d6; border-radius: 15px; padding: 20px; background: white; margin-bottom:20px;">
      <div style="text-align: center;">
        @php
          $logoPath = public_path($websiteLogo);
          $logoData = base64_encode(file_get_contents($logoPath));
          $logoSrc = 'data:image/png;base64,' . $logoData;

          $peofileImagePath = public_path($student->image);
          $peofileImageData = base64_encode(file_get_contents($peofileImagePath));
          $peofileImageSrc = 'data:image/png;base64,' . $peofileImageData;
        @endphp
        <img src="{{ $logoSrc }}" style="width: 100px; margin-bottom: 10px;" />
      </div>
      <div style="text-align: center;">
        <img src="{{ $peofileImageSrc }}" style="width: 80px; height: 80px; border-radius: 50%; border: 1px solid #ddd; object-fit: cover;" />
        <h3 style="margin: 10px 0 5px; font-size: 16px; justify-content:center">{{ $student->name }}</h3>
      </div>
      <table style="font-size: 14px; width: 100%; margin-top: 10px;">
        <tr>
          <td><strong>Profile:</strong></td>
          <td style="text-align: right;">Student</td>
        </tr>
        <tr>
          <td><strong>Course:</strong></td>
          <td style="text-align: right;">{{ $student->course ?? 'N/A' }}</td>
        </tr>
        <tr>
          <td><strong>ID:</strong></td>
          <td style="text-align: right;">{{ $student->student_id ?? 'N/A' }}</td>
        </tr>
        <tr>
          <td><strong>Blood Group:</strong></td>
          <td style="text-align: right;">{{ $student->blood_group ?? 'N/A' }}</td>
        </tr>
        <tr>
          <td><strong>Mobile:</strong></td>
          <td style="text-align: right;">{{ $student->mobile ?? 'N/A' }}</td>
        </tr>
        <tr>
          <td><strong>Email:</strong></td>
          <td style="text-align: right;">{{ $student->email ?? 'N/A' }}</td>
        </tr>
      </table>
    </div>

    <!-- Right Side -->
    <div style="width: 300px;height:380px; border: 2px solid #d6d6d6; border-radius: 15px; padding: 20px; background: white;">
      <div style="text-align: center;">
        <h3 style="margin-bottom: 10px; font-size: 16px;justify-content:center;">Scan QR Code</h3>
         @if($student->qr_code_path)
          @php
            $imagePath = public_path($student->qr_code_path);
            $imageData = base64_encode(file_get_contents($imagePath));
            $src = 'data:image/png;base64,' . $imageData;
          @endphp
          <img src="{{ $src }}" alt="Barcode" style="width: 150px;">
        @else
        <p>No QR code</p>
        @endif
        <p style="font-size: 12px; color: gray; margin-top: 10px;">Scan this code to verify identity</p>
        <hr />
        <p style="font-size: 12px; line-height: 18px; margin: 0;">
          House No. 81 Village Shimla Moulana<br />
          Post office Chandoli District Panipat<br />
          Panipat, HARYANA 132103<br />
          <strong>Ph:</strong> 9053903100
        </p>
      </div>
    </div>

  </div>