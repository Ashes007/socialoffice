 @if(count($groups)>0)
         @foreach ($groups as $group)       	

         <div class="col-sm-4 col-xs-6">
           <div class="photo-single group-areas">
             <div class="group-img">
             	<a href="group.html"><img src="{{ asset('uploads/group_images/').'/'.$group->cover_image }}" alt="" class="big-img"/></a>
                <!-- <img src="images/sg-1.jpg" alt="" class="small-img"/> -->
             </div>
             <h3><a href="group.html">{{ $group->group_name }}</a></h3>
             <h5>{{ get_memeber_group($group->group_id) }} members</h5>
             <p>{{ $group->group_description }}</p>
             <span class="week-active">Active 2 weeks ago / <label>{{ ucwords($group_type)}} Group</label></span>
           </div>
         </div>
       
         @endforeach
         @endif