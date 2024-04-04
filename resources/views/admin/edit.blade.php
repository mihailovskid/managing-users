@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Edit User') }}</div>
            <div class="card-body">
                <table class="table">
                    <form action="#" method="POST">
                        @csrf
						<div class="mb-3">
                            <input type="hidden" class="form-control" id="user_id" name="user_id">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
                        </div>
                        <div>
                            <button type="button" onClick="updateUser()" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
		function fetchSingleUser() {
			let user_id = getUserIdFromUrl()

			$.ajax({
                url: 'http://127.0.0.1:8000/api/get-user',
				type: 'GET',
				dataType: 'json',
				data: {
					'user_id': user_id
				},
				success: function(response) {

                    console.log(response);
					$('#user_id').val(user_id)
                    $('#username').val(response.user.username)
					$('#email').val(response.user.email)
                },
                error: function(error) {
                    console.error(error); 
                }
			})
		}

		fetchSingleUser()

        function updateUser() {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/update-user',
                type: 'PUT',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
					"user_id": $('#user_id').val(),
                    "username": $('#username').val(),
                    "email": $('#email').val(),
                },
                success: function(response) {
					alert(response.success);
                    window.location.replace("http://127.0.0.1:8000/admin/dashboard");
                },
                error: function(error) {
                    console.error(error); 
                }
            });
        }

		
		function getUserIdFromUrl() {
			let searchParams = new URLSearchParams(window.location.search);
			let user_id = null

			if (searchParams.has('user_id')) {
				user_id = searchParams.get('user_id')
			}

			return user_id
		}

    </script>
@endsection
