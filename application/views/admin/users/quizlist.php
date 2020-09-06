    <!--Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users Quiz</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('Admin_dashboard');?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Users Quiz</li>
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
                    <h3 class="card-title">Users Quiz list</h3>

                    <div class="card-tools">
                        <a href="<?php echo base_url('Users');?>" class="btn btn-success"> << Back </a>
                        <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php alert();?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Score</th>
                                <th>Create Date</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($user_quiz) > 0){
                                $i = 0;
                                foreach ($user_quiz as $key => $value) { $i++; ?>
                                <tr>
                                    <td style="width: 10px"><?php echo $i; ?></td>
                                    <td><?php echo $name; ?></td>
                                    <td><?php echo $mobile; ?></td>
                                    <td><?php echo $value->score; ?></td>
                                    <td><?php echo $value->create_at; ?></td>
                                    <!-- <td><a href="<?php //echo base_url('Questions/Edit_question/'.$value->id);?>"
                                        data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> &nbsp;&nbsp;
                                        <a href="<?php //echo base_url('Questions/Delete_question/'.$value->id);?>" onclick="return ConfirmDelete();" data-toggle="tooltip" data-placement="top" title="Delete!"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    </td> -->
                                </tr>  
                            <?php } }else{
                                echo '<tr><td colspan="7">No Record Available</td></tr>';
                            }?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                  <!-- Footer -->
                <div class="card-footer clearfix">
                    <?php echo $link; ?>
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script language="JavaScript" type="text/javascript">
        function ConfirmDelete(){
            return confirm('Are you sure?');
        }
    </script>
