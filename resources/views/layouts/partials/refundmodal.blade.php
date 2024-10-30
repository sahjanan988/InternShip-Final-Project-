<div class="modal fade" id="modal-refund-{{ $id }}" tabIndex="-1" role="dialog" aria-labelledby="refundModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="refundModalLabel">Confirm Refund</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5> Are you sure you want to refund?</h5>
            </div>
            <form method="post" id="refund-form-{{$id }}" action="{{route($route,$id)}}" style="display: none">
                @csrf
                @method('DELETE')

            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning tx-white" onclick="
                    event.preventDefault();
                    document.getElementById('refund-form-{{$id }}').submit();">Refund</button>
            </div>
        </div>
    </div>

</div>
