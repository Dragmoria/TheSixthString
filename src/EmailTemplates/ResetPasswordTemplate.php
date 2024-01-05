<h1>Hallo <?=$gebruiker?></h1>
<p>
    Klik op de link om je wachtwoord te resetten:
    <a href="<?="{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/ResetPassword/{$token}"?>">Reset password</a>
</p>