PORT ?= 8080
FRANKENPHP ?= frankenphp

.PHONY: run
run:
	$(FRANKENPHP) php-server --listen 0.0.0.0:$(PORT) --root public
