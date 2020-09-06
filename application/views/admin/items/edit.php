    <!--Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Questions</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('Questions');?>">All Questions</a></li>
                            <li class="breadcrumb-item active">Edit Questions</li>
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
                    <h3 class="card-title">Edit Questions</h3>

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
                                <textarea name="question" class="form-control" id="question"><?= $questions->question;?></textarea>
                                <span class="text-danger"><?php echo form_error('question');?></span>
                            </div>

                            <div class="form-group">
                                <label for="title">Option 1</label>
                                <input type="text" name="option_1" class="form-control" id="option_1" value="<?= $questions->option_1;?>" autocomplete ="off">
                                <span class="text-danger"><?php echo form_error('option_1');?></span>
                            </div>

                            <div class="form-group">
                                <label for="title">Option 2</label>
                                <input type="text" name="option_2" class="form-control" id="option_2" value="<?= $questions->option_2;?>" autocomplete ="off">
                                <span class="text-danger"><?php echo form_error('option_2');?></span>
                            </div>

                            <div class="form-group">
                                <label for="title">Option 3</label>
                                <input type="text" name="option_3" class="form-control" id="option_3" value="<?= $questions->option_3;?>" autocomplete ="off">
                                <span class="text-danger"><?php echo form_error('option_3');?></span>
                            </div>

                            <div class="form-group">
                                <label for="title">Option 4</label>
                                <input type="text" name="option_4" class="form-control" id="option_4" value="<?= $questions->option_4;?>" autocomplete ="off">
                                <span class="text-danger"><?php echo form_error('option_4');?></span>
                            </div>

                            <div class="form-group">
                                <label for="title">Right answer</label>
                               <!--  <input type="text" name="right_answer" class="form-control" id="right_answer" value="<?= $questions->right_answer;?>"> -->
                                
                                <select  name="right_answer" class="form-control" id="right_answer">
                                    <option value="option_1" <?php if($questions->right_answer == $questions->option_1){ echo "selected";}?> >option 1</option>
                                    <option value="option_2" <?php if($questions->right_answer == $questions->option_2){ echo "selected";}?> >option 2</option>
                                    <option value="option_3" <?php if($questions->right_answer == $questions->option_3){ echo "selected";}?> >option 3</option>
                                    <option value="option_4" <?php if($questions->right_answer == $questions->option_4){ echo "selected";}?> >option 4</option>
                                </select>
                                <span class="text-danger"><?php echo form_error('right_answer');?></span>
                            </div>

                           <!--  <div class="form-group">
                                <label for="title">Mark</label>
                                <input type="number" name="mark" class="form-control" id="mark" value="<?= $questions->mark;?>">
                                <span class="text-danger"><?php //echo form_error('mark');?></span>
                            </div> -->
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