# Laravel Service Repository Generator

An Artisan command to generate **Service & Repository pattern** in Laravel projects, complete with interfaces and customizable stubs.

## ✨ Features

- Generate **Service & Service Interface**
- Generate **Repository & Repository Interface**
- Configurable namespaces
- Customizable stubs via `vendor:publish`
- Laravel auto-discovery support
- Compatible with Laravel 10, 11, and 12

---

## 📦 Installation

Install the package via Composer:

```bash
composer require fatihrizqon/laravel-service-repo-generator
```

The service provider will be automatically registered via Laravel auto-discovery.

---

## ⚙️ Publish Configuration

(Optional but recommended)

```bash
php artisan vendor:publish --tag=service-repo-generator-config
```

The configuration file will be published to:

```bash
config/service-repo-generator.php
```

---

## 🧱 Publish Stubs (Customize Templates)

To customize the service and repository templates:

```bash
php artisan vendor:publish --tag=service-repo-generator-stubs
```

The stubs will be published to:

```bash
stubs/service-repo-generator/
```

---

## 🚀 Usage

### Generate a Service

```bash
php artisan make:service User
```

This command will generate:

```text
app/Services/UserService.php
app/Services/Interfaces/IUserService.php
```

---

### Generate a Repository

```bash
php artisan make:repository User
```

This command will generate:

```text
app/Repositories/UserRepository.php
app/Repositories/Interfaces/IUserRepository.php
```

---

## 🛠 Configuration Example

```php
return [
    'service_namespace' => 'Services',
    'service_interface_namespace' => 'Services\\Interfaces',

    'repository_namespace' => 'Repositories',
    'repository_interface_namespace' => 'Repositories\\Interfaces',
];
```

---

## 📄 License

MIT License © 2025  
Created by **Fatih Rizqon**
