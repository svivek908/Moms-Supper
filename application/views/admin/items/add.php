 <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Item</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#<?php //echo base_url('Questions');?>">All Item</a></li>
                            <li class="breadcrumb-item active">Add Item</li>
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
                    <h3 class="card-title">Add Item</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php alert();?>
                    <!-- form start -->
                    <form action="#" role="form" name="item_form" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Name</label>
                                        <input type="text" name="name" class="form-control" id="name" value="<?php echo set_value('name');?>" autocomplete ="off">
                                        <span class="text-danger"><?php echo form_error('name');?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Category</label>
                                        <select  name="category" class="form-control" id="category" value="<?php echo set_value('category');?>">
                                            <option value="">Select category</option>
                                            <option value="Veg">Veg</option>
                                            <option value="Nonveg">Nonveg</option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('category');?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title">Description</label>
                                <textarea name="description" class="form-control" id="description"><?php echo set_value('description');?></textarea>
                                <span class="text-danger"><?php echo form_error('description');?></span>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Status</label>
                                        <select  name="status" class="form-control" id="status" value="<?php echo set_value('status');?>">
                                            <option value="">Select status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('category');?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">File input</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input" id="image">
                                                <label class="custom-file-label" for="image">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('image');?></span>
                                    </div>
                                </div>
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