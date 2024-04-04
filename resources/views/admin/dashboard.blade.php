@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Users') }}</div>
                <div class="card-body">
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <button id="addUserBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add new User</button>
                        </div>
                    </div> 
                    <div>
                        <table class="table" id="user-table">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Activate</th>
                                    <th class="text-center" colspan="2" scope="col-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onClick="createUser()">Save</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function fetchUsers() {
        $.ajax({
            url: 'http://127.0.0.1:8000/api/get-users',
            type: 'GET',
            dataType: 'json',

            success: function (data) {
                $('#user-table tbody').empty();

                data.users.forEach(function (user) {
                   if(user.role_id != 1) {
                        $('#user-table tbody').append(
                            '<tr>' +
                            '<td>' + user.id + '</td>' +
                            '<td>' + user.username + '</td>' +
                            '<td>' + user.email + '</td>' +
                            '<td><button type="button" onClick="toggleUserStatus('+ user.id +', '+ user.is_active +')" class="btn btn-'+(user.is_active ? 'danger' : 'success')+'">'+(user.is_active ? 'Deactivate' : 'Activate')+'</button></td>' +
                            '<td><a href="{{ url("/admin/") }}/edit?user_id=' + user.id + '"class="text-decoration-none"><i class="fa-solid fa-pen-to-square text-dark"></i></a></td>' +
                            '<td><button type="button" onclick="deleteUser('+ user.id +')" class="border-0 bg-white d-block mx-auto"><i class="fa-solid fa-trash-can"></i></button></td>' +
                            '</tr>'
                        );
                   }
                });
            },
            error: function (error) {
                console.error('Error fetching users:', error);
            }
        });
    }

    function createUser() {
        $.ajax({
            url: 'http://127.0.0.1:8000/api/create-user',
            type: 'POST',
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
                "username": $('#username').val(),
                "password": $('#password').val(),
                "email": $('#email').val()
            },
            success: function(response) {
                alert(response.success);
                fetchUsers();
                $('#addUserModal').modal('hide');
            },
            error: function(error) {
                console.error(error); 
            }
        });
    }

    function deleteUser(user_id) {
        $.ajax({
            url: 'http://127.0.0.1:8000/api/delete-user',
            type: 'DELETE',
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
                "user_id": user_id
            },
            success: function (response) {
                alert(response.success);
                fetchUsers();
            },
            error: function (error) {
                console.error('Error fetching user:', error);
            }
        })
    }

    function toggleUserStatus(user_id, current_status) {
        let new_status = current_status ? 0 : 1; // Toggle the status
        $.ajax({
            url: 'http://127.0.0.1:8000/api/user-status',
            type: 'PUT',
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
                "user_id": user_id,
                "status": new_status
            },
            success: function (response) {
                alert(response.success);
                fetchUsers();
            },
            error: function (error) {
                console.error('Error toggling user status:', error);
            }
        });
    }

    $(document).ready(function () {
        fetchUsers();
    });
</script>

@endsection
