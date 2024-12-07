<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP projekt</title>
    <link href="./css/index.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="main-container">
        <h1>Sign up</h1>
        <div>
            <p id="login-msg">msg</p>
        </div>
        <form class="greeting-form" onsubmit="submitForm(event);" method="POST">
            <label>Username</label>
            <input class="text-input" name="username" type="text">
            <label>Password</label>
            <input class="text-input" name="password" type="password">
            <label>Confirm password</label>
            <input class="text-input" name="confirm-password" type="password">
            <button type="submit">Send</button>
        </form>
    </div>
</body>

<script>
    const submitForm = (event) => {
        event.preventDefault(); // Prevent the default form submission

        const username = document.getElementsByName('username')[0].value;
        const pwd1 = document.getElementsByName('password')[0].value;
        const pwd2 = document.getElementsByName('confirm-password')[0].value;

        console.log(pwd1 + pwd2);

        if (pwd1 === pwd2) {
            $.ajax({
                method: "POST",
                url: "./login.php", // Ensure this points to the correct sibling PHP file
                data: {
                    username: username,
                    password: pwd1
                }
            })
            .done((response) => {
                let alertElem = document.getElementById("login-msg");
                alertElem.innerHTML = "Konto loomine õnnestus";
                alertElem.style.display = "block";

                // Clearing the input fields
                $('input[type="text"], textarea').val('');

                setTimeout(() => {
                    alertElem.style.display = "none";
                }, 3000);
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                console.error('Fetch error:', textStatus, errorThrown, jqXHR.responseText);
                alert('Midagi läks valesti: ' + textStatus);
            });
        } else {
            alert("Passwordid ei matchi.");
        }
    }
</script>

</html>