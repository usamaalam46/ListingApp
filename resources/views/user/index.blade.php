@extends('layouts.app')
@section('css')
<style>
  .container-fluid {
    margin-right: 10% !important;
  }
</style>
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<!-- <button class="btn btn-default" data-toggle="modal" data-target="#create-category">
  Add Category
</button> -->


<div id="create-category" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Add Category</h3>
      </div>
      <div class="modal-body">
        <form action="{{ route('category.store') }}" method="post">
          @csrf
          <div class="form-group mb-20">
            <input type="text" name="title" id="title" class="form-control" placeholder="Title in English" required>
          </div>
          <div class="form-group mb-20">
            <input type="text" name="title_arabic" id="title_arabic" class="form-control" placeholder="Title in Arabic" required>
          </div>
          <div class="form-group mb-20">
            <textarea name="description" class="form-control" id="" cols="30" rows="3" placeholder="Description"></textarea>
          </div>
          <div class="form-group mb-20">
            <textarea name="description_arabic" class="form-control" id="" cols="30" rows="3" placeholder="Description Arabic"></textarea>
          </div>
          <div class="form-group mb-20">
            <select name="is_featured" id="is_featured" class="form-control">
              <option value="1">Featured</option>
              <option value="0">Non Featured</option>
            </select>
          </div>
          <div class="form-group mb-20">
            <select name="active" id="active" class="form-control">
              <option value="1">Active</option>
              <option value="0">Non Active</option>
            </select>
          </div>
          <div class="form-group mb-20">
            <select name="show_menu" id="show_menu" class="form-control">
              <option value="1">Show in Menu</option>
              <option value="0">Non Show</option>
            </select>
          </div>
          <div class="button-group d-flex pt-25">
            <button class="btn btn-primary btn-default btn-squared text-capitalize">
              add new category
            </button>
            <!-- <button data-dismiss="modal"class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light">cancel</button> -->
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@if(isset($users) && count($users) !=0)
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>User</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Verify</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                  <tr>

                    <td>{{isset($user->name)? $user->name : ''}}</td>
                    <td>{{isset($user->email)? $user->email : ''}}</td>
                    <td>{{$user->role}}</td>
                    @if(isset($user->email_verified_at))
                    <td><span class="badge badge-success">Verify</span></td>
                    @else
                    <td><span class="badge badge-danger">Not Verified </span></td>
                    @endif
                  </tr>
                  @endforeach
                </tbody>
                {!! $users->links() !!}
              </table>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>

  <!-- /.content -->

</div>
@else
<h3 class="card-title">yet not added Category</h3>
@endif
@endsection

@section('js')
<script type="text/javascript">
  $(function() {
    $("#example2").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>
@endsection