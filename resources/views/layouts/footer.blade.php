<div class="modal fade" id="modal-md" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content" id="modal-md-content">
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="modal-lg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content" id="modal-lg-content">
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content" id="modal-xl-content">
      </div>
    </div>
  </div>
  
  <div class="modal fade slide-up" id="reportmodal" style="z-index:9999" tabindex="-1" role="dialog"
      data-keyboard="false" data-backdrop="static" aria-hidden="false">
      <div class="modal-dialog" style="    width: fit-content;">
          <div class="modal-content-wrapper">
              <div class="modal-content" id="report-modal-content">
              </div>
          </div>
      </div>
  </div>

<!-- Footer -->
<footer class="footer mt-auto">
    <div class="copyright bg-white">
        <p>
            Copyright © {{date('Y')}}. All right reserved.
        </p>
    </div>
</footer>

</div> <!-- End Page Wrapper -->
</div> <!-- End Wrapper -->
<script>
    function toTitleCase(str) {
      return str
        .split(' ')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
        .join(' ');
    }
  
  
    function add(url, modal) {
      if (modal.length > 0) {
        $.ajax({
          url: url,
          type: "GET",
          success: function(data) {
            $('#' + modal + '-content').html(data);
            $('#' + modal).modal('show');
          }
        })
      } else {
        window.location.href = url
      }
  
    }
  
    function edit(url, modal) {
      $(".modal").modal('hide');
      $.ajax({
        url: url,
        type: "GET",
        success: function(data) {
          $('#' + modal + '-content').html(data);
          $('#' + modal).modal('show');
        }
      })
    }
  
    function updateActiveStatus(url, table) {
      $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
          if (response.status == 'success') {
            toastr.success(response.message);
          } else {
            toastr.error(response.message);
          }
          $('#' + table).DataTable().ajax.reload();
        }
      })
    }
  
    function destry(url, table) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert customer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete customer!',
        customClass: {
          confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
          cancelButton: 'btn btn-label-secondary waves-effect waves-light'
        },
        buttonsStyling: false
      }).then(function(result) {
        if (result.value) {
          $.ajax({
            url: url,
            type: "GET",
            method: "DELETE",
            data:{_token:"{{csrf_token()}}"},
            success: function(response) {
              if (response.status == 'success') {
                toastr.success(response.message);
                if (table.length > 0) {
                  $('#' + table).DataTable().ajax.reload();
                } else {
                  window.location.reload();
                }
              } else {
                toastr.error(response.message);
              }
            }
          })
        }
      });
    }
  </script>
<!-- Common Javascript -->
<script src="{{asset('assets/plugins/jquery/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/plugins/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-zoom/jquery.zoom.min.js')}}"></script>
<script src="{{asset('assets/plugins/slick/slick.min.js')}}"></script>

<!-- Chart -->
<script src="{{asset('assets/plugins/charts/Chart.min.js')}}"></script>
<script src="{{asset('assets/js/chart.js')}}"></script>

<!-- Google map chart -->
<script src="{{asset('assets/plugins/charts/google-map-loader.js')}}"></script>
<script src="{{asset('assets/plugins/charts/google-map.js')}}"></script>

<!-- Date Range Picker -->
<script src="{{asset('assets/plugins/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/js/date-range.js')}}"></script>
<!-- custom js -->
<script src="{{asset('assets/js/custom.js')}}"></script>
<!-- Data Tables -->
<script src='assets/plugins/data-tables/jquery.datatables.min.js'></script>
<script src='assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
<script src='assets/plugins/data-tables/datatables.responsive.min.js'></script>

{{-- Toastr --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- select2 --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js" integrity="sha512-4MvcHwcbqXKUHB6Lx3Zb5CEAVoE9u84qN+ZSMM6s7z8IeJriExrV3ND5zRze9mxNlABJ6k864P/Vl8m0Sd3DtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>


<!-- Mirrored from andit.co/projects/html/andshop/andshop-dashboard/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 22 Sep 2024 05:05:38 GMT -->
</html>