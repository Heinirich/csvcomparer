<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transactions</title>
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel="stylesheet" href="{{asset('font-awesome.css')}}">

</head>
<body>
    <div class="p-10 bg-surface-secondary">
        <div class="container">
            <div class="text-center">
                <h3 class="mb-2">Crafted with Smith</h3>

            </div>
            <div class="card" style="padding: 20px;">
                <div class="card-header">
                     @if($errors->any())
                        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                     @endif


                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    @if ($message = Session::get('sorted'))
                    <div class="alert alert-success">
                        <p>Recent results {{ json_encode($message) }}</p>
                    </div>
                    <p style="padding: 10px;"> I dont Like this data? <a class="btn btn-success" href="#showpopularity">Click Here</a> </p>
                    @endif


                </div>

                    <div class="table-responsive">
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group" style="display: flex;justify-content:space-between;padding:10px;">
                                <butto type="button" id="knowfile" onclick="Wo_ShowOption('knowfile','1')" class="btn btn-success">I Know My File Name</butto>
                                <button type="button" id="import" onclick="Wo_ShowOption('import','0')" class="btn btn-success">Just Import The File</button>
                            </div>
                            <input type="hidden" name="selected" id="selected">
                            <div class="form-group" style="padding:10px;display: none;" id="file" accept=".csv">
                                <input type="file" name="file"  class="form-control">
                            </div>
                            <div class="form-group" style="padding:10px;display: none;"  id="f_name">
                                <input type="text" name="f_name" class="form-control" placeholder="Enter filename i.e file.csv. Dont worry, I will do the rest">
                            </div>
                            <div class="form-group" style="padding:10px;display: none;" id="number" >
                                <input type="number" name="number" class="form-control" placeholder="Enter Popularity Number" min="1" oninput="this.value = 
 !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                            </div>
                            <br>
                            <button id="btnimport" style="display: none;" class="btn btn-success">Import User Data</button>
                            
                        </form>
                    </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h6>Transactions Table</h6>
                    <br>
                    
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover table-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Customer</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{$transaction->customer_id}}</td>
                                    <td>Ksh.{{$transaction->amount}}</td>
                                    <td>{{$transaction->date}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <ul style="text-align: center!important;font-size:2rem;">
                        {!! $transactions->links() !!}
                    </ul>
                    
                </div>
            </div>

            <div class="card" id="showpopularity">
                <div class="card-header">
                    <h6>By Popularity</h6>
                    <br>


                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Amount</th>
                                <th scope="col">No of Transactions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count = 0; @endphp
                            @foreach($t_count_unique as $transaction)
                            <tr>
                                <td>{{$count = $count+1}}</td>
                                <td>{{$transaction['customer_id']}}</td>
                                <td>{{$transaction['trans_sum']}}</td>
                                <td>{{$transaction['number']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        function Wo_ShowOption(what,which){
            $('#selected').val(which);
            $('#knowfile').hide();
            $('#import').hide();
            $('#number').show();
            $('#btnimport').show();
            if(what == 'knowfile'){
                $('#f_name').show();
            }else{
                $('#file').show();
            }
        }
    </script>
</body>
</html>

