<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
use App\Models\Transaction;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //get inserted transactions from DB and paginate
    $transactions = DB::table('transactions')->orderBy('customer_id','ASC')->paginate(10);
    //get uniques
    $t_count_uniques  = DB::table('transactions')->select('customer_id')->distinct()->get();
    $data = array();
    foreach($t_count_uniques as $t_count_unique){
        $data[] = array(
            'customer_id' => $t_count_unique->customer_id,
            'trans_sum' => number_format(DB::table('transactions')->where('customer_id', $t_count_unique->customer_id)->sum('amount'), 2),
            'number' => DB::table('transactions')->where('customer_id',$t_count_unique->customer_id)->count()
        );
    }

    $price = array_column($data, 'number');
    //sort based on number from big to small
    array_multisort($price, SORT_DESC, $data);

    $t_count_unique = $data;


    return view('welcome',compact('transactions','t_count_unique'));
});


//import post data
Route::post('/import', [ImportController::class,'import'])->name('import');


