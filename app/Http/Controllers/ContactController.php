<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Validator;


class ContactController extends Controller
{
    public function addTask(request $request){
        $user_id = 1;//Auth::User()->user_id;

    
        $validator=validator::make($request->all(),[

           
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',

            

            ]);
            if ($validator->fails()){
                return response()->json(['error'=>$validator->errors()],400);
            }


            $name   = $request->input('name');
            $email   = $request->input('email');
            $message   = $request->input('message');
            $status   = 1;//$request->input('message');
       

            $res = DB::table ('test_task')
            ->insert([
                 'message' => $message,
                'name' => $name,
                'email' => $email,
                'status' => $status,
                
            ]);
            if($res){
                return response()->json(['message'=>'Task successfully added','success'=>true],200);
            }else{
                return response()->json(['message'=>'Task not added','success'=>false],200);
            }
}

 /**taskManager
 * job shedule project
 * 3
 * @param  \Illuminate\Http\$searchTerm
 * @return \Illuminate\Http\Response $opsearch
 */

public function editTask(request $request){
    $user_id =Auth::User()->user_id;
    $now = Carbon::now();
    $validator=validator::make($request->all(),[

        'task_id' => 'required',
        'project_id' => 'required',
        'planned_minutes' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'description' => 'required',
        'status' => 'required',
        'task_manager_id' => 'required',


        ]);
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],400);
        }
        $task_id   = $request->input('task_id');
        // $task_code   = $request->input('task_code');
        $duty   = $request->input('task_name');
        $description   = $request->input('description');
        // $city_name   = $request->input('city_name');
        $project_id   = $request->input('product_id');
        $planned_minutes   = $request->input('planned_minutes');
        $task_manager_id   = $request->input('task_manager_id');
        $start_date   = $request->input('start_date');
        $end_date   = $request->input('end_date');
        $status   = $request->input('status');


        $taskid = DB::table ('tasks')
        ->where('id',$task_id)
        ->update([
            // 'task_code' => $task_code,
            'task_name' => $duty,
            'description' => $description,
            'product_id' => $project_id,
            'planned_minutes' => $planned_minutes,
            'task_manager_id' => $task_manager_id,
            'end_date' => $end_date,
            'start_date' => $start_date,
            'status' => $status,
            'created_by'=>$user_id,
            'created_at'=>$now,
            'updated_by'=>$user_id,
            'updated_at'=>$now,


        ]);
        if($taskid){
            return response()->json(['message'=>'task edit successfully','success'=>true],200);
        }else{
            return response()->json(['message'=>'edit task failed','success'=>false],200);
        }
}


            /**getTaskManager
             * job shedule project
             * 3
             * @param  \Illuminate\Http\$searchTerm
             * @return \Illuminate\Http\Response $opsearch
             */


        public function getTaskManager(){
            $task=DB::table('tasks as t')
                ->leftjoin('staff as s','s.staff_id','t.task_manager_id')
                ->select('t.id as task_id','t.task_name','t.description','t.planned_minutes','t.start_date','t.end_date','t.product_id','t.status','s.staff_name','s.staff_id', DB::raw('CAST(t.planned_minutes/60 as int) as total_planned_hours'), DB::raw('CAST(t.planned_minutes%60 as int) as total_planned_minutes'))
                ->get();
            return response()->json(['data'=>$task],200);
        }

}
