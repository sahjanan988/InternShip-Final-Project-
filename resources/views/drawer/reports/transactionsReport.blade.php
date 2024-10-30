
<h1 align="center">List of Transactions</h1>
@if($from != '')
    <h5 align="center"> From: {{$from}}</h5>
@endif

@if($to != '')
    <h5 align="center"> To: {{$to}}</h5>
@endif

<table border="1" width="100%" cellpadding="5">
    <tr bgcolor="black" color="white" align="center" valign="center">
        <th width="10%">Type</th>
        <th width="15%">Amount</th>
        <th width="15%" align="center">Date</th>
        <th width="20%">Employee</th>
        <th width="45%">Description</th>
    </tr>

    @foreach($data  as $transaction)
        <tr>
            <td>{{$transaction->type}}</td>
            <td>{{$transaction->amount . 'LBP'}}</td>
            <td>{{date("Y-m-d",strtotime($transaction -> date))}}</td>
            <td>{{\App\Models\Employee::where('id',$transaction->employee_id)->first()->name}}</td>
            <td>{{$transaction->description}}</td>
        </tr>
        @endforeach
        </tbody>
</table>
