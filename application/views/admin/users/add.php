    <!--Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Questions</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('Questions');?>">All Questions</a></li>
                            <li class="breadcrumb-item active">Add Questions</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Questions</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php alert();?>
                    <!-- form start -->
                    <form action="<?php echo current_url();?>" role="form" name="Member_form" method="post">
                        <input type="hidden" name="<?=$token_name;?>" value="<?=$hash;?>" id="token_val">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Question</label>
                                <textarea name="question" class="form-control" id="question"><?php echo set_value('question');?></textarea>
                                <span class="text-danger"><?php echo form_error('question');?></span>
                            </div>

                            <div class="form-group">
                                <label for="title">Option 1</label>
                                <input type="text" name="option_1" class="form-control" id="option_1" value="<?php echo set_value('option_1');?>">
                                <span class="text-danger"><?php echo form_error('option_1');?></span>
                            </div>

                            <div class="form-group">
                                <label for="title">Option 2</label>
                                <input type="text" name="option_2" class="form-control" id="option_2" value="<?php echo set_value('option_2');?>">
                                <span class="text-danger"><?php echo form_error('option_2');?></span>
                            </div>

                            <div class="form-group">
                                <label for="title">Option 3</label>
                                <input type="text" name="option_3" class="form-control" id="option_3" value="<?php echo set_value('option_3');?>">
                                <span class="text-danger"><?php //echo form_error('option_3');?></span>
                            </div>

                            <div class="form-group">
                                <label for="title">Option 4</label>
                                <input type="text" name="option_4" class="form-control" id="option_4" value="<?php echo set_value('option_4');?>">
                                <span class="text-danger"><?php //echo form_error('option_4');?></span>
                            </div>

                            <div class="form-group">
                                <label for="title">Right answer</label>
                                <input type="text" name="right_answer" class="form-control" id="right_answer" value="<?php echo set_value('right_answer');?>">
                                <span class="text-danger"><?php echo form_error('right_answer');?></span>
                            </div>

                            <div class="form-group">
                                <label for="title">Mark</label>
                                <input type="number" name="mark" class="form-control" id="mark" value="<?php echo set_value('mark');?>">
                                <span class="text-danger"><?php echo form_error('mark');?></span>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <!-- Footer -->
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->