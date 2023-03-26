@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Account Manage</h1>

    <div class="row">
        <div class="col-md-12">
            
                <form method="GET" action="/accountmanage" style="margin-top:20px;">
                    <input type="text" placeholder="搜尋姓名" aria-label="Search" name="search" >
                    <input type="hidden" name="orderBy" value="{{ $orderBy }}">
                    <input type="hidden" name="orderDirection" value="{{ $orderDirection }}">
                    <button class="btn btn-primary">搜索</button>
                </form>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>帳號</th>
                        <th>
                            <a href="?orderBy=name&orderDirection={{ $orderDirection === 'asc' ? 'desc' : 'asc' }}&search={{ $search ?? '' }}">
                                姓名
                                @if ($orderBy === 'name')
                                    @if ($orderDirection === 'asc')
                                        <i class="fa fa-sort-down"></i>
                                    @else
                                        <i class="fa fa-sort-up"></i>
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th>性別</th>
                        <th>生日</th>
                        <th>Email</th>
                        <th>備註</th>
                        <th>更改</th>
                        <th>刪除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accountInfos as $accountInfo)
                    <tr>
                        <td>{{ $accountInfo->account }}</td>
                        <td>{{ $accountInfo->name }}</td>
                        <td>{{ $accountInfo->gender }}</td>
                        <td>{{ $accountInfo->birthday }}</td>
                        <td>{{ $accountInfo->email }}</td>
                        <td>{{ $accountInfo->note }}</td>
                        <td>
                            <button type="button" class="btn btn-primary edit-btn" data-id="{{ $accountInfo->id }}"  >更改</button>
                              
                        </td>
                        
                        <td>
                            <button type="button" class="btn btn-primary delete-btn" data-id="{{ $accountInfo->id }}"  >刪除</button>
                              
                        </td>
                    <td>
                    </td>
                </tr>
                
                @endforeach
            </tbody>
        </table>
        <div style="text-align:center;">
            {{ $accountInfos->links() }}
        </div>
        <div class="" style="margin-bottom:50px;">
            <button type="button"  class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#createModal">新增</button>
        </div>
       
    </div>
</div>
</div>
<!-- 刪除Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">確定刪除嗎？</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="delete">
                    <input type="hidden" id="deleteId" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="deleteBtn">確定</button>
            </div>
        </div>
    </div>
</div>
<!-- 修改Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">編輯資料</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="update">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-3">
                        <label for="" class="form-label">帳號</label>
                        <input type="text" class="form-control" id="editAccount" name="account">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">姓名</label>
                        <input type="text" class="form-control" id="editName" name="name">
                    </div>
                    <label for="" class="form-label">性別</label>
                    <select name="gender" id="editGender" class="form-select">
                        <option value="男">男</option>
                        <option value="女">女</option>
                    </select>
                    <div class="mb-3">
                        <label for="" class="form-label">生日</label>
                        <input type="date" class="form-control" id="editBirthday" name="birthday">
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">備註</label>
                        <input type="text" class="form-control" id="editRemork" name="remork">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="editBtn">更新</button>
            </div>
        </div>
    </div>
</div>
<!-- 新增Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form id="create">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">新增</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <label for="">帳號</label>
                <input type="text" name="account" class="form-control">
                <label for="">姓名</label>
                <input type="text" name="name" class="form-control">
                <label for="">性別</label>
                <select name="gender" id="" class="form-select">
                    <option value="男">男</option>
                    <option value="女">女</option>
                </select>
                <label for="">生日</label>
                <input type="date" name="birthday" class="form-control">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control">
                <label for="">備註</label>
                <input type="text" name="remark" class="form-control">

                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                {{csrf_field()}}
                <button type="submit" class="btn btn-primary" id="createBtn">送出</button>
            </div>
        </form>
    </div>
</div>
</div>


<script>
    $(document).ready(function() {

         // 新增
        $('#createBtn').click(function () {
            var formData = $('#create').serialize(); // 將表單數據序列化為字串
        $.ajax({
            url: "{{ route('accountmanage') }}", 
            type: "post",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(response) {
                
                console.log(response);
                //$('#createmodel').modal('hide');
                //location.reload(true);

            },
            error: function(xhr, status, error) {
                
                console.error(xhr.responseText);
                alert(xhr.responseText);
            }
        });
    });
       

     // 當點擊編輯按鈕時，取得資料並填入表單中
     $('body').on('click', '.edit-btn', function () {
        var id = $(this).data('id');

        $.ajax({
            type: "post",
            url: "/accountmanage/" + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType:"json",
            success: function (data) {
                // 關閉 Modal 並重新載入資料
                $('#editId').val(data['data']['id']);
                $('#editAccount').val(data['data']['account']);
                $('#editName').val(data['data']['name']);
                var gender = data['data']['gender'];
                if(gender == '男'){
                    $('#editGender').val('男');
                }else{
                    $('#editGender').val('女');
                }
                $('#editBirthday').val(data['data']['birthday']);
                $('#editEmail').val(data['data']['email']);
                $('#editRemark').val(data['data']['remark']);
                $('#editModal').modal('show');
                
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
       /* $.get('/data/' + id, function (data) {
            
        });*/
    });
        
    $('#editBtn').click(function () {
        var id = $('#editId').val();
        var formData = $('#update').serialize(); // 將表單數據序列化為字串
        $.ajax({
            url: "/accountmanage/" + id + "/edit", 
            type: "put",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(response) {
                
                console.log(response);
                $('#editModal').modal('hide');
                location.reload(true);

            },
            error: function(xhr, status, error) {
                
                console.error(xhr.responseText);
                alert(xhr.responseText);
            }
        });
    });

    // 刪除
    $('body').on('click', '.delete-btn', function () {
        var id = $(this).data('id');
        $('#deleteId').val(id);
        $('#deleteModal').modal('show');
       
    });
    
    $('#deleteBtn').click(function () {
        var id = $('#deleteId').val();
        var formData = $('#delete').serialize(); // 將表單數據序列化為字串
        $.ajax({
            url: "/accountmanage/" + id, 
            type: "delete",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(response) {

                $('#deleteModal').modal('hide');
                location.reload(true);

            },
            error: function(xhr, status, error) {
                
                console.error(xhr.responseText);
                alert(xhr.responseText);
            }
        });
    });
    });
</script>
@endsection
