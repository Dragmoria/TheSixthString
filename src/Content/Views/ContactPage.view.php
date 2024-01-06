<style>
    :root {
        --sixth-black: #1C1713;
        --sixth-brown: #2C231E;
        --sixth-yellow: #fab30e;
        --sixth-beige: #EFE3C4;
        --sixth-white: #FFFFFF;
    }

    body {
        background-color: var(--sixth-brown) !important;
    }

    input[type=text],
    select,
    textarea {
        width: 100%;
        background-color: var(--sixth-beige);
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-top: 6px;
        margin-bottom: 16px;
        font-family: "Sans-serif", Arial, SansSerif, serif;
        font-size: 13px;
        resize: vertical
    }

    input[type=email],
    select,
    textarea {
        width: 100%;
        background-color: var(--sixth-beige);
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-top: 6px;
        margin-bottom: 16px;
        font-family: "Sans-serif", Arial, SansSerif, serif;
        font-size: 13px;
        resize: vertical
    }

    textarea[id=message] {
        width: 100%;
        background-color: var(--sixth-beige);
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-top: 6px;
        margin-bottom: 16px;
        resize: vertical;
        font-family: "Sans-serif", Arial, SansSerif, serif;
        font-size: 13px;
    }

    input[type=submit] {
        background-color: var(--sixth-yellow);
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: var(--sixth-yellow);
        filter: drop-shadow(5px 29px 40px #000000);
    }

    .container {
        border-color: var(--sixth-black);
        background-color: var(--sixth-black);
        border-radius: 5px;
        padding: 20px;
    }

    .section {
        border-color: var(--sixth-beige);
        background-color: var(--sixth-beige);
        margin-bottom: 16px;
        border-radius: 5px;
        padding: 20px;
    }

    h2 {
        width: 100%;
        border: 1px solid var(--sixth-beige);
        box-sizing: border-box;
        margin-top: 5px;
        margin-bottom: 5px;
        font-family: "Sans-serif", Arial, SansSerif, serif;
        font-size: 30px;
        resize: vertical
    }

    label {
        border: none;
        color: #cccccc;
        cursor: pointer;
        font-family: "Sans-serif", Arial, SansSerif, serif;
        font-size: 15px;
    }
</style>

<div class="container">
    <section class="section">
        <h2>Neem contact met ons op!</h2>
    </section>

    <form action="/ContactForm/Send" method="post">
        <label for="firstname">Voornaam</label>
        <input name="firstname" type="text" required="yes" id="firstname" placeholder="Vul hier uw voornaam in...">

        <label for="lastname">Achternaam</label>
        <input name="lastname" type="text" required="yes" id="lastname" placeholder="Vul hier uw achternaam in...">

        <label for="email">Emailadres</label>
        <input name="email" type="email" required="yes" id="email" placeholder="Vul hier uw e-mailadres in...">

        <label for="message">Type hier uw bericht</label>
        <textarea name="message" required="yes" id="message" placeholder="Type hier uw bericht"
            style="height:200px"></textarea>

        <input type="submit" value="verzenden">

    </form>
</div>