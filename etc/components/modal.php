<div data-modal="auth" class="modal fade" id="authTo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Жүйеге кіру</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form data-modal-form method="POST" action="api/auth.php" id="auth" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="mb-3">
              <label for="auth-info" class="col-form-label">Телефон:</label>
              <input name="auth" placeholder="Телефонды теріңіз" type="text" class="form-control" id="auth-info" required>
            </div>
            <div class="mb-3">
              <label for="auth-pass" class="col-form-label">Кұпия сөз:</label>
              <input name="pass" placeholder="Кұпия сөзді теріңіз" type="password" class="form-control" id="auth-pass" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Жабу</button>
          <button type="submit" name="submit" class="btn btn-primary">Кіру</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->

<div data-modal="create_course" class="modal fade" id="createCourse" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Курс құрастыру</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form data-modal-form method="POST" action="api/createCourse.php" id="create_course" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row gap-3">
              <div class="col-auto">
                <label for="course-type" class="col-form-label">Курстың бағыты</label>
                <select class="form-control" name="course-type" id="course-type">
                  <option value="potok">Потоктық</option>
                  <option value="always">Постоянный</option>
                </select>
              </div>
              <div class="col-auto">
                <label for="course-price" class="col-form-label">Курстың бағасы:</label>
                <input name="course-price" placeholder="Курстың бағасың енгізіңіз" type="number" class="form-control" id="course-price" required>
              </div>
              <div class="col-auto">
                <label for="course-file" class="col-form-label">Курстың картинкасы</label>
                <input name="image" placeholder="Курстың атың енгізіңіз" type="file" class="form-control" id="course-file">
              </div>
            </div>
            <div class="mb-3">
              <label for="course-name" class="col-form-label">Курстың аты:</label>
              <input name="course-title" placeholder="Курстың атың енгізіңіз" type="text" class="form-control" id="course-name" required>
            </div>
            <div class="mb-3">
              <label for="course-text" class="col-form-label">Курс туралы ақпарат:</label>
              <textarea name="course-text" placeholder="Курстың ақпаратың енгізіңіз" class="form-control" id="course-text" required></textarea>
              <input name="course-author" placeholder="Курстың бағасың енгізіңіз" type="hidden" class="form-control" id="course-author" value="<?isset($_COOKIE['auth'])?$_COOKIE['auth']:'none';?>">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Жабу</button>
          <button type="submit" name="submit" class="btn btn-primary">Сақтау</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--  -->

<div data-modal="edit_course" class="modal fade" id="editCourse" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Курс ақпаратың өзгерту</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form data-modal-form method="POST" action="api/editCourse.php" id="edit_course" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row gap-3">
              <div class="col-auto">
                <label for="course-edit-type" class="col-form-label">Курстың бағыты</label>
                <select class="form-control" name="course-edit-type" id="course-edit-type" required>
                  <option value="potok">Потоктық</option>
                  <option value="always">Постоянный</option>
                </select>
              </div>
              <div class="col-auto">
                <label for="course-edit-price" class="col-form-label">Курстың бағасы:</label>
                <input name="course-edit-price" placeholder="Курстың бағасың енгізіңіз" type="number" class="form-control" id="course-edit-price" required>
              </div>
              <div class="col-auto">
                <label for="course-edit-file" class="col-form-label">Курстың картинкасы</label>
                <input name="image" placeholder="Курстың атың енгізіңіз" type="file" class="form-control" id="course-edit-file">
              </div>
            </div>
            <div class="mb-3">
              <label for="course-edit-name" class="col-form-label">Курстың аты:</label>
              <input name="course-edit-title" placeholder="Курстың атың енгізіңіз" type="text" class="form-control" id="course-edit-name" required>
            </div>
            <div class="mb-3">
              <label for="course-edit-text" class="col-form-label">Курс туралы ақпарат:</label>
              <textarea name="course-edit-text" placeholder="Курстың ақпаратың енгізіңіз" class="form-control" id="course-edit-text" required></textarea>
            </div>
            <input id="course-edit-uuid" type="hidden" name="course-edit-uuid" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Жабу</button>
          <button type="submit" name="submit" class="btn btn-primary">Сақтау</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--  -->

<div data-modal="info_course" class="modal fade" id="infoCourse" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Курс туралы ақпарат</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-auto">
              <h2 class="fs-6">Курстың аты</h2>
              <p id="course-info-title">Жүктелуде</p>
            </div>
            <div class="col-auto">
              <h2 class="fs-6">Курстың бағыты</h2>
              <p id="course-info-type">Жүктелуде</p>
            </div>
            <div class="col-auto">
              <h2 class="fs-6">Курстың бағасы</h2>
              <p id="course-info-price">Жүктелуде</p>
            </div>
          </div>
          <hr>
          <h2 class="fs-6">Курс туралы ақпарат</h2>
          <p id="course-info-content">Жүктелуде</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Жабу</button>
          <button type="submit" name="submit" class="btn btn-primary">Сақтау</button>
        </div>
    </div>
  </div>
</div>

<!--  -->

<div data-modal="create_potok" class="modal fade" id="createCoursePotok" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Поток құрастыру</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form data-modal-form method="POST" action="api/createPotok.php" id="create_potok">
        <div class="modal-body">
            <div class="mb-3">
              <label for="course-name" class="col-form-label">Потоктың аты:</label>
              <input name="course-potok-title" placeholder="Потоктың атың енгізіңіз" type="text" class="form-control" id="course-name" required>
              <input id="course-potok-uuid" type="hidden" name="uuid" value="">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Жабу</button>
          <button type="submit" name="submit" class="btn btn-primary">Сақтау</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--  -->

<div data-modal="create_lesson_list" class="modal fade" id="createCourseLessonList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Бөлім еңгізу</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form data-modal-form method="POST" action="api/createLessonList.php" id="create_lesson_list">
        <div class="modal-body">
            <div class="mb-3">
              <label for="course-name" class="col-form-label">Бөлімнің аты:</label>
              <input name="title" placeholder="Сабақтың атың енгізіңіз" type="text" class="form-control" id="course-name" required>
            </div>
            <div class="mb-3">
              <label for="course-edit-text" class="col-form-label">Бөлім туралы ақпарат:</label>
              <textarea name="content" placeholder="Сабақтың ақпаратың енгізіңіз" class="form-control" id="course-edit-text" required></textarea>
              <input id="course-lesson-list-uuid" type="hidden" name="uuid" value="">
              <input id="main-course-lesson-list-uuid" type="hidden" name="main-uuid" value="">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Жабу</button>
          <button type="submit" name="submit" class="btn btn-primary">Сақтау</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--  -->

<div data-modal="edit_lesson_list" class="modal fade" id="editCourseLessonList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Бөлім өзгерту</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form data-modal-form method="POST" action="api/editLessonList.php" id="edit_lesson_list">
        <div class="modal-body">
            <div class="mb-3">
              <label for="course-name" class="col-form-label">Бөлімнің аты:</label>
              <input name="title" placeholder="Сабақтың атың енгізіңіз" type="text" class="form-control" id="course-list-lesson-title" required>
            </div>
            <div class="mb-3">
              <label for="course-name" class="col-form-label">Бөлім туралы ақпарат:</label>
              <textarea name="content" placeholder="Сабақтың ақпаратың енгізіңіз" class="form-control" id="course-list-lesson-content" required></textarea>
              <input id="course-list-lesson-uuid" type="hidden" name="uuid" value="">
              <input id="main-course-list-lesson-uuid" type="hidden" name="main-uuid" value="">
              <input id="course-list-lesson-uuid-selected" type="hidden" name="lesson_uuid" value="">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Жабу</button>
          <button type="submit" name="submit" class="btn btn-primary">Сақтау</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--  -->

<div data-modal="delete_lesson_list" class="modal fade" id="deleteCourseLessonList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Бөлімді жою</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form data-modal-form method="POST" action="api/deleteLessonList.php" id="delete_lesson_list">
        <div class="modal-body">
            <div class="mb-3">
              <p>Сіз растайсыз ба жоюды?</p>
              <input id="delete-course-list-lesson-uuid" type="hidden" name="uuid" value="">
              <input id="delete-course-list-lesson-uuid-selected" type="hidden" name="lesson_uuid" value="">
              <input id="delete-course-list-lesson-uuid-main" type="hidden" name="main-uuid" value="">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Жабу</button>
          <button type="submit" name="submit" class="btn btn-danger">Жою</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--  -->

<div data-modal="edit_potok" class="modal fade" id="editCoursePotok" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Поток атың ауыстыру</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form data-modal-form method="POST" action="api/editPotok.php" id="edit_potok">
        <div class="modal-body">
            <div class="mb-3">
              <p>Таңдалды: <b id="editPotokResult"></b></p>
              <label for="course-name" class="col-form-label">Потоктың жаңа аты:</label>
              <input name="course-potok-edit-title" placeholder="Потоктың атың енгізіңіз" type="text" class="form-control" id="course-name" required>
              <input id="course-potok-edit-uuid-selected" type="hidden" name="potok-edit-uuid-selected" value="">
              <input id="course-potok-edit-uuid" type="hidden" name="potok-edit-uuid" value="">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Жабу</button>
          <button type="submit" name="submit" class="btn btn-primary">Сақтау</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--  -->

<div data-modal="create_topic" class="modal fade" id="createTopic" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Сабақты құрастыру</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form data-modal-form method="POST" action="api/createTopic.php" id="create_topic">
        <div class="modal-body">
            <div class="mb-3">
              <label for="course-name" class="col-form-label">Жаңа сабақтың аты:</label>
              <input id="create-topic-title" name="topic-title" placeholder="Бөлімнің атың енгізіңіз" type="text" class="form-control" required>
              <input id="create-topic-uuid-lesson-selected" name="uuid-lesson-selected" type="hidden" value="">
              <input id="create-topic-uuid-selected" name="uuid-selected" type="hidden" value="">
              <input id="create-topic-uuid" type="hidden" name="uuid" value="">
            </div>
            <div class="mb-3">
              <label for="course-name" class="col-form-label">Сабақ туралы ақпарат:</label>
              <textarea id="create-topic-content" name="content" placeholder="Сабақтың ақпаратың енгізіңіз" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
              <label for="course-name" class="col-form-label">Ссылка на видео:</label>
              <input id="create-topic-url" name="topic-media" placeholder="Ссылка енгізіңіз" type="url" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Жабу</button>
          <button type="submit" name="submit" class="btn btn-primary">Сақтау</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--  -->

<div data-modal="edit_topic" class="modal fade" id="editTopic" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Сабақты өзгерту</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form data-modal-form method="POST" action="api/editTopic.php" id="edit_topic">
        <div class="modal-body">
            <div class="mb-3">
              <label for="edit-topic-title" class="col-form-label">Сабақтың аты:</label>
              <input id="edit-topic-title" name="topic-title" placeholder="Бөлімнің атың енгізіңіз" type="text" class="form-control" required>
              <input id="edit-topic-uuid-lesson-selected" name="uuid-lesson-selected" type="hidden" value="">
              <input id="edit-topic-uuid-selected" name="uuid-selected" type="hidden" value="">
              <input id="edit-topic-uuid" type="hidden" name="uuid" value="">
              <input id="edit-topic-self-uuid" type="hidden" name="self-uuid" value="">
            </div>
            <div class="mb-3">
              <label for="edit-topic-content" class="col-form-label">Сабақ туралы ақпарат:</label>
              <textarea id="edit-topic-content" name="content" placeholder="Сабақтың ақпаратың енгізіңіз" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
              <label for="edit-topic-media" class="col-form-label">Ссылка на видео:</label>
              <input id="edit-topic-media" name="topic-media" placeholder="Ссылка енгізіңіз" type="url" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Жабу</button>
          <button type="submit" name="submit" class="btn btn-primary">Сақтау</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--  -->

<div data-modal="delete_topic" class="modal fade" id="deleteTopic" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Сабақты жою</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form data-modal-form method="POST" action="api/deleteTopic.php" id="delete_topic">
        <div class="modal-body">
            <div class="mb-3">
              <p>Сіз растайсыз ба сабақты жоюға?</p>
              <input id="delete-topic-uuid-lesson-selected" name="uuid-lesson-selected" type="hidden" value="">
              <input id="delete-topic-uuid-selected" name="uuid-selected" type="hidden" value="">
              <input id="delete-topic-uuid" type="hidden" name="uuid" value="">
              <input id="delete-topic-self-uuid" type="hidden" name="self-uuid" value="">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Жабу</button>
          <button type="submit" name="submit" class="btn btn-danger">Жою</button>
        </div>
      </form>
    </div>
  </div>
</div>