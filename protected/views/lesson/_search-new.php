<?php
/* @var $this StudentAssignmentController */
/* @var $model StudentAssignment */
/* @var $form CActiveForm */
$ket=NULL;
$kata=NULL;

if(isset($_GET['tipe'])){
	$ket = $_GET['tipe'];
}

if(isset($_GET['nama'])){
	$kata=$_GET['nama'];
}

?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('lesson/filterLesson'),
	'method'=>'get',
)); ?>
<div class="form-group">
	<?php if(!Yii::app()->user->YiiTeacher){ ?>
	<select class="tipe form-control" name="tipe" id="tipe">
	  <option <?php if($ket == 1) echo "selected";?> value="1">Nama Pelajaran</option>
	  <option <?php if($ket == 2) echo "selected";?> value="2">Kelas</option>
	</select>
	<?php }else{ ?>
		<select class="tipe form-control" name="tipe" id="tipe">
		  <option <?php if($ket == 1) echo "selected";?> value="1" >Nama Pelajaran</option>
		  <option <?php if($ket == 2) echo "selected";?> value="2">Pelajaran</option>
		</select> 
	<?php }?>
</div>
<div class="form-group">
	<input type="text" name="nama" id="nama" class="form-control" value="<?php echo $kata;?>">
</div> 

<!-- <div class="form-group">
	<input type="hidden" name="user_id" id="user_id" value="<?php //echo Yii::app()->user->id;?>">
</div>  -->

<div class="form-group">
	<input type="submit" class="btn btn-primary" value="Cari">
</div>
<script type="text/javascript">
	/*$("#nama").hide();
	var tipe;
	$( "select" ).change(function () {
		tipe = $("#tipe").val();
	    console.log(tipe);
	    $( "select option:selected" ).each(function() {
	    	if(tipe == 1){
	    		$("#nama").show();
	    	}	
	    });
	  })
	  .change();*/
</script>

<?php $this->endWidget(); ?>