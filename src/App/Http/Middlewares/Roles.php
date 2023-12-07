<?php

namespace Http\Middlewares;

enum Roles: string {
    case Admin = 'admin';
    case User = 'user';
    case Guest = 'guest';
}