<tr>
    <td></td>
    <td style="text-align: center">

        PT. SAT NUSAPERSADA Tbk

    </td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td></td>
    <td style="text-align: center">MEETING REPORT</td>
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

<table style="border-collapse: collapse;">
    <thead>
        <tr>
            <td style="border: 1px solid black; width: 100px;"><b>Title</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Room</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Floor</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Date</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Start Meeting</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Finished Meeting</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Participant</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Request</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Status</b></td>
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $item)
            <tr>
                <td style="border: 1px solid black; width: 100px;">{{ $item->title_meeting }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->room_name }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->floor }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->meeting_date }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->meeting_start }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->meeting_end }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->participant_count }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->fullname }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->status_name_eng }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
