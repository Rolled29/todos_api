<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TodosController extends Controller
{
    public function getTasks(){
        return $this->generateResponse('success', Todo::all(), NULL);
    }

    public function createTask(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->generateResponse('fail', 'Task creation failed', $validator->errors());
        }

        Todo::create([
            'title' => $request->post('title'),
            'status' => $request->post('status')
        ]);

        return $this->generateResponse('success', 'Task successfully created', NULL);
    }

    public function updateTask(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->generateResponse('fail', 'Task update failed', $validator->errors());
        }
        $todo = Todo::findOrFail($id);
        $todo->update($request->all());
        return $this->generateResponse('success', 'Task successfully updated', NULL);
    }

    public function deleteTask($id){
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return $this->generateResponse('success', 'Task successfully deleted', NULL);
    }


    private function generateResponse($status, $message, $errors){
        return response()->json([
            'status' => $status,
            'message' => $message,
            'errors' => $errors
        ]);
    }


}
