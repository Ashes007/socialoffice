      
     <div class="modal-body likelistarea" id="likearea">
      
       <div class="row">
        <div class="col-sm-12">
          <h2><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{$count_like}} Likes</h2>

          <div class="overview" style="height:400px; overflow-y:auto;">
          @if(!empty($post_likes))
          @foreach($post_likes as $likes)
          <div class="recent-block">
           <div class="image-div">
             
            @if($likes->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $likes->user->profile_photo)))
              <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$likes->user->profile_photo) }}" alt=""/>
            @else
              <img src="{{ asset('uploads/no_img.png') }}" alt="">
            @endif 
           </div>
           <h4>{{ $likes->user->display_name }} <br>
             <span>{{ $likes->user->title }} </span></h4>
         </div>
         @endforeach
         @endif

        </div>

         </div>

       </div>
     </div>
   