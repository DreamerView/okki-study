const Preloader = () => {
    $('div#root').html(`
        <div style="width:3rem;height:3rem;" class="spinner-border text-primary m-5" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    `);
};

const NetworkError = () => {
    $('div#root').html(`
        <div class="my-5 mx-1 row justify-content-center">
            <div class="col-lg-8 col-12 bg-body-secondary p-5 rounded-4 text-center">
                <h1 class="mb-4">Интернетке байланыс жоқ</h1>
                <p>Өкінішке орай интернетке байланыс жоқ.</p>
                <a data-page class="mt-3 btn btn-lg btn-primary" href="?location=all">Қайтадан</a>
            </div>
        </div>
    `);
};

const Error404 = () => {
    $('div#root').html(`
        <div class="my-5 mx-1 row justify-content-center">
            <div class="col-lg-8 col-12 bg-body-secondary p-5 rounded-4 text-center">
                <h1 class="mb-4">Бет табылмады</h1>
                <p>Өкінішке орай бет табылмады.</p>
                <a data-page class="mt-3 btn btn-lg btn-primary" href="?location=all">Үйге</a>
            </div>
        </div>
    `);
};

const Error500 = () => {
    $('div#root').html(`
        <div class="my-5 mx-1 row justify-content-center">
            <div class="col-lg-8 col-12 bg-body-secondary p-5 rounded-4 text-center">
                <h1 class="mb-4">Жүйеде қате кетті</h1>
                <p>Өкінішке орай жүйеде қате кетті.</p>
                <a data-page class="mt-3 btn btn-lg btn-primary" href="?location=all">Үйге</a>
            </div>
        </div>
    `);
};

const ErrorHandler = (xhr, status, error) => {
    console.error('Ошибка:', status, error);
    switch (xhr.status) {
        case 0:
            if (status === 'error') {
                console.error('Отсутствует соединение с интернетом');
                NetworkError();
            }
            break;
        case 404:
            console.error('Страница не найдена');
            Error404();
            break;
        case 500:
            console.error('Внутренняя ошибка сервера');
            Error500();
            break;
        default:
            break;
    }    
}

const makeHtmlRequest = (url, successCallback) => {
    $.ajax({
        url,
        method: 'GET',
        dataType: 'text',
        cache: false,
        beforeSend: Preloader,
        success: successCallback,
        error: ErrorHandler
    });
};

const handleLocationParameter = (url) => {
    const queryString = url.split('?')[1];
    return queryString ? new URLSearchParams(queryString).get('location') : null;
};

const removeLocationParameter = (url) => {
    const urlParams = new URLSearchParams(url);
    urlParams.delete('location');
    return '?' + urlParams.toString();
};

const updatePageContent = (data) => {
    const rootDiv = document.querySelector('div#root');
    rootDiv.innerHTML = data;
    document.querySelector("h1#preloaderHTML").style.display = "none";
    $("div#root").find('script').each((i, script) => {
        const newScript = document.createElement('script');
        newScript.text = script.text;
        document.body.appendChild(newScript);
    });
};

const makePageRequest = (path) => {
    makeHtmlRequest(`pages/${handleLocationParameter(path)}.php${removeLocationParameter(path)}`,
        (data) => {
            updatePageContent(data);
            const getPath = window.location.search.replace(/\s/g, '');
            const reqPath = path.replace(/\s/g, '');
            if (getPath !== reqPath) window.history.pushState({ path }, '', path);
        }
    );
};

const pageUpdate = () => {
    $(document).on('click', '[data-page]', function(event) {
        event.preventDefault();
        const path = $(this).attr("href");
        $('.navbar-collapse').collapse('hide');
        makePageRequest(path);
    });
};


function modalFormUpdate() {
    $('form[data-modal-form]').each(function() {
        $(this).submit(function(event) {
            event.preventDefault();

            var formData = new FormData();

            var formElements = $(this).find('[name]');

            formElements.each(function() {
                if ($(this).prop('type') === 'file') {
                    formData.append($(this).prop('name'), $(this).prop('files')[0]);
                } else {
                    formData.append($(this).prop('name'), $(this).val());
                }
            });

            formData.append('lazy', 'yes');

            const formId = $(this).attr('id');
            $("[data-modal]").each(function() {
                const attr = $(this).attr("data-modal");
                if(attr === formId) {
                    const modal = bootstrap.Modal.getInstance(this);
                    if(modal) modal.hide();
                }
            });

            $('.navbar-collapse').collapse('hide');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                beforeSend: Preloader,
                processData: false,
                contentType: false,
                cache: false,
                success: function(pathResult) {
                    var reqPath = pathResult.replace(/\s/g, '');
                    makeHtmlRequest("pages/" + handleLocationParameter(reqPath) + ".php" + removeLocationParameter(reqPath),
                        function(data) {
                            $('div#root').html(data);
                            $('h1#preloaderHTML').css('display', 'none');
                            $("div#root").find('script').each(function(i, script) {
                                var newScript = document.createElement('script');
                                newScript.text = script.text;
                                document.body.appendChild(newScript);
                            });
                            var getPath = window.location.search.replace(/\s/g, '');
                            if (getPath !== reqPath) window.history.pushState({ path: reqPath }, '', reqPath);
                            $('input,textarea').val('');
                        }
                    );
                },
                error: ErrorHandler
            });
        });
    });
}

function formUpdate() {
    $(document).on('submit', 'form[data-form]', function(event) {
        event.preventDefault();
    
        var formData = new FormData();
        var formElements = $(this).find('[name]');
    
        formElements.each(function() {
            if ($(this).prop('type') === 'file') {
                formData.append($(this).prop('name'), $(this).prop('files')[0]);
            } else {
                formData.append($(this).prop('name'), $(this).val());
            }
        });
    
        formData.append('lazy', 'yes');
    
        $('.navbar-collapse').collapse('hide');
    
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            beforeSend: Preloader,
            processData: false,
            contentType: false,
            cache: false,
            success: function(pathResult) {
                var reqPath = pathResult.replace(/\s/g, '');
                makeHtmlRequest("pages/" + handleLocationParameter(reqPath) + ".php" + removeLocationParameter(reqPath),
                    function(data) {
                        $('div#root').html(data);
                        $('h1#preloaderHTML').css('display', 'none');
                        $("div#root").find('script').each(function(i, script) {
                            var newScript = document.createElement('script');
                            newScript.text = script.text;
                            document.body.appendChild(newScript);
                        });
                        var getPath = window.location.search.replace(/\s/g, '');
                        if (getPath !== reqPath) window.history.pushState({ path: reqPath }, '', reqPath);
                        $('input,textarea').val('');
                    }
                );
            },
            error: ErrorHandler
        });
    });
    
}

const allUpdate = () => {
    pageUpdate();
    modalFormUpdate();
    formUpdate();
};

allUpdate();

const pageReload = () => {
    $(document).on('click', '[data-page-reload]', (e) => {
        e.preventDefault();
        let path = window.location.search || "?location=all";
        makePageRequest(path);
    });
    $(document).on('click', '[data-page-back]', (e) => {
        e.preventDefault();
        history.back();
    });
};

pageReload();

window.addEventListener('popstate', () => {
    let get = window.location.search || "?location=all";
    makePageRequest(get);
});