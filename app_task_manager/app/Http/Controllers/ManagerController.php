<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Manager;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function __construct(Manager $task)
    {
        $this->tasks = $task;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasksManeger = $this->tasks->all();
        return response()->json($tasksManeger , 200);
       // return view('list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


     $request->validate($this->tasks->rules(), $this->tasks->feedback());


         $Attachment = $request->file('Attachment');
         $Attachment_urn = $Attachment->store('file','public');

        $task  = $this->tasks->create([
        'title' => $request->title,
        'description' => $request->description,
        'Attachment' => $Attachment_urn,
        'dateCreated' => $request->dateCreated,
        'completedDate' => $request->completedDate,
        'user' => $request->user,
    ]);
        //return view('/list');
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = $this->tasks->find($id);
        if ($task === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404); // json
        }
        return response()->json($task, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function edit(Manager $manager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $task = $this->tasks->find($id);

        if($task === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($task->rules() as $input => $regra) {

                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

         //  $request->validate($regrasDinamicas, $task->feedback());

        } else {
            $request->validate($task->rules(), $task->feedback());

        }

        //remove o arquivo antigo caso um novo aqrquivo tenha sido enviado no request
        if($request->file('Attachment')){
            Storage::disk('public')->delete($task->Attachment);
        }

        $Attachment = $request->file('Attachment');
         $Attachment_urn = $Attachment->store('file','public');

        $task->update([
        'title' => $request->title,
        'description' => $request->description,
        'Attachment' => $Attachment_urn,
        'dateCreated' => $request->dateCreated,
        'completedDate' => $request->completedDate,
        'user' => $request->user,
    ]);


        //$marca->update($request->all());
        return response()->json($task, 200);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = $this->tasks->find($id);
        if ($task === null) {
            return response()->json(['erro' => 'Impossivel realizar exclusão. O recurso solicitado não existe'], 200); // json
        }

       //remove o arquivo antigo caso um novo aqrquivo tenha sido enviado no request
        Storage::disk('public')->delete($task->Attachment);


        $task->delete();
        return ['msg' => 'Registro removido com sucesso!'];
    }
}
