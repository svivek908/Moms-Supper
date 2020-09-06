    <!--Content Wrapper. Contains page content -->
   <!--  <div class="content-wrapper"> -->
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Moms</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('Admin_dashboard');?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Moms</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= ($status) ? $status : 'All'?> Moms</h3>

                    <div class="card-tools">
                        <!-- <a href="<?php //echo base_url('Moms/add_Moms');?>" class="btn btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Moms</a> -->
                        <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php alert();?>
                    <table class="table table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Create date</th>
                                <th>Full name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                  <!-- Footer -->
                <div class="card-footer clearfix">
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
        <script language="JavaScript" type="text/javascript">
            function ConfirmDelete(){
                return confirm('Are you sure?');
            }

            $(document).ready(function() {

                $('[data-toggle="tooltip"]').tooltip();

                $('#datatable').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo base_url('Msa-moms_list/'.$status)?>",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        {   
                            "targets": [0,4,5,6],//first column / numbering column
                            "orderable": false, //set not orderable 
                        },
                    ]
                });
            });


        </script>
    <!-- </div> -->
    <!-- /.content-wrapper -->
   
