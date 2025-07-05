# laravel-auth-sanctum-api

A simple and clean authentication API using Laravel Sanctum.

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

## 🔐 About This Project

This project is a minimal authentication API starter built with Laravel and Sanctum. Ideal for learning or serving as a base backend for modern frontend apps (React, Vue, etc).

### Features
- User registration login, and logout auth.
- Token-based authentication using Laravel Sanctum
- Protected routes with `auth:sanctum` for user profile
- Clean validation, middleware, and controller structure

## 🚀 Getting Started

```bash
git clone https://github.com/yosua-sn/laravel-auth-sanctum-api.git
cd laravel-auth-sanctum-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate

