<div class="mt-5 block_animation">
    <div class="mt-5 row justify-content-center">
        <div class="col-12 col-lg-7 border border-light border-2 p-lg-5 p-4 rounded-5">
            <h1 class="mb-5">Жүйеге тіркелу</h1>
            <? if(isset($_GET['phone']) || isset($_GET['email'])): ?>
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <div>
                    <? if(isset($_GET['phone'])&&$_GET['phone']==='busy'): ?>
                        Телефондық нөмер бос емес, басқаны теріңіз
                    <? endif;?>
                    <? if(isset($_GET['email'])&&$_GET['email']==='busy'): ?>
                        Электрондық пошта бос емес, басқаны теріңіз
                    <? endif;?>
                </div>
            </div>
            <? endif;?>
            <form method="POST" action="api/register.php">
                <div class="mb-3">
                    <label for="registerName" class="form-label">Атыңыз</label>
                    <input name="registerName" type="text" class="form-control bg-body-secondary" id="registerName" placeholder="Атың еңгізіңіз" required>
                </div>
                <div class="mb-3">
                    <label for="registerSurname" class="form-label">Тегіңіз</label>
                    <input name="registerSurname" type="text" class="form-control bg-body-secondary" id="registerSurname" placeholder="Тегіңізді еңгізіңіз" required>
                </div>
                <div class="mb-3">
                    <label for="registerPhone" class="form-label">Телефон</label>
                    <input name="registerPhone" type="text" class="form-control bg-body-secondary" id="registerPhone" placeholder="Телефонды еңгізіңіз" required>
                </div>
                <div class="mb-3">
                    <label for="registerEmail" class="form-label">Электрондық пошта</label>
                    <input name="registerEmail" type="email" class="form-control bg-body-secondary" id="registerEmail" placeholder="Электрондық поштаны еңгізіңіз" required>
                </div>
                <div class="mb-3">
                    <label for="registerPassword" class="form-label">Құпия сөз</label>
                    <input name="registerPassword" type="password" class="form-control bg-body-secondary" id="registerPassword" placeholder="Құпия сөзді еңгізіңіз" required>
                </div>
                <div class="mt-5">
                    <button type="submit" name="submit" class="btn btn-lg btn-primary">Тіркелу</button>
                    <a data-page href="?location=auth" class="btn btn-lg btn-link">Кіру</a>
                </div>
            </form>
        </div>
    </div>
</div>