<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joulutervitused</title>
    <link rel="stylesheet" href="./index.css">
</head>
<body>
    <form id="messageForm" class="message-form">
        <label for="message">Sisesta enda tervitussõnum</label>
        <input name="message" id="message" required/>
        <label for="name">Sisesta enda nimi</label>
        <input name="name" id="name" required/>
        <label for="email">Sisesta enda e-post</label>
        <input name="email" id="email" required/>
        <button type="submit">Saada</button>
    </form> 

    <script>
        document.getElementById('messageForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const jsonData = {
                message: document.getElementById('message').value,
                name: document.getElementById('name').value,
                email: document.getElementById('email').value
            };

            fetch('sendMessage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>