<div style="
    width: 100%;
    height: 500px;
    background: #CCCCCC;
    margin:0;
    padding: 100px 0 0 0;
    align-items: center;
    font-family: Arial, serif;
">
    <div style="
        width: 500px;
        background: rgba(255, 255, 255, 1);
        box-shadow: 0 5px 20px -5px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        padding: 10px 30px;
        border-radius: 10px;
    ">
        <h2 style="
            color: green;
            font-family: Arial, serif;
            text-align: center;
        ">Xin chào, {{ $user->name }}!</h2>
        <p style="font-family: Arial, serif; text-align: center">Vui lòng nhấn vào liên kết dưới đây để đặt lại mật khẩu cho tài
            khoản {{ $user->email }}.</p>
        <p style="
            font-family: Arial, serif;
            text-align: center;
            margin-top:30px
        ">
            @if($guard === 'user')
                <a target="_blank" href="{{ route('auth.show_user_reset_password_form', ['token' => $token ]) }}" style="
                background-color: #4CAF50; /* Green */
                border: none;
                color: white;
                padding: 10px 30px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                border-radius: 8px;
                font-family: Arial, serif;
            ">Đặt lại mật khẩu</a>
            @elseif($guard === 'admin')
                <a target="_blank" href="{{ route('auth.show_admin_reset_password_form', ['token' => $token ]) }}" style="
                background-color: #4CAF50; /* Green */
                border: none;
                color: white;
                padding: 10px 30px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                border-radius: 8px;
                font-family: Arial, serif;
            ">Đặt lại mật khẩu</a>
            @endif
        </p>
    </div>
</div>
