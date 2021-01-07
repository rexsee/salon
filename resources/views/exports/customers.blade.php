<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Tel.</th>
        <th>Email</th>
        <th>Gender</th>
        <th>DOB</th>
        <th>Birthday Month</th>
        <th>Occupation</th>
        <th>Address</th>
        <th>City</th>
        <th>Handle By</th>
        <th>Stylist</th>
        <th>Allergies</th>
        <th>Remark</th>
        <th>Last Visit</th>
        <th>Created At</th>
        <th>Follow Up Date</th>
        <th>Total Visit</th>
        <th>Total Spent</th>
    </tr>
    </thead>
    <tbody>
    @foreach($customers as $customer)
        <tr>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->tel }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->gender }}</td>
            <td>{{ empty($customer->dob) ? '-' : $customer->dob->toDateString() }}</td>
            <td>{{ empty($customer->dob) ? '-' : $customer->dob->format('F') }}</td>
            <td>{{ $customer->occupation }}</td>
            <td>{{ $customer->address }}</td>
            <td>{{ $customer->city }}</td>
            <td>{{ $customer->handle_by }}</td>
            <td>{{ empty($customer->stylist) ? '-' : $customer->stylist->name }}</td>
            <td>{{ $customer->allergies }}</td>
            <td>{{ $customer->remark }}</td>
            <td>{{ $customer->last_visit_at }}</td>
            <td>{{ $customer->created_at->toDateString() }}</td>
            <td>{{ empty($customer->follow_up_date) ? '-' : $customer->follow_up_date->toDateString() }}</td>
            <td>{{ $customer->logs()->count() }}</td>
            <td>{{ $customer->logs()->sum('total') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
