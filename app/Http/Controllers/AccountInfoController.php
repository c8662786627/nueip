<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountInfo;

class AccountInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * 顯示清單
     * 
     * @param  \Illuminate\Http\Request  $request  HTTP請求物件
     * @return \Illuminate\Http\Response HTTP回應物件
     */
    public function index(Request $request)
    {
        //
        $query = AccountInfo::query();

        //搜尋
        $search = $request->input('search');

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        //排序
        $orderBy = $request->input('orderBy','name');
        $orderDirection = $request->input('orderDirection','asc');
        
        $accountInfos = $query->orderBy($orderBy, $orderDirection)->paginate(10);

      
        return view('account_info', [
                                        'accountInfos' => $accountInfos,
                                        'orderBy'=>$orderBy,
                                        'orderDirection'=>$orderDirection,
                                        'search' => $search,
                                        
                                    ]);
    }

    /**
     * 儲存新建的資源
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'account' => 'required|alpha_num',
            'name' => 'required',
            'gender' => 'required',
            'birthday' => 'required|date',
            'email' => 'required|email',
            
        ]);

        $validatedData['account'] = strtolower($validatedData['account']);

        $accountInfo = AccountInfo::create($validatedData);

        return response()->json(['success' => true, 'message' => '資源已成功新增！', 'data' => $accountInfo]);
    }

    /**
     * 顯示指定資源的詳細資訊
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        //
        $accountInfo = AccountInfo::findOrFail($id);
        
        return response()->json(['success' => true, 'message' => '資源已成功更新！', 'data' => $accountInfo]);
    }

    /**
     * 顯示編輯資源的表單
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $accountInfo = AccountInfo::find($id);
        return view('account_info', ['accountInfo' => $accountInfo]);
    }

    /**
     * 更新指定資料
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
        $validatedData = $request->validate([
            'account' => 'required|alpha_num',
            'name' => 'required',
            'gender' => 'required',
            'birthday' => 'required|date',
            'email' => 'required|email',
            
        ]);
        $validatedData['account'] = strtolower($validatedData['account']);
        $accountInfo = AccountInfo::findOrFail($id);
        $accountInfo->update($validatedData);

        return response()->json(['success' => true, 'message' => '資源已成功更新！', 'data' => $accountInfo]);
    }

    /**
     * 刪除指定id
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        $accountInfo = AccountInfo::findOrFail($id);
        $accountInfo->delete();

        return response()->json(['success' => true, 'message' => '資源已成功刪除！', 'data' => null]);
    }
    /**
     * 刪除指定所id
     *
     * @param  int  $ids
     * @return \Illuminate\Http\JsonResponse
     */
    public function alldelete(Request $request)
    {
        //
        $ids = $request->input('ids');
        AccountInfo::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => '已成功刪除資源！', 'data' => null]);
    }
    /**
     * 匯出csv資料
     *
     * 
     */
    public function exportCSV()
    {
        // 取得要匯出的資料
        $accountInfos = AccountInfo::all();
    
        // 建立CSV檔案
        $filename = 'account_infos.csv';
        $handle = fopen($filename, 'w+');
    
        // 寫入標頭
        fputcsv($handle, ['帳號', '姓名', '性別', '生日', 'Email', '備註']);
    
        // 寫入資料
        foreach ($accountInfos as $accountInfo) {
            fputcsv($handle, [
                $accountInfo->account,
                $accountInfo->name,
                $accountInfo->gender == '1' ? '男' : '女',
                date('Y年n月j日',strtotime($accountInfo->birthday)),
                $accountInfo->email,
                $accountInfo->note,
            ]);
        }
    
        // 關閉CSV檔案
        fclose($handle);
    
        // 下載CSV檔案
        $headers = [
            'Content-Type' => 'text/csv;charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        return response()->download($filename, $filename, $headers);
    }   
}
