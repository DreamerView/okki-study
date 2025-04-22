<nav class="navbar navbar-expand-xl bg-transparent p-3 p-lg-3 border-bottom border-light border-1">
    <div class="container ">
        <a data-page class="navbar-brand fw-bold fs-4" href="?location=all">Zaru Academy</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="ms-lg-3 ms-0 mt-3 mt-lg-0 navbar-nav gap-3">
                <li class="nav-item">
                    <a data-page class="nav-link" href="?location=all"><i class="bi bi-journal-check me-1"></i> Барлық курстар</a>
                </li>
                <li class="nav-item">
                    <a data-page class="nav-link" href="?location=my_courses"><i class="bi bi-app-indicator me-1"></i> Менің курстарым</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-cast me-1"></i> Тікелей эфир</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-journal-text me-1"></i> Кесте</a>
                </li>
                
            </ul>
            <div class="d-flex flex-wrap gap-3 ms-lg-auto ms-0 mt-3 mt-lg-0">
                <button class="btn btn-outline-dark p-2 rounded">Okki Study v.1.0</button>
                <? if(isset($_COOKIE['name'])) { ?>
                    <a data-page href="?location=auth" class="btn text-primary p-2 rounded"><?=$_COOKIE['name'];?></a>
                <? } else { ?>
                    <a data-page href="?location=auth" class="btn text-primary p-2 rounded">Кіру</a>
                <? } ?>
            </div>
        </div>
    </div>
</nav>