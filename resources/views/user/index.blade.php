@extends('layouts.master')

@section('content')

<div class="content">
  <div class="breadcrumb-wrapper breadcrumb-contacts">
    <div>
      <h1>Users List</h1>
      <p class="breadcrumbs"><span><a href="index-2.html">Home</a></span>
        <span><i class="mdi mdi-chevron-right"></i></span>Users</p>
    </div>
    <div>
      <a href="javascript:;" onclick="add('{{ route('users.create') }}', 'modal-lg')" class="btn btn-primary"> Add User</a>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-12 col-lg-12">
      <div class="ec-cat-list card card-default">
        <div class="card-body">
          <div class="table-responsive">
            <table id="user-table" class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Photo</th>
                  <th>Full name</th>
                  <th>Roles</th>
                  <th>Status</th>
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
  var responsiveDataTable = $("#user-table");
  if (responsiveDataTable.length !== 0){
    responsiveDataTable.DataTable({
      ajax: "{{ route('users') }}",
      columns: [
        // columns according to JSON
        {
          data: 'id'
        },
        {
          data: 'photo'
        },
        {
          data: 'name'
        },
        {
          data: 'role'
        },
        {
          data: 'is_active'
        },
        {
          data: 'action'
        }
      ],
      columnDefs: [
        {
          // User full name and email
          targets: 1,
          responsivePriority: 4,
          render: function(data, type, full, meta) {
            console.log(full);
            
            var $name = full['profile_photo_path']!=null?full['profile_photo_path']:full['profile_photo_url'];
             return '<img class="cat-thumb" src="'+$name+'"alt="Product Image" />';
          }
        },
        {
          // User Role
          targets: 2,
          render: function(data, type, full, meta) {
            var $name = full['name'];
            return "<span class='text-truncate d-flex align-items-center'>" + $name +
              '</span>';
          }
        },
        {
          // User Role
          targets: 3,
          render: function(data, type, full, meta) {
            var $role = JSON.parse(full['role']);
            return "<span class='text-truncate d-flex align-items-center'>" + $role[0] +
              '</span>';
          }
        },
        {
          targets: 4,
          render: function(data, type, full, meta) {
            var $checkedStatus = full['current'] == 1 ? 'checked' : '';
              var $nameStatus = full['current'] == 1 ? 'Yes' : 'No';
              var $isDisabled ='onclick="updateActiveStatus(&#39;/settings/admissions/admission-sessions/current-status/' + full['id'] + '&#39;, &#39;admission-sessions-table&#39;)"';
              return '<label class="switch">' +
                '<input ' + $isDisabled + ' type="checkbox" ' + $checkedStatus + ' class="switch-input">' +
                '<span class="switch-toggle-slider">' +
                '<span class="switch-on">' +
                '<i class="ti ti-check"></i>' +
                '</span>' +
                '<span class="switch-off">' +
                '<i class="ti ti-x"></i>' +
                '</span>' +
                '</span>' +
                '<span class="switch-label">' + $nameStatus + '</span>' +
                '</label>';
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function(data, type, full, meta) {
            var $role = JSON.parse(full['role']);
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