<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Member ID Card</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }

        .id-card {
            width: 650px;
            border: 1px solid #000;
            padding: 20px;
            margin: 25px auto;
        }

        .header {
            background-color: #ff702933;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        .header img {
            height: 40px;
        }

        h3 {
            text-align: center;
            margin: 15px 0;
            font-size: 18px;
            text-decoration: underline;
        }

        .profile-table {
            width: 100%;
            border-spacing: 10px;
        }

        .profile-table td {
            vertical-align: top;
        }

        .photo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        .details {
            font-size: 14px;
        }

        .details p {
            margin: 4px 0;
        }

        .details strong {
            display: inline-block;
            width: 110px;
        }

        .barcode img {
            width: 100px;
        }

        .barcode p {
            font-size: 12px;
            text-align: center;
            margin: 5px 0 0;
        }




        .portrait-id-card {
            width: 350px;
            height: 500px;
            border: 2px solid #333;
            border-radius: 10px;
            padding: 15px;
            font-family: 'Arial', sans-serif;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
        }

        .portrait-id-card .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .portrait-id-card .header img {
            height: 50px;
            object-fit: contain;
            margin: auto;
            width: 200px;
            border-radius: 50%;
        }

        .portrait-id-card .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .portrait-id-card .profile-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .portrait-id-card .photo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #ccc;
            margin: 10px auto;
        }

        .portrait-id-card .details {
            font-size: 13px;
            line-height: 1.5;
            width: 100%;
            margin-bottom: 10px;
        }

        .portrait-id-card .details p {
            margin: 4px 0;
        }

        .portrait-id-card .barcode {
            text-align: center;
        }

        .portrait-id-card .barcode img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-top: 5px;
        }
        @media (max-width: 576px) {
            .id-card {
                max-width: 450px;
                width: 100%;
                        margin: 50px auto;
                                border-radius: 20px;
        border: 1px solid #ddd;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            }
            .profile-table td {
                vertical-align: top;
                width: 100%;
                display: flex;
                text-align: center;
                align-items: center;
                flex-direction: column;
                margin-bottom: 20px;
            }
            .details p {
                margin: 4px 0;
                display: flex;
                justify-content: space-between;
                width: 100%;
                text-align: left !important;
            }
        }
    </style>
</head>

<body>
    {{-- <div class="id-card d-none">
        <div class="header">
            <img src="{{ public_path($websiteLogo) }}" alt="{{ public_path($websiteLogo) }}">
        </div>
        <h3>MEMBER ID CARD</h3>
        <table class="profile-table">
            <tr>
                <td class="photo">
                    @if($member->profile_image)
                    <img src="{{ public_path($member->profile_image) }}" alt="Photo">
                    @else
                    <img src="{{ public_path('default-avatar.png') }}" alt="Default Photo">
                    @endif
                </td>
                <td class="details">
                    <p><strong>Full Name:</strong> {{ $member->name }}</p>
                    <p><strong>Member ID:</strong> {{ $member->member_id ?? 'N/A' }}</p>
                    <p><strong>Mobile:</strong> {{ $member->mobile ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $member->email }}</p>
                    <p><strong>Blood Group:</strong> {{ $member->blood_group ?? 'N/A' }}</p>
                </td>
                <td class="barcode">
                    @if($member->qr_code_path && file_exists(public_path($member->qr_code_path)))
                    <img src="{{ public_path($member->qr_code_path) }}" alt="Barcode">
                    @else
                    <p>No QR code</p>
                    @endif
                </td>
            </tr>
        </table>
    </div> --}}



    <div id="visitingCard" style="width:380px;margin:50px auto 0;background:#fff;border-radius:30px;overflow:hidden;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;text-align:center; border:1px solid #ccc;">
        <div style="background-color:#ff702933;height:130px;border-bottom-right-radius:50% 20%;border-bottom-left-radius:50% 20%;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;padding-top:20px;"><img src="{{ public_path($websiteLogo) }}" alt="Logo"></div>
        @if($member->profile_image)
        <img src="{{ public_path($member->profile_image) }}" width="100" height="100" style="border-radius:50%;object-fit: cover;margin-top:-60px;border:5px solid #fff;background-color: #fff;" alt="Profile">
        @else
        <img src="{{ public_path('default-avatar.png') }}" width="100" height="100" style="border-radius:50%;object-fit: cover;margin-top:-60px;border:5px solid #fff;background-color: #fff;" alt="Profile">
        @endif
        <h2 style="margin:10px 0 5px 0;color:#333;">{{ $member->name }}</h2>
        <p style="margin:0;font-size:14px;color:#777;">{{ $member->member_id ?? 'N/A' }}</p>
        <p style="font-size:13px;color:#444;">{{ $member->mobile ?? 'N/A' }}</p>
        <p style="font-size:13px;color:#444;"> {{ $member->email }}</p>
        <p style="margin:5px 0;font-size:13px;color:#555;">Blood Group:<b>{{ $member->blood_group ?? 'N/A' }}</b></p>
        <div style="margin:15px 0;">
            <div class="barcode">
                @if($member->qr_code_path && file_exists(public_path($member->qr_code_path)))
                <img src="{{ public_path($member->qr_code_path) }}" alt="QR Code">
                @else
                <p>No QR Code</p>
                @endif
            </div>
        </div>
        {{-- <div style="display: flex; justify-content: center; gap: 20px; margin: 20px;">
            <button onclick="downloadCardAsImage()" style="background: rgb(255,146,57); color: #fff; padding: 12px 24px; border-radius: 30px; border: none; font-size: 14px; font-weight: bold; cursor: pointer;">
                <i class="fas fa-download" style="margin-right: 8px;"></i>Download
            </button>

            <button id="shareBtn" style="background: rgb(255,146,57); color: #fff; padding: 12px 24px; border-radius: 30px; border: none; font-size: 14px; font-weight: bold; cursor: pointer;">
                <i class="fas fa-share" style="margin-right: 8px;"></i> Share
            </button>
        </div> --}}
    </div>

</body>

</html>