<div class="row">
    <a href="{{ URL::to('/student/pdf') }}">Export PDF</a>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Address</th>
        </tr>
        @foreach ($customers as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->username }}</td>
                <td>{{ $student->name }}</td>
            </tr>
        @endforeach
    </table>
</div>
