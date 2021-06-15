<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\task;

class taskcontroller extends Controller
{
    //
    public function getTable($Uid)
    {
        $tasks=Task::where('user_id',$Uid)->get();

        $data['record']=$tasks;
        echo json_encode($data);
    }
    public function add(Request $req)
    {
        if($req->status != "pending" && $req->status != "done" && $req->status != ""){
            return response()->json(["message"=>"status can be set as either 'pending' or 'done'"]);
        }
        $task = new task;
        $task->user_id = $req->user_id;
        $task->task = $req->task;
        $task->status = $req->status;

        if($task->status == ""){
            $task->status="pending";
        }
        $run = $task->save();
        return response()->json(["message"=>"successfully created a task"]);
    }
    public function statusChange(Request $req)
    {
        $task = task::find($req->taskId);
        if(is_null($task)){
            return response()->json(["Message"=>"No Such Task Found"],404);
        }
        if($task->status == "pending") {
            $task->status = "done";
            $message = "Marked task as done";
        }
        else{
            $task->status = "pending";
            $message = "Marked task as pending";
        }
        $run = $task->save();
        return response()->json(["message"=>$message]);

        if ($run) {
            return response()->json(["task"=>$task->task,"status"=>"1","message"=>$message]);
        }
        else{
            return response()->json(["message"=>"Status change failed"]);
        }
    }
}
