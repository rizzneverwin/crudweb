<!DOCTYPE html>
<html>
<head>
    <title>Laravel Ajax CRUD</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
</head>

<body class="p-4">

<div class="container">
    <h2 class="mb-4">Laravel Ajax CRUD Example</h2>

    <button class="btn btn-success mb-3" id="btn-add">+ Create New Product</button>

    <table class="table table-bordered" id="productTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Details</th>
                <th width="200px">Action</th>
            </tr>
        </thead>
    </table>
</div>

<!-- MODAL -->
<div class="modal fade" id="ajaxModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Product Form</h4>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="productForm">
                    <input type="hidden" id="id" name="id">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>

                    <div class="mb-3">
                        <label>Details</label>
                        <textarea class="form-control" id="details"></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="btn-save">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function () {

    // SETUP DATATABLE
    let table = $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/products",
        columns: [
            { data: null, render: (d,t,r,m) => m.row + 1 },
            { data: 'name' },
            { data: 'details' },
            {
                data: 'id',
                render: function(id) {
                    return `
                        <button class="btn btn-info btn-sm view" data-id="${id}">View</button>
                        <button class="btn btn-primary btn-sm edit" data-id="${id}">Edit</button>
                        <button class="btn btn-danger btn-sm delete" data-id="${id}">Delete</button>
                    `;
                }
            }
        ]
    });

    // CREATE
    $('#btn-add').click(function () {
        $('#productForm')[0].reset();
        $('#id').val('');
        $('#ajaxModal').modal('show');
    });

    // EDIT
    $(document).on('click','.edit',function(){
        let id = $(this).data('id');

        $.get('/product/edit/'+id, function(res){
            $('#id').val(res.id);
            $('#name').val(res.name);
            $('#details').val(res.details);
            $('#ajaxModal').modal('show');
        });
    });

    // DELETE
    $(document).on('click','.delete',function(){
        if(!confirm("Delete this item?")) return;

        let id = $(this).data('id');

        $.ajax({
            url: '/product/delete/'+id,
            type: 'DELETE',
            data: {_token:"{{ csrf_token() }}"},
            success: function(){
                table.ajax.reload();
            }
        });
    });

    // SAVE
    $('#btn-save').click(function(){
        $.post('/product/store',{
            _token:"{{ csrf_token() }}",
            id: $('#id').val(),
            name: $('#name').val(),
            details: $('#details').val()
        }, function(){
            $('#ajaxModal').modal('hide');
            table.ajax.reload();
        });
    });

});
</script>

</body>
</html>
