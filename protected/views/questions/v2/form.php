<?php
  if(Yii::app()->user->YiiTeacher){
    $mapel = Lesson::model()->findAll(array('condition'=>'user_id = '.Yii::app()->user->id));
  }else{
    $mapel = Lesson::model()->findAll();
  }

  $lesson = array();
  foreach ($mapel as $value) {
    if($value->moving_class == 1){
      $lesson[$value->id]=$value->name." (".$value->grade->name.")";
    }else{
      $lesson[$value->id]=$value->name." (".$value->class->name.")";
    }
  }

  $tipe=array(NULL=>'Pilihan Ganda');

  $qid=NULL;
  if(isset($_GET['quiz_id'])){
    $qid=$_GET['quiz_id'];
  }

  if(!empty($model->tipe)){
    $selected=$model->tipe;
  }else{
    $selected=NULL;
  }

  if(!empty($model->lesson_id)){
    $lsn=$model->lesson_id;
  }else{
    $lsn=NULL;
  }
?>
<div class="container-fluid">
  <div class="row">
    <?php
      // $this->renderPartial('v2/_breadcrumb_soal_add', array(
      //   'model'=>$model
      // ));
    ?>
    <?php
      if(isset($_GET['quiz_id'])){
        $modelQuiz = Quiz::model()->findByPk($_GET['quiz_id']);

        if($modelQuiz->lesson->moving_class == 1){
          $kelasnya = $modelQuiz->lesson->name;
          $idkelasnya = $modelQuiz->lesson->id;
          $path_nya = 'lesson/'.$idkelasnya;
        }else{
          $kelasnya = $modelQuiz->lesson->name;
          $idkelasnya = $modelQuiz->lesson->id;
          $path_nya = 'lesson/'.$idkelasnya;
        }
      }
    ?>
    <div class="col-md-12">
      <div id="bc1" class="btn-group btn-breadcrumb">
        <?php
        if(isset($_GET['quiz_id'])){
        ?>
      <?php echo CHtml::link('<i class="fa fa-home"></i> Beranda',array('/site/index'), array('class'=>'btn btn-default')); ?>
      <?php echo CHtml::link('<div>Ujian</div>',array('/quiz/index'), array('class'=>'btn btn-default')); ?>
      <?php echo CHtml::link('<div>'.CHtml::encode($kelasnya).'</div>',array($path_nya,'type'=>'ulangan'), array('class'=>'btn btn-default')); ?>
      <?php echo CHtml::link('<div>'.CHtml::encode($modelQuiz->title).'</div>',array('/quiz/view', 'id'=>$modelQuiz->id), array('class'=>'btn btn-default')); ?>
      <?php
          if(!$model->isNewRecord){
            echo CHtml::link('<div>Sunting Soal</div>',array('#'), array('class'=>'btn btn-success'));
          }else{
            echo CHtml::link('<div>Tambah Soal</div>',array('#'), array('class'=>'btn btn-success'));
          }
      ?>
        <?php
          }else{
        ?>
      <?php echo CHtml::link('<i class="fa fa-home"></i> Beranda',array('/site/index'), array('class'=>'btn btn-default')); ?>
      <?php echo CHtml::link('<div>Bank Soal</div>',array('/questions/index'), array('class'=>'btn btn-default')); ?>
      <?php
          if(!$model->isNewRecord){
            echo CHtml::link('<div>Sunting Soal</div>',array('#'), array('class'=>'btn btn-success'));
          }else{
            echo CHtml::link('<div>Tambah Soal</div>',array('#'), array('class'=>'btn btn-success'));
          }
      ?>
        <?php
          }
        ?>
      </div>
    </div>

    <div class="col-lg-12">
      <?php
        $form=$this->beginWidget('CActiveForm', array(
          'id'=>'questions-form',
          'htmlOptions' => array('enctype' => 'multipart/form-data'),
          'enableAjaxValidation'=>false,
        ));
      ?>
      <?php if($qid != NULL){?>
          <?php echo $form->hiddenField($model,'quiz_id',array('class'=>'form-control','value'=>$qid)); ?>
      <?php } ?>
      <?php if(!$model->isNewRecord){ ?>
      <h2>Sunting Soal</h2>
      <?php }else{ ?>
      <h2>Buat Soal Baru</h2>
      <?php } ?>
      <div class="row">
        <div class="col-md-12">
          <h4>Informasi Soal</h4>
          <div class="col-card">
            <div class="col-dropdown">
              <div class="row">
                <div class="col-md-9">
                  <label for="Questions_title">Judul / Kompetensi Dasar</label>
                  <?php echo $form->textField($model,'title',array('class'=>'form-control input-pn input-lg','placeholder'=>'Judul / Kompetensi Dasar','required'=>'required')); ?>
                  <!-- <select name="kompetensiDasar" class="selectpicker form-control" data-style="btn-default input-lg" data-live-search="true" title="Kompetensi Dasar 1">
                    <option>Isi Kompetensi Dasar 1</option>
                    <option>Isi Kompetensi Dasar 2</option>
                    <option>Isi Kompetensi Dasar 3</option>
                    <option>Isi Kompetensi Dasar 4</option>
                  </select> -->
                </div>
                <br class="visible-xs">
                <div class="col-md-3">
                  <label for="Questions_type">Jenis Soal</label>
                  <?php echo $form->dropdownList($model,'type',$tipe,array('class'=>'selectpicker form-control','data-style'=>'btn-default input-lg', 'options'=>array($selected=>array('selected'=>true))))?>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-12">
          <h4>Tambah Soal Wizard <small><i>fitur baru!</i></small></h4>
          <div class="col-card">
            <div class="row">
              <div class="col-xs-12">
                  <ul class="nav nav-pills nav-justified setup-panel">
                      <li id="btn-step-1" class="active"><a href="#step-1">
                          <h4 class="list-group-item-heading">Tahap 1</h4>
                          <p class="list-group-item-text">Import dari Word </p>
                      </a></li>
                      <li id="btn-step-2" class="disabled"><a href="#step-2">
                          <h4 class="list-group-item-heading">Tahap 2</h4>
                          <p class="list-group-item-text">Preview dan Sunting Soal</p>
                      </a></li>
                     <!--  <li class="disabled"><a href="#step-3">
                          <h4 class="list-group-item-heading">Tahap 3</h4>
                          <p class="list-group-item-text"></p>Tambahkan Soal!</p>
                      </a></li> -->
                  </ul>
              </div>
            </div>
            <hr>
            <div class="row">
              <div id="step-1" class="col-md-12">
                <div class="text-center">
                  <img src="<?php echo Yii::app()->theme->baseUrl ?>/images/import-icon.png" alt="" class="pull-left" style="width: 110px;">
                  <h3>Tambahkan Soal dari dokumen <strong>Microsoft Word</strong> dibawah ini!</h3>
                  <p>
                    Anda dapat menyalin dan menempelkan (<i>copy & paste</i>) soal yang ingin anda masukkan di kotak editor dibawah ini.
                    <br>
                    Atau anda dapat mengetikan langsung soal dan jawaban dibawah ini.
                  </p>
                  <p>
                    <a href="#" data-toggle="modal" data-target="#modalPanduanImportWord" class="btn btn-pn-primary btn-sm">
                      <i class="fa fa-question-circle"></i> Panduan Menggunakan <strong>Import dari Word</strong>
                    </a>
                  </p>
                </div>
                <div class="clearfix"></div>
                <div class="rich-textarea-container">
                  <textarea name="name_extword" id="textword" cols="30" rows="10" class="rich-textarea"></textarea>
                </div>
              </div>

               <div id="step-2" class="col-md-12 hide">
                <br>
                 <h4 class="pull-left">Soal </h4>
                <div class="rich-textarea-container">
                  <div class="jawaban-container">
                    <textarea id="soalnya" class="jawaban jawaban-title" name="Questions[text]" data-placeholder="Tuliskan Pertanyaan Disini..">
                      <?php
                        if(!empty($model->text)){
                          echo $model->text;
                        }
                      ?>
                    </textarea>
                    <br/>
                    <br/>
                    <div class="clearfix"></div>
                      <div id="plh">
                        <?php
                          if(!$model->isNewRecord){
                            if(!empty($model->choices)){
                              if($model->type==NULL){
                                $pilihan = json_decode($model->choices, true);
                                $jumPilihan = count($pilihan);

                                $no = 1;
                                foreach($pilihan as $key => $value){
                        ?>
                        <div id="index<?php echo $key; ?>">
                          <h4 class="pull-left">Jawaban <?php echo $no ?></h4>
                          <div class="checkbox card-checkbox pull-right">
                            <label>
                              <?php
                                  if($value == $model->key_answer){
                              ?>
                            <!-- <button type="button" class="btn btn-pn-primary btn-xs"><i class="fa fa-toggle-on"></i> Kunci Jawaban</button> -->
                              <input type="radio" name="answer" value="<?php echo $no;?>" checked required> <span><b>Jadikan Kunci Jawaban</b></span>
                              <?php
                                  }else{
                              ?>
                              <!-- <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-toggle-off"></i> Jadikan Kunci Jawaban</button> -->
                              <input type="radio" name="answer" value="<?php echo $no;?>" required> <span><b>Jadikan Kunci Jawaban</b></span>
                              <?php
                                  }
                              ?>
                              <button type="button" class="btn btn-danger btn-xs" data-index="index<?php echo $key ?>" data-no="<?php echo $key ?>"><i class="fa fa-trash"></i></button>
                            </label>
                          </div>
                          <div class="clearfix"></div>
                          <textarea class="jawaban" name="pil[<?php echo $key?>]" id="pil<?php echo $key?>" data-placeholder="Tuliskan Jawaban <?php echo $no ?> disini...."><?php echo $value ?></textarea>
                        </div>
                        <?php
                                  $no++;
                                }
                              }
                            }
                          }else{
                        ?>
                        <div id="index0">
                          <h4 class="pull-left">Jawaban 1</h4>
                          <div class="checkbox card-checkbox pull-right">
                            <label>
                              <!-- <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-toggle-off"></i>Jadikan Kunci Jawaban</button> -->
                              <input id="rad-opt-A" type="radio" name="answer" value="1"> <span><b>Jadikan Kunci Jawaban</b></span>   
                              <button type="button" class="btn btn-danger btn-xs" data-index="index0" data-no="0"><i class="fa fa-trash"></i></button>
                            </label>
                          </div>
                          <div class="clearfix"></div>
                          <textarea id="pil0" name="pil[0]" data-placeholder="Tuliskan Jawaban 1 disini.."></textarea>
                        </div>
                        <br/>
                        <br/>
                        <div class="clearfix"></div>
                        <div id="index1">
                          <h4 class="pull-left">Jawaban 2</h4>
                          <div class="checkbox card-checkbox pull-right">
                            <label>
                              <!-- <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-toggle-off"></i> Jadikan Kunci Jawaban</button> -->
                              <input id="rad-opt-B" type="radio" name="answer" value="2" > <span><b>Jadikan Kunci Jawaban</b></span>   
                              <button type="button" class="btn btn-danger btn-xs" data-index="index1" data-no="1"><i class="fa fa-trash"></i></button>                              
                            </label>
                          </div>
                          <div class="clearfix"></div>
                          <textarea id="pil1" name="pil[1]" data-placeholder="Tuliskan Jawaban 2 disini.."></textarea>
                        </div>
                        <br/>
                        <br/>
                        <div class="clearfix"></div>
                        <div id="index2">
                          <h4 class="pull-left">Jawaban 3</h4>
                          <div class="checkbox card-checkbox pull-right">
                            <label>
                              <!-- <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-toggle-off"></i> Jadikan Kunci Jawaban</button> -->
                              <input id="rad-opt-C" type="radio" name="answer" value="3" > <span><b>Jadikan Kunci Jawaban</b></span> 
                              <button type="button" class="btn btn-danger btn-xs" data-index="index2" data-no="2"><i class="fa fa-trash"></i></button>
                            </label>
                          </div>
                          <div class="clearfix"></div>
                          <textarea id="pil2" name="pil[2]" data-placeholder="Tuliskan Jawaban 3 disini.."></textarea>
                        </div>
                        <br/>
                        <br/>
                        <div class="clearfix"></div>
                        <div id="index3">
                          <h4 class="pull-left">Jawaban 4</h4>
                          <div class="checkbox card-checkbox pull-right">
                            <label>
                              <!-- <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-toggle-off"></i> Jadikan Kunci Jawaban</button> -->
                              <input id="rad-opt-D" type="radio" name="answer" value="4" > <span><b>Jadikan Kunci Jawaban</b></span> 
                              <button type="button" class="btn btn-danger btn-xs" data-index="index3" data-no="3"><i class="fa fa-trash"></i></button>
                            </label>
                          </div>
                          <div class="clearfix"></div>
                          <textarea id="pil3" name="pil[3]" data-placeholder="Tuliskan Jawaban 4 disini.."></textarea>
                        </div>
                        <br/>
                        <br/>
                        <div class="clearfix"></div>
                        <div id="index3">
                          <h4 class="pull-left">Jawaban 5</h4>
                          <div class="checkbox card-checkbox pull-right">
                            <label>
                              <!-- <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-toggle-off"></i> Jadikan Kunci Jawaban</button> -->
                              <input id="rad-opt-E" type="radio" name="answer" value="4" > <span><b>Jadikan Kunci Jawaban</b></span> 
                              <button type="button" class="btn btn-danger btn-xs" data-index="index4" data-no="4"><i class="fa fa-trash"></i></button>
                            </label>
                          </div>
                          <div class="clearfix"></div>
                          <textarea id="pil4" name="pil[4]" data-placeholder="Tuliskan Jawaban 5 disini.."></textarea>
                        </div>
                      </div>
                    <?php
                      }
                    ?>
                    </div>
                    <div class="text-center">
                      <button type="button" id="addChoices" class="btn btn-success btn-block btn-sm"><i class="fa fa-plus-circle"></i> Tambah Jawaban</button>
                    </div>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>

            </div>
          </div>
         </div>

         <div id="act-step-1" class="col-md-12">
          <div class="col-card">
            <div class="row">
              <div class="col-md-6">
                <!-- <button type="button" class="btn btn-primary btn-lg btn-pn-round btn-block next-step"><i class="fa fa-save"></i> Simpan</button> -->
              </div>
              <div class="col-md-6">
                <button id="submitword" type="button" class="btn btn-pn-primary btn-lg btn-pn-round btn-block next-step">Preview dan Sunting Soal <i class="fa fa-arrow-right"></i></button>
              </div>
            </div>
          </div>
        </div>


        <div id="act-step-2" class="col-md-12 hide">
          <div class="col-card">
            <div class="row">
              <!-- <div class="col-md-4">
                <button type="button" class="btn btn-primary btn-lg btn-pn-round btn-block next-step"><i class="fa fa-plus"></i> Tambah Soal</button>
              </div> -->
              <?php if(!$model->isNewRecord){ ?>
              <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-lg btn-pn-round btn-block next-step"><i class="fa fa-save"></i> Simpan Perubahan</button>
              </div>
              <?php }else{ ?>
              <div class="col-md-6">
                <button type="submit" class="btn btn-primary btn-lg btn-pn-round btn-block next-step"><i class="fa fa-save"></i> Simpan</button>
              </div>
              <div class="col-md-6">
                <button type="submit" class="btn btn-pn-primary btn-lg btn-pn-round btn-block next-step"><i class="fa fa-check-circle"></i> Selesai</button>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>

       
      
      </div>
   </div>
 </div>
      <?php $this->endWidget(); ?>
</div>
  </div>
</div>

 <!-- Modal -->
<div class="modal fade" id="modalPanduanImportWord" tabindex="-1" role="dialog" aria-labelledby="filterPanduanImportWord">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="forgotPasswordLabel">Panduan Tambah Soal Wizard</h4>
      </div>
      <div class="modal-body">
        <h4><i class="fa fa-info-circle"></i> Panduan Menggunakan <strong>Tambah Soal Wizard</strong>:</h4>
        <p>
          Bentuk format teks yang dapat diterima:
          <ul>
            <li>
              Penomoran soal tidak menggunakan numbering
            </li>
            <li>
              Abjad pilihan jawaban tidak menggunakan bullet/numbering
            </li>
            <li>
              Abjad pilihan menggunakan huruf kapital
            </li>
            <li>
              Soal dan pilihan jawaban dipisah menggunakan kalimat <strong>"KUNCI : [Abjad kunci jawaban]"</strong>
            </li>
          </ul>
        </p>
        <h4><i class="fa fa-check-circle"></i> Contoh format soal yang benar:</h4>
        <p>
          <img src="<?php echo Yii::app()->theme->baseUrl ?>/images/contoh-import-word.png" alt="" class="thumbnail" style="max-width: 100%;">
        </p>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function(){

      <?php  if(!$model->isNewRecord){ ?>

         $('#step-2').removeClass('hide');
         $('#step-1').addClass('hide');

      <?php } ?>  


     $("#submitword").click(function(){
        //console.log(tinymce.get('textword').getContent());
        $.post("ajaxparsingtabel",
              {
                  wordhtml: tinymce.get('textword').getContent()
              },
              function(result){
                 var obj = $.parseJSON(result);
                 // console.log(result);
                 console.log(obj);
                 // console.log(obj['jawaban']);
                 // console.log(obj['jawabanA']);
                 // console.log(obj['jawabanB']);
                 // console.log(obj['jawabanC']);
                 // console.log(obj['jawabanD']);
                 // console.log(obj['jawabanE']);
                 // $('#step-2').removeClass('hide');
                 // $('#step-1').addClass('hide');

                 // $('#act-step-2').removeClass('hide');
                 // $('#act-step-1').addClass('hide');

                 // $('#btn-step-1').removeClass('active');
                 // $('#btn-step-1').addClass('disabled');
                 // $('#btn-step-2').removeClass('disabled')
                 // $('#btn-step-2').addClass('active');

                 // tinyMCE.get('soalnya').setContent(obj['soal']);
                 // tinyMCE.get('pil0').setContent(obj['jawabanA']);
                 // tinyMCE.get('pil1').setContent(obj['jawabanB']);
                 // tinyMCE.get('pil2').setContent(obj['jawabanC']);
                 // tinyMCE.get('pil3').setContent(obj['jawabanD']);
                 // tinyMCE.get('pil4').setContent(obj['jawabanE']);

                 // $("#rad-opt-"+obj['jawaban']).attr("checked", "checked");

                 // $("#modalImportSoalWord").modal('hide');

                  
              });
        // alert("sdfasdf");
      });


    <?php
      if(!$model->isNewRecord){
        if(!empty($model->choices)){
          echo "var no = ".$jumPilihan;
        }
      }else{
        echo "var no = 4";
      }
    ?>
    
    $("#addChoices").click(function(){
      no++;
      
      $('#plh').append('<br/><br/><div class="clearfix"></div><div id="index'+ (no - 1) +'"><h4 class="pull-left">Jawaban</h4><div class="checkbox card-checkbox pull-right"><label><input type="radio" name="answer" value="'+ (no) +'" required> <span><b>Jadikan Kunci Jawaban</b></span> <button type="button" class="btn btn-danger btn-xs" data-index="index'+ (no - 1) +'" data-no="'+ (no - 1) +'"><i class="fa fa-trash"></i></button></label></div><div class="clearfix"></div><textarea class="jawaban" name="pil['+ (no - 1) +']" id="pil'+ (no - 1) +'"  data-placeholder="Tuliskan Jawaban disini.."></textarea></div>');
      reloadFunction();
    });

    function reloadFunction(){
      tinymce.init({
          selector: 'textarea',
          theme: 'modern',
          invalid_elements :'script',
          valid_styles : { '*' : 'color,font-size,font-weight,font-style,text-decoration' },
          entity_encoding: 'raw',
          entities: '160,nbsp,38,amp,60,lt,62,gt',
          plugins: [
              "advlist autolink lists link image charmap print preview anchor",
              "searchreplace visualblocks code fullscreen contextmenu",
              "insertdatetime media table contextmenu paste jbimages"
          ],
          contextmenu: "cut copy paste | jbimages inserttable | cell row column deletetable | code preview",
          toolbar: "undo redo | styleselect fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | jbimages | preview",
          contextmenu_never_use_native: true,
          paste_data_images: true,
          relative_urls: false,
          // initline: true,
          menubar: false,            
          setup : function(editor) {
            editor.on('init', function () {
                // Add class on init
                // this also sets the empty class on the editor on init
                if ( editor.getContent() === "" ) {
                    tinymce.DOM.addClass( editor.bodyElement, 'empty' );
                } else {
                    tinymce.DOM.removeClass( editor.bodyElement, 'empty' );
                }
            });
            // You CAN do it on 'change' event, but tinyMCE sets debouncing on that event
            // so for a tiny moment you would see the placeholder text and the text you typed in the editor
            // the selectionchange event happens a lot more and with no debouncing, so in some situations
            // you might have to go back to the change event instead.
            editor.on('selectionchange', function () {
                if ( editor.getContent() === "" ) {
                    tinymce.DOM.addClass( editor.bodyElement, 'empty' );
                } else {
                    tinymce.DOM.removeClass( editor.bodyElement, 'empty' );
                }
            });
            editor.on('change', function () {
                if ( editor.getContent() === "" ) {
                    tinymce.DOM.addClass( editor.bodyElement, 'empty' );
                } else {
                    tinymce.DOM.removeClass( editor.bodyElement, 'empty' );
                }
            });
          }
      });

      $( ".btn-danger" ).click(function() {
        dataID = $(this).attr('data-index');
        console.log(dataID);     
        $( "#"+dataID ).remove();
      });
    }
    reloadFunction();


    // LocalStorage
    var theUrl = $(location).attr('href').split("/");
    var theCon = theUrl[theUrl.length - 2];
    var theMeth = theUrl[theUrl.length - 1];

    if (theCon=="questions" && theMeth == "create") {
      $("#Questions_title").change(function(){
        var theTitle = $("#Questions_title").val();
        if(typeof(Storage) !== "undefined") {
          localStorage.setItem("titleQuestion", theTitle);
        }
      });

      var localTitle = localStorage.getItem("titleQuestion");
      $("#Questions_title").val(localTitle);
    }
  });  
</script>
