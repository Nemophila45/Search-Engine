<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case KOAS = 'koas';

    /**
     * Human readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::DOCTOR => 'Dokter',
            self::KOAS => 'Koas',
        };
    }
}

