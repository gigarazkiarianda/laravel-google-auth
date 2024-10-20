<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="text-center card-header">
                        <h4>Login Successful!</h4>
                    </div>
                    <div class="text-center card-body">
                        <p>Welcome, you have successfully logged in using Google.</p>
                        <!-- Link to home (dashboard) -->
                        <a href="/home" class="mb-2 btn btn-primary">Go to Dashboard</a>
                        <!-- Add a logout button as well, in case the user wants to log out -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-secondary">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
