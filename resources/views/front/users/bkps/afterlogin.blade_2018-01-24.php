@extends('front.layout.login_layout')
@section('title','Profile')

@section('css')
<link rel="stylesheet" href="{{ asset('frontend/css/jquery.ezdz.css') }}">

<link rel="stylesheet" href="{{ asset('frontend/css/tinyscrollbar.css') }}" type="text/css" media="screen"/>
<link href="{{ asset('frontend/css/animate.min.css') }}" rel="stylesheet">
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>
<link rel="stylesheet" href="{{ asset('frontend/css/CropBox.css') }}">
@endsection
@section('content')

<div id="wrap">
    <div class="cube">
      <section class="page active face front" id="home">
              <div class="overview">
              <div class="register-in">
          <div class="act-table-cell ver-middle">
          <div class="register-top">
          <img src="{{ asset('frontend/images/reg-icon.jpg') }}" alt=""/>
          <span  class="animated zoomIn">Registration</span>
          <label class="animated infinite bounce down_arrow"><img src="{{ asset('frontend/images/reg-arrow.jpg') }}" alt=""/></label>
      </div>
           <h1><span>Hello <label>{{ $userInfo->display_name }},</label></span></h1>

      <div class="reg-body">
            <p>You are <input type="text" value="{{ $userInfo->display_name }}" readonly="readonly" placeholder="Full Name" data-autosize-input='{ "space": 20 }' />, working in our <input type="text" class="in2" value="{{ $userInfo->department->name }}" readonly="readonly" placeholder="Department" data-autosize-input='{ "space": 20 }' /> Department as <input type="text" class="in3" value="{{ $userInfo->designation->name }}" readonly="readonly" placeholder="Title" data-autosize-input='{ "space": 20 }' />.</p>

              <p>You have joined <input type="text" class="in3" value="{{ $userInfo->company->name }}" readonly="readonly" placeholder="Company" data-autosize-input='{ "space": 20 }' /> on <input type='text' id='datetimepicker' placeholder="DD/MM/YYYY" data-date-format="dd/mm/yyyy" value="{{ \DateTime::createFromFormat('Y-m-d', $userInfo->date_of_joining)->format('d/m/Y') }}" readonly="readonly" class="date" />.</p>

              <p>Can you tell me your date of birth <input type='text' placeholder="DD/MM" id="birthday" readonly="readonly"  data-date-format="dd/mm" class="date1" value="{{ \DateTime::createFromFormat('Y-m-d', $userInfo->date_of_birth)->format('d/m') }}" data-autosize-input='{ "space": 20 }'/>.</p>

              <p>You can be reached at <input type="text" readonly="readonly" placeholder="Phone No." value="{{ $userInfo->mobile }}" class="con" data-autosize-input='{ "space": 20 }' /> or on your E-Mail <input type='text' placeholder="E-Mail" value="{{ $userInfo->email }}" readonly="readonly" class="email" data-autosize-input='{ "space": 20 }'/>.</p>
          </div>

            <header>
              <nav class="text-center">
                <ul class="inline-block">
                  <li><a href="#" data-direction="back"><img src="{{ asset('frontend/images/arrow-right.png') }}" alt=""/></a>
                  <div class="clearfix"></div>
                </ul>
              </nav>
              <a class="skip_first" href="{{ URL::Route('home') }}">Skip</a></li>
            </header>
          </div>
        </div>
            </div>
      </section>

     {!! Form::open(['method' => 'post','files' => true, 'id'=>'profileUpdate', 'route' => array('store_profile')]) !!}
     {!! Form::hidden('page_name','after-login') !!}
      <section class="page face back" id="portfolio">
              <div class="overview">
            <div class="register-in">
          <div class="act-table-cell ver-middle">

      <div class="reg-body reg-body2">
            <p>Write something about yourself:</p>
              <div class="paper">
          <div class="paper-content">
            <!-- <textarea autofocus>I am...</textarea> -->
            {!! Form::textarea('description',$userInfo->description, ['id' => 'description', 'maxlength' => '500', 'class' => 'form-control']) !!}
            
          </div>
          <span id="charNum"></span>
        </div>

              <p>Please upload an image of yourself:</p>
                <div class="croppings">
                  <input id="open" name="profile_photo" type="file" class="fileload" value="Browse your files">
                  <label for="open" style="width: 90%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block;">
                    <span class="cropped" style="margin-right:10px;"></span>
                    Browse your files
                  </label>

                </div>

                <p>Would you like to set a cover page on your Tawasul profile?</p>

                <div class="croppings1">
                  <input id="open1" name="cover_photo" type="file" class="fileload" value="Browse your files">
                  <label for="open1" style="width: 90%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block;">
                    <span class="cropped1" style="margin-right:10px;"></span>
                    Browse your files
                  </label>

                </div>

              <div class="sub-area">

              <input type="hidden" name="hdn_profile_photo" id="hdn_profile_photo">
              <input type="hidden" name="hdn_cover_photo"   id="hdn_cover_photo">

              <input type="submit" value="Submit"/> <span>or</span> <a href="{{ URL::Route('home') }}">Skip</a>
              </div>
          </div>


          </div>
        </div>
    </div>
      </section>
       {!! Form::close() !!}

      <section class="page face top" id="about">
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
      </section>
    </div>
  </div>
<div class="pop hidden">
    <div class="imageBox" id="im">
      <div id="thumbbox" class="thumbBox"></div>
      <div class="spinner" style="display: none">Loading...</div>
    </div>
    <div class="action">
      <!-- <div class="brows-butt">
        <input type="file" id="file" data-exist="false">
      </div> -->
      <div class="button-crop">
        <span class="btnCrop" id="btnCrop">
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

@endsection

@section('script')

<script src="{{ asset('frontend/js/jquery.tinyscrollbar.js') }}"></script>
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


<script src="{{ asset('frontend/js/bootstrap-datepicker.js') }}"></script>

<!--/////////////image crop js///////////////-->
<script src="{{ asset('frontend/js/CropBox.js') }}"></script>
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

          var thisID = $(this).attr("id");          
          $('.pop').removeClass('hidden').addClass('show');
          $('body').css({
            overflow: 'hidden'
          });
          if (thisID !== 'open') {
            $("#thumbbox").addClass("banner");
            boxValue = 'banner';
          } else {
            $("#thumbbox").removeClass("banner");
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
      $('#btnCrop').on('click', function () {
        var img = cropper.getDataURL();
        if (boxValue == 'dp') {
          $('#dp').remove();
          $('.cropped').append('<img id="dp" src="' + img + '">');
          $('#open').removeAttr("value");
        } else if (boxValue == 'banner') {
          $('#banner').remove();
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


@endsection