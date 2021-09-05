<div class="modal fade" id="modal-delete-{{ $id }}" tabIndex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5> Are you sure you want to delete?</h5>
            </div>
            <form method="post" id="delete-form-{{$id }}" action="{{route($route,$id)}}" style="display: none">
                @csrf
                @method('DELETE')

            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="
                    event.preventDefault();
                    document.getElementById('delete-form-{{$id }}').submit();">Delete</button>
            </div>
        </div>
    </div>

</div>
