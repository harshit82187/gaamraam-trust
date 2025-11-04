<!DOCTYPE html>
<html>
	<head>
		<title>Ticket Chat</title>
		<style>
			@page {
			margin: 100px 25px;
			}
			body {
			font-family: sans-serif;
			font-size: 12px;
			}
			footer {
			position: fixed;
			bottom: 0px;
			left: 0px;
			right: 0px;
			height: 50px;
			text-align: center;
			line-height: 35px;
			font-size: 10px;
			color: #777;
			}
			table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
			}
			th, td {
			border: 1px solid #000;
			padding: 8px;
			text-align: left;
			}
			th {
			background-color: #f2f2f2;
			}
			h2 {
			text-align: center;
			}
			h3 {
			margin-bottom: 10px;
			text-align: center;
			}
			.header_content {
			display: flex;
			align-items: center;
			justify-content: space-between;
			}
            a{
                text-decoration: none;
            }
		</style>
	</head>
	<body>
        @php
            $logoPath = public_path($websiteLogo);
            $logoSrc = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        @endphp
        <header style="display: flex; flex-direction: column; align-items: center; text-align: center; margin-bottom: 20px;">
            <div>
                <img src="{{ $logoSrc }}" alt="Logo" height="50">
            </div>
			<h2 style="margin: 10px 0 5px;">Ticket Chat</h2>
			<div class="header_content">
                <h3  style="margin: 0;">{{ $ticketNo }} - {{ now()->format('d M Y, h:i A') }}</h3>
			</div>
		</header>
		<footer>
			<div class="copyright">
				2025 © All Rights Reserved. <i class="fa fa-heart heart text-danger"></i> 
				<a href="{{ url('/') }}" target="_blank">Gaam Raam Ngo</a> And Powered By <a href="https://www.pearlorganisation.com/" target="_blank">Pearl Organisation</a>
			</div>
		</footer>
		<main>
			<table>
				<thead>
					<tr>
						<th>SL</th>
						<th>Name</th>
						<th>Chat</th>
						<th>Attachemnt</th>
						<th>Date & Time</th>
					</tr>
				</thead>
				<tbody>
                    @if($ticket->replies->count())
                        @foreach($ticket->replies as $reply)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                 @if($reply->type == 1)
                                    {{ $reply->adminDetail->name}}
                                     @elseif($reply->type == 2)
                                         {{ $reply->studentDetail->name}}
                                        @elseif($reply->type == 3)
                                            {{ $reply->memberDetail->name}}
                                             @elseif($reply->type == 4)
                                                 {{ $reply->collegeDetail->name}}
                                @endif
                            </td>
                            <td>{{ $reply->reply }}</td>
                            <td>
                                @if($reply->attachment)
                                    <a href="{{ asset($reply->attachment) }}" target="_blank" rel="noopener noreferrer">View</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $reply->created_at->format('d-M-Y h:i A') }}</td>
                        </tr>
                        @endforeach
                    @endif
				</tbody>
			</table>
		</main>
	</body>
</html>