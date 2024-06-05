<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('welcome');
    $priceList = [];
    $discountedItems = [];
    $payableItems = [];
    return view('bogo', compact('priceList', 'discountedItems', 'payableItems'));
});

Route::post('/', function (Request $request) {
    $request->validate([
        'priceList' => 'required|string|regex:/^\d+(?:,\d+)*$/',
    ]);
    $priceList = $request->input('priceList');
    if (!empty($priceList)) {
        $priceList = array_map('intval', explode(',', $priceList)); // Convert string values to integers
        $result = bogo($priceList);
        $discountedItems = $result['discountedItems'];
        $payableItems = $result['payableItems'];
    }
    return view('bogo', compact('priceList', 'discountedItems', 'payableItems'));
});

function bogo($priceList)
{
    $discountedItems = $payableItems = [];
    rsort($priceList); // Sort in descending order

    while (!empty($priceList)) {
        $currentItem = array_shift($priceList); // Get the first element (highest price) and remove from the array
        array_push($payableItems, $currentItem); // Push the highest price to payableItems
        $nextIndex = null;
        foreach ($priceList as $key => $value) {
            if ($priceList[$key] < $currentItem) {
                $nextIndex = $key;
                break;
            }
        }

        if ($nextIndex !== null) {
            $element = array_splice($priceList, $nextIndex, 1)[0];
            array_push($discountedItems, $element);
        } else {
            // No smaller value found, add remaining to payable
            $payableItems = array_merge($payableItems, $priceList);
            $priceList = null;
        }
        //reindex the array
        if ($priceList != null)
            $priceList = array_values($priceList);
    }

    return [
        'discountedItems' => $discountedItems,
        'payableItems' => $payableItems,
    ];
}
