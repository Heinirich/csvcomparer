<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use App\Models\Transaction;
use App\Imports\TransactionImport;
use App\Imports\CsvImport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class ImportController extends Controller
{
    
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request) 
    {   
        //validation of data
        if($request->input('selected') == '0'){
            $request->validate([
                'file' => 'required|mimes:csv',
                'number' => 'required'
            ]);
        }else{
            $request->validate([
                'f_name' => 'required',
                'number' => 'required'
            ]);
        }
        
        if($request->input('selected') == '0'){
            $fileName = time().'.'.$request->file->extension();
            $file = $request->file->move(public_path('csv'), $fileName);
        }else{
            $file = public_path('csv').'/'.$request->f_name;
        }

        if (!file_exists($file)) {
            \Session::flash('error', 'The file you are looking for does not exist!. Add it to public/csv folder');
            return back();

        }

        //Read function and populate with file path argument and number
        $this->wo_readFileandPops($file,$request->number);
        \Session::flash('success', 'Data Retrieved Successfully!'); 
        return back();
    }

    public function wo_readFileandPops($file,$n){
        //delete before insert. Session would really hold big data and reading from db is faster that reading from db
        \DB::table('transactions')->delete();
        //read from Excel File
        $data = Excel::toArray(new CsvImport , $file);
        array_shift($data[0]);
        $f_data = $data[0];
        //loop through csv data and insert records to transaction
        foreach ($f_data as $row) {
            $trans = new Transaction();
            $trans->customer_id = $row[0];
            if (array_key_exists(1,$row))
                $trans->amount = $row[1];
            
            if (array_key_exists(2,$row))
                $trans->date = $row[2];
                
            $trans->save();
        }
        //only uniques are selected and sorted
        if(!empty($n) && $n>0){
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

            array_multisort($price, SORT_DESC, $data);

            $t_uniques = $data;

            $datas = array();
            foreach($t_uniques as $t_unique){
                $datas[] = $t_unique['customer_id'];
            }

            //final results is added to a session for display or $n
            \Session::put('sorted', array_slice($datas,0, $n));

            
        }
    }
}
