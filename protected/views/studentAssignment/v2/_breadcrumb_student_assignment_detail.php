<div class="col-md-12">
  <div id="bc1" class="btn-group btn-breadcrumb">
    <?php echo CHtml::link('<i class="fa fa-home"></i> Beranda',array('/site/index'), array('class'=>'btn btn-default')); ?>
    <?php echo CHtml::link('<div>Tugas Siswa</div>',array('/studentAssignment'), array('class'=>'btn btn-default')); ?>
    <?php echo CHtml::link('<div>'.$model->student->display_name.'</div>',array('#'), array('class'=>'btn btn-success')); ?>
  </div>
</div>
