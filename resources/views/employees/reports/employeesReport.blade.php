
    <h1 align="center">List of Employees</h1>

    <table border="1" width="100%" cellpadding="5">
        <tr bgcolor="black" color="white" align="center" valign="center">
            <th width="5%">ID</th>
            <th width="25%">Name</th>
            <th width="30%">Phone</th>
            <th width="20%">Salary</th>
            <th width="20%">DoE</th>
        </tr>

        @foreach($data  as $employee)
            <tr>
                <td>{{$employee->id}}</td>
                <td>{{$employee->name}}</td>
                <td>{{'+961 '. $employee->phone}}</td>
                <td>{{$employee->salary . ' LBP'}}</td>
                <td>{{date("Y-m-d",strtotime($employee -> enrolled_at))}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
