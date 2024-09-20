# Use a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instalar dependências
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar o diretório de trabalho
WORKDIR /var/www/html

# Copiar todos os arquivos do projeto
COPY . .

# Ajustar permissões para a pasta de armazenamento e cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite

# Expor a porta 80 para acessar o Apache
EXPOSE 80

# Executar o Apache como serviço
CMD ["apache2-foreground"]
