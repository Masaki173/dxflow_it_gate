<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Inquiry;
use App\Models\ItDepartment;
use App\Models\InquiryAssignment;
use App\Models\InquiryLog;
use Illuminate\Support\Str;

class InquiryController extends Controller
{
     public function store(Request $request)
    {
        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
    $attachmentPath = $request->file('attachment')->store('attachments', 'public');
          }
        $inquiry = Inquiry::create(
            array(
              'user_id' => Auth::id(),
              'department' => $request->department,
              'detail' => $request->detail,
              'issue_type' => $request->issue_type,
              'hardware_option' => $request->hardware_option,
              'software_option' => $request->software_option,
              'network_option' => $request->network_option,
              'it_can_handle' => null,
              'software_can_handle' => null,
              'hardware_can_handle' => null,
              'network_can_handle' => null,
              'attachment' => $attachmentPath,
            )
          );
         return redirect()->route('inquiry.form')
                     ->with('success', 'フォームの送信が完了しました');
    }
    public function itTasks()
    {   
         $items = Inquiry::with('user')
        ->whereNull('it_can_handle')
        ->get();
        $departments = ItDepartment::all();
        return view('departments.it.index', compact('items', 'departments'));
    }

public function softwareTasks()
    {
        $softwareDept = ItDepartment::where('name', 'Software')->firstOrFail();
        $departmentId = $softwareDept->id;

        $items = Inquiry::with(['user', 'assignments'])
        ->where('it_can_handle', false)
        ->whereHas('assignments', function ($q) use ($departmentId) {
        $q->where('department_id', $departmentId);
    })
     ->whereDoesntHave('logs')
    ->get();
        return view('departments.software.index', compact('items'));
    }
public function hardwareTasks()
    {
        $hardwareDept = ItDepartment::where('name', 'Hardware')->firstOrFail();
        $departmentId = $hardwareDept->id;

        $items = Inquiry::with(['user', 'assignments'])
        ->where('it_can_handle', false)
        ->whereHas('assignments', function ($q) use ($departmentId) {
        $q->where('department_id', $departmentId);
    })
    ->whereDoesntHave('logs')
    ->get();
        return view('departments.hardware.index', compact('items'));
    }
public function networkTasks()
    {
        $networkDept = ItDepartment::where('name', 'Network')->firstOrFail();
        $departmentId = $networkDept->id;
        $items = Inquiry::with(['user', 'assignments'])
        ->where('it_can_handle', false)
        ->whereHas('assignments', function ($q) use ($departmentId) {
        $q->where('department_id', $departmentId);
    })
    ->whereDoesntHave('logs')
    ->get();
     return view('departments.network.index', compact('items'));
}

public function assign(Request $request, Inquiry $inquiry)
{
    InquiryAssignment::create([
        'inquiry_id' => $inquiry->id,
        'department_id' => $request->department,
    ]);

    $inquiry->it_can_handle = false;
    $inquiry->save();


    return redirect()->back()->with('success', '問い合わせを振り分けました');
}
public function itHandled($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->it_can_handle = true;
        $inquiry->save();

        InquiryLog::create([
            'inquiry_id'  => $inquiry->id,
            'user_id'     => $inquiry->user->id,
            'can_handle'  => true,
            'content'     => $inquiry->detail,
            'details'     => null, 
        ]);

        return redirect()->route('it.index')->with('success', '依頼を対処済みにしました。');
    }
public function markHandled(Request $request, $inquiryId)
{
    $request->validate([
        'can_handle' => 'required|boolean',
        'details' => 'nullable|string|max:1000',
    ]);

    $inquiry = Inquiry::findOrFail($inquiryId);

    InquiryLog::create([
        'user_id' =>$inquiry->user->id,
        'inquiry_id' => $inquiry->id,
        'can_handle' => $request->can_handle,
        'content' => $inquiry->detail,
        'handled_by' => auth()->id(),
    ]);

    return redirect()->back()->with('success', '処理結果を記録しました');
}

public function itLogs()
{
$logs = InquiryLog::with(['inquiry', 'user'])
    ->whereHas('inquiry', function ($query) {
        $query->where('it_can_handle', true);
    })
    ->orderBy('created_at', 'desc')
    ->get();
    return view('departments.it.logs', compact('logs'));
}
public function hardwareLogs()
{
   
    $hardwareDept = ItDepartment::where('name', 'Hardware')->firstOrFail();

    
    $logs = InquiryLog::with(['inquiry.user', 'inquiry.assignments.departments'])
        ->whereHas('inquiry.assignments', function($q) use ($hardwareDept) {
            $q->where('department_id', $hardwareDept->id);
        })
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('departments.hardware.logs', compact('logs'));
}
public function softwareLogs()
{
    $softwareDept = ItDepartment::where('name', 'Software')->firstOrFail();

    $logs = InquiryLog::with(['inquiry.user', 'inquiry.assignments.departments'])
        ->whereHas('inquiry.assignments', function($q) use ($softwareDept) {
            $q->where('department_id', $softwareDept->id);
        })
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('departments.software.logs', compact('logs'));
}
public function networkLogs()
{
    $networkDept = ItDepartment::where('name', 'Network')->firstOrFail();

    $logs = InquiryLog::with(['inquiry.user', 'inquiry.assignments.departments'])
        ->whereHas('inquiry.assignments', function($q) use ($networkDept) {
            $q->where('department_id', $networkDept->id);
        })
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('departments.network.logs', compact('logs'));
}
public function updateDetails(Request $request, $id)
{
    $request->validate([
        'details' => 'required|string|max:1000',
    ]);

    $log = InquiryLog::findOrFail($id);
    $log->details = $request->input('details');
    $log->save();

    return back()->with('success', '詳細を更新しました。');
}

public function overviewLogs()
    {
    $logs = InquiryLog::with(['inquiry.user', 'inquiry.assignments.departments'])
    ->where('can_handle', false)
    ->orderBy('updated_at', 'desc')
    ->get();

    return view('departments.overview.logs', compact('logs'));
    }
       
    }