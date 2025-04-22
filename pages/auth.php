<div class="mt-5 block_animation">
    <div class="mt-5 row justify-content-center">
        <div class="col-12 col-lg-7 border border-light border-2 p-lg-5 p-4 rounded-5">
            <h1 class="mb-5">Жүйеге кіру</h1>
            <? if(isset($_GET['input'])): ?>
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <div>
                    <? if(isset($_GET['input'])&&$_GET['input']==='wrong'): ?>
                        Телефондық нөмер немесе электрондық пошта және құпия сөзіңіз қате, қайтадан теріңіз
                    <? endif;?>
                </div>
            </div>
            <? endif;?>
            <form method="POST" action="api/auth.php">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Телефон/электрондық пошта</label>
                    <input name="auth" type="text" class="form-control bg-body-secondary" id="exampleInputEmail1" placeholder="Телефон немесе электрондық поштаны еңгізіңіз" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Құпия сөз</label>
                    <input name="pass" type="password" class="form-control bg-body-secondary" id="exampleInputPassword1" placeholder="Құпия сөзді еңгізіңіз" required>
                </div>
                <div class="mt-5">
                    <button type="submit" name="submit" class="btn btn-lg btn-primary">Кіру</button>
                    <a data-page href="?location=register" class="btn btn-lg btn-link">Тіркелу</a>
                </div>
            </form>
        </div>
    </div>
</div>