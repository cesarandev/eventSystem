<?php
declare(strict_types=1);

session_start();

$basePath = dirname(__DIR__);
$configPath = $basePath . '/config/local.php';
$lockPath = $basePath . '/storage/installed.lock';
$schemaPath = $basePath . '/database/schema.sql';
$errors = [];
$success = null;

function setup_e(string|int|float|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function setup_requirement(bool $status, string $label): array
{
    return ['status' => $status, 'label' => $label];
}

function setup_sql_statements(string $sql): array
{
    $sql = preg_replace('/^\s*--.*$/m', '', $sql) ?? $sql;
    return array_values(array_filter(array_map('trim', explode(';', $sql))));
}

$requirements = [
    setup_requirement(PHP_VERSION_ID >= 80100, 'PHP 8.1 o superior'),
    setup_requirement(extension_loaded('pdo'), 'Extension PDO'),
    setup_requirement(extension_loaded('pdo_mysql'), 'Extension PDO MySQL'),
    setup_requirement(is_writable($basePath . '/config'), 'Carpeta config escribible'),
    setup_requirement(is_writable($basePath . '/storage'), 'Carpeta storage escribible'),
    setup_requirement(is_file($schemaPath), 'Archivo database/schema.sql disponible'),
];

$alreadyInstalled = is_file($lockPath);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$alreadyInstalled) {
    $host = trim($_POST['host'] ?? '127.0.0.1');
    $port = trim($_POST['port'] ?? '3306');
    $database = trim($_POST['database'] ?? 'eventia_pro');
    $username = trim($_POST['username'] ?? 'root');
    $password = (string) ($_POST['password'] ?? '');
    $seed = isset($_POST['seed']);

    foreach ($requirements as $requirement) {
        if (!$requirement['status']) {
            $errors[] = 'Requisito pendiente: ' . $requirement['label'];
        }
    }

    if ($database === '' || !preg_match('/^[a-zA-Z0-9_]+$/', $database)) {
        $errors[] = 'El nombre de la base de datos solo puede contener letras, numeros y guion bajo.';
    }

    if ($host === '' || $port === '' || $username === '') {
        $errors[] = 'Host, puerto y usuario MySQL son obligatorios.';
    }

    if ($errors === []) {
        try {
            $serverDsn = "mysql:host={$host};port={$port};charset=utf8mb4";
            $pdo = new PDO($serverDsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);

            $quotedDatabase = '`' . str_replace('`', '``', $database) . '`';
            $pdo->exec("CREATE DATABASE IF NOT EXISTS {$quotedDatabase} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE {$quotedDatabase}");

            $schema = file_get_contents($schemaPath);
            if ($schema === false) {
                throw new RuntimeException('No se pudo leer database/schema.sql.');
            }

            $schema = preg_replace('/CREATE DATABASE IF NOT EXISTS\s+eventia_pro[^;]*;/i', '', $schema) ?? $schema;
            $schema = preg_replace('/USE\s+eventia_pro\s*;/i', '', $schema) ?? $schema;

            if (!$seed) {
                $schema = preg_replace('/INSERT INTO[\s\S]*$/i', '', $schema) ?? $schema;
            }

            foreach (setup_sql_statements($schema) as $statement) {
                $pdo->exec($statement);
            }

            $localConfig = "<?php\n"
                . "declare(strict_types=1);\n\n"
                . "return [\n"
                . "    'host' => " . var_export($host, true) . ",\n"
                . "    'port' => " . var_export($port, true) . ",\n"
                . "    'database' => " . var_export($database, true) . ",\n"
                . "    'username' => " . var_export($username, true) . ",\n"
                . "    'password' => " . var_export($password, true) . ",\n"
                . "    'charset' => 'utf8mb4',\n"
                . "];\n";

            if (file_put_contents($configPath, $localConfig) === false) {
                throw new RuntimeException('No se pudo escribir config/local.php.');
            }

            $lockContent = 'Instalado el ' . date('Y-m-d H:i:s') . ' con base de datos ' . $database . PHP_EOL;
            if (file_put_contents($lockPath, $lockContent) === false) {
                throw new RuntimeException('No se pudo escribir storage/installed.lock.');
            }

            $success = 'Instalacion completada. Ya puedes entrar al dashboard.';
            $alreadyInstalled = true;
        } catch (Throwable $throwable) {
            $errors[] = $throwable->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instalador | Eventia Pro</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body class="setup-body">
    <main class="setup-shell">
        <section class="setup-hero">
            <p class="eyebrow">Instalador</p>
            <h1>Configura Eventia Pro con MySQL</h1>
            <p>Este asistente valida requisitos, crea la base de datos, importa las tablas y genera <code>config/local.php</code>.</p>
        </section>

        <?php if ($alreadyInstalled): ?>
            <article class="panel">
                <h2>Aplicacion instalada</h2>
                <p><?= setup_e($success ?? 'Ya existe storage/installed.lock. Para reinstalar, elimina ese archivo y config/local.php.') ?></p>
                <a class="primary-btn" href="/">Ir al dashboard</a>
            </article>
        <?php else: ?>
            <div class="setup-grid">
                <article class="panel">
                    <h2>Requisitos</h2>
                    <div class="requirement-list">
                        <?php foreach ($requirements as $requirement): ?>
                            <div class="<?= $requirement['status'] ? 'ok' : 'fail' ?>">
                                <span><?= $requirement['status'] ? 'OK' : 'Falta' ?></span>
                                <strong><?= setup_e($requirement['label']) ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>

                <form class="panel form-grid" method="post">
                    <h2>Conexion MySQL</h2>

                    <?php if ($errors !== []): ?>
                        <div class="setup-errors span-2">
                            <?php foreach ($errors as $error): ?><p><?= setup_e($error) ?></p><?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <label>Host <input name="host" value="<?= setup_e($_POST['host'] ?? '127.0.0.1') ?>" required></label>
                    <label>Puerto <input name="port" value="<?= setup_e($_POST['port'] ?? '3306') ?>" required></label>
                    <label>Base de datos <input name="database" value="<?= setup_e($_POST['database'] ?? 'eventia_pro') ?>" required></label>
                    <label>Usuario <input name="username" value="<?= setup_e($_POST['username'] ?? 'root') ?>" required></label>
                    <label class="span-2">Contrasena <input name="password" type="password" value="<?= setup_e($_POST['password'] ?? '') ?>"></label>
                    <label class="check span-2"><input name="seed" type="checkbox" checked> Importar datos de ejemplo</label>
                    <p class="setup-note span-2">El instalador recrea las tablas del sistema. Usalo solo en una instalacion nueva.</p>
                    <button class="primary-btn">Instalar plataforma</button>
                </form>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
