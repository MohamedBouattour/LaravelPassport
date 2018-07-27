<?php

namespace App\Http\Controllers\api;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController as BaseController;
use App\Rates;
use App\Coffes;
use Validator;


class RateService extends BaseController{
    public function index() {
        $rates = Rates::all();
        return $this->sendResponse($rates->toArray(),'allCaoffes');
    }

    public function store(Request $request) {
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
        //$coffe = DB::select('select * from coffes where id = ? ',[$id]);
        $coffe = DB::select('select * from coffes where id = ?',[$id] );
        $newnbusers = $coffe[0]->nbusers+1;
        $affected = DB::update('update coffes set nbusers = ? where id = ?', [$newnbusers,$id]);
        
        if($affected==1)
        {
            $newTotals = $coffe[0]->totalrate+$input['value'];
            $affected = DB::update('update coffes set totalrate = ? where id = ?', [$newTotals,$id]);   
        }
        
        //$rate = Rates::create($input);
        //return $this->sendResponse($rate->toArray(),'created');
    }

}