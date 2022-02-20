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
        ">Welcome, {{ $user->name }}!</h2>
        <p style="font-family: Arial, serif;">Thanks for signing up! We just need you to verify your email address to complete setting up
            your account.</p>

        <p style="
            font-family: Arial, serif;
            text-align: center;
            margin-top:30px
        ">
            <a target="_blank" href="{{ route('auth.verify_user_email', ['token' => $token->token ]) }}" style="
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
            ">Verify</a>
        </p>
    </div>
</div>
