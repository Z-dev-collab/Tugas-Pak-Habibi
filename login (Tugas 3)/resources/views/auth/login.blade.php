<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>

    <h2 align="center">Login</h2>
    <div style="align="center"></div>
    <div class="form-page"x>
        <form action="{{route('login.proceed')}}" method="post" align="center" method="POST">
            @csrf
            <table align="center">
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" required></td>
                </tr>
            </table>
            <input type="checkbox" name="remember" id="remember" class="remember">Remember Me
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>