
<?php

    class DatabaseOkkiCMS
    {
        private static $rootOkki;
        private static $mainPathOkki;
        private static $triggerConnection;
        private static $hostDatabase;
        private static $userDatabase;
        private static $passwordDatabase;

        public function __construct()
        {
            try {
                // self::$hostDatabase = "localhost:3306";
                // self::$userDatabase = "okkiwebs_corpus";
                // self::$passwordDatabase = "?A36u18wf";

                self::$hostDatabase = "127.0.0.1";
                self::$userDatabase = "root";
                self::$passwordDatabase = "";

                self::$mainPathOkki = self::getPathOkki() ?: "/";
                self::$rootOkki = realpath($_SERVER["DOCUMENT_ROOT"]) . self::$mainPathOkki;
            } catch (Exception $e) {
                // Обработка и логирование ошибок
                echo "Произошла ошибка: " . $e->getMessage();
                // Можно также занести ошибку в журнал ошибок или отправить уведомление разработчику
            }
        }

        private static function getPathOkki(): string
        {
            try {
                $requestUri = $_SERVER['REQUEST_URI'];
                $wordsToCheck = ['admin', 'news', 'stats', 'cms'];
                $result = '';
                foreach ($wordsToCheck as $word) {

                    $position = strpos($requestUri, $word);

                    if ($position !== false) {
                        $substringBefore = substr($requestUri, 0, $position);
                        $result = $substringBefore;
                        break;
                    }
                }
                return $result;
            } catch (Exception $e) {
                // Обработка и логирование ошибок
                throw new Exception("Ошибка при получении пути: " . $e->getMessage());
            }
        }

        public function create(string $dbName) {
            $host = self::$hostDatabase;
            $userName = self::$userDatabase;
            $password = self::$passwordDatabase;

            try {
                // Connect to MySQL server
                $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $userName, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Create the database
                $pdo->exec("CREATE DATABASE IF NOT EXISTS {$dbName}");
                $pdo->exec("ALTER DATABASE {$dbName} CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
                
            } catch (PDOException $e) {
                die("Error creating database: " . $e->getMessage());
            }
        }

        public function delete(string $dbName) {
            $host = self::$hostDatabase;
            $userName = self::$userDatabase;
            $password = self::$passwordDatabase;

            try {
                // Connect to MySQL server
                $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $userName, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Create the database
                $pdo->exec("DROP DATABASE IF EXISTS $dbName");
                
            } catch (PDOException $e) {
                die("Error creating database: " . $e->getMessage());
            }
        }

        public function connect(string $dbName): object
        {
            try {
                $host = self::$hostDatabase;
                $username = self::$userDatabase;
                $password = self::$passwordDatabase;
                $dbPath = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
                static $connections = [];
                if (empty($connections[$dbPath])) {
                    $params = [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::ATTR_PERSISTENT => true,
                        PDO::ATTR_TIMEOUT => 30
                    ];
                    $connections[$dbPath] = new PDO($dbPath, $username, $password);
                    
                }
                $result = $connections[$dbPath];
                unset($connections, $dbName, $dbPath);
                return $result;
            } catch (PDOException $e) {
                // Обработка и логирование ошибок подключения к базе данных
                throw new Exception("Ошибка подключения к базе данных: " . $e->getMessage());
            }
        }

        public function fetch(object $database, string $query, array $prepare = [])
        {
            try {
                if (empty($prepare)) {
                    $result = $database->query($query)->fetch(\PDO::FETCH_ASSOC);
                } else {
                    $fetch = $database->prepare($query);
                    $fetch->execute($prepare);
                    $result = $fetch->fetch(\PDO::FETCH_ASSOC);
                }
                unset($fetch, $database, $query, $prepare);
                return $result;
            } catch (PDOException $e) {
                // Обработка и логирование ошибок запросов к базе данных
                throw new Exception("Ошибка выполнения запроса: " . $e->getMessage());
            }
        }

        public function fetchAll(object $database, string $query, array $prepare = [])
        {
            try {
                if (empty($prepare)) {
                    $result = $database->query($query)->fetchAll(\PDO::FETCH_ASSOC);
                } else {
                    $fetchAll = $database->prepare($query);
                    $fetchAll->execute($prepare);
                    $result = $fetchAll->fetchAll(\PDO::FETCH_ASSOC);
                }
                unset($fetchAll, $database, $query, $prepare);
                return $result;
            } catch (PDOException $e) {
                // Обработка и логирование ошибок запросов к базе данных
                throw new Exception("Ошибка выполнения запроса: " . $e->getMessage());
            }
        }

        public function start(object $database, string $query, array $prepare = [])
        {
            try {
                if (empty($prepare)) {
                    return $database->query($query);
                } else {
                    $action = $database->prepare($query);
                    $action->execute($prepare);
                    return $action;
                }
            } catch (PDOException $e) {
                // Обработка и логирование ошибок запросов к базе данных
                throw new Exception("Ошибка выполнения запроса: " . $e->getMessage());
            }
        }
        
    }

?>
