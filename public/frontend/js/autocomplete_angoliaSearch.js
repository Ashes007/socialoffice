/* Downloaded from https://www.codeseek.co/ */
'use strict';

//for autocomplete
var client = algoliasearch('YSH65GN3MY', '909af66ddb45355625135f076718476b');
var index = client.initIndex('TAWASUL');
var eventindex = client.initIndex('TAWASUL-Events');
var groupindex = client.initIndex('TAWASUL-Groups');
var html = '';
autocomplete('#aa-search-input', { hint: true }, [
  {
    source: autocomplete.sources.hits(index, { hitsPerPage: 5 }),
    displayKey: 'employeeName',
    templates: {
      header: '<div class="aa-suggestions-category" >User</div>',
      suggestion: function(suggestion) {
        
        return '<div class="'+suggestion.alpha+' employeeSearch"  onclick="location.href=\''+USER_PROFILE_URL+suggestion.objectID+'\'"><div class="emDirectory-block-single"><div class="blockSingle-img"><img src="'+USER_IMAGE_URL+suggestion.profile_photo+'" alt=""></div><div class="blockSingleCont"><h2>'+suggestion._highlightResult.employeeName.value+' <br> <span>'+suggestion.designation+'</span> </h2></div></div></div>';
      }
    }
  },
  {
    source: autocomplete.sources.hits(eventindex, { hitsPerPage: 5 }),
    displayKey: 'eventName',
    templates: {
      header: '<div class="aa-suggestions-category" >Event</div>',
      suggestion: function(suggestion) {
        
        //if(suggestion.eventStatus == 'Active')
        //return '<span>'+suggestion._highlightResult.eventName.value+'<span>';
        //return '<div class="employeeSearch eventSearch" onclick="location.href=\''+USER_PROFILE_URL+suggestion.objectID+'\'"><div class="emDirectory-block-single"><div class="blockSingle-img"><img src="'+USER_IMAGE_URL+suggestion.eventProfileImage+'" alt=""></div><div class="blockSingleCont"><h2>'+suggestion._highlightResult.eventName.value+' <br> <span>'+suggestion.eventStartDate+'</span> </h2></div></div></div>';

        return '<div class="employeeSearch" onclick="location.href=\''+BASE_URL+'/event/details/'+suggestion.encryptId+'\'"><div class="emDirectory-block-single"><div class="blockSingle-img"><img src="'+EVENT_PROFILE_IMG+suggestion.eventProfileImage+'" alt=""></div><div class="blockSingleCont"><h2>'+suggestion._highlightResult.eventName.value+' <br> <span>'+suggestion.eventStartDate+'</span></span> </h2></div></div></div>';

      }
    }
  },
  {
    source: autocomplete.sources.hits(groupindex, { hitsPerPage: 5 }),
    displayKey: 'groupName_en',
    templates: {
      header: '<div class="aa-suggestions-category" >GroupList</div>',
      suggestion: function(suggestion) {
        var members = suggestion.groupMembers.split(',');
        if(suggestion.groupStatus == 'Active' && (jQuery.inArray(CURRENT_USER, members) !== -1)){
        //alert(GROUP_PROFILE_IMG+suggestion.groupProfileImage);
          //return '<div class="emDirectory-block-single" onclick="location.href=\''+BASE_URL+'/group-details/'+suggestion.group_encode_id+'\'"><div class="blockSingle-img"><img src="'+GROUP_PROFILE_IMG+suggestion.groupProfileImage+'" alt=""></div><div class="blockSingleCont"><h2>'+suggestion._highlightResult.groupName_en.value+'</h2></div></div>';
        
        //return '<div class="employeeSearch groupSearch" onclick="location.href=\''+BASE_URL+'/group-details/'+suggestion.group_encode_id+'\'"><div class="emDirectory-block-single"><div class="blockSingle-img"><img src="'+GROUP_PROFILE_IMG+suggestion.groupProfileImage+'" alt=""></div><div class="blockSingleCont"><h2>'+suggestion._highlightResult.groupName_en.value+'</h2></div></div></div>';

        return '<div class="employeeSearch" onclick="location.href=\''+BASE_URL+'/group-details/'+suggestion.group_encode_id+'\'"><div class="emDirectory-block-single"><div class="blockSingle-img"><img src="'+GROUP_PROFILE_IMG+suggestion.groupProfileImage+'" alt=""></div><div class="blockSingleCont"><h2>'+suggestion._highlightResult.groupName_en.value+'</span> </h2></div></div></div>';
        }
      }
    }
  }
]).on('autocomplete:selected', function(event, suggestion, dataset) {

  //$('#search-input').val(suggestion.employeeName);

  // var html = '<li class="'+suggestion.alpha+'"><div class="emDirectory-block-single"><div class="emailPop"><a href="mailto:'+suggestion.email+'"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></div><div class="blockSingle-img"><img src="'+suggestion.profile_photo+'" alt=""></div><div class="blockSingleCont"><h2>'+suggestion._highlightResult.employeeName.value+' <br> <span>'+suggestion.designation+'</span> </h2><h3>'+suggestion.department+'</h3><h4><i class="fa fa-phone" aria-hidden="true"></i>'+suggestion.telno+'</h4><h4><a href="mailto:'+suggestion.email+'"><i class="fa fa-envelope-o" aria-hidden="true"></i> '+suggestion.email+'</a></h4></div></div></li>';

  // $('#searchUser').html(html);
  
});

$('.sb-icon-search').on('click',function(){
  $('.aa-input-container').toggleClass('open');
  $('#aa-search-input').val('');
});