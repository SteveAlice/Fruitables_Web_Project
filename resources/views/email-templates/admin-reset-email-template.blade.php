<p>Dear {{ $admin->name }}</p>
<br>
<p>
    Your password on FruitShop system was changed successfully.
    Here is your new login credentials:
    <br>
    <b>Login ID: <b>{{ $admin -> username}} or {{ $admin -> email}}</b></b>
    <br>
    <b>Password: </b>{{ $new_password}}
</p>
<br>
Please, keep your credentials confidential. Your username and password are your own credentials and you should never share them with anybody else.
<p>
    FruitShop will not liable for any misuse of your username or password.
</p>

---------------------------------------------------------------------
<p>
    This is was automatically sent by FruitShop. Do not reply it.
</p>
