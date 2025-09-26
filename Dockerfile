FROM php:8.3-cli

# Instalar extensões necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev unzip git curl && \
    docker-php-ext-install pdo pdo_pgsql && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar apenas arquivos de dependência primeiro
COPY app/composer.json app/composer.lock ./

# Instalar dependências do PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copiar o resto do projeto
COPY app/ .

# Expor porta do servidor
EXPOSE 8000

# Rodar servidor embutido do Lumen
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
