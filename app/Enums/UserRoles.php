<?php

namespace App\Enums;

enum UserRoles: string {

    case NONE = "none";
    case TRAINER = "trainer";
    case MANAGER = "manager";
    case ADMIN = "admin";
}