# PRESTIGE V1

**PRESTIGE V1** is the foundation for a GTA San Andreas multiplayer roleplay project.

This repository currently contains the initial web/API companion scaffold and MySQL connectivity checks. It does **not** yet contain a completed SA-MP/open.mp game mode.

## Current architecture

- **Game server:** SA-MP/open.mp runtime hosted separately on a Linux VPS that supports the required game traffic (including UDP).
- **Web/API companion:** PHP application that can run on the current Clever Cloud Linux application.
- **Database:** Clever Cloud MySQL add-on, accessed through the `MYSQL_ADDON_URI` environment variable.

> Clever Cloud's web application is not the SA-MP/open.mp game server. Use it for the website/API and database-backed services, not for player game connections.

## Clever Cloud deployment

The repository includes a `Makefile` with a `run` task to address the deployment error requiring a run command.

The run task starts FrankenPHP and listens on the port supplied by Clever Cloud (default: `8080`).

Required linked add-on variable:

- `MYSQL_ADDON_URI` — supplied automatically by the linked Clever Cloud MySQL add-on.

The application also supports the individual variables `MYSQL_ADDON_HOST`, `MYSQL_ADDON_PORT`, `MYSQL_ADDON_USER`, `MYSQL_ADDON_PASSWORD`, and `MYSQL_ADDON_DB` as a fallback.

Do not commit database credentials or put them in source files.

### Endpoints

- `/` — service information.
- `/health` — application health.
- `/health/db` — checks the MySQL connection without returning credentials or database details.

### Database schema

The starter schema is in `database/schema.sql`. Apply it deliberately when the player-account feature is implemented; the health endpoint does not modify the database.

## Local run

Requirements: PHP with PDO MySQL and FrankenPHP.

```sh
make run
```

The service listens on `http://127.0.0.1:8080` by default.

## Game server starter

The initial open.mp server configuration and Pawn gamemode source are in `server/openmp/`. This first build supports a basic connection/spawn flow and `/help`; it is not yet a complete roleplay mode. See `server/openmp/README.md` for setup and hosting requirements.

The game server requires inbound UDP on port `7777`. Clever Cloud TCP redirections are TCP-only and cannot serve as the normal SA-MP/open.mp game endpoint. Keep the current Clever Cloud app for the web/API and MySQL service, and run open.mp on a UDP-capable game host.

## Project status

**PRESTIGE V1 — Foundation stage.** The web/API and MySQL health check are working. An initial open.mp gamemode source and configuration are now present, but the game runtime has not been installed or started on a public UDP host. Player accounts, persistent gameplay systems, and the full roleplay mode remain to be implemented and tested.
