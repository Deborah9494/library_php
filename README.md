# Books

Simple PHP + MySQL application to browse books and authors.

## Features

- Books listing
- Authors listing
- Detail pages
- Pagination
- Custom CSS styling
- Shared header/logo
- MVC-inspired structure

## Structure

```text
books/
│
├── models/
│   ├── mod001_kernel.php
│   ├── mod002_accesoadatos_execute_query.php
│   ├── mod004_generate_error.php
│   │
│   ├── authors/
│   │   ├── mod002_accesoadatos.php
│   │   ├── mod003_logica.php
│   │   └── mod004_presentacion.php
│   │
│   ├── books/
│       ├── mod002_accesoadatos.php
│       ├── mod003_logica.php
│       └── mod004_presentacion.php
│
├── views/
│   ├── header.php
│   ├── view_index.php
│   ├── view_authors.php
│   ├── view_books.php
│
├── authors.php
├── books.php
└── index.php
