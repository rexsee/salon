<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Services</th>
        <th>Handle By</th>
        <th>Stylist</th>
        <th>Remark</th>
        <th>Product</th>
        <th>Total Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($customerLogs as $log)
        <tr>
            <td>{{ $log->log_date->toDayDateTimeString() }}</td>
            <td>{{ $log->services }}</td>
            <td>{{ $log->handle_by }}</td>
            <td>{{ empty($log->stylist) ? '- ' : $log->stylist->name }}</td>
            <td>{{ $log->remark }}</td>
            <td>{{ $log->product }}</td>
            <td>{{ $log->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
