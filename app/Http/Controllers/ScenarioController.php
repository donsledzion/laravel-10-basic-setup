<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateScenarioRequest;
use App\Http\Requests\UpdateScenarioRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Scenario;

class ScenarioController extends Controller
{
    public function index()
    {
        return view('scenarios.index',[
            'scenarios' => Scenario::all()
        ]);
    }

    public function show(Scenario $scenario)
    {
        return view('scenarios.show',[
            'scenario' => $scenario
        ]);
    }

    public function store(CreateScenarioRequest $request)
    {
        try{
            $scenario = Scenario::create($request->validated());
            return redirect(route('scenario.show',[$scenario]));            
        }catch(\Exception $e){
            $msg = "An error occured while trying to store scenario: ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }
        
    }

    public function edit(Scenario $scenario)
    {
        return view('scenarios.edit',[
            'scenario' => $scenario
        ]);
    }

    public function update(UpdateScenarioRequest $request, Scenario $scenario)
    {
        try{
            $scenario->update($request->validated());
            return redirect(route('scenario.show',[$scenario]));             
        }catch(\Exception $e){
            $msg = "An error occured while trying to update scenario: ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }
        
    }

    public function destroy(Scenario $scenario)
    {
        try{
            $scenario->delete();
            return redirect(route('scenario.index'));
            redirect()->back();
        }catch(\Exception $e){
            $msg = "An error occured while trying to delete scenario: ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }        
    }
}
