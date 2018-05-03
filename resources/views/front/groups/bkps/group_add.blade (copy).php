    @extends('front.layout.group_app')
    @section('title','Tawasul')
    @section('content')
   <div class="home-container createEventPopup">


        <section class="createEventSection">

            <div class="createEventSection-close">
                <a href="{{ URL::Route('group') }}">Cancel
                    <img src="{{ asset('frontend/images/btn-cancel.png')}}" alt="">
                </a>
            </div>

            <div class="container">
                <!-- ========= Create Event Circle Container Start ========= -->

                <div class="fullHeight formstartContainer startForm">
                    <div class="absCont">
                        <div class="ceCircle">
                            <div class="cirlePoint">
                                <div class="cirlePointInn"></div>
                            </div>
                            <div class="ceTitle">Create Group</div>
                        </div>
                        <!-- ========= Start Container Start ========= -->
                        <div class="startContainer">
                            <h1>Start!</h1>
                            <div class="proceedContainer">
                                <h5>
                                    <a href="javascript:void(0)" id="formStart" class="ceBtnBlue">Proceed</a> or
                                    <span class="pressText">Press</span> ENTER</h5>
                                <input type="text" style="width: 0;height: 0;border: none;" id="formstart" autofocus />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========= Type Form Container Start ========= -->
                <div class="typeFormContainer">
                    <div class="formContainerInn">
                        <form class="typeForm">
                            <ul class="formList mainForm">
                                <li class="formSection formInit">
                                    <div class="inputTitle">
                                        <span class="numberText">1</span> What will be your
                                        <span class="textOne">group name</span>? *</div>
                                    <div class="inputField">
                                        <input type="text" class="formTextField" placeholder="">
                                    </div>
                                    <div class="proceedContainer spaceOne">
                                        <h5>
                                            <a href="javascript:void(0)" id="proceedFirst" class="ceBtnBlue">Proceed</a> or
                                            <span class="pressText">Press</span> ENTER</h5>
                                    </div>
                                </li>
                                <li class="formSection formMove">
                                    <div class="inputTitle">
                                        <span class="numberText">2</span> Can you provide a
                                        <span class="textOne">Cover Image</span> for the Group? *</div>
                                    <div class="inputField">
                                        <div class="browseContainer">
                                            <p>Drag &amp; Drop your files here! or
                                                <input id="upload" type="file" />
                                                <label for="upload">browse</label>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="formSection formMove">
                                    <div class="inputTitle">
                                        <span class="numberText">3</span>Write something about your
                                        <span class="textOne">group</span>? *</div>
                                    <div class="inputField textareaOnly">
                                        <textarea class="formTextField textareaField" rows=""></textarea>
                                    </div>
                                    <div class="proceedContainer spaceOne">
                                        <h5>
                                            <a href="#" class="ceBtnBlue">Proceed</a> or
                                            <span class="pressText">Press</span> ENTER</h5>
                                    </div>
                                </li>
                                <!-- <li>
                                    <div class="inputTitle">
                                        <span class="numberText">4</span> What are the
                                        <span class="textOne">department</span> that will be associated with your group? *</div>
                                    <div class="inputField withArr">
                                        <input class="chosen-value formTextField" type="text">
                                        <ul class="value-list">
                                            <li>Shurooq</li>
                                            <li>Al Qasba</li>
                                            <li>Tarfeeh</li>
                                            <li>Maraya</li>
                                            <li>SBEO</li>
                                            <li>City Sight</li>
                                            <li>SGTS</li>
                                            <li>Sheraa</li>
                                            <li>Tarfeeh</li>
                                            <li>Thaqafa</li>
                                        </ul>
                                    </div>
                                </li> -->
                                <!-- <li class="formSection formMove"> -->
                                    <!-- <div class="inputTitle">
                                        <span class="numberText">4</span> What are the
                                        <span class="textOne">department</span> that will be associated with your group? *</div>
                                    <div class="inputField withArr">
                                        <input class="chosen-value formTextField" type="text">
                                        <ul class="value-list">
                                            <li>Shurooq</li>
                                            <li>Al Qasba</li>
                                            <li>Tarfeeh</li>
                                            <li>Maraya</li>
                                            <li>SBEO</li>
                                            <li>City Sight</li>
                                            <li>SGTS</li>
                                            <li>Sheraa</li>
                                            <li>Tarfeeh</li>
                                            <li>Thaqafa</li>
                                        </ul>
                                    </div> -->
                                    <!--  <div class="inputField withArr">
                                    <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
                                      <option value="AL">Alabama</option>
                                      <option value="WY">Wyoming</option>
                                    </select>
                                  </div> -->
                                <!-- </li> -->
                                <li class="formSection formMove">
                                    <div class="inputTitle">
                                        <span class="numberText">4</span> You
                                        <span class="textOne">Creating</span> a? * </div>

                                          <input type="radio" class="opS0" name="department" id="activityGroup" />
                                          <input type="radio" class="opS0" name="department" id="departmentGroup" />

                                    <div class="inputField eventType">
                                        <ul>
                                            <li class="eventTwo departgroup" >
                                                <label for="departmentGroup">
                                                <h3>Departmental
                                                    <br>Group</h3>
                                                </label>
                                            </li>
                                            <li class="eventFour">
                                                    <label for="activityGroup">
                                                <h3>Activity
                                                    <br>Group</h3>
                                                    </label>
                                            </li>
                                        </ul>
                                    </div>



                                    <div class="inputField withArr">
                                      <div class="form-group">
                                        <label for="title"></label>
                                         <select id="required" multiple="multiple" data-placeholder="Select guest...">
                                              <option>Steven White</option>
                                              <option>Nancy King</option>
                                              <option>Nancy Davolio</option>
                                              <option>Robert Davolio</option>
                                              <option>Michael Leverling</option>
                                              <option>Andrew Callahan</option>
                                              <option>Michael Suyama</option>
                                              <option selected>Anne King</option>
                                              <option>Laura Peacock</option>
                                              <option>Robert Fuller</option>
                                              <option>Janet White</option>
                                              <option>Nancy Leverling</option>
                                              <option>Robert Buchanan</option>
                                              <option>Margaret Buchanan</option>
                                              <option selected>Andrew Fuller</option>
                                              <option>Anne Davolio</option>
                                              <option>Andrew Suyama</option>
                                              <option>Nige Buchanan</option>
                                              <option>Laura Fuller</option>
                                          </select>
                                      </div>
                                    </div>


                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>


            <div class="subMit-bottom">
                <div class="container">
                    <div class="proceedContainer">
                        <h5>
                            <a href="group.html" class="ceBtnBlue">Proceed</a> or
                            <span class="pressText">Press</span> ENTER</h5>
                    </div>
                </div>
            </div>
        </section>
    </div>
   


    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
   
    <script src="{{ asset('frontend/js/custom.js') }}"></script>

   <script src="{{ asset('frontend/js/multiselects.js') }}"></script>

   <script>
       $(document).ready(function() {
           // create MultiSelect from select HTML element
           var required = $("#required").kendoMultiSelect().data("kendoMultiSelect");
           var optional = $("#optional").kendoMultiSelect({
               autoClose: false
           }).data("kendoMultiSelect");

           $("#get").click(function() {
               alert("Attendees:\n\nRequired: " + required.value() + "\nOptional: " + optional.value());
           });
           //-------------------------
           $(".eventType > ul > li").each(function(){
             $(this).click(function(){
               $(".eventType > ul > li").removeClass('active');
               $(this).addClass('active');
             });
           });
       });
   </script>

    <!-- ========= for search area ========= -->
    <script src="{{ asset('frontend/js/classie.js') }}"></script>
    <script src="{{ asset('frontend/js/uisearch.js') }}"></script>
    <script>
        new UISearch(document.getElementById('sb-search'));
    </script>
    <!-- <script src="js/index.js"></script> -->
    <script src="{{ asset('frontend/js/typescript.js') }}"></script>
    <script src="{{ asset('frontend/js/select2.js')}}"></script>
    <script src="{{ asset('frontend/js/select2.full.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection