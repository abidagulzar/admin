<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\UserMessage;
use App\Store;
use Illuminate\Http\Request;
use DataTables;
use Redirect;
use DateTime;

class UserMessageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:User Messages', ['only' => ['index', 'delete']]);
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = UserMessage::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.UserMessage.index');
    }


    public function delete(Request $request)
    {

        $ids = explode(",", $request->get('UserMessageId'));
        $category = UserMessage::whereIn('UserMessageId', $ids);
        $category->delete();
        return redirect()->route('admin.usermessage.index')
            ->with('success', 'User Message deleted successfully');
    }


    public function GetById($id)
    {
        $where = array('UserMessageId' => $id);
        $userMessage = UserMessage::where($where)->first();
        return $userMessage;
    }
}
