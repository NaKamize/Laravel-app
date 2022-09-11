<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Exception;
use stdClass;

class ProductController extends Controller
{
    public $url = 'https://old.tssgroup.sk/pricelisthandler.aspx?login=52713229&password=b219957d46535ae6afeaebb324afc451482b4768f64d161a3c8fb3040856b013b2d1eca95ccbc5dfb8c9dcdebf842de4ea205f8c7780579919214ae9bf0023c6&typxml=1';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $final_items = array();     // variable for items with id QI90000101

        // download data from xml file and convert them into array
        $result = simplexml_load_file($this->url);
        $json = json_encode($result);
        $array = json_decode($json, TRUE);
        // loop filters out needed items with id QI90000101
        $item_pos = 0;  // variable that contains current position of an item in 
        foreach ($result->Item as $item) {
            if ($array['Item'][$item_pos]['Category']['@attributes']['id'] == 'QI90000101') {
                $tempObj = new stdClass();
                $tempObj->id = $array['Item'][$item_pos]['ID'];
                $tempObj->name = $item->Name->__toString();
                $tempObj->desc = $item->ShortDescription->__toString();
                $tempObj->img = $array['Item'][$item_pos]['PictureMain'];
                $tempObj->weight = $array['Item'][$item_pos]['WEIGHT'];
                $tempObj->onStock =  $item->OnStock->__toString();
                array_push($final_items, $tempObj);
            }
            $item_pos++;
        }
        //print_r($final_items);
        return view('products', ['itemsXML' => $final_items]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $ids = $request->input('products');
            $quantities = $request->input('quantity');
            $maxLen = count($ids);
            for ($i = 0; $i < $maxLen; $i++) {
                if ($quantities[$i] != "") {
                    $order = new Order();
                    $order->item_id = $ids[$i];
                    $order->count = intval($quantities[$i]);
                    $order->save();
                }
            }
        } catch (Exception $e) {
            return redirect('/');
        }

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
