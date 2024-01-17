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
    <td style="text-align: center">ROOM SUMMARY REPORT</td>
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
            <td style="border: 1px solid black; width: 100px;"><b>Room</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Total Meetings</b></td>
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $item)
            <tr>
                <td style="border: 1px solid black; width: 150px;">{{ $item->room_name }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->meeting_count }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
