{{-- layouts/layout.blade.phpを読み込む --}}
@extends('layouts.layout')

{{-- layout.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', '家計簿サイト')

{{-- layout.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    
    <header>
        <h1>Bank management</h1>
    </header>
    
    <h2>入力</h2>
    <div class="addition">
        <!-- 銀行追加 -->
        <form action="{{ action('KakeiboController@bankaddition') }}" method="post" enctype="multipart/form-data">
            @csrf
             <label class="form-check" for="bankaddition">銀行追加</label>
                       <input type="text" name="bank" id="bankaddition" class="form-control" placeholder="銀行名">
                       <input type="submit" class="button" name="bankaddition" value="保存">
                       <input type="submit" class="button" name="bankdelete"value="削除">
        </form>
        
        <!-- カテゴリ追加 -->                   
        <form action="{{ action('KakeiboController@categoryaddition') }}" method="post" enctype="multipart/form-data">
            @csrf
             <label class="form-check" for="categoryaddition">カテゴリ追加</label>
                       <input type="text" name="category" id="categoryaddition" class="form-control" placeholder="カテゴリ名">
                       <input type="submit" class="button" name="categoryaddition"value="保存">
                       <input type="submit" class="button" name="categorydelete"value="削除">
        </form>
    </div>
    <form action="{{ action('KakeiboController@create') }}" method="post" enctype="multipart/form-data">
        
      @csrf
      @if (count($errors) > 0)
            <ul>
                  @foreach($errors->all() as $e)
                     <li>{{ $e }}</li>
                  @endforeach
             </ul>
      @endif
    <article>
        
        <section id="inputSection">
           
           <div class="form-group row">
 
                <label class="col-md-6" for="bank">銀行</label>
                <select class="form-control" name="bank" id="bank">
                    <option value="">-選択してください-</option>
                    @php
                        $default_banks = ['三菱UFJ', '三井住友', 'みずほ', 'りそな', 'ゆうちょ'];
                    @endphp
                    @foreach($default_banks as $bank_name)
                    <option>
                        {{ $bank_name }}
                    </option>
                    @endforeach
                    @foreach($bankaddition as $bank)
                    <option>
                        {{ $bank->bank }}
                    </option>
                    @endforeach
                </select>
                
    　　　 </div>
                            
           
           <div class="from-group row">
               <label class="form-check" for="total-income">収支</label>
               
               <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="total" value="収入" id="total-income">収入
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="total" value="支出">支出
                    </label>
                 </div>
           </div>
                
            <div class="form-group row">
                <label class="col-md-6" for="date">日付</label>
                <input type="date" name="date" id="date" class="form-control">
            </div>
            
        </section>
         <section id="inputSections">
             
           <div class="form-group row">
                <label class="form-check" for="category">カテゴリ</label>
                 <select name="category" id="category" class="form-control">   
            　　　　<option value="">-選択してください-</option>
                    @php
                        $default_categories = ['給与', '食費', '日用品', '交通費', '衣服','携帯代','貯金'];
                    @endphp
                    @foreach($default_categories as $category_name)
                    <option>
                        {{ $category_name }}
                    </option>
                    @endforeach
                    
                    @foreach($categoryaddition as $category))
                    <option>
                        {{ $category->category }}
                    </option>
                    @endforeach
                </select>
                
                
            </div>
            
            <div class="form-group row">
                <label class="col-md-6" for="amount">金額</label>
                   <input type="text" name="amount" id="amount" class="form-control" placeholder="金額を記入">
                  
             </div>
            
            <div class="form-group row">
                <label class="col-md-6" for="memo">メモ</label>
                   <input type="text" name="memo" id="memo" class="form-control" placeholder="品目やお店">
                 
             </div>
             
        </section>
        
        <div class="submitInput">
            <input type="submit" class="btn btn-primary" value="登録">
        </div>
         </article>
      </form>
    
     <!-- 検索機能　絞り込み -->  
    <div class="clear">
        <h2>検索</h2>   
        <form action="{{ action('KakeiboController@index') }}" method="get" enctype="multipart/form-data">
            
        
        <article>
            
            <section id="inputSection">
               
               <div class="form-group row">
     
                    <label class="col-md-6" for="bank">銀行</label>
                    <select class="form-control" name="bank" id="bank">
                        <option value="">-選択してください-</option>
                        @php
                            $default_banks = ['三菱UFJ', '三井住友', 'みずほ', 'りそな', 'ゆうちょ'];
                        @endphp
                        @foreach($default_banks as $bank_name)
                        <option @if($request->bank == $bank_name) selected @endif>
                            {{ $bank_name }}
                        </option>
                        @endforeach
                        @foreach($bankaddition as $bank)
                        <option @if($request->bank == $bank->bank) selected @endif>
                            {{ $bank->bank }}
                        </option>
                        @endforeach
                    </select>
        　　　 </div>
                                
               
               <div class="from-group row">
                   <label class="col-md-6" for="total-income">収支</label>
                   
                   <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="total" value="収入" id="total-income" @if($request->total == "収入") checked @endif>収入
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="total" value="支出" @if($request->total == "支出") checked @endif>支出
                        </label>
                     </div>
               </div>
                    
                <div class="form-group row">
                    <label class="col-md-6" for="date">日付</label>
                    <input type="date" name="payDateFrom" id="date" class="form-control" value="{{$request->payDateFrom}}">
                    ~
                    <input type="date" name="payDateTo" id="date" class="form-control" value="{{$request ->payDateTo}}">
                </div>
                
                
                 
               <div class="form-group row">
                    <label class="col-md-6" for="category">カテゴリ</label>
                     <select name="category" id="category" class="form-control">   
                     <option value="">-選択してください-</option>
                        @php
                            $default_categories = ['給与', '食費', '日用品', '交通費', '衣服','携帯代','貯金'];
                        @endphp
                        @foreach($default_categories as $category_name)
                        
                        <option @if($request->category == $category_name) selected @endif>
                            {{ $category_name }}
                        </option>
                        @endforeach
                        
                        @foreach($categoryaddition as $category)
                        <option @if($request->category == $category->category) selected @endif>
                            {{ $category->category }}
                        </option>
                        @endforeach
                  
                    </select>
                </div>
                
            </section>
            
            <div class="submit">
                <input type="submit" class="btn btn-primary" value="検索">
            </div>
          </form>
      </div>
 
        <h2>入出金一覧</h2>
        <section id="list">
            
            <div class="row">
            <div class="list-news col-md-11 mx-auto">
                <div class="row">
                  <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">銀行</th>
                                <th width="5%">収支</th>
                                <th width="10%">日付</th>
                                <th width="15%">カテゴリ</th>
                                <th width="10%">金額</th>
                                <th width="20%">メモ</th>
                                <th width="5%">削除</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $kakeibo)
                                <tr>
                                    <th>{{ $kakeibo->id }}</th>
                                    <td>{{ $kakeibo->bank }}</td>
                                    <td>{{ $kakeibo->total }}</td>
                                    <td>{{ $kakeibo->date }}</td>
                                    <td>{{ $kakeibo->category }}</td>
                                    <td>{{ number_format($kakeibo->amount) }}円</td>
                                    <td>{{ $kakeibo->memo }}</td>
                                    <td><a href="{{ action('KakeiboController@delete', ['id' => $kakeibo->id]) }}">削除</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
           </div> 
            <!-- ここに入出金一覧を表示 -->
        </section>

        <h2>合計金額</h2>
    
        <section id="incomeExpence">
            
            <div class="incomeExpence">
                <label class="col-md-2" for="income">収入</br>
                 ¥<label class="income">{{ $incomeTotal }}</label>
                </label>
                <label class="col-md-2" for="expence">支出</br>
                 ¥<label class="expence">{{ $expenceTotal }}</label>
                </label>
                <label class="col-md-2" for="expence">残金</br>
                ¥<label class="total">{{ $incomeTotal - $expenceTotal }}</label>
                </label>
            </div>
        
        </section>

    </article>
    
    <footer>
        &copy;Bank management
    </footer>
@endsection