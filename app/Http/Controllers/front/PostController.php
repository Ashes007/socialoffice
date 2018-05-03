<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GroupUser;
use App\UserGroupUser;
use App\Language;
use App\Post;


class PostController extends Controller {
    public function index($keyword='',Request $request) {       
        $groups = array();
        
        return view('front.groups.group_list',$data);
    }

    public function details($groupid ,Request $request) {  
        $group_id = $this->decodeid($groupid);
        $data=array();      
        $group_details=GroupUser::find($group_id);
       // dd($group_details);
        $group_memebers = UserGroupUser::from('user_group_users as ugu')->join('users as usr','usr.id', '=', 'ugu.user_id')->where('ugu.group_id',$group_id)->get(); 
        $group_posts = Post::where('type','Group')->where('group_id',$group_id)->get();
       // dd($group_posts);
        $data['group_details'] = $group_details;
        $data['group_memebers']= $group_memebers;
        $data['group_posts']= $group_posts;
        return view('front.groups.group_details',$data);

    }
    public function post_add(Request $request) {

    }
    public function add(Request $request) { 
        $data=array(); 
        return view('front.groups.group_add',$data);
    }
    public function decodeid($group_id)
    {       
         $varnew = decrypt($group_id);
         //$varnew = ( $var - 100 );
         return $varnew;
    }
   

}
