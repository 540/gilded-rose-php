.PHONY: help up down build shell test example install clean

# Colors for output
BLUE := \033[0;34m
GREEN := \033[0;32m
YELLOW := \033[0;33m
NC := \033[0m # No Color

help: ## Muestra esta ayuda
	@echo "$(BLUE)Gilded Rose - Comandos disponibles:$(NC)"
	@echo ""
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  $(GREEN)%-15s$(NC) %s\n", $$1, $$2}'
	@echo ""

up: ## Levanta el contenedor de Docker
	@echo "$(BLUE)Levantando contenedor...$(NC)"
	docker-compose up -d
	@echo "$(GREEN)✓ Contenedor levantado$(NC)"

down: ## Detiene y elimina el contenedor
	@echo "$(BLUE)Deteniendo contenedor...$(NC)"
	docker-compose down
	@echo "$(GREEN)✓ Contenedor detenido$(NC)"

build: ## Construye la imagen de Docker
	@echo "$(BLUE)Construyendo imagen...$(NC)"
	docker-compose build
	@echo "$(GREEN)✓ Imagen construida$(NC)"

shell: ## Abre una terminal dentro del contenedor
	@echo "$(BLUE)Abriendo shell en el contenedor...$(NC)"
	docker-compose exec php bash

test: ## Ejecuta los tests con PHPUnit
	@echo "$(BLUE)Ejecutando tests...$(NC)"
	docker-compose exec php vendor/bin/phpunit
	@echo "$(GREEN)✓ Tests completados$(NC)"

example: ## Ejecuta el ejemplo de funcionamiento
	@echo "$(BLUE)Ejecutando ejemplo...$(NC)"
	@echo ""
	docker-compose exec php php example.php

install: ## Instala las dependencias de Composer
	@echo "$(BLUE)Instalando dependencias...$(NC)"
	docker-compose exec php composer install
	@echo "$(GREEN)✓ Dependencias instaladas$(NC)"

clean: down ## Limpia contenedores, volúmenes e imágenes
	@echo "$(BLUE)Limpiando recursos de Docker...$(NC)"
	docker-compose down -v --rmi local
	@echo "$(GREEN)✓ Limpieza completada$(NC)"

