
<h1 align="center">List of Customers</h1>
@if($area != '')
    <h5 align="center"> Area: {{$area}}</h5>
@endif

@if($employee != '')
    <h5 align="center">{{$employee}}</h5>
@endif

<table border="1" width="100%" cellpadding="5">
    <tr bgcolor="black" color="white" align="center" valign="center">
        <th width="5%">ID</th>
        <th width="20%">Name</th>
        <th width="20%">Phone</th>
        <th width="20%">Area</th>
        <th width="20%">Balance</th>
        <th width="15%">Expires At</th>
    </tr>

    @foreach($data  as $customer)
        <tr>
            <td>{{$customer->id}}</td>
            <td>{{$customer->name}}</td>
            <td>{{'+961 '. $customer->phone}}</td>
            <td>{{\App\Models\Area::find($customer->area_id)->name}}</td>
            <td>{{\App\Models\CustomerInvoice::where('customer_id', $customer->id)->sum('due').' LBP'}}</td>
            <td>{{date("Y-m-d",strtotime($customer -> expires_at))}}</td>
        </tr>
        @endforeach
        </tbody>
</table>
