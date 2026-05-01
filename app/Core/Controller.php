<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        $viewPath = BASE_PATH . '/app/Views/' . $view . '.php';

        if (!is_file($viewPath)) {
            http_response_code(500);
            echo 'Vista no encontrada: ' . e($view);
            return;
        }

        require BASE_PATH . '/app/Views/layouts/main.php';
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    protected function flash(string $message): void
    {
        $_SESSION['flash'] = $message;
    }
}
