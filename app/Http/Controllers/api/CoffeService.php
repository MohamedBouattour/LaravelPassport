<?php

namespace App\Http\Controllers\api;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController as BaseController;
use App\Rates;
use App\Coffes;
use Validator;


class CoffeService extends BaseController{
    public function index() {
        $categorys = Coffes::all();
        return $this->sendResponse($categorys->toArray(),'allCaoffes');
    }

    public function store(Request $request) {
        $input = $request->all();
        $validator = Validator::make($input,
        [
            'coffename'=> 'required|string',
            'lo'=> 'required',
            'la'=> 'required',
            'description'=> 'string',
            'nbusers'=> 'required',
            'totalrate'=> 'required',
            'options'=> 'string',
            'cat_id'=> 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError('erreur de validation',$validator->errors());
        }

        $coffes = Coffes::create($input);
        return $this->sendResponse($coffes->toArray(),'created');
    }

    public function show($id) {
        $coffes = Coffes::find($id);
        if (is_null($coffes)) {
            return $this->sendError('not found',$id);
        }
        return $this->sendResponse($coffes->toArray(),'finded');
    }

    public function change (Request $request, Coffes $coffes) {
        $input = $request->all();
        $validator = Validator::make($input,
        [
            'coffename'=> 'required|string',
            'lo'=> 'required',
            'la'=> 'required',
            'description'=> 'string',
            'nbusers'=> 'required',
            'totalrate'=> 'required',
            'options'=> 'string',
            'cat_id'=> 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError('erreur de validation',$validator->errors());
        }

        $coffes->coffesname =$input['coffesname'];
        $coffes->save();
        return $this->sendResponse($coffes->toArray(),'changed');
    }

    public function destroy ( Coffes $coffe) {
        $coffe->delete();
        return $this->sendResponse($coffe->toArray(),'destroyed');
    }


    public function vote(Request $request) {
        $input = $request->all();
        $validator = Validator::make($input,
        [
            'coffe_id'=> 'required',
            'user_id'=> 'required',
            'value'=> 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError('erreur de validation',$validator->errors());
        }
        $id=$input['coffe_id'];
        $coffe = DB::select('select * from coffes where id = ?',[$id] );
        $newnbusers = $coffe[0]->nbusers+1;
        $affected = DB::update('update coffes set nbusers = ? where id = ?', [$newnbusers,$id]);
        
        if($affected==1)
        {
            $newTotals = $coffe[0]->totalrate+$input['value'];
            $affected = DB::update('update coffes set totalrate = ? where id = ?', [$newTotals,$id]);
            return $this->sendResponse($coffe[0],'rated');  
        }
    }

}