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
     * 顯示資源列表
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * 顯示新增資源的表單
     */
    public function create()
    {
        //
        return view('account-info.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * 儲存新建的資源
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


        $accountInfo = AccountInfo::create($validatedData);

        return response()->json(['success' => true, 'message' => '資源已成功新增！', 'data' => $accountInfo]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * 顯示指定資源的詳細資訊
     */
    public function show($id)
    {
        //
        $accountInfo = AccountInfo::findOrFail($id);
        
        return response()->json(['success' => true, 'message' => '資源已成功更新！', 'data' => $accountInfo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /**
     * 顯示編輯資源的表單
     */
    public function edit($id)
    {
        //
        $accountInfo = AccountInfo::find($id);
        return view('account_info', ['accountInfo' => $accountInfo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /**
     * 更新指定資源
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

        $accountInfo = AccountInfo::findOrFail($id);
        $accountInfo->update($validatedData);

        return response()->json(['success' => true, 'message' => '資源已成功更新！', 'data' => $accountInfo]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * 刪除指定資源
     */
    public function destroy($id)
    {
        //
        $accountInfo = AccountInfo::findOrFail($id);
        $accountInfo->delete();

        return response()->json(['success' => true, 'message' => '資源已成功刪除！', 'data' => null]);
    }
}
