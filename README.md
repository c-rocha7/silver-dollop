# API Laravel + Vue JS + Tailwind

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## 1. Descrição

O projeto API Laravel + Vue JS + Tailwind é um teste tecnico no qual me foi passado onde devere ocorrer 2 endpoints com CRUD completo e fazer um front para eles com Vue JS.

## 2. Tecnologias

| Item                         | Descrição |
| ---------------------------- | --------- |
| **Servidor**                 | Laravel   |
| **Linguagem de programação** | PHP       |
| **Biblioteca**               | Vue Js    |
| **Build**                    | Vite      |
| **Estilização**              | Tailwind  |

## 3. Pré-requisitos

Antes de iniciar, certifique-se de ter as seguintes ferramentas instaladas:

-   [Docker](https://www.docker.com/)

## 4. Instalação

### 4.1. Clonando o repositório

```bash
git clone git@github.com:c-rocha7/silver-dollop.git
cd silver-dollop
```

### 4.2. Criando ambiente

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

### 4.3. Iniciando ambiente

```bash
./vendor/bin/sail up -d
```

### 4.4. Permitindo a criação de funções armazenadas (Stored Functions)

```bash
./vendor/bin/sail exec mysql bash -c "mysql -u root -p -e \"SET GLOBAL log_bin_trust_function_creators = 1;\""
```

### 4.5. Aplicando migrates

```bash
./vendor/bin/sail artisan migrate
```

### 4.6. Iniciando o vite

```bash
./vendor/bin/sail npm run dev
```
