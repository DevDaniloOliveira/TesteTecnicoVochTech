<?php

if (!function_exists('formatCnpj')) {
    function formatCnpj($cnpj): string
    {
        if (empty($cnpj)) {
            return 'N/A';
        }
        $clean = preg_replace('/[^0-9]/', '', $cnpj);

        if (strlen($clean) === 14) {
            return preg_replace(
                '/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/',
                '$1.$2.$3/$4-$5',
                $clean
            );
        }

        return $cnpj;
    }
}

if (!function_exists('formatCpf')) {
    function formatCpf($cpf): string
    {
        if (empty($cpf)) {
            return 'N/A';
        }

        $clean = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($clean) === 11) {
            return preg_replace(
                '/(\d{3})(\d{3})(\d{3})(\d{2})/',
                '$1.$2.$3-$4',
                $clean
            );
        }

        return $cpf;
    }
}

if (!function_exists('formatPhone')) {
    function formatPhone($phone): string
    {
        if (empty($phone)) {
            return 'N/A';
        }

        $clean = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($clean) === 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $clean);
        }

        if (strlen($clean) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $clean);
        }

        return $phone;
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd/m/Y'): string
    {
        if (!$date instanceof \DateTime) {
            $date = new \DateTime($date);
        }

        return $date->format($format);
    }
}
