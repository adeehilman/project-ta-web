<tr>
    <td></td>
    <td></td>
    <td></td>
    <td style="text-align: center">

        PT. SAT NUSAPERSADA Tbk

    </td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td></td>
    <td></td>
    <td></td>
    <td style="text-align: center">MEETING REPORT SUMMARY</td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td style="width: 250px;"><b>Date</b></td>
    <td>{{ $TimeDetail }}</td>
    <td></td>
</tr>
<tr>
    <td style="width: 250px;"><b>Room</b></td>
    <td>{{ $NameRoom }}</td>
</tr>
<tr>
    <td style="width: 250px;"><b>Total Meeting</b></td>
    <td style="text-align: left">{{ $TotMeeting }}</td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
</tr>

<table style="border-collapse: collapse;">
    <thead>
        <tr>
            <td style="border: 1px solid black; width: 200px;"><b>Meeting Title</b></td>
            <td style="border: 1px solid black; width: 200px;"><b>Room</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Meeting Date</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Start Meeting</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Finish Meeting</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Attendance Status</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Participant</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Total Attendance</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Visitor</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Request</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Project Name</b></td>
            <td style="border: 1px solid black; width: 400px;"><b>Fasilitas</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Booking Time</b></td>
        </tr>
    </thead>

    <tbody>
        @foreach ($list_tabel as $item)
            <tr>
                <td style="border: 1px solid black; width: 200px;">{{ $item->title_meeting }}</td>
                <td style="border: 1px solid black; width: 200px;">{{ $item->room_name }}</td>
                <td style="border: 1px solid black; width: 150px;">{{ date('d F Y', strtotime($item->meeting_date)) }}
                </td>
                <td style="border: 1px solid black; width: 100px;">{{ date('H:i', strtotime($item->meeting_start)) }}
                </td>
                <td style="border: 1px solid black; width: 100px;">{{ date('H:i', strtotime($item->meeting_end)) }}
                </td>
                @if ($item->kehadiran == 1)
                    <td style="border: 1px solid black; width: 100px;">Attendance</td>
                @else
                    <td style="border: 1px solid black; width: 100px;">Absent</td>
                @endif
                <td style="border: 1px solid black; width: 100px;">{{ $item->participant_count }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->tot_kehadiran }}</td>
                @if ($item->jumlah_tamu == null || 0)
                    <td style="border: 1px solid black; width: 100px; text-align: right;">-</td>
                @else
                    <td style="border: 1px solid black; width: 100px;">{{ $item->jumlah_tamu }}</td>
                @endif
                <td style="border: 1px solid black; width: 200px;">{{ $item->booking_by_name }}</td>
                <td style="border: 1px solid black; width: 200px;">{{ $item->project_name }}</td>
                @if ($item->fasilitas == null)
                    <td style="border: 1px solid black; width: 400px;">-</td>
                @else
                    <td style="border: 1px solid black; width: 400px;">{{ $item->fasilitas }}</td>
                @endif
                <td style="border: 1px solid black; width: 150px;">{{ date('d F Y', strtotime($item->booking_date)) }}
                </td>


            </tr>
        @endforeach
    </tbody>
</table>
