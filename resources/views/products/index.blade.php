<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>CRUD RIZKI R DAN RASYA — Products</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<!-- Google font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
  :root{
    --bg-dark: #0f1724;
    --card-dark: rgba(255,255,255,0.03);
    --muted-dark: #9aa6b2;
    --accent: #2563eb;
    --accent-2: #06b6d4;
    --glass: rgba(255,255,255,0.04);
    --text-light: #e6eef8;

    --bg-light: #f7fafc;
    --card-light: #ffffff;
    --muted-light: #6b7280;
    --text-dark: #0b1220;
  }

  *{ box-sizing:border-box; font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }

  html,body { height:100%; margin:0; -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale; }

  /* default (dark) */
  body {
    background: linear-gradient(180deg,var(--bg-dark), #071028 140%);
    color:var(--text-light);
    min-height:100vh;
    transition: background .25s ease, color .25s ease;
    padding:60px 24px;
  }

  /* light mode */
  body.light {
    background: var(--bg-light);
    color: var(--text-dark);
  }

  /* container card */
.app {
    max-width:1100px;
    margin: 60px auto 0 auto; /* ← tambah jarak atas 60px */
}
  .panel {
    background: var(--card-dark);
    border-radius:14px;
    padding:20px;
    border:1px solid var(--glass);
    box-shadow: 0 8px 30px rgba(2,6,23,0.45);
    transition: background .25s ease, border .25s ease, box-shadow .25s ease;
  }
  body.light .panel {
    background: var(--card-light);
    border-color: rgba(16,24,40,0.06);
    box-shadow: 0 8px 20px rgba(16,24,40,0.06);
  }

  /* header */
  .panel-header {
    display:flex;
    gap:12px;
    align-items:center;
    justify-content:space-between;
    margin-bottom:18px;
  }
  .brand {
    display:flex;
    gap:12px;
    align-items:center;
  }
  .logo {
    width:48px; height:48px; border-radius:10px; display:flex; align-items:center; justify-content:center;
    font-weight:700; color:var(--text-dark);
    background: linear-gradient(180deg,#ffffff,#f0f6ff);
    box-shadow: 0 6px 18px rgba(16,24,40,0.06);
  }
  body:not(.light) .logo {
    background: linear-gradient(180deg, rgba(255,255,255,0.12), rgba(255,255,255,0.02));
    color: #fff;
    box-shadow: none;
  }
  .brand .title { font-weight:700; font-size:16px; }
  .brand .subtitle { font-size:13px; color:var(--muted-dark); }

  /* controls */
  .controls { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }

  .btn-primary-accent {
    background: linear-gradient(90deg,var(--accent),var(--accent-2));
    color:#fff; border:0; padding:8px 12px; border-radius:10px;
  }
  .theme-toggle {
    display:flex; gap:8px; align-items:center;
    background: transparent; border-radius:999px; padding:4px;
  }

  /* table styling */
  .table-wrapper { margin-top:6px; overflow:auto; border-radius:10px; }
  table {
    width:100%;
    border-collapse:collapse;
  }
  thead th {
    font-weight:600; font-size:13px; color:var(--muted-dark); text-align:left; padding:12px 12px;
    border-bottom:1px solid rgba(255,255,255,0.04);
  }
  tbody td {
    padding:12px; vertical-align:middle; border-top:1px solid rgba(255,255,255,0.02);
  }
  body.light thead th { color:var(--muted-light); border-bottom:1px solid rgba(16,24,40,0.05); }
  .row-hover tbody tr:hover { background: linear-gradient(90deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); transform: translateY(-2px); transition: all .12s ease; }

  .price { font-weight:700; color:var(--accent-2); }
  body.light .price { color:var(--accent); }

  .stock-badge { font-size:13px; padding:6px 8px; border-radius:8px; display:inline-block; min-width:48px; text-align:center; }

  /* small screens */
  @media (max-width: 760px){
    .panel-header { flex-direction:column; align-items:flex-start; gap:14px; }
    thead th:nth-child(3), tbody td:nth-child(3) { display:none; } /* hide details for mobile */
    .brand .subtitle { display:none; }
  }

  /* modal modern */
  .modal-content { border-radius:12px; background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); border:1px solid rgba(255,255,255,0.04); color:inherit; }
  body.light .modal-content { background:var(--card-light); border-color: rgba(16,24,40,0.06); }

  /* inputs */
  .form-control {
    border-radius:8px; padding:10px 12px; border:1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);
    color:inherit;
  }
  body.light .form-control { background:#fff; color:var(--text-dark); border:1px solid rgba(16,24,40,0.06); }

  .small-muted { color:var(--muted-dark); font-size:13px; }
  body.light .small-muted { color:var(--muted-light); }

  .action-btns .btn { border-radius:8px; }

  /* subtle animations */
  .fade-in { animation: fadeIn .18s ease; }
  @keyframes fadeIn { from{opacity:0; transform: translateY(6px)} to{opacity:1; transform:none} }
</style>
</head>
<body>

<div class="app">
  <div class="panel fade-in">

    <!-- header -->
    <div class="panel-header">
      <div class="brand">
        <div class="logo">RR</div>
        <div>
          <div class="title">CRUD RIZKI R DAN RASYA</div>
          <div class="small-muted">Produk — manajemen sederhana & modern</div>
        </div>
      </div>

      <div class="controls">
        <div>
          <label class="small-muted me-2">Show</label>
          <select id="showEntries" class="form-select form-select-sm" style="width:92px; display:inline-block;">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>

        <button class="btn btn-primary-accent" id="btnAdd" data-bs-toggle="modal" data-bs-target="#AddProductModal">
          <i class="fa fa-plus me-2"></i> Add Product
        </button>

        <div class="theme-toggle">
          <i class="fa fa-sun small-muted" style="font-size:14px;"></i>
          <div class="form-check form-switch m-0">
            <input class="form-check-input" type="checkbox" id="themeToggle" checked>
          </div>
          <i class="fa fa-moon small-muted" style="font-size:14px;"></i>
        </div>
      </div>
    </div>

    <!-- table -->
    <div class="table-wrapper">
      <table class="row-hover">
        <thead>
          <tr>
            <th style="width:64px">No</th>
            <th>Name</th>
            <th>Details</th>
            <th style="width:120px">Price</th>
            <th style="width:96px">Stock</th>
            <th style="width:240px">Action</th>
          </tr>
        </thead>
        <tbody id="productTable"></tbody>
      </table>
    </div>

    <!-- footer -->
    <div class="d-flex justify-content-between align-items-center mt-3">
      <div class="small-muted" id="showingInfo">Showing 0 of 0</div>
      <div>
        <button id="prevBtn" class="btn btn-outline-secondary btn-sm me-2"><i class="fa fa-chevron-left"></i> Prev</button>
        <button id="nextBtn" class="btn btn-outline-secondary btn-sm">Next <i class="fa fa-chevron-right"></i></button>
      </div>
    </div>

  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="AddProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <h5 class="mb-2">Add Product</h5>
      <div id="addError" class="alert alert-danger d-none"></div>

      <div class="mb-2">
        <label class="form-label small">Name</label>
        <input id="name" class="form-control" placeholder="e.g. Kemeja Hitam">
      </div>

      <div class="mb-2">
        <label class="form-label small">Details</label>
        <textarea id="details" class="form-control" rows="2" placeholder="Short description"></textarea>
      </div>

      <div class="row">
        <div class="col-6 mb-2">
          <label class="form-label small">Price (Rp)</label>
          <input id="price" class="form-control" type="number" min="0" step="0.01" placeholder="0.00">
        </div>
        <div class="col-6 mb-2">
          <label class="form-label small">Stock</label>
          <input id="stock" class="form-control" type="number" min="0" step="1" placeholder="0">
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-2">
        <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary-accent btn-sm" id="SaveProduct">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="EditProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <h5 class="mb-2">Edit Product</h5>
      <div id="editError" class="alert alert-danger d-none"></div>

      <input type="hidden" id="edit_id">

      <div class="mb-2">
        <label class="form-label small">Name</label>
        <input id="edit_name" class="form-control" placeholder="Product name">
      </div>

      <div class="mb-2">
        <label class="form-label small">Details</label>
        <textarea id="edit_details" class="form-control" rows="2"></textarea>
      </div>

      <div class="row">
        <div class="col-6 mb-2">
          <label class="form-label small">Price (Rp)</label>
          <input id="edit_price" class="form-control" type="number" min="0" step="0.01">
        </div>
        <div class="col-6 mb-2">
          <label class="form-label small">Stock</label>
          <input id="edit_stock" class="form-control" type="number" min="0" step="1">
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-2">
        <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success btn-sm" id="UpdateProduct">Update</button>
      </div>
    </div>
  </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="ViewProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <h5 class="mb-2">View Product</h5>

      <div class="mb-2">
        <strong>Name</strong>
        <div id="view_name" class="mt-1"></div>
      </div>

      <div class="mb-2">
        <strong>Details</strong>
        <div id="view_details" class="mt-1 small-muted"></div>
      </div>

      <div class="row">
        <div class="col-6">
          <strong>Price</strong>
          <div id="view_price" class="mt-1 price"></div>
        </div>
        <div class="col-6">
          <strong>Stock</strong>
          <div id="view_stock" class="mt-1"></div>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* Utilities */
function currencyFormat(num){
  const v = Number(num) || 0;
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(v);
}
function escapeHtml(text) {
  if(!text && text !== 0) return '';
  return $('<div>').text(String(text)).html();
}

/* State */
let currentPage = 1;
let perPage = parseInt($('#showEntries').val());
let dataList = [];

/* Fetch products */
function fetchProducts(){
  $.ajax({
    url: "/products",
    method: "GET",
    success: function(res){
      dataList = Array.isArray(res) ? res : [];
      currentPage = 1;
      renderTable();
    },
    error: function(e){
      console.error('fetch error', e);
      // show minimal fallback
      $('#productTable').html('<tr><td colspan="6" class="text-center small-muted">Failed to load data</td></tr>');
    }
  });
}

/* Render table with pagination */
function renderTable(){
  perPage = parseInt($('#showEntries').val()) || 10;
  const total = dataList.length;
  const start = (currentPage - 1) * perPage;
  const end = start + perPage;
  const slice = dataList.slice(start, end);
  let rows = '';
  let no = start + 1;

  if(slice.length === 0){
    rows = `<tr><td colspan="6" class="text-center small-muted">No products found</td></tr>`;
  } else {
    slice.forEach(item => {
      rows += `
        <tr>
          <td>${no++}</td>
          <td><strong>${escapeHtml(item.name)}</strong></td>
          <td class="small-muted">${escapeHtml(item.details || '')}</td>
          <td class="price">${currencyFormat(item.price)}</td>
          <td><span class="stock-badge ${item.stock > 0 ? 'bg-success text-white' : 'bg-secondary text-white'}">${item.stock}</span></td>
          <td class="action-btns">
            <button class="btn btn-outline-light btn-sm ViewBtn me-1" data-id="${item.id}"><i class="fa fa-eye"></i> View</button>
            <button class="btn btn-info btn-sm EditBtn me-1" data-id="${item.id}"><i class="fa fa-pen"></i> Edit</button>
            <button class="btn btn-danger btn-sm DeleteBtn" data-id="${item.id}"><i class="fa fa-trash"></i> Delete</button>
          </td>
        </tr>
      `;
    });
  }

  $('#productTable').html(rows);
  $('#showingInfo').text(`Showing ${Math.min(end, total)} of ${total}`);
  // disable/enable pagination
  $('#prevBtn').prop('disabled', currentPage <= 1);
  $('#nextBtn').prop('disabled', currentPage * perPage >= total);
}

/* Init */
fetchProducts();

/* Events */
$(document).on('change', '#showEntries', function(){
  perPage = parseInt($(this).val());
  currentPage = 1;
  renderTable();
});

$(document).on('click', '#prevBtn', function(){
  if(currentPage > 1){ currentPage--; renderTable(); }
});
$(document).on('click', '#nextBtn', function(){
  if(currentPage * perPage < dataList.length){ currentPage++; renderTable(); }
});

/* THEME toggle */
$('#themeToggle').on('change', function(){
  if($(this).is(':checked')){
    $('body').removeClass('light'); // checked = dark
  } else {
    $('body').addClass('light'); // unchecked = light
  }
});
// start in dark
$('#themeToggle').prop('checked', true);

/* SAVE */
$(document).on('click', '#SaveProduct', function(){
  $('#addError').addClass('d-none').html('');
  const payload = {
    name: $('#name').val(),
    details: $('#details').val(),
    price: $('#price').val(),
    stock: $('#stock').val()
  };

  $.ajax({
    url: "/product/store",
    method: "POST",
    data: payload,
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    success: function(){
      $('#AddProductModal').modal('hide');
      $('#name,#details,#price,#stock').val('');
      fetchProducts();
    },
    error: function(xhr){
      if(xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors){
        let html = '<ul class="mb-0">';
        $.each(xhr.responseJSON.errors, function(k,v){ html += `<li>${v[0]}</li>`; });
        html += '</ul>';
        $('#addError').html(html).removeClass('d-none');
      } else {
        alert('Error saving product');
      }
    }
  });
});

/* OPEN EDIT */
$(document).on('click', '.EditBtn', function(){
  const id = $(this).data('id');
  $('#editError').addClass('d-none').html('');
  $.get(`/product/edit/${id}`, function(product){
    $('#edit_id').val(product.id);
    $('#edit_name').val(product.name);
    $('#edit_details').val(product.details);
    $('#edit_price').val(product.price);
    $('#edit_stock').val(product.stock);
    $('#EditProductModal').modal('show');
  }).fail(function(){ alert('Failed to fetch product'); });
});

/* UPDATE */
$(document).on('click', '#UpdateProduct', function(){
  const id = $('#edit_id').val();
  const payload = {
    name: $('#edit_name').val(),
    details: $('#edit_details').val(),
    price: $('#edit_price').val(),
    stock: $('#edit_stock').val()
  };

  $.ajax({
    url: `/product/update/${id}`,
    method: "PUT",
    data: payload,
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    success: function(){
      $('#EditProductModal').modal('hide');
      fetchProducts();
    },
    error: function(xhr){
      if(xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors){
        let html = '<ul class="mb-0">';
        $.each(xhr.responseJSON.errors, function(k,v){ html += `<li>${v[0]}</li>`; });
        html += '</ul>';
        $('#editError').html(html).removeClass('d-none');
      } else {
        alert('Error updating product');
      }
    }
  });
});

/* DELETE */
$(document).on('click', '.DeleteBtn', function(){
  if(!confirm('Delete this product?')) return;
  const id = $(this).data('id');
  $.ajax({
    url: `/product/delete/${id}`,
    method: "DELETE",
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    success: function(){
      fetchProducts();
    },
    error: function(){ alert('Error deleting'); }
  });
});

/* VIEW */
$(document).on('click', '.ViewBtn', function(){
  const id = $(this).data('id');
  $.get(`/product/edit/${id}`, function(p){
    $('#view_name').text(p.name);
    $('#view_details').text(p.details || '-');
    $('#view_price').text(currencyFormat(p.price));
    $('#view_stock').text(p.stock);
    $('#ViewProductModal').modal('show');
  }).fail(function(){ alert('Failed to fetch product'); });
});
</script>
</body>
</html>
