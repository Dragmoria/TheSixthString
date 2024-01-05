<h1>goedendag
    <?= $gebruiker ?>
</h1>
<p>
    Klik op de link om je account te activeren:
    <a href="<?="{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/Activate/{$token}"?>">Account activeren</a>
    <br><b>Pas na activatie kunt u inloggen.</b>
</p>