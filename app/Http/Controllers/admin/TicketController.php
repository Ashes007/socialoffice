<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ticket, App\Department, App\Issue, App\TicketAttachment;

class TicketController extends Controller
{
    public $management = 'Ticket';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'admin_ticket_list';

    public function __construct()
    {       
        parent::__construct();
        $this->breadcrumb = $breadcrumb = [
                            'LISTPAGE' => 
                                [
                                    ['label' => 'List', 'url' => 'THIS']
                                ],
                            'CREATEPAGE' => 
                                [
                                    ['label' => $this->management, 'url' => \URL::route($this->listUrl)],
                                    ['label' => 'Create', 'url' => 'THIS']
                                ],                                 
                            'EDITPAGE' => 
                                [
                                    ['label' => $this->management, 'url' => \URL::route($this->listUrl)],
                                    ['label' => 'Edit', 'url' => 'THIS']
                                ]                                
                            ];

                            \View::share([
                                'management' => $this->management,
                                'breadcrumb' => $this->breadcrumb,
                            ]);

                            if(\Route::current()->getActionMethod()=='index'){
                                \View::share(['pageType' => $this->listMode]);                                
                            }elseif(\Route::current()->getActionMethod()=='add'){
                                \View::share(['pageType' => $this->createMode]); 
                            }elseif(\Route::current()->getActionMethod()=='edit'){
                                \View::share(['pageType' => $this->editMode]); 
                            }
    }

    public function index()
    {
    	$data['records'] = Ticket::where('parent_id',0)->orderBy('id','desc')->get(); 
        $data['departments'] = Department::listsTranslations('name')->pluck('name','id');
        $data['priorities']	= array('Urgent'=>'Urgent','High'=>'High');
    	return view('admin.tickets.list',$data);
    }
    
    public function getIssues(Request $request){
        $data['issues'] = Issue::where('department_id',$request->departmentId)->listsTranslations('name')->pluck('name','id');
        return view('front.tickets.get_issues',$data);
    }

    public function create(Request $request){
        $this->validate($request, [
            'department'    => 'required',
            'title'         => 'required',           
            'priority'      => 'required',
            'issue'         => 'required',
            'message'       => 'required',
            'file.*'        => 'max:1000|mimes:png,jpg,gif,jpeg,pdf,rar,zip,txt',
            ],
            [
                'issue.required'    => 'Chose issue related to',
                'file.*.mimes'      => 'Uploaded file type must be .png, *.jpg, *.gif, *.jpeg, *.pdf, *rar, *.zip, *.txt',
                'file.*.max'        => 'Uploaded file size maximum 5MB allowed'
            ]
        );

        $ticketNo                   = date('mdyis').auth()->guard('user')->user()->id.mt_rand(1000,9999);
        $object = new Ticket;
        $object->title              = $request->title;
        $object->message            = $request->message;
        $object->user_id            = auth()->guard('user')->user()->id;
        $object->department_id      = $request->department;
        $object->priority           = $request->priority;
        $object->issue_id           = $request->issue;
        $object->status             = 'Open';
        $object->ticket_no          = $ticketNo;
        $object->save(); 

        // File Upload
        if($request->file('file')){
            foreach ($request->file('file') as $file) {
                $fileName  = $ticketNo.'-'.time().'-ticket' . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/tickets/'), $fileName);

                $ticketAttachment                = new TicketAttachment();
                $ticketAttachment->ticket_id     = $object->id;
                $ticketAttachment->file          = $fileName;
                $ticketAttachment->save();
            }            
        }


        return \Redirect::back()->with('success', 'Ticket created successfully');
    }

    public function reply(Request $request){
        $this->validate($request, [
            'message' => 'required',
            'file.*'        => 'max:5000|mimes:png,jpg,gif,jpeg,pdf,rar,zip,txt'
            ],
            [
                'file.*.mimes'      => 'Uploaded file type must be .png, *.jpg, *.gif, *.jpeg, *.pdf, *rar, *.zip, *.txt',
                'file.*.max'        => 'Uploaded file size maximum 5MB allowed'
            ]            
        );
        $ticketId = decrypt($request->route('id'));
        $ticket   = Ticket::find($ticketId);
        $ticketNo = $ticket->ticket_no;

        $object = new Ticket;
        $object->parent_id          = $ticket->id;
        $object->message            = $request->message;
        $object->user_id            = auth()->guard('user')->user()->id;
        $object->department_id      = $ticket->department_id;
        $object->issue_id           = $ticket->issue_id;
        $object->ticket_no          = $ticketNo;
        $object->save(); 

        // File Upload
        foreach ($request->file('file') as $file) {
            $fileName  = $ticketNo.'-'.time().'-ticket' . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/tickets/'), $fileName);

            $ticketAttachment                = new TicketAttachment();
            $ticketAttachment->ticket_id     = $ticket->id;
            $ticketAttachment->file          = $fileName;
            $ticketAttachment->save();
        }

        return \Redirect::back()->with('success', 'Message posted successfully');
    }    

    public function viewTicket(Request $request){
        $data = array();
        $ticketId = $request->route('id');
        $data['record'] = Ticket::find($ticketId);
        $data['tickets'] = Ticket::where('id',$ticketId)->orWhere('parent_id',$ticketId)->orderBy('id')->get();
        $data['backUrl'] = route('tickets');
        return view('admin.tickets.view',$data);
    }

    // public function closeTicket(Request $request){
    //     $ticketId = decrypt($request->route('id'));
    //     $ticket = Ticket::find($ticketId); 
    //     $ticket->status = 'Closed';
    //     $ticket->save();
    //     return \Redirect::back()->with('success', 'Your ticket closed successfully');
    // }





}