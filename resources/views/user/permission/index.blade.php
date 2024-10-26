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
      <a href="javascript:;" onclick="add('{{ route('permissions.create') }}', 'modal-md')" class="btn btn-primary"> Add Permission</a>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-12 col-lg-12">
      <div class="ec-cat-list card card-default">
        <div class="card-body">
          <div class="table-responsive">
            <table id="permissions-table" class="table">
              <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Assigned To</th>
                  <th>Created Date</th>
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

<script type="module">
  $(function() {
    var dataTablePermissions = $('#permissions-table'),
      dt_permission;
    // Users List datatable
    if (dataTablePermissions.length) {
      dt_permission = dataTablePermissions.DataTable({
        ajax: "{{ route('permissions') }}",
        columns: [{
            data: ''
          },
          {
            data: 'name'
          },
          {
            data: 'roles'
          },
          {
            data: 'created_at'
          },
          {
            data: ''
          },
        ],
        columnDefs: [{
            // For Responsive
            className: 'control',
            orderable: false,
            searchable: false,
            responsivePriority: 2,
            targets: 0,
            render: function(data, type, full, meta) {
              return '';
            }
          },
          {
            // Name
            targets: 1,
            render: function(data, type, full, meta) {
              var $name = full['name'];
              return '<span class="text-nowrap">' + $name + '</span>';
            }
          },
          {
            // User Role
            targets: 2,
            orderable: false,
            render: function(data, type, full, meta) {
              var $assignedTo = full['roles'],
                $output = '';
              for (var i = 0; i < $assignedTo.length; i++) {
                $output += '<span class="badge bg-primary m-1">' + $assignedTo[i] + '</span></a>';
              }
              return '<span class="text-nowrap">' + $output + '</span>';
            }
          },
          {
            targets: 3,
            orderable: false,
            render: function(data, type, full, meta) {
              var $date = full['created_at'];
              return '<span class="text-nowrap">' + $date + '</span>';
            }
          },
          {
            // Actions
            targets: -1,
            searchable: false,
            title: 'Actions',
            orderable: false,
            render: function(data, type, full, meta) {
              return (
                '<span class="text-nowrap"><button class="btn btn-sm btn-icon me-2" onclick="edit()"><i class="mdi mdi-edit"></i></button>' +
                '<button class="btn btn-sm btn-icon delete-record"><i class="mdi mdi-trash"></i></button></span>'
              );
            }
          }
        ],
        aaSorting: false,
        dom: '<"row mx-1"' +
          '<"col-sm-12 col-md-3" l>' +
          '<"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>' +
          '>t' +
          '<"row mx-2"' +
          '<"col-sm-12 col-md-6"i>' +
          '<"col-sm-12 col-md-6"p>' +
          '>',
      });
    }
  });
</script>
@endsection