<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="module" src="./js/validationClient.js" defer></script>
    <link rel="stylesheet" href="css/output.css">
      <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-zinc-900 text-sm sm:text-m">
<div
        class="flex flex-col w-1/2 border-solid border-2 border-zinc-400 rounded-xl mx-auto p-3 mt-10 bg-zinc-700/50 shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#fff,0_0_15px_#fff,0_0_30px_#fff]">
    <h1 class="text-xl font-bold p-2 text-center w-1/2 bg-zinc-900/75 hover:bg-zinc-700 hover:underline rounded-xl self-center shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#fff,0_0_15px_#fff,0_0_30px_#fff] text-slate-100">Connexion Admin</h1>
    <form class="form flex flex-col" action="check_login.php" method="post">
        <div class="mt-3">
            <label class="text-m p-2 text-center w-1/2 bg-zinc-900/50 rounded-xl shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#fff,0_0_15px_#fff,0_0_30px_#fff] text-slate-100" for="username">Utilisateur :</label>
            <div class="control">
                <input class="p-2 mt-3 w-full rounded-xl" type="text" id="username" name="username" required>
            </div>
        </div>

        <div class="mt-3">
            <label class="text-m p-2 text-center w-1/2 bg-zinc-900/50 rounded-xl shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#fff,0_0_15px_#fff,0_0_30px_#fff] text-slate-100" for="password">Mot de passe :</label>
            <div class="control">
                <input class="p-2 mt-3 w-full rounded-xl" type="password" id="password" name="password" required>
            </div>
        </div>

        <div class="mt-3 self-center">
            <div class="text-m p-2 text-center bg-zinc-900/50 rounded-xl shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#fff,0_0_15px_#fff,0_0_30px_#fff] text-slate-100">
                <button class="button is-link" type="submit">Se connecter</button>
            </div>
                        <div class="form_boutton mt-3 self-center text-center">
    <a href="../index.html" class="text-zinc-400 s-center">Retour</a>
</div>
        </div>
    </form>
</div>
</body>
</html>