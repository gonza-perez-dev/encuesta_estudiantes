<?php
function e($valor): string {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

function opciones(array $items, string $seleccionado = ''): string {
    $html = '<option value="">Seleccione una opción</option>';
    foreach ($items as $item) {
        $sel = ($seleccionado === $item) ? ' selected' : '';
        $html .= '<option value="' . e($item) . '"' . $sel . '>' . e($item) . '</option>';
    }
    return $html;
}
