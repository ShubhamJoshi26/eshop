@extends('layouts.master')

@section('content')

<div class="content">
  <div class="breadcrumb-wrapper breadcrumb-contacts">
    <div>
      <h1>Role List</h1>
      <p class="breadcrumbs"><span><a href="index-2.html">Home</a></span>
        <span><i class="mdi mdi-chevron-right"></i></span>Roles</p>
    </div>
    <div>
      <a href="javascript:;" onclick="add('{{ route('role.create') }}', 'modal-lg')" class="btn btn-primary"> Add Role</a>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-12 col-lg-12">
      <div class="ec-cat-list card card-default">
        <div class="card-body">
          <div class="table-responsive">
            <table id="role-table" class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('page-script')

<script>
  var responsiveDataTable = $("#role-table");
  if (responsiveDataTable.length !== 0){
    responsiveDataTable.DataTable({
      ajax: "{{ route('role') }}",
      columns: [
        // columns according to JSON
        {
          data: 'id'
        },
        {
          data: 'name'
        },
        {
          data: 'action'
        }
      ],
      columnDefs: [
        {
          // User Role
          targets: 1,
          render: function(data, type, full, meta) {
            var $name = full['name'];
            return "<span class='text-truncate d-flex align-items-center'>" + $name +
              '</span>';
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function(data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center">' +
              '<a href="javascript:;" class="text-body" onclick="edit(&#39;'+full['editUrl']+'&#39;, &#39;modal-lg&#39;)"><i class="mdi mdi-pencil"></i></a>' +
              '</div>'
            );
          },
          visible: true
        }
      ],
      "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
    });
  }
</script>
@endsection