<table style="border-collapse: collapse;">
    <thead>
        <tr>
            <td style="border: 1px solid black; width: 100px;"><b>Badge ID </b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Name </b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Department</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Date</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Time In</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Time Out</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Status</b></td>
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $item)
            <tr>
                <td style="border: 1px solid black; width: 100px; text-align:left;">{{ $item->badge_id }}</td>
                <td style="border: 1px solid black; width: 200px; text-align:left;">{{ $item->fullname }}</td>
                <td style="border: 1px solid black; width: 100px; text-align:left;">{{ $item->dept_name }}</td>
                <td style="border: 1px solid black; width: 100px; text-align:left;">{{ $item->submit_date }}</td>
                <td style="border: 1px solid black; width: 100px; text-align:left;">{{ $item->scanin }}</td>
                <td style="border: 1px solid black; width: 100px; text-align:left;">{{ $item->scanout }}</td>
                <td style="border: 1px solid black; width: 100px; text-align:left;">{{ $item->status }}</td>


            </tr>
        @endforeach
    </tbody>
</table>
