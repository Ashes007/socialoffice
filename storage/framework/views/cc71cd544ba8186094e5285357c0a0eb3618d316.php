
<?php $__env->startSection('title','Profile'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('frontend/css/jquery.ezdz.css')); ?>">

<link rel="stylesheet" href="<?php echo e(asset('frontend/css/tinyscrollbar.css')); ?>" type="text/css" media="screen"/>
<link href="<?php echo e(asset('frontend/css/animate.min.css')); ?>" rel="stylesheet">
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>
<link rel="stylesheet" href="<?php echo e(asset('frontend/css/CropBox.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('frontend/css/bootstrap-datetimepicker.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div id="wrap">
    <div class="cube">

    <section class="page active face front" id="home">
              <div class="overview">
              <div class="register-in">
          <div class="act-table-cell ver-middle">
          <div class="register-top">
          <img src="<?php echo e(asset('frontend/images/reg-icon.jpg')); ?>" alt=""/>
          <span  class="animated zoomIn"><?php echo e(trans('usersAfterLogin.Update_Your_Profile')); ?></span>
          <label class="animated infinite bounce down_arrow"><img src="<?php echo e(asset('frontend/images/reg-arrow.jpg')); ?>" alt=""/></label>
      </div>
           <h1><span><?php echo e(trans('usersAfterLogin.Hello')); ?> <label><?php echo e($userInfo->display_name); ?>,</label></span></h1>
       <?php echo Form::open(['method' => 'post','files' => true, 'id'=>'profileUpdate', 'route' => array('store_profile')]); ?>    
      <div class="reg-body">
            <p><?php echo e(trans('usersAfterLogin.You_are')); ?> <input type="text" value="<?php echo e($userInfo->display_name); ?>" readonly="readonly" placeholder="Full Name" data-autosize-input='{ "space": 20 }' />, <?php echo e(trans('usersAfterLogin.working_in_our')); ?> <input type="text" class="in2" value="<?php echo e($userInfo->department->name); ?>" readonly="readonly" placeholder="Department" data-autosize-input='{ "space": 20 }' /> <?php echo e(trans('usersAfterLogin.Department_as')); ?> <input type="text" class="in3" value="<?php echo e($userInfo->designation->name); ?>" readonly="readonly" placeholder="Title" data-autosize-input='{ "space": 20 }' />.</p>

              <p><?php echo e(trans('usersAfterLogin.You_have_joined')); ?> <input type="text" class="in3" value="<?php echo e($userInfo->company->name); ?>" readonly="readonly" placeholder="Company" data-autosize-input='{ "space": 20 }' /> <?php echo e(trans('usersAfterLogin.on')); ?> <input type='text' placeholder="DD/MM/YYYY" data-date-format="dd/mm/yyyy" value="<?php echo e(($userInfo->date_of_joining != '') ? \DateTime::createFromFormat('Y-m-d', $userInfo->date_of_joining)->format('d/m/Y') : ''); ?>" readonly="readonly" class="date" />.</p>

              <p><?php echo e(trans('usersAfterLogin.Can_you_tell_me_your_date_of_birth')); ?> <input type='text' placeholder="DD/MM" readonly="readonly"  data-date-format="dd/mm" class="date1" value="<?php echo e(($userInfo->date_of_joining != '') ? \DateTime::createFromFormat('Y-m-d', $userInfo->date_of_birth)->format('d/m') : ''); ?>" data-autosize-input='{ "space": 20 }'/>.</p>

              <p><?php echo e(trans('usersAfterLogin.You_can_be_reached_at')); ?> <input type="text" readonly="readonly" placeholder="Phone No." value="<?php echo e($userInfo->mobile); ?>" class="con" data-autosize-input='{ "space": 20 }' /> <?php echo e(trans('usersAfterLogin.or')); ?> <br/> <?php echo e(trans('usersAfterLogin.at')); ?> <input type='text' placeholder="E-Mail" value="<?php echo e($userInfo->email); ?>" readonly="readonly" class="email" data-autosize-input='{ "space": 20 }'/>.</p>
          </div>

            <header>
              <nav class="text-center">
                <ul class="inline-block">
                  <li><a href="#" data-direction="back"><img src="<?php echo e(asset('frontend/images/arrow-right.png')); ?>" alt=""/></a>
                  <div class="clearfix"></div>
                </ul>
              </nav>
              <!-- <a class="skip_first" href="<?php echo e(URL::Route('home')); ?>">Skip</a> -->
              </li>
            </header>
          </div>
        </div>
            </div>
      </section>
      
     
     <?php echo Form::hidden('page_name','update-profile'); ?>

      <section class="page face back" id="portfolio">
              <div class="overview">
            <div class="register-in">
          <div class="act-table-cell ver-middle">

      <div class="reg-body reg-body2">
            <p><?php echo e(trans('usersAfterLogin.Write_something_about_yourself')); ?></p>
              <div class="paper">
          <div class="paper-content">
            <!-- <textarea autofocus>I am...</textarea> -->
            <?php echo Form::textarea('description',$userInfo->description, ['id' => 'description', 'maxlength' => '500', 'class' => 'form-control']); ?>

            
          </div>
          <span id="charNum"></span>
        </div>

              <p><?php echo e(trans('usersAfterLogin.Please_upload_an_image_of_yourself')); ?></p>
                <div class="croppings">
                  <input id="open" name="profile_photo" type="file" class="fileload" value="Update your files">
                  <label for="open" style="width: 90%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block;">
                    <span class="cropped" style="margin-right:10px;">
                      <?php if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo))): ?>
                      <img id="update_profile_photo" src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo)); ?>" alt=""/>
                      <?php endif; ?>
                    </span>
                    <?php echo e(trans('usersAfterLogin.Update_your_files')); ?>

                  </label>

                </div>

                <p><?php echo e(trans('usersAfterLogin.Would_you_like_to_set_a_cover_page_on_your_Tawasul_profile')); ?></p>

                <div class="croppings1">
                  <input id="open1" name="cover_photo" type="file" class="fileload" value="Update your files">
                  <label for="open1" style="width: 90%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block;">
                    <span class="cropped1" style="margin-right:10px;">
                      <?php if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/cover_photo/thumbnails/' . \Auth::guard('user')->user()->cover_photo))): ?>
                      <img id="update_cover_photo" src="<?php echo e(asset('uploads/user_images/cover_photo/thumbnails/'.\Auth::guard('user')->user()->cover_photo)); ?>" alt=""/>
                      <?php endif; ?>
                    </span>
                    <?php echo e(trans('usersAfterLogin.Update_your_files')); ?>

                  </label>

                </div>

              <div class="sub-area">

              <input type="hidden" name="hdn_profile_photo" id="hdn_profile_photo">
              <input type="hidden" name="hdn_cover_photo"   id="hdn_cover_photo">

              <input type="submit" value="<?php echo e(trans('usersAfterLogin.Update')); ?>"/> <span><?php echo e(trans('usersAfterLogin.or')); ?></span> <a href="<?php echo e(URL::Route('home')); ?>"><?php echo e(trans('usersAfterLogin.Cancel')); ?></a>
              </div>
          </div>


          </div>
        </div>
    </div>
      </section>
       <?php echo Form::close(); ?>


      <!-- <section class="page face top" id="about">
        <div class="act-table text-center">
          <div class="act-table-cell ver-middle">about Page</div>
        </div>
      </section>
      <section class="page face right" id="contact">
        <div class="act-table text-center">
          <div class="act-table-cell ver-middle">contact Page</div>
        </div>
      </section>
      <section class="page face bottom" id="blog">
        <div class="act-table text-center">
          <div class="act-table-cell ver-middle">blog Page</div>
        </div>
      </section>
      <section class="page face left" id="article">
        <div class="act-table text-center">
          <div class="act-table-cell ver-middle">article Page</div>
        </div>
      </section> -->
    </div>
  </div>
<div class="pop hidden">
    <div class="imageBox" id="im">
      <div id="thumbbox" class="thumbBox"></div>
      <div class="spinner" style="display: none"><?php echo e(trans('usersAfterLogin.Loading')); ?></div>
       <button class="buttonCrop deskVersion" ><?php echo e(trans('usersAfterLogin.OK')); ?></button>
    </div>
    <div class="action">
      <div class="button-crop">
        <span class="btnCrop buttonCrop mobileVersion" id="btnCrop">
          <input type="button" value="">
        </span>
        <span class="btnzoom" id="btnZoomIn">
          <input type="button" value="">
        </span>
        <span class="btnzoomo" id="btnZoomOut">
          <input type="button" value="">
        </span>
        <span id="btnClose">
          <input type="button" value="X">
        </span>
      </div>

    </div>
    <div class="arrows hidden-md hidden-lg">
      <span class="moveButton" id="btnTop">
        <input type="button" value="">
      </span>
      <span class="moveButton" id="btnDown">
        <input type="button" value="">
      </span>
      <span class="moveButton" id="btnLeft">
        <input type="button" value="">
      </span>
      <span class="moveButton" id="btnRight">
        <input type="button" value="">
      </span>
    </div>
  </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script src="<?php echo e(asset('frontend/js/jquery.tinyscrollbar.js')); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                var $scrollbar = $("#scrollbar3");
                $scrollbar.tinyscrollbar();
            });
      $(document).ready(function()
            {
        var $scrollbar = $("#scrollbar4");
        $scrollbar.tinyscrollbar();
            });
        </script>
<script>

(function(document, window, $){
  $(document).ready(function(){

    // Variables
    var
      windowWidth = $(window).width(),
      windowHeight = $(window).height(),
      $header = $('header');

    // header anchor tags
    function headerAnchors(){
      var pageDirection = '';
      var thisElement;
      var timeout;
      $header.find('nav li a').click(function(event){
        event.preventDefault();
        window.scrollTo(0,0);
        $('.cube').removeClass('reverse-' + pageDirection);
        thisElement = $(this);
        pageDirection = thisElement.data('direction');
        reverseDirection = thisElement.data('reverse-direction');
        thisElement.parent().addClass('active').siblings().removeClass('active');
          $('.cube').addClass('reverse-' + pageDirection);

          $header.addClass('go-out');
        $('#wrap').addClass('active');
        clearTimeout(timeout);
        timeout = setTimeout(function(){
          $header.removeClass('go-out');
          $('#wrap').removeClass('active');
        }, 1000);
      });
    }headerAnchors();
    $(window).resize(function(){

      // Vars
        windowWidth = $(window).width();
        windowHeight = $(window).height();
      // Functions
    });
  });
})(document, window, jQuery);

</script>

<!--/////////////page slider///////////////-->

<script type="text/javascript">
var Plugins;(function(n){var t=function(){function n(n){typeof n=="undefined"&&(n=30);this.space=n}return n}(),i;n.AutosizeInputOptions=t;i=function(){function n(t,i){var r=this;this._input=$(t);this._options=$.extend({},n.getDefaultOptions(),i);this._mirror=$('<span style="position:absolute; top:-999px; left:0; white-space:pre;"/>');$.each(["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],function(n,t){r._mirror[0].style[t]=r._input.css(t)});$("body").append(this._mirror);this._input.on("keydown keyup input propertychange change",function(){r.update()});(function(){r.update()})()}return n.prototype.getOptions=function(){return this._options},n.prototype.update=function(){var n=this._input.val()||"",t;n!==this._mirror.text()&&(this._mirror.text(n),t=this._mirror.width()+this._options.space,this._input.width(t))},n.getDefaultOptions=function(){return this._defaultOptions},n.getInstanceKey=function(){return"autosizeInputInstance"},n._defaultOptions=new t,n}();n.AutosizeInput=i,function(t){var i="autosize-input",r=["text","password","search","url","tel","email","number"];t.fn.autosizeInput=function(u){return this.each(function(){if(this.tagName=="INPUT"&&t.inArray(this.type,r)>-1){var f=t(this);f.data(n.AutosizeInput.getInstanceKey())||(u==undefined&&(u=f.data(i)),f.data(n.AutosizeInput.getInstanceKey(),new n.AutosizeInput(this,u)))}})};t(function(){t("input[data-"+i+"]").autosizeInput()})}(jQuery)})(Plugins||(Plugins={}))
</script>


<script src="<?php echo e(asset('frontend/js/bootstrap-datepicker.js')); ?>"></script>
<script type="text/javascript">
            $(function () {
                $('#date_of_joining').datepicker(function(){
                  format: 'dd/mm/yyyy'
                });
                $('#birthday').datepicker(function(){
                  format: 'dd/mm'
                });

                
            });
</script>

<!--/////////////image crop js///////////////-->
<script src="<?php echo e(asset('frontend/js/CropBox.js')); ?>"></script>
  <script type="text/javascript">
    $(window).load(function () {
      var options = {
        thumbBox: '.thumbBox',
        spinner: '.spinner',
        imgSrc: 'avatar.png'
      }
      var cropper;
      var reader;
      var boxValue;
      $('.fileload').each(function () {
        $(this).change(function () {

          var totalFile = this.files.length;
          for (var i = 0; i < totalFile; i++) {

                var fileInfo = this.files[i];
                var fileType = fileInfo["type"];
                var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png"];
                if ($.inArray(fileType, ValidImageTypes) < 0) {

                      $.alert({
                              title: '<?php echo e(trans("common.Alert")); ?>',
                              content: '<?php echo e(trans("common.only_JPEG_JPG_PNG_are_allowed")); ?>',
                              icon: 'fa fa-rocket',
                              type: 'blue',
                              animation: 'scale',
                              closeAnimation: 'scale',
                              animateFromElement: false,
                              buttons: {
                                  okay: {
                                  text: '<?php echo e(trans("common.Okay")); ?>',
                                  btnClass: 'btn-blue'
                                  }
                              }
                          });

                      $(this).val('');
                      return false;
                }
          }

          var thisID = $(this).attr("id");          
          $('.pop').removeClass('hidden').addClass('show');
          $('body').css({
            overflow: 'hidden'
          });
          if (thisID !== 'open') {
            $("#thumbbox").addClass("banner");
            $(".buttonCrop").addClass("banner");
            boxValue = 'banner';
          } else {
            $("#thumbbox").removeClass("banner");
            $(".buttonCrop").removeClass("banner");
            boxValue = 'dp';
          }
          // ----------------
          reader = new FileReader();
          reader.onload = function (e) {
            options.imgSrc = e.target.result;
            cropper = $('.imageBox').cropbox(options);
            cropper.existimage = 1;
          }
          reader.readAsDataURL(this.files[0]);

          // -----------------
        });
      });

      // $('#file').on('change', function () {
      //   $("#file").attr('data-exist', 'true');
      //   reader = new FileReader();
      //   reader.onload = function (e) {
      //     options.imgSrc = e.target.result;
      //     cropper = $('.imageBox').cropbox(options);
      //     cropper.existimage = 1;
      //   }
      //   reader.readAsDataURL(this.files[0]);
      // })
      $('.buttonCrop').on('click', function () {
        var img = cropper.getDataURL();
        if (boxValue == 'dp') {
          $('#dp').remove();
          $('#update_profile_photo').remove();
          $('.cropped').append('<img id="dp" src="' + img + '">');
          $('#open').removeAttr("value");
        } else if (boxValue == 'banner') {
          $('#banner').remove();
          $('#update_cover_photo').remove();
          $('.cropped1').append('<img id="banner" src="' + img + '">');
          $('#open1').removeAttr("value");
        }
        $('.pop').addClass('hidden');
        $('body').removeAttr('style');
        // $('.fileload').each(function(){
        //  $("#fileform")[0].reset();
        // });
        // console.log('reader ', reader);
        // reader = null;
        // $(".imageBox").removeAttr('style');
        // $("#file").attr('data-exist', 'false');

      });
      $('#btnZoomIn').on('click', function () {
        cropper.zoomIn();
      });
      $('#btnZoomOut').on('click', function () {
        cropper.zoomOut();
      });
      $("#btnClose").on('click', function () {
        $('.pop').addClass('hidden');
        $('body').removeAttr('style');
      });
    });


    $(".moveButton").each(function () {
      $(this).click(function () {
        var backPosition = $("#im").css('background-position').split(" ");
        var xPos = parseInt(backPosition[0]);
        var yPos = parseInt(backPosition[1]);
        var thisid = $(this).attr('id');

        var thumbWidth = parseInt($("#thumbbox").css('width'));
        // var thumbHeight = parseInt($("#thumbbox").css('height'));
        var objSize = $("#im").css('background-size').split(' ');
        var objW = parseInt(objSize[0]);

        if (thisid === 'btnTop') {
          $("#im").css({
            backgroundPosition: xPos + 'px ' + (yPos - 5) + 'px'
          });
        } else if (thisid === 'btnDown') {
          $("#im").css({
            backgroundPosition: xPos + 'px ' + (yPos + 5) + 'px'
          });
        } else if (thisid === 'btnRight') {
          if (objW <= thumbWidth) {
            $("#im").css({
              backgroundPosition: xPos + 'px ' + yPos + 'px'
            });
          } else {
            $("#im").css({
              backgroundPosition: (xPos + 5) + 'px ' + yPos + 'px'
            });
          }

        } else if (thisid === 'btnLeft') {

          if (objW <= thumbWidth) {
            $("#im").css({
              backgroundPosition: xPos + 'px ' + yPos + 'px'
            });
          } else {
            $("#im").css({
              backgroundPosition: (xPos - 5) + 'px ' + yPos + 'px'
            });
          }

        } else {
          return false;
        }
      });
    });
  </script>
  <script>

    $("#profileUpdate").on('submit',(function(e){
        $('#hdn_profile_photo').val($('#dp').attr('src'));  
        $('#hdn_cover_photo').val($('#banner').attr('src'));

    }));
  </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.login_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>