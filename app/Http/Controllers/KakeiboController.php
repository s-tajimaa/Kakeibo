<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Kakeibo;

use App\Bank;

use App\Category;

class KakeiboController extends Controller
{
    //
    public function index(Request $request)
  {   
      $bankaddition = Bank::all();
      $categoryaddition = Category::all();
     
      $incomeTotal = 0;
      $expenceTotal = 0;
      
      /* 検索機能　絞り込み */  
      $cond_bank = $request->bank;
      $cond_total = $request->total;
      $cond_paydatefrom = $request->payDateFrom;
      $cond_paydateto = $request->payDateTo;  
      $cond_category = $request->category;
      
      $query_builder = DB::table('kakeibos');
      
      if (!empty($cond_bank)) {
       $query_builder = $query_builder->where('bank', $cond_bank);
      }
      if (!empty($cond_total)) {
       $query_builder = $query_builder->where('total', $cond_total);
      }
      if (!empty($cond_paydatefrom)) {
       $query_builder = $query_builder->where('date','>=', $cond_paydatefrom);
      }
      if (!empty($cond_paydateto)) {
       $query_builder = $query_builder->where('date','<=', $cond_paydateto);
      }
      if (!empty($cond_category)) {
       $query_builder = $query_builder->where('category', $cond_category);
      }
      $records = $query_builder->get();
      
      
      //if ($cond_bank != '' or $cond_total != '' or $cond_paydatefrom != '' or $cond_paydateto != '' or $cond_category != '' ) {
      // $records = Kakeibo::where('bank', $cond_bank)->get();
      //}else{
      //  $records = Kakeibo::all();
      //}
      
      
      foreach($records as $kakeibo)
      {
        
          if ($kakeibo->total == '収入'){
              
              $incomeTotal = $incomeTotal + $kakeibo->amount;
              
          }else {
              $expenceTotal = $expenceTotal + $kakeibo->amount;
          }
        
      }
      
      
                                                                                                  
      return view('kakeibo.index',['records'=> $records,'incomeTotal'=>$incomeTotal,'expenceTotal'=>$expenceTotal,'bankaddition'=>$bankaddition,'categoryaddition'=>$categoryaddition,'request'=>$request]);
      
  }
  
 public function create(Request $request)
  {
     // dd($request);
      /*追加*/
      $this->validate($request, Kakeibo::$rules);

      $kakeibo = new Kakeibo;
      $form = $request->all();
      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // データベースに保存する
      $kakeibo->fill($form);
      $kakeibo->save();
      
    return redirect('/kakeibo');
  }

   public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      $kakeibo = Kakeibo::find($request->id);
      // 削除する
      $kakeibo->delete();
      return redirect('/kakeibo');
  }  
  
  public function bankaddition(Request $request)
  {
      if (!empty($request->bankaddition)){
        
        $bankaddition = new Bank;
        $form = $request->all();
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        // データベースに保存する
        $bankaddition->fill($form);
        $bankaddition->save();
        
      }elseif(!empty($request ->bankdelete)){
        $query_builder = DB::table('bank');
        $query_builder = $query_builder->where('bank', $request->bank);
        $query_builder->delete();
      }
      
      return redirect('/kakeibo');
  }
  public function categoryaddition(Request $request)
  {
     if (!empty($request->categoryaddition)){
      $categoryaddition = new Category;
      $form = $request->all();
      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // データベースに保存する
      $categoryaddition->fill($form);
      $categoryaddition->save();
      
     }elseif(!empty($request ->categorydelete)){
        $query_builder = DB::table('category');
        $query_builder = $query_builder->where('category', $request->category);
        $query_builder->delete();
     }  
      return redirect('/kakeibo');
  }
}
